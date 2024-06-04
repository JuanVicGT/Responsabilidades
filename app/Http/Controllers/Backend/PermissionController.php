<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Utils\Enums\AlertType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index', Permission::class);

        return view('backend.permission.IndexPermission');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Permission::class);

        return view('backend.permission.CreatePermission');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:255'],]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = 'web';

        if ($permission->save())
            $this->addAlert(AlertType::SUCCESS, __('Created successfully'));
        else
            $this->addAlert(AlertType::ERROR, __('Could not be created'));

        return redirect()->route('permission.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        Gate::authorize('show', $permission);

        return view('backend.permission.ShowPermission', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $permission = Permission::find($id);
        Gate::authorize('edit', $permission);

        return view('backend.permission.EditPermission', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $permission = Permission::find($request->id);
        $permission->name = $request->name;

        if ($permission->save())
            $this->addAlert(AlertType::SUCCESS, __('Created successfully'));
        else
            $this->addAlert(AlertType::ERROR, __('Could not be created'));

        return redirect()->route('permission.edit', $request->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
