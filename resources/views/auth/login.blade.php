<x-app-layout>
    <x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email">Email</label>
                <input id="email" class="block mt-1 w-full input" type="email" name="email"
                       placeholder="Enter your email" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password">{{__('forms.Password')}}</label>

                <input id="password" class="block mt-1 w-full input"
                       type="password"
                       name="password"
                       required autocomplete="current-password"
                       placeholder="Enter your password">

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div>
                <button class="btn-validate w-full">
                    {{ __('Log in') }}
                </button>
            </div>
            <div class="flex items-center justify-between mt-4">
                <a class="btn-secondary" href="{{route('register')}}">Sign up</a>
                <div class="flex-grow"></div>
                @if (Route::has('password.request'))
                    <a class="btn-secondary" href="{{ route('password.request') }}">
                        {{ __('Forgot your password') }}
                    </a>
                @endif
            </div>
        </form>
    </x-guest-layout>
    <x-footer/>
</x-app-layout>
