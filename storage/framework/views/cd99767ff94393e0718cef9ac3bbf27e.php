<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'applyAction',
    'columns' => null,
    'hasReorderableColumns',
    'hasToggleableColumns',
    'headingTag' => 'h3',
    'reorderAnimationDuration' => 300,
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
    'applyAction',
    'columns' => null,
    'hasReorderableColumns',
    'hasToggleableColumns',
    'headingTag' => 'h3',
    'reorderAnimationDuration' => 300,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use Filament\Support\Enums\GridDirection;
    use Illuminate\View\ComponentAttributeBag;
?>

<div class="fi-ta-col-manager">
    <div
        x-data="filamentTableColumnManager({
                    columns: $wire.entangle('tableColumns'),
                    isLive: <?php echo e($applyAction->isVisible() ? 'false' : 'true'); ?>,
                })"
        class="fi-ta-col-manager-ctn"
    >
        <div class="fi-ta-col-manager-header">
            <<?php echo e($headingTag); ?> class="fi-ta-col-manager-heading">
                <?php echo e(__('filament-tables::table.column_manager.heading')); ?>

            </<?php echo e($headingTag); ?>>

            <div>
                <?php if (isset($component)) { $__componentOriginal549c94d872270b69c72bdf48cb183bc9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal549c94d872270b69c72bdf48cb183bc9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.link','data' => ['attributes' => 
                        \Filament\Support\prepare_inherited_attributes(
                            new ComponentAttributeBag([
                                'color' => 'danger',
                                'tag' => 'button',
                                'wire:click' => 'resetTableColumnManager',
                                'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => '',
                                'wire:target' => 'resetTableColumnManager',
                            ])
                        )
                    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                        \Filament\Support\prepare_inherited_attributes(
                            new ComponentAttributeBag([
                                'color' => 'danger',
                                'tag' => 'button',
                                'wire:click' => 'resetTableColumnManager',
                                'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => '',
                                'wire:target' => 'resetTableColumnManager',
                            ])
                        )
                    )]); ?>
                    <?php echo e(__('filament-tables::table.column_manager.actions.reset.label')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal549c94d872270b69c72bdf48cb183bc9)): ?>
