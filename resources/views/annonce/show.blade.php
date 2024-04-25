<x-app-layout>
    <div class="flex flex-col">
        <!--titre de l'annoonce-->
        <h2 class="text-xl">{{$annonce->title}}</h2>
        <!--description de l'annonce-->
        <p class="">{{$annonce->description}}</p>

        <!---->
        <p>{{$annonce->schedule}}</p>
        <!--Photo de l'annonce-->
        <div>
            <img src="{{asset('/img/annonces/'.$annonce->picture_name)}}">
        </div>
        <!--photo de l'utilisateur-->
       <img src="{{asset('/img/profiles/'.$user->profile_picture)}}">

    </div>
</x-app-layout>
