<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the modules.
     */
    public function index()
    {
        // Get latest modules
        $modules = Module::latest()->get();

        // View: resources/views/admin/modules/index.blade.php
        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new module.
     */
    public function create()
    {
        // All modules for parent-module dropdown (if needed)
        $modules = Module::all();

        // View: resources/views/admin/modules/create.blade.php
        return view('admin.modules.create', compact('modules'));
    }

    /**
     * Store a newly created module in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'module_label' => 'required|string|max:255',
            'module_display_name' => 'required|string|max:255',
            'priority' => 'required|numeric',
            'icon' => 'required|string|max:255',
            'file_url' => 'required|string|max:255',
            'page_name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'access_for' => 'required|string|max:50',
            // add parent_id or other fields if in your table
        ]);

        Module::create($request->all());

        // Route name from Route::resource('modules', ...) inside admin group:
        // -> admin.modules.index
        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module created successfully.');
    }

    /**
     * Show the form for editing the specified module.
     */
    public function edit(Module $module)
    {
        $modules = Module::all(); // for parent-module dropdown

        // View: resources/views/admin/modules/edit.blade.php
        return view('admin.modules.edit', compact('module', 'modules'));
    }

    /**
     * Update the specified module in storage.
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'module_label' => 'required|string|max:255',
            'module_display_name' => 'required|string|max:255',
            'priority' => 'required|numeric',
            'icon' => 'required|string|max:255',
            'file_url' => 'required|string|max:255',
            'page_name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'access_for' => 'required|string|max:50',
        ]);

        $module->update($request->all());

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified module from storage.
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module deleted successfully.');
    }
}
