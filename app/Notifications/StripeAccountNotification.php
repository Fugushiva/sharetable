<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StripeAccountNotification extends Notification
{
    use Queueable;

    public $message;
    private $hostId;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $hostId)
    {
        $this->message = $message;
        $this->hostId = $hostId;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];  // ou 'mail' si vous envoyez par email
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return json_encode([
            'message' => $this->message,
            'url' => route('host.stripe-connect', ['host' => $this->hostId])
        ]);

    }
}
