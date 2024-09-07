<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnonceRequest;
use App\Models\Annonce;
use App\Models\Host;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use MongoDB\Driver\Session;
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
        // Get all the active ads
        $annonces = Annonce::with('host', 'host.user', 'pictures')
            ->where('status', '=', 'active')
            ->paginate(15)
            ->fragment('annonces');

        // get all the actives ads base on the user country
        $user = User::find(auth()->id());
        $annonceByCountry = Annonce::with('host', 'host.user', 'pictures')
            ->where('status', '=', 'active')
            ->where('country_id', $user->country_id)->get();

        //get first ad of our 10 best host
        $hosts = Host::all()->map(function($host) {

            $user = $host->user;
            $evaluations = $user->hostReviewsReceived()->get();
            $host->average_rating = $evaluations->avg('rating');
            return $host;
        });

        //get the 10 best host
        $bestHosts = $hosts->sortByDesc('average_rating')->take(10);

        $firstAdTable = $bestHosts->map(function($host) {
            return $host->annonces()->first();
        });




        return view('annonce.index', [
            'annonces' => $annonces,
            'annonceByCountry' => $annonceByCountry,
            'user' => $user,
            'firstAdTable' => $firstAdTable
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

        return view('annonce.create', [
            'countries' => $countries
        ]);
    }

    /**
     *  Store a newly created ad in storage.
     * @param StoreAnnonceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnnonceRequest $request)
    {

        // Récupère l'hôte qui a créé l'annonce
        $host = Host::getCurrentUser();
        $user = User::find(auth()->id());

        $validated = $request->validated();
        $validated['host_id'] = $host->id;
        $validated['country_id'] = $user->country_id;
        $validated['cuisine'] = Country::where('name', $validated['cuisine'])->first()->iso2;

        $annonce = Annonce::create($validated);

        // Enregistre les images dans le dossier public/img/annonces/{id_annonce}
        $annonce->uploadPictures($request->file('pictures'));

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
        $current_host = null;
        if ($current_user) {
            $current_host = Host::where('user_id', $current_user->id)->first();
        }



        $annonce = Annonce::with('pictures')->find($id);

        //get country with cuisine
        $annonceCuisine = Country::where('name', $annonce->cuisine)->first();


        // Récupère l'hôte de l'annonce & l'utilisateur qui a créé l'annonce
        $host = Host::find($annonce->host_id);
        $user = User::find($host->user_id);

        $reservations = Reservation::where('annonce_id', $id)
            ->where('status', 'active')
            ->get();

        return view('annonce.show', [
            'annonce' => $annonce,
            'host' => $host,
            'user' => $user,
            'currentHost' => $current_host,
            'reservations' => $reservations,
            'annonceCuisine' => $annonceCuisine
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
     * @param string $id : id de l'annonce
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception : if the ad does not exist
     * @throws \Exception : if the user didn't create the ad
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException : si le dossier de l'annonce n'existe pas
     */
    public function destroy(string $id, Request $request)
    {
        $annonce = Annonce::findOrfail($id);

        // Vérifie si l'utilisateur connecté peut supprimer l'annonce
        $this->authorize('delete', $annonce);

        $directory = storage_path('app/public/img/annonces/' . $id);

        // Supprime le dossier et son contenu de manière récursive
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }

        $annonce->status = 'deleted';
        $annonce->save();

        $request->session()->put('annonce_id', $annonce->id);
        $request->session()->put('allow_access', true);

        return redirect()->route('stripe.refundAll')->with('success', 'Annonce supprimée avec succès');
    }

    /**
     * Display the form to search for an ad.
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        $input = $request->input();
        $user = auth()->user();
        $countries = Country::all();

        $query = Annonce::query();

        // Ajoutez des conditions à la requête en fonction des champs remplis
        $this->applyFilters($query, $input);

        // Exécutez la requête pour obtenir les résultats
        $annonces = $query->get();

        return view('guest.index', [
            'annonces' => $annonces,
            'user' => $user,
            'countries' => $countries
        ]);
    }

    /**
     * Apply filters to the query
     * @param $query
     * @param $input
     */

    private function applyFilters($query, $input)
    {
        if (!empty($input['cuisine'])) {
            $query->findByCuisine($input['cuisine']);
        }

        if (!empty($input['date'])) {
            $query->whereDate('schedule', $input['date']);
        }

        if (!empty($input['price_max'])) {
            $query->findPriceBelow($input['price_max']);
        }

        if (!empty($input['guest_max'])) {
            $query->findGuestsBelow($input['guest_max']);
        }

        if (!empty($input['country'])) {
            $query->findByCountry($input['country']);
        }
        }
}
