<x-app-layout>
    <h1 class="text-3xl">Liste des annonces</h1>
    <div class="flex gap-5">
        @foreach($annonces as $annonce)
            <div class="border border-solid border-black w-1/4 p-3 ">
                <div class="flex-col">
                    <p>{{$annonce->host->user->firstname}}</p>
                    <p class="underline"><a href="{{route('annonce.show', $annonce->id)}}">{{$annonce->title}}</a></p>
                    <img src="{{asset('/img/annonces/'.$annonce->picture_name)}}">
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
