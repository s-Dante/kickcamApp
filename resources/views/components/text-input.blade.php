@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => $ui['text-input']]) }}>