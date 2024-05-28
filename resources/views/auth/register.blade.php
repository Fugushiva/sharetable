<x-guest-layout>
    <h1 class="text-3xl text-center my-12">Sign up for ShareTable</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="firstname">Firstname</label>
            <input id="firstname" class="block mt-1 w-full" type="text" name="firstname" required autofocus autocomplete="name" >
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <div>
            <label for="lastname">Lastname</label>
            <input id="lastname" class="block mt-1 w-full" type="text" name="lastname" required autofocus autocomplete="name" >
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email">Email</label>
            <input id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" :value="__('Password')">Password</label>

            <input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" >

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">Confirm Password</label>

            <input id="password_confirmation" class="form-input block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password">

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!--Country-->
        <div class="mt-4">
            <label for="country">Country</label>
            <input list="countryList" id="country" name="country_name">
            <datalist id="countryList">
                @foreach($countries as $country)
                    <option value="{{$country->name}}" data-id="{{$country->id}}"></option>
                @endforeach
            </datalist>

            <x-input-error :messages="$errors->get('country_name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <label for="city">City</label>
            <input list="cityList" id="city" name="city_name">
            <datalist id="cityList">
                @foreach($cities as $city)
                    <option value="{{$city->name}}" data-id="{{$city->id}}"></option>
                @endforeach
            </datalist>

            <x-input-error :messages="$errors->get('city_name')" class="mt-2" />
        </div>
        <div class="m">
            <button class="btn-validate w-full">Create my account</button>
        </div>
        <div class="flex items-center justify-center mt-4 gap-3">
            <a class="btn-secondary" href="{{ route('login') }}">
                {{ __('Login') }}
            </a>

        </div>
    </form>
</x-guest-layout>
