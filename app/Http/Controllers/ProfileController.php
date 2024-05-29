<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
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
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $country = Country::where('name', $request->input('country_name'))->first();
        $countryId = $country->id;

        $city = City::where('name', $request->input('city_name'))->first();
        $cityId = $city->id;

        $request->user()->country_id = $countryId;
        $request->user()->city_id = $cityId;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            $nameAndExtention = generateUniqueImageName($file);
            $uniqueName = explode('.', $nameAndExtention);
            $uniqueName = $uniqueName[0];
            $file->move(public_path('img/profiles'), $nameAndExtention);


            $request->user()->profile_picture = $uniqueName;
        }



        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
