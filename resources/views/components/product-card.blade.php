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

<div x-data="{ showActions: false }"
     class="group relative bg-white dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-lg dark:shadow-gray-900/50 overflow-hidden hover:shadow-2xl dark:hover:shadow-purple-900/30 transition-all duration-500 transform hover:-translate-y-2 {{ $variant === 'featured' ? 'relative' : '' }}"
     @mouseenter="showActions = true"
     @mouseleave="showActions = false">

    <!-- Animated Gradient Border -->
    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-purple-400 dark:to-pink-400 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>

    <!-- Card Content -->
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl">
        <!-- Product Image -->
        <div class="relative {{ $variant === 'featured' ? 'h-64' : 'h-56' }} overflow-hidden">
            @if($product->images && count($product->images) > 0)
                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                     loading="lazy">
            @else
                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                    <svg class="w-{{ $variant === 'featured' ? '20' : '16' }} h-{{ $variant === 'featured' ? '20' : '16' }} text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <!-- Badges -->
            @if($showSellerBadge && $variant !== 'minimal')
                <div class="absolute top-4 left-4 {{ $variant === 'featured' ? 'flex flex-col space-y-2' : '' }}">
                    @if($showSellerBadge)
                        <span class="px-3 py-1 {{ $variant === 'featured' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 text-white' : 'bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700' }} text-xs font-semibold rounded-full shadow-lg transition-transform duration-300 hover:scale-105">
                            {{ $product->team->name }}
                        </span>
                    @endif
                    @if($showFeaturedBadge && $product->is_featured)
                        <span class="px-3 py-1 bg-gradient-to-r from-yellow-400 to-orange-400 dark:from-purple-500 dark:to-pink-500 text-white dark:text-white text-xs font-semibold rounded-full shadow-lg transform -rotate-12 group-hover:rotate-0 transition-transform duration-300">
                            ⭐ Featured
                        </span>
                    @endif
                </div>
            @endif

            <!-- Wishlist Button -->
            @if($showWishlist && $variant !== 'featured' && $variant !== 'minimal')
                <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-red-50 dark:hover:bg-red-900/30 transition-all duration-300 transform hover:scale-110 z-10"
                        onclick="event.preventDefault(); toggleWishlist({{ $product->id }})">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400 transition-colors duration-300"
                         :class="{ 'fill-current text-red-500 dark:text-red-400': isInWishlist({{ $product->id }}) }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            @endif

            <!-- Quick View Overlay -->
            @if($showQuickView && $variant === 'featured')
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent dark:from-purple-900/70 dark:via-purple-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                    <a href="{{ route('marketplace.show', $product->id) }}"
                       class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-blue-600 hover:text-white dark:hover:bg-purple-600 shadow-xl">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Quick View
                        </span>
                    </a>
                </div>
            @endif

            <!-- Minimal Variant Overlay -->
            @if($variant === 'minimal')
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                    <a href="{{ route('marketplace.show', $product->id) }}"
                       class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm rounded-lg hover:bg-blue-600 hover:text-white dark:hover:bg-purple-600 transition-colors duration-300">
                        View Product
                    </a>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="p-6">
            <!-- Seller & Rating -->
            <div class="flex items-center justify-between mb-2">
                @if($variant === 'minimal')
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        {{ $product->team->name }}
                    </span>
                @endif

                @if($showRating && ($variant === 'featured' || $variant === 'standard'))
                    <div class="flex items-center gap-1">
                        <div class="flex text-yellow-400 dark:text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= floor($rating) ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">({{ $product->reviews_count ?? 24 }})</span>
                    </div>
                @endif
            </div>

            <!-- Product Name -->
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-{{ $variant === 'minimal' ? '1' : '2' }}">
                <a href="{{ route('marketplace.show', $product->id) }}" class="hover:text-blue-600 dark:hover:text-purple-400 transition-colors duration-200">
                    {{ $product->name }}
                </a>
            </h3>

            @if($variant !== 'minimal')
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                    {{ Str::limit(strip_tags($product->description), 80) }}
                </p>
            @endif

            <!-- Price and Stock Status -->
            <div class="flex items-center {{ $variant === 'minimal' ? 'justify-center' : 'justify-between' }} mb-4">
                <div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $product->getFormattedCurrentPrice() }}
                    </span>
                    @if($product->sale_price && $product->sale_price < $product->price)
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 line-through">
                            {{ $product->getFormattedPrice() }}
                        </span>
                    @endif
                </div>

                <!-- Stock Status -->
                @if($product->stock_count > 0)
                    <div class="flex items-center text-xs text-green-600 dark:text-green-400">
                        <span class="flex w-2 h-2 bg-green-500 dark:bg-green-400 rounded-full mr-1 animate-pulse"></span>
                        In Stock
                    </div>
                @else
                    <div class="flex items-center text-xs text-red-600 dark:text-red-400">
                        <span class="flex w-2 h-2 bg-red-500 dark:bg-red-400 rounded-full mr-1"></span>
                        Out of Stock
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            @if($variant === 'standard' && $buttonAction === 'cart')
                <div class="flex gap-2">
                    <a href="{{ route('marketplace.show', $product->id) }}"
                       class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300 text-center text-sm font-medium">
                        Details
                    </a>
                    <button onclick="addToCart({{ $product->id }})"
                            class="flex-1 bg-blue-600 dark:bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-purple-700 transition-all duration-300 text-sm font-medium transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Add to Cart
                    </button>
                </div>
            @else
                @if($buttonAction === 'cart')
                    <button onclick="addToCart({{ $product->id }})"
                            class="group/btn w-full {{ $variant === 'featured' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 hover:from-blue-700 hover:to-indigo-700 dark:hover:from-purple-600 dark:hover:to-pink-600' : 'bg-blue-600 dark:bg-purple-600 hover:bg-blue-700 dark:hover:bg-purple-700' }} text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 relative overflow-hidden">
                        <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></span>
                        <span class="relative flex items-center justify-center gap-2">
                            @if($variant === 'featured')
                                <svg class="w-5 h-5 animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            @endif
                            {{ $buttonText }}
                        </span>
                    </button>
                @else
                    <a href="{{ route('marketplace.show', $product->id) }}"
                       class="group/btn block w-full {{ $variant === 'featured' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 hover:from-blue-700 hover:to-indigo-700 dark:hover:from-purple-600 dark:hover:to-pink-600' : 'bg-blue-600 dark:bg-purple-600 hover:bg-blue-700 dark:hover:bg-purple-700' }} text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-center relative overflow-hidden">
                        <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></span>
                        <span class="relative flex items-center justify-center gap-2">
                            {{ $buttonText }}
                            <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Line Clamp Utilities */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pulse Subtle Animation */
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(0.98); }
        }

        .animate-pulse-subtle {
            animation: pulse-subtle 2s ease-in-out infinite;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Wishlist functionality (will implement this based on future needs)
        function isInWishlist(productId) {
            // Implementation of wishlist logic
            return false;
        }

        function toggleWishlist(productId) {
            // Implementation wishlist toggle logic
            console.log('Toggle wishlist for product:', productId);
        }

        function updateCartCount() {
            fetch('{{ route("marketplace.cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const countElement = document.getElementById('cart-count');
                    const newCount = data.count || 0;

                    if (countElement.textContent != newCount) {
                        countElement.textContent = newCount;
                        countElement.classList.add('animate-bounce-in');
                        setTimeout(() => countElement.classList.remove('animate-bounce-in'), 300);
                    }
                });
        }

        function showNotification(message, type = 'success') {
            const notification = document.getElementById('cart-notification');
            const messageEl = document.getElementById('notification-message');

            // Update colors based on type
            const borderColor = type === 'success' ? 'border-green-500' : 'border-red-500';
            const progressColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';

            notification.querySelector('.border-l-4').className = `border-l-4 ${borderColor} overflow-hidden`;
            notification.querySelector('.progress-bar').className = `h-1 ${progressColor} progress-bar`;

            messageEl.textContent = message;
            notification.classList.remove('translate-x-full');

            // Auto hide after 3 seconds
            setTimeout(() => {
                hideNotification();
            }, 3000);
        }

        function hideNotification() {
            const notification = document.getElementById('cart-notification');
            notification.classList.add('translate-x-full');
        }

        function addToCart(productId) {
            // Show loading state on button
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>';
            btn.disabled = true;
            let url = "{{ url('/marketplace/cart/add') }}/" + productId;
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                    showNotification('Product added to cart!');

                    // Animate cart button
                    const cartBtn = document.querySelector('[onclick="toggleCart()"]');
                    cartBtn.classList.add('animate-bounce-in');
                    setTimeout(() => cartBtn.classList.remove('animate-bounce-in'), 300);
                }
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });

            // Example animation feedback
            const button = event.currentTarget;
            button.classList.add('scale-95', 'opacity-80');
            setTimeout(() => {
                button.classList.remove('scale-95', 'opacity-80');
            }, 200);
        }
    </script>
@endpush
