@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'outline-none appearance-none bg-transparent']) }}>
