<x-app-layout>
    <section class="mt-4">
        <div class="mx-auto text-center">
            <img src="{{ asset($user->profile_picture) }}" alt="Profile picture"
                 class="w-1/6 rounded-full mx-auto">
            <p class="text-xl font-bold mt-4">{{$user->firstname}}</p>
            <p class="text-red-750">{{$user->city->name}}</p>
            <div class="mt-4 mb-6">
                <a class="btn-secondary" href="{{route('profile.edit')}}">@lang('profile.edit')</a>
            </div>
        </div>
        <!-- rectangle data -->
        <div class="flex flex-col justify-center space-x-4 mt-8 md:flex-row">
            <div class="border border-gray-300 border-solid rounded-lg w-1/4 p-4 flex-row items-center ">
                <div>
                    <i class="fa-solid fa-location-dot" style="color: #991a14;"></i>
                </div>
                <p class="font-bold">{{$user->city->name}}, {{$user->country->iso2}}</p>
            </div>
            <div class="border border-gray-300 border-solid rounded-lg w-1/4 p-4 flex-row items-center ">
                <div>
                    <i class="fa-solid fa-user-friends" style="color: #991a14"></i>
                </div>
                <p class="font-bold">@lang('profile.meal') : {{count($reservations)}}</p>
            </div>
            <div class="border border-gray-300 border-solid rounded-lg w-1/4 p-4 flex-row items-center ">
                <div>
                    <i class="fa-solid fa-heart" style="color: #991a14"></i>
                </div>
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
        </div>
    </section>

    <!-- Tabs -->
    <section>
        <div class="flex gap-16 justify-center mt-8">
            <div class="px-8 border-b-2 border-gray-200 hover:border-red-750 cursor-pointer" onclick="showSection('bookings')">
                <p class="text-gray-600 font-bold">@lang('profile.book')</p>
            </div>
            <div class="px-8 border-b-2 border-gray-200 hover:border-red-750 cursor-pointer" onclick="showSection('reviews')">
                <p class="text-gray-600 font-bold">@lang('profile.review')</p>
            </div>
            <div class="px-8 border-b-2 border-gray-200 hover:border-red-750 cursor-pointer" onclick="showSection('favorites')">
                <p class="text-gray-600 font-bold">@lang('profile.favorite')</p>
            </div>
        </div>
    </section>

    <!-- Sections -->
    <section id="bookings" class="tab-section">
        @if($nextAnnonce)
            <div class="flex justify-center mt-8">
                <div class="w-full max-w-4xl">
                    <h1 class="text-3xl font-bold mb-4">@lang('profile.upcoming_experience')</h1>
                    <div class="flex items-center">
                        <div class="flex-grow flex flex-col justify-center">
                            <p class="text-red-750">{{$nextAnnonce->title}}</p>
                            <p class="text-gray-500">{{$nextAnnonce->schedule}}, {{$nextAnnonce->max_guest}} max</p>
                            <div class="mt-4">
                                <a class="btn-secondary" href="{{route('annonce.show', $nextAnnonce->id)}}">@lang('profile.annonce_details')</a>
                            </div>
                        </div>
                        <div class="ml-8 flex-shrink-0">
                            <img src="{{ asset($nextAnnonce->pictures[0]->path) }}" alt="Experience Image" class="rounded-lg w-80">
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-center mt-8">@lang('profile.host.no_upcoming_annonce')</p>
        @endif
    </section>

    <section id="reviews" class="tab-section" style="display:none;">
        <!-- Contenu des reviews -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center mt-4">Evaluations</h2>
        <div class="space-y-4 mx-auto flex flex-col items-center">
            @foreach($evaluations as $evaluation)
                <div class="rounded-lg p-4 flex items-start w-full max-w-2xl">
                    <img src="{{ asset($evaluation->reviewer->profile_picture) }}" alt="Reviewer profile picture"
                         class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">{{ $evaluation->reviewer->firstname }}</p>
                        <p class="text-red-750 text-sm">{{ __('country.'.$evaluation->reviewer->country->iso2) }}</p>
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
                        <p class="text-gray-600 text-lg mt-2">{{ $evaluation->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <section id="favorites" class="tab-section" style="display:none;">
        <!-- Contenu des favoris -->
        <p class="text-center mt-8">@lang('profile.no_favorites')</p>
    </section>

    <!--past annonces-->
    <section class="flex flex-col items-center mt-8">
        <h1 class="text-3xl font-bold mb-4">@lang('profile.past_experience')</h1>
        @if(count($pastAnnonces) > 0)
            <div class="flex flex-wrap justify-center gap-5">
                @foreach($pastAnnonces as $annonce)
                    <div class="border border-gray-300 rounded-lg shadow-lg  bg-white">
                        <div class="relative overflow-hidden rounded-t-lg">
                            <img src="{{ asset($annonce->pictures[0]->path) }}" class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4">
                            <p class="text-lg font-medium">{{ $annonce->title }}</p>
                            <p class="text-sm text-gray-500">{{ $annonce->schedule }}, {{ $annonce->max_guest }} guests</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center mt-8">@lang('profile.host.no_past_annonce')</p>
        @endif
    </section>

    <script>
        function showSection(sectionId) {
            // Cache toutes les sections
            var sections = document.querySelectorAll('.tab-section');
            sections.forEach(function (section) {
                section.style.display = 'none';
            });

            // Affiche la section sélectionnée
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</x-app-layout>
