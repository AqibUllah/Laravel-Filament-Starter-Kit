<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\IconSize;
    use Filament\Support\View\Components\SectionComponent\IconComponent;

    use function Filament\Support\is_slot_empty;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'afterHeader' => null,
    'aside' => false,
    'collapsed' => false,
    'collapseId' => null,
    'collapsible' => false,
    'compact' => false,
    'contained' => true,
    'contentBefore' => false,
    'description' => null,
    'divided' => false,
    'footer' => null,
    'hasContentEl' => true,
    'heading' => null,
    'headingTag' => 'h2',
    'icon' => null,
    'iconColor' => 'gray',
    'iconSize' => null,
    'persistCollapsed' => false,
    'secondary' => false,
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
    'afterHeader' => null,
    'aside' => false,
    'collapsed' => false,
    'collapseId' => null,
    'collapsible' => false,
    'compact' => false,
    'contained' => true,
    'contentBefore' => false,
    'description' => null,
    'divided' => false,
    'footer' => null,
    'hasContentEl' => true,
    'heading' => null,
    'headingTag' => 'h2',
    'icon' => null,
    'iconColor' => 'gray',
    'iconSize' => null,
    'persistCollapsed' => false,
    'secondary' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    if (filled($iconSize) && (! $iconSize instanceof IconSize)) {
        $iconSize = IconSize::tryFrom($iconSize) ?? $iconSize;
    }

    $hasDescription = filled((string) $description);
    $hasHeading = filled($heading);
    $hasIcon = filled($icon);
    $hasHeader = $hasIcon || $hasHeading || $hasDescription || $collapsible || (! is_slot_empty($afterHeader));
?>

<section
    
    x-data="{
        isCollapsed: <?php if($persistCollapsed): ?> $persist(<?php echo \Illuminate\Support\Js::from($collapsed)->toHtml() ?>).as(`section-${<?php echo \Illuminate\Support\Js::from($collapseId)->toHtml() ?> ?? $el.id}-isCollapsed`) <?php else: ?> <?php echo \Illuminate\Support\Js::from($collapsed)->toHtml() ?> <?php endif; ?>,
    }"
    <?php if($collapsible): ?>
        x-on:collapse-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($collapseId)->toHtml() ?> ?? $el.id) isCollapsed = true"
        x-on:expand="isCollapsed = false"
        x-on:expand-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($collapseId)->toHtml() ?> ?? $el.id) isCollapsed = false"
        x-on:open-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($collapseId)->toHtml() ?> ?? $el.id) isCollapsed = false"
        x-on:toggle-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($collapseId)->toHtml() ?> ?? $el.id) isCollapsed = ! isCollapsed"
        x-bind:class="isCollapsed && 'fi-collapsed'"
    <?php endif; ?>
    <?php echo e($attributes->class([
            'fi-section',
            'fi-section-not-contained' => ! $contained,
            'fi-section-has-content-before' => $contentBefore,
            'fi-section-has-header' => $hasHeader,
            'fi-aside' => $aside,
            'fi-compact' => $compact,
            'fi-collapsible' => $collapsible,
            'fi-divided' => $divided,
            'fi-secondary' => $secondary,
        ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if($hasHeader): ?>
        <header
            <?php if($collapsible): ?>
                x-on:click="isCollapsed = ! isCollapsed"
            <?php endif; ?>
            class="fi-section-header"
        >
            <?php echo e(\Filament\Support\generate_icon_html($icon, attributes: (new \Illuminate\View\ComponentAttributeBag)
                    ->color(IconComponent::class, $iconColor), size: $iconSize ?? IconSize::Large)); ?>


            <!--[if BLOCK]><![endif]--><?php if($hasHeading || $hasDescription): ?>
                <div class="fi-section-header-text-ctn">
                    <!--[if BLOCK]><![endif]--><?php if($hasHeading): ?>
                        <<?php echo e($headingTag); ?> class="fi-section-header-heading">
                            <?php echo e($heading); ?>

                        </<?php echo e($headingTag); ?>>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($hasDescription): ?>
                        <p class="fi-section-header-description">
                            <?php echo e($description); ?>

                        </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if(! is_slot_empty($afterHeader)): ?>
                <div x-on:click.stop class="fi-section-header-after-ctn">
                    <?php echo e($afterHeader); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($collapsible): ?>
                <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => \Filament\Support\Icons\Heroicon::ChevronUp,'iconAlias' => \Filament\Support\View\SupportIconAlias::SECTION_COLLAPSE_BUTTON,'xOn:click.stop' => 'isCollapsed = ! isCollapsed','class' => 'fi-section-collapse-btn']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Icons\Heroicon::ChevronUp),'icon-alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\View\SupportIconAlias::SECTION_COLLAPSE_BUTTON),'x-on:click.stop' => 'isCollapsed = ! isCollapsed','class' => 'fi-section-collapse-btn']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $attributes = $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $component = $__componentOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </header>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if((! is_slot_empty($slot)) || (! is_slot_empty($footer))): ?>
        <div
            <?php if($collapsible): ?>
                x-bind:aria-expanded="(! isCollapsed).toString()"
                <?php if($collapsed || $persistCollapsed): ?>
                    x-cloak
                <?php endif; ?>
            <?php endif; ?>
            class="fi-section-content-ctn"
        >
            <!--[if BLOCK]><![endif]--><?php if($hasContentEl): ?>
                <div class="fi-section-content">
                    <?php echo e($slot); ?>

                </div>
            <?php else: ?>
                <?php echo e($slot); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if(! is_slot_empty($footer)): ?>
                <footer class="fi-section-footer">
                    <?php echo e($footer); ?>

                </footer>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</section>
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\vendor\filament\support\resources\views/components/section/index.blade.php ENDPATH**/ ?>