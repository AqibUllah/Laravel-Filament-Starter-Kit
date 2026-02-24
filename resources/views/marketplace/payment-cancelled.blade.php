@extends('layouts.app')

@section('title', 'Payment Cancelled - Marketplace')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-rose-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-32 px-4 sm:px-6 lg:px-8 transition-colors duration-500 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating Orbs -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-red-200 dark:bg-red-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-float-slow"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-rose-200 dark:bg-rose-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-float-slower animation-delay-2000"></div>
            <div class="absolute top-40 right-40 w-96 h-96 bg-pink-200 dark:bg-pink-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-20 animate-float animation-delay-4000"></div>

            <!-- Floating Particles -->
            @for ($i = 0; $i < 30; $i++)
                <div class="absolute w-1 h-1 bg-red-400 dark:bg-rose-400 rounded-full animate-float-particle"
                     style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
            @endfor

            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-grid-pattern opacity-20 dark:opacity-10"></div>
        </div>

        <!-- Header -->
        <div class="relative z-10 max-w-4xl mx-auto text-center mb-12 animate-fade-in-down">
            <!-- Animated Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-100 to-rose-100 dark:from-gray-800 dark:to-gray-700 rounded-full mb-4 transform hover:scale-105 transition-transform duration-300">
                <svg class="w-5 h-5 text-red-600 dark:text-rose-400 animate-pulse-subtle" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-rose-600 dark:from-rose-400 dark:to-pink-400 uppercase tracking-wider">
                    Payment Status
                </span>
            </div>

            <!-- Cancel Icon with Enhanced Animation -->
            <div class="relative inline-flex mb-6 group">
                <!-- Multiple Pulse Rings -->
                <div class="absolute inset-0 bg-red-500 dark:bg-rose-500 rounded-full animate-ping opacity-25"></div>
                <div class="absolute inset-0 bg-red-500 dark:bg-rose-500 rounded-full animate-ping opacity-25 animation-delay-500"></div>
                <div class="absolute inset-0 bg-red-500 dark:bg-rose-500 rounded-full animate-ping opacity-25 animation-delay-1000"></div>

                <!-- Icon Container -->
                <div class="relative inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-red-400 to-rose-500 dark:from-rose-500 dark:to-pink-600 rounded-full shadow-xl transform group-hover:rotate-12 group-hover:scale-110 transition-all duration-500">
                    <svg class="w-12 h-12 text-white transform group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-5xl md:text-6xl font-black mb-4 animate-slide-up">
                <span class="bg-gradient-to-r from-red-600 via-rose-600 to-pink-600 dark:from-rose-400 dark:via-pink-400 dark:to-red-400 bg-clip-text text-transparent animate-gradient-x">
                    Payment Cancelled
                </span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto animate-fade-in animation-delay-500">
                Your payment has been cancelled. Your order has been saved and you can try again whenever you're ready.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="relative z-10 max-w-4xl mx-auto animate-scale-in">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-3xl shadow-2xl dark:shadow-red-900/20 overflow-hidden border border-gray-100 dark:border-gray-700 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-3xl dark:hover:shadow-rose-900/30">
                <!-- Order Header with Gradient -->
                <div class="bg-gradient-to-r from-red-500 via-rose-500 to-pink-500 dark:from-rose-600 dark:via-pink-600 dark:to-red-600 px-8 py-8 relative overflow-hidden">
                    <!-- Animated Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer"></div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-white relative z-10">
                        <div class="space-y-1">
                            <h2 class="text-3xl font-bold tracking-tight flex items-center gap-2">
                                <svg class="w-8 h-8 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Order #{{ $order->order_number }}
                            </h2>
                            <p class="text-red-100 dark:text-rose-100 flex items-center">
                                <svg class="w-4 h-4 mr-2 animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold border border-white/30 transform hover:scale-105 transition-transform duration-300">
                                <svg class="w-4 h-4 mr-2 animate-spin-slow" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Payment Cancelled
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Cancellation Message -->
                <div class="p-8 md:p-10">
                    <div class="bg-red-50 dark:bg-gray-700/50 border-l-4 border-red-400 dark:border-rose-500 p-6 mb-8 rounded-r-lg transform hover:scale-[1.01] transition-transform duration-300">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-red-400 dark:bg-rose-400 rounded-full animate-ping opacity-25"></div>
                                    <svg class="relative h-6 w-6 text-red-400 dark:text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-red-800 dark:text-rose-200">Payment Status</h3>
                                <div class="mt-2 text-sm text-red-700 dark:text-gray-300">
                                    <p>Your payment was cancelled. No charges were made to your account.</p>
                                    <p class="mt-1 font-medium">Your order is still saved and you can complete the payment anytime.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500 dark:text-rose-400 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Order Items
                        </h3>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-sm transform hover:scale-105 transition-transform duration-300">
                            {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                        </span>
                    </div>

                    <div class="space-y-4 mb-10">
                        @foreach($order->items as $index => $item)
                            <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600 hover:border-red-200 dark:hover:border-rose-800 transition-all duration-500 hover:shadow-xl transform hover:-translate-y-1"
                                 style="animation-delay: {{ $index * 0.1 }}s">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        @if(!empty($item->product->images))
                                            <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}"
                                                 class="w-20 h-20 object-cover rounded-xl shadow-md group-hover:shadow-lg transition-all duration-500 group-hover:scale-110">
                                        @else
                                            <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-500">
                                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <!-- Quantity Badge -->
                                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-r from-red-500 to-rose-500 dark:from-rose-500 dark:to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold transform group-hover:scale-110 transition-transform duration-300">
                                            {{ $item->quantity }}
                                        </span>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white text-lg group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-red-600 group-hover:to-rose-600 dark:group-hover:from-rose-400 dark:group-hover:to-pink-400 transition-all duration-300">
                                            {{ $item->product_name }}
                                        </h4>
                                        <div class="flex flex-wrap items-center gap-3 text-sm">
                                            <span class="text-gray-600 dark:text-gray-300">Unit Price: {{ $order->currency }} {{ number_format($item->product_price, 2) }}</span>
                                            @if(!empty($item->product_snapshot['sku']))
                                                <span class="text-gray-400 dark:text-gray-500">•</span>
                                                <span class="text-gray-500 dark:text-gray-400">SKU: {{ $item->product_snapshot['sku'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-3 sm:mt-0">
                                    <p class="font-bold text-gray-900 dark:text-white text-xl">{{ $order->currency }} {{ number_format($item->product_price * $item->quantity, 2) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary with Modern Design -->
                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-6 mb-8 transform hover:scale-[1.01] transition-transform duration-300">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500 dark:text-rose-400 animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Order Summary
                        </h4>
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
                                    <span class="text-3xl font-black bg-gradient-to-r from-red-600 to-rose-600 dark:from-rose-400 dark:to-pink-400 bg-clip-text text-transparent animate-pulse-subtle">
                                        {{ $order->currency }} {{ number_format($order->total_amount, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons with Modern Design -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('marketplace.payment.selection', ['orders' => [$order->id]]) }}"
                           class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 dark:from-rose-500 dark:to-pink-600 dark:hover:from-rose-600 dark:hover:to-pink-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            <span class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <svg class="w-5 h-5 mr-2 relative z-10 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span class="relative z-10">Try Payment Again</span>
                        </a>
                        <a href="{{ route('marketplace.index') }}"
                           class="group relative inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 hover:border-red-300 dark:hover:border-rose-500 text-gray-700 dark:text-gray-200 font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <span class="absolute inset-0 bg-gray-100 dark:bg-gray-600 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            <svg class="w-5 h-5 mr-2 relative z-10 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="relative z-10">Continue Shopping</span>
                        </a>
                    </div>

                    <!-- Help Text -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Need help? <a href="#" class="text-red-600 dark:text-rose-400 hover:underline font-medium">Contact Support</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Animation Keyframes */
        @keyframes float-slow {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .animate-float-slow {
            animation: float-slow 8s ease-in-out infinite;
        }

        .animate-float-slower {
            animation: float-slow 12s ease-in-out infinite;
        }

        @keyframes float-particle {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            25% { transform: translateY(-20px) translateX(10px); opacity: 0.6; }
            50% { transform: translateY(-30px) translateX(-10px); opacity: 0.4; }
            75% { transform: translateY(-20px) translateX(20px); opacity: 0.6; }
        }

        .animate-float-particle {
            animation: float-particle 6s ease-in-out infinite;
        }

        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(0.95); }
        }

        .animate-pulse-subtle {
            animation: pulse-subtle 2s ease-in-out infinite;
        }

        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        @keyframes gradient-x {
            0%, 100% { background-size: 200% 200%; background-position: left center; }
            50% { background-size: 200% 200%; background-position: right center; }
        }

        .animate-gradient-x {
            animation: gradient-x 3s ease infinite;
            background-size: 200% 200%;
        }

        @keyframes fade-in-down {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.8s ease-out forwards;
        }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out forwards;
        }

        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out forwards;
        }

        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-scale-in {
            animation: scale-in 0.6s ease-out forwards;
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        /* Animation Delays */
        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Grid Pattern */
        .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(239, 68, 68, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(239, 68, 68, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .dark .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(251, 113, 133, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(251, 113, 133, 0.1) 1px, transparent 1px);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        }
    </style>
@endpush
