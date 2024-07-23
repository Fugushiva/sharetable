<x-app-layout>
    <section class="p-6 rounded-lg w-3/4 justify-center mx-auto bg-gray-100 shadow-lg">
        <div class="flex gap-6 items-center">
            <img src="{{ asset($user->profile_picture) }}" alt="Profile picture" class="w-32 h-32 rounded-full border-4">
            <div>
                <p class="text-2xl font-bold text-red-750">{{$user->firstname}} {{$user->lastname}}</p>
                <p class="text-sm text-gray-600">{{$user->country->name}}, {{$user->city->name}}</p>
            </div>
        </div>
        <div class="mt-4">
            <h2 class="text-xl font-bold text-red-750">@lang('content.about') {{$user->firstname}}</h2>
            <p class="mt-2 text-gray-700">{{$user->host->bio}}</p>
        </div>
    </section>
    <!-- My ads -->

    <section class="mt-8 w-3/4 mx-auto">
        @if(sizeOf($annonces)>0) <!-- If the user have ads -->
        <div class="flex justify-center text-center mx-auto">
            <h1 class="text-3xl font-bold text-red-750">@lang('profile.my_ads')</h1>
        </div>
        <table class="w-full mt-4 bg-white shadow-lg rounded-lg text-center">
            <thead>
            <tr class="bg-red-750 text-white">
                <th class="py-2 px-4">@lang('annonce.title')</th>
                <th class="py-2 px-4">@lang('annonce.price')</th>
                <th class="py-2 px-4">@lang('annonce.date')</th>
                <th class="py-2 px-4">@lang('annonce.action')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($annonces as $ad)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-2 px-4">{{$ad->title}}</td>
                    <td class="py-2 px-4">{{$ad->price}}</td>
                    <td class="py-2 px-4">{{$ad->schedule}}</td>
                    <td class="py-2 px-4 flex gap-4 justify-center">
                        <a class="text-red-750 underline" href="{{route('annonce.show', $ad->id)}}">@lang('annonce.details')</a>
                        <a class="text-red-750 underline">@lang('annonce.edit')</a>
                        <form method="post" action="{{route('annonce.destroy', $ad)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-750 underline">@lang('annonce.delete')</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <div class="flex justify-center text-center mx-auto mb-2">
                <h1 class="text-3xl font-bold text-red-750">@lang('message.ads.no_ads_title')</h1>
            </div>
            <div class="flex justify-center mx-auto">
                <h1 class="">@lang('message.ads.no_ads_message')</h1>
            </div>
        @endif
    </section>
</x-app-layout>
