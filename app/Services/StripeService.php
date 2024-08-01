<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NewNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Refund;
use Stripe\Stripe;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.sk'));
    }


    /**
     * Create a new checkout session
     * @param $annonce
     * @param $host
     * @param $guest
     * @return Session
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCheckoutSession($annonce, $host, $guest)
    {
        $metadata =
            [
                'annonce_id' => $annonce->id,
                'host_id' => $host->id,
                'guest_id' => $guest->id,
                'annonce_title' => $annonce->title
            ];

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $annonce->title,
                        ],
                        'unit_amount' => str_replace('.', '', $annonce->price),
                    ],
                    'quantity' => 1,
                ],
            ],
            'metadata' => $metadata,
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);
    }

    public function createRefund($paymentIntentId)
    {
        return Refund::create([
            'payment_intent' => $paymentIntentId,
        ]);
    }

    public function processRefund($reservationId, $userId)
    {
        $user = User::find($userId);
        $reservation = Reservation::find($reservationId);
        $transaction = Transaction::where('reservation_id', $reservationId)->first();
        $annonce = $reservation->annonce;
        $annonceHost = $annonce->host;

        try {
            // Annuler la réservation
            $reservation->update(['status' => 'cancelled']);
            $scheduleDate = Carbon::parse($annonce->schedule);

            // Vérifier si la réservation est dans moins de 2 jours
            if ($scheduleDate->isBefore(now()->addDays(2))) {
                // Envoyer une notification au client
                $message = __('notification.refund.time_over');
                $user->notify(new NewNotification($message));

                $annonce->update(['max_guest' => $annonce->max_guests + 1]);

                return ['success' => false, 'message' => __('notification.refund.time_over')];
            }

            // Créer un remboursement
            $this->createRefund($transaction->stripe_transaction_id);
            $transaction->update(['status' => 'refunded']);

            // Envoyer une notification au client
            $message = __('notification.refund.success_guest');
            $user->notify(new NewNotification($message));

            // Envoyer une notification à l'hôte
            $message = __('notification.refund.host_message', ['Name' => $user->firstname]);
            $annonceHost->user->notify(new NewNotification($message));

            // Envoyer un email au client
            //Mail::to($user->email)->send(new \App\Mail\PaymentRefund($user, $annonce, $annonceHost));
            // Mettre à jour le nombre maximal de clients de l'annonce
            $annonce->update(['max_guest' => $annonce->max_guests + 1]);

            return ['success' => true, 'message' => 'Remboursement réussi.'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Échec du remboursement : ' . $e->getMessage()];
        }
    }

    public function refundAllReservations($annonce)
    {
        $reservations = Reservation::where('annonce_id', $annonce->id)->get();
        $guestMessage = __('notification.host_cancel_reservation');
        $errors = [];

        // for each reservation we cancel the reservation and refund
        foreach ($reservations as $reservation) {
            $transaction = Transaction::where('reservation_id', $reservation->id)->first();
            $guest = User::find($reservation->user_id);

            if (!$transaction) {
                $errors[] = 'Transaction not found for reservation ID: ' . $reservation->id;
                continue;
            }

            try {
                $reservation->update(['status' => 'cancelled']);
                $guest->notify(new NewNotification($guestMessage));
                $this->createRefund($transaction->stripe_transaction_id);
                $transaction->update(['payment_status' => 'refunded']);
            } catch (\Exception $e) {
                $errors[] = 'Refund failed for reservation ID: ' . $reservation->id . ' - ' . $e->getMessage();
            }

        }

        return $errors;
    }

}
