<?php

namespace App\Http\Controllers;

use App\Notifications\NewNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;
        return view('notification.index', compact('notifications'));
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function sendNotification()
    {
        $user = auth()->user();  // Vous pouvez également cibler d'autres utilisateurs
        $user->notify(new NewNotification('Vous avez une nouvelle notification !'));

        return redirect()->back()->with('status', 'Notification envoyée !');
    }
}
