<?php

namespace App\Policies;

use App\Models\LineResponsabilitySheet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LineResponsabilitySheetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, LineResponsabilitySheet $lineResponsabilitySheet): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LineResponsabilitySheet $lineResponsabilitySheet): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LineResponsabilitySheet $lineResponsabilitySheet): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LineResponsabilitySheet $lineResponsabilitySheet): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LineResponsabilitySheet $lineResponsabilitySheet): bool
    {
        //
    }
}
