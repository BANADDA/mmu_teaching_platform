@props([
    'type' => 'submit',
    'variant' => 'primary'
])

@php
    $variants = [
        'primary' => 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 focus:ring-emerald-500',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 active:bg-gray-800 focus:ring-gray-500',
        'danger' => 'bg-red-600 hover:bg-red-700 active:bg-red-800 focus:ring-red-500',
    ];

    $baseClasses = 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';
    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button>
