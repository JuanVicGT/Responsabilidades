<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserPasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Dependency;
use App\Models\Role;
use App\Models\User;
use App\Utils\Enums\AlertTypeEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private const MODULE_NAME = 'user';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->general_auth('index', self::MODULE_NAME);
        return view('backend.user.IndexUser');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->general_auth('create', self::MODULE_NAME);

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
        $user->is_first_login = true;

        $password = Str::random(8);
        $user->password = Hash::make($password);

        $save = $user->save();

        if (!$save)
            $this->addAlert(AlertTypeEnum::Error, __('Could not be stored'));

        if ($save) {
            $user->assignRole($request->role);
            $this->addAlert(AlertTypeEnum::Success, __('Stored successfully. username: :username, password: :password', ['username' => $user->username, 'password' => $password]));
        }

        return redirect()->route('user.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->general_auth('show', self::MODULE_NAME);
        return view('backend.user.Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->general_auth('edit', self::MODULE_NAME);

        $user = User::find($id);

        $roles = Role::all();
        $dependencies = Dependency::all();
        $current_role = $user->roles()->first();

        return view('backend.user.EditUser', compact(
            'user',
            'roles',
            'dependencies',
            'current_role'
        ));
    }

    /**
     * Apply the random password reset
     */
    public function apply_password_reset(UpdateUserPasswordRequest $request)
    {
        /** @var User */
        $user = User::find($request->id);

        $password = Str::random(8);
        if ($user->applyPasswordResetRequest($password)) {
            $this->addAlert(AlertTypeEnum::Success, __('Updated successfully, password: ' . $password));
        } else {
            $this->addAlert(AlertTypeEnum::Error, __('Could not be updated'));
        }

        return redirect()->route('user.edit', $user->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Refuse the password reset
     */
    public function refuse_password_reset(UpdateUserPasswordRequest $request)
    {
        $user = User::find($request->id);

        if ($user->refusePasswordResetRequest()) {
            $this->addAlert(AlertTypeEnum::Success, __('Password reset refused'));
        } else {
            $this->addAlert(AlertTypeEnum::Error, __('Could not be updated'));
        }

        return redirect()->route('user.edit', $user->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = User::find($request->id);
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
            $this->addAlert(AlertTypeEnum::Error, __('Could not be stored'));

        if ($save) {
            $user->syncRoles([$request->role]);
            $this->addAlert(AlertTypeEnum::Success, __('Updated successfully'));
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
