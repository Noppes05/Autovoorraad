<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center py-4 bg-black-pearl-950 text-white overflow-hidden after:w-full after:bg-blaze-orange-600 after:h-1 after:absolute after:bottom-0 relative cursor-pointer rounded-md w-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-blaze-orange-600 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
