<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Annonce;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\Language;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * @param Request $request
     * @return View profile.edit with the user's profile information
     */
    public function edit(Request $request): View
    {
        $countries = Country::all();
        $cities = City::all();

        return view('profile.edit', [
            'user' => $request->user(),
            'countries' => $countries,
            'cities' => $cities
        ]);
    }

    /**
     * Update the user's profile information.
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse with a status message 'profile-updated'
     *
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Update the user's information
        $request->user()->fill($request->validated());

        // If the email has changed, we need to reset the email_verified_at column
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Get the country, city and language ids
        $country = Country::where('name', $request->input('country_name'))->first();
        $city = City::where('name', $request->input('city_name'))->first();
        $language = Language::where('code', $request->input('language_code'))->first();

        //set the country, city and language ids
        $countryId = $country->id;
        $cityId = $city->id;
        $languageId = $language->id;

        // Update the user's country, city and language
        $request->user()->country_id = $countryId;
        $request->user()->city_id = $cityId;
        $request->user()->language_id = $languageId;

        // Update the user's profile picture
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture
            $file = $request->file('profile_picture');

            // Generate a unique name for the image
            $nameAndExtention = generateUniqueImageName($file);
            // Get the name without the extention
            $uniqueName = explode('.', $nameAndExtention);
            $uniqueName = $uniqueName[0];
            // Move the file to the public folder
            $file->move(public_path('img/profiles'), $nameAndExtention);


            $request->user()->profile_picture = $uniqueName;
        }

        $request->user()->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     * @param Request $request
     * @return RedirectResponse to the home page
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id)->get();
        // Trouver les IDs des annonces liées aux réservations de l'utilisateur
        $annonceIds = $reservations->pluck('annonce_id');

        //evaluations for user guest profile
        $evaluations = $user->hostReviewsReceived()->get();
        $evaluationsAverage = round($evaluations->avg('rating'));
        // Récupérer la prochaine annonce
        $nextAnnonce = Annonce::whereIn('id', $annonceIds)->nextAnnonce()->first();

        // Récupérer les trois dernières annonces passées
        $pastAnnonces = Annonce::whereIn('id', $annonceIds)->past3Annonces();

        return view('profile.show', [
            'user' => $user,
            'reservations' => $reservations,
            'nextAnnonce' => $nextAnnonce,
            'pastAnnonces' => $pastAnnonces,
            'evaluations' => $evaluations,
            'evaluationsAverage' => $evaluationsAverage
        ]);
    }
}
