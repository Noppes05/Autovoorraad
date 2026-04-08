<x-app-layout>
   <div class="p-10" x-data="autovoorraad">
       <h1 class="text-3xl font-bold mb-6">Autovoorraad</h1>
       <div class="gap-6 mb-6">
           <div class="bg-white rounded-lg shadow p-6">
               <h2 class="text-xl font-semibold mb-4">Auto's in Voorraad</h2>
               <p class="text-gray-600 text-sm mb-2" x-text="'Totaal aantal autos in voorraad: ' + autos.length"></p>

           </div>
           <!-- Voeg hier meer dashboard widgets toe indien nodig -->
        </div>
        <table class="w-full table rounded-lg text-start">
         <thead class="uppercase text-start relative mb-3 h-max text-[#454652] text-sm tracking-wider font-semibold">
             <tr class="text-start">
                 <th class="text-start p-4">Auto</th>
                 <th class="text-start p-4">kenteken</th>
                 <th class="text-start p-4">prijs</th>
                 <th class="text-start p-4">status</th>
                 <th class="text-end p-4">acties</th>
             </tr>
         </thead>
         <tbody class="bg-white">
           <template x-for="auto in autos" :key="auto.id">
                <tr class="border-b-2 relative last:border-0 border-black-pearl-950" >
                    <td class="py-4 pl-3" >
                        <div class="flex gap-4 items-center w-min">
                            <div class="relative w-40 h-24">
                                <img :src="auto.fotos['0'].foto_path" alt="" class="object-cover w-full h-full rounded">
                            </div>
                            <div class="w-max grow-0">
                                <p class="font-semibold w-full" x-text="auto.merk"></p>
                                <p class="text-sm w-full text-gray-500" x-text="auto.model + ' | ' + auto.bouwjaar + ' | ' + auto.km_stand + ' km'"></p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4" >
                        <div class="rounded text-center p-1 bg-amber-300">
                            <p x-text="auto.kenteken"></p>
                        </div>
                    </td>
                    <td class="p-4" x-text="auto.prijs ? '€' + Math.floor(auto.prijs) : 'N/A'"></td>
                    <td class="p-4">
                        <div class="rounded-full font-bold text-center p-2" x-text="auto.status" :class="{
                            'bg-black-pearl-100 text-black-pearl-800': auto.status === 'beschikbaar',
                            'bg-gray-100 text-gray-800': auto.status === 'concept',
                            'bg-red-100 text-red-800': auto.status === 'verkocht',
                        }">

                        </div>
                    </td>
                    <td class="p-4" >
                        <div class="h-full my-auto flex gap-2 items-center justify-end"">
                            <!-- Voeg hier actieknoppen toe, zoals bewerken of verwijderen -->
                            <button class="bg-black-pearl-700 cursor-pointer hover:bg-black-pearl-800 transition text-white p-3 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                 <path d="M1.5 12H2.56875L9.9 4.66875L8.83125 3.6L1.5 10.9312V12ZM0 13.5V10.3125L9.9 0.43125C10.05 0.29375 10.2156 0.1875 10.3969 0.1125C10.5781 0.0375 10.7688 0 10.9688 0C11.1687 0 11.3625 0.0375 11.55 0.1125C11.7375 0.1875 11.9 0.3 12.0375 0.45L13.0688 1.5C13.2188 1.6375 13.3281 1.8 13.3969 1.9875C13.4656 2.175 13.5 2.3625 13.5 2.55C13.5 2.75 13.4656 2.94062 13.3969 3.12188C13.3281 3.30313 13.2188 3.46875 13.0688 3.61875L3.1875 13.5H0ZM12 2.55L10.95 1.5L12 2.55ZM9.35625 4.14375L8.83125 3.6L9.9 4.66875L9.35625 4.14375Z" fill="currentcolor"/>
                                </svg>
                            </button>
                            <button class="bg-black-pearl-700 cursor-pointer hover:bg-black-pearl-800 transition text-white p-3 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14" fill="none">
                                    <path d="M2.25 13.5C1.8375 13.5 1.48438 13.3531 1.19062 13.0594C0.896875 12.7656 0.75 12.4125 0.75 12V2.25H0V0.75H3.75V0H8.25V0.75H12V2.25H11.25V12C11.25 12.4125 11.1031 12.7656 10.8094 13.0594C10.5156 13.3531 10.1625 13.5 9.75 13.5H2.25ZM9.75 2.25H2.25V12H9.75V2.25ZM3.75 10.5H5.25V3.75H3.75V10.5ZM6.75 10.5H8.25V3.75H6.75V10.5ZM2.25 2.25V12V2.25Z" fill="currentcolor"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </template>
         </tbody>

   </div>
</x-app-layout>
