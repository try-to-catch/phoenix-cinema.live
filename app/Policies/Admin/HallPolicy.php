<?php

namespace App\Policies\Admin;

use App\Models\Hall;
use App\Models\User;

class HallPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hall $hall): bool
    {
        return $hall->is_preset;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hall $hall): bool
    {
        return $hall->is_preset;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hall $hall): bool
    {
        return $hall->is_preset;
    }
}
