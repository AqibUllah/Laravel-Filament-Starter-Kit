<x-filament-panels::layout.base>
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
        @if (($hasTopbar ?? true) && filament()->auth()->check())
            <div class="absolute end-0 top-0 flex h-16 items-center gap-x-4 pe-4 md:pe-6 lg:pe-8 z-10">
                @if (filament()->hasDatabaseNotifications())
                    @livewire(Filament\Livewire\DatabaseNotifications::class, [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications()
                    ])
                @endif
            </div>
        @endif

        <!-- Left Side - Visual Section -->
{{--            <img--}}
{{--                class="absolute inset-0 size-full object-cover transform scale-105"--}}
{{--                src="{{ asset('images/team.jpg') }}"--}}
{{--                alt="Team collaboration"--}}
{{--            >--}}

        <!-- Right Side - Content Section -->
        <div class="flex flex-1 flex-col justify-center px-4 py-8 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-full">
            <div class="w-full mx-auto lg:mx-0">
                <!-- Logo/Brand -->
                <div class="flex justify-center lg:justify-start mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">YourBrand</span>
                    </div>
                </div>

                <!-- Main Content -->
                <main class="w-1/2 rounded-2xl mx-auto">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </div>
</x-filament-panels::layout.base>
