@extends('layouts.admin')

@section('page-title', 'Financial Years')
@section('title', 'Financial Years')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex align-items-center w-100">
            {{-- LEFT: title + breadcrumb --}}
            <div class="page-header-title">
                <h5 class="m-b-10 mb-1">
                    <i class="feather-calendar me-2"></i>Financial Years
                </h5>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Financial Years</li>
                </ul>
            </div>

            {{-- RIGHT: Add FY --}}
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('admin.financial-years.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-1"></i> Add Financial Year
                </a>
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
            @if ($financialYears->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financialYears as $index => $fy)
                                <tr>
                                    <td>{{ $financialYears->firstItem() + $index }}</td>
                                    <td>{{ $fy->code }}</td>
                                    <td>{{ $fy->start_date->format('d-m-Y') }}</td>
                                    <td>{{ $fy->end_date->format('d-m-Y') }}</td>
                                    <td>
                                        @if($fy->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle" title="Edit">
                                                <i class="feather-edit-2"></i>
                                            </a>
                                            {{-- later: delete / toggle --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $financialYears->links() }}
                </div>
            @else
                <p class="mb-0">No financial years found.</p>
            @endif
        </div>
    </div>
@endsection