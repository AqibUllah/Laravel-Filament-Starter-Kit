@props([
    'product',
    'variant' => 'standard', // 'standard', 'featured', or 'minimal'
    'showQuickView' => false,
    'showRating' => false,
    'showWishlist' => true,
    'showSellerBadge' => true,
    'showFeaturedBadge' => true,
    'buttonText' => null,
    'buttonAction' => 'cart' // 'cart', 'details', or 'view'
])

@php
    $rating = 4.5; // You can implement actual rating logic
    $buttonText = $buttonText ?: match($buttonAction) {
        'cart' => 'Add to Cart',
        'details' => 'Details',
        'view' => 'View Product',
        default => 'Add to Cart'
    };
@endphp

<div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 {{ $variant === 'featured' ? 'relative' : '' }}">
    <!-- Product Image -->
    <div class="relative {{ $variant === 'featured' ? 'h-64' : 'h-56' }} overflow-hidden">
        @if($product->images && count($product->images) > 0)
            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
        @else
            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <svg class="w-{{ $variant === 'featured' ? '20' : '16' }} h-{{ $variant === 'featured' ? '20' : '16' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        <!-- Badges -->
        @if($showSellerBadge && $variant !== 'minimal')
            <div class="absolute top-4 left-4 {{ $variant === 'featured' ? 'flex flex-col space-y-2' : '' }}">
                @if($showSellerBadge)
                    <span class="px-3 py-1 {{ $variant === 'featured' ? 'bg-blue-600 text-white' : 'bg-white/90 backdrop-blur-sm text-gray-900' }} text-xs font-semibold rounded-full shadow-lg">
                        {{ $product->team->name }}
                    </span>
                @endif
                @if($showFeaturedBadge && $product->is_featured)
                    <span class="px-3 py-1 bg-yellow-400 text-gray-900 text-xs font-semibold rounded-full shadow-lg">
                        ⭐ Featured
                    </span>
                @endif
            </div>
        @endif

        <!-- Wishlist Button -->
        @if($showWishlist && $variant !== 'featured' && $variant !== 'minimal')
            <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-red-50 transition-colors duration-300">
                <svg class="w-5 h-5 text-gray-600 hover:text-red-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        @endif

        <!-- Quick View Overlay (Featured variant) -->
        @if($showQuickView && $variant === 'featured')
            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <a href="{{ route('marketplace.show', $product->id) }}"
                   class="px-6 py-3 bg-white text-gray-900 rounded-lg font-semibold transform -translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-blue-600 hover:text-white">
                    Quick View
                </a>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $product->name }}</h3>
        @if($variant !== 'minimal')
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
        @endif

        <!-- Price and Rating -->
        <div class="flex items-center {{ $variant === 'minimal' ? 'justify-center' : 'justify-between' }} mb-4">
            <div>
                <span class="text-2xl font-bold text-gray-900">{{ $product->getFormattedCurrentPrice() }}</span>
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="ml-2 text-sm text-gray-500 line-through">{{ $product->getFormattedPrice() }}</span>
                @endif
            </div>

            @if($showRating && $variant === 'featured')
                <div class="flex items-center">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500 ml-1">(24)</span>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        @if($variant === 'standard' && $buttonAction === 'cart')
            <div class="flex gap-2">
                <a href="{{ route('marketplace.show', $product->id) }}"
                   class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-300 text-center text-sm">
                    Details
                </a>
                <button onclick="addToCart({{ $product->id }})"
                        class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300 text-sm">
                    Add to Cart
                </button>
            </div>
        @else
            @if($buttonAction === 'cart')
                <button onclick="addToCart({{ $product->id }})"
                        class="w-full {{ $variant === 'featured' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    @if($variant === 'featured')
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    @endif
                    {{ $buttonText }}
                </button>
            @else
                <a href="{{ route('marketplace.show', $product->id) }}"
                   class="w-full {{ $variant === 'featured' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-center block">
                    {{ $buttonText }}
                </a>
            @endif
        @endif
    </div>
</div>
