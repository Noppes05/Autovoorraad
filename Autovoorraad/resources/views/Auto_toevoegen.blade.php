<x-app-layout>
    <div class="p-4 md:p-10" x-data="add_car">
        <div class="md:w-full  flex flex-col gap-4 md:gap-0 md:flex-row items-center justify-center md:justify-between mb-4">
            <div>
                <h1 class="text-2xl md:text-4xl font-serif font-bold text-gray-800">Auto Toevoegen</h1>
                <p class="text-md">Voeg een nieuw voertuig toe aan de digitale showroom.</p>
            </div>
            <div class="flex self-start gap-4 md:gap-0 md:flex-row flex-col">
                <a x-on:click="submitConceptCar()" class="ml-4 inline-flex items-center px-4 py-3 border border-black-pearl-950 hover:bg-black-pearl-950 hover:text-white rounded-md font-semibold text-xs text-black-pearl-950 uppercase tracking-widest  focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                    Concept Opslaan
                    <template x-transition x-if="isConceptSaved">
                         <svg class="w-5 h-5 text-green-400 shrink-0 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </template>
                </a>
                <a x-on:click="submitBeschikbaarCar()" class="ml-4 inline-flex items-center px-4 py-3 bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                    Opslaan & Publiceren
                    <template x-transition x-if="isPublished">
                         <svg class="w-5 h-5 text-fg-success shrink-0 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </template>
                </a>
            </div>
        </div>
        <template x-if="status === 'basisinformatie'" x-transition>
            <div>
            <div class="p-2 md:p-4 bg-white rounded mb-4">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                    <h2 class=" text-2xl font-semibold font-serif inline leading-none">Basisinformatie</h2>
                </div>
                <div>
                    <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Kenteken</p>
                    <div class="flex gap-4 items-center">
                        <div class="rounded bg-[#FACC15] p-2 uppercase text-sm font-bold text-gray-800 w-min">
                            <input type="text" x-model="kenteken" @change="handleKentekenInput" tabindex="1" class="uppercase text-center outline-none placeholder:uppercase placeholder:text-center" placeholder="xx-999-x">
                        </div>
                        <template x-if="rdwData_loading">
                             <svg aria-hidden="true" class="w-4 h-4 me-2 inline-block text-neutral-tertiary animate-spin fill-brand" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                            <p class="text-[0.6rem] inline text-gray-400 mt-1">RDW gegevens laden...</p>
                        </template>
                    </div>
                    <p class="mt-2 text-[0.7rem] text-gray-500">RDW Gegevens worden automatisch opgehaald na invoer.</p>
                    <p x-text="rdwData_error" class=" text-[0.6rem] text-red-400 "></p>
                </div>
                <div class="grid md:grid-cols-2 grid-rows-6 md:grid-rows-3 w-full gap-y-5 gap-x-10 mt-10">
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Merk</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm text-gray-800">
                            <input type="text" tabindex="2" x-model="merk" class="outline-none w-min md:w-full placeholder:font-semibold" placeholder="Volkswagen, Audi, etc.">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">model</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="text" tabindex="3" x-model="model" class="outline-none w-min md:w-full placeholder:font-semibold" placeholder="Bijv Golf, A3, etc.">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">bouwjaar</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="number" tabindex="4" x-model="bouwjaar" class="outline-nonew-min md:w-full placeholder:font-semibold" placeholder="2021, 2020, etc.">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">prijs (€)</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="number" tabindex="5" x-model="prijs" class="outline-none w-min md:w-full placeholder:font-semibold" placeholder="0,00">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">km stand</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="number" tabindex="6" x-model="km_stand" class="outline-none w-min md:w-full placeholder:font-semibold" placeholder="0 km">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-white rounded mb-4">
                <div class="flex items-center gap-4 mb-8">
                        <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                        <h2 class=" text-2xl font-semibold font-serif inline leading-none">Voertuig omschrijving</h2>
                </div>
                <textarea x-model="beschrijving" tabindex="7" class="w-full h-40 rounded bg-gray-100 p-4 text-sm  text-gray-800 outline-none placeholder:font-semibold" placeholder="Voeg hier een omschrijving van het voertuig toe. Denk aan details zoals onderhoudsgeschiedenis, unieke kenmerken, of andere relevante informatie die potentiële kopers zou kunnen interesseren."></textarea>
            </div>

            <div class="p-4 bg-white rounded">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                        <h2 class=" text-2xl font-semibold font-serif inline leading-none">Voertuig foto's</h2>
                    </div>
                    <a x-on:click="status = 'foto_toevoegen'" class="p-4 cursor-pointer bg-blaze-orange-50 hover:bg-blaze-orange-100 flex rounded text-blaze-orange-600 gap-4 justify-between">
                            <svg xmlns="http://www.w3.org/2000/svg" class="self-center" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7 12H17L13.55 7.5L11.25 10.5L9.7 8.5L7 12ZM6 16C5.45 16 4.97917 15.8042 4.5875 15.4125C4.19583 15.0208 4 14.55 4 14V2C4 1.45 4.19583 0.979167 4.5875 0.5875C4.97917 0.195833 5.45 0 6 0H18C18.55 0 19.0208 0.195833 19.4125 0.5875C19.8042 0.979167 20 1.45 20 2V14C20 14.55 19.8042 15.0208 19.4125 15.4125C19.0208 15.8042 18.55 16 18 16H6ZM6 14H18V2H6V14ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4H2V18H16V20H2ZM6 2V14V2Z" fill="currentcolor"/>
                            </svg>
                            <p>foto's beheren</p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="self-center" width="8" height="12" viewBox="0 0 8 12" fill="none">
                                <path d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z" fill="currentcolor"/>
                            </svg>
                    </a>
                </div>
                <div  class="flex gap-6">
                    <template x-for="(foto, index) in fotos" :key="index">
                        <div 
                             class="relative rounded bg-gray-100 h-48 w-1/5 flex items-center justify-center">
                            <img :src="URL.createObjectURL(foto)" :alt="foto.name" class="object-cover h-full w-full rounded">
                        </div>
                    </template>
                </div>
                
            </div>
         </template>
         <template x-if="status === 'foto_toevoegen'">
             <div @photos-updated="updateFotos($event.detail)">
                 <div class="w-full flex flex-col gap-4 md:gap-0 md:flex-row items-center justify-between mb-4">
                       <div>
                           <h1 class="text-4xl font-serif font-bold text-gray-800">Foto's beheren</h1>
                           <p class="text-md">Voeg foto’s toe voor de auto</p>
                       </div>
                       <div class="flex w-min">
                           <a x-on:click="status = 'basisinformatie'" class="ml-4 inline-flex items-center px-4 py-3 w-full md:w-max bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                               Opslaan foto's en <br>
                               terug naar overzicht
                           </a>
                       </div>
                   </div>
                <x-photo-manager />
            </div>
        </template>
    </div>
    
</x-app-layout>