<x-app-layout>
    <section class="flex flex-col items-center bg-gradient-to-r from-gray-50 to-gray-100 p-8">
        <h2 class="text-2xl font-semibold mb-4">@lang('content.booking_summary')</h2>
        <div class="flex flex-col md:flex-row gap-6 mb-8 w-full md:w-3/4 lg:w-1/2">
            <!-- Titre de l'annonce -->
            <div class="flex items-center md:items-start gap-4">
                <img class="h-48 object-cover rounded-md shadow-md" src="{{ asset($annonce->pictures->first()->path) }}"
                     alt="Photo de l'annonce">
                <div class="flex flex-col">
                    <p class="text-lg text-gray-700 mt-4">{{ $annonce->title }}</p>
                    <span class="font-bold">@lang('content.host'): <span
                            class="text-gray-500">{{ $annonce->host->user->firstname }}</span></span>
                </div>
            </div>
        </div>
        <!-- Information date & repas -->
        <div class="border-t border-red-750 w-3/4 my-4"></div>
        <h2 class="text-xl font-semibold mb-2">@lang('content.your_meal')</h2>
        <div class="text-center">
            <p class="text-gray-700 text-lg leading-relaxed">{{ __('content.the') }} {{ substr($annonce->schedule, 0, -8) }} {{ __('content.at') }} {{ substr($annonce->schedule, -8, 8) }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-700 text-lg leading-relaxed">{{ $annonce->cuisine }} cuisine</p>
        </div>
        <!-- Paiement & form -->
        <div class="border-t border-red-750 w-3/4 my-4"></div>
        <div class="text-center">
            <p class="text-lg text-gray-700">{{ $annonce->price }}€ {{ __('annonce.per_guest') }}</p>
        </div>

        @if(Auth::check())
        <form method="post" class="mt-4" action="{{ route('stripe.checkout') }}">
            @csrf
            <input type="hidden" name="annonce_id" value="{{ Crypt::encrypt($annonce->id) }}">
            <button class="btn-validate hover:bg-red-700 transition duration-300">@lang('content.pay')</button>
        </form>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>


</x-app-layout>

