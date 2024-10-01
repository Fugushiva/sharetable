<x-app-layout>
    <section class="flex flex-col bg-gradient-to-r p-8">
        <!-- Titre de l'annonce -->
        <h2 class="text-4xl font-bold text-center">{{$annonce->title}}</h2>

        <div class="border border-solid border-red-750 w-3/4 mx-auto my-5"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 mx-auto w-full sm:w-3/4">
        <div class="flex flex-col gap-4">
                <!-- Max guest -->
                <div class="flex items-center">
                    <span class="text-red-500 mr-2">
                        <i class="fa-solid fa-users text-red-750 text-3xl"></i>
                    </span>
                    <p class="text-2xl text-gray-600">{{ trans_choice('annonce.guest_max', $annonce->max_guest, ['count' => $annonce->max_guest]) }}</p>
                </div>
                <!-- price -->
                <div class="flex items-center">
                    <span class="text-red-500 mr-2">
                        <i class="fa-solid fa-dollar-sign text-red-750 text-3xl"></i>
                    </span>
                    <p class="text-2xl text-gray-600">{{$annonce->price}}€ {{__('annonce.per_guest')}}</p>
                </div>
                <!-- schedule -->
                <div class="flex items-center">
                    <span class="text-red-500 mr-2">
                      <i class="fa-solid fa-calendar-days text-red-750 text-3xl"></i>
                    </span>
                    <p class="text-gray-700 text-2xl  leading-relaxed">{{__('content.the')}} {{substr($annonce->schedule, 0, -8)}} {{__('content.at')}} {{substr($annonce->schedule, -8)}}</p>
                </div>
                <!-- cuisine -->
                <div class="flex items-center">
                    <span class="text-red-500 mr-2">
                      <i class="fa-solid fa-bowl-food text-red-750 text-3xl"></i>
                    </span>
                    <p class="text-gray-700 text-2xl leading-relaxed">Dîner, {{__('country.'. $annonce->cuisine)}}</p>
                </div>
            </div>
            <div class="flex items-start">
                <p class="text-gray-700 text-2xl leading-relaxed mb-8 text-left break-words w-3/4">
                    {{$annonce->description}}
                </p>
            </div>
        </div>

        <div class="border border-solid border-red-750 w-3/4 mx-auto my-5"></div>

        <!-- pictures carousel -->
        <div class="relative w-3/4 mx-auto h-full flex items-center justify-center p-4 bg-white shadow-lg rounded-lg">
            <div class="swiper-container w-full h-full overflow-hidden rounded-lg">
                <div class="swiper-wrapper">
                    <!-- Pictures -->
                    @foreach($annonce->pictures as $picture)
                        <div class="swiper-slide flex justify-center items-center">
                            <img class="w-full h-64 object-cover rounded-lg" src="{{ asset($picture->path) }}" alt="Photo de l'annonce">
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Navigation -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>

    <!-- Check if guest went to host -->
    <section class="flex flex-col w-full justify-center">
        @if($currentHost && $currentHost->id === $annonce->host_id)
            <div class="flex flex-col gap-4 p-4 bg-gray-100 rounded-lg shadow-md shadow-red-750 w-full sm:w-2/3 lg:w-1/3 mx-auto">
                <h2 class="text-2xl mb-4 text-center">{{__('annonce.show.guest_code')}}</h2>
                <p class="text-lg font-semibold text-gray-800">
                    {{__('annonce.show.code_validation')}}
                </p>
                <form method="post" action="{{route('reservation.code')}}" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="annonce_id" value="{{$annonce->id}}">
                    <input
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        type="text" name="code" placeholder="{{__('annonce.show.enter_code')}}">
                    <button class="btn-validate">Envoyer</button>
                </form>
            </div>
            @if($reservations)
                <div class="overflow-x-auto mx-auto w-full sm:w-3/4 lg:w-2/3 mt-8">
                    <h2 class="text-2xl mb-4 text-center">{{__('annonce.guest_list')}}</h2>
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead class="bg-red-750 text-white">
                        <tr>
                            <th class="px-6 py-2 border-b border-gray-300">{{__('forms.profile_picture')}}</th>
                            <th class="px-6 py-2 border-b border-gray-300">{{__('forms.Firstname')}}</th>
                            <th class="px-6 py-2 border-b border-gray-300">{{__('forms.Lastname')}}</th>
                            <th class="px-6 py-2 border-b border-gray-300">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td class="text-center border-b border-gray-300">
                                    <img src="{{asset($reservation->user->profile_picture)}}"
                                         class="rounded-full w-12 h-12 mx-auto">
                                </td>
                                <td class="px-4 py-2 border-b border-gray-300">{{$reservation->user->firstname}}</td>
                                <td class="px-4 py-2 border-b border-gray-300">{{$reservation->user->lastname}}</td>
                                <td class="px-4 py-2 border-b border-gray-300">
                                    <a href="{{ route('guest.show', ['id' => $reservation->user->id, 'reservationId' => $reservation->id]) }}"
                                       class="text-red-750 text-sm hover:underline">
                                        {{__('annonce.show.see_profile')}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @elseif(Auth::check())
            <div class="w-full flex justify-center mt-8">
                <a class="btn-validate" href="{{route('book.create', $annonce->id)}}">@lang('content.book')</a>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3 w-full sm:w-2/3 lg:w-1/3 mx-auto">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>
    <x-footer />
</x-app-layout>
