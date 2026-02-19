<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FinancialYearApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FinancialYear::query();

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('start_year')) {
            $query->whereYear('start_date', (int) $request->start_year);
        }

        return response()->json([
            'status' => true,
            'data' => $query->orderBy('start_date', 'desc')->paginate(15)
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:financial_years,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $financialYear = FinancialYear::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Financial year created successfully.',
            'data' => $financialYear
        ], 201);
    }

    public function update(Request $request, FinancialYear $financial_year): JsonResponse
    {
        $financial_year->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Financial year updated successfully.',
            'data' => $financial_year
        ]);
    }

    public function destroy(FinancialYear $financial_year): JsonResponse
    {
        $financial_year->delete();

        return response()->json([
            'status' => true,
            'message' => 'Financial year deleted successfully.'
        ]);
    }
}
