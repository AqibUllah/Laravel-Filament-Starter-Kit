@props([
    'category',
    'variant' => 'standard', // 'standard' or 'compact'
    'showProductCount' => true,
    'icon' => null // Custom SVG icon or null for default
])

@php
    $icon = $icon ?: '<svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012-2 2 2 2 2 0 012 2-2 2zm-7 4h1a1 1 0 110-1v-4a1 1 0 00-1-1h-3a1 1 0 00-1 1v4a1 1 0 001 1h3a1 1 0 001 1z"/>
    </svg>';
@endphp

<a href="{{ route('marketplace.index', ['category' => $category->id]) }}"
   class="group relative {{ $variant === 'compact' ? 'bg-gradient-to-br from-white to-gray-50 p-6' : 'bg-gradient-to-br from-white to-gray-50 p-8' }} rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden block">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity duration-500">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-600 rounded-full"></div>
        <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-purple-600 rounded-full"></div>
    </div>

    <div class="relative text-center">
        <div class="w-{{ $variant === 'compact' ? '16' : '20' }} h-{{ $variant === 'compact' ? '16' : '20' }} mx-auto mb-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-{{ $variant === 'compact' ? 'xl' : '2xl' }} flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
            {!! $icon !!}
        </div>
        <h3 class="text-{{ $variant === 'compact' ? 'lg' : 'xl' }} font-bold text-gray-900 mb-2">{{ $category->name }}</h3>
        
        @if($showProductCount)
            <p class="text-gray-600">{{ $category->public_products_count }} Products</p>
        @endif

        <!-- Hover Indicator -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
    </div>
</a>
