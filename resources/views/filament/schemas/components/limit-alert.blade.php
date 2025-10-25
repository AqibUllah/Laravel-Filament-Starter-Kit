

<div class="p-2">

    <div id="alert-additional-content-2"
         class="{{ match($type) {
            'danger' => 'p-3 border rounded-lg bg-red-50 dark:bg-red-700 border-red-300 text-red-800 dark:text-red-100 dark:border-red-800',
            'warning' => 'p-3 border rounded-lg bg-yellow-50 dark:bg-yellow-700 border-yellow-300 text-yellow-800 dark:text-yellow-100 dark:border-yellow-800',
            'info' => 'p-3 border rounded-lg bg-info-50 dark:bg-info-700 border-info-300 text-info-800 dark:text-info-100 dark:border-info-800',
            default => 'p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 text-gray-800 dark:text-gray-100 dark:border-gray-800'
        } }}"
         role="alert">
        <div class="flex items-center justify-between">

            <div>
                <div class="flex items-center">
                    <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <h3 class="text-lg font-medium">
                        {{ match($type) {
                            'danger' => 'Limit Reached',
                            'warning' => 'Approaching Limit',
                            'info' => 'Usage Information',
                            default => 'Limit Alert'
                        } }}
                    </h3>
                </div>
                <div class="mt-1 mb-4 text-sm">
                    {{ $message }}
                </div>
            </div>
            <div class="flex">
                @if($upgradeUrl)
                    <x-filament::button
                        :href="$upgradeUrl"
                        size="sm"
                        color="primary"
                        tag="a"
                    >
                        Upgrade Plan
                    </x-filament::button>
                @endif
            </div>
        </div>
    </div>
</div>

