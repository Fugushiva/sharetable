<x-app-layout>
    <section class="mt-8">
        <h1 class="text-3xl font-bold mb-6 text-center">@lang('content.reservation_list')</h1>
        <div class="flex justify-center">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-center">Hôte</th>
                    <th class="py-2 px-4 border-b text-center">Lieu</th>
                    <th class="py-2 px-4 border-b text-center">Prix</th>
                    <th class="py-2 px-4 border-b text-center">Annonce</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b flex items-center justify-center text-center">
                            <img src="{{ image_path($reservation->annonce->host->user->profile_picture) }}" class="w-10 h-10 rounded-full mr-2">
                            <div>
                                <a href="{{ route('host.show', $reservation->annonce->host->id) }}" class="font-medium">
                                    {{ $reservation->annonce->host->user->firstname }}
                                </a>
                            </div>
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            {{ $reservation->annonce->host->user->country->name }}, {{ $reservation->annonce->host->user->city->name }}
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            {{ $reservation->annonce->price }} €
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <a href="{{ route('annonce.show', $reservation->annonce->id) }}" class="text-orange-600 hover:text-orange-800 underline">
                                {{ $reservation->annonce->title }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
