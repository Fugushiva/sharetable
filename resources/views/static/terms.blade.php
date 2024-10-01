<x-app-layout>
    <section class="bg-gray-100 py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-center mt-8 text-gray-900">{{__('cgu.title')}}</h1>
            <h2 class="text-2xl font-medium text-center mt-4 text-gray-600">{{__('cgu.intro')}}</h2>
        </div>

        <div class="max-w-4xl mx-auto mt-12">
            <!-- Section Template -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.object')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.object_text')}}</p>
            </div>
            <!-- Other sections -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.definitions')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.definitions_text')}}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.access')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.access_text')}}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.reservations')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.reservations_text')}}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.payments')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.payments_text')}}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.liability')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.liability_text')}}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.data_privacy')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.data_privacy_text')}}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.modification')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.modification_text')}}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">{{__('cgu.law')}}</h2>
                <p class="mt-4 text-gray-600">{{__('cgu.law_text')}}</p>
            </div>
        </div>
    </section>
    <x-footer />
</x-app-layout>
