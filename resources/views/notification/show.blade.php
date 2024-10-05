<x-app-layout>
    <section class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">{{__('notification.all')}}</h1>
        @foreach($userNotifications as $notification)
            <div class="notification-item bg-white shadow-lg rounded-lg p-6 mb-4 transition transform hover:scale-105 hover:shadow-2xl">
                <!-- Affichage du message directement -->
                <p class="text-gray-800 text-lg font-medium mb-2">{{ $notification->message }}</p>

                <!-- Affichage du lien directement -->
                <a href="{{ $notification->url }}" class="text-red-750 hover:text-blue-700 font-semibold underline transition duration-300">
                    {{__('notification.see_more')}}
                </a>
            </div>
        @endforeach
    </section>
</x-app-layout>

