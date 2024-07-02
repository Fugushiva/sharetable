<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Annonce;
use App\Models\Host;
use App\Models\Reservation;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('annonce')->where('user_id', auth()->id())->get();

        return view('reservation.index', compact('reservations',));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $annonce = Annonce::with('host.user')->find($request->id);

        return view('reservation.create', compact('annonce'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\RedirectResponse with a success message or an error message
     */
    public function store(StoreReservationRequest $request)
    {
        // Decrypt the annonce_id
        try {
            $annonceId = Crypt::decrypt($request->input('annonce_id'));
        } catch (DecryptException $e) {
            return redirect()->back()->withErrors('Invalid annonce ID');
        }

        $annonce = Annonce::find($annonceId);

        // Check if the annonce exists, if not, redirect back with an error message
        if (!$annonce) {
            return redirect()->back()->withErrors('Annonce not found');
        }

        // Check if the user has already reserved this annonce, if yes, redirect back with an error message
        if (Reservation::where('user_id', auth()->id())->where('annonce_id', $annonceId)->first()) {
            return redirect()->back()->withErrors(['msg' => __('message.reservation_exists')]);
        }

        Reservation::create([
            'annonce_id' => $annonceId,
            'user_id' => auth()->id(),
            'host_id' => $annonce->host_id,
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
