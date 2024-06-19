<x-app-layout>
    <section class="relative w-full h-auto flex items-center justify-center">
        <div class="relative w-full max-w-screen-xl overflow-hidden">
            <img src="{{ asset('img/site/guest/cooking_person_red.webp') }}" alt="Cooking Person" class="w-full h-[70vh] object-cover object-bottom rounded mt-10">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center p-4 mt-32">
                <h1 class="text-4xl font-bold">@lang('content.welcome_back') {{$user->firstname}}</h1>
                <p class="mt-4 text-lg">@lang('content.find_and_book')</p>
                <div class="mt-8 flex flex-wrap justify-center gap-2">
                    <input type="text" placeholder="@lang('content.city_or_cuisine')" class="px-4 py-2 rounded-lg text-gray-900 w-80">
                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg">@lang('content.search')</button>
                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg">@lang('content.more')</button>
                </div>
            </div>
        </div>
    </section>
    <!--Liste des annonces-->
    <section class="relative w-full h-auto items-center ">
        <div class="relative flex justify-center mt-4">
            <h1 class="relative text-2xl font-bold">{{__('content.listing')}}</h1>
        </div>
        <div class="relative flex gap-8 justify-center flex-wrap">
            @foreach($annonces as $annonce)
                <div class="flex flex-col w-1/5 bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{asset('/img/annonces/'.$annonce->picture_name)}}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <p class="underline hover:text-red-600"><a href="{{route('annonce.show', $annonce->id)}}">{{$annonce->title}}</a></p>
                        <p class="text-red-700 text-sm">{{$annonce->price}} € @lang('annonce.per_guest')</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
