<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        $user = Auth::user();

        // Récupérer les notifications de l'utilisateur
        $userNotifications = Notification::where('user_id', $user->id)->get();

        // Vérification et décodage des données JSON
        $userNotifications->transform(function ($notification) {
            $data = json_decode($notification->data, true);

            // Vérifier que 'message' est une chaîne, mais permettre 'url' d'être null
            if (isset($data['message']) && is_string($data['message'])) {
                $notification->message = $data['message'];
                // Si l'URL est une chaîne ou null, on l'accepte
                $notification->url = is_string($data['url']) ? $data['url'] : null;
            } else {
                // Si le 'message' n'est pas valide, on le marque comme invalide
                $notification->message = 'Message non valide';
                $notification->url = '#'; // Lien par défaut
            }

            return $notification;
        });

        // Passer les notifications vérifiées à la vue
        return view('notification.show', compact('userNotifications'));
    }
}

