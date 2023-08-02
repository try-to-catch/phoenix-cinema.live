<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScreeningPolicy
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
    public function view(User $user, Screening $screening): bool
    {
        return true;
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
    public function update(User $user, Screening $screening): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Screening $screening): Response
    {
        return $screening->seats()->where('is_taken', true)->count() === 0
            ? Response::allow()
            : Response::deny('Cannot delete screening with taken seats');
    }
}
