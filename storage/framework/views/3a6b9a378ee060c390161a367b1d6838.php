<?php
    use Filament\Schemas\Components\Tabs\Tab;

    $activeTab = $getActiveTab();
    $isContained = $isContained();
    $isVertical = $isVertical();
    $label = $getLabel();
    $livewireProperty = $getLivewireProperty();
    $renderHookScopes = $getRenderHookScopes();
    $id = $getId();
?>

<!--[if BLOCK]><![endif]--><?php if(blank($livewireProperty)): ?>
    <div
        x-load
        x-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('tabs', 'filament/schemas')); ?>"
        x-data="tabsSchemaComponent({
            activeTab: <?php echo \Illuminate\Support\Js::from($activeTab)->toHtml() ?>,
            isTabPersistedInQueryString: <?php echo \Illuminate\Support\Js::from($isTabPersistedInQueryString())->toHtml() ?>,
            livewireId: <?php echo \Illuminate\Support\Js::from($this->getId())->toHtml() ?>,
            tab: <?php if($isTabPersisted() && filled($id)): ?> $persist(null).as(<?php echo \Illuminate\Support\Js::from($id)->toHtml() ?>) <?php else: ?> <?php echo \Illuminate\Support\Js::from(null)->toHtml() ?> <?php endif; ?>,
            tabQueryStringKey: <?php echo \Illuminate\Support\Js::from($getTabQueryStringKey())->toHtml() ?>,
        })"
        wire:ignore.self
        <?php echo e($attributes
                ->merge([
                    'id' => $id,
                    'wire:key' => $getLivewireKey() . '.container',
                ], escape: false)
                ->merge($getExtraAttributes(), escape: false)
                ->merge($getExtraAlpineAttributes(), escape: false)
                ->class([
                    'fi-sc-tabs',
                    'fi-contained' => $isContained,
                    'fi-vertical' => $isVertical,
                ])); ?>

    >
        <input
            type="hidden"
            value="<?php echo e(collect($getChildSchema()->getComponents())
                    ->filter(static fn (Tab $tab): bool => $tab->isVisible())
                    ->map(static fn (Tab $tab) => $tab->getKey(isAbsolute: false))
                    ->values()
                    ->toJson()); ?>"
            x-ref="tabsData"
        />

        <?php if (isset($component)) { $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.index','data' => ['contained' => $isContained,'label' => $label,'vertical' => $isVertical,'xCloak' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['contained' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isContained),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'vertical' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isVertical),'x-cloak' => true]); ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getStartRenderHooks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $startRenderHook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook($startRenderHook, scopes: $renderHookScopes)); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getChildSchema()->getComponents(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $tabKey = $tab->getKey(isAbsolute: false);
                    $tabBadge = $tab->getBadge();
                    $tabBadgeColor = $tab->getBadgeColor();
                    $tabBadgeIcon = $tab->getBadgeIcon();
                    $tabBadgeIconPosition = $tab->getBadgeIconPosition();
                    $tabBadgeTooltip = $tab->getBadgeTooltip();
                    $tabIcon = $tab->getIcon();
                    $tabIconPosition = $tab->getIconPosition();
                    $tabExtraAttributeBag = $tab->getExtraAttributeBag();
                    $tabHiddenJs = $tab->getHiddenJs();
                    $tabVisibleJs = $tab->getVisibleJs();
                    $tabVisibilityJs = match ([filled($tabHiddenJs), filled($tabVisibleJs)]) {
                        [true, true] => "(! ({$tabHiddenJs})) && ({$tabVisibleJs})",
                        [true, false] => "! ({$tabHiddenJs})",
                        [false, true] => $tabVisibleJs,
                        default => null,
                    };
                ?>

                <?php if (isset($component)) { $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.item','data' => ['alpineActive' => 'tab === \'' . $tabKey . '\'','badge' => $tabBadge,'badgeColor' => $tabBadgeColor,'badgeIcon' => $tabBadgeIcon,'badgeIconPosition' => $tabBadgeIconPosition,'badgeTooltip' => $tabBadgeTooltip,'icon' => $tabIcon,'iconPosition' => $tabIconPosition,'xOn:click' => 'tab = \'' . $tabKey . '\'','xShow' => $tabVisibilityJs,'xCloak' => $tabVisibilityJs !== null,'attributes' => $tabExtraAttributeBag]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::tabs.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alpine-active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('tab === \'' . $tabKey . '\''),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadge),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeColor),'badge-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeIcon),'badge-icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeIconPosition),'badge-tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeTooltip),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabIcon),'icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabIconPosition),'x-on:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('tab = \'' . $tabKey . '\''),'x-show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabVisibilityJs),'x-cloak' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabVisibilityJs !== null),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabExtraAttributeBag)]); ?>
                    <?php echo e($tab->getLabel()); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $attributes = $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $component = $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getEndRenderHooks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $endRenderHook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook($endRenderHook, scopes: $renderHookScopes)); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $attributes = $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $component = $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>

        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getChildSchema()->getComponents(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $tabHiddenJs = $tab->getHiddenJs();
                $tabVisibleJs = $tab->getVisibleJs();
                $tabVisibilityJs = match ([filled($tabHiddenJs), filled($tabVisibleJs)]) {
                    [true, true] => "(! ({$tabHiddenJs})) && ({$tabVisibleJs})",
                    [true, false] => "! ({$tabHiddenJs})",
                    [false, true] => $tabVisibleJs,
                    default => null,
                };
            ?>

            <!--[if BLOCK]><![endif]--><?php if($tabVisibilityJs): ?>
                <div x-show="<?php echo $tabVisibilityJs; ?>" x-cloak>
                    <?php echo e($tab); ?>

                </div>
            <?php else: ?>
                <?php echo e($tab); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
<?php else: ?>
    <?php
        $activeTab = strval($this->{$livewireProperty});
    ?>

    <div
        <?php echo e($attributes
                ->merge([
                    'id' => $id,
                    'wire:key' => $getLivewireKey() . '.container',
                ], escape: false)
                ->merge($getExtraAttributes(), escape: false)
                ->class([
                    'fi-sc-tabs',
                    'fi-contained' => $isContained,
                    'fi-vertical' => $isVertical,
                ])); ?>

    >
        <?php if (isset($component)) { $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.index','data' => ['contained' => $isContained,'label' => $label,'vertical' => $isVertical]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['contained' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isContained),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'vertical' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isVertical)]); ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getStartRenderHooks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $startRenderHook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook($startRenderHook, scopes: $renderHookScopes)); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <?php $__currentLoopData = $getChildSchema()->getComponents(withOriginalKeys: true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabKey => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $tabBadge = $tab->getBadge();
                    $tabBadgeColor = $tab->getBadgeColor();
                    $tabBadgeIcon = $tab->getBadgeIcon();
                    $tabBadgeIconPosition = $tab->getBadgeIconPosition();
                    $tabBadgeTooltip = $tab->getBadgeTooltip();
                    $tabIcon = $tab->getIcon();
                    $tabIconPosition = $tab->getIconPosition();
                    $tabExtraAttributeBag = $tab->getExtraAttributeBag();
                    $tabKey = strval($tabKey);
                ?>

                <?php if (isset($component)) { $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.item','data' => ['active' => $activeTab === $tabKey,'badge' => $tabBadge,'badgeColor' => $tabBadgeColor,'badgeIcon' => $tabBadgeIcon,'badgeIconPosition' => $tabBadgeIconPosition,'badgeTooltip' => $tabBadgeTooltip,'icon' => $tabIcon,'iconPosition' => $tabIconPosition,'wire:click' => '$set(\'' . $livewireProperty . '\', ' . (filled($tabKey) ? ('\'' . $tabKey . '\'') : 'null') . ')','attributes' => $tabExtraAttributeBag]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::tabs.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab === $tabKey),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadge),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeColor),'badge-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeIcon),'badge-icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeIconPosition),'badge-tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabBadgeTooltip),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabIcon),'icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabIconPosition),'wire:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('$set(\'' . $livewireProperty . '\', ' . (filled($tabKey) ? ('\'' . $tabKey . '\'') : 'null') . ')'),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabExtraAttributeBag)]); ?>
                    <?php echo e($tab->getLabel() ?? $this->generateTabLabel($tabKey)); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $attributes = $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $component = $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getEndRenderHooks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $endRenderHook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook($endRenderHook, scopes: $renderHookScopes)); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $attributes = $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $component = $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>

        <?php $__currentLoopData = $getChildSchema()->getComponents(withOriginalKeys: true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabKey => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($tab->key($tabKey)); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/filament/schemas/resources/views/components/tabs.blade.php ENDPATH**/ ?>