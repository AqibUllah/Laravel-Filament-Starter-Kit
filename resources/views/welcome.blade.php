@extends('layouts.app')
@section('title','Home')
@section('content')

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

    <!-- Tenant & Admin Panels Section -->
    <section id="panels" class="section-padding bg-gray-50 dark:bg-gray-900/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Built for Every Team Member</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    A tailored experience for tenants managing their workspaces and administrators running the platform.
                </p>
            </div>
            <div class="grid gap-10 lg:grid-cols-2">
                <article class="bg-white dark:bg-gray-900 shadow-xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800 transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="relative h-60 overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80"
                            alt="Tenant dashboard preview"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 px-3 py-1 bg-white/90 dark:bg-gray-900/90 text-purple-600 dark:text-purple-300 text-xs font-semibold rounded-full uppercase tracking-wide">
                            Tenant Portal
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <h3 class="text-2xl font-semibold mb-2">Tenant Workspace</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Empower teams with a focused workspace. Manage projects, collaborate with members, and keep every task on track with intuitive tools built around productivity.
                            </p>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/40 dark:text-purple-300">✓</span>
                                Seamless team switching and isolated data per tenant
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/40 dark:text-purple-300">✓</span>
                                Task, project, and member management in one place
                            </li>
                        </ul>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a
                                href="{{ Route::has('filament.tenant.auth.login') ? route('filament.tenant.auth.login') : (Route::has('login') ? route('login') : '#') }}"
                                class="flex-1 text-center px-6 py-3 rounded-lg font-semibold bg-purple-600 text-white hover:bg-purple-700 transition"
                            >
                                Access Tenant Portal
                            </a>
                            <a href="#features" class="flex-1 text-center px-6 py-3 rounded-lg font-semibold border border-purple-200 text-purple-600 hover:bg-purple-50 dark:border-purple-800 dark:text-purple-300 dark:hover:bg-purple-900/30 transition">
                                Explore Features
                            </a>
                        </div>
                    </div>
                </article>

                <article class="bg-white dark:bg-gray-900 shadow-xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800 transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="relative h-60 overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1600&q=80"
                            alt="Admin panel preview"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 px-3 py-1 bg-white/90 dark:bg-gray-900/90 text-indigo-600 dark:text-indigo-300 text-xs font-semibold rounded-full uppercase tracking-wide">
                            Admin Panel
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <h3 class="text-2xl font-semibold mb-2">Administrator Control Center</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Oversee the entire platform with advanced insights. Configure plans, manage tenants, and monitor usage with streamlined administrative workflows.
                            </p>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-300">✓</span>
                                Real-time analytics across tenants and subscriptions
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-300">✓</span>
                                Centralized billing, roles, and security management
                            </li>
                        </ul>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a
                                href="{{ Route::has('filament.admin.auth.login') ? route('filament.admin.auth.login') : (Route::has('login') ? route('login') : '#') }}"
                                class="flex-1 text-center px-6 py-3 rounded-lg font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition"
                            >
                                Go to Admin Panel
                            </a>
                            <a href="#pricing" class="flex-1 text-center px-6 py-3 rounded-lg font-semibold border border-indigo-200 text-indigo-600 hover:bg-indigo-50 dark:border-indigo-800 dark:text-indigo-300 dark:hover:bg-indigo-900/30 transition">
                                View Plans
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
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
            <div class="grid md:grid-cols-3 gap-8 items-stretch">
                @foreach($plans as $plan)
                <!-- Pro Plan -->
                <div class="relative group h-full">
                    <div class="pointer-events-none absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-70 transition-opacity duration-500 blur-3xl {{ $plan->is_featured ? 'bg-gradient-to-br from-purple-500/30 via-fuchsia-400/25 to-purple-600/20' : 'bg-gradient-to-br from-gray-400/20 via-purple-300/20 to-gray-200/10 dark:from-purple-900/20 dark:via-indigo-800/20 dark:to-purple-900/10' }}"></div>
                    <div class="relative flex h-full flex-col bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-[0_40px_120px_-40px_rgba(79,70,229,0.35)] dark:shadow-[0_40px_120px_-50px_rgba(79,70,229,0.45)] border border-gray-100 dark:border-gray-800 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_45px_140px_-40px_rgba(99,102,241,0.45)] dark:hover:shadow-[0_45px_140px_-45px_rgba(129,140,248,0.55)] hover:border-purple-200 dark:hover:border-purple-500 {{  $plan->is_featured ? 'border-2 border-purple-500 shadow-[0_45px_140px_-35px_rgba(124,58,237,0.55)] scale-105 hover:border-purple-400 dark:hover:border-purple-400' : '' }}">
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
                        <ul class="space-y-3 mb-8 flex-1">
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
                        <a href="{{ Route::has('filament.tenant.auth.register') ? route('filament.tenant.auth.register') : '#' }}" class="block w-full text-center dark:text-gray-800 px-6 py-3 rounded-lg font-semibold transition duration-300 {{ $plan->is_featured ? 'bg-purple-600 text-white dark:hover:text-gray-200 group-hover:bg-purple-700' : 'bg-gray-200 text-gray-700 group-hover:bg-purple-100 group-hover:text-purple-600' }}">
                            Get Started
                        </a>
                    </div>
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

@endsection


