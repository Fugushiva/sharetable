<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserRegistered;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\Language;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = Country::all();
        $cities = City::all();
        $languages = Language::whereIn('name',['French', 'English'])->get();

        return view('auth.register', [
            'countries' => $countries,
            'cities' => $cities,
            'languages'=> $languages
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country_name' => ['required', 'exists:countries,name' ],
            'city_name' => ['required', 'exists:cities,name' ],
            'language_name' => ['required', 'exists:languages,name_native']
        ]);

        $country = Country::where('name', $request->input('country_name'))->first();
        $countryId = $country->id;

        $city = City::where('name', $request->input('city_name'))->first();
        $cityId = $city->id;

        $language = Language::where('name_native', $request->input('language_name'))->first();
        $languageId = $language->id;

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_id' => $countryId,
            'city_id' => $cityId,
            'language_id' => $languageId,
        ]);

        $guestProfile = Profile::where('profile', 'guest')->first();
        $user->profiles()->attach($guestProfile);


        //Mail::to($user->email)->send(new UserRegistered($user));

        //event(new Registered($user));

        Auth::login($user);

        return redirect(route('welcome', absolute: false));
    }

    public function getCities($country_id)
    {
        try {
            $cities = City::where('country_id', $country_id)->pluck('name');
            return response()->json($cities);
        } catch (\Exception $e) {
            \Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['error' => 'Could not fetch cities'], 500);
        }
    }
}
