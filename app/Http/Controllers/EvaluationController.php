<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationRequest;
use App\Mail\BookingCode;
use App\Models\Evaluation;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\NewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Decrypt encrypted data
        $decryptedReservationId = decrypt($request->input('reservation_id'));
        $decryptedReviewerId = decrypt($request->input('reviewer_id'));
        $decryptedRevieweeId = decrypt($request->input('reviewee_id'));


        // update the request with the decrypted values
        $request->merge([
            'reservation_id' => $decryptedReservationId,
            'reviewer_id' => $decryptedReviewerId,
            'reviewee_id' => $decryptedRevieweeId
        ]);

        // Validate the request
        $validatedData = $request->validate([
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:255'],
            'reviewer_id' => ['required', 'integer', 'exists:users,id'],
            'reviewee_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        // Find the reservation
        $reservation = Reservation::find($validatedData['reservation_id']);

        // check if the reservation exists
        if (!$reservation) {
            return back()->withErrors(['msg' => 'Reservation not found']);
        }

        // create the evaluation
        $evaluation = Evaluation::create([
            'reservation_id' => $reservation->id,
            'rating' => $validatedData['rating'],
            'comment' => $validatedData['comment'],
            'reviewer_id' => $validatedData['reviewer_id'],
            'reviewee_id' => $validatedData['reviewee_id'],
        ]);

        // determine the reviewee and the reviewer
        $reviewee = User::find($request->input('reviewee_id'));
        $reviewer = Auth::user();

        // determine the action link
        if ($reservation->isGuest($reviewee)) {
            $actionLink = route('guest.profile', ['id' => $reviewee->id, 'reservationid' => $reservation->id]);
        } elseif ($reservation->isHost($reviewee)) {
            $actionLink = route('host.profile', ['host' => $reviewee->id]);
        } else {
            $actionLink = route('home'); // fallback to home in case of error
        }
        // Notify the reviewee
        $reviewee->notify(new NewNotification([
            'message' => __('notification.evaluation.host', ['Name' => $reviewer->firstname]),
            'action' => $actionLink
        ]));

        // Redirigez vers la page d'accueil de l'hôte
        return redirect()->route('host.show', $reservation->annonce->host->id)
            ->with('success', 'Evaluation submitted successfully');
    }
}

