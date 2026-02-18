@extends('layouts.admin')

@section('page-title', 'Financial Year Mapping | ' .config('app.name'))
@section('title', 'Financial Year Mapping')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="page-header-title">
            <h5 class="m-b-10">
                <i class="feather-link me-2"></i>Financial Year – Hospital Mapping
            </h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Financial Year Mapping</li>
            </ul>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

<div class="card stretch stretch-full">
    <div class="card-body">
        <form action="{{ route('admin.financial-years.mapping') }}" method="GET" class="mb-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Hospital</label>
                    <select name="hospital_id" class="form-select" onchange="this.form.submit()">
                        @foreach ($hospitals as $hospital)
                            <option value="{{ $hospital->id }}"
                                {{ $selectedHospitalId == $hospital->id ? 'selected' : '' }}>
                                {{ $hospital->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        @if ($selectedHospital)
            <form action="{{ route('admin.financial-years.mapping.store') }}" method="POST">
                @csrf
                <input type="hidden" name="hospital_id" value="{{ $selectedHospital->id }}">

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Use</th>
                                <th>Financial Year</th>
                                <th>Dates</th>
                                <th>Current</th>
                                <th>Locked</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financialYears as $fy)
                                @php
                                    $pivot = $mappings->get($fy->id)?->pivot;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="financial_year_ids[]"
                                               value="{{ $fy->id }}"
                                               {{ $pivot ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $fy->code }}</td>
                                    <td>
                                        {{ $fy->start_date->format('d-m-Y') }}
                                        –
                                        {{ $fy->end_date->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        <input type="radio"
                                               name="current_year_id"
                                               value="{{ $fy->id }}"
                                               {{ $pivot && $pivot->is_current ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                               name="locked[{{ $fy->id }}]"
                                               value="1"
                                               {{ $pivot && $pivot->locked ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="feather-save me-2"></i>Save Mapping
                    </button>
                </div>
            </form>
        @else
            <p class="mb-0">No hospitals found. Please create a hospital first.</p>
        @endif
    </div>
</div>
@endsection
