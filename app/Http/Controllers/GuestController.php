<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Evaluation;
use App\Models\Host;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Nnjeim\World\Models\Country;

class GuestController extends Controller
{
    /**
     * Display a listing of the guest.
     */
    public function index()
    {
        $annonces = Annonce::all();
        $user = auth()->user();
        $countries = Country::all();


        return view('guest.index', [
            'annonces' => $annonces,
            'user' => $user,
            'countries' => $countries,
        ]);
    }

    /**
     * Show the form for creating a new guest.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created guest in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified guest.
     */
    public function show($id, $reservationId)
    {
        $guest = User::find($id);
        $host = Host::where('user_id', Auth::user()->id)->first();
        $evaluations = $guest->guestReviewsReceived;

        // Trouvez la réservation spécifique en utilisant l'ID de la réservation
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', $guest->id)
            ->whereHas('annonce', function ($query) use ($host) {
                $query->where('host_id', $host->id);
            })
            ->where('status', 'active')
            ->first();

        // Vérifiez si l'hôte a déjà évalué cette réservation
        $existingEvaluation = null;
        if ($reservation) {
            $existingEvaluation = Evaluation::where('reservation_id', $reservation->id)
                ->where('reviewer_id', $host->user_id) // Vérifiez l'évaluation de l'hôte
                ->first();
        }

        return view('guest.show', [
            'guest' => $guest,
            'host' => $host,
            'reservation' => $reservation,
            'existingEvaluation' => $existingEvaluation,
            'evaluations' => $evaluations,
        ]);
    }

    /**
     * Show the form for editing the specified guest.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified guest in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified guest from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeEvaluation(Request $request)
    {
        try {
            $decryptedReservationId = decrypt($request->input('reservation_id'));
            $decryptedGuestId = decrypt($request->input('guest_id'));
            $decryptedHostId = decrypt($request->input('host_id'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->withErrors(['msg' => 'Invalid encrypted data']);
        }

        // Vérifiez si une évaluation existe déjà pour cette combinaison hôte-réservation
        $existingEvaluation = Evaluation::where('reservation_id', $decryptedReservationId)
            ->where('reviewer_id', $decryptedHostId)
            ->first();

        if ($existingEvaluation) {
            return back()->withErrors(['msg' => 'You have already submitted an evaluation for this reservation.']);
        }

        // Mettez à jour la requête avec les ID déchiffrés
        $request->merge([
            'reservation_id' => $decryptedReservationId,
            'reviewer_id' => $decryptedHostId,
            'reviewee_id' => $decryptedGuestId
        ]);

        // Validez les données
        $validatedData = $request->validate([
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:255'],
            'reviewer_id' => ['required', 'integer', 'exists:users,id'],
            'reviewee_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        // Créez l'évaluation
        Evaluation::create([
            'reservation_id' => $validatedData['reservation_id'],
            'rating' => $validatedData['rating'],
            'comment' => $validatedData['comment'],
            'reviewer_id' => $validatedData['reviewer_id'],
            'reviewee_id' => $validatedData['reviewee_id'],
        ]);

        return redirect()->route('guest.show', $decryptedGuestId, $validatedData['reservation_id'])
            ->with('success', 'Evaluation submitted successfully');
    }
}
