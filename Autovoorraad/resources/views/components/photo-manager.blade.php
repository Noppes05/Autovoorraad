@props(['initialFotos' => []])

<div
    x-data="photoManager( @js($initialFotos ?? []))"
    class="p-4"
>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <template x-for="(foto, index) in fotos" :key="index">
            <div
                draggable="true"
                @dragstart="startDrag(index)"
                @dragover.prevent="dragOver(index)"
                @drop="drop(index)"
                @dragend="endDrag"
                :class="{
                    'opacity-50': draggedIndex === index,
                    'border-l-2 border-blaze-orange-600': overIndex === index
                }"
                class="relative rounded group bg-gray-100 h-48 w-full flex items-center overflow-hidden justify-center"
            >
                <img
                    :src="resolvePhotoSrc(foto)"
                    class="object-cover h-full w-full group-hover:scale-110 transition-all"
                >

                <div class="absolute hidden bg-black/30 top-0 left-0 transition-all group-hover:flex justify-center items-center w-full h-full">
                    <button class="cursor-pointer text-blaze-orange-500 transition hover:text-blaze-orange-600" @click="deletePicture(index)">
                         <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 52 52" fill="none">
                                    <path d="M41.1668 8.66667H33.5835L31.4168 6.5H20.5835L18.4168 8.66667H10.8335V13H41.1668M13.0002 41.1667C13.0002 42.3159 13.4567 43.4181 14.2694 44.2308C15.082 45.0435 16.1842 45.5 17.3335 45.5H34.6668C35.8161 45.5 36.9183 45.0435 37.731 44.2308C38.5436 43.4181 39.0002 42.3159 39.0002 41.1667V15.1667H13.0002V41.1667Z" fill="currentcolor"/>
                                </svg>
                    </button>
                </div>
            </div>
        </template>

        <!-- ADD -->
        <div
            @click="$refs.file.click()"
            class="w-full h-48 rounded bg-black-pearl-950 border cursor-pointer border-blaze-orange-600 text-blaze-orange-600 flex justify-center items-center"
        >
            +
            <input type="file" multiple hidden accept="image/*" x-ref="file" @change="addFoto">
        </div>

    </div>
</div>