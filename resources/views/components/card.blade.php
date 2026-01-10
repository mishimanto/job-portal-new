@props(['class' => '', 'hover' => false])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-200 ' . ($hover ? 'hover:shadow-lg transition-shadow duration-300' : '') . ' ' . $class]) }}>
    {{ $slot }}
</div>