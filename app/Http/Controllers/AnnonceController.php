<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnonceRequest;
use App\Models\Annonce;
use App\Models\Host;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Nnjeim\World\Models\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AnnonceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the ad.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $annonces = Annonce::with('host', 'host.user', 'pictures')->get(); // Récupère toutes les annonces avec les informations de l'hôte et de l'utilisateur

        return view('annonce.index', [
            'annonces' => $annonces
        ]);
    }

    /**
     * Display the form to create a new ad.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Annonce::class);

        $countries = Country::all();

        return view('annonce.create',[
            'countries' => $countries
        ]);
    }

    /**
     *  Store a newly created ad in storage.
     *  @param StoreAnnonceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnnonceRequest $request)
    {
        // Récupère l'hôte qui a créé l'annonce
        $host = Host::where('user_id', auth()->id())->first();
        $user = User::find(auth()->id());

        $validated = $request->validated();
        $validated['host_id'] = $host->id;
        $validated['country_id'] = $user->country_id;

        $annonce = Annonce::create($validated);

        // Enregistre les images dans le dossier public/img/annonces/{id_annonce}
        if ($request->hasFile('pictures')) {
            $annonce->uploadPictures($request->file('pictures'));
        }
        return redirect()->route('annonce.index')->with('success', 'Annonce créée avec succès');
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $id)
    {
        // Récupère l'utilisateur connecté & l'hôte connecté
        $current_user = Auth::user();
        $current_host = Host::where('user_id', $current_user->id)->first();


        $annonce = Annonce::with('pictures')->find($id);

        // Récupère l'hôte de l'annonce & l'utilisateur qui a créé l'annonce
        $host = Host::with('user')->where('id',"=", $annonce->host_id)->first();
        $user = User::where('id', '=', $host->user_id)->first();

        return view('annonce.show', [
            'annonce' => $annonce,
            'host' => $host,
            'user' => $user,
            'currentHost' => $current_host
        ]);
    }

    /**
     * Show the form for editing the specified ad.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified ad in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified ad from storage.
     */
    public function destroy(string $id)
    {
        $annonce = Annonce::findOrfail($id);

        // Vérifie si l'utilisateur connecté peut supprimer l'annonce
        $this->authorize('delete', $annonce);

        $directory = storage_path('app/public/img/annonces/' . $id);
        // Supprime le dossier et son contenu de manière récursive
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }

        $annonce->delete();

        return redirect()->route('annonce.index')->with('success', 'Annonce supprimée avec succès');
    }
}
