<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialYear;
use Illuminate\Http\Request;

class FinancialYearController extends Controller
{
    public function index()
    {
        $financialYears = FinancialYear::orderBy('start_date', 'desc')
            ->paginate(10);

        return view('admin.financial-years.index', compact('financialYears'));
    }

    public function create()
    {
        return view('admin.financial-years.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:financial_years,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        FinancialYear::create($data);

        return redirect()
            ->route('admin.financial-years.index')
            ->with('success', 'Financial year created successfully.');
    }
}
