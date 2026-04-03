<x-app-layout>
    <div class="p-10">
        <div class="w-full flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-serif font-bold text-gray-800">Auto Toevoegen</h1>
                <p class="text-md">Voeg een nieuw voertuig toe aan de digitale showroom.</p>
            </div>
            <div class="flex">
                <a href="{{ route('dashboard') }}" class="ml-4 inline-flex items-center px-4 py-3 border border-black-pearl-950 hover:bg-black-pearl-950 hover:text-white rounded-md font-semibold text-xs text-black-pearl-950 uppercase tracking-widest  focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                    Concept Opslaan
                <a href="{{ route('dashboard') }}" class="ml-4 inline-flex items-center px-4 py-3 bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-900 transition duration-150 ease-in-out">
                    Publiceren
                </a>
            </div>
        </div>

        <div class="p-4 bg-white rounded">
            <div class="flex items-center gap-4 mb-10">
                <div class="bg-blaze-orange-600 rounded-full w-1.5 h-8 inline-block"></div>
                <h2 class=" text-2xl font-semibold font-serif inline leading-none">Basisinformatie</h2>
            </div>
            <div>
                <p class="uppercase relative mb-3 h-max text-[#454652] text-sm tracking-wider font-bold">Kenteken</p>
                <div class="rounded bg-[#FACC15] p-2 uppercase text-sm font-bold text-gray-800 w-min">
                    <input type="text" class="uppercase text-center outline-none placeholder:uppercase placeholder:text-center" placeholder="xx-999-x">
                </div>
                <p class="mt-2 text-[0.7rem] text-gray-500">RDW Gegevens worden automatisch opgehaald na invoer.</p>
            </div>
        </div>
    </div>
    
</x-app-layout>