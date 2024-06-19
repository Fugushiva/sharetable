<x-app-layout>
    <section class="flex flex-col items-center bg-gray-100 p-8">
        <!-- Titre de l'annonce -->
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">{{$annonce->title}}</h2>

        <div class="flex gap-6 mb-6">
            <div class="border border-solid border-red-500 rounded-lg p-4 bg-white shadow-md">
                <p class="text-lg text-gray-600">{{ trans_choice('annonce.max_guest', $annonce->max_guest, ['count' => $annonce->max_guest]) }}</p>
            </div>
            <div class="border border-solid border-red-500 rounded-lg p-4 bg-white shadow-md">
                <p class="text-lg text-gray-600">{{$annonce->price}}€ {{__('annonce.per_guest')}}</p>
            </div>
            <div class="border border-solid border-red-500 rounded-lg p-4 bg-white shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-6">{{__('content.the')}} {{substr($annonce->schedule,0, -8)}} {{__('content.at')}} {{substr($annonce->schedule,-8,8)}}</p>
            </div>
        </div>

        <!-- Description de l'annonce -->
        <p class="text-gray-700 text-lg leading-relaxed mb-6">{{$annonce->description}}</p>

        <!-- Horaire de l'annonce -->


        <!-- Photo de l'annonce -->
        <div class="mb-6">
            <img class="rounded-lg shadow-lg" src="{{asset('/img/annonces/'.$annonce->picture_name)}}" alt="Photo de l'annonce">
        </div>
    </section>
</x-app-layout>
