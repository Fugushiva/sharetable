<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Annonce;
use App\Models\Host;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class StripeController extends Controller
{
    public function index()
    {
        return view('index');
    }

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
            'cancel_url' => route('stripe.index'),

        ]);

        $request->session()->put('stripe_session_id', $session->id);


        return redirect()->away($session->url);
    }

    public function success()
    {
        return view('stripe.index');
    }
}
