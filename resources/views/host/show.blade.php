<x-app-layout>
    <section class="p-6 mt-6 rounded-lg w-3/4 justify-center mx-auto">
        <div class="flex gap-6 items-center">
            <img src="{{ image_path($user->profile_picture) }}" alt="Profile picture" class="w-32 h-32 rounded-full border-2 border-gray-300">
            <div>
                <p class="text-2xl font-bold text-gray-800">{{$user->firstname}} {{$user->lastname}}</p>
                <p class="text-sm text-red-750">{{$user->country->name}}, {{$user->city->name}}</p>
            </div>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-700">@lang('content.about') {{$user->firstname}}</h2>
            <p class="mt-3 text-gray-600">{{$user->host->bio}}</p>
        </div>
    </section>
    <section class="mt-8">
        <div class="mb-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Annonces de {{$user->firstname}}</h2>
        </div>
        <div>
            @if($annonces->count() > 0)
                <div class="flex flex-wrap md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                    @foreach($annonces as $annonce)
                        <div class="border border-gray-200 rounded-lg shadow-lg p-5 bg-white transform transition-transform hover:scale-105 w-full max-w-xs mx-auto">
                            <div class="flex flex-col items-center">
                                <p class="underline mb-2 text-xl font-bold text-gray-800">
                                    <a href="{{ route('annonce.show', $annonce->id) }}" class="text-orange-600 hover:text-orange-800">{{ $annonce->title }}</a>
                                </p>
                                <img src="{{ asset($annonce->pictures[0]->path) }}" class="rounded-lg shadow-md mb-4">
                                <p class="text-lg font-medium text-gray-700">{{ $annonce->price }} €</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
