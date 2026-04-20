<x-app-layout>
    <div class="p-4 md:p-10" x-data="{...websiteSettings(@js($user)), scrollY: 0, scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }}" @scroll.window="scrollY = window.scrollY">
        <div class="md:w-full   flex flex-col gap-4 md:gap-0 md:flex-row items-center justify-center md:justify-between mb-4">
            <div>
                <h1 class="text-2xl md:text-4xl font-serif font-bold text-gray-800">Website instellingen</h1>
                <p class="text-md">Pas de informatie op de website aan</p>
            </div>
           
                <a x-on:click="updateSettings()" class="ml-4 cursor-pointer inline-flex items-center px-8 py-3 bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                    Opslaan 
                    <template x-transition >
                         <svg class="w-5 h-5 text-fg-success shrink-0 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </template>
                </a>
        </div>

        <div class="p-2 md:p-4 bg-white rounded mb-4">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                    <h2 class=" text-2xl font-semibold font-serif inline leading-none">Basisinformatie</h2>
                </div>
                <div class="mb-8">
                    <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">naam van autobedrijf</p>
                    <div class="rounded bg-gray-100 p-4 uppercase text-sm text-gray-800">
                        <input type="text" tabindex="1" x-model="naam" class="outline-none w-min md:w-full placeholder:font-semibold">
                    </div>
                    <p class="text-sm font-light tracking-thight inline">Url van website is: <p class="inline" x-text="naam + '.' + window.location.host"></p></p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2  gap-10">
                    <div class="">
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">logo</p>
                        <div  @click="$refs.logo.click()" class="rounded bg-gray-100 border-2 border-gray-400 border-dashed p-4 gap-8 font-bold cursor-pointer flex items-center  text-sm text-gray-800">
                            <div class="h-16 w-16 overflow-hidden rounded">
                                <img class="object-contain h-full w-full" :src="getImagePreview(logo, '{{ asset('img/Autovoorraad/img_placeholder.png') }}')" alt="">

                            </div>
                            <p>Klik hier om een logo te uploaden</p>
                        </div>
                        <input hidden type="file" x-ref="logo" accept="image/*" tabindex="2" @change="addlogo" class="outline-none w-min md:w-full placeholder:font-semibold">
                    </div>
                    <div class="">
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">primaire kleur</p>
                        <div class="rounded bg-gray-100 flex justify-between items-center cursor-pointer p-4 uppercase text-sm text-gray-600" @click="$refs.kleur.click()">
                            <p>Kies een kleur</p>
                            <div class="w-8 h-8" x-bind:style="`background-color: ${kleur}`">
                                <input type="color" x-ref="kleur" @change="console.log('nieuwe kleur', kleur )"  tabindex="3" x-model="kleur" class="outline-none opacity-0 w-5 aspect-square md:w-8 h-8 placeholder:font-semibold">
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="flex items-center gap-4 mt-10 mb-8">
                    <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                    <h2 class=" text-2xl font-semibold font-serif inline leading-none">Hero informatie</h2>
                </div>
                <div class="mb-8">
                        <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">Upload hero foto</p>
                        <div  @click="$refs.hero.click()" class="rounded bg-gray-100 border-2 border-gray-400 border-dashed p-4 gap-8 font-bold cursor-pointer flex items-center  text-sm text-gray-800">
                            <div class="h-16 w-16 rounded overflow-hidden ">
                                <img class="object-contain  w-full h-full" :src="getImagePreview(herofoto, '{{ asset('img/Autovoorraad/img_placeholder.png') }}')" alt="">
                            </div>
                            <p>Klik hier om foto te uploaden</p>
                        </div>
                        <input hidden type="file" x-ref="hero" accept="image/*" tabindex="2" @change="addHero" class="outline-none w-min md:w-full placeholder:font-semibold">
                </div>
                <div class="mb-8">
                    <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">hero beschrijving</p>
                    <div class="rounded bg-gray-100 p-4 uppercase text-sm text-gray-800">
                        <textarea  tabindex="1" rows="10" x-model="hero_beschrijving" class="outline-none w-min md:w-full placeholder:font-semibold"></textarea>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-10 mb-8">
                   <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                   <h2 class=" text-2xl font-semibold font-serif inline leading-none">Contactgegevens / Adres</h2>
               </div>
               <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                   <div class="">
                       <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">email</p>
                       <div class="rounded bg-gray-100 p-4 uppercase text-sm text-gray-800">
                           <input type="text" tabindex="1" x-model="email" placeholder="info@autovoorraad.nl" class="outline-none w-min md:w-full placeholder:font-semibold">
                       </div>
                   </div>
                   <div class="">
                       <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">telefoonnummer</p>
                       <div class="rounded bg-gray-100 p-4 uppercase text-sm text-gray-800">
                           <input type="text" tabindex="1" x-model="telefoonnummer" placeholder="06 12345678" class="outline-none w-min md:w-full placeholder:font-semibold">
                       </div>
                   </div>
    
               </div>
               <div class="bg-blaze-orange-600 rounded-full h-px w-full my-8"></div>
                
               <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                   <div class="">
                       <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">plaats</p>
                       <div class="rounded bg-gray-100 p-4 uppercase text-sm text-gray-800">
                           <input type="text" tabindex="1" x-model="plaats" placeholder="Amsterdam, Rotterdam, Den haag" class="outline-none w-min md:w-full placeholder:font-semibold">
                       </div>
                   </div>
                   <div class="">
                       <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">adres</p>
                       <div class="rounded bg-gray-100 p-4 uppercase text-sm text-gray-800">
                           <input type="text" tabindex="1" x-model="adres" placeholder="De straat 123" class="outline-none w-min md:w-full placeholder:font-semibold">
                       </div>
                   </div>
                   <div class="">
                       <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">postcode</p>
                       <div class="rounded bg-gray-100 p-4 uppercase text-sm text-gray-800">
                           <input type="text" tabindex="1" x-model="postcode" placeholder="1234XX" class="outline-none w-min md:w-full placeholder:font-semibold uppercase placeholder:uppercase">
                       </div>
                   </div>
    
               </div>
            </div>

        <!-- Scroll to Top Button -->
        <button 
            x-show="scrollY > 300" 
            x-transition:enter="transition ease-out duration-300" 
            x-transition:enter-start="opacity-0 translate-y-2" 
            x-transition:enter-end="opacity-100 translate-y-0" 
            x-transition:leave="transition ease-in duration-200" 
            x-transition:leave-start="opacity-100 translate-y-0" 
            x-transition:leave-end="opacity-0 translate-y-2"
            @click="scrollToTop()"
            class="fixed bottom-8 right-8 z-30 inline-flex cursor-pointer items-center justify-center w-12 h-12 bg-blaze-orange-600 hover:bg-blaze-orange-700 rounded-full text-white shadow-lg transition duration-150 ease-in-out"
            aria-label="Scroll to top">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    </div>
    
</x-app-layout>