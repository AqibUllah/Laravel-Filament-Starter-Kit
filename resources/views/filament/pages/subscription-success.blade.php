<x-filament-panels::page>
    <x-filament::section class="text-center">
        @if($this->isProcessing)
            <div class="flex justify-center mb-4">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-500"></div>
            </div>

            <h2 class="text-2xl font-bold mb-4">Processing Your Subscription...</h2>

            <p class="text-gray-600 mb-6">
                Please wait while we activate your subscription. This may take a few moments.
            </p>

            <x-filament::button
                wire:click="checkSubscriptionStatus"
                color="primary"
                size="lg">
                Check Status
            </x-filament::button>

        @elseif($this->subscription)
            <div class="flex justify-center mb-4">
                <x-heroicon-o-check-badge class="h-16 w-16 text-success-500" />
            </div>

            <h2 class="text-2xl font-bold mb-4">Subscription Activated Successfully!</h2>

            <div class="bg-green-300 dark:bg-gray-800 border border-success-200 dark:border-gray-700 rounded-lg p-4 mb-6 text-left">
                <h3 class="font-semibold text-gray-600 mb-2">Subscription Details:</h3>
                <p><strong>Plan:</strong> {{ $this->subscription->plan->name }}</p>
                <p><strong>Status:</strong> <span class="text-success-600">Active</span></p>
                <p><strong>Price:</strong> ${{ $this->subscription->plan->price }}/{{ $this->subscription->plan->interval }}</p>

                @if($this->subscription->isOnTrial())
                    <p><strong>Trial Ends:</strong> {{ $this->subscription->trial_ends_at->format('M j, Y') }}</p>
                @endif
            </div>

            <p class="text-gray-600 mb-6">
                Your team now has access to all features of the <strong>{{ $this->subscription->plan->name }}</strong> plan.
                @if($this->subscription->isOnTrial())
                    You're currently on a free trial that ends on {{ $this->subscription->trial_ends_at->format('F j, Y') }}.
                @endif
            </p>

            <div class="flex justify-center gap-4">
                <x-filament::button
                    tag="a"
                    href="{{ filament()->getUrl() }}"
                    color="primary"
                    size="lg">
                    Go to Dashboard
                </x-filament::button>

                <x-filament::button
                    tag="a"
                    href="{{ route('filament.admin.pages.plans',['tenant' => filament()->getTenant()]) }}"
                    color="gray"
                    size="lg">
                    View Plans
                </x-filament::button>
            </div>

        @else
            <div class="flex justify-center mb-4">
                <x-heroicon-o-clock class="h-16 w-16 text-warning-500" />
            </div>

            <h2 class="text-2xl font-bold mb-4">Subscription Processing</h2>

            <p class="text-gray-600 mb-6">
                Your payment was successful, but we're still activating your subscription.
                This usually takes just a few moments.
            </p>

            <div class="flex justify-center gap-4">
                <x-filament::button
                    wire:click="checkSubscriptionStatus"
                    color="primary"
                    size="lg">
                    Check Status Again
                </x-filament::button>

                <x-filament::button
                    tag="a"
                    href="{{ filament()->getUrl() }}"
                    color="gray"
                    size="lg">
                    Go to Dashboard
                </x-filament::button>
            </div>

            <p class="text-sm text-gray-500 mt-4">
                If you continue to see this message, please contact support.
            </p>
        @endif
    </x-filament::section>

    @script
    <script>
        // Auto-refresh the page when subscription is activated
        $wire.on('subscription-activated', () => {
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });

        // Auto-check status every 5 seconds if still processing
        @if($this->isProcessing || !$this->subscription)
        setInterval(() => {
            @this.checkSubscriptionStatus();
        }, 5000);
        @endif
    </script>
    @endscript
</x-filament-panels::page>