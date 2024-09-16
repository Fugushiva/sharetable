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
                <x-ad-card :firstAd="$annonce" />
            @endforeach
        </div>
</x-app-layout>

