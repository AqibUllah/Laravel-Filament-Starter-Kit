@extends('layouts.app')

@section('title', 'Select Payment Method - Marketplace')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-32 px-4 sm:px-6 lg:px-8 transition-colors duration-500 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating Orbs -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200 dark:bg-purple-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-float-slow"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-indigo-200 dark:bg-pink-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-float-slower animation-delay-2000"></div>
            <div class="absolute top-40 right-40 w-96 h-96 bg-purple-200 dark:bg-blue-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-20 animate-float animation-delay-4000"></div>

            <!-- Floating Particles -->
            @for ($i = 0; $i < 30; $i++)
                <div class="absolute w-1 h-1 bg-blue-400 dark:bg-purple-400 rounded-full animate-float-particle"
                     style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
            @endfor

            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-grid-pattern opacity-20 dark:opacity-10"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <!-- Header with Animation -->
            <div class="text-center mb-10 animate-fade-in-down">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-gray-800 dark:to-gray-700 rounded-full mb-4 transform hover:scale-105 transition-transform duration-300">
                    <svg class="w-5 h-5 text-blue-600 dark:text-purple-400 animate-pulse-subtle" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-400 dark:to-pink-400 uppercase tracking-wider">
                        Secure Checkout
                    </span>
                </div>

                <h1 class="text-4xl md:text-5xl font-extrabold mb-3">
                    <span class="bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent animate-gradient-x">
                        Select Payment Method
                    </span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto animate-fade-in animation-delay-300">
                    Choose how you'd like to pay for your orders securely
                </p>
            </div>

            <!-- Progress Steps with Enhanced Animation -->
            <div class="max-w-2xl mx-auto mb-12 animate-slide-up">
                <div class="relative flex justify-between">
                    <!-- Progress Line -->
                    <div class="absolute top-5 left-0 w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    <div class="absolute top-5 left-0 w-2/3 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-purple-500 dark:to-pink-600 rounded-full transition-all duration-500 animate-pulse-scale"></div>

                    <!-- Step 1 -->
                    <div class="relative flex flex-col items-center group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-green-500 dark:bg-green-400 rounded-full animate-ping opacity-25"></div>
                            <div class="relative w-10 h-10 flex items-center justify-center bg-green-500 dark:bg-green-400 border-2 border-green-600 dark:border-green-500 rounded-full shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <span class="mt-2 text-sm font-semibold text-green-600 dark:text-green-400">Information</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex flex-col items-center group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-blue-500 dark:bg-purple-400 rounded-full animate-ping opacity-25 animation-delay-500"></div>
                            <div class="relative w-10 h-10 flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-purple-500 dark:to-pink-600 border-2 border-transparent rounded-full shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                        </div>
                        <span class="mt-2 text-sm font-semibold text-blue-600 dark:text-purple-400">Payment</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex flex-col items-center group">
                        <div class="relative w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-full shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-500 dark:text-gray-400">Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Payment Methods Section -->
                <div class="lg:col-span-2 animate-slide-up animation-delay-150">
                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-xl dark:shadow-gray-900/50 p-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl dark:hover:shadow-purple-900/30">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600 dark:text-purple-400 animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Payment Methods
                        </h2>

                        <!-- Payment Method Options -->
                        <div class="space-y-4">
                            <!-- Stripe/Credit Card -->
                            <div class="payment-method-card relative group border-2 border-blue-500 dark:border-purple-500 bg-blue-50 dark:bg-purple-900/20 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1" data-method="stripe">
                                <!-- Animated gradient border -->
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>

                                <div class="relative flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-blue-600 dark:bg-purple-500 rounded-lg animate-ping opacity-25"></div>
                                            <div class="relative w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-600 rounded-lg flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Credit/Debit Card</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Pay securely with Visa, Mastercard, or American Express</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" class="w-8 h-8 transform group-hover:scale-110 transition-transform duration-300">
                                        <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard" class="w-8 h-8 transform group-hover:scale-110 transition-transform duration-300 delay-100">
                                        <img src="https://img.icons8.com/color/48/000000/amex.png" alt="Amex" class="w-8 h-8 transform group-hover:scale-110 transition-transform duration-300 delay-200">
                                    </div>
                                </div>
                            </div>

                            <!-- PayPal -->
                            <div class="payment-method-card relative group border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:border-blue-300 dark:hover:border-purple-500 transform hover:-translate-y-1" data-method="paypal">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>

                                <div class="relative flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-blue-700 dark:bg-purple-500 rounded-lg animate-ping opacity-25 animation-delay-300"></div>
                                        <div class="relative w-12 h-12 bg-gradient-to-r from-blue-700 to-indigo-700 dark:from-purple-500 dark:to-pink-600 rounded-lg flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944 2.419c.103-.464.462-.819.933-.819h7.654c2.603 0 4.808 1.927 5.09 4.456.082.726-.061 1.433-.371 2.046a4.01 4.01 0 0 1-1.114 1.362 4.414 4.414 0 0 1-1.873.82c-.286.047-.576.07-.866.07h-2.525l-.744 4.155a.641.641 0 0 1-.633.528h-2.527a.641.641 0 0 1-.633-.74l.743-4.155H9.38a.641.641 0 0 1-.633-.74l.743-4.155a.641.641 0 0 1 .633-.528h2.525c.29 0 .58-.023.866-.07a4.414 4.414 0 0 0 1.873-.82 4.01 4.01 0 0 0 1.114-1.362c.31-.613.453-1.32.371-2.046C16.339 3.527 14.134 1.6 11.531 1.6H3.877c-.471 0-.83.355-.933.819L.837 20.597a.641.641 0 0 0 .633.74h4.606l.743-4.155a.641.641 0 0 1 .633-.528h2.525a.641.641 0 0 1 .633.74l-.743 4.155h2.527a.641.641 0 0 0 .633-.528l.744-4.155h2.525c.29 0 .58.023.866.07a4.414 4.414 0 0 0 1.873-.82 4.01 4.01 0 0 0 1.114-1.362c.31-.613.453-1.32.371-2.046-.282-2.529-2.487-4.456-5.09-4.456H5.877c-.471 0-.83.355-.933.819L4.201 6.975a.641.641 0 0 0 .633.74h2.525l-.743 4.155a.641.641 0 0 1-.633.528H3.458l-.743 4.155a.641.641 0 0 0 .633.74h4.606l.743-4.155a.641.641 0 0 1 .633-.528h2.525a.641.641 0 0 1 .633.74l-.743 4.155z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">PayPal</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Fast and secure payment with your PayPal account</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="payment-method-card relative group border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-xl hover:border-green-300 dark:hover:border-green-500 transform hover:-translate-y-1" data-method="bank">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>

                                <div class="relative flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-green-600 dark:bg-green-500 rounded-lg animate-ping opacity-25 animation-delay-600"></div>
                                        <div class="relative w-12 h-12 bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-600 rounded-lg flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Bank Transfer</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Direct bank transfer (processing time: 1-3 business days)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Continue Button -->
                        <div class="mt-8">
                            <button id="continuePaymentBtn" class="group relative w-full bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 text-white font-semibold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-indigo-700 dark:hover:from-purple-700 dark:hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 overflow-hidden">
                                <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                                <span class="relative flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Continue to Payment
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div class="lg:col-span-1 animate-slide-up animation-delay-300">
                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-xl dark:shadow-gray-900/50 p-6 sticky top-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl dark:hover:shadow-purple-900/30">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-purple-400 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Order Summary
                        </h2>

                        @foreach($orders as $order)
                            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0 last:mb-0 last:pb-0">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Order #{{ $order->order_number }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->team->name ?? 'Unknown Store' }}</p>
                                    </div>
                                    <span class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-400 dark:to-pink-400">
                                        {{ $order->getFormattedTotalAmount() }}
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">{{ $item->product_name }} × {{ $item->quantity }}</span>
                                            <span class="text-gray-900 dark:text-white">{{ $order->currency }} {{ number_format($item->total_price, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <!-- Total -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-white">{{ $orders->first()->currency }} {{ number_format($orders->sum('subtotal_amount'), 2) }}</span>
                            </div>
                            @if($orders->sum('tax_amount') > 0)
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600 dark:text-gray-400">Tax</span>
                                    <span class="text-gray-900 dark:text-white">{{ $orders->first()->currency }} {{ number_format($orders->sum('tax_amount'), 2) }}</span>
                                </div>
                            @endif
                            @if($orders->sum('discount_amount') > 0)
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600 dark:text-gray-400">Discount</span>
                                    <span class="text-green-600 dark:text-green-400">-{{ $orders->first()->currency }} {{ number_format($orders->sum('discount_amount'), 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                <span class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-400 dark:to-pink-400">
                                    {{ $orders->first()->currency }} {{ number_format($orders->sum('total_amount'), 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="mt-6 flex items-center justify-center space-x-2 text-sm text-gray-600 dark:text-gray-400 group">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-300">Secure Payment</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for payment processing -->
    <form id="paymentForm" method="POST" action="{{ route('marketplace.payment.initiate', ['order' => $orders->first()->id]) }}" style="display: none;">
        @csrf
        <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="">
        <input type="hidden" name="order_ids" value="{{ $orders->pluck('id')->implode(',') }}">
    </form>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl dark:shadow-purple-900/30 transform scale-95 animate-modal-pop">
            <div class="flex flex-col items-center">
                <!-- Animated Loader -->
                <div class="relative mb-4">
                    <div class="w-16 h-16 border-4 border-gray-200 dark:border-gray-700 border-t-blue-600 dark:border-t-purple-600 rounded-full animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 rounded-full animate-pulse"></div>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Processing Payment</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Please wait while we redirect you to the payment gateway...</p>
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

        @keyframes pulse-scale {
            0%, 100% { transform: scaleX(1); }
            50% { transform: scaleX(1.02); }
        }

        .animate-pulse-scale {
            animation: pulse-scale 2s ease-in-out infinite;
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

        @keyframes modal-pop {
            0% { opacity: 0; transform: scale(0.9); }
            50% { transform: scale(1.05); }
            100% { opacity: 1; transform: scale(1); }
        }

        .animate-modal-pop {
            animation: modal-pop 0.3s ease-out forwards;
        }

        /* Animation Delays */
        .animation-delay-150 {
            animation-delay: 150ms;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        .animation-delay-500 {
            animation-delay: 500ms;
        }

        .animation-delay-600 {
            animation-delay: 600ms;
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
                linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .dark .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(168, 85, 247, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(168, 85, 247, 0.1) 1px, transparent 1px);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentCards = document.querySelectorAll('.payment-method-card');
            const continueBtn = document.getElementById('continuePaymentBtn');
            const paymentForm = document.getElementById('paymentForm');
            const selectedMethodInput = document.getElementById('selectedPaymentMethod');
            const loadingOverlay = document.getElementById('loadingOverlay');

            let selectedMethod = 'stripe'; // Default selection

            // Handle payment method selection with animation
            paymentCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active state from all cards with animation
                    paymentCards.forEach(c => {
                        c.classList.remove('border-blue-500', 'bg-blue-50', 'dark:border-purple-500', 'dark:bg-purple-900/20');
                        c.classList.add('border-gray-200', 'bg-white', 'dark:border-gray-700', 'dark:bg-gray-800');

                        // Add scale animation on removal
                        c.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            c.style.transform = '';
                        }, 200);
                    });

                    // Add active state to selected card with animation
                    this.classList.remove('border-gray-200', 'bg-white', 'dark:border-gray-700', 'dark:bg-gray-800');
                    this.classList.add('border-blue-500', 'bg-blue-50', 'dark:border-purple-500', 'dark:bg-purple-900/20');

                    // Add scale animation
                    this.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);

                    selectedMethod = this.dataset.method;
                    selectedMethodInput.value = selectedMethod;
                });
            });

            // Handle continue button click with enhanced animation
            continueBtn.addEventListener('click', async function() {
                // Button loading animation
                const originalText = this.innerHTML;
                this.innerHTML = `
            <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
            <span class="relative flex items-center justify-center gap-2">
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </span>
        `;
                this.disabled = true;
                this.classList.add('opacity-75', 'cursor-not-allowed');

                try {
                    // Show loading overlay with animation
                    loadingOverlay.classList.remove('hidden');

                    // Add entrance animation
                    const modal = loadingOverlay.firstElementChild;
                    modal.classList.add('animate-modal-pop');

                    // Submit form via AJAX
                    const formData = new FormData(paymentForm);
                    const response = await fetch(paymentForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    const result = await response.json();

                    if (result.success && result.payment_url) {
                        // Add exit animation before redirect
                        modal.style.transform = 'scale(0.9)';
                        modal.style.opacity = '0';

                        setTimeout(() => {
                            window.location.href = result.payment_url;
                        }, 300);
                    } else {
                        // Hide loading and show error
                        setTimeout(() => {
                            loadingOverlay.classList.add('hidden');
                            this.innerHTML = originalText;
                            this.disabled = false;
                            this.classList.remove('opacity-75', 'cursor-not-allowed');

                            // Show error message with animation
                            showNotification(result.message || 'Payment initiation failed. Please try again.', 'error');
                        }, 300);
                    }
                } catch (error) {
                    console.error('Payment error:', error);

                    // Hide loading and show error
                    setTimeout(() => {
                        loadingOverlay.classList.add('hidden');
                        this.innerHTML = originalText;
                        this.disabled = false;
                        this.classList.remove('opacity-75', 'cursor-not-allowed');

                        showNotification('Payment initiation failed. Please try again.', 'error');
                    }, 300);
                }
            });

            // Set initial active state with animation
            const defaultCard = document.querySelector('[data-method="stripe"]');
            if (defaultCard) {
                setTimeout(() => {
                    defaultCard.classList.remove('border-gray-200', 'bg-white', 'dark:border-gray-700', 'dark:bg-gray-800');
                    defaultCard.classList.add('border-blue-500', 'bg-blue-50', 'dark:border-purple-500', 'dark:bg-purple-900/20');
                    selectedMethodInput.value = 'stripe';
                }, 100);
            }

            // Notification function
            function showNotification(message, type = 'error') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform translate-x-full animate-slide-in ${
                    type === 'error' ? 'bg-red-500' : 'bg-green-500'
                } text-white`;
                notification.innerHTML = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('translate-x-0');
                }, 100);

                setTimeout(() => {
                    notification.classList.remove('translate-x-0');
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);
            }

            // Close loading overlay on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !loadingOverlay.classList.contains('hidden')) {
                    loadingOverlay.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
