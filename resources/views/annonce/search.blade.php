<x-app-layout>
    <!-- Formulaire de recherche -->
    <div class="bg-gray-100 p-6 rounded-lg shadow-lg mb-6">
        <h2 class="font-bold text-lg mb-4">Filtrer les résultats</h2>
        <form action="{{ route('annonce.search',  ['country' => $selected_country->id]) }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <!-- Filtre par cuisine -->
            <div>
                <label for="cuisine" class="block mb-2 text-sm font-medium text-gray-700">Type de Cuisine</label>
                <select name="cuisine" id="cuisine"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Toutes les cuisines</option>
                    @foreach($countries as $cuisine)
                        <option value="{{ $cuisine->name }}">{{ __('country.'. $cuisine->iso2) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par nombre de places disponibles -->
            <div>
                <label for="guest_max" class="block mb-2 text-sm font-medium text-gray-700">Nombre de places</label>
                <input type="number" id="guest_max" name="guest_max" min="1" max="8"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="Nombre de places disponibles">
            </div>

            <!-- Filtre par date -->
            <div>
                <label for="date" class="block mb-2 text-sm font-medium text-gray-700">Date</label>
                <input type="date" id="date" name="date"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <!-- Filtre par prix -->
            <div>
                <label for="price_max" class="block mb-2 text-sm font-medium text-gray-700">prix max</label>
                <input type="number" id="price_max" name="price_max"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="prix maximum €">
            </div>

            <!-- Bouton de recherche -->
            <div class="flex items-end">
                <button type="submit"
                        class="btn-validate text-white px-4 py-2 rounded-lg hover:bg-red-600 transition w-full">
                    Rechercher
                </button>
            </div>

        </form>
    </div>
    <section>
        <div class="flex flex-wrap justify-center gap-5">
            @foreach($annonces as $annonce)
                <div class="border border-gray-300 rounded-lg shadow-lg w-1/4 p-5 bg-white">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <!-- Profil utilisateur à gauche -->
                            <div class="flex items-center">
                                <img src="{{ asset($annonce->host->user->profile_picture) }}"
                                     class="w-16 h-16 rounded-full mr-4">
                                <div class="flex flex-col">
                                    <p class="font-medium">
                                        <a href="{{ route('host.show', $annonce->host->id) }}">{{ $annonce->host->user->firstname }}</a>
                                    </p>
                                    <p class="text-red-750 text-sm">{{ __('country.'. $annonce->host->user->country->iso2) }}
                                        ,
                                        {{ $annonce->host->user->city->name }}</p>
                                </div>
                            </div>

                            <!-- Prix et cuisine à droite -->
                            <div class="text-right">
                                <!-- Prix avec icône à gauche -->
                                <div class="flex items-center justify-end">
                                <span class="text-red-500 mr-2">
                                    <i class="fa-solid fa-dollar-sign text-red-750 text-sm"></i>
                                </span>
                                    <p class="text-sm">{{ $annonce->price }} €</p>
                                </div>

                                <!-- Cuisine avec icône à gauche -->
                                <div class="flex items-center justify-end">
                                <span class="text-red-500 mr-2">
                                    <i class="fa-solid fa-bowl-food text-red-750 text-sm"></i>
                                </span>
                                    <p class="text-sm">Cuisine : {{ __('country.'. $annonce->cuisine) }}</p>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-sans text-md text-red-750">{{ $annonce->title }}</h2>
                        <a href="{{ route('annonce.show', $annonce->id) }}"
                           class="block w-full h-48 overflow-hidden rounded">
                            <img src="{{ asset($annonce->pictures[0]->path) }}" class="w-full h-full object-cover">
                        </a>

                    </div>
                </div>
            @endforeach
        </div>
</x-app-layout>

