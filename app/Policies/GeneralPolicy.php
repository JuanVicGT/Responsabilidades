<?php

namespace App\Policies;

use App\Models\User;

class GeneralPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public static function index(User $user, string $view_name): bool
    {
        return $user->is_admin || $user->hasPermissionTo('index_' . $view_name);
    }

    /**
     * Determine whether the user can view the model.
     */
    public static function show(User $user, string $view_name): bool
    {
        return $user->is_admin || $user->hasPermissionTo('show_' . $view_name);
    }

    /**
     * Determine whether the user can create models.
     */
    public static function create(User $user, string $view_name): bool
    {
        return $user->is_admin || $user->hasPermissionTo('create_' . $view_name);
    }

    /**
     * Determine whether the user can update the model.
     */
    public static function edit(User $user, string $view_name): bool
    {
        return $user->is_admin || $user->hasPermissionTo('edit_' . $view_name);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public static function delete(User $user, string $view_name): bool
    {
        return $user->is_admin || $user->hasPermissionTo('delete_' . $view_name);
    }
}
