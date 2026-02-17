<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FinancialYearMappingController extends Controller
{
    public function index(Request $request)
    {
        $hospitals = Hospital::orderBy('name')->get();
        $financialYears = FinancialYear::orderBy('start_date', 'desc')->get();

        $selectedHospitalId = $request->get('hospital_id', optional($hospitals->first())->id);

        $selectedHospital = $selectedHospitalId
            ? Hospital::with(['financialYears'])->find($selectedHospitalId)
            : null;

        $mappings = $selectedHospital
            ? $selectedHospital->financialYears->keyBy('id')
            : collect();

        return view('admin.financial-years.mapping', compact(
            'hospitals',
            'financialYears',
            'selectedHospital',
            'selectedHospitalId',
            'mappings'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'financial_year_ids' => 'array',
            'financial_year_ids.*' => 'exists:financial_years,id',
            'current_year_id' => 'nullable|exists:financial_years,id',
            'locked' => 'array',
            'locked.*' => 'boolean',
        ]);

        $hospital = Hospital::findOrFail($data['hospital_id']);

        $syncData = [];
        foreach ($data['financial_year_ids'] ?? [] as $fyId) {
            $syncData[$fyId] = [
                'is_current' => isset($data['current_year_id']) && $data['current_year_id'] == $fyId,
                'locked' => !empty($data['locked'][$fyId] ?? false),
            ];
        }

        $hospital->financialYears()->sync($syncData);

        return redirect()
            ->route('admin.financial-years.mapping', ['hospital_id' => $hospital->id])
            ->with('success', 'Financial year mapping updated.');
    }
}
