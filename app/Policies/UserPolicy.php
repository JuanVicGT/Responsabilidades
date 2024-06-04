<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /** @var string */
    private $modelName = 'user';

    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user): bool
    {
        return $user->is_admin || $user->hasPermissionTo('index_' . $this->modelName);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->is_admin || $user->hasPermissionTo('view_' . $this->modelName);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_admin || $user->hasPermissionTo('create_' . $this->modelName);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, User $model): bool
    {
        return $user->is_admin || $user->hasPermissionTo('edit_' . $this->modelName);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->is_admin || $user->hasPermissionTo('delete_' . $this->modelName);
    }
}
