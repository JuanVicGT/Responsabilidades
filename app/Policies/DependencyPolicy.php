<?php

namespace App\Policies;

use App\Models\Dependency;
use App\Models\User;

class DependencyPolicy
{
    /** @var string */
    private $modelName = 'dependency';

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
    public function show(User $user, Dependency $dependency): bool
    {
        return $user->is_admin || $user->hasPermissionTo('show_' . $this->modelName);
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
    public function edit(User $user, Dependency $dependency): bool
    {
        return $user->is_admin || $user->hasPermissionTo('edit_' . $this->modelName);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dependency $dependency): bool
    {
        return $user->is_admin || $user->hasPermissionTo('delete_' . $this->modelName);
    }
}
