<x-guest-layout>
    <!-- Session Status -->
    <div class="flex md:flex-row flex-col h-full md:h-screen w-screen">
        <div class="md:w-1/2 p-12 bg-white">

        <div class="w-full lg:w-2/5 mx-auto">
            <img class="object cover w-full h-full" src="{{ asset('img/Autovoorraad/logo.png') }}" alt="">
        </div>
        <h2 class="text-2xl font-semibold">Welkom terug</h2>
        <p class="text-gray-500 mb-6">Log in op uw dealer dashboard om uw voorraad te
beheren.</p>
        <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-mailadress')" />
            <div class="flex items-center bg-gray-200 text-black rounded-md mt-1 p-4 gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="14" viewBox="0 0 17 14" fill="none">
                <path d="M1.66667 13.3333C1.20833 13.3333 0.815972 13.1701 0.489583 12.8438C0.163194 12.5174 0 12.125 0 11.6667V1.66667C0 1.20833 0.163194 0.815972 0.489583 0.489583C0.815972 0.163194 1.20833 0 1.66667 0H15C15.4583 0 15.8507 0.163194 16.1771 0.489583C16.5035 0.815972 16.6667 1.20833 16.6667 1.66667V11.6667C16.6667 12.125 16.5035 12.5174 16.1771 12.8438C15.8507 13.1701 15.4583 13.3333 15 13.3333H1.66667ZM8.33333 7.5L1.66667 3.33333V11.6667H15V3.33333L8.33333 7.5ZM8.33333 5.83333L15 1.66667H1.66667L8.33333 5.83333ZM1.66667 3.33333V1.66667V3.33333V11.6667V3.33333Z" fill="currentcolor"/>
                </svg>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex justify-between">
                <x-input-label for="password" :value="__('wachtwoord')" />
                <a class="underline text-sm text-blaze-orange-600 hover:text-blaze-orange-400 transition" href="{{ route('password.request') }}">
                        {{ __('Wachtwoord vergeten?') }}
                    </a>
            </div>
            <div x-data="{isPassword: false}" class="flex items-center bg-gray-200 text-black rounded-md mt-1 p-4 gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="18" viewBox="0 0 14 18" fill="none">
                   <path d="M1.66667 17.5C1.20833 17.5 0.815972 17.3368 0.489583 17.0104C0.163194 16.684 0 16.2917 0 15.8333V7.5C0 7.04167 0.163194 6.64931 0.489583 6.32292C0.815972 5.99653 1.20833 5.83333 1.66667 5.83333H2.5V4.16667C2.5 3.01389 2.90625 2.03125 3.71875 1.21875C4.53125 0.40625 5.51389 0 6.66667 0C7.81944 0 8.80208 0.40625 9.61458 1.21875C10.4271 2.03125 10.8333 3.01389 10.8333 4.16667V5.83333H11.6667C12.125 5.83333 12.5174 5.99653 12.8438 6.32292C13.1701 6.64931 13.3333 7.04167 13.3333 7.5V15.8333C13.3333 16.2917 13.1701 16.684 12.8438 17.0104C12.5174 17.3368 12.125 17.5 11.6667 17.5H1.66667ZM1.66667 15.8333H11.6667V7.5H1.66667V15.8333ZM6.66667 13.3333C7.125 13.3333 7.51736 13.1701 7.84375 12.8438C8.17014 12.5174 8.33333 12.125 8.33333 11.6667C8.33333 11.2083 8.17014 10.816 7.84375 10.4896C7.51736 10.1632 7.125 10 6.66667 10C6.20833 10 5.81597 10.1632 5.48958 10.4896C5.16319 10.816 5 11.2083 5 11.6667C5 12.125 5.16319 12.5174 5.48958 12.8438C5.81597 13.1701 6.20833 13.3333 6.66667 13.3333ZM4.16667 5.83333H9.16667V4.16667C9.16667 3.47222 8.92361 2.88194 8.4375 2.39583C7.95139 1.90972 7.36111 1.66667 6.66667 1.66667C5.97222 1.66667 5.38194 1.90972 4.89583 2.39583C4.40972 2.88194 4.16667 3.47222 4.16667 4.16667V5.83333ZM1.66667 15.8333V7.5V15.8333Z" fill="#767683"/>
                </svg>
                <input id="password" class="block mt-1 w-full outline-none"
                                :type="isPassword ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password" />
                                <div class="cursor-pointer" x-on:click="isPassword = !isPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="13" viewBox="0 0 19 13" fill="none">
                                        <path d="M9.16667 10C10.2083 10 11.0938 9.63542 11.8229 8.90625C12.5521 8.17708 12.9167 7.29167 12.9167 6.25C12.9167 5.20833 12.5521 4.32292 11.8229 3.59375C11.0938 2.86458 10.2083 2.5 9.16667 2.5C8.125 2.5 7.23958 2.86458 6.51042 3.59375C5.78125 4.32292 5.41667 5.20833 5.41667 6.25C5.41667 7.29167 5.78125 8.17708 6.51042 8.90625C7.23958 9.63542 8.125 10 9.16667 10ZM9.16667 8.5C8.54167 8.5 8.01042 8.28125 7.57292 7.84375C7.13542 7.40625 6.91667 6.875 6.91667 6.25C6.91667 5.625 7.13542 5.09375 7.57292 4.65625C8.01042 4.21875 8.54167 4 9.16667 4C9.79167 4 10.3229 4.21875 10.7604 4.65625C11.1979 5.09375 11.4167 5.625 11.4167 6.25C11.4167 6.875 11.1979 7.40625 10.7604 7.84375C10.3229 8.28125 9.79167 8.5 9.16667 8.5ZM9.16667 12.5C7.13889 12.5 5.29167 11.934 3.625 10.8021C1.95833 9.67014 0.75 8.15278 0 6.25C0.75 4.34722 1.95833 2.82986 3.625 1.69792C5.29167 0.565972 7.13889 0 9.16667 0C11.1944 0 13.0417 0.565972 14.7083 1.69792C16.375 2.82986 17.5833 4.34722 18.3333 6.25C17.5833 8.15278 16.375 9.67014 14.7083 10.8021C13.0417 11.934 11.1944 12.5 9.16667 12.5ZM9.16667 10.8333C10.7361 10.8333 12.1771 10.4201 13.4896 9.59375C14.8021 8.76736 15.8056 7.65278 16.5 6.25C15.8056 4.84722 14.8021 3.73264 13.4896 2.90625C12.1771 2.07986 10.7361 1.66667 9.16667 1.66667C7.59722 1.66667 6.15625 2.07986 4.84375 2.90625C3.53125 3.73264 2.52778 4.84722 1.83333 6.25C2.52778 7.65278 3.53125 8.76736 4.84375 9.59375C6.15625 10.4201 7.59722 10.8333 9.16667 10.8333Z" fill="#767683"/>
                                    </svg>

                                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-900 border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Onthoud me') }}</span>
            </label>
        </div>
        <div class="">
            <a href="{{ route("register") }}">Registreer als nieuw autobedrijf</a>
        </div>
        <div class="mt-4">
            <x-primary-button class="">
                {{ __('Inloggen') }}
            </x-primary-button>
        </div>
    </form>
        </div>
        <div class="md:w-1/2 relative">
            <div class="absolute w-full h-full bg-linear-to-t from-black-pearl-950 to-transparent z-10">
                <div class="bottom-0 p-6 absolute">
                    <span class="bg-blaze-orange-600 p-1.5 px-4 text-xs leading-16 tracking-[2px] font-medium text-white uppercase rounded-4xl">dealers first</span>
                    <h1 class="text-6xl font-serif font-bold tracking-tight leading-16 text-white mb-4">De slimste weg naar uw voorraadbeheer.</h1>
                </div>
            </div>
            <img src="{{ asset('img/Autovoorraad/login_bg.png') }}" alt="Background image" class="object-contain md:object-cover h-full w-full">
        </div>
        
    </div>

    
</x-guest-layout>
