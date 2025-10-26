
<div class="p-4">
    <div id="alert-additional-content-2"
         class="{{ match($type) {
            'danger' => 'relative overflow-hidden rounded-xl border-l-4 border-l-red-500 bg-gradient-to-r from-red-50 to-red-100/50 dark:from-red-900/20 dark:to-red-800/10 dark:border-l-red-400 shadow-lg backdrop-blur-sm',
            'warning' => 'relative overflow-hidden rounded-xl border-l-4 border-l-amber-500 bg-gradient-to-r from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-800/10 dark:border-l-amber-400 shadow-lg backdrop-blur-sm',
            'info' => 'relative overflow-hidden rounded-xl border-l-4 border-l-blue-500 bg-gradient-to-r from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-800/10 dark:border-l-blue-400 shadow-lg backdrop-blur-sm',
            default => 'relative overflow-hidden rounded-xl border-l-4 border-l-gray-500 bg-gradient-to-r from-gray-50 to-gray-100/50 dark:from-gray-900/20 dark:to-gray-800/10 dark:border-l-gray-400 shadow-lg backdrop-blur-sm'
        } }}"
         role="alert">
        
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.15)_1px,transparent_0)] bg-[length:20px_20px]"></div>
        </div>
        
        <div class="relative p-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-3">
                        <!-- Professional Icons -->
                        <div class="flex-shrink-0">
                            @if($type === 'danger')
                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                            @elseif($type === 'warning')
                                <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @elseif($type === 'info')
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold {{ match($type) {
                                'danger' => 'text-red-900 dark:text-red-100',
                                'warning' => 'text-amber-900 dark:text-amber-100',
                                'info' => 'text-blue-900 dark:text-blue-100',
                                default => 'text-gray-900 dark:text-gray-100'
                            } }}">
                                {{ match($type) {
                                    'danger' => 'Limit Reached',
                                    'warning' => 'Approaching Limit',
                                    'info' => 'Usage Information',
                                    default => 'Limit Alert'
                                } }}
                            </h3>
                            <p class="text-sm {{ match($type) {
                                'danger' => 'text-red-700 dark:text-red-300',
                                'warning' => 'text-amber-700 dark:text-amber-300',
                                'info' => 'text-blue-700 dark:text-blue-300',
                                default => 'text-gray-700 dark:text-gray-300'
                            } }} mt-1">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($upgradeUrl)
                    <div class="flex-shrink-0">
                        <x-filament::button
                            :href="$upgradeUrl"
                            size="sm"
                            color="primary"
                            tag="a"
                            class="shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105 font-medium px-6 py-2.5"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            Upgrade Plan
                        </x-filament::button>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Subtle bottom border accent -->
        <div class="absolute bottom-0 left-0 right-0 h-1 {{ match($type) {
            'danger' => 'bg-gradient-to-r from-red-500 to-red-400',
            'warning' => 'bg-gradient-to-r from-amber-500 to-amber-400',
            'info' => 'bg-gradient-to-r from-blue-500 to-blue-400',
            default => 'bg-gradient-to-r from-gray-500 to-gray-400'
        } }}"></div>
    </div>
</div>

