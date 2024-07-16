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
                <p class="font-bold"></p>
            </div>
            <div class="border border-gray-300 border-solid rounded-lg w-1/4 p-4 flex-row items-center ">
                <div>
                    <i class="fa-solid fa-heart" style="color: #991a14"></i>
                </div>
                <p class="font-bold">rating
                    <span>
                        <i class="fa-regular fa-star" style="color: #991a14"></i>
                        <i class="fa-regular fa-star" style="color: #991a14"></i>
                        <i class="fa-regular fa-star" style="color: #991a14"></i>
                        <i class="fa-regular fa-star" style="color: #991a14"></i>
                        <i class="fa-regular fa-star" style="color: #991a14"></i>
                    </span>
                </p>
                <p class="font-bold"></p>
            </div>
        </div>
    </section>
    <!--links-->
    <section>
        <div class="flex gap-16 justify-center mt-8">
            <div class="px-8 border-b-2 border-gray-200 hover:border-red-750">
                <p class="text-gray-600 font-bold">@lang('profile.book')</p>
            </div>
            <div class="px-8 border-b-2 border-gray-200 hover:border-red-750">
                <p class="text-gray-600 font-bold">@lang('profile.review')</p>
            </div>
            <div class="px-8 border-b-2 border-gray-200 hover:border-red-750">
                <p class="text-gray-600 font-bold">@lang('profile.favorite')</p>
            </div>
        </div>
    </section>
    <!--upcoming exp-->
    <section class="flex justify-center mt-8">
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
    </section>
    <!--tags-->


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
            <p class="text-center mt-8">@lang('profile.no_past_annonce')</p>
        @endif
    </section>



</x-app-layout>
