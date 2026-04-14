<x-app-layout>
    <div class="p-4 md:p-10" x-data="updateCar(@js($auto), @js($initialFotos))">
        <div class="md:w-full flex flex-col gap-4 md:gap-0 md:flex-row items-center justify-center md:justify-between mb-4">
            <div>
                <h1 class="text-2xl md:text-4xl font-serif font-bold text-gray-800">Auto Bewerken</h1>
                <p class="text-md">Werk voertuiggegevens en foto's bij.</p>
            </div>
            <div class="flex self-start gap-4 md:gap-0 md:flex-row flex-col">
                <a @click="window.location.href = `/auto/${autoId}`" class="ml-4 inline-flex items-center px-4 py-3 border border-black-pearl-950 hover:bg-black-pearl-950 hover:text-white rounded-md font-semibold text-xs text-black-pearl-950 uppercase tracking-widest transition duration-150 ease-in-out">
                    Annuleren
                </a>
                <a @click="saveUpdate()" :class="isSaving ? 'opacity-70 pointer-events-none' : ''" class="ml-4 inline-flex items-center px-4 py-3 bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 transition duration-150 ease-in-out">
                    Opslaan
                    <template x-if="isSaved">
                        <svg class="w-5 h-5 text-fg-success shrink-0 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </template>
                </a>
            </div>
        </div>

        <div x-show="status === 'basisinformatie'" x-transition>
            <div class="p-2 md:p-4 bg-white rounded mb-4">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                    <h2 class="text-2xl font-semibold font-serif inline leading-none">Basisinformatie</h2>
                </div>
                <div>
                    <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Kenteken</p>
                    <div class="rounded bg-[#FACC15] p-2 uppercase text-sm font-bold text-gray-800 w-min">
                        <input type="text" x-model="kenteken" tabindex="1" class="uppercase text-center outline-none placeholder:uppercase placeholder:text-center" placeholder="xx-999-x">
                    </div>
                    <p class="mt-2 text-[0.7rem] text-gray-500">Kenteken wordt niet automatisch opgehaald via RDW op deze pagina.</p>
                </div>

                <div class="grid md:grid-cols-2 grid-rows-6 md:grid-rows-3 w-full gap-y-5 gap-x-10 mt-10">
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Merk</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm text-gray-800">
                            <input type="text" tabindex="2" x-model="merk" class="outline-none w-min md:w-full placeholder:font-semibold">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Model</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm text-gray-800">
                            <input type="text" tabindex="3" x-model="model" class="outline-none w-min md:w-full placeholder:font-semibold">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Bouwjaar</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm text-gray-800">
                            <input type="number" tabindex="4" x-model="bouwjaar" class="outline-none w-min md:w-full placeholder:font-semibold">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Prijs (€)</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm text-gray-800">
                            <input type="number" tabindex="5" x-model="prijs" class="outline-none w-min md:w-full placeholder:font-semibold">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">KM stand</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm text-gray-800">
                            <input type="number" tabindex="6" x-model="km_stand" class="outline-none w-min md:w-full placeholder:font-semibold">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Status</p>
                        <div class="rounded bg-gray-100 p-3 text-sm text-gray-800">
                            <select x-model="auto_status" class="outline-none w-full bg-transparent">
                                <option value="beschikbaar">Beschikbaar</option>
                                <option value="concept">Concept</option>
                                <option value="verkocht">Verkocht</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white rounded mb-4">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                    <h2 class="text-2xl font-semibold font-serif inline leading-none">Voertuig omschrijving</h2>
                </div>
                <textarea x-model="beschrijving" tabindex="7" class="w-full h-40 rounded bg-gray-100 p-4 text-sm text-gray-800 outline-none placeholder:font-semibold"></textarea>
            </div>

            <div class="p-4 bg-white rounded">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                        <h2 class="text-2xl font-semibold font-serif inline leading-none">Voertuig foto's</h2>
                    </div>
                    <a @click="status = 'foto_toevoegen'" class="p-4 cursor-pointer bg-blaze-orange-50 hover:bg-blaze-orange-100 flex rounded text-blaze-orange-600 gap-4 justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="self-center" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M7 12H17L13.55 7.5L11.25 10.5L9.7 8.5L7 12ZM6 16C5.45 16 4.97917 15.8042 4.5875 15.4125C4.19583 15.0208 4 14.55 4 14V2C4 1.45 4.19583 0.979167 4.5875 0.5875C4.97917 0.195833 5.45 0 6 0H18C18.55 0 19.0208 0.195833 19.4125 0.5875C19.8042 0.979167 20 1.45 20 2V14C20 14.55 19.8042 15.0208 19.4125 15.4125C19.0208 15.8042 18.55 16 18 16H6ZM6 14H18V2H6V14ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4H2V18H16V20H2ZM6 2V14V2Z" fill="currentcolor"/>
                        </svg>
                        <p>Foto's beheren</p>
                    </a>
                </div>

                <div class="flex gap-6">
                    <template x-for="(foto, index) in fotos.slice(0, 5)" :key="index">
                        <div class="relative rounded bg-gray-100 h-48 w-1/5 flex items-center justify-center">
                            <img :src="resolveFotoSrc(foto)" class="object-cover h-full w-full rounded">
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div x-show="status === 'foto_toevoegen'" x-transition @photos-updated="updateFotos($event.detail)">
            <div class="w-full flex flex-col gap-4 md:gap-0 md:flex-row items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-serif font-bold text-gray-800">Foto's beheren</h1>
                    <p class="text-md">Werk de foto's van deze auto bij</p>
                </div>
                <div class="flex w-min">
                    <a @click="status = 'basisinformatie'" class="ml-4 inline-flex items-center px-4 py-3 w-full md:w-max bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 transition duration-150 ease-in-out">
                        Klaar met foto's
                    </a>
                </div>
            </div>
            <x-photo-manager :initialFotos="$initialFotos" />
        </div>
    </div>
</x-app-layout>