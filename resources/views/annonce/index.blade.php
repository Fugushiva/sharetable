<x-app-layout>
    <h1 class="text-3xl font-bold mb-6 text-center">Liste des annonces</h1>
    <div class="flex flex-wrap justify-center gap-5">
        @foreach($annonces as $annonce)
            <div class="border border-gray-300 rounded-lg shadow-lg w-1/4 p-5 bg-white">
                <div class="flex flex-col items-center">
                    <div class="flex items-center mb-4">
                        <img src="{{ image_path($annonce->host->user->profile_picture) }}" class="w-16 h-16 rounded-full mr-4">
                        <div class="flex flex-col">
                            <p class="font-medium"><a href="{{route('host.show', $annonce->host->id)}}">{{ $annonce->host->user->firstname }}</a></p>
                            <p class="text-red-500 text-sm">{{ $annonce->host->user->country->name }}, {{ $annonce->host->user->city->name }}</p>
                            <p class="text-sm">{{$annonce->price}} €</p>

                        </div>
                    </div>
                    <p class="underline mb-2">
                        <a href="{{ route('annonce.show', $annonce->id) }}" class="text-orange-600 hover:text-orange-800">{{ $annonce->title }}</a>
                    </p>
                    <img src="{{ asset($annonce->pictures[0]->path) }}" class="rounded-lg">
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
