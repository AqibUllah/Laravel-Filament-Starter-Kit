@extends('layouts.app')

@section('title', $product->name . ' - Marketplace')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Breadcrumb -->
        <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ route('marketplace.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                Marketplace
                            </a>
                        </li>
                        <li>
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </li>
                        <li>
                            <a href="{{ route('marketplace.index', ['category' => $product->category_id]) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                {{ $product->category->name }}
                            </a>
                        </li>
                        <li>
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </li>
                        <li class="text-gray-900 dark:text-white font-medium truncate">
                            {{ $product->name }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Product Detail Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
                <!-- Product Images -->
                <div class="flex flex-col">
                    <!-- Main Image -->
                    <div class="aspect-w-1 aspect-h-1 w-full">
                        @if($product->images && count($product->images) > 0)
                            <div class="relative">
                                <img src="{{ $product->images[0] }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-96 object-cover rounded-2xl shadow-lg dark:shadow-gray-800"
                                     id="mainImage">

                                <!-- Badges -->
                                <div class="absolute top-4 left-4 flex flex-col space-y-2">
                                <span class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full shadow-lg dark:shadow-gray-800">
                                    {{ $product->team->name }}
                                </span>
                                    @if($product->is_featured)
                                        <span class="px-3 py-1 bg-yellow-400 text-gray-900 dark:text-gray-900 text-xs font-semibold rounded-full shadow-lg dark:shadow-gray-800">
                                        ⭐ Featured
                                    </span>
                                    @endif
                                    @if($product->isLowStock())
                                        <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg dark:shadow-gray-800">
                                        Low Stock
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-2xl shadow-lg dark:shadow-gray-800 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($product->images && count($product->images) > 1)
                        <div class="flex space-x-4 mt-4">
                            @foreach($product->images as $index => $image)
                                <button onclick="changeMainImage('{{ $image }}')"
                                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 {{ $index == 0 ? 'border-blue-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-blue-500 dark:hover:border-blue-500 transition-colors">
                                    <img src="{{ $image }}" alt="Product image {{ $index + 1 }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    <!-- Product Name and SKU -->
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">SKU: {{ $product->sku }}</p>

                    <!-- Reviews and Rating -->
                    <div class="mt-4">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 dark:text-yellow-400">
                                @php $rating = 4.5; @endphp {{-- You can implement actual rating logic --}}
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $rating ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $rating }} out of 5 stars</span>
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">(24 reviews)</span>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mt-6">
                        <div class="flex items-baseline">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">{{ $product->getFormattedCurrentPrice() }}</span>
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="ml-3 text-xl text-gray-500 dark:text-gray-400 line-through">{{ $product->getFormattedPrice() }}</span>
                                <span class="ml-2 text-sm text-green-600 dark:text-green-400 font-medium">Save {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%</span>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mt-6">
                        @if($product->isInStock())
                            @if($product->isLowStock())
                                <p class="text-amber-600 dark:text-amber-400 font-medium">Only {{ $product->quantity }} left in stock!</p>
                            @else
                                <p class="text-green-600 dark:text-green-400 font-medium">In stock and ready to ship</p>
                            @endif
                        @else
                            <p class="text-red-600 dark:text-red-400 font-medium">Out of stock</p>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Description</h3>
                        <div class="mt-2 prose prose-sm text-gray-500 dark:text-gray-400">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <!-- Product Attributes -->
                    @if($product->attributes && count($product->attributes) > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Specifications</h3>
                            <div class="mt-2 space-y-2">
                                @foreach($product->attributes as $key => $value)
                                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($key) }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Add to Cart Form -->
                    <div class="mt-10">
                        @if($product->isInStock())
                            <form id="addToCartForm" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <!-- Quantity Selector -->
                                <div class="flex items-center space-x-4">
                                    <label for="quantity" class="text-sm font-medium text-gray-700 dark:text-gray-300">Quantity:</label>
                                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800">
                                        <button type="button" onclick="decrementQuantity()" class="px-3 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="w-16 text-center border-0 focus:ring-0 bg-transparent text-gray-900 dark:text-white">
                                        <button type="button" onclick="incrementQuantity()" class="px-3 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-8 py-4 rounded-lg font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                        @endif
                    </div>

                    <!-- Seller Information -->
                    <div class="mt-8 border-t dark:border-gray-700 pt-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                @if($tenant->logo)
                                    <img src="{{ $tenant->logo }}" alt="{{ $tenant->name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">{{ substr($tenant->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $tenant->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $tenant->products()->where('is_public', true)->count() }} products</p>
                                </div>
                            </div>
                            <a href="{{ route('marketplace.index', ['team' => $tenant->id]) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm">
                                View Store →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="mt-16">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="showTab('details')" id="details-tab" class="tab-button border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 py-2 px-1 text-sm font-medium">
                            Product Details
                        </button>
                        <button onclick="showTab('reviews')" id="reviews-tab" class="tab-button border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 py-2 px-1 text-sm font-medium">
                            Reviews
                        </button>
                        <button onclick="showTab('shipping')" id="shipping-tab" class="tab-button border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 py-2 px-1 text-sm font-medium">
                            Shipping & Returns
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="mt-8">
                    <!-- Details Tab -->
                    <div id="details-content" class="tab-content">
                        <div class="prose max-w-none dark:prose-invert">
                            <h3 class="dark:text-white">Product Information</h3>
                            <ul class="dark:text-gray-300">
                                <li>Category: {{ $product->category->name }}</li>
                                <li>SKU: {{ $product->sku }}</li>
                                <li>Weight: {{ $product->weight ?? 'N/A' }} kg</li>
                                <li>Dimensions: {{ $product->dimensions ? implode(' × ', $product->dimensions) : 'N/A' }}</li>
                            </ul>

                            @if($product->tags && count($product->tags) > 0)
                                <h3 class="dark:text-white">Tags</h3>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($product->tags as $tag)
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm">{{ is_array($tag) ? $tag['tag'] : $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div id="reviews-content" class="tab-content hidden">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No reviews yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Be the first to review this product!</p>
                        </div>
                    </div>

                    <!-- Shipping Tab -->
                    <div id="shipping-content" class="tab-content hidden">
                        <div class="prose max-w-none dark:prose-invert">
                            <h3 class="dark:text-white">Shipping Information</h3>
                            <ul class="dark:text-gray-300">
                                <li>Free shipping on orders over $50</li>
                                <li>Standard shipping: 5-7 business days</li>
                                <li>Express shipping: 2-3 business days</li>
                                <li>International shipping available</li>
                            </ul>

                            <h3 class="dark:text-white">Return Policy</h3>
                            <ul class="dark:text-gray-300">
                                <li>30-day return policy</li>
                                <li>Items must be unused and in original packaging</li>
                                <li>Customer responsible for return shipping</li>
                                <li>Refunds processed within 5-7 business days</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Products</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedProducts as $relatedProduct)
                            <x-product-card :product="$relatedProduct" variant="minimal" :show-wishlist="false" button-action="view" button-text="View Product" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="fixed top-4 right-4 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg dark:shadow-gray-800 transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Product added to cart!</span>
        </div>
    </div>

    <!-- Cart Toggle Button -->
    <button onclick="window.location.href='{{ route('marketplace.index') }}'" class="fixed bottom-6 right-6 bg-blue-600 dark:bg-blue-500 text-white p-4 rounded-full shadow-lg dark:shadow-gray-800 hover:bg-blue-700 dark:hover:bg-blue-600 transition-all duration-300 transform hover:scale-110 z-40">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <span class="absolute -top-2 -right-2 bg-red-500 dark:bg-red-600 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center" id="cart-count">0</span>
    </button>
@endsection

@push('scripts')
    <script>
        // Quantity management
        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        // Image gallery
        function changeMainImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;

            // Update thumbnail borders
            const thumbnails = document.querySelectorAll('[onclick^="changeMainImage"]');
            thumbnails.forEach(thumb => {
                if (thumb.getAttribute('onclick').includes(imageSrc)) {
                    thumb.classList.add('border-blue-500');
                    thumb.classList.remove('border-gray-200', 'dark:border-gray-700');
                } else {
                    thumb.classList.remove('border-blue-500');
                    thumb.classList.add('border-gray-200', 'dark:border-gray-700');
                }
            });
        }

        // Tab management
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });

            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');

            // Add active state to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            activeTab.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        }

        // Add to cart form submission
        document.getElementById('addToCartForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log(e)
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Adding...';

            try {
                const response = await fetch('{{ route("marketplace.cart.add", $product->id) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    const successMessage = document.getElementById('successMessage');
                    successMessage.classList.remove('translate-x-full');

                    // Hide success message after 3 seconds
                    setTimeout(() => {
                        successMessage.classList.add('translate-x-full');
                    }, 3000);

                    // Update cart count if cart count element exists
                    const cartCountElements = document.querySelectorAll('#cart-count');
                    cartCountElements.forEach(element => {
                        if (data.cart_count !== undefined) {
                            element.textContent = data.cart_count;
                        }
                    });
                } else {
                    alert(data.message || 'Failed to add product to cart');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while adding the product to cart');
            } finally {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        });

        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("marketplace.cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const cartCountElements = document.querySelectorAll('#cart-count');
                        cartCountElements.forEach(element => {
                            element.textContent = data.count || 0;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        });
    </script>
@endpush
