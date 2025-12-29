
<?php if (isset($component)) { $__componentOriginale960ae7ad1b1ce9e3596e483505fadc9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.layout.base','data' => ['livewire' => $livewire]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::layout.base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['livewire' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($livewire)]); ?>
    <?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
    <div class="antialiased min-h-screen bg-gray-50 dark:bg-gray-900 animated-gradient">
        <!-- Floating Shapes -->
        <div class="floating-shape w-20 h-20 top-10 left-10"></div>
        <div class="floating-shape w-16 h-16 top-32 right-20"></div>
        <div class="floating-shape w-24 h-24 bottom-20 left-32"></div>
        <div class="floating-shape w-12 h-12 bottom-32 right-16"></div>

        <div class="min-h-screen flex flex-col items-center justify-center p-4 relative z-10">
            <!-- Brand Section -->
            <div class="mb-8 text-center">
                <?php if(isset($brandLogo)): ?>
                    <div class="logo-container mb-4">
                        <?php echo e($brandLogo); ?>

                    </div>
                <?php endif; ?>

                <?php if(isset($brandName)): ?>
                    <h1 class="brand-text text-4xl md:text-5xl font-bold text-white mb-2">
                        <?php echo e($brandName); ?>

                    </h1>
                <?php endif; ?>

                <?php if(isset($brandDescription)): ?>
                    <p class="brand-subtitle text-white/80 text-lg md:text-xl">
                        <?php echo e($brandDescription); ?>

                    </p>
                <?php endif; ?>
            </div>

            <!-- Content Section -->
            <div class="login-card w-full max-w-md rounded-2xl p-8">
                <?php echo e($slot); ?>

            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-white/60 text-sm">
                    &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Your Application')); ?>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9)): ?>
<?php $attributes = $__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9; ?>
<?php unset($__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale960ae7ad1b1ce9e3596e483505fadc9)): ?>
<?php $component = $__componentOriginale960ae7ad1b1ce9e3596e483505fadc9; ?>
<?php unset($__componentOriginale960ae7ad1b1ce9e3596e483505fadc9); ?>
<?php endif; ?>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/resources/views/components/team/layout/custom-simple.blade.php ENDPATH**/ ?>