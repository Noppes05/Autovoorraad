<x-app-layout>
    <div class="p-4 md:p-10" x-data="manageAutoPhotos(@js($autoId), @js($initialFotos))">
        <div class="w-full flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-4xl font-serif font-bold text-gray-800">Foto's beheren</h1>
                <p class="text-md">Wijzig de foto's van deze auto en sla ze op.</p>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button
                    type="button"
                    @click="goToDetails()"
                    class="inline-flex justify-center items-center px-4 py-3 border border-black-pearl-950 hover:bg-black-pearl-950 hover:text-white rounded-md font-semibold text-xs text-black-pearl-950 uppercase tracking-widest transition duration-150 ease-in-out"
                >
                    Annuleren
                </button>
                <button
                    type="button"
                    @click="saveFotos()"
                    :disabled="saving"
                    class="inline-flex justify-center items-center px-4 py-3 bg-blaze-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-700 disabled:opacity-70 disabled:cursor-not-allowed transition duration-150 ease-in-out"
                >
                    <span x-text="saving ? 'Opslaan...' : 'Opslaan'"></span>
                </button>
            </div>
        </div>

        <div @photos-updated="updateFotos($event.detail)">
            <x-photo-manager :initialFotos="$initialFotos" />
        </div>
    </div>
</x-app-layout>