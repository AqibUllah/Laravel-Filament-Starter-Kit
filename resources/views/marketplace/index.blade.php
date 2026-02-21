@extends('layouts.app')

@push('styles')

    <style>
        /* Slide animations - ADD THESE CLASSES */
        .slide-in {
            transform: translateX(0) !important;
        }

        .slide-out {
            transform: translateX(100%) !important;
        }

        /* Initial state for cart panel */
        #cart-panel {
            transform: translateX(0);
        }

        /* Optional: Add a subtle shadow animation */
        #cart-panel {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Ensure the backdrop blur works */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        /* Cart count badge animation */
        @keyframes bounce-in {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        .animate-bounce-in {
            animation: bounce-in 0.3s ease-out;
        }

        /* Custom scrollbar styles */
        #cart-items-container::-webkit-scrollbar {
            width: 6px;
        }

        #cart-items-container::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 10px;
        }

        #cart-items-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
            transition: background 0.2s;
        }

        #cart-items-container::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Loading skeleton animation */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
    </style>

    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }

        @keyframes pulse-slow {
            0%, 100% {
                opacity: 0.4;
            }
            50% {
                opacity: 0.6;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s infinite;
        }

        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
        <!-- Hero Section with Parallax Effect -->
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700">
            <!-- Animated Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
            </div>

            <div class="relative pt-24 pb-16 md:pt-32 md:pb-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center animate-fade-in-down">
                        <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6 tracking-tight">
                            <span class="block">{{ config('app.name') }}</span>
                            <span class="block text-4xl md:text-5xl mt-2 text-blue-200">Marketplace</span>
                        </h1>
                        <p class="text-xl md:text-2xl text-blue-100 mb-10 max-w-3xl mx-auto">
                            Discover exceptional products from our curated network of trusted sellers
                        </p>

                        <!-- Search Bar -->
                        <div class="max-w-2xl mx-auto mb-8">
                            <form method="GET" action="{{ route('marketplace.index') }}" class="flex items-center bg-white rounded-lg shadow-xl p-1">
                                <input type="text" name="search" placeholder="Search for products..."
                                       value="{{ request('search') }}"
                                       class="flex-1 px-6 py-4 text-gray-700 placeholder-gray-400 bg-transparent border-none focus:outline-none text-lg">
                                <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-semibold">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Search
                                </button>
                            </form>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="#categories" class="inline-flex items-center justify-center px-8 py-4 text-base z-50 font-medium rounded-lg text-gray-900 bg-white hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Browse Categories
                            </a>
                            @guest
                                <a href="#" class="inline-flex items-center justify-center px-8 py-4 text-base z-50 font-medium rounded-lg text-white bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Join as Buyer
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wave Divider -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
                </svg>
            </div>
        </div>

        <!-- Products Grid with Advanced Filters -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Filter Bar -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h2 class="text-2xl font-bold text-gray-900">
                            All Products
                            <span class="ml-2 text-sm font-normal text-gray-500">({{ $products->total() }} items)</span>
                        </h2>

                        <form method="GET" action="{{ route('marketplace.index') }}" class="flex flex-col sm:flex-row gap-4">
                            <div class="relative">
                                <select name="category" class="appearance-none w-full bg-gray-50 border border-gray-300 text-gray-900 py-3 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="relative">
                                <select name="team" class="appearance-none w-full bg-gray-50 border border-gray-300 text-gray-900 py-3 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Sellers</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ request('team') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }} ({{ $team->products_count }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="relative">
                                <select name="sort" class="appearance-none w-full bg-gray-50 border border-gray-300 text-gray-900 py-3 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>

                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold">
                                Apply Filters
                            </button>

                            @if(request()->anyFilled(['category', 'team', 'sort', 'search']))
                                <a href="{{ route('marketplace.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors duration-300 font-semibold">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($products as $product)
                            <x-product-card :product="$product" variant="standard" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-600 mb-8">Try adjusting your search or filter to find what you're looking for.</p>
                        <a href="{{ route('marketplace.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Featured Products Section -->
        @if($featuredProducts->count() > 0)
            <section class="py-20 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 animate-on-scroll">
                        <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Handpicked for you</span>
                        <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-4">Featured Products</h2>
                        <p class="text-xl text-gray-600">Curated selections from our top sellers</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($featuredProducts as $product)
                            <x-product-card :product="$product" variant="featured" :show-quick-view="true" :show-rating="true" :show-wishlist="false" />
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Categories Section with Gradient Cards -->
        <section id="categories" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Browse by</span>
                    <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-1">Product Categories</h2>
                    <p class="text-lg text-gray-600">Find exactly what you're looking for</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                        <x-category-card :category="$category" />
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <!-- Shopping Cart Drawer -->
{{--    <div id="cart-drawer" class="fixed inset-0 overflow-hidden z-50" style="display: none;">--}}
{{--        <div class="absolute inset-0 overflow-hidden">--}}
{{--            <div class="absolute inset-0  bg-opacity-30 backdrop-blur-xs transition-opacity" onclick="toggleCart()"></div>--}}

{{--            <div id="cart-panel" class="fixed inset-y-0 right-0 pl-10 max-w-full flex transform translate-x-full transition-transform duration-500 ease-in-out">--}}
{{--                <div class="w-screen max-w-md h-full flex flex-col bg-white shadow-xl">--}}
{{--                    <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">--}}
{{--                        <div class="flex items-start justify-between">--}}
{{--                            <h2 class="text-lg font-medium text-gray-900">Shopping Cart</h2>--}}
{{--                            <button onclick="toggleCart()" class="ml-3 h-7 flex items-center">--}}
{{--                                <svg class="h-6 w-6 text-gray-400 hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>--}}
{{--                                </svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}

{{--                        <div class="mt-8" id="cart-content">--}}
{{--                            <!-- Cart items will be loaded here -->--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">--}}
{{--                            <div class="flex justify-between text-base font-medium text-gray-900">--}}
{{--                                <p>Subtotal</p>--}}
{{--                                <p id="cart-subtotal">$0.00</p>--}}
{{--                            </div>--}}
{{--                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>--}}
{{--                            <div class="mt-6">--}}
{{--                                <a href="{{ route('marketplace.checkout') }}" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700">--}}
{{--                                    Checkout--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="mt-6 flex justify-center text-sm text-center text-gray-500">--}}
{{--                                <p>or <button @click="open = false" class="text-blue-600 font-medium hover:text-blue-500">Continue Shopping<span aria-hidden="true"> →</span></button></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


    <!-- Shopping Cart Drawer -->
    <!-- Shopping Cart Drawer -->
    <div id="cart-drawer" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Backdrop with blur effect - Fixed missing bg class -->
            <div class="absolute inset-0  bg-opacity-50 backdrop-blur-sm transition-opacity duration-300" onclick="toggleCart()"></div>

            <!-- Cart Panel -->
            <div id="cart-panel" class="fixed inset-y-0 right-0 pl-10 max-w-full flex transform transition-transform duration-500 ease-out">
                <div class="w-screen max-w-md h-full flex flex-col bg-white shadow-2xl">
                    <!-- Rest of your cart content remains the same -->
                    <!-- Header with gradient -->
                    <div class="relative px-6 py-8 bg-gradient-to-r from-blue-600 to-indigo-600">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-purple-400 opacity-10 rounded-full blur-2xl"></div>

                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">Your Cart</h2>
                                    <p class="text-sm text-blue-100" id="cart-item-count">Loading...</p>
                                </div>
                            </div>
                            <button onclick="toggleCart()" class="p-2 hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-200 group">
                                <svg class="w-5 h-5 text-white group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Cart Items Container with custom scrollbar -->
                    <div class="flex-1 overflow-y-auto px-6 py-4 bg-gray-50" id="cart-items-container" style="scrollbar-width: thin; scrollbar-color: #cbd5e0 #f7fafc;">
                        <div id="cart-content">
                            <!-- Cart items will be loaded here -->
                        </div>
                    </div>

                    <!-- Footer with checkout -->
                    <div class="border-t border-gray-200 bg-white px-6 py-6 space-y-4">
                        <!-- Coupon Code Section -->
                        <div class="flex space-x-2">
                            <input type="text" placeholder="Coupon code"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                                Apply
                            </button>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span id="cart-subtotal">$0.00</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Tax</span>
                                <span>Calculated at checkout</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between text-base font-bold text-gray-900">
                                    <span>Total</span>
                                    <span id="cart-total">$0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('marketplace.checkout') }}"
                           class="flex justify-center items-center w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Proceed to Checkout
                        </a>

                        <!-- Continue Shopping Link -->
                        <div class="text-center">
                            <button onclick="toggleCart()" class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200 flex items-center justify-center mx-auto group">
                                <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Continue Shopping
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Toggle Button with Badge -->
    <button onclick="toggleCart()" class="fixed bottom-6 right-6 group z-40">
        <div class="relative">
            <div class="absolute inset-0 bg-blue-600 rounded-full animate-ping opacity-20 group-hover:opacity-30"></div>
            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center shadow-lg animate-bounce-in">0</span>
        </div>
    </button>

    <!-- Success/Error Notification -->
    <div id="cart-notification" class="fixed top-4 right-4 z-50 transform transition-all duration-500 translate-x-full">
        <div class="bg-white rounded-lg shadow-2xl border-l-4 border-green-500 overflow-hidden">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900" id="notification-message">Item added to cart!</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button onclick="hideNotification()" class="inline-flex text-gray-400 hover:text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-green-500 progress-bar"></div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        // Cart functionality

        const cartDrawer = document.getElementById('cart-drawer');
        const cartPanel = document.getElementById('cart-panel');

        function toggleCart() {
            if (!cartDrawer || !cartPanel) return;
            if (cartDrawer.style.display === 'none' || cartDrawer.style.display === '') {
                openCart();
            } else {
                closeCart();
            }
        }

        function openCart() {
            if (!cartDrawer || !cartPanel) return;
            cartDrawer.style.display = 'block';
            // Trigger reflow
            cartDrawer.offsetHeight;
            cartPanel.classList.remove('slide-out');
            cartPanel.classList.add('slide-in');
            loadCart();
            document.body.style.overflow = 'hidden';
        }

        function closeCart() {
            if (!cartDrawer || !cartPanel) return;
            cartPanel.classList.remove('slide-in');
            cartPanel.classList.add('slide-out');
            setTimeout(() => {
                cartDrawer.style.display = 'none';
                document.body.style.overflow = '';
            }, 500);
        }

        // Enhanced load cart with loading state
        // Load cart function (simplified version)
        function loadCart() {
            const cartContent = document.getElementById('cart-content');
            const cartSubtotal = document.getElementById('cart-subtotal');
            const cartTotal = document.getElementById('cart-total');
            const cartItemCount = document.getElementById('cart-item-count');

            // Show loading state
            if (cartContent) {
                cartContent.innerHTML = '<div class="flex justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div></div>';
            }

            // Your existing fetch logic here
            fetch('{{ route("marketplace.cart") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart display (use your existing updateCartDisplay function)
                        if (typeof updateCartDisplay === 'function') {
                            updateCartDisplay(data);
                        }
                    }
                });
        }

        function generateSkeletonLoader() {
            let skeleton = '';
            for (let i = 0; i < 3; i++) {
                skeleton += `
            <div class="flex py-6">
                <div class="flex-shrink-0 w-24 h-24 skeleton rounded-lg"></div>
                <div class="ml-4 flex-1 space-y-3">
                    <div class="h-4 skeleton rounded w-3/4"></div>
                    <div class="h-3 skeleton rounded w-1/2"></div>
                    <div class="h-8 skeleton rounded w-full"></div>
                </div>
            </div>
        `;
            }
            return skeleton;
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
        }

        function updateCartDisplay(data) {
            const cartContent = document.getElementById('cart-content');
            const cartSubtotal = document.getElementById('cart-subtotal');
            const cartTotal = document.getElementById('cart-total');
            const cartItemCount = document.getElementById('cart-item-count');

            if (data.cart_items && data.cart_items.length > 0) {
                const totalItems = data.cart_items.reduce((sum, item) => sum + item.quantity, 0);
                cartItemCount.textContent = `${totalItems} ${totalItems === 1 ? 'item' : 'items'}`;

                let html = '<div class="flow-root"><ul class="-my-6 divide-y divide-gray-200">';

                data.cart_items.forEach(item => {
                    const itemTotal = (item.quantity * parseFloat(item.price)).toFixed(2);
                    html += `
                <li class="py-6 cart-item" data-item-id="${item.id}">
                    <div class="flex">
                        <!-- Product Image -->
                        <div class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                            ${item.product.images && item.product.images[0] ?
                        `<img src="${item.product.images[0]}" alt="${item.product.name}" class="w-full h-full object-center object-cover">` :
                        `<div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>`
                    }
                        </div>

                        <!-- Product Details -->
                        <div class="ml-4 flex-1 flex flex-col">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                        <a href="{{ url('/marketplace/cart/add') }} /${item.product.id}">${item.product.name}</a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">${item.team.name}</p>
                                </div>
                                <p class="text-base font-bold text-gray-900">$${itemTotal}</p>
                            </div>

                            <!-- Quantity and Remove -->
                            <div class="flex-1 flex items-end justify-between mt-2">
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm text-gray-500">Qty:</label>
                                    <div class="relative">
                                        <select onchange="updateCartItem(${item.id}, this.value)"
                                                class="appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 px-3 py-2">
                                            ${[1,2,3,4,5,6,7,8,9,10].map(num =>
                        `<option value="${num}" ${item.quantity == num ? 'selected' : ''}>${num}</option>`
                    ).join('')}
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="removeItemFromCart(${item.product.id})"
                                        class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center transition-colors duration-200 group">
                                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            `;
                });

                html += '</ul></div>';
                cartContent.innerHTML = html;
                cartSubtotal.textContent = `$${parseFloat(data.total_amount).toFixed(2)}`;
                cartTotal.textContent = `$${parseFloat(data.total_amount).toFixed(2)}`;
            } else {
                // Empty cart state with illustration
                cartContent.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <div class="w-32 h-32 mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-sm text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                <button onclick="toggleCart()" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Start Shopping
                </button>
            </div>
        `;
                cartItemCount.textContent = '0 items';
                cartSubtotal.textContent = '$0.00';
                cartTotal.textContent = '$0.00';
            }
        }

        function updateCartItem(productId, quantity) {
            // For now, just reload the cart to show updated quantity
            // In a real implementation, you would make an API call to update the quantity
            loadCart();
        }

        function removeItemFromCart(productId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                fetch(`/marketplace/cart/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Item removed from cart', 'success');
                        updateCartCount();
                        loadCart(); // Reload cart to show updated items
                    } else {
                        showNotification(data.message || 'Failed to remove item from cart', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while removing the item', 'error');
                });
            }
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

        // Close cart on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && cartDrawer.style.display === 'block') {
                closeCart();
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Ensure cart drawer starts hidden with correct transform
            if (cartDrawer) {
                cartDrawer.style.display = 'none';
            }
            if (cartPanel) {
                cartPanel.classList.add('slide-out');
            }
        });
    </script>
@endpush
