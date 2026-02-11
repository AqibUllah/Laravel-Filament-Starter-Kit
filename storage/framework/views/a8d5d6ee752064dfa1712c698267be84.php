<?php
    $afterHeader = $getChildSchema($schemaComponent::AFTER_HEADER_SCHEMA_KEY)?->toHtmlString();
    $isAside = $isAside();
    $isCollapsed = $isCollapsed();
    $isCollapsible = $isCollapsible();
    $isCompact = $isCompact();
    $isContained = $isContained();
    $isDivided = $isDivided();
    $isFormBefore = $isFormBefore();
    $description = $getDescription();
    $footer = $getChildSchema($schemaComponent::FOOTER_SCHEMA_KEY)?->toHtmlString();
    $heading = $getHeading();
    $headingTag = $getHeadingTag();
    $icon = $getIcon();
    $iconColor = $getIconColor();
    $iconSize = $getIconSize();
    $shouldPersistCollapsed = $shouldPersistCollapsed();
    $isSecondary = $isSecondary();
    $id = $getId();
?>

<div
    <?php echo e($attributes
            ->merge([
                'id' => $id,
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->merge($getExtraAlpineAttributes(), escape: false)
            ->class(['fi-sc-section'])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if(filled($label = $getLabel())): ?>
        <div class="fi-sc-section-label-ctn">
            <?php echo e($getChildSchema($schemaComponent::BEFORE_LABEL_SCHEMA_KEY)); ?>


            <div class="fi-sc-section-label">
                <?php echo e($label); ?>

            </div>

            <?php echo e($getChildSchema($schemaComponent::AFTER_LABEL_SCHEMA_KEY)); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($aboveContentContainer = $getChildSchema($schemaComponent::ABOVE_CONTENT_SCHEMA_KEY)?->toHtmlString()): ?>
        <?php echo e($aboveContentContainer); ?>

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['afterHeader' => $afterHeader,'aside' => $isAside,'collapsed' => $isCollapsed,'collapseId' => $id,'collapsible' => $isCollapsible && (! $isAside),'compact' => $isCompact,'contained' => $isContained,'contentBefore' => $isFormBefore,'description' => $description,'divided' => $isDivided,'footer' => $footer,'hasContentEl' => false,'heading' => $heading,'headingTag' => $headingTag,'icon' => $icon,'iconColor' => $iconColor,'iconSize' => $iconSize,'persistCollapsed' => $shouldPersistCollapsed,'secondary' => $isSecondary]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['after-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($afterHeader),'aside' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isAside),'collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isCollapsed),'collapse-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($id),'collapsible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isCollapsible && (! $isAside)),'compact' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isCompact),'contained' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isContained),'content-before' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isFormBefore),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description),'divided' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isDivided),'footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($footer),'has-content-el' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($heading),'heading-tag' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headingTag),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconColor),'icon-size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconSize),'persist-collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($shouldPersistCollapsed),'secondary' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSecondary)]); ?>
        <?php echo e($getChildSchema()->gap(! $isDivided)->extraAttributes(['class' => 'fi-section-content'])); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>

    <!--[if BLOCK]><![endif]--><?php if($belowContentContainer = $getChildSchema($schemaComponent::BELOW_CONTENT_SCHEMA_KEY)?->toHtmlString()): ?>
        <?php echo e($belowContentContainer); ?>

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\vendor\filament\schemas\resources\views/components/section.blade.php ENDPATH**/ ?>