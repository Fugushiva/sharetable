<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Annonce;
use App\Models\Host;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::activeForUser(auth()->id())->get();

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
        //Définiaation de la clé secrète de l'API Stripe pour les transactions
        Stripe::setApiKey(config('stripe.sk'));

        $annonce = Annonce::find($request->input('annonce_id'));
        $user = Auth::user();

        // Vérifie si l'annonce existe, sinon redirige avec un message d'erreur
        if (!$annonce) {
            return redirect()->back()->withErrors(['msg' => __('message.annonce_exists')]);
        }


        // Crée la réservation
        $reservation = Reservation::create([
            'annonce_id' => $annonce->id,
            'user_id' => $user->id,
            'host_id' => $annonce->host_id,
        ]);

        //retrouver la transaction stipe
        $session = Session::retrieve($request->session()->get('stripe_session_id'));


        $transaction = Transaction::create([
            'annonce_id' => $annonce->id,
            'user_id' =>$user->id,
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
}
