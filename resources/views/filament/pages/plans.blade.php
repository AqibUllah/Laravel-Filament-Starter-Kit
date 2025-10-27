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
                    href="{{ route('filament.tenant.tenant.billing',['tenant' => filament()->getTenant()]) }}">
                    Manage Billing
                </x-filament::button>
            </div>
        </x-filament::section>
    @endif

    {{-- Coupon Section --}}
    <x-filament::section class="mb-8">
        <x-slot name="heading">
            Coupon Code
        </x-slot>
        <x-slot name="description">
            Enter a coupon code to get a discount on your subscription
        </x-slot>

        <div class="flex gap-4 items-end">
            <div class="flex-1">
                <x-filament::input.wrapper>
                    <x-filament::input
                        wire:model.live="couponCode"
                        placeholder="Enter coupon code (e.g., WELCOME20)"
                        wire:keyup.enter="validateCoupon"
                    />
                </x-filament::input.wrapper>
            </div>
            
            <x-filament::button
                wire:click="validateCoupon"
                color="primary"
                :disabled="empty($couponCode)">
                Apply Coupon
            </x-filament::button>
            
            @if($appliedCoupon)
                <x-filament::button
                    wire:click="removeCoupon"
                    color="gray"
                    outline>
                    Remove
                </x-filament::button>
            @endif
        </div>

        @if($appliedCoupon)
            <div class="mt-4 p-4 bg-success-50 dark:bg-success-900/20 border border-success-200 dark:border-success-800 rounded-lg">
                <div class="flex items-center">
                    <x-heroicon-o-check-circle class="h-5 w-5 text-success-500 mr-2" />
                    <div>
                        <p class="font-medium text-success-800 dark:text-success-200">
                            Coupon Applied: {{ $appliedCoupon->name }}
                        </p>
                        <p class="text-sm text-success-600 dark:text-success-300">
                            {{ $appliedCoupon->getFormattedDiscount() }} discount
                            @if($appliedCoupon->description)
                                - {{ $appliedCoupon->description }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </x-filament::section>

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
                <div class="{{ $this->isCurrentPlan($plan->id) ? 'rounded-3xl p-px bg-gradient-to-b from-blue-300 to-pink-300 dark:from-blue-800 dark:to-purple-800' : '' }}">
                    <div class="border relative rounded-[calc(1.5rem-1px)] p-5 h-full flex flex-col {{ $plan->is_featured ? 'border-primary-500 ring-2 ring-primary-500 bg-primary-100 dark:bg-gray-900' : ($this->isCurrentPlan($plan->id) ? 'border-gray-200 dark:border-gray-700' : 'border-gray-200 bg-gray-200 dark:bg-gray-800 dark:border-gray-700') }}">
                        @if($plan->is_featured)
                            <div class="bg-primary-500 text-white text-sm font-medium px-3 py-1 rounded-full inline-block mb-4">
                                Most Popular
                            </div>
                        @endif

                        <div class="flex-grow">
                            <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ $plan->description }}</p>

                            <div class="my-4">
                                @if($appliedCoupon)
                                    @php
                                        $couponService = app(\App\Services\CouponService::class);
                                        $discountData = $couponService->calculateDiscount($appliedCoupon, $plan->price);
                                    @endphp
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span class="text-lg text-gray-500 line-through">${{ $plan->price }}</span>
                                            <span class="text-3xl font-bold ml-2">${{ number_format($discountData['final_amount'], 2) }}</span>
                                            <span class="text-gray-600">/{{ $plan->interval }}</span>
                                        </div>
                                        <div class="text-sm text-success-600 font-medium">
                                            Save ${{ number_format($discountData['discount_amount'], 2) }} ({{ $discountData['savings_percentage'] }}% off)
                                        </div>
                                    </div>
                                @else
                                    <span class="text-3xl font-bold">${{ $plan->price }}</span>
                                    <span class="text-gray-600">/{{ $plan->interval }}</span>
                                @endif
                            </div>

                            <ul class="space-y-2 mb-6">
                                @foreach(json_decode($plan->features) as $feature)
                                    <li class="flex items-center">
                                <span class="text-sm flex justify-between w-full">
                                    <span>
                                        {{ $feature->name }}:
                                    </span>
                                    @if(is_bool($feature->value))
                                        @if (is_bool($feature->value) && $feature->value)
                                            <x-heroicon-o-check-circle class="h-5 w-5 text-success-500" />
                                        @else
                                            <x-heroicon-o-x-circle class="h-5 w-5 text-danger-500" />
                                        @endif
                                    @else
                                        {{ $feature->value }}
                                    @endif
                                </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-auto pt-4">
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
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-panels::page>
