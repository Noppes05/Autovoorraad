<div
    x-data
    class="fixed top-5 right-5 z-50 space-y-3 w-80"
>
<template x-for="toast in $store.toast?.toasts || []" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transform ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform ease-in duration-500"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="px-4 py-3 rounded-xl shadow-lg text-white flex justify-between items-center"
            :class="{
                'bg-green-500': toast.type === 'success',
                'bg-red-500': toast.type === 'error',
                'bg-blue-500': toast.type === 'info',
                'bg-yellow-500': toast.type === 'warning'
            }"
        >
            <span x-text="toast.message" class="pr-2"></span>

            <button @click="$store.toast.hide(toast.id)" class="ml-2 opacity-70 hover:opacity-100">
                ✕
            </button>
        </div>
    </template>
</div>