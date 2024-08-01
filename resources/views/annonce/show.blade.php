<x-app-layout>
    <section class="flex flex-col items-center bg-gradient-to-r  p-8">
        <!-- Titre de l'annonce -->
        <h2 class="text-4xl font-bold  mb-6">{{$annonce->title}}</h2>

        <div class="flex gap-6 mb-8">
            <div
                class="border border-solid border-red-750 rounded-lg p-6 bg-white shadow-lg transition-transform transform hover:scale-105">
                <p class="text-lg text-gray-600">{{ trans_choice('annonce.guest_max', $annonce->max_guest, ['count' => $annonce->max_guest]) }}</p>
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
                <form method="post" action="{{route("reservation.code")}}" class="flex gap-4">
                    @csrf
                    <input type="hidden" name="annonce_id" value="{{$annonce->id}}">
                    <input class="input" type="text" name="code" placeholder="Code">
                    <button class="btn-validate">envoyer</button>
                </form>
            </div>
            @if($reservations)
                <h2 class="text-2xl mb-4">{{__('annonce.guest_list')}}</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100">
                        <thead class="thead-dark">
                        <tr>
                            <th>{{__('forms.profile_picture')}}</th>
                            <th>{{__('forms.Firstname')}}</th>
                            <th>{{__('forms.Lastname')}}</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td class="text-center">
                                    <img src="{{asset($reservation->user->profile_picture)}}" class="rounded-circle" style="width: 50px; height: 50px;">
                                </td>
                                <td>{{$reservation->user->firstname}}</td>
                                <td>{{$reservation->user->lastname}}</td>
                                <td>
                                    <a href="{{ route('guest.show', ['id' => $reservation->user->id, 'reservationId' => $reservation->id]) }}">
                                        Voir le profil
                                    </a>
                                </td>                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif


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
