<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel Filament Starter Kit') }} - Multi-Tenant SaaS Platform</title>
    <meta name="description" content="A powerful multi-tenant SaaS starter kit built with Laravel and Filament. Manage teams, tasks, projects, and subscriptions with ease.">

        <script>
        // Apply saved/system theme ASAP to avoid flash and ensure dark variants are active
        (function() {
            try {
                var stored = localStorage.getItem('theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var isDark = stored ? stored === 'dark' : prefersDark;
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

            <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-bg-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .gradient-bg-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .section-padding {
            padding: 5rem 0;
        }

        @media (max-width: 768px) {
            .section-padding {
                padding: 3rem 0;
            }
        }
            </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        {{ config('app.name', 'SaaS Kit') }}
                    </span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">Features</a>
                    <a href="#pricing" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">Pricing</a>
                    <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">About</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-purple-600 text-white dark:text-gray-800 rounded-lg hover:bg-purple-700 transition">
                                    Get Started
                                </a>
                            @endif
                        @endauth
        @endif
                    <button id="theme-toggle" aria-label="Toggle theme" class="p-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg id="icon-moon-desktop" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"></path>
                        </svg>
                        <svg id="icon-sun-desktop" class="w-5 h-5 text-gray-700 dark:text-gray-300 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05L5.636 5.636m12.728 0l-1.414 1.414M7.05 16.95l-1.414 1.414M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                </div>
                <div class="md:hidden flex items-center gap-3">
                    <button id="theme-toggle-mobile" aria-label="Toggle theme" class="p-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg id="icon-moon-mobile" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"></path>
                        </svg>
                        <svg id="icon-sun-mobile" class="w-5 h-5 text-gray-700 dark:text-gray-300 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05L5.636 5.636m12.728 0l-1.414 1.414M7.05 16.95l-1.414 1.414M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                    <button id="mobile-menu-btn" class="text-gray-700 dark:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="px-4 py-4 space-y-4">
                <a href="#features" class="block text-gray-700 dark:text-gray-300">Features</a>
                <a href="#pricing" class="block text-gray-700 dark:text-gray-300">Pricing</a>
                <a href="#about" class="block text-gray-700 dark:text-gray-300">About</a>
            @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-4 py-2 bg-purple-600 text-white rounded-lg text-center">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block text-gray-700 dark:text-gray-300">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-4 py-2 bg-purple-600 text-white dark:text-gray-800 rounded-lg text-center">
                                Get Started
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
                </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-12 md:pt-32 md:pb-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center animate-fade-in-up">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Powerful Multi-Tenant SaaS
                    <span class="block mt-2">Starter Kit</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                    Built with Laravel & Filament. Manage teams, tasks, projects, and subscriptions with ease.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                            Start Free Trial
                        </a>
            @endif
                    <a href="#features" class="px-8 py-4 bg-white/20 text-white rounded-lg font-semibold hover:bg-white/30 transition backdrop-blur-sm border border-white/30">
                        Explore Features
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white dark:from-gray-900 to-transparent"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Everything You Need to Build Your SaaS</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    A comprehensive starter kit with all the essential features for your multi-tenant application
                </p>
            </div>

            <!-- Teams Section -->
            <div class="mb-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="animate-fade-in-up">
                        <div class="inline-block px-4 py-2 bg-purple-100 dark:bg-purple-900/30 rounded-full text-purple-600 dark:text-purple-400 text-sm font-semibold mb-4">
                            Multi-Tenant Architecture
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Team Management</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">
                            Create and manage multiple teams with isolated workspaces. Each team has its own projects, tasks, and members. Switch between teams seamlessly with our intuitive team switcher.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Isolated team workspaces</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Easy team switching</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Team-specific domains</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Team branding & logos</span>
                            </li>
                        </ul>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl p-8 shadow-2xl transform rotate-3 hover:rotate-0 transition-transform">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg">Design Team</h4>
                                        <p class="text-sm text-gray-500">5 members</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                        <span class="text-sm">Active Projects</span>
                                        <span class="font-semibold">12</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                        <span class="text-sm">Tasks</span>
                                        <span class="font-semibold">48</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Members Section -->
            <div class="mb-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="order-2 md:order-1 relative">
                        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl p-8 shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                <h4 class="font-semibold text-lg mb-4">Team Members</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-blue-600 dark:text-blue-400 font-semibold">JD</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium">John Doe</p>
                                            <p class="text-sm text-gray-500">Admin</p>
                                        </div>
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 text-xs rounded-full">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-pink-600 dark:text-pink-400 font-semibold">JS</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium">Jane Smith</p>
                                            <p class="text-sm text-gray-500">Member</p>
                                        </div>
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 text-xs rounded-full">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-purple-600 dark:text-purple-400 font-semibold">MJ</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium">Mike Johnson</p>
                                            <p class="text-sm text-gray-500">Member</p>
                                        </div>
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-full">Away</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 md:order-2 animate-fade-in-up">
                        <div class="inline-block px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-full text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                            User Management
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Members & Permissions</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">
                            Invite team members, assign roles, and manage permissions with fine-grained access control. Built-in support for Spatie Laravel Permission with team-aware roles.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Role-based access control</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Team invitation system</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Custom permission management</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>User activity tracking</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="mb-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="animate-fade-in-up">
                        <div class="inline-block px-4 py-2 bg-green-100 dark:bg-green-900/30 rounded-full text-green-600 dark:text-green-400 text-sm font-semibold mb-4">
                            Task Management
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Powerful Task Tracking</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">
                            Organize your work with comprehensive task management. Assign tasks, set priorities, track progress, and manage deadlines all in one place.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Priority levels (High, Medium, Low)</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Status tracking (Pending, In Progress, Completed)</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Time tracking (estimated & actual hours)</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Task assignment notifications</span>
                            </li>
                        </ul>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl p-8 shadow-2xl transform rotate-3 hover:rotate-0 transition-transform">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                <h4 class="font-semibold text-lg mb-4">Tasks</h4>
                                <div class="space-y-3">
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4 border-green-500">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium">Design Landing Page</span>
                                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 text-xs rounded">High</span>
                                        </div>
                                        <p class="text-sm text-gray-500">Due: Dec 15, 2024</p>
                                        <div class="mt-2 flex items-center">
                                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                                            </div>
                                            <span class="ml-2 text-xs text-gray-500">75%</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4 border-blue-500">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium">API Integration</span>
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 text-xs rounded">Medium</span>
                                        </div>
                                        <p class="text-sm text-gray-500">Due: Dec 20, 2024</p>
                                        <div class="mt-2 flex items-center">
                                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                <div class="bg-blue-500 h-2 rounded-full" style="width: 45%"></div>
                                            </div>
                                            <span class="ml-2 text-xs text-gray-500">45%</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4 border-purple-500">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium">Code Review</span>
                                            <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 text-xs rounded">Low</span>
                                        </div>
                                        <p class="text-sm text-gray-500">Due: Dec 18, 2024</p>
                                        <div class="mt-2 flex items-center">
                                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                <div class="bg-purple-500 h-2 rounded-full" style="width: 90%"></div>
                                            </div>
                                            <span class="ml-2 text-xs text-gray-500">90%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Section -->
            <div class="mb-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="order-2 md:order-1 relative">
                        <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-8 shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                <h4 class="font-semibold text-lg mb-4">Active Projects</h4>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium">Website Redesign</span>
                                            <span class="text-sm text-gray-500">75%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-orange-500 h-2 rounded-full" style="width: 75%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Due: Jan 15, 2025</p>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium">Mobile App</span>
                                            <span class="text-sm text-gray-500">45%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-orange-500 h-2 rounded-full" style="width: 45%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Due: Feb 20, 2025</p>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium">E-commerce Platform</span>
                                            <span class="text-sm text-gray-500">90%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-orange-500 h-2 rounded-full" style="width: 90%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Due: Dec 30, 2024</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 md:order-2 animate-fade-in-up">
                        <div class="inline-block px-4 py-2 bg-orange-100 dark:bg-orange-900/30 rounded-full text-orange-600 dark:text-orange-400 text-sm font-semibold mb-4">
                            Project Management
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Complete Project Control</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">
                            Manage complex projects with ease. Track progress, budgets, timelines, and team assignments. Get comprehensive insights into project performance.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Project status tracking</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Budget & time tracking</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Client information management</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Progress visualization</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Dashboards Section -->
            <div class="mb-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="animate-fade-in-up">
                        <div class="inline-block px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-full text-indigo-600 dark:text-indigo-400 text-sm font-semibold mb-4">
                            Analytics & Insights
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Comprehensive Dashboards</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">
                            Get real-time insights into your projects, tasks, and team performance with beautiful, interactive dashboards. Track metrics, analyze trends, and make data-driven decisions.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Project dashboard with charts</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Task analytics & statistics</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Plan usage tracking</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Real-time metrics & widgets</span>
                            </li>
                        </ul>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl p-8 shadow-2xl transform rotate-3 hover:rotate-0 transition-transform">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                <h4 class="font-semibold text-lg mb-4">Dashboard Overview</h4>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-lg">
                                        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">24</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Projects</p>
                                    </div>
                                    <div class="bg-purple-50 dark:bg-purple-900/30 p-4 rounded-lg">
                                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">156</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Tasks</p>
                                    </div>
                                    <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg">
                                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">12</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Members</p>
                                    </div>
                                    <div class="bg-orange-50 dark:bg-orange-900/30 p-4 rounded-lg">
                                        <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">68%</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Complete</p>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm font-medium mb-2">Progress Chart</p>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <span class="text-xs w-20">This Week</span>
                                            <div class="flex-1 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                <div class="bg-indigo-500 h-2 rounded-full" style="width: 75%"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-xs w-20">This Month</span>
                                            <div class="flex-1 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                <div class="bg-purple-500 h-2 rounded-full" style="width: 60%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plans Section -->
            <div class="mb-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="order-2 md:order-1 relative">
                        <div class="bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl p-8 shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                <h4 class="font-semibold text-lg mb-4">Subscription Plans</h4>
                                <div class="space-y-4">
                                    <div class="border-2 border-pink-500 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-lg">Pro Plan</span>
                                            <span class="px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-400 text-xs rounded-full">Active</span>
                                        </div>
                                        <p class="text-2xl font-bold mb-1">$49<span class="text-sm text-gray-500">/mo</span></p>
                                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1 mt-3">
                                            <li>✓ Unlimited projects</li>
                                            <li>✓ 50 team members</li>
                                            <li>✓ Advanced analytics</li>
                                            <li>✓ Priority support</li>
                                        </ul>
                                    </div>
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-semibold">Basic Plan</span>
                                            <span class="text-xs text-gray-500">Available</span>
                                        </div>
                                        <p class="text-xl font-bold mb-1">$19<span class="text-sm text-gray-500">/mo</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 md:order-2 animate-fade-in-up">
                        <div class="inline-block px-4 py-2 bg-pink-100 dark:bg-pink-900/30 rounded-full text-pink-600 dark:text-pink-400 text-sm font-semibold mb-4">
                            Subscription Management
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Flexible Plans & Subscriptions</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">
                            Integrated billing system with Stripe support. Create custom plans, manage subscriptions, track usage, and handle feature limits. Perfect for SaaS applications.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Stripe payment integration</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Customizable pricing plans</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Feature-based limits</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Trial periods & coupons</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    @if(isset($plans))
        <section id="pricing" class="section-padding bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Simple, Transparent Pricing</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Choose the plan that fits your needs. All plans include a free trial.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($plans as $plan)
                <!-- Pro Plan -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-xl {{  $plan->is_featured ? 'border-purple-500 relative transform scale-105 border-2' : '' }}">
                    @if($plan->is_featured)
                        <div class="absolute top-0 right-0 bg-purple-500 text-white px-4 py-1 rounded-bl-lg rounded-tr-2xl text-sm font-semibold">
                            Most Popular
                        </div>
                    @endif
                    <h3 class="text-2xl font-bold mb-2">{{ $plan->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $plan->description }}</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold">${{ $plan->price }}</span>
                        <span class="text-gray-600 dark:text-gray-400">/{{ $plan->interval }}</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        @foreach(json_decode($plan->features) as $feature)
                            <li class="flex items-center">
                                <span class="text-sm flex justify-between w-full">

                                <span>{{ $feature->name }}</span>
                                @if(is_bool($feature->value))
                                    @if (is_bool($feature->value) && $feature->value)
                                        <x-heroicon-o-check-circle class="h-5 w-5 text-success-500" />
                                    @else
                                        <x-heroicon-o-x-circle class="h-5 w-5 text-danger-500" />
                                    @endif
                                @else
                                    {{ $feature->value }}
                                @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ Route::has('filament.tenant.auth.register') ? route('filament.tenant.auth.register') : '#' }}" class="block w-full text-center dark:text-gray-800 px-6 py-3 {{ $plan->is_featured ? 'bg-purple-600 text-white rounded-lg hover:bg-purple-700' : 'bg-gray-200' }} transition">
                        Get Started
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    @endif
    <!-- CTA Section -->
    <section class="section-padding gradient-bg-2 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Ready to Build Your SaaS?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                Start your free trial today. No credit card required.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-pink-600 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                        Start Free Trial
                    </a>
        @endif
                <a href="#features" class="px-8 py-4 bg-white/20 text-white rounded-lg font-semibold hover:bg-white/30 transition backdrop-blur-sm border border-white/30">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="about" class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">{{ config('app.name', 'SaaS Kit') }}</h3>
                    <p class="text-gray-400">
                        A powerful multi-tenant SaaS starter kit built with Laravel and Filament.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'SaaS Kit') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Theme handling
        (function() {
            function applyTheme(theme) {
                const root = document.documentElement;
                if (theme === 'dark') {
                    root.classList.add('dark');
                } else {
                    root.classList.remove('dark');
                }
                localStorage.setItem('theme', theme);
                updateThemeIcons(theme);
            }

            function getPreferredTheme() {
                const stored = localStorage.getItem('theme');
                if (stored === 'light' || stored === 'dark') return stored;
                return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            function updateThemeIcons(theme) {
                const isDark = theme === 'dark';
                const desktopSun = document.getElementById('icon-sun-desktop');
                const desktopMoon = document.getElementById('icon-moon-desktop');
                const mobileSun = document.getElementById('icon-sun-mobile');
                const mobileMoon = document.getElementById('icon-moon-mobile');
                if (desktopSun && desktopMoon) {
                    desktopSun.classList.toggle('hidden', !isDark);
                    desktopMoon.classList.toggle('hidden', isDark);
                }
                if (mobileSun && mobileMoon) {
                    mobileSun.classList.toggle('hidden', !isDark);
                    mobileMoon.classList.toggle('hidden', isDark);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize theme
                const initial = getPreferredTheme();
                applyTheme(initial);

                // Toggle handlers
                document.getElementById('theme-toggle')?.addEventListener('click', function() {
                    const current = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                    applyTheme(current === 'dark' ? 'light' : 'dark');
                });
                document.getElementById('theme-toggle-mobile')?.addEventListener('click', function() {
                    const current = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                    applyTheme(current === 'dark' ? 'light' : 'dark');
                });
            });
        })();

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    document.getElementById('mobile-menu')?.classList.add('hidden');
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });
    </script>
    </body>
</html>
