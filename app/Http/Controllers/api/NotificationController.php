<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Notifications\NewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            Log::error('User not authenticated in index method.');
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $notifications = $user->notifications;
        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $unreadNotifications = $user->notifications()->whereNull('read_at')->get();

        // Marquer les notifications comme lues
        foreach($unreadNotifications as $notification){
            $notification->read_at = now();
        }
        $user->notifications()->saveMany($unreadNotifications);

        return response()->json(['message' => 'Notifications marked as read'], 200);
    }

    public function sendNotification(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            Log::error('User not authenticated in sendNotification method.');
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $user->notify(new NewNotification('Vous avez une nouvelle notification !'));
        return response()->json(['message' => 'Notification sent!'], 200);
    }

    public function getUnreadNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            Log::error('User not authenticated in getUnreadNotifications method.');
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Accéder directement aux notifications non lues
        $unreadNotifications = $user->notifications()->whereNull('read_at')->get();
        return response()->json($unreadNotifications);
    }
}


