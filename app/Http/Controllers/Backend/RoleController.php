<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Utils\Enums\AlertType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index', Role::class);

        return view('backend.role.IndexRole');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Role::class);

        return view('backend.role.CreateRole');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')]]);

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        if ($role->save())
            $this->addAlert(AlertType::SUCCESS, __('Created successfully'));
        else
            $this->addAlert(AlertType::ERROR, __('Could not be created'));

        return redirect()->route('role.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        Gate::authorize('show', $role);

        return view('backend.role.ShowRole', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $role = Role::find($id);
        Gate::authorize('show', $role);

        return view('backend.role.EditRole', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:255'],]);

        $role = Role::find($request->id);
        $role->name = $request->name;

        if ($role->save())
            $this->addAlert(AlertType::SUCCESS, __('Created successfully'));
        else
            $this->addAlert(AlertType::ERROR, __('Could not be created'));

        return redirect()->route('role.edit', $request->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