<?php $attributes = $__attributesOriginal549c94d872270b69c72bdf48cb183bc9; ?>
<?php unset($__attributesOriginal549c94d872270b69c72bdf48cb183bc9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal549c94d872270b69c72bdf48cb183bc9)): ?>
<?php $component = $__componentOriginal549c94d872270b69c72bdf48cb183bc9; ?>
<?php unset($__componentOriginal549c94d872270b69c72bdf48cb183bc9); ?>
<?php endif; ?>
            </div>
        </div>

        <div
            <?php if($hasReorderableColumns): ?>
                x-sortable
                x-on:end.stop="reorderColumns($event.target.sortable.toArray())"
                data-sortable-animation-duration="<?php echo e($reorderAnimationDuration); ?>"
            <?php endif; ?>
            <?php echo e((new ComponentAttributeBag)
                    ->grid($columns, GridDirection::Column)
                    ->class(['fi-ta-col-manager-items'])); ?>

        >
            <template
                x-for="(column, index) in columns.filter((column) => ! column.isHidden && column.label)"
                x-bind:key="(column.type === 'group' ? 'group::' : 'column::') + column.name + '_' + index"
            >
                <div
                    <?php if($hasReorderableColumns): ?>
                        x-bind:x-sortable-item="column.type === 'group' ? 'group::' + column.name : 'column::' + column.name"
                    <?php endif; ?>
                >
                    <template x-if="column.type === 'group'">
                        <div class="fi-ta-col-manager-group">
                            <div class="fi-ta-col-manager-item">
                                <label class="fi-ta-col-manager-label">
                                    <!--[if BLOCK]><![endif]--><?php if($hasToggleableColumns): ?>
                                        <input
                                            type="checkbox"
                                            class="fi-checkbox-input fi-valid"
                                            x-bind:id="'group-' + column.name"
                                            x-bind:checked="(groupedColumns[column.name] || {}).checked || false"
                                            x-bind:disabled="(groupedColumns[column.name] || {}).disabled || false"
                                            x-effect="$el.indeterminate = (groupedColumns[column.name] || {}).indeterminate || false"
                                            x-on:change="toggleGroup(column.name)"
                                        />
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <span x-html="column.label"></span>
                                </label>

                                <!--[if BLOCK]><![endif]--><?php if($hasReorderableColumns): ?>
                                    <button
                                        x-sortable-handle
                                        x-on:click.stop
                                        class="fi-ta-col-manager-reorder-handle fi-icon-btn"
                                        type="button"
                                    >
                                        <?php echo e(\Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::Bars2, alias: \Filament\Tables\View\TablesIconAlias::REORDER_HANDLE)); ?>

                                    </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div
                                <?php if($hasReorderableColumns): ?>
                                    x-sortable
                                    x-on:end.stop="reorderGroupColumns($event.target.sortable.toArray(), column.name)"
                                    data-sortable-animation-duration="<?php echo e($reorderAnimationDuration); ?>"
                                <?php endif; ?>
                                class="fi-ta-col-manager-group-items"
                            >
                                <template
                                    x-for="
                                        (groupColumn, index) in
                                            column.columns.filter((column) => ! column.isHidden && column.label)
                                    "
                                    x-bind:key="'column::' + groupColumn.name + '_' + index"
                                >
                                    <div
                                        <?php if($hasReorderableColumns): ?>
                                            x-bind:x-sortable-item="'column::' + groupColumn.name"
                                        <?php endif; ?>
                                    >
                                        <div class="fi-ta-col-manager-item">
                                            <label
                                                class="fi-ta-col-manager-label"
                                            >
                                                <!--[if BLOCK]><![endif]--><?php if($hasToggleableColumns): ?>
                                                    <input
                                                        type="checkbox"
                                                        class="fi-checkbox-input fi-valid"
                                                        x-bind:id="'column-' + groupColumn.name.replace('.', '-')"
                                                        x-bind:checked="(getColumn(groupColumn.name, column.name) || {}).isToggled || false"
                                                        x-bind:disabled="(getColumn(groupColumn.name, column.name) || {}).isToggleable === false"
                                                        x-on:change="toggleColumn(groupColumn.name, column.name)"
                                                    />
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                <span
                                                    x-html="groupColumn.label"
                                                ></span>
                                            </label>

                                            <!--[if BLOCK]><![endif]--><?php if($hasReorderableColumns): ?>
                                                <button
                                                    x-sortable-handle
                                                    x-on:click.stop
                                                    class="fi-ta-col-manager-reorder-handle fi-icon-btn"
                                                    type="button"
                                                >
                                                    <?php echo e(\Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::Bars2, alias: \Filament\Tables\View\TablesIconAlias::REORDER_HANDLE)); ?>

                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    <template x-if="column.type !== 'group'">
                        <div class="fi-ta-col-manager-item">
                            <label class="fi-ta-col-manager-label">
                                <!--[if BLOCK]><![endif]--><?php if($hasToggleableColumns): ?>
                                    <input
                                        type="checkbox"
                                        class="fi-checkbox-input fi-valid"
                                        x-bind:id="'column-' + column.name.replace('.', '-')"
                                        x-bind:checked="(getColumn(column.name, null) || {}).isToggled || false"
                                        x-bind:disabled="(getColumn(column.name, null) || {}).isToggleable === false"
                                        x-on:change="toggleColumn(column.name)"
                                    />
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <span x-html="column.label"></span>
                            </label>

                            <!--[if BLOCK]><![endif]--><?php if($hasReorderableColumns): ?>
                                <button
                                    x-sortable-handle
                                    x-on:click.stop
                                    class="fi-ta-col-manager-reorder-handle fi-icon-btn"
                                    type="button"
                                >
                                    <?php echo e(\Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::Bars2, alias: \Filament\Tables\View\TablesIconAlias::REORDER_HANDLE)); ?>

                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($applyAction->isVisible()): ?>
            <div class="fi-ta-col-manager-apply-action-ctn">
                <?php echo e($applyAction); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/filament/tables/resources/views/components/column-manager.blade.php ENDPATH**/ ?>