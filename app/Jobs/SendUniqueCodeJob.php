<?php

namespace App\Jobs;

use App\Models\BookingCode;
use App\Models\Reservation;
use App\Notifications\NewNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendUniqueCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reservation;
    /**
     * Create a new job instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Début de la gestion du job pour la réservation ID: ' . $this->reservation->id);

        // generate a unique code
        $code = bin2hex(random_bytes(3));



        $user = $this->reservation->user;
        if (!$user) {
            Log::error('Utilisateur non trouvé pour la réservation ID: ' . $this->reservation->id);
            return;
        }

        $bookingCode = BookingCode::create([
            'reservation_id' => $this->reservation->id,
            'code' => $code,
        ]);

        if (!$bookingCode) {
            Log::error('Échec de la création du code de réservation pour la réservation ID: ' . $this->reservation->id);
            return;
        }

        Log::info('Code de réservation créé: ' . $code . ' pour la réservation ID: ' . $this->reservation->id);

        $user->notify(new NewNotification(__('notification.booking_code.send', ['code' => $code])));


        //Mail::to($user->email)->send(new \App\Mail\BookingCode($user, $this->reservation, $code));
        Log::info('Mail envoyé à ' . $user->email . ' pour la réservation ID: ' . $this->reservation->id);
    }
}
