<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'alpineDisabled' => null,
    'alpineValid' => null,
    'disabled' => false,
    'inlinePrefix' => false,
    'inlineSuffix' => false,
    'prefix' => null,
    'prefixActions' => [],
    'prefixIcon' => null,
    'prefixIconColor' => 'gray',
    'prefixIconAlias' => null,
    'suffix' => null,
    'suffixActions' => [],
    'suffixIcon' => null,
    'suffixIconColor' => 'gray',
    'suffixIconAlias' => null,
    'valid' => true,
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
    'alpineDisabled' => null,
    'alpineValid' => null,
    'disabled' => false,
    'inlinePrefix' => false,
    'inlineSuffix' => false,
    'prefix' => null,
    'prefixActions' => [],
    'prefixIcon' => null,
    'prefixIconColor' => 'gray',
    'prefixIconAlias' => null,
    'suffix' => null,
    'suffixActions' => [],
    'suffixIcon' => null,
    'suffixIconColor' => 'gray',
    'suffixIconAlias' => null,
    'valid' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use Filament\Support\View\Components\InputComponent\WrapperComponent\IconComponent;
    use Illuminate\View\ComponentAttributeBag;

    $prefixActions = array_filter(
        $prefixActions,
        fn (\Filament\Actions\Action $prefixAction): bool => $prefixAction->isVisible(),
    );

    $suffixActions = array_filter(
        $suffixActions,
        fn (\Filament\Actions\Action $suffixAction): bool => $suffixAction->isVisible(),
    );

    $hasPrefix = count($prefixActions) || $prefixIcon || filled($prefix);
    $hasSuffix = count($suffixActions) || $suffixIcon || filled($suffix);

    $hasAlpineDisabledClasses = filled($alpineDisabled);
    $hasAlpineValidClasses = filled($alpineValid);
    $hasAlpineClasses = $hasAlpineDisabledClasses || $hasAlpineValidClasses;

    $wireTarget = $attributes->whereStartsWith(['wire:target'])->first();

    $hasLoadingIndicator = filled($wireTarget);

    if ($hasLoadingIndicator) {
        $loadingIndicatorTarget = html_entity_decode($wireTarget, ENT_QUOTES);
    }
?>

<div
    <?php if($hasAlpineClasses): ?>
        x-bind:class="{
            <?php echo e($hasAlpineDisabledClasses ? "'fi-disabled': {$alpineDisabled}," : null); ?>

            <?php echo e($hasAlpineValidClasses ? "'fi-invalid': ! ({$alpineValid})," : null); ?>

        }"
    <?php endif; ?>
    <?php echo e($attributes
            ->except(['wire:target', 'tabindex'])
            ->class([
                'fi-input-wrp',
                'fi-disabled' => (! $hasAlpineClasses) && $disabled,
                'fi-invalid' => (! $hasAlpineClasses) && (! $valid),
            ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if($hasPrefix || $hasLoadingIndicator): ?>
        <div
            <?php if(! $hasPrefix): ?>
                wire:loading.delay.<?php echo e(config('filament.livewire_loading_delay', 'default')); ?>.flex
                wire:target="<?php echo e($loadingIndicatorTarget); ?>"
                wire:key="<?php echo e(\Illuminate\Support\Str::random()); ?>" 
            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-input-wrp-prefix',
                'fi-input-wrp-prefix-has-content' => $hasPrefix,
                'fi-inline' => $inlinePrefix,
                'fi-input-wrp-prefix-has-label' => filled($prefix),
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php if(count($prefixActions)): ?>
                <div class="fi-input-wrp-actions">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $prefixActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prefixAction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($prefixAction); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php echo e(\Filament\Support\generate_icon_html($prefixIcon, $prefixIconAlias, (new \Illuminate\View\ComponentAttributeBag)
                    ->merge([
                        'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                        'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : false,
                    ], escape: false)
                    ->color(IconComponent::class, $prefixIconColor))); ?>


            <!--[if BLOCK]><![endif]--><?php if($hasLoadingIndicator): ?>
                <?php echo e(\Filament\Support\generate_loading_indicator_html((new \Illuminate\View\ComponentAttributeBag([
                        'wire:loading.delay.' . config('filament.livewire_loading_delay', 'default') => $hasPrefix,
                        'wire:target' => $hasPrefix ? $loadingIndicatorTarget : null,
                    ]))->color(IconComponent::class, 'gray'))); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if(filled($prefix)): ?>
                <span class="fi-input-wrp-label">
                    <?php echo e($prefix); ?>

                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div
        <?php if($hasLoadingIndicator && (! $hasPrefix)): ?>
            <?php if($inlinePrefix): ?>
                wire:loading.delay.<?php echo e(config('filament.livewire_loading_delay', 'default')); ?>.class.remove="ps-3"
            <?php endif; ?>

            wire:target="<?php echo e($loadingIndicatorTarget); ?>"
        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-input-wrp-content-ctn',
            'fi-input-wrp-content-ctn-ps' => $hasLoadingIndicator && (! $hasPrefix) && $inlinePrefix,
        ]); ?>"
    >
        <?php echo e($slot); ?>

    </div>

    <!--[if BLOCK]><![endif]--><?php if($hasSuffix): ?>
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-input-wrp-suffix',
                'fi-inline' => $inlineSuffix,
                'fi-input-wrp-suffix-has-label' => filled($suffix),
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php if(filled($suffix)): ?>
                <span class="fi-input-wrp-label">
                    <?php echo e($suffix); ?>

                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php echo e(\Filament\Support\generate_icon_html($suffixIcon, $suffixIconAlias, (new \Illuminate\View\ComponentAttributeBag)
                    ->merge([
                        'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                        'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : false,
                    ], escape: false)
                    ->color(IconComponent::class, $suffixIconColor))); ?>


            <!--[if BLOCK]><![endif]--><?php if(count($suffixActions)): ?>
                <div class="fi-input-wrp-actions">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suffixActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suffixAction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($suffixAction); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/filament/support/resources/views/components/input/wrapper.blade.php ENDPATH**/ ?>