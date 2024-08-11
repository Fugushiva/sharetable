<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Jobs\SendUniqueCodeJob;
use App\Mail\UserEvaluation;
use App\Models\Annonce;
use App\Models\BookingCode;
use App\Models\Host;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Notifications\NewNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Stripe\Checkout\Session as stripeSession;
use Stripe\Stripe;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::activeForUser(auth()->id())
        ->whereHas('annonce', function($query){
            $query->where('schedule', '>', now());
        })->get();


        return view('reservation.index', compact('reservations',));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
        $annonce = Annonce::with('host.user')->find($request->id);

        $reservationExists = Reservation::reservationExists($annonce->id, Auth::id());

        if ($reservationExists) {
            return redirect()->back()->withErrors(['msg' => __('message.reservation_exists')]);
        }

        return view('reservation.create', compact('annonce'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\RedirectResponse with a success message or an error message
     */
    public function store(StoreReservationRequest $request)
    {
        Stripe::setApiKey(config('stripe.sk'));

        $annonce = Annonce::find($request->input('annonce_id'));
        $user = Auth::user();

        // Vérifie si l'annonce existe, sinon redirige avec un message d'erreur
        if (!$annonce) {
            return redirect()->back()->withErrors(['msg' => __('message.annonce_exists')]);
        }

        // Créer la réservation
        $reservation = $this->createReservation($annonce, $user);
        $session = stripeSession::retrieve($request->session()->get('stripe_session_id'));

        // Créer la transaction
        $this->createTransaction($annonce, $user, $reservation, $session);

        // Notifier l'hôte
        $this->notifyHost($annonce);

        // Décrémenter le nombre de places disponibles
        $this->decrementPlace($annonce);

        // Calculer le délai pour l'envoi de l'email 48 heures avant la réservation
        $scheduleTime = Carbon::parse($reservation->annonce->schedule)->subHours(48);
        $now = Carbon::now();

        if ($scheduleTime->lessThan($now)) {
            // Si la réservation est dans moins de 48 heures, envoyer l'email immédiatement
            $this->bookingCodeGenerate($reservation);
            $user->notify(new NewNotification(__('notification.booking_code.send', ['code' => Session::get('booking_code')])));
        } else {
            // Sinon, planifier l'envoi de l'email 48 heures avant la réservation
            $this->bookingCodeGenerate($reservation)->delay($scheduleTime);
            $user->notify(new NewNotification(__('notification.booking_code.send', ['code' => Session::get('booking_code')])));
        }

        return redirect()->route('reservation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    /**
     * Create a reservation
     * @param $annonce Annonce::class
     * @param $user  User::class
     * @return Reservation::class
     */
    private function createReservation($annonce, $user)
    {

        return Reservation::create([
            'annonce_id' => $annonce->id,
            'user_id' => $user->id,
            'host_id' => $annonce->host_id,
        ]);

    }

    /**
     * Create a transaction
     * @param $annonce Annonce::class
     * @param $user User::class
     * @param $reservation Reservation::class
     * @param $session Session::class
     * @return Transaction::class
     */
    private function createTransaction($annonce, $user, $reservation, $session)
    {
        return Transaction::create([
            'annonce_id' => $annonce->id,
            'user_id' => $user->id,
            'reservation_id' => $reservation->id,
            'host_id' => $annonce->host_id,
            'quantity' => 1,
            'payment_status' => 'completed',
            'stripe_transaction_id' => $session->payment_intent,
            'commission' => $annonce->price * 0.1,
            'currency' => $session->currency,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Notify the host
     * @param $annonce Annonce::class
     */
    private function notifyHost($annonce)
    {
        $host = Host::find($annonce->host_id);
        $message = __('notification.new_reservation');
        $url = URL::route('annonce.show', ['id' => $annonce->id]);
        $host->user->notify(new NewNotification($message, $url));
    }

    /**
     * Decrement the place
     * @param $annonce Annonce::class
     */
    private function decrementPlace($annonce)
    {
        $annonce->max_guest = $annonce->max_guest - 1;
        $annonce->save();
    }

    public function checkBookingCode(Request $request)
    {
        $request->validate([
            "code" => ['string', "exists:booking_codes,code"]
        ]);

        $annonce = Annonce::find($request->input('annonce_id'));
        $annonceId = $annonce->id;

        //search for code & associated reservation and check annonce id
        $bookingCode = BookingCode::where('code', $request->input('code'))
            ->whereHas('reservation', function ($query) use ($annonceId) {
                $query->where('annonce_id', $annonceId);
            })->first();

        //Check if the code was not already validated
        if ($bookingCode && !$bookingCode->validated) {
            $bookingCode->validated = true;
            $bookingCode->save();

            $reservation = $bookingCode->reservation;
            $guest = $reservation->user;
            $host = $annonce->host->user;

            // Envoyer un email à l'hôte
            //Mail::to($host->email)->send(new UserEvaluation($host, $guest));
            //envoyer une notification à l'hôte
            $host->notify(new NewNotification(__('notification.evaluation.evaluate', ['name' => $guest->firstname]), URL::route('guest.show', ['id' => $guest->id, 'reservationId' => $reservation->id])));

            // Envoyer un email à l'invité
            //Mail::to($guest->email)->send(new UserEvaluation($guest, $host));
            //envoyer une notification à l'invité
            $guest->notify(new NewNotification(__('notification.evaluation.evaluate', ['name' => $host->firstname]), URL::route('host.show', ['host' => $host->id])));

            return response()->json([
                'message' => 'Booking code is valid and has been marked as used.',
                'reservation' => $bookingCode->reservation,
            ]);
        }


        return response()->json([
            'message' => 'Invalid or already used booking code.',
        ], 400);
    }

    public function bookingCodeGenerate($reservation)
    {
        $code = bin2hex(random_bytes(3));

        $bookingCode = BookingCode::create([
            'reservation_id' => $reservation->id,
            'code' => $code,
        ]);

        Session::put('booking_code', $code);

        return $bookingCode;
    }

}
