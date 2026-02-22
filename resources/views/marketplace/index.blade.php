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


        /* Custom animations that can be added to tailwind.config.js */
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

        @keyframes slide {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .animate-slide {
            animation: slide 8s linear infinite;
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }

        .animate-spin-slower {
            animation: spin-slow 30s linear infinite;
        }

        @keyframes gradient-x {
            0%, 100% { background-size: 200% 200%; background-position: left center; }
            50% { background-size: 200% 200%; background-position: right center; }
        }

        .animate-gradient-x {
            animation: gradient-x 3s ease infinite;
            background-size: 200% 200%;
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

        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        @keyframes wave {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(-10px); }
        }

        .animate-wave {
            animation: wave 5s ease-in-out infinite;
        }

        /* Animation delays */
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

        /* Grid pattern */
        .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* Dark mode grid pattern */
        .dark .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(168, 85, 247, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(168, 85, 247, 0.1) 1px, transparent 1px);
        }

        /* Pulse subtle */
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .animate-pulse-subtle {
            animation: pulse-subtle 2s ease-in-out infinite;
        }

        /* Fade animations */
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out forwards;
        }

        @keyframes slide-down {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-down {
            animation: slide-down 0.6s ease-out forwards;
        }

        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out forwards;
        }
    </style>

    <!-- cart-drawer styles -->
    <style>
        /* Custom Scrollbar */
        #cart-items-container {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

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
        }

        #cart-items-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Dark mode scrollbar */
        .dark #cart-items-container {
            scrollbar-color: #4b5563 #1f2937;
        }

        .dark #cart-items-container::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .dark #cart-items-container::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .dark #cart-items-container::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        /* Animation Keyframes */
        @keyframes float-particle {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            25% { transform: translateY(-20px) translateX(10px); opacity: 0.6; }
            50% { transform: translateY(-30px) translateX(-10px); opacity: 0.4; }
            75% { transform: translateY(-20px) translateX(20px); opacity: 0.6; }
        }

        .animate-float-particle {
            animation: float-particle 6s ease-in-out infinite;
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.1; transform: scale(1); }
            50% { opacity: 0.2; transform: scale(1.1); }
        }

        .animate-pulse-slow {
            animation: pulse-slow 4s ease-in-out infinite;
        }

        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        /* Animation Delays */
        .animation-delay-1000 {
            animation-delay: 1s;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        }
    </style>

