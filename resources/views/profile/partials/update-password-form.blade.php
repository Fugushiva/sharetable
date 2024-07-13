<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('forms.update_password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('forms.ensure_security') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password">{{ __('forms.current_password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full input" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password">{{ __('forms.new_password') }}</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full input" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation">{{ __('forms.Password_confirm') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full input" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('forms.save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 input"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
