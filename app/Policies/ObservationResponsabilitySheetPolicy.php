<?php

namespace App\Policies;

use App\Models\ObservationResponsabilitySheet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ObservationResponsabilitySheetPolicy
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
    public function view(User $user, ObservationResponsabilitySheet $observationResponsabilitySheet): bool
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
    public function update(User $user, ObservationResponsabilitySheet $observationResponsabilitySheet): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ObservationResponsabilitySheet $observationResponsabilitySheet): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ObservationResponsabilitySheet $observationResponsabilitySheet): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ObservationResponsabilitySheet $observationResponsabilitySheet): bool
    {
        //
    }
}
