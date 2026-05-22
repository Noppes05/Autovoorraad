<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&display=swap" rel="stylesheet">

        <!-- Splide CSS -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/publicsite.js'])
    </head>
    <body x-data="publicCarDetail('{{ $tenant->id }}', '{{ $carPublicId }}')" style="--primary_color: {{ $tenant->kleur }}" class="antialiased font-sans">
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
            <div class="mx-12 md:mx-24 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span class="font-semibold">Terug</span>
                </a>
                <img :src="'{{ $tenant->logo ? asset($tenant->logo) : '' }}'" alt="Logo" class="h-8">
            </div>
        </nav>

        <template x-if="loading">
            <div class="flex items-center justify-center min-h-screen">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[var(--primary_color)] mx-auto mb-4"></div>
                    <p class="text-gray-600">Loading car details...</p>
                </div>
            </div>
        </template>

        <template x-if="!loading && car">
            <div>
                <section class="mx-12 md:mx-24 py-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <!-- Left Column: Images and Details -->
                        <div class="lg:col-span-2">
                            <!-- Header -->
                            <div class="mb-8">
                                <template x-if="car.status === 'beschikbaar'">
                                    <span class="inline-block bg-[var(--primary_color)] text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 uppercase" x-text="car.status"></span>
                                </template>
                                <template x-if="car.status === 'net nieuw'">
                                    <span class="inline-block bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 uppercase" x-text="car.status"></span>
                                </template>
                                <template x-if="car.status === 'verkocht'">
                                    <span class="inline-block bg-red-600 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 uppercase" x-text="car.status"></span>
                                </template>
                                <div class="flex justify-between">
                                    <h1 class="text-4xl md:text-5xl font-bold font-serif mb-4" x-text="car.merk + ' ' + car.model"></h1>
                                    <p class="text-3xl font-bold text-[var(--primary_color)]" x-text="formatPrice(car.prijs)"></p>
                                </div>
                            </div>

                            <!-- Main Image Carousel -->
                            <div class="mb-8">
                                <div id="main-carousel" class="splide rounded-lg overflow-hidden border border-gray-200">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <template x-for="foto in car.fotos" :key="foto.url">
                                                <li class="splide__slide">
                                                    <img :src="foto.url" :alt="car.merk + ' ' + car.model" class="w-full h-96 object-cover">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Thumbnail Carousel -->
                            <template x-if="car.fotos.length >= 1">
                                <div class="mb-12">
                                    <div id="thumb-carousel" class="splide">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                <template x-for="foto in car.fotos" :key="foto.url">
                                                    <li class="splide__slide">
                                                        <img :src="foto.url" :alt="car.merk + ' ' + car.model" class="w-full h-24 object-cover rounded cursor-pointer border-2 border-transparent hover:border-[var(--primary_color)] transition-all">
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Car Specs -->
                            <div class="grid grid-cols-3 gap-6 mb-12 py-8 border-t border-b border-gray-200">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none" class="w-8 h-8 text-[var(--primary_color)] mx-auto mb-2">
                                        <path d="M21 28.154C22.1083 28.1388 22.925 27.7375 23.45 26.95L33.25 12.25L18.55 22.05C17.7625 22.575 17.3472 23.3771 17.304 24.4563C17.2608 25.5354 17.5887 26.425 18.2875 27.125C18.9863 27.825 19.8905 28.168 21 28.154ZM21 7C22.7208 7 24.3763 7.24092 25.9665 7.72275C27.5567 8.20458 29.0512 8.92617 30.45 9.8875L27.125 11.9875C26.1625 11.4917 25.1638 11.1201 24.129 10.8727C23.0942 10.6254 22.0512 10.5012 21 10.5C17.1208 10.5 13.8174 11.8638 11.0897 14.5915C8.36208 17.3192 6.99883 20.622 7 24.5C7 25.725 7.168 26.9354 7.504 28.1313C7.84 29.3271 8.31367 30.45 8.925 31.5H33.075C33.7458 30.3917 34.2347 29.2396 34.5415 28.0437C34.8483 26.8479 35.0012 25.6083 35 24.325C35 23.275 34.8758 22.2542 34.6273 21.2625C34.3788 20.2708 34.0072 19.3083 33.5125 18.375L35.6125 15.05C36.4875 16.4208 37.1805 17.8792 37.6915 19.425C38.2025 20.9708 38.472 22.575 38.5 24.2375C38.528 25.9 38.3384 27.4896 37.9312 29.0063C37.5241 30.5229 36.9262 31.9667 36.1375 33.3375C35.8167 33.8625 35.3792 34.2708 34.825 34.5625C34.2708 34.8542 33.6875 35 33.075 35H8.925C8.3125 35 7.72917 34.8542 7.175 34.5625C6.62083 34.2708 6.18333 33.8625 5.8625 33.3375C5.10417 32.025 4.52083 30.6326 4.1125 29.1602C3.70417 27.6879 3.5 26.1345 3.5 24.5C3.5 22.0792 3.95967 19.8117 4.879 17.6978C5.79833 15.5837 7.0525 13.7317 8.6415 12.1415C10.2305 10.5513 12.0896 9.29717 14.2188 8.379C16.3479 7.46083 18.6083 7.00117 21 7Z" fill="currentcolor"/>
                                    </svg>
                                    
                                    <p class="text-sm text-gray-600 uppercase tracking-wider mb-1">KM Stand</p>
                                    <p class="text-lg font-bold" x-text="car.km_stand.toLocaleString() + ' km'"></p>
                                </div>
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none" class="w-8 h-8 text-[var(--primary_color)] mx-auto mb-2">
                                        <g clip-path="url(#clip0_10_1991)">
                                        <path d="M30.638 18.8477C30.137 18.8477 29.8418 19.125 29.8418 19.7423V22.1128C29.8418 22.73 30.1371 23.0074 30.638 23.0074C31.1389 23.0074 31.4431 22.73 31.4431 22.1128V19.7423C31.4431 19.125 31.139 18.8477 30.638 18.8477Z" fill="currentcolor"/>
                                        <path d="M35.7278 18.8477C35.2269 18.8477 34.9316 19.125 34.9316 19.7423V22.1128C34.9316 22.73 35.227 23.0074 35.7278 23.0074C36.2287 23.0074 36.533 22.73 36.533 22.1128V19.7423C36.533 19.125 36.2288 18.8477 35.7278 18.8477Z" fill="currentcolor"/>
                                        <path d="M25.5481 18.8477C25.0472 18.8477 24.752 19.125 24.752 19.7423V22.1128C24.752 22.73 25.0473 23.0074 25.5481 23.0074C26.049 23.0074 26.3533 22.73 26.3533 22.1128V19.7423C26.3533 19.125 26.0492 18.8477 25.5481 18.8477Z" fill="currentcolor"/>
                                        <path d="M37.7908 13.4968H4.20919C1.88828 13.4968 0 15.385 0 17.7059V24.2941C0 26.615 1.88828 28.5033 4.20919 28.5033H37.7909C40.1118 28.5033 42.0001 26.615 42.0001 24.2941V17.7059C42 15.385 40.1117 13.4968 37.7908 13.4968ZM9.92808 14.8693C10.4335 14.8693 10.8431 15.279 10.8431 15.7844C10.8431 16.2898 10.4335 16.6994 9.92808 16.6994C9.42268 16.6994 9.01302 16.2898 9.01302 15.7844C9.0131 15.279 9.42276 14.8693 9.92808 14.8693ZM8.28606 24.0809L6.98004 21.8624L5.67394 24.0808C5.61135 24.1792 5.48609 24.224 5.34294 24.224C4.95838 24.224 4.41262 23.9198 4.41262 23.5352C4.41262 23.4546 4.43945 23.3741 4.49318 23.2847L6.04078 20.8962L4.55577 18.5167C4.4931 18.4183 4.46627 18.3288 4.46627 18.2393C4.46627 17.8637 4.9761 17.5774 5.36977 17.5774C5.56648 17.5774 5.70076 17.6489 5.79026 17.8101L6.97996 19.8855L8.16974 17.8101C8.25923 17.649 8.39335 17.5774 8.59023 17.5774C8.9839 17.5774 9.49372 17.8637 9.49372 18.2393C9.49372 18.3289 9.4669 18.4183 9.40423 18.5167L7.91921 20.8962L9.46681 23.2847C9.52046 23.3742 9.54737 23.4546 9.54737 23.5352C9.54737 23.9198 9.00162 24.224 8.61697 24.224C8.47391 24.224 8.33979 24.1793 8.28606 24.0809ZM9.92808 27.2222C9.42268 27.2222 9.01302 26.8126 9.01302 26.3072C9.01302 25.8018 9.42268 25.3921 9.92808 25.3921C10.4335 25.3921 10.8431 25.8018 10.8431 26.3072C10.8431 26.8126 10.4335 27.2222 9.92808 27.2222ZM14.8341 18.302L12.9912 21.3704C12.9733 21.3972 12.9554 21.4419 12.9554 21.4955V23.7409C12.9554 24.0271 12.6066 24.1703 12.2576 24.1703C11.9086 24.1703 11.5599 24.0271 11.5599 23.7409V21.4955C11.5599 21.4419 11.542 21.3972 11.5241 21.3704L9.67239 18.302C9.65442 18.2662 9.65442 18.2305 9.65442 18.2036C9.65442 17.8726 10.218 17.6311 10.6027 17.6311C10.8263 17.6311 10.9069 17.7206 11.0052 17.8905L12.2576 20.1895L13.501 17.8905C13.5906 17.7206 13.68 17.6311 13.9036 17.6311C14.2882 17.6311 14.8518 17.8727 14.8518 18.2036C14.8521 18.2304 14.8521 18.2662 14.8341 18.302ZM19.1906 24.1703H15.3798C15.0935 24.1703 14.9773 24.0183 14.9773 23.8036C14.9773 23.6604 15.031 23.4815 15.1294 23.3115L17.652 18.8477H15.5765C15.3081 18.8477 15.156 18.5614 15.156 18.2393C15.156 17.9441 15.2813 17.6311 15.5765 17.6311H19.0295C19.2979 17.6311 19.432 17.7831 19.432 17.9979C19.432 18.141 19.3783 18.3109 19.28 18.4899L16.7573 22.9537H19.1905C19.459 22.9537 19.611 23.2758 19.611 23.5621C19.611 23.8483 19.4589 24.1703 19.1906 24.1703ZM27.749 22.1128C27.749 23.6515 26.7828 24.224 25.5483 24.224C24.3138 24.224 23.3566 23.6515 23.3566 22.1128V19.7423C23.3566 18.2036 24.3138 17.6311 25.5483 17.6311C26.7828 17.6311 27.749 18.2036 27.749 19.7423V22.1128ZM28.4464 22.1128V19.7423C28.4464 18.2036 29.4036 17.6311 30.6381 17.6311C31.8726 17.6311 32.8387 18.2036 32.8387 19.7423V22.1128C32.8387 23.6515 31.8726 24.224 30.6381 24.224C29.4036 24.224 28.4464 23.6516 28.4464 22.1128ZM32.0719 27.2222C31.5665 27.2222 31.1569 26.8126 31.1569 26.3072C31.1569 25.8018 31.5665 25.3921 32.0719 25.3921C32.5773 25.3921 32.987 25.8018 32.987 26.3072C32.9869 26.8126 32.5772 27.2222 32.0719 27.2222ZM32.0719 16.6993C31.5665 16.6993 31.1569 16.2897 31.1569 15.7843C31.1569 15.2789 31.5665 14.8692 32.0719 14.8692C32.5773 14.8692 32.987 15.2789 32.987 15.7843C32.9869 16.2897 32.5772 16.6993 32.0719 16.6993ZM37.9285 22.1128C37.9285 23.6515 36.9623 24.224 35.7278 24.224C34.4933 24.224 33.5361 23.6515 33.5361 22.1128V19.7423C33.5361 18.2036 34.4933 17.6311 35.7278 17.6311C36.9623 17.6311 37.9285 18.2036 37.9285 19.7423V22.1128Z" fill="currentcolor"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_10_1991">
                                        <rect width="42" height="42" fill="currentcolor"/>
                                        </clipPath>
                                        </defs>
                                        </svg>
                                    <p class="text-sm text-gray-600 uppercase tracking-wider mb-1">Kenteken</p>
                                    <p class="text-lg font-bold" x-text="car.kenteken"></p>
                                </div>
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8 text-[var(--primary_color)] mx-auto mb-2">
                                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm text-gray-600 uppercase tracking-wider mb-1">Bouwjaar</p>
                                    <p class="text-lg font-bold" x-text="car.bouwjaar"></p>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h2 class="text-2xl font-bold font-serif mb-4">Vehicle Description</h2>
                                <p class="text-gray-600 leading-relaxed" x-text="car.beschrijving"></p>
                            </div>
                        </div>

                        <!-- Right Column: Booking Form -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-8 sticky top-24">
                                <h3 class="text-2xl font-bold font-serif mb-2">Boek een proefrit</h3>
                                <p class="text-sm text-gray-600 mb-6">
                                    Ervaar en beleef deze auto bij <span class="text-[var(--primary_color)] font-semibold">{{ $tenant->naam }}</span>
                                </p>

                                <form @submit.prevent="submitProefrit" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Volledige Naam</label>
                                        <input type="text" x-model="proefritForm.naam" placeholder="John Doe" class="w-full px-4 py-3 rounded border border-gray-300 focus:border-[var(--primary_color)] focus:ring-2 focus:ring-[var(--primary_color)]/20 transition-all">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                        <input type="email" x-model="proefritForm.email" placeholder="john@example.com" class="w-full px-4 py-3 rounded border border-gray-300 focus:border-[var(--primary_color)] focus:ring-2 focus:ring-[var(--primary_color)]/20 transition-all">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Telefoonnummer</label>
                                            <input type="tel" x-model="proefritForm.telefoonnummer" placeholder="06 12345678" class="w-full px-4 py-3 rounded border border-gray-300 focus:border-[var(--primary_color)] focus:ring-2 focus:ring-[var(--primary_color)]/20 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Datum/Tijd</label>
                                            <input type="datetime-local" x-model="proefritForm.datumtijd" class="w-full px-4 py-3 rounded border border-gray-300 focus:border-[var(--primary_color)] focus:ring-2 focus:ring-[var(--primary_color)]/20 transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bericht <span class="font-normal text-gray-500">(optioneel)</span></label>
                                        <textarea x-model="proefritForm.bericht" rows="4" placeholder="Laat hier een bericht achter voor de proefrit" class="w-full px-4 py-3 rounded border border-gray-300 focus:border-(--primary_color) focus:ring-2 focus:ring-[var(--primary_color)] transition-all resize-none"></textarea>
                                    </div>

                                    <template x-if="formMessage">
                                        <div :class="{'bg-green-100 text-green-700': !formMessage.includes('Error'), 'bg-red-100 text-red-700': formMessage.includes('Error')}" class="p-4 rounded text-sm" x-text="formMessage"></div>
                                    </template>

                                    <button type="submit" :disabled="formSubmitting" class="w-full bg-(--primary_color) text-white font-semibold py-4 rounded hover:bg-transparent hover:text-[var(--primary-color)] border border-transparent hover:border-(--primary_color) transition disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer uppercase tracking-wide">
                                        <span x-show="!formSubmitting">Boek jouw proefrit →</span>
                                        <span x-show="formSubmitting">Bezig met verzenden...</span>
                                    </button>
                                </form>

                                <div class="mt-8 pt-8 border-t border-gray-200">
                                    <p class="text-sm text-gray-600 mb-4">Vragen? Neem direct contact op:</p>
                                    <div class="space-y-3">
                                        <a :href="'tel:' + '{{ $tenant->telefoonnummer }}'" class="flex items-center gap-2 text-gray-700 hover:text-[var(--primary_color)] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                                            </svg>
                                            <span x-text="'{{ $tenant->telefoonnummer }}'"></span>
                                        </a>
                                        <a :href="'mailto:' + '{{ $tenant->email }}'" class="flex items-center gap-2 text-gray-700 hover:text-[var(--primary_color)] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                                <polyline points="22,6 12,13 2,6"/>
                                            </svg>
                                            <span x-text="'{{ $tenant->email }}'"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </template>

        <x-public-footer />

        <!-- Splide JS -->
    </body>
</html>
