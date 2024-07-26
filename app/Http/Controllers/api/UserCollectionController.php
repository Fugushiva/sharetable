<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return new UserCollection($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function userReservations(string $id)
    {
        $user = User::findOrFail($id);
        $reservations = $user->reservations;
        return $reservations->toJson();
    }

    public function userAnnonces(string $id)
    {
        $user = User::findOrFail($id);
        $annonces = $user->host->annonces;
        return $annonces->toJson();
    }

    public function userTransactions(string $id)
    {
        $user = User::findOrFail($id);
        //transactions as guest
        $transactions = $user->transactions;

        return $transactions->toJson();
    }
}
