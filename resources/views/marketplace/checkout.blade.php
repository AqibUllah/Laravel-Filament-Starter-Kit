@extends('layouts.app')

@section('title', 'Secure Checkout - Marketplace')

@push('styles')
    <style>
        input[type="text"]{
        color: red !important;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="max-w-7xl mx-auto mb-10 text-center">
            <h1 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-3">
                Secure Checkout
            </h1>
            <p class="text-lg text-gray-600">Complete your purchase in just a few steps</p>
        </div>

        <!-- Progress Steps -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="relative flex justify-between">
                <!-- Progress Line -->
                <div class="absolute top-5 left-0 w-full h-1 bg-gray-200 rounded-full"></div>
                <div class="absolute top-5 left-0 w-2/3 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500"></div>

                <!-- Step 1 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-white border-2 border-blue-600 rounded-full shadow-lg z-10">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="mt-2 text-sm font-semibold text-blue-600">Information</span>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-white border-2 border-gray-300 rounded-full z-10">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Payment</span>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-white border-2 border-gray-300 rounded-full z-10">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Confirm</span>
                </div>
            </div>
        </div>

        @if(count($cart_items) < 1)
            <!-- Empty Cart State -->
            <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Your cart is empty</h3>
                <p class="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('marketplace.index') }}"
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Continue Shopping
                </a>
            </div>
        @else
            <form id="checkout-form" method="POST" action="{{ route('marketplace.checkout.process') }}" class="max-w-7xl mx-auto">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Forms -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Billing Information -->
                        <div class="bg-white text-gray-700 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                            <!-- Section Header -->
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                        <svg class="w-6 h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Billing Information</h3>
                                        <p class="text-blue-100 text-sm">Enter your billing details</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Fields -->
                            <div class="p-8 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- First Name -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            First Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="billing_first_name" name="billing_address[first_name]" required
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="John">
                                    </div>

                                    <!-- Last Name -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Last Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="billing_last_name" name="billing_address[last_name]" required
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Doe">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="billing_email" name="billing_address[email]" required
                                           value="{{ auth()->user()->email ?? '' }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           placeholder="john@example.com">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" id="billing_phone" name="billing_address[phone]"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           placeholder="+1 (555) 123-4567">
                                </div>

                                <!-- Address -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Street Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="billing_address" name="billing_address[address]" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           placeholder="123 Main St">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- City -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            City <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="billing_city" name="billing_address[city]" required
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="New York">
                                    </div>

                                    <!-- State -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            State <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="billing_state" name="billing_address[state]" required
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="NY">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Postal Code -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Postal Code <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="billing_postal_code" name="billing_address[postal_code]" required
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="10001">
                                    </div>

                                    <!-- Country -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Country <span class="text-red-500">*</span>
                                        </label>
                                        <select id="billing_country" name="billing_address[country]" required
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                            <option value="">Select Country</option>
                                            <option value="US">United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="AU">Australia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="bg-white text-gray-700 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                            <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                        <svg class="w-6 h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Shipping Information</h3>
                                        <p class="text-green-100 text-sm">Where should we deliver your order?</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8">
                                <!-- Same as billing checkbox -->
                                <div class="mb-6 p-4 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" id="same_as_billing" checked
                                               class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 transition duration-200">
                                        <span class="text-sm font-medium text-gray-700">Same as billing address</span>
                                    </label>
                                </div>

                                <!-- Shipping Address Fields (Hidden by default) -->
                                <div id="shipping-address-fields" class="space-y-6" style="display: none;">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                First Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="shipping_address[first_name]"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Last Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="shipping_address[last_name]"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Street Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="shipping_address[address]"
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                City <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="shipping_address[city]"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                State <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="shipping_address[state]"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Postal Code <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="shipping_address[postal_code]"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Country <span class="text-red-500">*</span>
                                            </label>
                                            <select name="shipping_address[country]"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                                <option value="">Select Country</option>
                                                <option value="US">United States</option>
                                                <option value="CA">Canada</option>
                                                <option value="UK">United Kingdom</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl text-gray-700">
                                        <svg class="w-6 h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold ">Order Notes</h3>
                                        <p class="text-sm">Special instructions for your order</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8">
                            <textarea name="notes" rows="4"
                                      class="w-full px-4 py-3 border-2 text-gray-700 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Any special delivery instructions or notes about your order..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-6">
                            <!-- Summary Header -->
                            <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-5">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-white">Order Summary</h3>
                                    <span class="px-3 py-1 bg-gray-700 text-gray-300 text-xs rounded-full">
                                    {{ count($cart_items) }} items
                                </span>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="max-h-96 overflow-y-auto px-6 py-4 space-y-4">
                                @foreach($cart_items as $item)
                                    <div class="flex items-start space-x-4 pb-4 border-b border-gray-100 last:border-0">
                                        <!-- Product Image -->
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                            @if($item['product']->images && !empty($item['product']->images))
                                                <img src="{{ collect($item['product']->images)->first() }}"
                                                     alt="{{ $item['product']->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900">{{ $item['product']->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">{{ $item['product']->team->name }}</p>
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="text-xs text-gray-600">Qty: {{ $item['quantity'] }}</span>
                                                <span class="text-sm font-bold text-gray-900">${{ number_format($item['total'], 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Price Breakdown -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-medium text-gray-900">${{ number_format($total_amount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Free
                                    </span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tax</span>
                                        <span class="text-gray-500">Calculated at checkout</span>
                                    </div>
                                    <div class="flex justify-between text-base font-bold pt-2 mt-2 border-t border-gray-200">
                                        <span class="text-gray-900">Total</span>
                                        <span class="text-gray-900">${{ number_format($total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Coupon Code -->
                            <div class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <input type="text" placeholder="Coupon code"
                                           class="flex-1 px-3 py-2 border-2 border-gray-200 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <button type="button"
                                            class="px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-sm font-semibold rounded-lg hover:from-yellow-600 hover:to-orange-600 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                        Apply
                                    </button>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-t border-gray-200">
                                <button type="submit" id="checkout-btn"
                                        class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                    <span id="btn-text">Complete Order</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </button>

                                <div class="mt-4 text-center">
                                    <a href="{{ route('marketplace.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                        ← Back to Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform scale-0 transition-transform duration-300">
            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h3>
            <p class="text-gray-600 mb-6">Thank you for your purchase. We'll send you an email with your order details.</p>
            <a href="{{ route('marketplace.index') }}"
               class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                Continue Shopping
            </a>
        </div>
    </div>

    <!-- Loading Spinner Component -->
    <div id="loading-spinner" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm" style="display: none;">
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto"></div>
            <p class="text-gray-700 mt-4 font-medium">Processing your order...</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sameAsBillingCheckbox = document.getElementById('same_as_billing');
            const shippingAddressFields = document.getElementById('shipping-address-fields');
            const checkoutForm = document.getElementById('checkout-form');
            const checkoutBtn = document.getElementById('checkout-btn');
            const btnText = document.getElementById('btn-text');
            const loadingSpinner = document.getElementById('loading-spinner');
            const successModal = document.getElementById('success-modal');

            // Toggle shipping fields
            if (sameAsBillingCheckbox) {
                sameAsBillingCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        shippingAddressFields.style.display = 'none';
                        shippingAddressFields.querySelectorAll('input, select').forEach(input => {
                            input.required = false;
                            input.disabled = true;
                        });
                    } else {
                        shippingAddressFields.style.display = 'block';
                        shippingAddressFields.querySelectorAll('input, select').forEach(input => {
                            if (!input.name.includes('phone')) {
                                input.required = true;
                            }
                            input.disabled = false;
                        });
                    }
                });
            }

            // Form submission
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Validate form
                    if (!validateForm()) {
                        return;
                    }

                    // Show loading state
                    checkoutBtn.disabled = true;
                    btnText.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>Processing...';
                    loadingSpinner.style.display = 'flex';

                    const formData = new FormData(this);

                    // If same as billing is checked, copy billing data to shipping
                    if (sameAsBillingCheckbox && sameAsBillingCheckbox.checked) {
                        const billingFields = {
                            'first_name': formData.get('billing_address[first_name]'),
                            'last_name': formData.get('billing_address[last_name]'),
                            'address': formData.get('billing_address[address]'),
                            'city': formData.get('billing_address[city]'),
                            'state': formData.get('billing_address[state]'),
                            'postal_code': formData.get('billing_address[postal_code]'),
                            'country': formData.get('billing_address[country]')
                        };

                        Object.keys(billingFields).forEach(key => {
                            formData.append(`shipping_address[${key}]`, billingFields[key]);
                        });
                    }

                    // Submit via fetch
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            loadingSpinner.style.display = 'none';

                            if (data.success) {
                                // Show success modal
                                const modalContent = successModal.querySelector('.bg-white');
                                successModal.style.display = 'flex';
                                setTimeout(() => {
                                    modalContent.classList.remove('scale-0');
                                    modalContent.classList.add('scale-100');
                                }, 50);

                                // Reset form
                                setTimeout(() => {
                                    if (data.redirect_url) {
                                        window.location.href = data.redirect_url;
                                    }
                                }, 2000);
                            } else {
                                showError(data.message || 'An error occurred during checkout.');
                                checkoutBtn.disabled = false;
                                btnText.textContent = 'Complete Order';
                            }
                        })
                        .catch(error => {
                            console.error('Checkout error:', error);
                            loadingSpinner.style.display = 'none';
                            showError('An error occurred during checkout. Please try again.');
                            checkoutBtn.disabled = false;
                            btnText.textContent = 'Complete Order';
                        });
                });
            }

            // Form validation
            function validateForm() {
                let isValid = true;
                const requiredFields = checkoutForm.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500', 'focus:ring-red-500');

                        // Add error message
                        let errorMsg = field.parentNode.querySelector('.error-message');
                        if (!errorMsg) {
                            errorMsg = document.createElement('p');
                            errorMsg.className = 'error-message text-xs text-red-500 mt-1 flex items-center';
                            errorMsg.innerHTML = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>This field is required';
                            field.parentNode.appendChild(errorMsg);
                        }
                    } else {
                        field.classList.remove('border-red-500', 'focus:ring-red-500');
                        const errorMsg = field.parentNode.querySelector('.error-message');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });

                if (!isValid) {
                    showError('Please fill in all required fields.');
                }

                return isValid;
            }

            // Show error message
            function showError(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'fixed top-4 right-4 z-50 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg shadow-lg flex items-center animate-slide-in';
                errorDiv.innerHTML = `
            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>${message}</span>
        `;

                document.body.appendChild(errorDiv);

                setTimeout(() => {
                    errorDiv.remove();
                }, 5000);
            }

            // Auto-populate user data
            @auth
            const user = @json(auth()->user());
            if (user.first_name) document.getElementById('billing_first_name').value = user.first_name;
            if (user.last_name) document.getElementById('billing_last_name').value = user.last_name;
            if (user.email) document.getElementById('billing_email').value = user.email;
            if (user.phone) document.getElementById('billing_phone').value = user.phone;
            @endauth

            // Phone number formatting
            const phoneInput = document.getElementById('billing_phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        if (value.length <= 3) {
                            value = value;
                        } else if (value.length <= 6) {
                            value = value.slice(0, 3) + '-' + value.slice(3);
                        } else {
                            value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                        }
                        e.target.value = value;
                    }
                });
            }
        });

        // Add custom animation class
        const style = document.createElement('style');
        style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
