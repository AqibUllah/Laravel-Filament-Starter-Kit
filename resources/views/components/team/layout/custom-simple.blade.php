@php
    use Filament\Support\Enums\MaxWidth;
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="flex min-h-screen">
        @if (($hasTopbar ?? true) && filament()->auth()->check())
            <div
                class="absolute end-0 top-0 flex h-16 items-center gap-x-4 pe-4 md:pe-6 lg:pe-8"
            >
                @if (filament()->hasDatabaseNotifications())
                    @livewire(Filament\Livewire\DatabaseNotifications::class, [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications()
                    ])`
                @endif

{{--                <x-filament-panels::user-menu/>--}}
            </div>
        @endif

        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 size-full object-cover"
                 src="{{ asset('images/team.jpg') }} "
                 alt="">
        </div>

        <div
            class="fi-simple-main-ctn flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-1/2 bg-white dark:bg-gray-800"
        >
            <main
                @class([
                    'fi-simple-main mx-auto w-full',

                ])
            >
                {{ $slot }}
            </main>
        </div>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $livewire->getRenderHookScopes()) }}
    </div>
</x-filament-panels::layout.base>
