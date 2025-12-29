<div
    x-data="{}"
    x-load-css="[<?php echo \Illuminate\Support\Js::from(\Filament\Support\Facades\FilamentAsset::getStyleHref('filament-socialite-styles', package: 'filament-socialite'))->toHtml() ?>]"
>
    <div class="flex flex-col gap-y-6">
        <!--[if BLOCK]><![endif]--><?php if($messageBag->isNotEmpty()): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $messageBag->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="fi-fo-field-wrp-error-message text-danger-600 dark:text-danger-400"><?php echo e(__($value)); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if(count($visibleProviders)): ?>
            <!--[if BLOCK]><![endif]--><?php if($showDivider): ?>
                <div class="relative flex items-center justify-center text-center">
                    <div class="absolute border-t border-gray-200 w-full h-px"></div>
                    <p class="inline-block relative bg-white text-sm p-2 rounded-full font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-100">
                        <?php echo e(__('filament-socialite::auth.login-via')); ?>

                    </p>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <div class="grid <?php if(count($visibleProviders) > 1): ?> grid-cols-2 <?php endif; ?> gap-4">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $visibleProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => $provider->getColor(),'outlined' => $provider->getOutlined(),'icon' => $provider->getIcon(),'tag' => 'a','href' => route($socialiteRoute, $key),'spaMode' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($provider->getColor()),'outlined' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($provider->getOutlined()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($provider->getIcon()),'tag' => 'a','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($socialiteRoute, $key)),'spa-mode' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
                        <?php echo e($provider->getLabel()); ?>

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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php else: ?>
            <span></span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/resources/views/vendor/filament-socialite/components/buttons.blade.php ENDPATH**/ ?>