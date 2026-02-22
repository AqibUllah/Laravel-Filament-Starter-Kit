@props([
    'category',
    'variant' => 'standard', // 'standard' or 'compact'
    'showProductCount' => true,
    'icon' => null // Custom SVG icon or null for default
])

@php
    $gradients = [
        'from-blue-500 to-indigo-600',
        'from-purple-500 to-pink-600',
        'from-green-500 to-teal-600',
        'from-yellow-500 to-orange-600',
        'from-red-500 to-pink-600',
        'from-indigo-500 to-purple-600',
        'from-pink-500 to-rose-600',
        'from-cyan-500 to-blue-600',
    ];

    $gradient = $gradients[$category->id % count($gradients)] ?? $gradients[0];
    $darkGradient = str_replace(['blue', 'indigo', 'purple', 'pink', 'green', 'teal', 'yellow', 'orange', 'red', 'rose', 'cyan'],
                                 ['purple', 'pink', 'violet', 'fuchsia', 'emerald', 'cyan', 'amber', 'red', 'rose', 'pink', 'blue'],
                                 $gradient);

    $defaultIcon = '<svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012-2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
    </svg>';

    $icon = $icon ?: $defaultIcon;
@endphp

<a href="{{ route('marketplace.index', ['category' => $category->id]) }}"
   class="group relative {{ $variant === 'compact' ? 'p-6' : 'p-8' }} rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden block bg-white dark:bg-gray-800/90 backdrop-blur-sm border border-gray-200 dark:border-gray-700 hover:border-transparent">

    <!-- Animated Gradient Border -->
    <div class="absolute -inset-0.5 bg-gradient-to-r {{ $gradient }} dark:{{ $darkGradient }} rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur"></div>

    <!-- Card Content -->
    <div class="relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-0 group-hover:opacity-10 dark:group-hover:opacity-20 transition-opacity duration-500">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-r {{ $gradient }} rounded-full"></div>
            <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-gradient-to-r {{ $gradient }} rounded-full"></div>
        </div>

        <div class="relative text-center">
            <!-- Icon Container with Enhanced Animation -->
            <div class="relative w-{{ $variant === 'compact' ? '16' : '20' }} h-{{ $variant === 'compact' ? '16' : '20' }} mx-auto mb-4">
                <!-- Pulsing Ring -->
                <div class="absolute inset-0 bg-gradient-to-r {{ $gradient }} dark:{{ $darkGradient }} rounded-{{ $variant === 'compact' ? 'xl' : '2xl' }} opacity-20 group-hover:opacity-30 animate-ping"></div>

                <!-- Main Icon Background -->
                <div class="relative w-full h-full bg-gradient-to-r {{ $gradient }} dark:{{ $darkGradient }} rounded-{{ $variant === 'compact' ? 'xl' : '2xl' }} flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300 shadow-lg group-hover:shadow-xl">
                    {!! $icon !!}
                </div>
            </div>

            <!-- Category Name -->
            <h3 class="text-{{ $variant === 'compact' ? 'lg' : 'xl' }} font-bold text-gray-900 dark:text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r {{ $gradient }} dark:{{ $darkGradient }} transition-all duration-300">
                {{ $category->name }}
            </h3>

            <!-- Product Count with Icon -->
            @if($showProductCount)
                <div class="flex items-center justify-center gap-1.5 text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-300 transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $category->public_products_count }} Products</span>
                </div>
            @endif

            <!-- Hover Indicator with Gradient -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r {{ $gradient }} dark:{{ $darkGradient }} transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-b-full"></div>
        </div>
    </div>
</a>

@push('styles')
    <style>
        /* Animation Keyframes */
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .animate-blob {
            animation: blob 7s infinite;
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

        /* Animation Delays */
        .animation-delay-2000 {
            animation-delay: 2s;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
@endpush
