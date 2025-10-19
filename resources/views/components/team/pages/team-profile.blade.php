<x-filament-panels::page style="margin-bottom: 500px">
    <form wire:submit="save">
        {{ $this->form }}
        <x-filament::button
            type="submit"
            color="info"
            class="mt-10"
            icon="heroicon-m-sparkles">
            Save
        </x-filament::button>
    </form>
</x-filament-panels::page>
<script>
    document.addEventListener('livewire:init', function () {
        // Livewire.on('companyProfileUpdated', function () {
        //     window.location.reload();
        // });
    });
</script>
