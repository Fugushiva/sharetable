<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow all authenticated users to view any messages
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Message $message): bool
    {
        // Allow the user to view the message if they are the sender, receiver, or an admin
        return $user->id === $message->user_id ||
            $message->thread->participants()->pluck('user_id')->contains($user->id) ||
            $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Allow all authenticated users to create messages
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Message $message): bool
    {
        // Allow the user to update the message if they are the sender or an admin
        return $user->id === $message->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        // Allow the user to delete the message if they are the sender or an admin
        return $user->id === $message->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Message $message): bool
    {
        // Allow the user to restore the message if they are the sender or an admin
        return $user->id === $message->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Message $message): bool
    {
        // Allow the user to permanently delete the message if they are the sender or an admin
        return $user->id === $message->user_id || $user->hasRole('admin');
    }
}

