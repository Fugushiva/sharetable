<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Thread as BaseThread;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Thread extends BaseThread
{
    public function userUnreadMessages($userId)
    {
        $messages = $this->messages()->where('user_id', '!=', $userId)->where('is_read', 0)->get();

        try {
            $participant = $this->getParticipantFromUser($userId);
        } catch (ModelNotFoundException $e) {
            return collect();
        }

        if (! $participant->last_read) {
            return $messages;
        }

        return $messages->filter(function ($message) use ($participant) {
            return $message->updated_at->gt($participant->last_read);
        });
    }

    public function unreadMessagesCount($userId)
    {
        return $this->userUnreadMessages($userId)->count();
    }
}

