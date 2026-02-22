@extends('layouts.app')

@section('title', 'Your Cart is Empty - Marketplace')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-600 via-white to-purple-600 relative overflow-hidden flex items-center justify-center">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Floating Particles -->
        <div class="absolute inset-0">
            @for ($i = 0; $i < 20; $i++)
                <div class="absolute w-1 h-1 bg-gray-300 rounded-full animate-float"
                     style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
            @endfor
        </div>

        <!-- Main Content Card -->
        <div class="relative z-10 max-w-2xl w-full mx-4 pb-5 pt-[80px]">
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 md:p-12 transform transition-all duration-500 hover:scale-[1.02] border border-white/20">
                <!-- Animated Icon -->
                <div class="relative flex justify-center mb-8">
                    <!-- Pulsing Rings -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-32 h-32 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full opacity-20 animate-ping"></div>
                        <div class="absolute w-40 h-40 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full opacity-10 animate-ping animation-delay-300"></div>
                    </div>

                    <!-- Cart Icon Container -->
                    <div class="relative w-36 h-36 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center shadow-lg transform hover:rotate-12 transition-transform duration-500">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>

                <!-- Text Content -->
                <div class="text-center mb-10">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                        Your Cart is Empty
                    </h1>
                    <p class="text-gray-600 text-lg max-w-md mx-auto">
                        Looks like you haven't added anything to your cart yet.
                        Explore our marketplace and discover amazing products!
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="{{ route('marketplace.index') }}"
                       class="group relative px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl font-semibold overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                        <span class="relative flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Start Shopping
                    </span>
                    </a>

                    <a href="{{ route('marketplace.index') }}#deals"
                       class="group px-8 py-4 bg-white text-gray-700 rounded-xl font-semibold border-2 border-gray-200 hover:border-purple-500 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-purple-500 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                        View Deals
                    </span>
                    </a>
                </div>

                <!-- Quick Links/Suggestions -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider text-center mb-6">
                        Quick Links
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Explore All -->
                        <div onclick="window.location='{{ route('marketplace.index') }}'"
                             class="group bg-gray-50 hover:bg-white rounded-2xl p-6 text-center cursor-pointer border-2 border-transparent hover:border-purple-500 transition-all duration-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Explore All</h4>
                            <p class="text-sm text-gray-500">Browse our collection</p>
                        </div>

                        <!-- Categories -->
                        <div onclick="window.location='{{ route('marketplace.index') }}#categories'"
                             class="group bg-gray-50 hover:bg-white rounded-2xl p-6 text-center cursor-pointer border-2 border-transparent hover:border-purple-500 transition-all duration-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Categories</h4>
                            <p class="text-sm text-gray-500">Shop by department</p>
                        </div>

                        <!-- Help Center -->
                        <div onclick="#'"
                             class="group bg-gray-50 hover:bg-white rounded-2xl p-6 text-center cursor-pointer border-2 border-transparent hover:border-purple-500 transition-all duration-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Help Center</h4>
                            <p class="text-sm text-gray-500">24/7 customer support</p>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center justify-center gap-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Secure Checkout</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Money-back Guarantee</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Fast Delivery</span>
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: Add interactive particle effect on mouse move
            const container = document.querySelector('.min-h-screen');

            container.addEventListener('mousemove', (e) => {
                const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
                const moveY = (e.clientY - window.innerHeight / 2) * 0.01;

                document.querySelectorAll('.animate-blob').forEach((blob, index) => {
                    const speed = index + 1;
                    blob.style.transform = `translate(${moveX * speed}px, ${moveY * speed}px)`;
                });
            });
        });
    </script>
@endpush
