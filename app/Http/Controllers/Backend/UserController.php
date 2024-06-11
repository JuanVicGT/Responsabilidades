<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserPasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Dependency;
use App\Models\Role;
use App\Models\User;
use App\Utils\Enums\AlertType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index', User::class);
        return view('backend.user.IndexUser');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create', Role::class);

        $dependencies = Dependency::all();
        $roles = Role::all();
        return view('backend.user.CreateUser', compact('dependencies', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        $user = new User();
        $user->code = $request->code;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->work_position = $request->work_position;
        $user->work_row = $request->work_row;
        $user->dependency = $request->dependency;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->birthdate = $request->birthdate;
        $user->address = $request->address;
        $user->is_admin = $request->is_admin;
        $user->is_active = $request->is_active;

        $password = Str::random(8);
        $user->password = Hash::make($password);

        $save = $user->save();

        if (!$save)
            $this->addAlert(AlertType::Error, __('Could not be stored'));

        if ($save) {
            $user->assignRole($request->role);
            $this->addAlert(AlertType::Success, __('Stored successfully. username: :username, password: :password', ['username' => $user->username, 'password' => $password]));
        }

        return redirect()->route('user.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        Gate::authorize('show', $user);
        return view('backend.user.Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        Gate::authorize('show', $user);

        $roles = Role::all();
        $dependencies = Dependency::all();
        $currentRole = $user->roles()->first();
        return view('backend.user.EditUser', compact('user', 'roles', 'dependencies', 'currentRole'));
    }

    public function update_password(UpdateUserPasswordRequest $request)
    {
        $user = User::find($request->id);

        $password = Str::random(8);
        $user->password = Hash::make($password);
        $save = $user->save();

        if (!$save)
            $this->addAlert(AlertType::Error, __('Could not be stored'));

        if ($save)
            $this->addAlert(AlertType::Success, __('Updated successfully, password: ' . $password));

        return redirect()->route('user.edit', $user->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = User::find($request->id);
        $user->code = $request->code;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->work_position = $request->work_position;
        $user->work_row = $request->work_row;
        $user->dependency = $request->dependency;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->birthdate = $request->birthdate;
        $user->address = $request->address;
        $user->is_admin = $request->is_admin;
        $user->is_active = $request->is_active;

        $save = $user->save();

        if (!$save)
            $this->addAlert(AlertType::Error, __('Could not be stored'));

        if ($save) {
            $user->syncRoles([$request->role]);
            $this->addAlert(AlertType::Success, __('Updated successfully'));
        }

        return redirect()->route('user.edit', $user->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
