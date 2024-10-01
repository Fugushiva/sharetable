<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-4">Profil de l'invité</h1>
        <p class="text-center text-gray-700 mb-6">Découvrez les informations et évaluations de l'invité.</p>

        <!--Guest informations-->
        <section class="p-6 mt-6 rounded-lg w-3/4 mx-auto bg-gray-50 shadow-lg">
            <div class="flex gap-6 items-center">
                <img src="{{ asset($guest->profile_picture) }}" alt="Profile picture de {{$guest->firstname}}"
                     class="w-32 h-32 rounded-full border-2 border-gray-300">
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{$guest->firstname}} {{$guest->lastname}}</p>
                    <p class="text-sm text-red-750">{{$guest->country->name}}, {{$guest->city->name}}</p>
                </div>
            </div>
            <div class="mt-6">
                <h2 class="text-xl font-bold text-gray-700">@lang('content.about') {{$guest->firstname}}</h2>
                <p class="mt-3 text-gray-600">{{$guest->bio}}</p>
            </div>
        </section>

        <!--Evaluations-->
        <section class="mt-8 w-3/4 mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Evaluations</h2>

            <!--create evaluation form-->
            @if(!$existingEvaluation)
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-center text-gray-800">Évaluer {{$guest->firstname}}</h2>
                    @if(session('success'))
                        <div class="alert alert-success p-4 mb-4 rounded-md bg-green-100 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger p-4 mb-4 rounded-md bg-red-100 text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{route('guest.evaluation.store', $reservation->id)}}" method="POST"
                          class="flex flex-col items-center bg-gray-50 p-6 rounded-lg shadow-md">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-4 mb-4 w-full max-w-lg">
                            <div class="flex-1">
                                <label for="rating" class="block text-gray-700">Note:</label>
                                <input type="number" name="rating" id="rating" min="1" max="5"
                                       class="input w-24 mt-1 p-2 border border-gray-300 rounded-md" required>
                            </div>
                            <div class="flex-1">
                                <label for="comment" class="block text-gray-700">Commentaire:</label>
                                <textarea name="comment" id="comment"
                                          class="input w-full mt-1 p-2 border border-gray-300 rounded-md"
                                          required></textarea>
                            </div>
                            <div>
                                <input type="hidden" name="reservation_id" value="{{ encrypt($reservation->id) }}">
                                <input type="hidden" name="guest_id" value="{{ encrypt($guest->id) }}">
                                <input type="hidden" name="host_id" value="{{ encrypt($host->id) }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-validate hover:bg-red-800 transition">Soumettre</button>
                    </form>
                </div>
            @elseif(!$reservation)
                    <p>No active reservation found with this guest.</p>
            @elseif($existingEvaluation)
                    <p>You have already submitted an evaluation for this reservation.</p>
        @endif

    </div>
    <section class="p-6 mt-6 rounded-lg w-3/4 mx-auto bg-gray-50 shadow-lg">
        <div class="space-y-4">
            @foreach($evaluations as $evaluation)
                <div class="border border-gray-200 rounded-lg shadow-lg p-4 bg-white flex items-start">
                    <img src="{{ asset($evaluation->reviewer->profile_picture) }}" alt="Reviewer profile picture"
                         class="w-16 h-16 rounded-full border-2 border-gray-300 mr-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">{{ $evaluation->reviewer->firstname}}</p>
                        <p class="text-red-750 text-sm">{{ $evaluation->reviewer->country->name}}</p>
                        <p class="text-gray-600 mt-2">{{ $evaluation->comment }}</p>
                        <div class="flex items-center mt-2">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $evaluation->rating)
                                    <svg class="w-5 h-5 text-red-750" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </section>
    <x-footer />
</x-app-layout>
