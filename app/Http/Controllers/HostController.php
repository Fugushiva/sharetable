<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHostRequest;
use App\Mail\HostProfileCreated;
use App\Models\Annonce;
use App\Models\BookingCode;
use App\Models\Evaluation;
use App\Models\Host;
use App\Models\Profile;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\NewNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Nnjeim\World\Models\City;


class HostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $this->authorize('create', Host::class);

        $cities = city::with('country')->where('country_id', '=', $request->user()->country_id)->get();


        return view('host.create', [
            'cities' => $cities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHostRequest $request)
    {

        $user = User::find(auth()->id());

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');


            $nameAndExtention = generateUniqueImageName($file);
            // Get the name without the extention
            $uniqueName = explode('.', $nameAndExtention)[0];
            $file->move(public_path('img/host'), $nameAndExtention);

            $validated['profile_picture'] = $uniqueName;
        }


        $host = Host::create($validated);
        $host->save();

        $hostProfile = Profile::where('profile', 'host')->first();
        $user->profiles()->attach($hostProfile->id);

        Mail::to($user->email)->send(new HostProfileCreated($user));

        $notifMessage = 'Vous avez créer votre profil hôte';
        $user->notify(new NewNotification($notifMessage));

        return redirect()->route('annonce.index');

    }

    /**
     * Display the specified resource.
     * @param Host $host
     */
    public function show(Host $host)
    {
        $user = User::find($host->user_id); // host user
        $guest = Auth::user(); // guest user
        $evaluationsPerPage = $user->paginatedGuestReviewsReceived(5);
        $annonces = $host->annonces()->with('pictures')->get();


        // Get the booking code
        $sessionBookingCode = Session::get('booking_code');
        $bookingCode = BookingCode::where('code', $sessionBookingCode)->first();

        // Get the reservation if the booking code is validated
        if ($bookingCode && $bookingCode->validated) {
            $reservation = Reservation::where('user_id', $guest->id)
                ->where('status', 'active')
                ->where('id', $bookingCode->reservation_id)
                ->first();
        } else {
            $reservation = null;
        }

        // Check if the guest has already evaluated the host
        if($reservation) {
            $existingEvaluation = Evaluation::where('reservation_id', $reservation->id)
                ->where('reviewer_id', $guest->id)
                ->where('reviewee_id', $user->id)
                ->first();
        }

        $evaluations = $user->guestReviewsReceived()->get();
        $evaluationsAverage = round($evaluations->avg('rating'));




        return view('host.show', [
            'host' => $host,
            'guest' => $guest,
            'annonces' => $annonces,
            'evaluations' => $evaluationsPerPage,
            'bookingCode' => $bookingCode,
            'reservation' => $reservation,
            'evaluationsAverage' => $evaluationsAverage,
            'showForm' => $bookingCode && $bookingCode->validated && $reservation,
            'existingEvaluation' => $existingEvaluation ?? null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Host $host)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Host $host)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Host $host)
    {
        //
    }

    /**
     * Display the host profile of the connected user
     * @param Request $request
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $annonces = Annonce::where('host_id', $user->host->id)
            ->where('status', 'active')
            ->get();

        $evaluations = $user->guestReviewsReceived()->get();
        $evaluationsAverage = round($evaluations->avg('rating'));

        return view('host.profile', [
            'user' => $user,
            'annonces' => $annonces,
            'evaluations' => $evaluations,
            'evaluationsAverage' => $evaluationsAverage

        ]);
    }
}