@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
        <!-- Hero Section with Parallax Effect -->
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 dark:from-gray-900 dark:via-purple-900 dark:to-indigo-900 transition-colors duration-500">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <!-- Floating Orbs -->
                <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 dark:bg-purple-400/20 rounded-full mix-blend-overlay filter blur-3xl animate-float-slow"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-white/10 dark:bg-blue-400/20 rounded-full mix-blend-overlay filter blur-3xl animate-float-slower animation-delay-2000"></div>
                <div class="absolute top-40 right-40 w-80 h-80 bg-white/10 dark:bg-pink-400/20 rounded-full mix-blend-overlay filter blur-3xl animate-float animation-delay-4000"></div>

                <!-- Grid Pattern -->
                <div class="absolute inset-0 bg-grid-pattern opacity-20 dark:opacity-30"></div>

                <!-- Animated Lines -->
                <div class="absolute inset-0">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="absolute h-px w-full bg-gradient-to-r from-transparent via-white/20 dark:via-purple-400/20 to-transparent animate-slide"
                             style="top: {{ 10 + $i * 20 }}%; animation-delay: {{ $i * 0.5 }}s;"></div>
                    @endfor
                </div>

                <!-- Floating Particles -->
                @for ($i = 0; $i < 30; $i++)
                    <div class="absolute w-1 h-1 bg-white/30 dark:bg-purple-400/30 rounded-full animate-float-particle"
                         style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                @endfor

                <!-- Rotating Rings -->
                <div class="absolute -top-1/2 -right-1/2 w-[800px] h-[800px] border-2 border-white/10 dark:border-purple-500/10 rounded-full animate-spin-slow"></div>
                <div class="absolute -bottom-1/2 -left-1/2 w-[600px] h-[600px] border-2 border-white/10 dark:border-blue-500/10 rounded-full animate-spin-slower animation-delay-1000"></div>
            </div>

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 dark:from-black/40 via-transparent to-transparent"></div>

            <!-- Main Content -->
            <div class="relative pt-24 pb-16 md:pt-32 md:pb-24 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center animate-fade-in-up">
                        <!-- Badge -->
                        <div class="inline-flex items-center px-4 py-2 bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-full text-white/90 dark:text-white text-sm font-semibold mb-8 animate-bounce-subtle">
                            <svg class="w-4 h-4 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                            </svg>
                            Welcome to {{ config('app.name') }}
                        </div>

                        <!-- Main Heading -->
                        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight">
                            <span class="block animate-slide-down">Discover Amazing</span>
                            <span class="block text-4xl md:text-6xl mt-2 text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300 dark:from-purple-300 dark:to-pink-300 animate-gradient-x">
                        Products & Services
                    </span>
                        </h1>

                        <!-- Description -->
                        <p class="text-xl md:text-2xl text-white/90 dark:text-white/80 mb-10 max-w-3xl mx-auto animate-fade-in animation-delay-500">
                            Discover exceptional products from our curated network of trusted sellers
                        </p>

                        <!-- Search Bar -->
                        <div class="max-w-2xl mx-auto mb-8 animate-slide-up animation-delay-700">
                            <form method="GET" action="{{ route('marketplace.index') }}" class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-pink-400 dark:from-purple-400 dark:to-pink-400 rounded-lg blur opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                                <div class="relative flex items-center bg-white/10 dark:bg-gray-800/50 backdrop-blur-md rounded-lg shadow-2xl p-1 border border-white/20 dark:border-purple-500/30">
                                    <input type="text" name="search" placeholder="Search for products..."
                                           value="{{ request('search') }}"
                                           class="flex-1 px-6 py-4 text-white placeholder-white/70 bg-transparent border-none focus:outline-none text-lg">
                                    <button type="submit" class="bg-gradient-to-r from-yellow-400 to-pink-400 dark:from-purple-500 dark:to-pink-500 text-white px-8 py-4 rounded-lg hover:from-yellow-500 hover:to-pink-500 dark:hover:from-purple-600 dark:hover:to-pink-600 transition-all duration-300 font-semibold transform hover:scale-105 hover:shadow-xl">
                                        <svg class="w-5 h-5 inline-block mr-2 animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Search
                                    </button>
                                </div>
                            </form>

                            <!-- Popular Searches -->
                            <div class="flex flex-wrap justify-center gap-2 mt-4 text-sm text-white/70 dark:text-white/60">
                                <span>Popular:</span>
                                @foreach(['Electronics', 'Fashion', 'Home & Garden', 'Sports'] as $term)
                                    <a href="{{ route('marketplace.index', ['search' => $term]) }}"
                                       class="hover:text-white dark:hover:text-white transition-colors duration-200">
                                        {{ $term }}
                                    </a>
                                    @if(!$loop->last)<span>•</span>@endif
                                @endforeach
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in animation-delay-1000">
                            <a href="#categories"
                               class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-medium rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 overflow-hidden">
                                <span class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-400 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Browse Categories
                            </a>

                            @guest
                                <a href="#"
                                   class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-medium rounded-lg text-white bg-gradient-to-r from-yellow-400 to-orange-500 dark:from-purple-500 dark:to-pink-500 hover:from-yellow-500 hover:to-orange-600 dark:hover:from-purple-600 dark:hover:to-pink-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 overflow-hidden">
                                    <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Join as Buyer
                                </a>
                            @endguest

                            <!-- Stats Counter -->
                            <div class="flex items-center justify-center gap-4 text-white/80 dark:text-white/70 mt-4 sm:mt-0 sm:ml-4">
                                <div class="flex items-center">
                                    <span class="text-2xl font-bold animate-pulse-subtle">10k+</span>
                                    <span class="ml-1 text-sm">Products</span>
                                </div>
                                <div class="w-px h-8 bg-white/30 dark:bg-white/20"></div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-bold animate-pulse-subtle animation-delay-500">5k+</span>
                                    <span class="ml-1 text-sm">Sellers</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Animated Wave Divider -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg class="fill-current text-gray-50 dark:text-gray-900" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="wave-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#764ba2;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#6b46c1;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path class="animate-wave" fill="url(#wave-gradient)" fill-opacity="0.1" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
                    <path class="animate-wave animation-delay-500" fill="url(#wave-gradient)" fill-opacity="0.05" d="M0,96L80,101.3C160,107,320,117,480,112C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
                </svg>
            </div>
        </div>

        <!-- Products Grid with Advanced Filters -->
        <section class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Filter Bar with Glass Effect -->
                <div class="relative group mb-8">
                    <!-- Animated gradient border -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-purple-400 dark:to-pink-400 rounded-2xl blur opacity-0 group-hover:opacity-30 transition-opacity duration-500"></div>

                    <div class="relative bg-white dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-lg dark:shadow-gray-900/50 p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl dark:hover:shadow-gray-900/70">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        All Products
                                        <span class="ml-2 text-sm font-normal text-gray-500 dark:text-gray-400">({{ $products->total() }} items)</span>
                                    </h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Discover our curated collection</p>
                                </div>
                            </div>

                            <form method="GET" action="{{ route('marketplace.index') }}" class="flex flex-col sm:flex-row gap-3">
                                <!-- Category Filter -->
                                <div class="relative group/select">
                                    <select name="category"
                                            class="appearance-none w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white py-3 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all duration-200 cursor-pointer hover:border-blue-500 dark:hover:border-purple-400">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Seller Filter -->
                                <div class="relative group/select">
                                    <select name="team"
                                            class="appearance-none w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white py-3 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all duration-200 cursor-pointer hover:border-blue-500 dark:hover:border-purple-400">
                                        <option value="">All Sellers</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}" {{ request('team') == $team->id ? 'selected' : '' }}>
                                                {{ $team->name }} ({{ $team->products_count }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Sort Filter -->
                                <div class="relative group/select">
                                    <select name="sort"
                                            class="appearance-none w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white py-3 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all duration-200 cursor-pointer hover:border-blue-500 dark:hover:border-purple-400">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <button type="submit"
                                            class="group/btn relative px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 dark:hover:from-purple-600 dark:hover:to-pink-600 transition-all duration-300 font-semibold overflow-hidden shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></span>
                                        <span class="relative flex items-center">
                                    <svg class="w-5 h-5 mr-2 animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Apply
                                </span>
                                    </button>

                                    @if(request()->anyFilled(['category', 'team', 'sort', 'search']))
                                        <a href="{{ route('marketplace.index') }}"
                                           class="group/btn px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 group-hover/btn:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Clear
                                    </span>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Active Filters Display -->
                        @if(request()->anyFilled(['category', 'team', 'search']))
                            <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                                @if(request('search'))
                                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm">
                                Search: "{{ request('search') }}"
                                <a href="{{ route('marketplace.index', array_merge(request()->except('search'), request()->query())) }}" class="ml-2 hover:text-blue-600 dark:hover:text-blue-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </span>
                                @endif
                                @if(request('category'))
                                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-sm">
                                Category: {{ $categories->find(request('category'))?->name }}
                                <a href="{{ route('marketplace.index', array_merge(request()->except('category'), request()->query())) }}" class="ml-2 hover:text-purple-600 dark:hover:text-purple-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if($products->count() > 0)
                    <!-- Products Grid with Animation -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($products as $index => $product)
                            <div class="transform transition-all duration-500 hover:-translate-y-2 animate-fade-in-up"
                                 style="animation-delay: {{ $index * 0.1 }}s">
                                <x-product-card :product="$product" variant="standard" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination with Dark Mode -->
                    <div class="mt-12">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                Showing <span class="font-semibold">{{ $products->firstItem() }}</span>
                                to <span class="font-semibold">{{ $products->lastItem() }}</span>
                                of <span class="font-semibold">{{ $products->total() }}</span> products
                            </div>

                            {{ $products->appends(request()->query())->links('vendor.pagination.tailwind-custom') }}
                        </div>
                    </div>
                @else
                    <!-- Empty State with Animation -->
                    <div class="relative text-center py-20 animate-fade-in">
                        <!-- Animated background circles -->
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <div class="w-96 h-96 bg-blue-100 dark:bg-purple-900/20 rounded-full opacity-20 animate-ping"></div>
                                <div class="absolute inset-0 w-96 h-96 bg-purple-100 dark:bg-pink-900/20 rounded-full opacity-20 animate-ping animation-delay-500"></div>
                            </div>
                        </div>

                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="w-28 h-28 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center shadow-xl transform hover:scale-110 transition-transform duration-300">
                                <svg class="w-14 h-14 text-blue-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">No products found</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-lg mb-8 max-w-md mx-auto">
                                Try adjusting your search or filter to find what you're looking for.
                            </p>

                            <!-- Suggestions -->
                            <div class="max-w-lg mx-auto mb-8">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">You might like:</h4>
                                <div class="flex flex-wrap justify-center gap-2">
                                    @foreach(['Electronics', 'Fashion', 'Home & Garden', 'Sports'] as $suggestion)
                                        <a href="{{ route('marketplace.index', ['search' => $suggestion]) }}"
                                           class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-blue-100 dark:hover:bg-purple-900/30 hover:text-blue-600 dark:hover:text-purple-400 transition-all duration-300 transform hover:-translate-y-1">
                                            {{ $suggestion }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('marketplace.index') }}"
                               class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 text-white rounded-xl font-semibold overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Clear All Filters
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Featured Products Section -->
        @if($featuredProducts->count() > 0)
            <section class="py-20 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 transition-colors duration-500 relative overflow-hidden">
                <!-- Animated Background Elements -->
                <div class="absolute inset-0 overflow-hidden">
                    <!-- Gradient Orbs -->
                    <div class="absolute top-0 -left-20 w-72 h-72 bg-purple-200 dark:bg-purple-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl animate-float-slow opacity-30"></div>
                    <div class="absolute bottom-0 -right-20 w-80 h-80 bg-blue-200 dark:bg-blue-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl animate-float-slower opacity-30 animation-delay-2000"></div>

                    <!-- Floating Particles -->
                    @for ($i = 0; $i < 15; $i++)
                        <div class="absolute w-1 h-1 bg-gradient-to-r from-blue-400 to-purple-400 dark:from-purple-400 dark:to-pink-400 rounded-full animate-float-particle"
                             style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: {{ rand(3, 6) / 10 }};"></div>
                    @endfor

                    <!-- Grid Pattern -->
                    <div class="absolute inset-0 bg-grid-pattern opacity-20 dark:opacity-10"></div>
                </div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <!-- Section Header with Animation -->
                    <div class="text-center mb-16 animate-on-scroll" x-data="{ shown: false }" x-intersect="shown = true" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <!-- Animated Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-gray-800 dark:to-gray-700 rounded-full mb-4 transform hover:scale-105 transition-transform duration-300">
                            <svg class="w-5 h-5 text-blue-600 dark:text-purple-400 animate-pulse-subtle" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-purple-400 dark:to-pink-400 uppercase tracking-wider">
                        Handpicked for you
                    </span>
                        </div>

                        <!-- Main Title with Gradient -->
                        <h2 class="text-4xl md:text-5xl font-extrabold mb-4">
                    <span class="bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                        Featured Products
                    </span>
                        </h2>

                        <!-- Description with Icon -->
                        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto flex items-center justify-center gap-2">
                            <svg class="w-6 h-6 text-blue-500 dark:text-purple-400 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m0-4h4m4 4h4m4-4h4M3 19h18"/>
                            </svg>
                            Curated selections from our top sellers
                        </p>

                        <!-- Decorative Line -->
                        <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-500 dark:from-purple-400 dark:to-pink-400 mx-auto mt-6 rounded-full"></div>
                    </div>

                    <!-- Products Grid with Staggered Animation -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($featuredProducts as $index => $product)
                            <x-product-card :product="$product" variant="featured" :show-quick-view="true" :show-rating="true" :show-wishlist="false" />
                        @endforeach
                    </div>
                    <!-- View All Button -->
                    <div class="text-center mt-16 animate-on-scroll" x-data="{ shown: false }" x-intersect="shown = true" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <a href="{{ route('marketplace.index', ['featured' => true]) }}"
                           class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-500 dark:to-pink-500 text-white rounded-xl font-semibold overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            <span class="relative flex items-center gap-2">
                        <span>View All Featured Products</span>
                        <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Categories Section with Gradient Cards -->
        <section id="categories" class="py-20 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200 dark:bg-purple-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-200 dark:bg-pink-900/20 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

                <!-- Floating Particles -->
                @for ($i = 0; $i < 10; $i++)
                    <div class="absolute w-1 h-1 bg-blue-400 dark:bg-purple-400 rounded-full animate-float-particle"
                         style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                @endfor
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Section Header with Animation -->
                <div class="text-center mb-16 animate-on-scroll" x-data="{ shown: false }" x-intersect="shown = true" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                    <!-- Animated Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-gray-800 dark:to-gray-700 rounded-full mb-4 transform hover:scale-105 transition-transform duration-300">
                        <svg class="w-5 h-5 text-blue-600 dark:text-purple-400 animate-pulse-subtle" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-purple-400 dark:to-pink-400 uppercase tracking-wider">
                    Browse by
                </span>
                    </div>

                    <!-- Main Title -->
                    <h2 class="text-4xl md:text-5xl font-extrabold mb-4">
                <span class="bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                    Product Categories
                </span>
                    </h2>

                    <!-- Description -->
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-blue-500 dark:text-purple-400 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Find exactly what you're looking for
                    </p>

                    <!-- Decorative Line -->
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-500 dark:from-purple-400 dark:to-pink-400 mx-auto mt-6 rounded-full"></div>
                </div>

                <!-- Categories Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($categories as $index => $category)
                        <div x-data="{ show: false }"
                             x-intersect="show = true"
                             :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                             class="transform transition-all duration-700"
                             style="transition-delay: {{ $index * 0.1 }}s">
                            <x-category-card :category="$category" variant="standard" />
                        </div>
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
    <div id="cart-drawer" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Backdrop with blur effect - Fixed missing bg class -->
            <div class="absolute inset-0   bg-opacity-50 dark:bg-opacity-70 backdrop-blur-sm transition-opacity duration-300" onclick="toggleCart()"></div>

            <!-- Cart Panel -->
            <div id="cart-panel" class="fixed inset-y-0 right-0 pl-10 max-w-full flex transform transition-transform duration-500 ease-out">
                <div class="w-screen max-w-md h-full flex flex-col bg-white dark:bg-gray-900 shadow-2xl dark:shadow-gray-950/50">
                    <!-- Header with gradient -->
                    <div class="relative px-6 py-8 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 overflow-hidden">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 dark:opacity-20 rounded-full blur-2xl animate-pulse-slow"></div>
                        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-purple-400 dark:bg-pink-400 opacity-10 dark:opacity-20 rounded-full blur-2xl animate-pulse-slow animation-delay-1000"></div>

                        <!-- Floating particles -->
                        <div class="absolute inset-0 overflow-hidden">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="absolute w-1 h-1 bg-white/30 rounded-full animate-float-particle"
                                     style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                            @endfor
                        </div>

                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white/20 dark:bg-white/10 rounded-lg backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">Your Cart</h2>
                                    <p class="text-sm text-blue-100 dark:text-purple-200" id="cart-item-count">Loading...</p>
                                </div>
                            </div>
                            <button onclick="toggleCart()" class="p-2 hover:bg-white/20 dark:hover:bg-white/10 rounded-lg transition-all duration-200 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                                <svg class="relative w-5 h-5 text-white group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Cart Items Container with custom scrollbar -->
                    <div class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-800/50 backdrop-blur-sm transition-colors duration-300"
                         id="cart-items-container"
                         style="scrollbar-width: thin; scrollbar-color: #cbd5e0 #f7fafc;"
                         x-data="{ showEmpty: false }">

                        <!-- Loading State -->
                        <div id="cart-loading" class="flex flex-col items-center justify-center h-64">
                            <div class="relative">
                                <div class="w-16 h-16 border-4 border-gray-200 dark:border-gray-700 border-t-blue-600 dark:border-t-purple-600 rounded-full animate-spin"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                            <p class="mt-4 text-gray-600 dark:text-gray-400 animate-pulse">Loading your cart...</p>
                        </div>

                        <!-- Cart Content -->
                        <div id="cart-content" class="space-y-4" style="display: none;">
                            <!-- Cart items will be loaded here -->
                        </div>

                        <!-- Empty Cart State -->
                        <div id="cart-empty" class="flex flex-col items-center justify-center h-64 text-center" style="display: none;">
                            <div class="relative mb-6">
                                <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-blue-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-purple-500 dark:to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold animate-bounce-subtle">
                                    0
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Looks like you haven't added any items yet.</p>
                            <button onclick="toggleCart()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 dark:hover:from-purple-700 dark:hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Continue Shopping
                            </button>
                        </div>
                    </div>

                    <!-- Footer with checkout -->
                    <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-6 py-6 space-y-4 transition-colors duration-300">
                        <!-- Coupon Code Section -->
                        <div class="flex space-x-2">
                            <div class="relative flex-1 group">
                                <input type="text" placeholder="Coupon code"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                <div class="absolute inset-0 border-2 border-transparent group-hover:border-blue-500 dark:group-hover:border-purple-500 rounded-lg pointer-events-none transition-colors duration-200 opacity-0 group-hover:opacity-100"></div>
                            </div>
                            <button class="relative px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium overflow-hidden group">
                                <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-purple-500 dark:to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                <span class="relative">Apply</span>
                            </button>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span id="cart-subtotal" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Shipping</span>
                                <span class="text-green-600 dark:text-green-400 font-medium">Free</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Tax</span>
                                <span class="text-gray-500 dark:text-gray-500">Calculated at checkout</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                                <div class="flex justify-between text-base font-bold">
                                    <span class="text-gray-900 dark:text-white">Total</span>
                                    <span id="cart-total" class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-400 dark:to-pink-400">$0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('marketplace.checkout') }}"
                           class="group relative flex justify-center items-center w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 overflow-hidden">
                            <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Proceed to Checkout
                        </a>

                        <!-- Continue Shopping Link -->
                        <div class="text-center">
                            <button onclick="toggleCart()" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200 flex items-center justify-center mx-auto group">
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl border-l-4 border-green-500 overflow-hidden">
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

        // Load cart data
        async function loadCart() {
            try {
                const loading = document.getElementById('cart-loading');
                const content = document.getElementById('cart-content');
                const empty = document.getElementById('cart-empty');

                loading.style.display = 'flex';
                content.style.display = 'none';
                empty.style.display = 'none';

                fetch('{{ route("marketplace.cart") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loading.style.display = 'none';
                            if (data.cart_items && data.cart_items.length > 0) {
                                content.style.display = 'block';
                                renderCartItems(data);
                            } else {
                                empty.style.display = 'flex';
                            }
                            // Update cart display (use your existing updateCartDisplay function)
                            if (typeof updateCartDisplay === 'function') {
                                updateCartDisplay(data);
                            }
                        }
                    });
            } catch (error) {
                console.error('Error loading cart:', error);
            }
        }

        function renderCartItems(data) {
            const container = document.getElementById('cart-content');
            let html = '';

            data.cart_items.forEach(item => {
                html += `
                <div class="flex items-center space-x-4 p-4 bg-white dark:bg-gray-700/50 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group/item">
                    <div class="relative w-20 h-20 flex-shrink-0 overflow-hidden rounded-lg">
                        <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/item:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">${item.name}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${item.price}</p>
                            </div>
                            <button onclick="removeFromCart(${item.id})" class="p-1 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-full transition-colors duration-200">
                                <svg class="w-4 h-4 text-gray-400 hover:text-red-500 dark:hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center border border-gray-200 dark:border-gray-600 rounded-lg">
                                <button onclick="updateQuantity(${item.id}, 'decrease')" class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <span class="px-3 py-1 text-sm font-medium text-gray-900 dark:text-white border-x border-gray-200 dark:border-gray-600">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 'increase')" class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">$${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            `;
            });

            container.innerHTML = html;
        }

        function updateCartTotals(data) {
            document.getElementById('cart-item-count').textContent = `${data.totalItems} items`;
            document.getElementById('cart-subtotal').textContent = `$${data.subtotal.toFixed(2)}`;
            document.getElementById('cart-total').textContent = `$${data.total.toFixed(2)}`;
        }

        // Initialize cart on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadCart();

            // Close cart on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    const drawer = document.getElementById('cart-drawer');
                    if (drawer.style.display === 'block') {
                        toggleCart();
                    }
                }
            });
        });

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

        function updateCartDisplay(data) {
            const cartContent = document.getElementById('cart-content');
            const cartSubtotal = document.getElementById('cart-subtotal');
            const cartTotal = document.getElementById('cart-total');
            const cartItemCount = document.getElementById('cart-item-count');

            if (data.cart_items && data.cart_items.length > 0) {
                const totalItems = data.cart_items.reduce((sum, item) => sum + item.quantity, 0);
                cartItemCount.textContent = `${totalItems} ${totalItems === 1 ? 'item' : 'items'}`;

                let html = '<div class="flow-root"><ul class="m-2">';

                data.cart_items.forEach(item => {
                    const itemTotal = (item.quantity * parseFloat(item.price)).toFixed(2);
                    html += `
                <li class="cart-item my-4 bg-white dark:bg-gray-700/50 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group/item" data-item-id="${item.id}">
                    <div class="flex">
                        <!-- Product Image -->
                        <div class="flex-shrink-0 w-32 h-32 rounded-lg overflow-hidden shadow-sm">
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
                        <div class="ml-4 flex-1 flex flex-col p-3">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-600 transition-colors">
                                        <a href="{{ url('/marketplace/cart/add') }} /${item.product.id}">${item.product.name}</a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-100">${item.team?.name}</p>
                                </div>
                                <p class="text-base font-bold text-gray-900 dark:text-gray-50">$${itemTotal}</p>
                            </div>

                            <!-- Quantity and Remove -->
                            <div class="flex-1 flex items-end justify-between mt-2">
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm text-gray-500">Qty:</label>
                                    <div class="relative">
                                        <select onchange="updateCartItem(${item.product.id}, this.value)"
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
                                        class="text-sm text-red-600 hover:cursor-pointer hover:text-red-800 font-medium flex items-center transition-colors duration-200 group">
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
            // Show loading state
            const selectElement = event.currentTarget;
            const originalDisabled = selectElement.disabled;
            selectElement.disabled = true;
            selectElement.classList.add('opacity-50');

            // Make API call to update cart
            fetch(`{{ url('/marketplace/cart/update') }}/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: parseInt(quantity),
                    _method: 'PUT' // Laravel method spoofing
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart display with new data
                    updateCartDisplay(data);

                    // Show success notification
                    showNotification('Cart updated successfully!', 'success');

                    // Update cart count in header
                    updateCartCount();
                } else {
                    // Show error notification
                    showNotification(data.message || 'Failed to update cart', 'error');

                    // Reload cart to show correct state
                    loadCart();
                }
            })
            .catch(error => {
                console.error('Cart update error:', error);
                showNotification('An error occurred while updating cart', 'error');

                // Reload cart to show correct state
                loadCart();
            })
            .finally(() => {
                // Remove loading state
                selectElement.disabled = originalDisabled;
                selectElement.classList.remove('opacity-50');
            });
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
