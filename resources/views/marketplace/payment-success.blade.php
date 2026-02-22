@extends('layouts.app')

@section('title', 'Payment Successful - Marketplace')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-32 px-4 sm:px-6 lg:px-8 transition-colors duration-200">
        <!-- Header -->
        <div class="max-w-4xl mx-auto text-center mb-12 animate-fade-in">
            <!-- Success Icon with Animation -->
            <div class="relative inline-flex mb-6">
                <!-- Pulse Animation -->
                <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-25"></div>
                <div class="relative inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full shadow-xl">
                    <svg class="w-10 h-10 text-white transform transition-transform hover:scale-110 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-5xl md:text-6xl font-black mb-4">
                <span class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 dark:from-green-400 dark:via-emerald-400 dark:to-teal-400 bg-clip-text text-transparent">
                    Payment Successful!
                </span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Thank you for your purchase. Your order has been successfully processed and confirmed.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700 transform transition-all duration-300 hover:shadow-3xl">
                <!-- Order Header with Gradient -->
                <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 dark:from-green-600 dark:via-emerald-600 dark:to-teal-600 px-8 py-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-white">
                        <div class="space-y-1">
                            <h2 class="text-3xl font-bold tracking-tight">Order #{{ $order->order_number }}</h2>
                            <p class="text-green-100 dark:text-green-50 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold border border-white/30">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Payment Confirmed
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-8 md:p-10">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Order Items</h3>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-sm">
                            {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                        </span>
                    </div>

                    <div class="space-y-4 mb-10">
                        @foreach($order->items as $item)
                            <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600 hover:border-green-200 dark:hover:border-green-800 transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    @if(!empty($item->product->images))
                                        <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}" class="w-20 h-20 object-cover rounded-xl shadow-md group-hover:shadow-lg transition-shadow">
                                    @else
                                        <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-xl flex items-center justify-center shadow-md">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="space-y-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white text-lg">{{ $item->product_name }}</h4>
                                        <div class="flex flex-wrap items-center gap-3 text-sm">
                                            <span class="text-gray-600 dark:text-gray-300">Qty: {{ $item->quantity }}</span>
                                            @if(!empty($item->product_snapshot['sku']))
                                                <span class="text-gray-400 dark:text-gray-500">•</span>
                                                <span class="text-gray-500 dark:text-gray-400">SKU: {{ $item->product_snapshot['sku'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-3 sm:mt-0">
                                    <p class="font-bold text-gray-900 dark:text-white text-xl">{{ $order->currency }} {{ number_format($item->product_price * $item->quantity, 2) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->currency }} {{ number_format($item->product_price, 2) }} each</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary with Modern Design -->
                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-6 mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Summary</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-gray-600 dark:text-gray-300">
                                <span>Subtotal</span>
                                <span class="font-medium">{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            @if($order->tax_amount > 0)
                                <div class="flex justify-between items-center text-gray-600 dark:text-gray-300">
                                    <span>Tax</span>
                                    <span class="font-medium">{{ $order->currency }} {{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($order->shipping_amount > 0)
                                <div class="flex justify-between items-center text-gray-600 dark:text-gray-300">
                                    <span>Shipping</span>
                                    <span class="font-medium">{{ $order->currency }} {{ number_format($order->shipping_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                    <span class="text-3xl font-black bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-400 dark:to-emerald-400 bg-clip-text text-transparent">
                                        {{ $order->currency }} {{ number_format($order->total_amount, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons with Modern Design -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('marketplace.index') }}" class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                            <span class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
                            <svg class="w-5 h-5 mr-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="relative z-10">Continue Shopping</span>
                        </a>
                        <a href="#" class="group relative inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-700 dark:text-gray-200 font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                            <span class="absolute inset-0 bg-gray-100 dark:bg-gray-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
                            <svg class="w-5 h-5 mr-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="relative z-10">View Order History</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
    </style>
@endpush
