<?php

namespace App\Policies;

use App\Models\User;
use App\Models\booking;

class BookingPolicy
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
    public function view(User $user, booking $booking): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo("booking:create");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, booking $booking): bool
    {
        return $user->hasPermissionTo("booking:update") && $user->id === $booking->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, booking $booking): bool
    {
        if (($user->hasRole("manager") && $booking->stadium->owner_id === $user->id) || ($user->hasRole("customer") && $user->id === $booking->user_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, booking $booking): bool
    {
        return false;
    }
}
