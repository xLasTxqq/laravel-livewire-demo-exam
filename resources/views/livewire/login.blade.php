
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Логин') }}
        </h2>
    </x-slot>

    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form wire:submit.prevent="login">

            <!-- Email Address -->
            <div>
                <x-label for="login" :value="__('Логин *')" />

                <x-input wire:model.lazy="login" id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Пароль *')" />

                <x-input wire:model.lazy="password" id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input wire:model.lazy="remember" id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Запомнить меня') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Забыли пароль?') }}
                </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Войти') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>