{{-- resources/views/components/button.blade.php --}}
@props([
    'text' => 'Submit',
    'type' => 'submit', // submit, button, reset
    'variant' => 'primary', // primary, secondary, danger, success
    'size' => 'default', // sm, default, lg
    'align' => 'center', // center, left, right
    'fullWidth' => false
])

@php
// Color variants
$variants = [
    'primary' => 'bg-green-600 hover:bg-green-700 text-white',
    'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white',
    'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white',
    'blue' => 'bg-blue-600 hover:bg-blue-700 text-white',
];

// Size variants
$sizes = [
    'sm' => 'px-4 py-2 text-sm',
    'default' => 'px-8 py-3',
    'lg' => 'px-10 py-4 text-lg'
];

// Alignment classes
$alignmentClasses = [
    'center' => 'justify-center',
    'left' => 'justify-start',
    'right' => 'justify-end md:justify-end'
];

$colorClass = $variants[$variant] ?? $variants['primary'];
$sizeClass = $sizes[$size] ?? $sizes['default'];
$alignClass = $alignmentClasses[$align] ?? 'justify-center';
$widthClass = $fullWidth ? 'w-full' : '';
@endphp

<div class="flex {{ $alignClass }} pt-4">
    <button 
        type="{{ $type }}"
        class="{{ $colorClass }} {{ $sizeClass }} {{ $widthClass }} rounded-full font-medium transition-colors"
        {{ $attributes }}>
        {{ $text }}
        {{ $slot }}
    </button>
</div>