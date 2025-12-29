<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="space-y-8">
        <!--[if BLOCK]><![endif]--><?php if($this->isProcessing): ?>
            <!-- Processing State -->
            <div class="text-center space-y-6 py-8">
                <!-- Animated Loader -->
                <div class="flex justify-center">
                    <div class="relative">
                        <div class="w-20 h-20 border-4 border-primary-200 rounded-full"></div>
                        <div class="w-20 h-20 border-4 border-primary-500 rounded-full animate-spin border-t-transparent absolute top-0 left-0"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <svg class="w-8 h-8 text-primary-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-blue-600 bg-clip-text text-transparent">
                        <?php echo e($this->isPlanSwitch ? 'Switching Your Plan' : 'Processing Your Subscription'); ?>

                    </h2>

                    <p class="text-gray-600 text-lg max-w-md mx-auto leading-relaxed">
                        Please wait while we <?php echo e($this->isPlanSwitch ? 'switch your plan' : 'activate your subscription'); ?> and apply all features.
                    </p>

                    <div class="pt-4">
                        <div class="w-48 h-1 bg-gray-200 rounded-full mx-auto overflow-hidden">
                            <div class="h-full bg-primary-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif($this->subscription): ?>
            <!-- Success State -->
            <div class="text-center space-y-5">
                <!-- Success Icon -->
                <div class="flex justify-center">
                    <div class="relative">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center shadow-lg shadow-green-200">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center animate-bounce">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="space-y-4">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                        <?php echo e($this->isPlanSwitch ? 'Plan Updated Successfully!' : 'Welcome to ' . $this->planName . '!'); ?>

                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300">
                        <?php echo e($this->isPlanSwitch ? 'Your plan has been switched successfully' : 'Your subscription is now active and ready to use'); ?>

                    </p>
                </div>

                <!-- Subscription Details Card -->
                <div class="bg-gradient-to-r from-primary-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-3 xs:grid-cols-2 gap-6 text-center md:text-left">
                        <div class="space-y-2">
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-semibold">Plan Details</span>
                            </div>
                            <p class="text-2xl font-bold"><?php echo e($this->subscription->plan->name); ?></p>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">Status</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                ✅ Active
                            </span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <span class="font-semibold">Price</span>
                            </div>
                            <p class="text-2xl font-bold">$<?php echo e($this->subscription->plan->price); ?>/<?php echo e($this->subscription->plan->interval); ?></p>
                        </div>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($this->subscription->isOnTrial()): ?>
                        <div class="mt-4 p-3 bg-white/10 rounded-lg backdrop-blur-sm">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Trial Ends: <?php echo e($this->subscription->trial_ends_at->format('M j, Y')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Features Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                        🎯 Your Active Features
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2 gap-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->subscription->plan->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <!--[if BLOCK]><![endif]--><?php if(is_bool($feature->value)): ?>
                                    <div class="flex-shrink-0 w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                <?php else: ?>
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        <?php echo e($feature->name); ?>

                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <!--[if BLOCK]><![endif]--><?php if(is_bool($feature->value)): ?>
                                            <?php echo e($feature->value ? 'Enabled' : 'Disabled'); ?>

                                        <?php else: ?>
                                            <?php echo e($feature->value); ?>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['tag' => 'a','href' => ''.e(route('filament.tenant.pages.dashboard',['tenant' => $this->teamId])).'','color' => 'primary','size' => 'xl','class' => 'flex items-center justify-center space-x-2 bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'a','href' => ''.e(route('filament.tenant.pages.dashboard',['tenant' => $this->teamId])).'','color' => 'primary','size' => 'xl','class' => 'flex items-center justify-center space-x-2 bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>🚀 Go to Dashboard</span>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['tag' => 'a','href' => ''.e(route('filament.tenant.pages.plans',['tenant' => $this->teamId])).'','color' => 'gray','size' => 'xl','class' => 'flex items-center justify-center space-x-2 border-2 hover:border-primary-300 transition-all duration-200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'a','href' => ''.e(route('filament.tenant.pages.plans',['tenant' => $this->teamId])).'','color' => 'gray','size' => 'xl','class' => 'flex items-center justify-center space-x-2 border-2 hover:border-primary-300 transition-all duration-200']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>📊 View Plans</span>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                </div>

                <!-- Next Steps -->
                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                        💡 <strong>Next:</strong> Explore your dashboard to get the most out of your new plan
                    </p>
                </div>
            </div>

        <?php else: ?>
            <!-- Still Waiting State -->
            <div class="text-center space-y-6 py-8">
                <!-- Waiting Icon -->
                <div class="flex justify-center">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg shadow-yellow-200">
                            <svg class="w-10 h-10 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Almost There!</h2>

                    <p class="text-gray-600 text-lg max-w-md mx-auto leading-relaxed">
                        <!--[if BLOCK]><![endif]--><?php if(app()->environment('local')): ?>
                            We're setting up your subscription locally...
                        <?php else: ?>
                            Your payment was successful! We're activating your subscription.
                            This usually takes just a few moments.
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </p>

                    <!-- Progress Bar -->
                    <div class="pt-4">
                        <div class="w-64 h-2 bg-gray-200 rounded-full mx-auto overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full animate-pulse w-3/4"></div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex justify-center gap-4 pt-4">
                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['wire:click' => 'checkSubscriptionStatus','color' => 'warning','size' => 'lg','class' => 'flex items-center space-x-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'checkSubscriptionStatus','color' => 'warning','size' => 'lg','class' => 'flex items-center space-x-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600']); ?>
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>🔄 Check Status</span>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                </div>

                <!-- Help Text -->
                <p class="text-sm text-gray-500 dark:text-gray-400 pt-4">
                    <!--[if BLOCK]><![endif]--><?php if(app()->environment('local')): ?>
                        Local development mode active
                    <?php else: ?>
                        If this takes more than 2 minutes, please contact our support team.
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </p>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

        <?php
        $__scriptKey = '2105219113-0';
        ob_start();
    ?>
    <script>
        // Auto-check status if still processing
        <!--[if BLOCK]><![endif]--><?php if($this->isProcessing): ?>
        setTimeout(() => {
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').checkSubscriptionStatus();
        }, 2000);
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        // Auto-redirect when subscription is activated
        $wire.on('subscription-activated', () => {
            // Show success confetti effect
            const confetti = () => {
                const end = Date.now() + 1000;
                const colors = ['#10b981', '#3b82f6', '#8b5cf6'];

                (function frame() {
                    confetti({
                        particleCount: 3,
                        angle: 60,
                        spread: 55,
                        origin: { x: 0 },
                        colors: colors
                    });
                    confetti({
                        particleCount: 3,
                        angle: 120,
                        spread: 55,
                        origin: { x: 1 },
                        colors: colors
                    });

                    if (Date.now() < end) {
                        requestAnimationFrame(frame);
                    }
                }());
            };

            confetti();

            setTimeout(() => {
                window.location.href = <?php echo \Illuminate\Support\Js::from(filament()->getUrl())->toHtml() ?>;
            }, 2000);
        });
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/resources/views/filament/pages/subscription-success.blade.php ENDPATH**/ ?>