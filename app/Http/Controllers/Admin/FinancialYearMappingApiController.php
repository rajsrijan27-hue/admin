<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialYear;
use App\Models\Transaction;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FinancialYearMappingApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $hospitalId = $request->hospital_id;

        $hospital = $hospitalId
            ? Hospital::with('financialYears')->find($hospitalId)
            : null;

        return response()->json([
            'status' => true,
            'data' => $hospital
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'financial_year_ids' => 'array',
            'financial_year_ids.*' => 'exists:financial_years,id',
            'current_year_id' => 'nullable|exists:financial_years,id',
        ]);

        $hospital = Hospital::findOrFail($data['hospital_id']);
        $selectedIds = $data['financial_year_ids'] ?? [];

        // 1) Block mapping to inactive or deleted FY (TC_MAP_002, TC_MAP_009)
        $invalidFyCount = FinancialYear::whereIn('id', $selectedIds)
            ->where(function ($q) {
                $q->where('is_active', false)
                    ->orWhereNotNull('deleted_at');
            })
            ->count();

        if ($invalidFyCount > 0) {
            return back()
                ->withErrors(['financial_year_ids' => 'Cannot map inactive or deleted financial years.'])
                ->withInput();
        }

        // 2) Check for removal when transactions exist (TC_MAP_004, TC_MAP_010)
        $existingMappings = $hospital->financialYears()->get();
        $toRemove = $existingMappings->whereNotIn('id', $selectedIds)->pluck('id');

        $blockedRemoval = $toRemove->filter(function ($fyId) use ($hospital) {
            return Transaction::where('hospital_id', $hospital->id)
                ->where('financial_year_id', $fyId)
                ->exists();
        });

        if ($blockedRemoval->isNotEmpty()) {
            return response()->json([
                'message' => 'Cannot remove mapping for financial years with existing transactions.',
                'blocked_ids' => $blockedRemoval->values(),
            ], 400);
        }

        // 3) Build sync data (create/update mappings, unique pair enforced by DB)
        $syncData = [];
        foreach ($selectedIds as $fyId) {
            $syncData[$fyId] = [
                'is_current' => isset($data['current_year_id']) && $data['current_year_id'] == $fyId,
            ];
        }

        $hospital->financialYears()->sync($syncData);

        return response()->json(['message' => 'Financial year mapping updated successfully.']);
    }
}
