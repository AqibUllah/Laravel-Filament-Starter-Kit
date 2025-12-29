<?php
    use Filament\Support\Enums\Alignment;

    $fieldWrapperView = $getFieldWrapperView();
    $id = $getId();
    $imageCropAspectRatio = $getImageCropAspectRatio();
    $imageResizeTargetHeight = $getImageResizeTargetHeight();
    $imageResizeTargetWidth = $getImageResizeTargetWidth();
    $isAvatar = $isAvatar();
    $isMultiple = $isMultiple();
    $key = $getKey();
    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
    $hasImageEditor = $hasImageEditor();
    $hasCircleCropper = $hasCircleCropper();
    $livewireKey = $getLivewireKey();

    $alignment = $getAlignment() ?? Alignment::Start;

    if (! $alignment instanceof Alignment) {
        $alignment = filled($alignment) ? (Alignment::tryFrom($alignment) ?? $alignment) : null;
    }
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
<?php $component->withAttributes(['field' => $field,'label-tag' => 'div']); ?>
    <div
        x-load
        x-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('file-upload', 'filament/forms')); ?>"
        x-data="fileUploadFormComponent({
                    acceptedFileTypes: <?php echo \Illuminate\Support\Js::from($getAcceptedFileTypes())->toHtml() ?>,
                    imageEditorEmptyFillColor: <?php echo \Illuminate\Support\Js::from($getImageEditorEmptyFillColor())->toHtml() ?>,
                    imageEditorMode: <?php echo \Illuminate\Support\Js::from($getImageEditorMode())->toHtml() ?>,
                    imageEditorViewportHeight: <?php echo \Illuminate\Support\Js::from($getImageEditorViewportHeight())->toHtml() ?>,
                    imageEditorViewportWidth: <?php echo \Illuminate\Support\Js::from($getImageEditorViewportWidth())->toHtml() ?>,
                    deleteUploadedFileUsing: async (fileKey) => {
                        return await $wire.callSchemaComponentMethod(
                            <?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>,
                            'deleteUploadedFile',
                            { fileKey },
                        )
                    },
                    getUploadedFilesUsing: async () => {
                        return await $wire.callSchemaComponentMethod(
                            <?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>,
                            'getUploadedFiles',
                        )
                    },
                    hasImageEditor: <?php echo \Illuminate\Support\Js::from($hasImageEditor)->toHtml() ?>,
                    hasCircleCropper: <?php echo \Illuminate\Support\Js::from($hasCircleCropper)->toHtml() ?>,
                    canEditSvgs: <?php echo \Illuminate\Support\Js::from($canEditSvgs())->toHtml() ?>,
                    isSvgEditingConfirmed: <?php echo \Illuminate\Support\Js::from($isSvgEditingConfirmed())->toHtml() ?>,
                    confirmSvgEditingMessage: <?php echo \Illuminate\Support\Js::from(__('filament-forms::components.file_upload.editor.svg.messages.confirmation'))->toHtml() ?>,
                    disabledSvgEditingMessage: <?php echo \Illuminate\Support\Js::from(__('filament-forms::components.file_upload.editor.svg.messages.disabled'))->toHtml() ?>,
                    imageCropAspectRatio: <?php echo \Illuminate\Support\Js::from($imageCropAspectRatio)->toHtml() ?>,
                    imagePreviewHeight: <?php echo \Illuminate\Support\Js::from($getImagePreviewHeight())->toHtml() ?>,
                    imageResizeMode: <?php echo \Illuminate\Support\Js::from($getImageResizeMode())->toHtml() ?>,
                    imageResizeTargetHeight: <?php echo \Illuminate\Support\Js::from($imageResizeTargetHeight)->toHtml() ?>,
                    imageResizeTargetWidth: <?php echo \Illuminate\Support\Js::from($imageResizeTargetWidth)->toHtml() ?>,
                    imageResizeUpscale: <?php echo \Illuminate\Support\Js::from($getImageResizeUpscale())->toHtml() ?>,
                    isAvatar: <?php echo \Illuminate\Support\Js::from($isAvatar)->toHtml() ?>,
                    isDeletable: <?php echo \Illuminate\Support\Js::from($isDeletable())->toHtml() ?>,
                    isDisabled: <?php echo \Illuminate\Support\Js::from($isDisabled)->toHtml() ?>,
                    isDownloadable: <?php echo \Illuminate\Support\Js::from($isDownloadable())->toHtml() ?>,
                    isMultiple: <?php echo \Illuminate\Support\Js::from($isMultiple)->toHtml() ?>,
                    isOpenable: <?php echo \Illuminate\Support\Js::from($isOpenable())->toHtml() ?>,
                    isPasteable: <?php echo \Illuminate\Support\Js::from($isPasteable())->toHtml() ?>,
                    isPreviewable: <?php echo \Illuminate\Support\Js::from($isPreviewable())->toHtml() ?>,
                    isReorderable: <?php echo \Illuminate\Support\Js::from($isReorderable())->toHtml() ?>,
                    itemPanelAspectRatio: <?php echo \Illuminate\Support\Js::from($getItemPanelAspectRatio())->toHtml() ?>,
                    loadingIndicatorPosition: <?php echo \Illuminate\Support\Js::from($getLoadingIndicatorPosition())->toHtml() ?>,
                    locale: <?php echo \Illuminate\Support\Js::from(app()->getLocale())->toHtml() ?>,
                    panelAspectRatio: <?php echo \Illuminate\Support\Js::from($getPanelAspectRatio())->toHtml() ?>,
                    panelLayout: <?php echo \Illuminate\Support\Js::from($getPanelLayout())->toHtml() ?>,
                    placeholder: <?php echo \Illuminate\Support\Js::from($getPlaceholder())->toHtml() ?>,
                    maxFiles: <?php echo \Illuminate\Support\Js::from($maxFiles = $getMaxFiles())->toHtml() ?>,
                    maxFilesValidationMessage: <?php echo \Illuminate\Support\Js::from($maxFiles ? trans_choice('validation.max.array', $maxFiles, ['attribute' => $getValidationAttribute(), 'max' => $maxFiles]) : null)->toHtml() ?>,
                    maxSize: <?php echo \Illuminate\Support\Js::from(($size = $getMaxSize()) ? "{$size}KB" : null)->toHtml() ?>,
                    minSize: <?php echo \Illuminate\Support\Js::from(($size = $getMinSize()) ? "{$size}KB" : null)->toHtml() ?>,
                    mimeTypeMap: <?php echo \Illuminate\Support\Js::from($getMimeTypeMap())->toHtml() ?>,
                    maxParallelUploads: <?php echo \Illuminate\Support\Js::from($getMaxParallelUploads())->toHtml() ?>,
                    removeUploadedFileUsing: async (fileKey) => {
                        return await $wire.callSchemaComponentMethod(
                            <?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>,
                            'removeUploadedFile',
                            { fileKey },
                        )
                    },
                    removeUploadedFileButtonPosition: <?php echo \Illuminate\Support\Js::from($getRemoveUploadedFileButtonPosition())->toHtml() ?>,
                    reorderUploadedFilesUsing: async (fileKeys) => {
                        return await $wire.callSchemaComponentMethod(
                            <?php echo \Illuminate\Support\Js::from($key)->toHtml() ?>,
                            'reorderUploadedFiles',
                            { fileKeys },
                        )
                    },
                    shouldAppendFiles: <?php echo \Illuminate\Support\Js::from($shouldAppendFiles())->toHtml() ?>,
                    shouldOrientImageFromExif: <?php echo \Illuminate\Support\Js::from($shouldOrientImagesFromExif())->toHtml() ?>,
                    shouldTransformImage: <?php echo \Illuminate\Support\Js::from($imageCropAspectRatio || $imageResizeTargetHeight || $imageResizeTargetWidth)->toHtml() ?>,
                    state: $wire.<?php echo e($applyStateBindingModifiers("\$entangle('{$statePath}')")); ?>,
                    uploadButtonPosition: <?php echo \Illuminate\Support\Js::from($getUploadButtonPosition())->toHtml() ?>,
                    uploadingMessage: <?php echo \Illuminate\Support\Js::from($getUploadingMessage())->toHtml() ?>,
                    uploadProgressIndicatorPosition: <?php echo \Illuminate\Support\Js::from($getUploadProgressIndicatorPosition())->toHtml() ?>,
                    uploadUsing: (fileKey, file, success, error, progress) => {
                        $wire.upload(
                            `<?php echo e($statePath); ?>.${fileKey}`,
                            file,
                            () => {
                                success(fileKey)
                            },
                            error,
                            (progressEvent) => {
                                progress(true, progressEvent.detail.progress, 100)
                            },
                        )
                    },
                })"
        wire:ignore
        wire:key="<?php echo e($livewireKey); ?>.<?php echo e(substr(md5(serialize([
                $isDisabled,
            ])), 0, 64)); ?>"
        <?php echo e($attributes
                ->merge([
                    'aria-labelledby' => "{$id}-label",
                    'id' => $id,
                    'role' => 'group',
                ], escape: false)
                ->merge($getExtraAttributes(), escape: false)
                ->merge($getExtraAlpineAttributes(), escape: false)
                ->class([
                    'fi-fo-file-upload',
                    'fi-fo-file-upload-avatar' => $isAvatar,
                    ($alignment instanceof Alignment) ? "fi-align-{$alignment->value}" : $alignment,
                ])); ?>

    >
        <div class="fi-fo-file-upload-input-ctn">
            <input
                x-ref="input"
                <?php echo e($getExtraInputAttributeBag()
                        ->merge([
                            'aria-labelledby' => "{$id}-label",
                            'disabled' => $isDisabled,
                            'multiple' => $isMultiple,
                            'type' => 'file',
                        ], escape: false)); ?>

            />
        </div>

        <div
            x-show="error"
            x-text="error"
            x-cloak
            class="fi-fo-file-upload-error-message"
        ></div>

        <!--[if BLOCK]><![endif]--><?php if($hasImageEditor && (! $isDisabled)): ?>
            <div
                x-show="isEditorOpen"
                x-cloak
                x-on:click.stop=""
                x-trap.noscroll="isEditorOpen"
                x-on:keydown.escape.prevent.stop="closeEditor"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'fi-fo-file-upload-editor',
                    'fi-fo-file-upload-editor-circle-cropper' => $hasCircleCropper,
                ]); ?>"
            >
                <div
                    aria-hidden="true"
                    class="fi-fo-file-upload-editor-overlay"
                ></div>

                <div class="fi-fo-file-upload-editor-window">
                    <div class="fi-fo-file-upload-editor-image-ctn">
                        <img
                            x-ref="editor"
                            class="fi-fo-file-upload-editor-image"
                        />
                    </div>

                    <div class="fi-fo-file-upload-editor-control-panel">
                        <div
                            class="fi-fo-file-upload-editor-control-panel-main"
                        >
                            <div
                                class="fi-fo-file-upload-editor-control-panel-group"
                            >
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = [
                                    [
                                        'label' => __('filament-forms::components.file_upload.editor.fields.x_position.label'),
                                        'ref' => 'xPositionInput',
                                        'unit' => __('filament-forms::components.file_upload.editor.fields.x_position.unit'),
                                        'alpineSaveHandler' => 'editor.setData({...editor.getData(true), x: +$el.value})',
                                    ],
                                    [
                                        'label' => __('filament-forms::components.file_upload.editor.fields.y_position.label'),
                                        'ref' => 'yPositionInput',
                                        'unit' => __('filament-forms::components.file_upload.editor.fields.y_position.unit'),
                                        'alpineSaveHandler' => 'editor.setData({...editor.getData(true), y: +$el.value})',
                                    ],
                                    [
                                        'label' => __('filament-forms::components.file_upload.editor.fields.width.label'),
                                        'ref' => 'widthInput',
                                        'unit' => __('filament-forms::components.file_upload.editor.fields.width.unit'),
                                        'alpineSaveHandler' => 'editor.setData({...editor.getData(true), width: +$el.value})',
                                    ],
                                    [
                                        'label' => __('filament-forms::components.file_upload.editor.fields.height.label'),
                                        'ref' => 'heightInput',
                                        'unit' => __('filament-forms::components.file_upload.editor.fields.height.unit'),
                                        'alpineSaveHandler' => 'editor.setData({...editor.getData(true), height: +$el.value})',
                                    ],
                                    [
                                        'label' => __('filament-forms::components.file_upload.editor.fields.rotation.label'),
                                        'ref' => 'rotationInput',
                                        'unit' => __('filament-forms::components.file_upload.editor.fields.rotation.unit'),
                                        'alpineSaveHandler' => 'editor.rotateTo(+$el.value)',
                                    ],
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label>
                                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                             <?php $__env->slot('prefix', null, []); ?> 
                                                <?php echo e($input['label']); ?>

                                             <?php $__env->endSlot(); ?>

                                            <input
                                                x-on:keyup.enter.prevent.stop="editor && <?php echo $input['alpineSaveHandler']; ?>"
                                                x-on:blur="editor && <?php echo $input['alpineSaveHandler']; ?>"
                                                x-ref="<?php echo e($input['ref']); ?>"
                                                x-on:keydown.enter.prevent
                                                type="text"
                                                class="fi-input"
                                            />

                                             <?php $__env->slot('suffix', null, []); ?> 
                                                <?php echo e($input['unit']); ?>

                                             <?php $__env->endSlot(); ?>
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
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div
                                class="fi-fo-file-upload-editor-control-panel-group"
                            >
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getImageEditorActions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupedActions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="fi-btn-group">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $groupedActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button
                                                aria-label="<?php echo e($action['label']); ?>"
                                                type="button"
                                                x-on:click.prevent.stop="<?php echo e($action['alpineClickHandler']); ?>"
                                                x-tooltip="{ content: <?php echo \Illuminate\Support\Js::from($action['label'])->toHtml() ?>, theme: $store.theme }"
                                                class="fi-btn"
                                            >
                                                <?php echo e($action['iconHtml']); ?>

                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if(count($aspectRatios = $getImageEditorAspectRatiosForJs())): ?>
                                <div
                                    class="fi-fo-file-upload-editor-control-panel-group"
                                >
                                    <div
                                        class="fi-fo-file-upload-editor-control-panel-group-title"
                                    >
                                        <?php echo e(__('filament-forms::components.file_upload.editor.aspect_ratios.label')); ?>

                                    </div>

                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = collect($aspectRatios)->chunk(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ratiosChunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="fi-btn-group">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ratiosChunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $ratio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <button
                                                    type="button"
                                                    x-on:click.prevent.stop="
                                                        currentRatio = <?php echo \Illuminate\Support\Js::from($label)->toHtml() ?> <?php echo ';'; ?>

                                                        editor.setAspectRatio(<?php echo \Illuminate\Support\Js::from($ratio)->toHtml() ?>)
                                                    "
                                                    x-tooltip="{ content: <?php echo \Illuminate\Support\Js::from(__('filament-forms::components.file_upload.editor.actions.set_aspect_ratio.label', ['ratio' => $label]))->toHtml() ?>, theme: $store.theme }"
                                                    x-bind:class="{ 'fi-active': currentRatio === <?php echo \Illuminate\Support\Js::from($label)->toHtml() ?> }"
                                                    class="fi-btn"
                                                >
                                                    <?php echo e($label); ?>

                                                </button>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div
                            class="fi-fo-file-upload-editor-control-panel-footer"
                        >
                            <button
                                type="button"
                                x-on:click.prevent="pond.imageEditEditor.oncancel"
                                class="fi-btn"
                            >
                                <?php echo e(__('filament-forms::components.file_upload.editor.actions.cancel.label')); ?>

                            </button>

                            <button
                                type="button"
                                x-on:click.prevent.stop="editor.reset()"
                                <?php echo e((new \Illuminate\View\ComponentAttributeBag)
                                        ->color(\Filament\Support\View\Components\ButtonComponent::class, 'danger')
                                        ->class(['fi-btn fi-fo-file-upload-editor-control-panel-reset-action'])); ?>

                            >
                                <?php echo e(__('filament-forms::components.file_upload.editor.actions.reset.label')); ?>

                            </button>

                            <button
                                type="button"
                                x-on:click.prevent="saveEditor"
                                <?php echo e((new \Illuminate\View\ComponentAttributeBag)
                                        ->color(\Filament\Support\View\Components\ButtonComponent::class, 'success')
                                        ->class(['fi-btn'])); ?>

                            >
                                <?php echo e(__('filament-forms::components.file_upload.editor.actions.save.label')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
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
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/filament/forms/resources/views/components/file-upload.blade.php ENDPATH**/ ?>