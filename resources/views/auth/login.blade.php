<x-guest-layout>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" />

    <!-- Content -->
    <div class="flex justify-center items-center h-full min-h-screen login-container">
        <div class="max-w-md w-full mx-auto">
            <div class="flex justify-center pb-4">
                <a href="/">
                    <x-application-logo class="w-32 h-32 text-gray-500 object-contain" />
                </a>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form class="bg-opacity-90 bg-white p-6 sm:rounded-2xl" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <h3 class="text-3xl font-extrabold text-center">{{ __('Welcome') }}</h3>
                </div>

                <!-- Username -->
                <div class="w-full">
                    <x-input-label for="username" :value="__('Username')" />
                    <div class="relative flex items-center">
                        <input id="username" type="text" name="username" :value="old('username')" required autofocus
                            class="w-full bg-transparent border border-black rounded-md shadow-sm"
                            autocomplete="username" />
                        <i class="fa-solid fa-id-card-clip absolute right-2"></i>
                    </div>
                    <x-input-error :messages="$errors->get('credentials')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="w-full mt-4" x-data="{ show: false }">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative flex items-center">
                        <input id="password" required name="password" autocomplete="current-password"
                            class="w-full bg-transparent border border-black rounded-md shadow-sm"
                            :type="show ? 'text' : 'password'" />
                        <a class="absolute right-2 cursor-pointer" :class="{ 'hidden': !show, 'block': show }"
                            @click="show = !show"><i class="fa-solid fa-eye"></i></a>
                        <a class="absolute right-2 cursor-pointer" :class="{ 'hidden': show, 'block': !show }"
                            @click="show = !show"><i class="fa-solid fa-eye-slash"></i></a>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-2 mt-6">
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember Me') }}</span>
                        </label>
                    </div>
                    <div>
                        @if (Route::has('prequest.create'))
                            <a class="text-sm font-semibold hover:underline" href="{{ route('prequest.create') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-10">
                    <x-primary-button class="w-full py-2.5 px-4 text-sm font-semibold justify-center">
                        {{ __('Log In') }}
                    </x-primary-button>

                    <!-- Register Button -->
                    <div class="flex items-center justify-center mt-6">
                        <div class="grid grid-cols-1 gap-4 mt-4 justify-items-center">
                            <img src="{{ asset('assets/images/umg.png') }}" alt="logo_umg" class="h-20 w-auto sm:h-10">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Developed by') }}
                            </span>
                        </div>
                    </div>
                    <p class="text-sm text-center mt-2">{{ date('Y') }} &copy; {{ __('Work Rights') }}</p>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
