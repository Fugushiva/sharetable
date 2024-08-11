<x-app-layout>
    <!-- host data -->
    <section class="p-6 rounded-lg md:w-3/4 justify-center mx-auto bg-gray-100 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between">
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <img src="{{ asset($user->profile_picture) }}" alt="Profile picture"
                     class="w-32 h-32 rounded-full border-4">
                <div>
                    <p class="text-2xl font-bold text-red-750">{{$user->firstname}} {{$user->lastname}}</p>
                    <p class="text-sm text-gray-600">{{$user->country->name}}, {{$user->city->name}}</p>
                </div>
            </div>
            <!-- rating -->
            <div class="flex items-center">
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
        <div class="mt-4">
            <h2 class="text-xl font-bold text-red-750">@lang('content.about') {{$user->firstname}}</h2>
            <p class="mt-2 text-gray-700">{{$user->host->bio}}</p>
        </div>
    </section>

    <!-- My ads -->
    <section class="mt-8 w-full max-w-3xl mx-auto">
        @if(sizeOf($annonces)>0)
            <!-- If the user has ads -->
            <div class="flex justify-center text-center mx-auto">
                <h1 class="text-3xl font-bold text-red-750">@lang('profile.my_ads')</h1>
            </div>
            <div class="overflow-x-auto">
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
                                <a class="text-red-750 underline"
                                   href="{{route('annonce.show', $ad->id)}}">@lang('annonce.details')</a>
                                <a class="text-red-750 underline">@lang('annonce.edit')</a>
                                <form method="post" action="{{route('annonce.destroy', $ad)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-750 underline">@lang('annonce.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex justify-center text-center mx-auto mb-2">
                <h1 class="text-3xl font-bold text-red-750">@lang('message.ads.no_ads_title')</h1>
            </div>
            <div class="flex justify-center mx-auto">
                <h1 class="">@lang('message.ads.no_ads_message')</h1>
            </div>
        @endif
    </section>
    <!-- évaluations -->
    <section class="mt-8 w-full max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center mt-4">@lang('profile.evaluations')</h2>
        <div class="space-y-4 mx-auto flex flex-col items-center">
            @foreach($evaluations as $evaluation)
                <div class="rounded-lg p-4 flex items-start w-full max-w-2xl">
                    <img src="{{ asset($evaluation->reviewer->profile_picture) }}" alt="Reviewer profile picture"
                         class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">{{ $evaluation->reviewer->firstname }}</p>
                        <p class="text-sm text-gray-500">{{ $evaluation->comment }}</p>
                        <div class="flex items
                        -center mt-2">
                            @for($i = 0; $i < $evaluation->rating; $i++)
                                <span>
                                    <i class="fa-solid fa-star text-red-750"></i>
                                </span>
                            @endfor
                            @for($i = 5; $i > $evaluation->rating; $i--)
                                <span>
                                    <i class="fa-regular
                                    fa-star text-red-750"></i>
                                </span>
                            @endfor
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
