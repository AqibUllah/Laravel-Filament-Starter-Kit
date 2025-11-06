
<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])
    <div class="antialiased min-h-screen bg-gray-50 dark:bg-gray-900 animated-gradient">
        <!-- Floating Shapes -->
        <div class="floating-shape w-20 h-20 top-10 left-10"></div>
        <div class="floating-shape w-16 h-16 top-32 right-20"></div>
        <div class="floating-shape w-24 h-24 bottom-20 left-32"></div>
        <div class="floating-shape w-12 h-12 bottom-32 right-16"></div>

        <div class="min-h-screen flex flex-col items-center justify-center p-4 relative z-10">
            <!-- Brand Section -->
            <div class="mb-8 text-center">
                @if(isset($brandLogo))
                    <div class="logo-container mb-4">
                        {{ $brandLogo }}
                    </div>
                @endif

                @if(isset($brandName))
                    <h1 class="brand-text text-4xl md:text-5xl font-bold text-white mb-2">
                        {{ $brandName }}
                    </h1>
                @endif

                @if(isset($brandDescription))
                    <p class="brand-subtitle text-white/80 text-lg md:text-xl">
                        {{ $brandDescription }}
                    </p>
                @endif
            </div>

            <!-- Content Section -->
            <div class="login-card w-full max-w-md rounded-2xl p-8">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-white/60 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Your Application') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</x-filament-panels::layout.base>
