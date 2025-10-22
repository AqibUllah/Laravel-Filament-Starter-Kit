<x-filament-panels::page>
    <x-filament::section class="text-center">
        @if($this->isProcessing)
            {{-- Processing State --}}
            <div class="flex justify-center mb-4">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-500"></div>
            </div>

            <h2 class="text-2xl font-bold mb-4">
                {{ $this->isPlanSwitch ? 'Switching Your Plan...' : 'Processing Your Subscription...' }}
            </h2>

            <p class="text-gray-600 mb-6">
                Please wait while we {{ $this->isPlanSwitch ? 'switch your plan' : 'activate your subscription' }} and apply all features.
            </p>

        @elseif($this->subscription)
            {{-- Success State --}}
            <div class="flex justify-center mb-4">
                <x-heroicon-o-check-badge class="h-16 w-16 text-success-500" />
            </div>

            <h2 class="text-2xl font-bold mb-4">
                {{ $this->isPlanSwitch ? 'Plan Updated!' : 'Welcome to ' . $this->planName . '!' }}
            </h2>

            <div class="bg-gradient-to-r from-primary-400 to-emerald-400 border border-primary-200 rounded-lg p-4 mb-6 text-left text-gray-700">
                <h3 class="font-semibold text-success-800 mb-2">
                    {{ $this->isPlanSwitch ? '🔄 Plan Successfully Changed!' : '🎉 Subscription Activated!' }}
                </h3>
                <p><strong>Plan:</strong> {{ $this->subscription->plan->name }}</p>
                <p><strong>Status:</strong> <span class="text-white bg-green-600 px-3 py-1 rounded-full">Active</span></p>
                <p><strong>Price:</strong> ${{ $this->subscription->plan->price }}/{{ $this->subscription->plan->interval }}</p>

                @if($this->subscription->isOnTrial())
                    <p><strong>🎁 Trial Ends:</strong> {{ $this->subscription->trial_ends_at->format('M j, Y') }}</p>
                @endif
            </div>

            {{-- Plan Features Activated --}}
            <div class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-300 dark:from-gray-700 dark:via-gray-800 dark:to-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-6 text-left">
                <h3 class="font-semibold text-primary-800 mb-2">✅ Features Now Active:</h3>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($this->subscription->plan->features as $feature)
                        <li class="text-sm">
                            {{ $feature->name }}:
                            <span class="font-medium">
                                @if(is_bool($feature->value))
                                    {{ $feature->value ? 'Yes' : 'No' }}
                                @else
                                    {{ $feature->value }}
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-center gap-4">
                <x-filament::button
                    wire:click="goToDashboard"
                    color="primary"
                    size="lg">
                    🚀 Go to Dashboard
                </x-filament::button>

                <x-filament::button
                    tag="a"
                    href="{{ route('filament.admin.pages.plans',['tenant' => filament()->getTenant()]) }}"
                    color="gray"
                    size="lg">
                    📊 View Plans
                </x-filament::button>
            </div>

        @else
            {{-- Still Waiting State --}}
            <div class="flex justify-center mb-4">
                <x-heroicon-o-clock class="h-16 w-16 text-warning-500" />
            </div>

            <h2 class="text-2xl font-bold mb-4">Almost There!</h2>

            <p class="text-gray-600 mb-6">
                @if(app()->environment('local'))
                    We're setting up your subscription locally...
                @else
                    Your payment was successful! We're activating your subscription.
                    This usually takes just a few moments.
                @endif
            </p>

            <div class="flex justify-center gap-4">
                <x-filament::button
                    wire:click="checkSubscriptionStatus"
                    color="primary"
                    size="lg">
                    🔄 Check Status
                </x-filament::button>
            </div>

            <p class="text-sm text-gray-500 mt-4">
                @if(app()->environment('local'))
                    Local development mode active
                @else
                    If this takes more than 2 minutes, please contact support.
                @endif
            </p>
        @endif
    </x-filament::section>

    @script
    <script>
        // Auto-check status if still processing
        @if($this->isProcessing)
        setTimeout(() => {
            @this.checkSubscriptionStatus();
        }, 2000);
        @endif

        // Auto-redirect when subscription is activated
        $wire.on('subscription-activated', () => {
            setTimeout(() => {
                window.location.href = @js(filament()->getUrl());
            }, 1500);
        });
    </script>
    @endscript
</x-filament-panels::page>
