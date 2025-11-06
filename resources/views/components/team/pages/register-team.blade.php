<x-filament-panels::page.simple>
    <form wire:submit="register">
        {{ $this->form }}
            <x-filament::button
                type="submit"
                color="primary"
                class="w-full mt-10"
                size="lg"
                icon="heroicon-m-sparkles"
                >
                Create Company
            </x-filament::button>
    </form>
</x-filament-panels::page.simple>
