@props(['variant' => 'primary', 'size' => 'md', 'fullWidth' => false])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-300';
    
    $variants = [
        'primary' => 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 focus:ring-indigo-500',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300 focus:ring-gray-500',
        'outline' => 'border border-indigo-600 text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-6 py-2.5',
        'lg' => 'px-8 py-3 text-lg',
    ];
    
    $widthClass = $fullWidth ? 'w-full' : '';
    
    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . $widthClass;
@endphp

<button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
    {{ $slot }}
</button>