<x-filament-panels::page>
    <x-filament::section class="text-center">
        <div class="flex justify-center mb-4">
            <x-heroicon-o-check-badge class="h-16 w-16 text-success-500" />
        </div>

        <h2 class="text-2xl font-bold mb-4">Thank You for Your Subscription!</h2>

        <p class="text-gray-600 mb-6">
            Your subscription has been activated successfully. You now have access to all the features of your chosen plan.
        </p>

        <x-filament::button
            tag="a"
            href="{{ filament()->getUrl() }}"
            color="primary"
            size="lg">
            Go to Dashboard
        </x-filament::button>
    </x-filament::section>
</x-filament-panels::page>
