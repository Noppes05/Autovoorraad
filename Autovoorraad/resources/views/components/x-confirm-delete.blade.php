<div
    x-data
    x-show="$store.confirmDelete.open"
    class="fixed inset-0 z-50 flex items-center justify-center"
>
    <!-- BACKDROP -->
    <div
        x-show="$store.confirmDelete.open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-black/50"
    ></div>

    <!-- MODAL -->
    <div
        x-show="$store.confirmDelete.open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 translate-y-4"
        @click.outside="$store.confirmDelete.close()"
        class="relative bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl"
    >
        <!-- TITLE -->
        <h2 class="text-xl font-bold mb-2">
            Verwijderen?
        </h2>

        <!-- TEXT -->
        <p class="text-sm text-gray-600 mb-6">
            Weet je zeker dat je 
            <span class="font-semibold text-black" x-text="$store.confirmDelete.car.merk + ' ' + $store.confirmDelete.car.model"></span>
            wilt verwijderen? Dit kan niet ongedaan gemaakt worden.
        </p>

        <!-- BUTTONS -->
        <div class="flex justify-end gap-3">
            <button
                @click="$store.confirmDelete.close()"
                class="px-4 cursor-pointer py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition"
            >
                Annuleren
            </button>

            <button
                @click="$store.confirmDelete.confirm()"
                :disabled="$store.confirmDelete.loading"
                class="px-4 cursor-pointer py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2"
            >
                <span x-show="!$store.confirmDelete.loading">
                    Verwijderen
                </span>

                <!-- loader -->
                <svg
                    x-show="$store.confirmDelete.loading"
                    class="w-4 h-4 animate-spin"
                    viewBox="0 0 24 24"
                >
                    <circle cx="12" cy="12" r="10" stroke="white" stroke-width="4" fill="none"/>
                </svg>
            </button>
        </div>
    </div>
</div>