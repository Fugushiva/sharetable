<x-app-layout>
    <div class="container mx-auto">
        <!-- Section principale pour l'échange culturel et culinaire -->
        <section class="relative bg-cover bg-center" style="background-image: url('{{ asset("img/site/charac/friendsCook.jpg") }}'); height: 400px;">
            <div class="relative text-white text-center py-20">
                <h1 class="text-4xl font-bold">{{ __('content.dashboard.exchange') }}</h1>
                <p class="mt-4 text-lg">{{ __('content.dashboard.exchange_text') }}</p>
                <div class="mt-8">
                    <a href="{{route('annonce.index')}}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">{{ __('content.dashboard.find') }}</a>
                    @if(auth()->user() && !auth()->user()->host)
                        <a href="{{route('host.create')}}" class="bg-gray-300 hover:bg-gray-500 text-gray-700 font-bold py-2 px-4 rounded ml-4">{{ __('content.dashboard.become_host') }}</a>
                    @elseif(!auth()->user())
                        <a href="{{route('register')}}" class="bg-gray-300 hover:bg-gray-500 text-gray-700 font-bold py-2 px-4 rounded ml-4">{{ __('content.register') }}</a>
                    @endif
                </div>*
            </div>
        </section>

        <!-- Section pour découvrir des expériences uniques -->
        <section class="mt-12 text-center">
            <h2 class="text-3xl font-bold mb-6">{{ __('content.dashboard.discover') }}</h2>
            <p class="text-lg mb-12">{{ __('content.dashboard.discover_text') }}</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Hôte de partage -->
                <div class="bg-white rounded-lg shadow-lg">
                    <img src="{{asset('img/site/charac/sharefood.jpg')}}" alt="Rechercher un hôte" class="w-full h-48 object-cover" style="object-position: 50% 17%;">
                    <h3 class="text-2xl font-bold mb-4">{{ __('content.dashboard.experience_search') }}</h3>
                    <p>{{ __('content.dashboard.experience_search_text') }}</p>
                </div>

                <!-- Découverte de la cuisine -->
                <div class="bg-white rounded-lg shadow-lg">
                    <img src="{{ asset('img/site/charac/disover.jpg') }}" alt="Découverte de cuisine" class="w-full h-48 object-cover" style="object-position: 50% 17%;">
                    <h3 class="text-2xl font-bold mb-4">{{ __('content.dashboard.cuisine_discovery') }}</h3>
                    <p>{{ __('content.dashboard.cuisine_discovery_text') }}</p>
                </div>

                <!-- Partage d'expérience -->
                <div class="bg-white rounded-lg shadow-lg">
                    <img src="{{asset('img/site/charac/shareExp.jpg')}}" alt="Partage d'expérience" class="w-full h-48 object-cover mb-4">
                    <h3 class="text-2xl font-bold mb-4">{{ __('content.dashboard.experience_sharing') }}</h3>
                    <p>{{ __('content.dashboard.experience_sharing_text') }}</p>
                </div>
            </div>
        </section>
    </div>
    <x-footer />
</x-app-layout>
