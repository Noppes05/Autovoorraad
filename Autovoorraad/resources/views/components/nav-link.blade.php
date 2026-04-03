@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex w-full text-white text-nowrap justify-around items-center p-3 border-s-3 border-blaze-orange-500 text-md font-light leading-5 text-gray-900  focus:outline-none focus:border-1 rounded-xl hover:bg-blaze-orange-500 transition duration-300 ease-in-out'
            : 'inline-flex w-full text-white text-nowrap justify-around items-center p-3 border-s-3 border-transparent text-md font-light leading-5 text-gray-500  hover:bg-orange-500 focus:outline-none focus:text-gray-700 rounded-xl focus:border-gray-300 ransition duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
