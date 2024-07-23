<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Mail\PaymentDone;
use App\Mail\PaymentRefund;
use App\Models\Annonce;
use App\Models\Host;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NewNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class StripeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    /**
     * Checkout the reservation
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException : if the API key is not set
     */
    public function checkout(StoreReservationRequest $request)
    {
        //config/stripe.php
        Stripe::setApiKey(config('stripe.sk'));

        // Decrypt the annonce_id because it was encrypted in the form to prevent any manipulation
        $annonce = Annonce::find(decrypt($request->annonce_id));
        $host = Host::find($annonce->host_id);
        $guest = auth()->user();

        // Store the annonce_id in the session
        session(['annonce_id' => $annonce->id]);


        $metadata =
            [
                'annonce_id' => $annonce->id,
                'host_id' => $host->id,
                'guest_id' => $guest->id,
                'annonce_title' => $annonce->title
            ];

        $session = Session::create([
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
                    'quantity' => 1, // always 1
                ]
            ],
            'metadata' => $metadata,
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),

        ]);

        $request->session()->put('stripe_session_id', $session->id);


        // Allow access to the success page
        $request->session()->put('allow_access', true);


        return redirect()->away($session->url);
    }

    public function success()
    {
        $user = User::find(auth()->user()->id);
        $annonce = Annonce::find(session('annonce_id'));
        $host = Host::find($annonce->host_id);

        Mail::to($user->email)->send(new PaymentDone($user, $annonce, $host));
        return view('stripe.index');
    }

    public function refund(Request $request)
    {

        // Valider les données reçues
        $request->validate([
            'reservation_id' => 'required|exists:transactions,reservation_id',
        ]);

        Stripe::setApiKey(config('stripe.sk'));

        $user = User::find(auth()->user()->id);
        $host = Host::find($user->id);
        $reservation = Reservation::find($request->reservation_id);
        $transaction = Transaction::where('reservation_id', $request->reservation_id)->first();
        $annonce = Annonce::find($reservation->annonce_id);
        $annonceHost = Host::find($annonce->host_id);

        if (!$transaction) {
            return redirect()->route('stripe.index')->with('error', 'Transaction not found.');
        }

        try {

            $reservation->update([
                'status' => 'cancelled',
            ]);

            $hostMessage = __('notification.cancel_reservation', ['Name' => $user->firstname]);
            $annonceHost->notify(new NewNotification($hostMessage));

            $scheduleDate = Carbon::parse($annonce->schedule);
            // Vérifier si la date de la réservation est dans les 2 prochains jours
            if ($scheduleDate->isBefore(now()->addDays(2))) {
                return redirect()->route('reservation.index')->with('error', 'Refund not possible, the reservation is less than 2 days away.');
            }

            // Créer le remboursement
            $refund = \Stripe\Refund::create([
                'payment_intent' => $transaction->stripe_transaction_id,
            ]);

            $transaction->update([
                'payment_status' => 'refunded',
            ]);

            $hostMessage = "$user->firstname a annulé sa réservation.";

            Mail::to($user->email)->send(new PaymentRefund($user, $annonce, $host));


            return redirect()->route('reservation.index')->with('success', 'Refund successful.');
        } catch (\Exception $e) {
            // Gérer les erreurs
            return redirect()->route('host.profile')->with('error', 'Refund failed: ' . $e->getMessage());
        }
    }

    /**
     * Refund all reservations for a specific ad
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception : si l'annonce n'existe pas
     * @throws \Exception : si la réservation n'existe pas
     */
    public function refundAll()
    {
        $annonce = Annonce::find(session('annonce_id'));
        $reservations = Reservation::all()->where('annonce_id', $annonce->id);
        $guestMessage = __('notification.host_cancel_reservation');

        Stripe::setApiKey(config('stripe.sk'));

        // pour chaque réservation on annule la réservation et on rembourse
        foreach ($reservations as $reservation) {
            $transaction = Transaction::where('reservation_id', $reservation->id)->first();
            $guest = User::find($reservation->user_id);
            if (!$transaction) {
                return redirect()->route('stripe.index')->with('error', 'Transaction not found.');
            }


            // les 4 premières transactions sont des tests, on ne les rembourse pas
            if ($transaction->id > '4') {
                try {

                    $reservation->update([
                        'status' => 'cancelled',
                    ]);

                    // Notifier le guest
                    $guest->notify(new NewNotification($guestMessage));



                    $refund = \Stripe\Refund::create([
                        'payment_intent' => $transaction->stripe_transaction_id,
                    ]);

                    $transaction->update([
                        'payment_status' => 'refunded',
                    ]);

                } catch (\Exception $e) {
                    // Gérer les erreurs
                    return redirect()->route('reservation.index')->with('error', 'Refund failed: ' . $e->getMessage());
                }
            } else {
                $reservation->update([
                    'status' => 'cancelled',
                ]);
                $transaction->update([
                    'payment_status' => 'refunded',
                ]);
            }
        }
        return redirect()->route('reservation.index')->with('success', 'Refund successful.');
    }

    public function cancel()
    {
        $annonce = Annonce::find(session('annonce_id'));


        return redirect()->route('annonce.show', ['id' => $annonce->id]);
    }
}
