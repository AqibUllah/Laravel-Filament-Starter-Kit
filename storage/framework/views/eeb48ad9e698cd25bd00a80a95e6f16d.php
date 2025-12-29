<?php
    $fieldWrapperView = $getFieldWrapperView();
    $extraInputAttributeBag = $getExtraInputAttributeBag();
    $canSelectPlaceholder = $canSelectPlaceholder();
    $isAutofocused = $isAutofocused();
    $isDisabled = $isDisabled();
    $isMultiple = $isMultiple();
    $isSearchable = $isSearchable();
    $canOptionLabelsWrap = $canOptionLabelsWrap();
    $isRequired = $isRequired();
    $isConcealed = $isConcealed();
    $isHtmlAllowed = $isHtmlAllowed();
    $isNative = (! ($isSearchable || $isMultiple) && $isNative());
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $key = $getKey();
    $id = $getId();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixIconColor = $getPrefixIconColor();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixIconColor = $getSuffixIconColor();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
    $state = $getState();
    $livewireKey = $getLivewireKey();
?>

<?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $fieldWrapperView] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field' => $field,'class' => 'fi-fo-select-wrp']); ?>
    <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['disabled' => $isDisabled,'inlinePrefix' => $isPrefixInline,'inlineSuffix' => $isSuffixInline,'prefix' => $prefixLabel,'prefixActions' => $prefixActions,'prefixIcon' => $prefixIcon,'prefixIconColor' => $prefixIconColor,'suffix' => $suffixLabel,'suffixActions' => $suffixActions,'suffixIcon' => $suffixIcon,'suffixIconColor' => $suffixIconColor,'valid' => ! $errors->has($statePath),'attributes' => 
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class([
                    'fi-fo-select',
                    'fi-fo-select-has-inline-prefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                    'fi-fo-select-native' => $isNative,
                ])
        ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isDisabled),'inline-prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isPrefixInline),'inline-suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSuffixInline),'prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixLabel),'prefix-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixActions),'prefix-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixIcon),'prefix-icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixIconColor),'suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixLabel),'suffix-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixActions),'suffix-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixIcon),'suffix-icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixIconColor),'valid' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(! $errors->has($statePath)),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class([
                    'fi-fo-select',
                    'fi-fo-select-has-inline-prefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                    'fi-fo-select-native' => $isNative,
                ])
        )]); ?>
        <!--[if BLOCK]><![endif]--><?php if($isNative): ?>
            <select
                <?php echo e($extraInputAttributeBag
                        ->merge([
                            'autofocus' => $isAutofocused,
                            'disabled' => $isDisabled,
                            'id' => $id,
                            'required' => $isRequired && (! $isConcealed),
                            $applyStateBindingModifiers('wire:model') => $statePath,
                        ], escape: false)
                        ->class([
                            'fi-select-input',
                            'fi-select-input-has-inline-prefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        ])); ?>

            >
                <!--[if BLOCK]><![endif]--><?php if($canSelectPlaceholder): ?>
                    <option value="">
                        <!--[if BLOCK]><![endif]--><?php if(! $isDisabled): ?>
                            <?php echo e($getPlaceholder()); ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </option>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if(is_array($label)): ?>
                        <optgroup label="<?php echo e($value); ?>">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $label; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupedValue => $groupedLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    <?php if($isOptionDisabled($groupedValue, $groupedLabel)): echo 'disabled'; endif; ?>
                                    value="<?php echo e($groupedValue); ?>"
                                >
                                    <!--[if BLOCK]><![endif]--><?php if($isHtmlAllowed): ?>
                                        <?php echo $groupedLabel; ?>

                                    <?php else: ?>
                                        <?php echo e($groupedLabel); ?>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </optgroup>
                    <?php else: ?>
                        <option
                            <?php if($isOptionDisabled($value, $label)): echo 'disabled'; endif; ?>
                            value="<?php echo e($value); ?>"
                        >
                            <!--[if BLOCK]><![endif]--><?php if($isHtmlAllowed): ?>
                                <?php echo $label; ?>

                            <?php else: ?>
                                <?php echo e($label); ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </option>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        <?php else: ?>
            <div
                class="fi-hidden"
                x-data="{
                    isDisabled: <?php echo \Illuminate\Support\Js::from($isDisabled)->toHtml() ?>,
                    init() {
                        const container = $el.nextElementSibling
                        container.dispatchEvent(
                            new CustomEvent('set-select-property', {
                                detail: { isDisabled: this.isDisabled },
                            }),
                        )
                    },
                }"
            ></div>
            <div
                x-load
                x-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('select', 'filament/forms')); ?>"
                x-data="selectFormComponent({
                            canOptionLabelsWrap: <?php echo \Illuminate\Support\Js::from($canOptionLabelsWrap)->toHtml() ?>,
                            canSelectPlaceholder: <?php echo \Illuminate\Support\Js::from($canSelectPlaceholder)->toHtml() ?>,
                            isHtmlAllowed: <?php echo \Illuminate\Support\Js::from($isHtmlAllowed)->toHtml() ?>,
                            getOptionLabelUsing: async () => {
                                return await $wire.callSchemaComponentMethod(<?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>, 'getOptionLabel')
                            },
                            getOptionLabelsUsing: async () => {
                                return await $wire.callSchemaComponentMethod(
                                    <?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>,
                                    'getOptionLabelsForJs',
                                )
                            },
                            getOptionsUsing: async () => {
                                return await $wire.callSchemaComponentMethod(
                                    <?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>,
                                    'getOptionsForJs',
                                )
                            },
                            getSearchResultsUsing: async (search) => {
                                return await $wire.callSchemaComponentMethod(
                                    <?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>,
                                    'getSearchResultsForJs',
                                    { search },
                                )
                            },
                            initialOptionLabel: <?php echo \Illuminate\Support\Js::from((blank($state) || $isMultiple) ? null : $getOptionLabel())->toHtml() ?>,
                            initialOptionLabels: <?php echo \Illuminate\Support\Js::from((filled($state) && $isMultiple) ? $getOptionLabelsForJs() : [])->toHtml() ?>,
                            initialState: <?php echo \Illuminate\Support\Js::from($state)->toHtml() ?>,
                            isAutofocused: <?php echo \Illuminate\Support\Js::from($isAutofocused)->toHtml() ?>,
                            isDisabled: <?php echo \Illuminate\Support\Js::from($isDisabled)->toHtml() ?>,
                            isMultiple: <?php echo \Illuminate\Support\Js::from($isMultiple)->toHtml() ?>,
                            isSearchable: <?php echo \Illuminate\Support\Js::from($isSearchable)->toHtml() ?>,
                            livewireId: <?php echo \Illuminate\Support\Js::from($this->getId())->toHtml() ?>,
                            hasDynamicOptions: <?php echo \Illuminate\Support\Js::from($hasDynamicOptions())->toHtml() ?>,
                            hasDynamicSearchResults: <?php echo \Illuminate\Support\Js::from($hasDynamicSearchResults())->toHtml() ?>,
                            loadingMessage: <?php echo \Illuminate\Support\Js::from($getLoadingMessage())->toHtml() ?>,
                            maxItems: <?php echo \Illuminate\Support\Js::from($getMaxItems())->toHtml() ?>,
                            maxItemsMessage: <?php echo \Illuminate\Support\Js::from($getMaxItemsMessage())->toHtml() ?>,
                            noSearchResultsMessage: <?php echo \Illuminate\Support\Js::from($getNoSearchResultsMessage())->toHtml() ?>,
                            options: <?php echo \Illuminate\Support\Js::from($getOptionsForJs())->toHtml() ?>,
                            optionsLimit: <?php echo \Illuminate\Support\Js::from($getOptionsLimit())->toHtml() ?>,
                            placeholder: <?php echo \Illuminate\Support\Js::from($getPlaceholder())->toHtml() ?>,
                            position: <?php echo \Illuminate\Support\Js::from($getPosition())->toHtml() ?>,
                            searchDebounce: <?php echo \Illuminate\Support\Js::from($getSearchDebounce())->toHtml() ?>,
                            searchingMessage: <?php echo \Illuminate\Support\Js::from($getSearchingMessage())->toHtml() ?>,
                            searchPrompt: <?php echo \Illuminate\Support\Js::from($getSearchPrompt())->toHtml() ?>,
                            searchableOptionFields: <?php echo \Illuminate\Support\Js::from($getSearchableOptionFields())->toHtml() ?>,
                            state: $wire.<?php echo e($applyStateBindingModifiers("\$entangle('{$statePath}')")); ?>,
                            statePath: <?php echo \Illuminate\Support\Js::from($statePath)->toHtml() ?>,
                        })"
                wire:ignore
                wire:key="<?php echo e($livewireKey); ?>.<?php echo e(substr(md5(serialize([
                        $isDisabled,
                    ])), 0, 64)); ?>"
                x-on:keydown.esc="select.dropdown.isActive && $event.stopPropagation()"
                x-on:set-select-property="$event.detail.isDisabled ? select.disable() : select.enable()"
                <?php echo e($attributes
                        ->merge($getExtraAlpineAttributes(), escape: false)
                        ->class(['fi-select-input'])); ?>

            >
                <div x-ref="select"></div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/filament/forms/resources/views/components/select.blade.php ENDPATH**/ ?>