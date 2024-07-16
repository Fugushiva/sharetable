<x-app-layout>
    <section class="relative w-full h-auto flex items-center justify-center">
        <div class="relative w-full max-w-screen-xl overflow-hidden">
            <img src="{{ asset('img/site/guest/cooking_person_red.webp') }}" alt="Cooking Person"
                 class="w-full h-[70vh] object-cover object-bottom rounded mt-10">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center p-4 mt-32">
                <h1 class="text-4xl font-bold">@lang('content.welcome_back') {{$user->firstname}}</h1>
                <p class="mt-4 text-lg">@lang('content.find_and_book')</p>
                <!--formulaire de recherche-->
                <div class="mt-8 flex flex-col items-center gap-2">
                    <form method="GET" action="{{ route('annonce.search') }}" class="flex flex-col gap-2 w-full max-w-md">
                        @csrf
                        <input type="text" placeholder="@lang('annonce.cuisine')" class="text-black input" name="cuisine">

                        <!-- Champs supplémentaires cachés -->
                        <div id="extra-fields" class="hidden flex-col gap-2 transition-all duration-300">
                            <!-- Date -->
                            <div>
                                <input type="date" placeholder="" class="text-black input" name="date">
                            </div>
                            <!-- Prix -->
                            <div class="">
                                <input type="number" placeholder="@lang('annonce.price_max')" class="text-black input w-1/4" name="price_max">
                            </div>
                            <!-- max guest -->
                            <div class="">
                                <input type="number" placeholder="@lang('annonce.guest_max')" class="text-black input w-1/4" name="guest_max">
                            </div>

                            <!-- Pays -->
                            <div>
                                <input list="countryList" placeholder="country select" name="country" class="text-black select">
                                <datalist id="countryList">
                                    @foreach($countries as $country)
                                        <option data-id="{{$country->id}}" value="{{ $country->name }}">
                                    @endforeach
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button class="btn-validate">@lang('content.search')</button>
                            <button type="button" class="btn-secondary" id="more-button">@lang('content.more')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Liste des annonces-->
    <h1 class="text-3xl font-bold mb-6 text-center">@lang('annonce.announce_list')</h1>
    <div class="flex flex-wrap justify-center gap-5">
        @foreach($annonces as $annonce)
            <div class="border border-gray-300 rounded-lg shadow-lg w-1/4 p-5 bg-white">
                <div class="flex flex-col items-center">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset($annonce->host->user->profile_picture) }}"
                             class="w-16 h-16 rounded-full mr-4">
                        <div class="flex flex-col">
                            <p class="font-medium"><a
                                    href="{{route('host.show', $annonce->host->id)}}">{{ $annonce->host->user->firstname }}</a>
                            </p>
                            <p class="text-red-500 text-sm">{{ $annonce->host->user->country->name }}
                                , {{ $annonce->host->user->city->name }}</p>
                            <p class="text-sm">{{$annonce->price}} €</p>

                        </div>
                    </div>
                    <p class="underline mb-2">
                        <a href="{{ route('annonce.show', $annonce->id) }}"
                           class="text-orange-600 hover:text-orange-800">{{ $annonce->title }}</a>
                    </p>
                    <img src="{{ asset($annonce->pictures[0]->path) }}" class="w-full h-48 object-cover rounded ">
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.getElementById('more-button').addEventListener('click', function() {
            let extraFields = document.getElementById('extra-fields');

            if (extraFields.classList.contains('hidden')) {
                extraFields.classList.remove('hidden');
                extraFields.classList.add('flex');
            } else {
                extraFields.classList.add('hidden');
                extraFields.classList.remove('flex');
            }
        });
    </script>
</x-app-layout>
