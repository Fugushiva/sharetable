<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
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
    public function show(string $id)
    {
        //
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
}
