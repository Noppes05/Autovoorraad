<x-app-layout>
    <div class="w-full p-4 md:p-10" x-data="autoDetails(@js(request()->route('id')))" x-init="init()" x-cloak>
        <div class="flex flex-col md:flex-row justify-between mb-8 gap-4">
            <div>
                <p class="text-[0.7rem] uppercase tracking-[0.4em] text-[#2B4963] font-semibold mb-3">Auto details</p>
                <h1 class="text-3xl font-serif tracking-tight font-bold" x-text="auto ? `${auto.merk} ${auto.model}` : 'Auto laden...'"></h1>
            </div>
            <div class="h-full my-auto flex md:flex-row flex-col gap-6 items-center justify-end">
                <button x-show="auto" @click.stop="confirmDelete(auto)" class="bg-[#E67272] cursor-pointer flex justify-between items-center gap-5 hover:opacity-90 transition text-black-pearl-950 font-semibold p-2 md:px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14" fill="none">
                        <path d="M2.25 13.5C1.8375 13.5 1.48438 13.3531 1.19062 13.0594C0.896875 12.7656 0.75 12.4125 0.75 12V2.25H0V0.75H3.75V0H8.25V0.75H12V2.25H11.25V12C11.25 12.4125 11.1031 12.7656 10.8094 13.0594C10.5156 13.3531 10.1625 13.5 9.75 13.5H2.25ZM9.75 2.25H2.25V12H9.75V2.25ZM3.75 10.5H5.25V3.75H3.75V10.5ZM6.75 10.5H8.25V3.75H6.75V10.5ZM2.25 2.25V12V2.25Z" fill="currentcolor"/>
                    </svg>
                    Verwijderen
                </button>
                <button x-show="auto" @click.stop="alert('Clicked update')" class="bg-black-pearl-700 cursor-pointer hover:bg-black-pearl-800 flex justify-between items-center gap-5 transition text-white font-semibold p-2 md:px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M1.5 12H2.56875L9.9 4.66875L8.83125 3.6L1.5 10.9312V12ZM0 13.5V10.3125L9.9 0.43125C10.05 0.29375 10.2156 0.1875 10.3969 0.1125C10.5781 0.0375 10.7688 0 10.9688 0C11.1687 0 11.3625 0.0375 11.55 0.1125C11.7375 0.1875 11.9 0.3 12.0375 0.45L13.0688 1.5C13.2188 1.6375 13.3281 1.8 13.3969 1.9875C13.4656 2.175 13.5 2.3625 13.5 2.55C13.5 2.75 13.4656 2.94062 13.3969 3.12188C13.3281 3.30313 13.2188 3.46875 13.0688 3.61875L3.1875 13.5H0ZM12 2.55L10.95 1.5L12 2.55ZM9.35625 4.14375L8.83125 3.6L9.9 4.66875L9.35625 4.14375Z" fill="currentcolor"/>
                    </svg>
                    Bewerken
                </button>
            </div>
        </div>

        <div x-show="loading" class="rounded-2xl bg-white/80 shadow p-8">
            <div class="h-4 w-40 bg-gray-200 rounded animate-pulse mb-4"></div>
            <div class="h-10 w-72 bg-gray-200 rounded animate-pulse mb-2"></div>
            <div class="h-64 w-full bg-gray-200 rounded-2xl animate-pulse"></div>
        </div>

        <div x-show="error && !loading" class="rounded-2xl bg-red-50 border border-red-200 text-red-700 p-6">
            <p class="font-semibold" x-text="error"></p>
        </div>

        <div x-show="auto && !loading" class="grid grid-cols-1 grid-rows-2 md:grid-cols-3 md:grid-rows-1 gap-10 h-full w-full">
            <div class="md:col-span-2">
                <div class="grid gap-4 grid-flow-row-dense grid-cols-2 grid-rows-2 md:grid-cols-4 md:grid-rows-2">
                    <div class="h-min md:h-full min-h-0 relative bg-white row-span-3 md:row-span-2 col-span-2 md:col-span-3 rounded-xl overflow-hidden">
                        <img :src="photoUrl(auto.fotos?.[0]?.foto_path)" alt="Auto Foto" class="absolute inset-0 object-cover w-full h-full rounded-xl">
                    </div>
                    <div class="bg-white h-min md:h-50 rounded-2xl overflow-hidden">
                        <img :src="photoUrl(auto.fotos?.[1]?.foto_path)" alt="Auto Foto" class="object-cover w-full h-full rounded-xl">
                    </div>
                    <div class="bg-white h-min md:h-50 rounded-2xl z-1 overflow-hidden group relative cursor-pointer" @click="openPhotoGallery(auto.fotos)">
                        <div class="absolute  z-10 h-full w-full flex justify-center items-center text-xl text-center text-semibold text-white group-hover:text-2xl transition-all ease-in gap-2 flex-col ">
                            <div>
                                <p x-text="'+' + (auto.fotos?.length ?? 0)"></p>
                                <p>Bekijk alles</p>
                            </div>
                        </div>
                        <img :src="photoUrl(auto.fotos?.[2]?.foto_path)" alt="Auto Foto" class="object-cover group-hover:blur-none transition ease-in blur-sm w-full h-full rounded-xl">
                    </div>
                </div>

                <div class="grid md:grid-cols-3 grid-rows-3 mt-10 md:grid-rows-1 gap-10">
                    <div class="bg-white rounded-xl h-30 p-4 flex flex-col gap-2">
                        <p class="text-[0.7rem] font-semibold uppercase tracking-widest font-sans text-[#2B4963]">Prijs</p>
                        <h3 class="text-xl font-bold tracking-tight font-serif" x-text="formatPrice(auto.prijs)"></h3>
                    </div>
                    <div class="bg-white rounded-xl h-30 p-4 flex flex-col gap-2">
                        <p class="text-[0.7rem] font-semibold uppercase tracking-widest font-sans text-[#2B4963]">kilometerstand</p>
                        <h3 class="text-xl font-bold tracking-tight font-serif" x-text="`${formatNumber(auto.km_stand)} km`"></h3>
                    </div>
                    <div class="bg-white rounded-xl h-30 p-4 flex flex-col gap-2">
                        <p class="text-[0.7rem] font-semibold uppercase tracking-widest font-sans text-[#2B4963]">Bouwjaar</p>
                        <h3 class="text-xl font-bold tracking-tight font-serif" x-text="auto.bouwjaar"></h3>
                    </div>
                </div>
            </div>

            <div class="h-full flex flex-col w-full">
                <div class="bg-white h-full flex flex-col gap-4 w-full relative shadow rounded-2xl p-6">
                    <p class="mb-3 before:h-2 uppercase before:w-2 before:rounded-full before:content-[''] before:inline-block before:mr-4 tracking-tight font-sans text-[#2B4963]" :class="statusClass(auto.status)">
                        Status van Auto: <b x-text="auto.status"></b>
                    </p>
                    <p class="font-sans uppercase font-light text-sm">dagen in voorraad</p>
                    <h3 class="text-5xl mb-3 tracking-wider font-semibold" x-text="daysInStock ?? 'N/A'"></h3>
                    <div class="bg-yellow-400 p-1 rounded text-center">
                        <p class="text-md uppercase font-bold p-2" x-text="auto.kenteken"></p>
                    </div>
                </div>
                <div class="bg-gray-100 shadow mt-10 p-6 h-full w-full rounded-2xl">
                    <p class="uppercase mb-6 font-semibold tracking-wide font-sans">beheer acties</p>
                    <button class="uppercase cursor-pointer hover:bg-blaze-orange-900 bg-blaze-orange-950 text-blaze-orange-500 p-4 w-full font-bold rounded text-center">verkocht melden</button>
                    <button class="bg-white p-4 w-full hover:text-white hover:bg-black-pearl-950 cursor-pointer transition font-bold rounded text-center flex items-center gap-4 justify-between mt-6">
                        <div class="flex gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                                <path d="M7.95 16.35L4.4 12.8L5.85 11.35L7.95 13.45L12.15 9.25L13.6 10.7L7.95 16.35V16.35M2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4C0 3.45 0.195833 2.97917 0.5875 2.5875C0.979167 2.19583 1.45 2 2 2H3V0H5V2H13V0H15V2H16C16.55 2 17.0208 2.19583 17.4125 2.5875C17.8042 2.97917 18 3.45 18 4V18C18 18.55 17.8042 19.0208 17.4125 19.4125C17.0208 19.8042 16.55 20 16 20H2V20M2 18H16V18V18V8H2V18V18V18V18M2 6H16V4V4V4H2V4V4V6V6M2 6V4V4V4V4V4V4V6V6V6" fill="currentcolor"/>
                            </svg>
                            Proefrit plannen
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="self-center" width="8" height="12" viewBox="0 0 8 12" fill="none">
                            <path d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z" fill="currentcolor"/>
                        </svg>
                    </button>
                    <button class="p-4 cursor-pointer bg-white w-full mt-6 font-bold hover:bg-blaze-orange-100 flex rounded text-blaze-orange-600 gap-4 justify-between">
                        <div class="flex gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="self-center" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7 12H17L13.55 7.5L11.25 10.5L9.7 8.5L7 12ZM6 16C5.45 16 4.97917 15.8042 4.5875 15.4125C4.19583 15.0208 4 14.55 4 14V2C4 1.45 4.19583 0.979167 4.5875 0.5875C4.97917 0.195833 5.45 0 6 0H18C18.55 0 19.0208 0.195833 19.4125 0.5875C19.8042 0.979167 20 1.45 20 2V14C20 14.55 19.8042 15.0208 19.4125 15.4125C19.0208 15.8042 18.55 16 18 16H6ZM6 14H18V2H6V14ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4H2V18H16V20H2ZM6 2V14V2Z" fill="currentcolor"/>
                            </svg>
                            <p>Beheer foto's</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="self-center" width="8" height="12" viewBox="0 0 8 12" fill="none">
                            <path d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z" fill="currentcolor"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <x-x-confirm-delete />
</x-app-layout>
