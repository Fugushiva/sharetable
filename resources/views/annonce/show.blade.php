<x-app-layout>
    <section class="flex flex-col items-center bg-gradient-to-r  p-8">
        <!-- Titre de l'annonce -->
        <h2 class="text-4xl font-bold  mb-6">{{$annonce->title}}</h2>

        <div class="flex gap-6 mb-8">
            <div
                class="border border-solid border-red-750 rounded-lg p-6 bg-white shadow-lg transition-transform transform hover:scale-105">
                <p class="text-lg text-gray-600">{{ trans_choice('annonce.max_guest', $annonce->max_guest, ['count' => $annonce->max_guest]) }}</p>
            </div>
            <div
                class="border border-solid border-red-750 rounded-lg p-6 bg-white shadow-lg transition-transform transform hover:scale-105">
                <p class="text-lg text-gray-600">{{$annonce->price}}€ {{__('annonce.per_guest')}}</p>
            </div>
            <div
                class="border border-solid border-red-750 rounded-lg p-6 bg-white shadow-lg transition-transform transform hover:scale-105">
                <p class="text-gray-700 text-lg leading-relaxed">{{__('content.the')}} {{substr($annonce->schedule,0, -8)}} {{__('content.at')}} {{substr($annonce->schedule,-8,8)}}</p>
            </div>
        </div>

        <!-- Description de l'annonce -->
        <p class="text-gray-700 text-lg leading-relaxed mb-8 text-center max-w-2xl">{{$annonce->description}}</p>

        <!-- Photos de l'annonce -->
        <div class="flex justify-center gap-4 mb-8">
            @foreach($annonce->pictures as $picture)
                <div class="overflow-hidden rounded-lg shadow-md group">
                    <img class="w-full h-64 object-cover" src="{{asset($picture->path)}}" alt="Photo de l'annonce">
                </div>
            @endforeach
        </div>
        <!-- Bouton supprimer si c'est l'auteur de l'annonce -->
        @if($currentHost && $currentHost->id === $annonce->host_id)
            <div class="flex gap-4">
                <form method="post" action="{{route('annonce.destroy', $annonce)}}" class="flex gap-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-750 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-850 transition-colors">{{__('forms.delete_ad')}}</button>
                </form>
            </div>
            <!-- Bouton réserver -->
        @elseif(Auth::check())
            <a class="btn-validate" href="{{route('book.create', $annonce->id)}}">@lang('content.book')</a>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </section>
</x-app-layout>
