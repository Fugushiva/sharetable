<?php

namespace App\Policies;

use App\Models\User;
use Cmgmyr\Messenger\Models\Thread;

class ThreadPolicy
{
    /**
     * Determine whether the user can view the thread.
     */
    public function view(User $user, Thread $thread): bool
    {
        // Vérifiez si l'utilisateur est un participant du thread ou un administrateur
        return $thread->participants()->where('user_id', $user->id)->exists() || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create a thread.
     */
    public function create(User $user): bool
    {
        // Allow all authenticated users to create threads
        return true;
    }

    /**
     * Determine whether the user can update the thread.
     */
    public function update(User $user, Thread $thread): bool
    {
        // Allow the user to update the thread if they are a participant or an admin
        return $thread->participants()->where('user_id', $user->id)->exists() || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the thread.
     */
    public function delete(User $user, Thread $thread): bool
    {
        // Allow the user to delete the thread if they are a participant or an admin
        return $thread->participants()->where('user_id', $user->id)->exists() || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the thread.
     */
    public function restore(User $user, Thread $thread): bool
    {
        // Allow the user to restore the thread if they are a participant or an admin
        return $thread->participants()->where('user_id', $user->id)->exists() || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the thread.
     */
    public function forceDelete(User $user, Thread $thread): bool
    {
        // Allow the user to permanently delete the thread if they are a participant or an admin
        return $thread->participants()->where('user_id', $user->id)->exists() || $user->hasRole('admin');
    }
}

