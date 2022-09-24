<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Регистрация') }}
        </h2>
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Имя *')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus />
            </div>

            <!-- Surname -->
            <div class="mt-4">
                <x-label for="surname" :value="__('Фамилия *')" />

                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" />
            </div>

            <!-- Patronymic -->
            <div class="mt-4">
                <x-label for="patronymic" :value="__('Отчество')" />

                <x-input id="patronymic" class="block mt-1 w-full" type="text" name="patronymic" :value="old('patronymic')" />
            </div>

            <!-- Login -->
            <div class="mt-4">
                <x-label for="login" :value="__('Логин *')" />

                <x-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Почта *')" />

                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Пароль *')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Подтверждение пароля *')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
            </div>

            <div class="mt-4 flex items-center">
                <x-input id="rules" class="block p-2 m-1" type="checkbox" name="rules" />
                <x-label for="rules" href="" ><span>Согласие с <a href="#правила" class="text-sky-500 underline underline-offset-1">правилами</a> регистрации *</span></x-label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Уже зарегистрированы?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Зарегистрироваться') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>