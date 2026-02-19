<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'financial_year_ids' => 'array'
        ]);

        $hospital = Hospital::findOrFail($data['hospital_id']);

        $hospital->financialYears()->sync($data['financial_year_ids'] ?? []);

        return response()->json([
            'status' => true,
            'message' => 'Mapping updated successfully.'
        ]);
    }
}
