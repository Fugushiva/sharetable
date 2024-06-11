<x-app-layout>
    <section class="relative w-full h-auto flex items-center justify-center">
        <div class="relative w-full max-w-screen-xl overflow-hidden">
            <img src="{{ asset('img/site/guest/cooking_person_red.webp') }}" alt="Cooking Person" class="w-full h-[70vh] object-cover object-bottom rounded mt-10">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center p-4 mt-32">
                <h1 class="text-4xl font-bold">Welcome back, {{$user->firstname}}</h1>
                <p class="mt-4 text-lg">Find and book unique food experiences around the world</p>
                <div class="mt-8 flex flex-wrap justify-center gap-2">
                    <input type="text" placeholder="Let's start with a city or cuisine" class="px-4 py-2 rounded-lg text-gray-900 w-80">
                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg">Search</button>
                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg">More</button>
                </div>
            </div>
        </div>
    </section>
    <section class="relative w-full h-auto items-center ">
        <h1 class="relative justify-center">liste des annonces</h1>
        <div class="relative flex gap-4 justify-center">


            @foreach($annonces as $annonce)
                <div class="flex-col w-1/5">
                    <img src="{{asset('/img/annonces/'.$annonce->picture_name)}}" class="w-full h-48 object-cover rounded mt-10">
                    <p class="underline"><a href="{{route('annonce.show', $annonce->id)}}">{{$annonce->title}}</a></p>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
