<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6 flex flex-col w-full">
        @csrf
        @method('patch')

        <div>
            <label for="firstname">Firstname</label>
            <input id="firstname" name="firstname" type="text" class="mt-1 block w-full" placeholder="{{$user->firstname}}" value="{{$user->firstname}}">
            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
        </div>

        <div>
            <label for="lastname">Lastname</label>
            <input id="lastname" name="lastname" type="text" class="mt-1 block w-full" placeholder="{{$user->lastname}}" value="{{$user->lastname}}" >
            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="{{$user->email}}" value="{{$user->email}}">
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
        <label for="picture">Photo de profil</label>
        <input type="file" name="profile_picture" id="picture" value="{{image_path($user->profile_picture)}}">
        <img src="{{ image_path($user->profile_picture) }}" alt="Profile picture" class="w-1/4 rounded-full  ">

        <!--Country-->
        <label for="country">Country</label>
        <input list="country" name="country_id" id="country">
        <datalist id="country" >
            <option>--Select a country--</option>
            @foreach($countries as $country)
                <option value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
        </datalist>

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
</section>
