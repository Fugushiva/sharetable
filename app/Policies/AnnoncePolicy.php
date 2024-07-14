<?php

namespace App\Policies;

use App\Models\Annonce;
use App\Models\Host;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnnoncePolicy
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
    public function view(User $user, Annonce $annonce): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * Only users with the host profile can create annonces
     * @param User $user
     * @return Response user with the host profile
     */
    public function create(User $user): bool
    {
        return $user->profiles->contains(Profile::where('profile', 'host')->first());
    }

    /**
     * Only the host of the annonce can update it
     * @param User $user connected user
     * @param Annonce $annonce annonce from the user
     * @return bool true if the user is the host of the annonce
     */
    public function update(User $user, Annonce $annonce): bool
    {
        return $user->id === $annonce->host->user_id;
    }

    /**
     * Only the host of the annonce can delete it
     * @param User $user connected user
     * @param Annonce $annonce annonce from the user
     * @return bool true if the user is the host of the annonce
     */
    public function delete(User $user, Annonce $annonce): bool
    {
        return $user->id === $annonce->host->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Annonce $annonce): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Annonce $annonce): bool
    {
        //
    }
}
