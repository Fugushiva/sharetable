<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('forms.profile_info') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("forms.profile_info_message") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6 flex flex-col w-full">
        @csrf
        @method('patch')

        <div>
            <label for="firstname">{{ __("forms.Firstname") }}</label>
            <input id="firstname" name="firstname" type="text" class="mt-1 block w-full input" placeholder="{{$user->firstname}}" value="{{$user->firstname}}">
            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
        </div>

        <div>
            <label for="lastname">{{ __("forms.Lastname") }}</label>
            <input id="lastname" name="lastname" type="text" class="mt-1 block w-full input" placeholder="{{$user->lastname}}" value="{{$user->lastname}}" >
            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full input" placeholder="{{$user->email}}" value="{{$user->email}}">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>


        <!--Profile picture-->
        <label for="picture">{{ __("forms.profile_picture") }}</label>
        <input type="file" name="profile_picture" class="input-file" id="picture" value="{{image_path($user->profile_picture)}}">
        <img src="{{ image_path($user->profile_picture) }}" alt="Profile picture" class="w-1/4 rounded-full  ">

        <!--Country-->
        <div class="mt-4">
            <label for="country">{{ __("forms.Country") }}</label>
            <input list="countryList" id="country" class="select" name="country_name" value="{{$user->country->name}}">
            <datalist id="countryList">
                @foreach($countries as $country)
                    <option value="{{$country->name}}" data-id="{{$country->id}}"></option>
                @endforeach
            </datalist>
            <x-input-error :messages="$errors->get('country_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="city">{{ __("forms.City") }}</label>
            <input list="cityList" id="city" class="select" name="city_name" value="{{$user->city->name}}">
            <datalist id="cityList">
                <!-- Les villes seront ajoutées ici -->
            </datalist>
            <x-input-error :messages="$errors->get('city_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="language">@lang("forms.language")</label>
            <select id="language" class="w-1/6 select" name="language_code" value="{{$user->language}}">
                @foreach($languages as $language)
                    <option data-id="{{$language->id}}">{{$language->code}}</option>
                @endforeach
            </select>
        </div>


        <div class="flex items-center gap-4">
            <button class="btn-validate">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script src="{{ asset('build/assets/cities-BouRWpE4.js') }}"></script>
</section>
