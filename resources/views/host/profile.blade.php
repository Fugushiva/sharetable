<x-app-layout>
        <section class="p-6 rounded-lg w-3/4 justify-center mx-auto ">
            <div class="flex gap-6 items-center">
                <img src="{{ image_path($user->profile_picture) }}" alt="Profile picture" class="w-32 h-32 rounded-full">
                <div>
                    <p class="text-2xl font-bold">{{$user->firstname}} {{$user->lastname}}</p>
                    <p class="text-sm text-gray-600">{{$user->country->name}}, {{$user->city->name}}</p>
                </div>
                <a href='{{route('annonce.create')}}' class="ml-auto btn-validate">Create Experience</a>
            </div>
            <div class="mt-4">
                <h2 class="text-xl font-bold">@lang('content.about') {{$user->firstname}}</h2>
                <p class="mt-2 text-gray-700">{{$user->host->bio}}</p>
            </div>
        </section>
</x-app-layout>

