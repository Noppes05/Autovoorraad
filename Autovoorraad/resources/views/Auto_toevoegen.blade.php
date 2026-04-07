<x-app-layout>
    <div class="p-10" x-data="add_car">
        <div class="w-full flex items-center justify-between mb-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-gray-800">Auto Toevoegen</h1>
                <p class="text-md">Voeg een nieuw voertuig toe aan de digitale showroom.</p>
            </div>
            <div class="flex">
                <a href="{{ route('dashboard') }}" class="ml-4 inline-flex items-center px-4 py-3 border border-black-pearl-950 hover:bg-black-pearl-950 hover:text-white rounded-md font-semibold text-xs text-black-pearl-950 uppercase tracking-widest  focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                    Concept Opslaan</a>
                <a x-on:click="submitCar()" class="ml-4 inline-flex items-center px-4 py-3 bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                    Opslaan & Publiceren
                </a>
            </div>
        </div>
        <template x-if="status === 'basisinformatie'" x-transition>
            <div>
            <div class="p-4 bg-white rounded mb-4">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                    <h2 class=" text-2xl font-semibold font-serif inline leading-none">Basisinformatie</h2>
                </div>
                <div>
                    <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Kenteken</p>
                    <div class="rounded bg-[#FACC15] p-2 uppercase text-sm font-bold text-gray-800 w-min">
                        <input type="text" x-model="kenteken" @change="handleKentekenInput" tabindex="1" class="uppercase text-center outline-none placeholder:uppercase placeholder:text-center" placeholder="xx-999-x">
                    </div>
                    <p class="mt-2 text-[0.7rem] text-gray-500">RDW Gegevens worden automatisch opgehaald na invoer.</p>
                    <p x-text="rdwData_error" class=" text-[0.6rem] text-red-400 "></p>
                </div>
                <div class="grid grid-cols-2 grid-rows-3 w-full gap-y-5 gap-x-10 mt-10">
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Merk</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm text-gray-800">
                            <input type="text" tabindex="2" x-model="merk" class="outline-none w-full placeholder:font-semibold" placeholder="Volkswagen, Audi, etc.">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">model</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="text" tabindex="3" x-model="model" class="outline-none w-full placeholder:font-semibold" placeholder="Bijv Golf, A3, etc.">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">bouwjaar</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="text" tabindex="4" x-model="bouwjaar" class="outline-none w-full placeholder:font-semibold" placeholder="2021, 2020, etc.">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">prijs (€)</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="text" tabindex="5" x-model="prijs" class="outline-none w-full placeholder:font-semibold" placeholder="0,00">
                        </div>
                    </div>
                    <div>
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">km stand</p>
                        <div class="rounded bg-gray-100 p-3 uppercase text-sm  text-gray-800">
                            <input type="text" tabindex="6" x-model="km_stand" class="outline-none w-full placeholder:font-semibold" placeholder="0 km">
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
         <template x-if="status === 'foto_toevoegen'" x-transition>
            <div class="p-4">
                <div class="w-full flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-4xl font-serif font-bold text-gray-800">Foto's beheren</h1>
                        <p class="text-md">Voeg foto’s toe voor de auto</p>
                    </div>
                    <div class="flex">
                        <a x-on:click="status = 'basisinformatie'" class="ml-4 inline-flex items-center px-4 py-3 bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                            Opslaan foto's en terug naar overzicht
                        </a>
                    </div>
                </div>
                <div class="flex gap-4">
                    <template x-for="(foto, index) in fotos" :key="index">
                        <div draggable="true"
                            @dragstart="startDrag(index)"
                            @dragover.prevent="dragOver(index)"
                            @drop="drop(index)"
                            @dragend="endDrag"
                            :class="{
                                    'opacity-50': draggedIndex === index,
                                    'border-l-2 border-blaze-orange-600': overIndex === index
                                }"
                             class="relative rounded group bg-gray-100 h-48 w-1/5 flex items-center overflow-hidden justify-center">
                            <img :src="URL.createObjectURL(foto)" :alt="foto.name" class="object-cover group-hover:scale-110 h-full w-full rounded transition-all duration-150">
                            <div class="absolute hidden  bg-black/30 z-10 top-0 left-0 group-hover:flex transition-all justify-center items-center w-full h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" x-on:click="deletePicture(index)" width="52" height="52" viewBox="0 0 52 52" fill="none">
                                    <path d="M41.1668 8.66667H33.5835L31.4168 6.5H20.5835L18.4168 8.66667H10.8335V13H41.1668M13.0002 41.1667C13.0002 42.3159 13.4567 43.4181 14.2694 44.2308C15.082 45.0435 16.1842 45.5 17.3335 45.5H34.6668C35.8161 45.5 36.9183 45.0435 37.731 44.2308C38.5436 43.4181 39.0002 42.3159 39.0002 41.1667V15.1667H13.0002V41.1667Z" fill="#FC6A00"/>
                                </svg>
                            </div>
                        </div>
                    </template>
                    <div x-on:click="OpenFotoKiezen()" class="w-1/5 h-48 rounded bg-black-pearl-950 border cursor-pointer border-blaze-orange-600 text-blaze-orange-600 flex justify-center items-center">+
                    <input type="file" accept="image/*" multiple  @change="AddFoto" hidden id="fileinput" x-model='fileInput'></div>
                </div>
            </div>
         </template>
    </div>
    
</x-app-layout>