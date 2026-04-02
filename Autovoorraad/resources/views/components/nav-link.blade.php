@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex text-white justify-evenly items-center p-4 border-s-3 border-orange-500 text-md font-light leading-5 text-gray-900  focus:outline-none focus:border-1 rounded-xl hover:bg-orange-500 transition duration-150 ease-in-out'
            : 'inline-flex text-white items-center p-6 border-s-3 border-transparent text-sm font-medium leading-5 text-gray-500  hover:bg-orange-500 focus:outline-none focus:text-gray-700 rounded-xl focus:border-gray-300 ransition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
