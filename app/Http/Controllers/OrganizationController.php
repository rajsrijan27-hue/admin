<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Organization;


class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return view('organization.index', compact('organizations'));
    }

    public function create()
    {
        return view('organization.create');
    }

    public function store(Request $request)
    {
        Organization::create($request->all());
        return redirect()->route('organization.index');
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        return view('organization.edit', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->update($request->all());

        return redirect()->route('organization.index');
    }

    public function destroy($id)
    {
        Organization::destroy($id);
        return redirect()->route('organization.index');
    }
}
