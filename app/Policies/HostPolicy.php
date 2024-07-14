<?php

namespace App\Policies;

use App\Models\Host;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Host $host): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * Only users without the host profile can create hosts
     * @param User $user The user to check
     * @return bool True if the user does not have the host profile, false otherwise
     */
    public function create(User $user): bool
    {
        return $user->profiles->doesntContain(Profile::where('profile', 'host')->first()) || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     */
    public function update(User $user, Host $host): bool
    {
        return $user->hasRole('admin') || $user->id === $host->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     */
    public function delete(User $user, Host $host): bool
    {
        return $user->hasRole('admin') || $user->id === $host->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Host $host): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Host $host): bool
    {
        //
    }
}
