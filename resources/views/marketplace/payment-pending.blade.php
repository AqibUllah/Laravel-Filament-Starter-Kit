@extends('layouts.app')

@section('title', 'Payment Processing - Marketplace')

@section('content')
    <div class="min-h-screen transition-colors duration-300 bg-gradient-to-br from-yellow-50 to-orange-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-32 px-4 sm:px-6 lg:px-8">
        <!-- Animated Background Elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <!-- Light Mode Elements -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-0 animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-0 animate-blob animation-delay-2000"></div>

            <!-- Dark Mode Elements -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-900 rounded-full mix-blend-multiply filter blur-3xl opacity-0 dark:opacity-20 animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-blue-900 rounded-full mix-blend-multiply filter blur-3xl opacity-0 dark:opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-96 h-96 bg-indigo-900 rounded-full mix-blend-multiply filter blur-3xl opacity-0 dark:opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Floating Particles -->
        <div class="fixed inset-0 pointer-events-none">
            @for ($i = 0; $i < 15; $i++)
                <div class="absolute w-1 h-1 bg-yellow-300 dark:bg-blue-400 rounded-full animate-float-particle"
                     style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: {{ rand(3, 7) / 10 }};"></div>
            @endfor
        </div>

        <!-- Header -->
        <div class="relative z-10 max-w-4xl mx-auto text-center mb-12">
            <!-- Animated Icon Container -->
            <div class="relative inline-flex mb-6">
                <!-- Pulsing Rings -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-yellow-400 to-orange-400 dark:from-blue-500 dark:to-purple-600 rounded-full opacity-20 animate-ping"></div>
                    <div class="absolute w-28 h-28 bg-gradient-to-r from-yellow-400 to-orange-400 dark:from-blue-500 dark:to-purple-600 rounded-full opacity-10 animate-ping animation-delay-300"></div>
                </div>

                <!-- Main Icon -->
                <div class="relative w-20 h-20 bg-gradient-to-r from-yellow-500 to-orange-600 dark:from-blue-600 dark:to-purple-700 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
            <span class="bg-gradient-to-r from-yellow-600 to-orange-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">
                Payment Processing
            </span>
            </h1>
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Your payment is being processed. We'll update this page once the payment is confirmed.
                This usually takes just a few moments.
            </p>

            <!-- Progress Bar -->
            <div class="max-w-md mx-auto">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <span>Processing</span>
                    <span>Confirming</span>
                    <span>Complete</span>
                </div>
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-yellow-500 to-orange-600 dark:from-blue-500 dark:to-purple-600 rounded-full animate-progress"></div>
                </div>
            </div>
        </div>

        <!-- Order Details Card -->
        <div class="relative z-10 max-w-4xl mx-auto">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-2xl dark:shadow-gray-900/50 overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-yellow-500 to-orange-600 dark:from-blue-600 dark:to-purple-700 px-8 py-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-white">
                        <div>
                            <h2 class="text-2xl font-bold flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Order #{{ $order->order_number }}
                            </h2>
                            <p class="text-yellow-100 dark:text-blue-100">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-4 py-2 bg-white/20 dark:bg-black/20 rounded-full text-sm font-semibold backdrop-blur-sm">
                            <svg class="w-4 h-4 mr-2 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Processing
                        </span>
                        </div>
                    </div>
                </div>

                <!-- Processing Message -->
                <div class="p-8">
                    <div class="bg-yellow-50 dark:bg-gray-700/50 border-l-4 border-yellow-400 dark:border-blue-500 p-6 mb-8 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-400 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Payment Status</h3>
                                <div class="mt-2 text-sm text-yellow-700 dark:text-gray-300">
                                    <p>We're waiting for confirmation from the payment processor. This usually takes a few moments.</p>
                                    <p class="mt-1 font-medium">You can safely refresh this page to check for updates.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Order Items
                    </h3>

                    <div class="space-y-4 mb-8">
                        @foreach($order->items as $item)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <div class="flex items-center space-x-4">
                                    @if(!empty($item->product_snapshot['images']))
                                        <img src="{{ $item->product_snapshot['images'][0] }}" alt="{{ $item->product_name }}"
                                             class="w-16 h-16 object-cover rounded-lg border-2 border-white dark:border-gray-600 shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $item->product_name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: {{ $item->quantity }}</p>
                                        @if(!empty($item->product_snapshot['sku']))
                                            <p class="text-sm text-gray-500 dark:text-gray-500">SKU: {{ $item->product_snapshot['sku'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right mt-2 sm:mt-0">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $order->currency }} {{ number_format($item->product_price * $item->quantity, 2) }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->currency }} {{ number_format($item->product_price, 2) }} each</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="border-t dark:border-gray-700 pt-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if($order->tax_amount > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $order->currency }} {{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($order->shipping_amount > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $order->currency }} {{ number_format($order->shipping_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between items-center text-green-600 dark:text-green-400">
                                    <span>Discount:</span>
                                    <span>-{{ $order->currency }} {{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center pt-4 mt-3 border-t border-dashed dark:border-gray-700">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Total:</span>
                            <div class="text-right">
                            <span class="text-2xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">
                                {{ $order->currency }} {{ number_format($order->total_amount, 2) }}
                            </span>
                                <p class="text-xs text-gray-500 dark:text-gray-500">Including all taxes</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <button onclick="location.reload()"
                                class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-yellow-500 to-orange-600 dark:from-blue-600 dark:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:from-yellow-600 hover:to-orange-700 dark:hover:from-blue-700 dark:hover:to-purple-800 transform hover:-translate-y-1 transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Refresh Status
                        </button>

                        <a href="{{ route('marketplace.index') }}"
                           class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-xl shadow-lg hover:bg-gray-50 dark:hover:bg-gray-600 transform hover:-translate-y-1 transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Payment Methods -->
                    <div class="mt-6 flex items-center justify-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <span>Payment Method:</span>
                        <div class="flex items-center gap-2">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M0 0h24v24H0z" fill="none"/>
                                <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                            </svg>
                            <span>{{ $order->payment_method ?? 'Credit Card' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        @keyframes float-particle {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(-30px) translateX(-10px); }
            75% { transform: translateY(-20px) translateX(20px); }
        }

        .animate-float-particle {
            animation: float-particle 4s ease-in-out infinite;
        }

        @keyframes progress {
            0% { width: 10%; }
            25% { width: 35%; }
            50% { width: 60%; }
            75% { width: 80%; }
            100% { width: 90%; }
        }

        .animate-progress {
            animation: progress 3s ease-in-out infinite;
            width: 10%;
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        /* Smooth theme transition */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            'use strict';

            // Auto-refresh every 10 seconds to check payment status
            let refreshInterval = setInterval(function() {
                location.reload();
            }, 10000);

            // Stop refreshing if page is hidden (improves performance)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    clearInterval(refreshInterval);
                } else {
                    refreshInterval = setInterval(function() {
                        location.reload();
                    }, 10000);
                }
            });

            // Optional: Add smooth mouse move effect to background
            const container = document.querySelector('.min-h-screen');

            container.addEventListener('mousemove', (e) => {
                const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
                const moveY = (e.clientY - window.innerHeight / 2) * 0.01;

                document.querySelectorAll('.animate-blob').forEach((blob, index) => {
                    const speed = index + 1;
                    blob.style.transform = `translate(${moveX * speed}px, ${moveY * speed}px)`;
                });
            });

            // Check for dark mode preference
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }

            // Listen for theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                if (event.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });
        })();
    </script>
@endpush
