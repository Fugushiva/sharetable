<x-app-layout>
    <section class="p-6 flex justify-center w-full mx-auto">
        <form method="post" action="{{route('annonce.store')}}" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg w-3/4">
            @csrf
            <div class="flex flex-col gap-6">
                <h1 class="text-red-750 mx-auto font-bold text-3xl">
                    @lang('forms.create_ad')
                </h1>
                <!-- Titre -->
                <div class="flex flex-col gap-1">
                    <label for="title" class="font-semibold">@lang('forms.title')</label>
                    <input type="text" id="title" name="title" class="input" value="{{ old('title') }}">
                    @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Description -->
                <div class="flex flex-col gap-1">
                    <label for="description" class="font-semibold">@lang('forms.description')</label>
                    <textarea
                        id="description"
                        name="description"
                        class="input"
                        style="height: 100px;"
                        placeholder="minimum 50 caractères">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- séparateur -->
                <div class="border-red-750 border mx-auto w-1/2"></div>
                <!-- Date -->
                <div class="flex flex-col gap-1">
                    <label for="schedule" class="font-semibold">@lang('forms.schedule')</label>
                    <input type="datetime-local" id="schedule" name="schedule" class="input" value="{{ old('schedule') }}">
                    @error('schedule')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Prix -->
                <div class="flex flex-col gap-1">
                    <label for="price" class="font-semibold">@lang('forms.price')</label>
                    <input type="number" step="0.01" id="price" name="price" class="input" value="{{ old('price') }}">
                    @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Cuisine -->
                <div class="flex flex-col gap-1">
                    <label for="cuisine" class="font-semibold">@lang('forms.cuisine')</label>
                    <input list="countryList" id="cuisine" name="cuisine" class="select" value="{{ old('cuisine') }}">
                    <datalist id="countryList">
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" data-id="{{ $country->id }}"></option>
                        @endforeach
                    </datalist>
                    @error('cuisine')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Max guest -->
                <div class="flex flex-col gap-1">
                    <label for="guest" class="font-semibold">@lang('forms.max_guest')</label>
                    <input type="number" id="guest" name="max_guest" class="input" value="{{ old('guest') }}">
                    @error('guest')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- séparateur -->
                <div class="border-red-750 border mx-auto w-1/2"></div>
                <!-- Pictures -->
                <div class="flex flex-col gap-1">
                    <label for="picture" class="font-semibold">@lang('forms.pictures')</label>
                    <input type="file" accept="image/*" id="picture" name="pictures[]" multiple>
                    @error('pictures')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button class="btn-validate text-white font-semibold py-2 px-4 rounded-lg ">@lang('forms.create_ad')</button>
            </div>
        </form>
    </section>
    <x-footer />
</x-app-layout>
