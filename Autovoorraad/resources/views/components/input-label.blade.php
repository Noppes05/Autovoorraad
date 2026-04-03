@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm uppercase text-black']) }}>
    {{ $value ?? $slot }}
</label>
