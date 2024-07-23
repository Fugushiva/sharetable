<x-app-layout>
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
                            <p class="text-red-750 text-sm">{{ $annonce->host->user->country->name }}
                                , {{ $annonce->host->user->city->name }}</p>
                            <p class="text-sm">{{$annonce->price}} €</p>

                        </div>
                    </div>
                    <h2 class="font-sans text-md text-red-750">{{ $annonce->title }}</h2>
                    <a href="{{ route('annonce.show', $annonce->id) }}" class="block w-full h-48 overflow-hidden rounded">
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
