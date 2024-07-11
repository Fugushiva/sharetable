<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHostRequest;
use App\Mail\HostProfileCreated;
use App\Models\Host;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;

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

        Mail::to($user->email)->send(new HostProfileCreated($user));

        return redirect()->route('annonce.index');

    }

    /**
     * Display the specified resource.
     * @param Host $host
     */
    public function show(Host $host)
    {
        $user = User::find($host->user_id);
        $annonces = $host->annonces()->with('pictures')->get();

        return view('host.show', [
            'host' => $host,
            'user' => $user,
            'annonces' => $annonces
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

        return view('host.profile', [
            'user' => $user
        ]);
    }
}
