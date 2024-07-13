<x-app-layout>
    <x-guest-layout>
        <h1 class="text-3xl text-center my-12">{{__('forms.Sign')}}</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="firstname">{{__('forms.Firstname')}}</label>
                <input id="firstname" class="block mt-1 w-full input" type="text" name="firstname" required autofocus
                       autocomplete="name">
                <x-input-error :messages="$errors->get('firstname')" class="mt-2"/>
            </div>

            <div>
                <label for="lastname">{{__('forms.Lastname')}}</label>
                <input id="lastname" class="block mt-1 w-full input" type="text" name="lastname" required autofocus
                       autocomplete="name">
                <x-input-error :messages="$errors->get('lastname')" class="mt-2"/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email">Email</label>
                <input id="email" class="block mt-1 w-full input" type="email" name="email" required autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" :value="__('Password')">{{__('forms.Password')}}</label>
                <input id="password" class="block mt-1 w-full input" type="password" name="password" required
                       autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation">{{__('forms.Password_confirm')}}</label>
                <input id="password_confirmation" class="form-input block mt-1 w-full input" type="password"
                       name="password_confirmation" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>

            <!--Country-->
            <div class="mt-4">
                <label for="country">{{__('forms.Country')}}</label>
                <input list="countryList" class="block mt-1 select" id="country" name="country_name">
                <datalist id="countryList">
                    @foreach($countries as $country)
                        <option value="{{$country->name}}" data-id="{{$country->id}}"></option>
                    @endforeach
                </datalist>
                <x-input-error :messages="$errors->get('country_name')" class="mt-2"/>
            </div>

            <!--City-->
            <div class="mt-4">
                <label for="city">{{__('forms.City')}}</label>
                <input list="cityList" class="block mt-1 select" id="city" name="city_name">
                <datalist id="cityList">
                    <!-- Les villes seront ajoutées ici -->
                </datalist>
                <x-input-error :messages="$errors->get('city_name')" class="mt-2"/>
            </div>

            <!--Language-->
            <div class="mt-4">
                <label for="language">@lang('forms.language')</label>
                <select id="language" name="language_name" class="w-1/4 select">
                    @foreach($languages as $language)
                        <option data-id="{{$language->id}}">{{$language->name_native}}</option>
                    @endforeach
                </select>
            </div>

            <div class="m">
                <button class="btn-validate w-full">{{__('forms.create_account')}}</button>
            </div>

            <div class="flex items-center justify-center mt-4 gap-3">
                <a class="btn-secondary" href="{{ route('login') }}">
                    {{ __('forms.login') }}
                </a>
            </div>
        </form>

        <script src="{{ asset('build/assets/cities-BouRWpE4.js') }}"></script>


    </x-guest-layout>
</x-app-layout>
