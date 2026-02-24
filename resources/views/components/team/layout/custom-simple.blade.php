<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="antialiased min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 dark:from-gray-900 dark:via-purple-900 dark:to-indigo-900 animated-gradient relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating Gradient Orbs -->
            <div class="absolute top-0 -left-20 w-72 h-72 bg-white/20 dark:bg-purple-400/20 rounded-full mix-blend-overlay filter blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-0 -right-20 w-96 h-96 bg-white/20 dark:bg-pink-400/20 rounded-full mix-blend-overlay filter blur-3xl animate-float-slower animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/20 dark:bg-blue-400/20 rounded-full mix-blend-overlay filter blur-3xl animate-float animation-delay-4000"></div>

            <!-- Floating Particles -->
            @for ($i = 0; $i < 50; $i++)
                <div class="absolute w-1 h-1 bg-white/30 dark:bg-purple-400/30 rounded-full animate-float-particle"
                     style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
            @endfor

            <!-- Animated Grid Pattern -->
            <div class="absolute inset-0 bg-grid-pattern opacity-20 dark:opacity-30"></div>

            <!-- Animated Lines -->
            <div class="absolute inset-0">
                @for ($i = 0; $i < 5; $i++)
                    <div class="absolute h-px w-full bg-gradient-to-r from-transparent via-white/30 dark:via-purple-400/30 to-transparent animate-slide"
                         style="top: {{ 10 + $i * 20 }}%; animation-delay: {{ $i * 0.5 }}s;"></div>
                @endfor
            </div>

            <!-- Rotating Rings -->
            <div class="absolute -top-1/2 -right-1/2 w-[800px] h-[800px] border-2 border-white/10 dark:border-purple-500/10 rounded-full animate-spin-slow"></div>
            <div class="absolute -bottom-1/2 -left-1/2 w-[600px] h-[600px] border-2 border-white/10 dark:border-pink-500/10 rounded-full animate-spin-slower animation-delay-1000"></div>
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 dark:from-black/40 via-transparent to-transparent"></div>

        <!-- Main Content -->
        <div class="min-h-screen flex flex-col items-center justify-center p-4 relative z-10">
            <!-- Brand Section with Enhanced Animations -->
            <div class="mb-8 text-center animate-fade-in-down">
                @if(isset($brandLogo))
                    <div class="logo-container mb-4 transform hover:scale-110 transition-transform duration-500">
                        <div class="relative">
                            <!-- Pulsing Ring -->
                            <div class="absolute inset-0 bg-white/30 dark:bg-purple-400/30 rounded-full animate-ping opacity-25"></div>
                            <div class="absolute inset-0 bg-white/20 dark:bg-pink-400/20 rounded-full animate-ping opacity-25 animation-delay-500"></div>
                            <div class="relative">
                                {{ $brandLogo }}
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($brandName))
                    <h1 class="brand-text text-4xl md:text-5xl font-bold text-white mb-2 animate-gradient-x">
                        {{ $brandName }}
                    </h1>
                @endif

                @if(isset($brandDescription))
                    <p class="brand-subtitle text-white/80 dark:text-white/70 text-lg md:text-xl animate-fade-in animation-delay-500">
                        {{ $brandDescription }}
                    </p>
                @endif

                <!-- Animated Separator -->
                <div class="flex items-center justify-center gap-2 mt-4 animate-fade-in animation-delay-700">
                    <div class="w-12 h-0.5 bg-white/30 dark:bg-purple-400/30 rounded-full"></div>
                    <svg class="w-4 h-4 text-white/50 dark:text-purple-400/50 animate-pulse-subtle" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                    </svg>
                    <div class="w-12 h-0.5 bg-white/30 dark:bg-purple-400/30 rounded-full"></div>
                </div>
            </div>

            <!-- Content Section with Glass Effect -->
            <div class="login-card w-full max-w-md rounded-2xl p-8 backdrop-blur-xl bg-white/20 dark:bg-gray-800/40 shadow-2xl dark:shadow-purple-900/30 border border-white/30 dark:border-purple-500/30 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-3xl dark:hover:shadow-purple-900/50 animate-scale-in">
                <!-- Card Header -->
                <div class="text-center mb-6">
                    @if($heading)
                        <h2 class="text-2xl font-bold text-white dark:text-white mb-2">{{ $heading }}</h2>
                    @endif
                    @if($subheading)
                        <p class="text-white/80 dark:text-white/70">{{ $subheading }}</p>
                    @endif
                </div>

                <!-- Card Content -->
                {{ $slot }}

                <!-- After Slot Content -->
                @if($after)
                    <div class="mt-6">
                        {{ $after }}
                    </div>
                @endif

                <!-- Decorative Elements -->
                <div class="absolute -top-10 -right-10 w-20 h-20 bg-white/10 dark:bg-purple-400/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-20 h-20 bg-white/10 dark:bg-pink-400/10 rounded-full blur-2xl"></div>
            </div>

            <!-- Footer with Animation -->
            <div class="mt-8 text-center animate-fade-in-up animation-delay-1000">
                <p class="text-white/60 dark:text-white/50 text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 animate-pulse-subtle" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    &copy; {{ date('Y') }} {{ config('app.name', 'Your Application') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</x-filament-panels::layout.base>

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

        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(0.95); }
        }

        .animate-pulse-subtle {
            animation: pulse-subtle 2s ease-in-out infinite;
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

        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }

        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-scale-in {
            animation: scale-in 0.6s ease-out forwards;
        }

        /* Animation Delays */
        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        .animation-delay-700 {
            animation-delay: 0.7s;
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
                linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .dark .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(168, 85, 247, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(168, 85, 247, 0.1) 1px, transparent 1px);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }

        /* Custom scrollbar for the page */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .dark ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        .dark ::-webkit-scrollbar-thumb {
            background: rgba(168, 85, 247, 0.3);
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(168, 85, 247, 0.5);
        }
    </style>
@endpush
