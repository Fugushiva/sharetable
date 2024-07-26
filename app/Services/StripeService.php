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

            // cancel the reservation
            $reservation->update(['status' => 'cancelled']);
            $scheduleDate = Carbon::parse($annonce->schedule);

            // check if the reservation is in less than 2 days
            if ($scheduleDate->isBefore(now()->addDays(2))) {
                // send notification to customer
                $message = __('annonce.refund.time_over');
                $user->notify(new NewNotification($message));

                return redirect()->route('stripe.index')->with('error', __('notification.refund.time_over'));
            }
            //create refund
            $this->createRefund($transaction->stripe_transaction_id);
            $transaction->update(['status' => 'refunded']);

            // send notification to customer
            $message = __('notification.refund.success');
            $user->notify(new NewNotification($message));

            // send notification to host
            $message = __('notification.refund.host_message', ['Name' => $user->firstname]);
            $annonceHost->user->notify(new NewNotification($message));


            // send email to customer
            Mail::to($user->email)->send(new \App\Mail\PaymentRefund($user, $annonce, $annonceHost));
            // update the max_guests of the annonce
            $annonce->update(['max_guests' => $annonce->max_guests + 1]);

            return ['success' => true, 'message' => 'Refund successful.'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Refund failed: ' . $e->getMessage()];
        }
    }

    public function refundAllReservations($annonce)
    {
        $reservations = Reservation::where('annonce_id', $annonce->id)->get();
        $guestMessage = __('notification.host_cancel_reservation');

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
