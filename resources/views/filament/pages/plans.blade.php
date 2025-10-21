<x-filament-panels::page>
    {{-- Current Subscription Status --}}
    @if($this->currentSubscription)
        <x-filament::section class="mb-8">
            <x-slot name="heading">
                Current Subscription
            </x-slot>

            <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold">{{ $this->currentSubscription->plan->name }}</p>
                    <p class="text-sm text-gray-600">
                        Status:
                        <span class="font-medium {{ $this->currentSubscription->isActive() ? 'text-success-600' : 'text-danger-600' }}">
                            {{ ucfirst($this->currentSubscription->status) }}
                        </span>
                    </p>
                    @if($this->currentSubscription->isOnTrial())
                        <p class="text-sm text-warning-600">
                            Trial ends in {{ $this->currentSubscription->trial_ends_at->diffInDays(now()) }} days
                        </p>
                    @endif
                </div>

                <x-filament::button
                    color="gray"
                    tag="a"
                    href="{{ route('filament.admin.pages.billing') }}">
                    Manage Billing
                </x-filament::button>
            </div>
        </x-filament::section>
    @endif

    {{-- Plans Grid --}}
    <x-filament::section class="mb-8">
        <x-slot name="heading">
            Subscription Plans
        </x-slot>
        <x-slot name="description">
            Choose the plan that works best for your team
        </x-slot>

        <x-slot name="afterHeader">
            {{-- Input to select the user's ID --}}
        {{ $this->getBillingPortalAction }}
        </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($this->plans as $plan)
            <div class="border rounded-lg p-6 {{ $plan->is_featured ? 'border-primary-500 ring-2 ring-primary-500 bg-primary-100 dark:bg-gray-900' : 'border-gray-200 bg-gray-200 dark:bg-gray-800 dark:border-gray-700' }}">
                @if($plan->is_featured)
                    <div class="bg-primary-500 text-white text-sm font-medium px-3 py-1 rounded-full inline-block mb-4">
                        Most Popular
                    </div>
                @endif

                <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                <p class="text-gray-600 mt-2">{{ $plan->description }}</p>

                <div class="my-4">
                    <span class="text-3xl font-bold">${{ $plan->price }}</span>
                    <span class="text-gray-600">/{{ $plan->interval }}</span>
                </div>

                <ul class="space-y-2 mb-6">
                    @foreach($plan->features as $feature)
                        <li class="flex items-center">
                            <x-heroicon-o-check class="h-5 w-5 text-success-500 mr-2" />
                            <span class="text-sm">
                                {{ $feature->name }}:
                                @if(is_bool($feature->value))
                                    {{ $feature->value ? 'Yes' : 'No' }}
                                @else
                                    {{ $feature->value }}
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>

                <x-filament::button
                    wire:click="subscribe({{ $plan->id }})"
                    class="w-full"
                    color="{{ $plan->is_featured ? 'primary' : 'gray' }}"
                    size="lg"
                    :disabled="$this->isCurrentPlan($plan->id)">
                    @if($this->isCurrentPlan($plan->id))
                        Current Plan
                    @else
                        {{ $this->currentSubscription ? 'Switch Plan' : 'Get Started' }}
                    @endif
                </x-filament::button>
            </div>
        @endforeach
    </div>
    </x-filament::section>
</x-filament-panels::page>
