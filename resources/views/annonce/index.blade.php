<x-app-layout>

    <div class="flex justify-center">
        <form action="{{ route('annonce.search_by_country') }}" method="get">
            <div class="inline-flex gap-5">
                <!-- Input pour sélectionner le pays -->
                <input list="countryList" class="block mt-1 select" id="country" name="country_name"
                       placeholder="@lang('annonce.actions.search_by_country')">

                <!-- Liste des pays dans le datalist -->
                <datalist id="countryList">
                    @foreach($countries as $country)
                        <option value="{{ $country->name }}" data-id="{{ $country->id }}"></option>
                    @endforeach
                </datalist>

                <!-- Bouton pour soumettre la recherche -->
                <button type="submit" class="btn-validate">@lang('content.search')</button>
            </div>
        </form>
    </div>

    <h1 class="text-3xl font-bold my-6 text-center text-red-750">@lang('content.our_best_host')</h1>


    <!--best host-->
    <div class="flex flex-wrap justify-center gap-5">
        @foreach($firstAdTable as $firstAd)
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
                                <p class="text-red-750 text-sm">{{ __('country.'. $firstAd->host->user->country->iso2) }}
                                    ,
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
        @endforeach
    </div>

    @if(isset($user->country))

        <h1 class="text-3xl font-bold my-6 text-center text-red-750">@lang('annonce.list') @lang('content.in') {{__('country.'.$user->country->iso2)}}</h1>
        <!--user country Ads-->
        <div class="flex flex-wrap justify-center gap-5">
            @foreach($annonceByCountry as $annonce)
                <div class="border border-gray-300 rounded-lg shadow-lg w-1/4 p-5 bg-white">
                    <div class="flex flex-col">
                        <div class="flex mb-4">
                            <img src="{{ asset($annonce->host->user->profile_picture) }}"
                                 class="w-16 h-16 rounded-full mr-4">
                            <div class="flex flex-col">
                                <p class="font-medium"><a
                                        href="{{route('host.show', $annonce->host->id)}}">{{ $annonce->host->user->firstname }}</a>
                                </p>
                                <p class="text-red-750 text-sm">{{ __('country.'. $firstAd->host->user->country->iso2) }}
                                    , {{ $annonce->host->user->city->name }}</p>
                                <p class="text-sm">{{$annonce->price}} €</p>

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
    @endif
    <h1 class="text-3xl font-bold my-6 text-center text-red-750">@lang('annonce.list')</h1>
    {{ $annonces->links() }}
    <div class="flex flex-wrap justify-center gap-5">
        @foreach($annonces as $annonce)
            <div class="border border-gray-300 rounded-lg shadow-lg w-1/4 p-5 bg-white">
                <div class="flex flex-col">
                    <div class="flex mb-4">
                        <img src="{{ asset($annonce->host->user->profile_picture) }}"
                             class="w-16 h-16 rounded-full mr-4">
                        <div class="flex flex-col">
                            <p class="font-medium"><a
                                    href="{{route('host.show', $annonce->host->id)}}">{{ $annonce->host->user->firstname }}</a>
                            </p>
                            <p class="text-red-750 text-sm">{{ __('country.'. $firstAd->host->user->country->iso2) }}
                                , {{ $annonce->host->user->city->name }}</p>
                            <p class="text-sm">{{$annonce->price}} €</p>

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
    <div class="mt-5">
        {{ $annonces->links() }}
    </div>
</x-app-layout>
