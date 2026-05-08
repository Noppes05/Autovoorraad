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

{{-- Manrope font --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/publicsite.js'])
    </head>
    {{-- @dd($tenant) --}}
    <body x-data="publicHomePage('{{ $tenant->id }}')" style="--primary_color: {{ $tenant->kleur }}" class="antialiased font-sans">
        <section class="relative w-full ">
            <div class="relative top-0 left-0 w-full h-full overflow-hidden">
                <img src="{{ asset($tenant->herofoto) }}" alt="Background Image" class="w-full h-auto object-center object-cover">
            </div>
            <div style="background-image: linear-gradient(to right, color-mix(in srgb, var(--primary_color) 70%, transparent) 0%, rgba(0, 0, 0, 0.2) 50%);"
                class="absolute z-0 top-0 left-0 flex flex-col items-start h-full mx-auto w-full justify-center  px-4">
                <h1 class="text-5xl md:text-7xl ml-12 md:ml-24  text-white mb-6 w-1/2 ">Welkom bij <b style="color: var(--primary_color)" class="font-semibold">{{ $tenant->naam }}.</b></h1>
                <p class="text-lg md:text-2xl font-light ml-12 md:ml-24 text-white mb-8 w-1/2">{{ $tenant->hero_beschrijving }}</p>
            </div>
        </section>
        <section class="w-full relative -top-10  block">
            <div class="z-20 mx-12 md:mx-24 h-full bg-white rounded-lg border relative border-[var(--primary_color)] p-8">
                <div class="flex gap-4 items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="inline-block" viewBox="0 0 20 20" fill="none">
                    <path d="M9 15H11V9H9V15ZM10 7C10.2833 7 10.5208 6.90417 10.7125 6.7125C10.9042 6.52083 11 6.28333 11 6C11 5.71667 10.9042 5.47917 10.7125 5.2875C10.5208 5.09583 10.2833 5 10 5C9.71667 5 9.47917 5.09583 9.2875 5.2875C9.09583 5.47917 9 5.71667 9 6C9 6.28333 9.09583 6.52083 9.2875 6.7125C9.47917 6.90417 9.71667 7 10 7ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20Z" fill="currentcolor"/>
                    </svg>
                    <h2 class="inline text-2xl font-semibold font-serif">Over <span class="text-[var(--primary_color)]">{{ $tenant->naam}}</span></h2>
                </div>
                <div class="flex gap-10 w-full flex-col md:flex-row">
                    <div class="flex gap-3 md:w-1/4 self-center md:self-start">
                        <div class="bg-[var(--primary_color)] p-3.5 h-min rounded  text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="15" viewBox="0 0 12 15" fill="none">
                            <path d="M6 7.5C6.4125 7.5 6.76562 7.35312 7.05937 7.05937C7.35312 6.76562 7.5 6.4125 7.5 6C7.5 5.5875 7.35312 5.23438 7.05937 4.94063C6.76562 4.64688 6.4125 4.5 6 4.5C5.5875 4.5 5.23438 4.64688 4.94063 4.94063C4.64688 5.23438 4.5 5.5875 4.5 6C4.5 6.4125 4.64688 6.76562 4.94063 7.05937C5.23438 7.35312 5.5875 7.5 6 7.5ZM6 13.0125C7.525 11.6125 8.65625 10.3406 9.39375 9.19687C10.1313 8.05312 10.5 7.0375 10.5 6.15C10.5 4.7875 10.0656 3.67188 9.19687 2.80312C8.32812 1.93437 7.2625 1.5 6 1.5C4.7375 1.5 3.67188 1.93437 2.80312 2.80312C1.93437 3.67188 1.5 4.7875 1.5 6.15C1.5 7.0375 1.86875 8.05312 2.60625 9.19687C3.34375 10.3406 4.475 11.6125 6 13.0125ZM6 15C3.9875 13.2875 2.48438 11.6969 1.49063 10.2281C0.496875 8.75937 0 7.4 0 6.15C0 4.275 0.603125 2.78125 1.80938 1.66875C3.01562 0.55625 4.4125 0 6 0C7.5875 0 8.98438 0.55625 10.1906 1.66875C11.3969 2.78125 12 4.275 12 6.15C12 7.4 11.5031 8.75937 10.5094 10.2281C9.51562 11.6969 8.0125 13.2875 6 15Z" fill="currentcolor"/>
                            </svg>
                        </div>
                        <div>
                            <p class="uppercase relative text-[#454652] text-sm tracking-wider font-semibold">adres</p>
                            <p class="text-md font-bold tracking-wider">{{$tenant->adres}}, {{ $tenant->plaats }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3  md:w-1/4  self-center md:self-start">
                        <div class="bg-[var(--primary_color)] p-3.5 h-min rounded text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path d="M2.25 15C1.8375 15 1.48437 14.8531 1.19062 14.5594C0.896875 14.2656 0.75 13.9125 0.75 13.5V5.04375C0.525 4.90625 0.34375 4.72813 0.20625 4.50938C0.06875 4.29063 0 4.0375 0 3.75V1.5C0 1.0875 0.146875 0.734375 0.440625 0.440625C0.734375 0.146875 1.0875 0 1.5 0H13.5C13.9125 0 14.2656 0.146875 14.5594 0.440625C14.8531 0.734375 15 1.0875 15 1.5V3.75C15 4.0375 14.9312 4.29063 14.7937 4.50938C14.6562 4.72813 14.475 4.90625 14.25 5.04375V13.5C14.25 13.9125 14.1031 14.2656 13.8094 14.5594C13.5156 14.8531 13.1625 15 12.75 15H2.25ZM2.25 5.25V13.5H12.75V5.25H2.25ZM1.5 3.75H13.5V1.5H1.5V3.75ZM5.25 9H9.75V7.5H5.25V9Z" fill="currentcolor"/>
                            </svg>
                        </div>
                        <div>
                            <p class="uppercase relative text-[#454652] text-sm tracking-wider font-semibold">aantal op voorraad</p>
                            <p class="text-md font-bold tracking-wider">24 auto's</p>
                        </div>
                    </div>
                    <div class="flex gap-3  md:w-1/4  self-center md:self-start">
                        <div class="bg-[var(--primary_color)] p-3.5 h-min rounded text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12" fill="none">
                                <path d="M1.5 12C1.0875 12 0.734375 11.8531 0.440625 11.5594C0.146875 11.2656 0 10.9125 0 10.5V1.5C0 1.0875 0.146875 0.734375 0.440625 0.440625C0.734375 0.146875 1.0875 0 1.5 0H13.5C13.9125 0 14.2656 0.146875 14.5594 0.440625C14.8531 0.734375 15 1.0875 15 1.5V10.5C15 10.9125 14.8531 11.2656 14.5594 11.5594C14.2656 11.8531 13.9125 12 13.5 12H1.5V12M7.5 6.75L1.5 3V10.5V10.5V10.5H13.5V10.5V10.5V3L7.5 6.75V6.75M7.5 5.25L13.5 1.5H1.5L7.5 5.25V5.25M1.5 3V1.5V1.5V3V10.5V10.5V10.5V10.5V10.5V10.5V3V3" fill="currentcolor"/>
                                </svg>
                        </div>
                        <div>
                            <p class="uppercase relative text-[#454652] text-sm tracking-wider font-semibold">email</p>
                            <p class="text-md font-bold tracking-wider">{{$tenant->email}}</p>
                        </div>
                    </div>
                    <div class="flex gap-3  md:w-1/4  self-center md:self-start">
                        <div class="bg-[var(--primary_color)] p-3.5 h-min rounded text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M12.7125 13.5C11.15 13.5 9.60625 13.1594 8.08125 12.4781C6.55625 11.7969 5.16875 10.8313 3.91875 9.58125C2.66875 8.33125 1.70312 6.94375 1.02188 5.41875C0.340625 3.89375 0 2.35 0 0.7875C0 0.5625 0.075 0.375 0.225 0.225C0.375 0.075 0.5625 0 0.7875 0H3.825C4 0 4.15625 0.059375 4.29375 0.178125C4.43125 0.296875 4.5125 0.4375 4.5375 0.6L5.025 3.225C5.05 3.425 5.04375 3.59375 5.00625 3.73125C4.96875 3.86875 4.9 3.9875 4.8 4.0875L2.98125 5.925C3.23125 6.3875 3.52813 6.83437 3.87188 7.26562C4.21562 7.69688 4.59375 8.1125 5.00625 8.5125C5.39375 8.9 5.8 9.25937 6.225 9.59062C6.65 9.92188 7.1 10.225 7.575 10.5L9.3375 8.7375C9.45 8.625 9.59688 8.54062 9.77812 8.48438C9.95937 8.42813 10.1375 8.4125 10.3125 8.4375L12.9 8.9625C13.075 9.0125 13.2188 9.10312 13.3313 9.23438C13.4438 9.36563 13.5 9.5125 13.5 9.675V12.7125C13.5 12.9375 13.425 13.125 13.275 13.275C13.125 13.425 12.9375 13.5 12.7125 13.5ZM2.26875 4.5L3.50625 3.2625L3.1875 1.5H1.51875C1.58125 2.0125 1.66875 2.51875 1.78125 3.01875C1.89375 3.51875 2.05625 4.0125 2.26875 4.5ZM8.98125 11.2125C9.46875 11.425 9.96562 11.5938 10.4719 11.7188C10.9781 11.8438 11.4875 11.925 12 11.9625V10.3125L10.2375 9.95625L8.98125 11.2125Z" fill="currentcolor"/>
                            </svg>
                        </div>
                        <div>
                            <p class="uppercase relative text-[#454652] text-sm tracking-wider font-semibold">telefoonnummer</p>
                            <p class="text-md font-bold tracking-wider">{{$tenant->telefoonnummer}}</p>
                        </div>
                    </div>
                </div>
                <div class="h-px rounded-full  my-5 bg-[var(--primary_color)]"></div>
                <div class="flex gap-4 items-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[var(--primary_color)]" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M8 18V12H10V14H18V16H10V18H8ZM0 16V14H6V16H0ZM4 12V10H0V8H4V6H6V12H4ZM8 10V8H18V10H8ZM12 6V0H14V2H18V4H14V6H12ZM0 4V2H10V4H0Z" fill="currentcolor"/>
                    </svg>
                    <h2 class="inline text-2xl  font-semibold font-serif uppercase">Filters</h2>
                </div>   
                <div class="flex w-full gap-4 flex-col md:flex-row">
                    <div class="md:w-1/4 relative">
                        <p class="uppercase relative text-[#454652] text-sm tracking-wider mb-3 font-semibold">merk</p>
                        <button @click="toggleDropdown('brands')" class="w-full rounded p-4 bg-gray-100 text-sm text-left font-medium hover:bg-gray-200 transition-colors duration-200 flex justify-between items-center group">
                            <span x-show="filters.brands.length === 0">Alle merken</span>
                            <span x-show="filters.brands.length > 0" x-text="filters.brands.length + ' geselecteerd'"></span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:text-[var(--primary_color)]" :class="{'rotate-180': openDropdown === 'brands'}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>
                        <div x-show="openDropdown === 'brands'" @click.outside="closeDropdown()" x-transition class="absolute top-full left-0 right-0 mt-2 bg-white rounded border border-[var(--primary_color)] shadow-lg z-50">
                            <div class="p-4 space-y-3 max-h-60 overflow-y-auto">
                                <template x-for="merk in merken" :key="merk">
                                    <label class="flex items-center cursor-pointer group/checkbox">
                                        <input type="checkbox" class="sr-only" @change="toggleBrand(merk)" :checked="isBrandSelected(merk)">
                                        <div class="w-5 h-5 rounded border-2 border-gray-300 bg-white group-hover/checkbox:border-[var(--primary_color)] transition-all duration-200 flex items-center justify-center" :class="{'bg-[var(--primary_color)] border-[var(--primary_color)]': isBrandSelected(merk)}">
                                            <template x-if="isBrandSelected(merk)">
                                                <svg class="w-3.5 h-3.5 text-[var(--primary_color)]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </template>
                                        </div>
                                        <span class="ml-3 text-sm font-medium group-hover/checkbox:text-[var(--primary_color)] transition-colors duration-200" x-text="merk"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-1/4 relative">
                        <p class="uppercase relative text-[#454652] text-sm tracking-wider mb-3 font-semibold">model</p>
                        <button @click="toggleDropdown('models')" :disabled="filters.brands.length === 0" class="w-full rounded p-4 bg-gray-100 text-sm text-left font-medium hover:bg-gray-200 transition-colors duration-200 flex justify-between items-center group disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-gray-100">
                            <span x-show="filters.models.length === 0">Selecteer model</span>
                            <span x-show="filters.models.length > 0" x-text="filters.models.length + ' geselecteerd'"></span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:text-[var(--primary_color)]" :class="{'rotate-180': openDropdown === 'models'}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>
                        <div x-show="openDropdown === 'models'" @click.outside="closeDropdown()" x-transition class="absolute top-full left-0 right-0 mt-2 bg-white rounded border border-[var(--primary_color)] shadow-lg z-50">
                            <div class="p-4 space-y-3 max-h-60 overflow-y-auto">
                                <template x-for="model in availableModels" :key="model">
                                    <label class="flex items-center cursor-pointer group/checkbox">
                                        <input type="checkbox" class="sr-only" @change="toggleModel(model)" :checked="isModelSelected(model)">
                                        <div class="w-5 h-5 rounded border-2 border-gray-300 bg-white group-hover/checkbox:border-[var(--primary_color)] transition-all duration-200 flex items-center justify-center" :class="{'bg-[var(--primary_color)] border-[var(--primary_color)]': isModelSelected(model)}">
                                            <template x-if="isModelSelected(model)">
                                                <svg class="w-3.5 h-3.5 text-[var(--primary_color)]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </template>
                                        </div>
                                        <span class="ml-3 text-sm font-medium group-hover/checkbox:text-[var(--primary_color)] transition-colors duration-200" x-text="model"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-1/4">
                        <p class="uppercase relative text-[#454652] text-sm tracking-wider mb-3 font-semibold">min prijs</p>
                        <div class="rounded p-4 bg-gray-100 text-sm">
                            <input class="w-full rounded border-gray-300 focus:border-[var(--primary_color)] focus:ring-[var(--primary_color)] transition-colors duration-200" placeholder="€0" type="number" x-model="tempMinPrice" @blur="onPriceBlur('min')"/>
                        </div>
                    </div>

                    <div class="md:w-1/4">
                        <p class="uppercase relative text-[#454652] text-sm tracking-wider mb-3 font-semibold">max prijs</p>
                        <div class="rounded p-4 bg-gray-100 text-sm">
                            <input class="w-full rounded border-gray-300 focus:border-[var(--primary_color)] focus:ring-[var(--primary_color)] transition-colors duration-200" placeholder="€100.000" type="number" x-model="tempMaxPrice" @blur="onPriceBlur('max')"/>
                        </div>
                    </div>

                </div>
        </section>
        <section class="mx-12 md:mx-24 mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative">
            <template x-for="car in cars" :key="car.id">
                <div
                    x-show="carMatchesFilter(car)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="border border-[var(--primary_color)] group rounded-lg overflow-hidden">
                    <div class="h-65 w-full relative overflow-hidden">
                        <img :src="car.fotos[0].url" alt="Car Image" class="w-full group-hover:scale-110 h-full transition-all duration-200 object-cover object-center">
                        <template x-if="car.status === 'beschikbaar'">
                            <span class="absolute top-3.5 bg-black-pearl-600 left-3.5 py-1 font-semibold text-white px-4 text-sm rounded-full uppercase" x-text="car.status"></span>
                        </template>
                        <template x-if="car.status === 'verkocht'">
                            <span class="absolute top-3.5 bg-red-800 left-3.5 p-2 px-4 text-sm text-white font-semibold rounded-full uppercase" x-text="car.status"></span>
                        </template>
                        <template x-if="car.status === 'net nieuw'">
                            <span class="absolute top-3.5 bg-black-pearl-950 left-3.5 p-2 px-4 text-sm text-white font-semibold rounded-full uppercase" x-text="car.status"></span>
                        </template>
                    </div>
                    <div class="p-4 flex flex-col justify-between">
                        <div class="flex justify-between mt-4">
                            <p class="text-gray-400/60 font-semibold text-sm" x-text="car.bouwjaar"></p>
                            <p class="text-gray-800 text-lg font-bold tracking-tight" x-text="formatPrice(car.prijs)"></p>
                        </div>
                        <h3 class="text-xl font-serif tracking-wide font-bold mb-6" x-text="car.merk + ' ' + car.model"></h3>
                        <div class="mb-6 text-gray-600  flex items-center gap-1 font-normal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline" width="12" height="10" viewBox="0 0 12 10" fill="none">
                            <path d="M4.92917 6.70833C5.1625 6.94167 5.46389 7.0559 5.83333 7.05104C6.20278 7.04618 6.475 6.9125 6.65 6.65L9.91667 1.75L5.01667 5.01667C4.75417 5.19167 4.61562 5.45903 4.60104 5.81875C4.58646 6.17847 4.69583 6.475 4.92917 6.70833ZM5.83333 0C6.40694 0 6.95868 0.0802083 7.48854 0.240625C8.0184 0.401042 8.51667 0.641667 8.98333 0.9625L7.875 1.6625C7.55417 1.49722 7.22118 1.37326 6.87604 1.29062C6.5309 1.20799 6.18333 1.16667 5.83333 1.16667C4.54028 1.16667 3.43924 1.62118 2.53021 2.53021C1.62118 3.43924 1.16667 4.54028 1.16667 5.83333C1.16667 6.24167 1.22257 6.64514 1.33438 7.04375C1.44618 7.44236 1.60417 7.81667 1.80833 8.16667H9.85833C10.0819 7.79722 10.2448 7.41319 10.3469 7.01458C10.449 6.61597 10.5 6.20278 10.5 5.775C10.5 5.425 10.4587 5.08472 10.376 4.75417C10.2934 4.42361 10.1694 4.10278 10.0042 3.79167L10.7042 2.68333C10.9958 3.14028 11.2267 3.62639 11.3969 4.14167C11.567 4.65694 11.6569 5.19167 11.6667 5.74583C11.6764 6.3 11.6132 6.82986 11.4771 7.33542C11.341 7.84097 11.1417 8.32222 10.8792 8.77917C10.7722 8.95417 10.6264 9.09028 10.4417 9.1875C10.2569 9.28472 10.0625 9.33333 9.85833 9.33333H1.80833C1.60417 9.33333 1.40972 9.28472 1.225 9.1875C1.04028 9.09028 0.894444 8.95417 0.7875 8.77917C0.534722 8.34167 0.340278 7.87743 0.204167 7.38646C0.0680556 6.89549 0 6.37778 0 5.83333C0 5.02639 0.153125 4.27049 0.459375 3.56562C0.765625 2.86076 1.18368 2.2434 1.71354 1.71354C2.2434 1.18368 2.86319 0.765625 3.57292 0.459375C4.28264 0.153125 5.03611 0 5.83333 0Z" fill="currentcolor"/>
                            </svg>
                            <p class="inline" x-text="car.km_stand + ' km'"></p>
                        </div>
                        <template x-if="car.status === 'beschikbaar'|| car.status === 'net nieuw'">
                        <a href="#" class="text-[var(--primary_color)] w-full py-4 border-2 text-center border-[var(--primary_color)] rounded text-[var(--primary_color)] hover:text-white bg-transparent hover:bg-[var(--primary_color)] uppercase transition duration-200 font-semibold">Bekijk Details</a>
                        </template>
                        <template x-if="car.status === 'verkocht'">
                            <a href="#" class="text-[var(--primary_color)]/60  w-full py-4 border-2 text-center border-[var(--primary_color)]/60 rounded bg-transparent uppercase font-semibold cursor-not-allowed">nu niet beschikbaar</a>
                        </template>
                    </div>

                </div>
            </template>
    </section>
    <x-public-footer />
    </body>
</html>

{{-- {{ dd($tenant) }} --}}
