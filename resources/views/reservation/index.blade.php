@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <section class="mt-8">
        <h1 class="text-3xl font-bold mb-6 text-center">@lang('content.reservation_list')</h1>
        <div class="flex justify-center">
            <table class="w-3/4 mx-auto bg-white border border-gray-300">
                <thead class="bg-red-750">
                <tr class="text-white text-center">
                    <th class="py-2 px-4 border-b ">{{__('annonce.host')}}</th>
                    <th class="py-2 px-4 border-b ">{{__('annonce.place')}}</th>
                    <th class="py-2 px-4 border-b ">{{__('annonce.price')}}</th>
                    <th class="py-2 px-4 border-b">{{__('annonce.date')}}</th>
                    <th class="py-2 px-4 border-b">{{__('annonce.ad')}}</th>
                    <th class="py-2 px-4 border-b">{{__('annonce.action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b flex items-center justify-center text-center">
                            <img src="{{ asset($reservation->annonce->host->user->profile_picture) }}" class="w-10 h-10 rounded-full mr-2">
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
                            {{ Carbon::parse($reservation->annonce->schedule)->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <a href="{{ route('annonce.show', $reservation->annonce->id) }}" class="text-orange-600 hover:text-orange-800 underline">
                                {{ $reservation->annonce->title }}
                            </a>
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <form action="{{ route('stripe.refund') }}" method="post" class="cancel-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                <button type="submit" class="btn-secondary cancel-button">{{__('annonce.cancel')}}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- Display errors -->
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Stripe error session message -->
        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </section>

    <!-- Script pour la boîte de confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cancelButtons = document.querySelectorAll('.cancel-button');

            cancelButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const confirmed = confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');
                    if (confirmed) {
                        button.closest('form').submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>

