<x-app-layout>
    <!--Host informations-->
    <section class="p-6 mt-6 rounded-lg w-3/4 justify-center mx-auto">
        <div class="flex gap-6 items-center content-around">
            <img src="{{ asset($host->user->profile_picture) }}" alt="Profile picture"
                 class="w-32 h-32 rounded-full border-2 border-gray-300">
            <div>
                <p class="text-2xl font-bold text-gray-800">{{$host->user->firstname}} {{$host->user->lastname}}</p>
                <p class="text-sm text-red-750">{{$host->user->country->name}}, {{$host->user->city->name}}</p>
                <div class="mt-6">
                    <a href="{{ route('conversations.create', ['recipient_id' => $host->user->id]) }}"
                       class="btn-validate">
                        {{ __('profile.host.message') }}
                    </a>
                </div>
            </div>

            <!-- rating -->
            @if($evaluations)
                <div class="ml-auto">
                    <p class="font-bold">Rating :
                        @if($evaluationsAverage)
                            @for($i = 0; $i < $evaluationsAverage; $i++)
                                <span>
                    <i class="fa-solid fa-star" style="color: #991a14"></i>
                </span>
                            @endfor
                            @for($i = 5; $i > $evaluationsAverage; $i--)
                                <span>
                    <i class="fa-regular fa-star" style="color: #991a14"></i>
                </span>
                            @endfor
                        @else
                            <span>{{__('profile.no_rating')}}</span>
                        @endif
                    </p>
                </div>
            @else
                <div class="ml-auto">
                    <p class="font-bold">Rating :
                        <span>{{__('profile.no_rating', ['name' => $host->user->firstname])}}</span>
                    </p>
                    @endif
                </div>
        </div>


        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-700">@lang('content.about') {{$host->user->firstname}}</h2>
            <p class="mt-3 text-gray-600">{{$host->bio}}</p>
        </div>
    </section>
    <!--Evaluations-->
    <!--create evaluation form-->
    <section id="newEvaluation" class="w-3/4 justify-center mx-auto">
        @if($showForm && !$existingEvaluation)
            <h2>{{ __('evaluation.evaluate', ['name' => $host->firstname]) }}</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{route('evaluation.store', $reservation->id)}}" method="POST">
                @csrf
                <div class="w-1/12">
                    <label for="rating">Note sur 5 :</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" class="input w-1/12" required>
                </div>
                <div class="">
                    <label for="comment">Commentaire:</label>
                    <textarea name="comment" id="comment" class="input" rows="4" required></textarea>
                </div>
                <!--hidden input to pass the reservation, reviewee & reviewer-->
                <div>
                    <input type="hidden" name="reservation_id" value="{{encrypt($reservation->id)}}">
                    <input type="hidden" name="reviewer_id" value="{{encrypt($guest->id)}}">
                    <input type="hidden" name="reviewee_id" value="{{encrypt($host->user->id)}}">
                </div>
                <button type="submit" class="btn-validate">Soumettre</button>
            </form>
        @endif
    </section>

    <!--Host ad(s) -->
    <section class="mt-8">
        <div class="mb-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800">{{__('profile.host.ads', ["name" => $host->user->firstname])}}</h2>
        </div>
        <div class="w-8/12 mx-auto">
            @if($annonces->count() > 0)
                <div class="flex flex-wrap gap-4 justify-center">
                    @foreach($annonces as $annonce)
                        <div
                            class="border border-gray-200 rounded-lg shadow-lg p-5 bg-white transform transition-transform hover:scale-105 w-full max-w-xs mx-auto border-solid">
                            <div class="flex flex-col items-center">
                                <p class="mb-2 text-sm font-bold text-red-750">{{ $annonce->title }}</p>
                                <p>{{__('annonce.cuisine')}} {{ $annonce->cuisine }}</p>
                                <a href="{{ route('annonce.show', $annonce->id) }}" class="w-full h-48 overflow-hidden">
                                    <img src="{{ asset($annonce->pictures[0]->path) }}"
                                         class="w-full h-full object-cover rounded">
                                </a>
                                <p class="text-lg font-medium text-gray-700">{{ $annonce->price }} €</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex justify-center text-center mx-auto mb-2">
                    <h1 class="text-3xl font-bold text-red-750">{{__('profile.host.no_ads')}}</h1>
                </div>
            @endif
        </div>
    </section>


    <!--Evaluation list-->
    <section id="evaluationList" class="mt-8 w-3/4 mx-auto">

        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Evaluations</h2>
        <div class="">
            {{ $evaluations->links() }}
        </div>
        <div class="space-y-4">
            @if($evaluations)
                @foreach($evaluations as $evaluation)
                    <div class="rounded-lg  p-4 flex items-start">
                        <img src="{{ asset($evaluation->reviewer->profile_picture) }}" alt="Reviewer profile picture"
                             class="w-16 h-16 rounded-full  mr-4">
                        <div>
                            <p class="text-lg font-semibold text-gray-800">{{ $evaluation->reviewer->firstname}}</p>
                            <p class="text-red-750 text-sm ">{{ $evaluation->reviewer->country->name}}</p>

                            <p class="text-xs text-red-750">{{ $evaluation->created_at->format('M j, Y') }}</p>
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
                            <comment class="text-gray-600 text-lg mt-2"> {{ $evaluation->comment }}</comment>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex justify-center text-center mx-auto mb-2">
                    <h1 class="text-3xl font-bold text-red-750">@lang('profile.no_rating')</h1>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
