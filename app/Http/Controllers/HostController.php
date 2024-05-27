<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHostRequest;
use App\Models\Host;
use Illuminate\Http\Request;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;

class HostController extends Controller
{
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



       $validated = $request->validated();
       $validated['user_id'] = auth()->id();

        $city = City::where('name', $request->input('city_name'))->first();
        if ($city) {
            $validated['city_id'] = $city->id;
        } else {
            return redirect()->back()->withErrors(['city_name' => 'Invalid city name']);
        }


        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Assurez-vous que la fonction generateUniqueImageName() est définie quelque part
            $nameAndExtention = generateUniqueImageName($file);
            $uniqueName = explode('.', $nameAndExtention)[0];
            $file->move(public_path('img/host'), $nameAndExtention);

            $validated['profile_picture'] = $uniqueName;
        }

       $host = Host::create($validated);
       $host->save();

       return redirect()->route('annonce.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Host $host)
    {
        //
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
}
