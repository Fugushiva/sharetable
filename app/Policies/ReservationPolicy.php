<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ReservationPolicy
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
     * Only the user who created the reservation can view it
     * @param User $user The authenticated user
     * @param Reservation $reservation The reservation to view
     * @return Response The reservation can be viewed by the user if the user created it
     */
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

    /**
     * Determine whether the user can create models.
     * Only authenticated users can create reservations
     * @param User $user The authenticated user
     * @return Response The user can create a reservation if they are authenticated
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     * Only the user who created the reservation can delete it
     * @param User $user The authenticated user
     * @param Reservation $reservation The reservation from the user to delete
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        //
    }
}
