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
            @if(isset($firstAd->unique_title))
                <x-ad-card :firstAd="$firstAd" :uniqueTitle="$firstAd->unique_title" />
            @else
                <x-ad-card :firstAd="$firstAd" />
            @endif
        @endforeach
    </div>

    @if(isset($user->country))

        <h1 class="text-3xl font-bold my-6 text-center text-red-750">@lang('annonce.list') @lang('content.in') {{__('country.'.$user->country->iso2)}}</h1>
        <!--user country Ads-->
        <div class="flex flex-wrap justify-center gap-5">
            @foreach($annonceByCountry as $annonce)
                <x-ad-card :firstAd="$annonce" />
            @endforeach
        </div>
    @endif
    <h1 class="text-3xl font-bold my-6 text-center text-red-750">@lang('annonce.list')</h1>
    {{ $annonces->links() }}
    <div class="flex flex-wrap justify-center gap-5">
        @foreach($annonces as $annonce)
            <x-ad-card :firstAd="$firstAd" />
        @endforeach
    </div>
    <div class="mt-5">
        {{ $annonces->links() }}
    </div>
</x-app-layout>
