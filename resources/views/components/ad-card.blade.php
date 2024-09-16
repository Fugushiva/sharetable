<div class="border border-gray-300 rounded-lg shadow-lg w-1/4 p-5 bg-white">
    <div class="flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <!-- Profil utilisateur à gauche -->
            <div class="flex items-center">
                <img src="{{ asset($firstAd->host->user->profile_picture) }}"
                     class="w-16 h-16 rounded-full mr-4">
                <div class="flex flex-col">
                    <p class="font-medium">
                        <a href="{{ route('host.show', $firstAd->host->id) }}">{{ $firstAd->host->user->firstname }}</a>
                    </p>
                    <p class="text-red-750 text-sm">{{ __('country.'. $firstAd->host->user->country->iso2) }},
                        {{ $firstAd->host->user->city->name }}</p>
                </div>
            </div>

            <!-- Prix et cuisine à droite -->
            <div class="text-right">
                <!-- Prix avec icône à gauche -->
                <div class="flex items-center justify-end">
                    <span class="text-red-500 mr-2">
                        <i class="fa-solid fa-dollar-sign text-red-750 text-sm"></i>
                    </span>
                    <p class="text-sm">{{ $firstAd->price }} €</p>
                </div>

                <!-- Cuisine avec icône à gauche -->
                <div class="flex items-center justify-end">
                    <span class="text-red-500 mr-2">
                        <i class="fa-solid fa-bowl-food text-red-750 text-sm"></i>
                    </span>
                    <p class="text-sm">Cuisine : {{ __('country.'. $firstAd->cuisine) }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center">
            <span class="text-red-500 mr-2">
                <i class="fa-solid fa-calendar-days text-red-750 text-sm"></i>
            </span>
            <p class="text-sm">
                {{ __('content.the') }}
                {{ \Carbon\Carbon::parse($firstAd->schedule)->translatedFormat('d F Y') }}
                {{ __('content.at') }}
                {{ \Carbon\Carbon::parse($firstAd->schedule)->format('H:i') }}
            </p>
        </div>

        <h2 class="font-sans text-md text-red-750">{{ $firstAd->title }}</h2>
        <a href="{{ route('annonce.show', $firstAd->id) }}"
           class="block w-full h-48 overflow-hidden rounded">
            <img src="{{ asset($firstAd->pictures[0]->path) }}" class="w-full h-full object-cover">
        </a>
    </div>
</div>
