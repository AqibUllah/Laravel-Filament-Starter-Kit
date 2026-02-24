<x-filament-panels::page.simple>
    <div class="space-y-6">
        <!-- Welcome Message -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-purple-500 dark:to-pink-600 rounded-2xl mb-4 transform hover:rotate-12 transition-transform duration-500">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white dark:text-white mb-2">Create Your Company</h3>
            <p class="text-white/70 dark:text-white/60 text-sm">Fill in the details below to get started</p>
        </div>

        <!-- Form -->
        <form wire:submit="register" class="space-y-6">
            {{ $this->form }}

            <!-- Animated Button -->
            <div class="relative group mt-10">
                <!-- Animated gradient border -->
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-purple-500 dark:to-pink-600 rounded-lg blur opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>

                <x-filament::button
                    type="submit"
                    color="primary"
                    class="w-full relative overflow-hidden"
                    size="lg"
                    icon="heroicon-m-sparkles"
                >
                    <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                    <span class="relative flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Company
                    </span>
                </x-filament::button>
            </div>

            <!-- Terms and Conditions -->
            <div class="text-center">
                <p class="text-xs text-white/60 dark:text-white/50">
                    By creating a company, you agree to our
                    <a href="#" class="text-white dark:text-purple-300 hover:underline font-medium">Terms of Service</a>
                    and
                    <a href="#" class="text-white dark:text-purple-300 hover:underline font-medium">Privacy Policy</a>
                </p>
            </div>
        </form>

        <!-- Help Section -->
        <div class="mt-6 pt-6 border-t border-white/20 dark:border-purple-500/20">
            <div class="flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4 text-white/50 dark:text-purple-400/50 animate-pulse-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-white/60 dark:text-white/50">Need help? <a href="#" class="text-white dark:text-purple-300 hover:underline">Contact support</a></span>
            </div>
        </div>
    </div>

    <!-- Loading State Animation (Optional) -->
    <style>
        /* Form field animations */
        .fi-field {
            @apply transition-all duration-300;
        }

        .fi-field:focus-within {
            @apply transform scale-[1.02];
        }

        /* Input field styling for dark mode */
        .dark .fi-input {
            @apply bg-gray-800/50 border-gray-700 text-white focus:border-purple-500 focus:ring-purple-500;
        }

        .dark .fi-label {
            @apply text-gray-300;
        }

        /* Button loading state */
        button[type="submit"].loading {
            @apply opacity-75 cursor-not-allowed;
        }

        button[type="submit"].loading svg {
            @apply animate-spin;
        }
    </style>

    @script
    <script>
        // Add loading state to button on form submit
        document.addEventListener('livewire:init', () => {
            Livewire.on('form-submitting', () => {
                const button = document.querySelector('button[type="submit"]');
                if (button) {
                    button.classList.add('loading');
                    const originalContent = button.innerHTML;
                    button.innerHTML = `
                        <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full"></span>
                        <span class="relative flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating...
                        </span>
                    `;
                }
            });

            Livewire.on('form-submitted', () => {
                const button = document.querySelector('button[type="submit"]');
                if (button) {
                    button.classList.remove('loading');
                }
            });
        });
    </script>
    @endscript
</x-filament-panels::page.simple>
