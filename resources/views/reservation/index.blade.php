@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <section class="mt-8">
        <h1 class="text-3xl font-bold mb-6 text-center">@lang('content.reservation_list')</h1>
        <div class="flex justify-center">
            @if($reservations->isEmpty())
                <tr>
                    <td colspan="6" class="text-center py-4">
                        {{__('profile.guest.no_reservation')}}
                    </td>
                </tr>
            @else
            <table class="w-3/4 mx-auto bg-white border border-gray-300">
                <thead class="bg-red-750">
                <tr class="text-white text-center">
                    <th class="py-2 px-4 border-b ">{{__('annonce.host')}}</th>
                    <th class="py-2 px-4 border-b ">{{__('annonce.data.cuisine')}}</th>
                    <th class="py-2 px-4 border-b ">{{__('annonce.data.price')}}</th>
                    <th class="py-2 px-4 border-b">{{__('annonce.data.date')}}</th>
                    <th class="py-2 px-4 border-b">{{__('annonce.data.title')}}</th>
                    <th class="py-2 px-4 border-b">{{__('annonce.actions.title')}}</th>
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
                                {{ __('country.'.$reservation->country->iso2) }}
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                {{ $reservation->annonce->price }} €
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                {{ __('content.days.'.Carbon::parse($reservation->annonce->schedule)->format('D')) }} {{ Carbon::parse($reservation->annonce->schedule)->format('d/m/Y') }}
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
                                    <button type="submit" class="btn-secondary cancel-button">{{__('annonce.actions.cancel')}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
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
    <x-footer />

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

