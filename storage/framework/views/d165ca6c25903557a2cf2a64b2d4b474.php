<?php if (isset($component)) { $__componentOriginal25595e7f084e4e30db607499dfe54c09 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25595e7f084e4e30db607499dfe54c09 = $attributes; } ?>
<?php $component = DutchCodingCompany\FilamentSocialite\View\Components\Buttons::resolve(['showDivider' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-socialite::buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\DutchCodingCompany\FilamentSocialite\View\Components\Buttons::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25595e7f084e4e30db607499dfe54c09)): ?>
<?php $attributes = $__attributesOriginal25595e7f084e4e30db607499dfe54c09; ?>
<?php unset($__attributesOriginal25595e7f084e4e30db607499dfe54c09); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25595e7f084e4e30db607499dfe54c09)): ?>
<?php $component = $__componentOriginal25595e7f084e4e30db607499dfe54c09; ?>
<?php unset($__componentOriginal25595e7f084e4e30db607499dfe54c09); ?>
<?php endif; ?><?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/storage/framework/views/dfe89ce8acd3a898ada657d2ba84607f.blade.php ENDPATH**/ ?>