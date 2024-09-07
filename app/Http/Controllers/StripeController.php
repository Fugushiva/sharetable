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
use App\Services\StripeService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Transfer;


class StripeController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

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
        $annonce = Annonce::find(decrypt($request->annonce_id));
        $host = $annonce->host;
        $guest = auth()->user();

        session(['annonce_id' => $annonce->id]);

        // Create a new checkout session
        $session = $this->stripeService->createCheckoutSession($annonce, $host, $guest);
        $request->session()->put('stripe_session_id', $session->id);
        $request->session()->put('allow_access', true);

        return redirect()->away($session->url);
    }

    public function success()
    {
        $user = User::find(auth()->user()->id);
        $annonce = Annonce::find(session('annonce_id'));
        $host = Host::find($annonce->host_id);


        //Mail::to($user->email)->send(new PaymentDone($user, $annonce, $host));
        return view('stripe.index');
    }

    public function refund(Request $request)
    {
        $request->validate(['reservation_id' => 'required|exists:transactions,reservation_id']);

        $userId = auth()->user()->id;
        $result = $this->stripeService->processRefund($request->reservation_id, $userId);



        if ($result['success']) {
            return redirect()->route('reservation.index')->with('success', $result['message']);
        } else {
            return redirect()->route('reservation.index')->with('error', $result['message']);
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
        $errors = $this->stripeService->refundAllReservations($annonce);

        if (empty($errors)) {
            return redirect()->route('reservation.index')->with('success', 'All refunds successful.');
        } else {
            return redirect()->route('reservation.index')->with('error', implode(', ', $errors));
        }
    }

    public function cancel()
    {
        $annonce = Annonce::find(session('annonce_id'));


        return redirect()->route('annonce.show', ['id' => $annonce->id]);
    }

    public function transferPaymentToHost($host, $amount)
    {
        Stripe::setApiKey(env('STRIPE_SK'));

        try {
            // Transférer 85% du montant total au compte Stripe de l'hôte
            $transfer = Transfer::create([
                'amount' => intval($amount * 100), // Le montant en centimes
                'currency' => 'eur',
                'destination' => $host->stripe_account_id,
                'transfer_group' => 'reservation_' . $host->id,
            ]);

            return response()->json(['success' => 'Paiement transféré avec succès à l\'hôte.'], 200);

        } catch (\Exception $e) {
            // Log l'erreur pour savoir ce qui s'est passé
            Log::error('Erreur lors du transfert : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors du transfert : ' . $e->getMessage()], 500);
        }
    }
}
