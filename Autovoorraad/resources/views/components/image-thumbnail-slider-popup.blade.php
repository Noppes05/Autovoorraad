@props(['Fotos' => []])

<div
    x-data="fotoSlider()"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    :class="open ? 'pointer-events-auto' : 'pointer-events-none'"
>
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-black/50"
        @click="close()"
    ></div>

    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 translate-y-4"
        @click.outside="close()"
        class="relative bg-white rounded-2xl p-6 w-full max-w-5xl shadow-2xl"
    >
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Foto's</h2>
            <button @click="close()" class="px-3 py-2 rounded-lg bg-black-pearl-950 text-white hover:bg-red-600 cursor-pointer transition">
                Sluiten
            </button>
        </div>

        <div class="grid gap-4">
            <section class="splide" x-ref="main" aria-label="Auto foto's">
                <div class="splide__track h-[60vh] relative rounded-xl bg-gray-100 overflow-hidden">
                    <ul class="splide__list h-full">
                        @foreach ($Fotos as $foto)
                            <li class="splide__slide relative h-full w-full flex items-center justify-center overflow-hidden">
                                <img
                                    src="{{ $foto['url'] ?? '' }}"
                                    class="max-h-full max-w-full w-auto h-auto object-contain"
                                    alt="Auto foto"
                                >
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <section class="splide" x-ref="thumbnails" aria-label="Auto thumbnails">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($Fotos as $foto)
                            <li class="splide__slide">
                                <button type="button" class="w-full h-full rounded-lg overflow-hidden flex justify-center items-center bg-gray-100">
                                    <img
                                        src="{{ $foto['url'] ?? '' }}"
                                        class="max-h-full max-w-full w-auto h-auto object-contain"
                                        alt="Thumbnail"
                                    >
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>
    </div>
</div>