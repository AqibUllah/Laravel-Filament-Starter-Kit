<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel Filament Starter Kit') }} - Multi-Tenant SaaS Platform | @yield('title')</title>
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

        @stack('styles')
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        {{ config('app.name', 'SaaS Kit') }}
                    </a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}#features" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">Features</a>
                <a href="{{ route('home') }}#pricing" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">Pricing</a>
                <a href="{{ route('home') }}#about" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">About</a>
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
            <a href="{{ route('home') }}#features" class="block text-gray-700 dark:text-gray-300">Features</a>
            <a href="{{ route('home') }}#pricing" class="block text-gray-700 dark:text-gray-300">Pricing</a>
            <a href="{{ route('home') }}#about" class="block text-gray-700 dark:text-gray-300">About</a>
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


<!-- Main Content -->
        <main>
            @yield('content')
        </main>

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
                            <li><a href="{{ route('home') }}#features" class="hover:text-white transition">Features</a></li>
                            <li><a href="{{ route('home') }}#pricing" class="hover:text-white transition">Pricing</a></li>
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
                        const isDark = document.documentElement.classList.contains('dark');
                        applyTheme(isDark ? 'light' : 'dark');
                    });
                    document.getElementById('theme-toggle-mobile')?.addEventListener('click', function() {
                        const isDark = document.documentElement.classList.contains('dark');
                        applyTheme(isDark ? 'light' : 'dark');
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

        @stack('scripts')
    </body>
</html>
