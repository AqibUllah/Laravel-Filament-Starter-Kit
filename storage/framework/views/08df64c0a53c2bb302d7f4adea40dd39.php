<?php
    use \Illuminate\Support\Js;
?>
<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="space-y-6">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getActivities(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activityItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
                /* @var \Spatie\Activitylog\Models\Activity $activityItem */
                $changes = $activityItem->getChangesAttribute();
            ?>

            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'p-2 space-y-2 bg-white rounded-xl shadow',
                'dark:border-gray-600 dark:bg-gray-800',
            ]); ?>">
                <div class="p-2">
                    <div class="flex justify-between">
                        <div class="flex items-center gap-4">
                            <!--[if BLOCK]><![endif]--><?php if($activityItem->causer): ?>
                                <?php if (isset($component)) { $__componentOriginalceea4679a368984135244eacf4aafeca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalceea4679a368984135244eacf4aafeca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.avatar.user','data' => ['user' => $activityItem->causer,'class' => '!w-7 !h-7']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::avatar.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activityItem->causer),'class' => '!w-7 !h-7']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalceea4679a368984135244eacf4aafeca)): ?>
<?php $attributes = $__attributesOriginalceea4679a368984135244eacf4aafeca; ?>
<?php unset($__attributesOriginalceea4679a368984135244eacf4aafeca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalceea4679a368984135244eacf4aafeca)): ?>
<?php $component = $__componentOriginalceea4679a368984135244eacf4aafeca; ?>
<?php unset($__componentOriginalceea4679a368984135244eacf4aafeca); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="flex flex-col text-start">
                                <span class="font-bold"><?php echo e($activityItem->causer?->name); ?></span>
                                <span class="text-xs text-gray-500">
                                    <?php echo e(__('filament-activity-log::activities.events.' . $activityItem->event)); ?> <?php echo e($activityItem->created_at->format(__('filament-activity-log::activities.default_datetime_format'))); ?>

                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col text-xs text-gray-500 justify-end">
                            <!--[if BLOCK]><![endif]--><?php if($this->canRestoreActivity() && $changes->isNotEmpty()): ?>
                                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['tag' => 'button','icon' => 'heroicon-o-arrow-path-rounded-square','labeledFrom' => 'sm','color' => 'gray','class' => 'right','wire:click' => 'restoreActivity('.e(Js::from($activityItem->getKey())).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'button','icon' => 'heroicon-o-arrow-path-rounded-square','labeled-from' => 'sm','color' => 'gray','class' => 'right','wire:click' => 'restoreActivity('.e(Js::from($activityItem->getKey())).')']); ?>
                                    <?php echo app('translator')->get('filament-activity-log::activities.table.restore'); ?>
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
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($changes->isNotEmpty()): ?>
                    <table class="fi-ta-table w-full overflow-hidden text-sm">
                        <thead>
                            <th class="fi-ta-header-cell">
                                <?php echo e(__('filament-activity-log::activities.table.field')); ?>

                            </th>
                            <th class="fi-ta-header-cell">
                                <?php echo e(__('filament-activity-log::activities.table.old')); ?>

                            </th>
                            <th class="fi-ta-header-cell">
                                <?php echo e(__('filament-activity-log::activities.table.new')); ?>

                            </th>
                        </thead>

                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = data_get($changes, 'attributes', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $change): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $oldValue = isset($changes['old'][$field]) ? $changes['old'][$field] : '';
                                    $newValue = isset($changes['attributes'][$field]) ? $changes['attributes'][$field] : '';
                                ?>
                            <tr
                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'fi-ta-row',
                                    'bg-gray-100/30' => $loop->even
                                ]); ?>"
                            >
                                <td class="fi-ta-cell px-4 py-2 align-top sm:first-of-type:ps-6 sm:last-of-type:pe-6" width="20%">
                                    <?php echo e($this->getFieldLabel($field)); ?>

                                </td>
                                <td width="40%" class="fi-ta-cell px-4 py-2 align-top break-all whitespace-normal">
                                    <!--[if BLOCK]><![endif]--><?php if(is_array($oldValue)): ?>
                                        <pre class="text-xs text-gray-500"><?php echo e(json_encode($oldValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>
                                    <?php else: ?>
                                        <?php echo e($oldValue); ?>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td width="40%" class="fi-ta-cell px-4 py-2 align-top break-all whitespace-normal">
                                    <!--[if BLOCK]><![endif]--><?php if(is_bool($newValue)): ?>
                                        <span class="text-xs text-gray-500"><?php echo e($newValue ? 'true' : 'false'); ?></span>
                                    <?php elseif(is_array($newValue)): ?>
                                        <pre class="text-xs text-gray-500"><?php echo e(json_encode($newValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>
                                    <?php else: ?>
                                        <?php echo e($newValue); ?>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        <?php if (isset($component)) { $__componentOriginal0c287a00f29f01c8f977078ff96faed4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c287a00f29f01c8f977078ff96faed4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.pagination.index','data' => ['currentPageOptionProperty' => 'recordsPerPage','pageOptions' => $this->getRecordsPerPageSelectOptions(),'paginator' => $this->getActivities()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['currentPageOptionProperty' => 'recordsPerPage','page-options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getRecordsPerPageSelectOptions()),'paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getActivities())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c287a00f29f01c8f977078ff96faed4)): ?>
<?php $attributes = $__attributesOriginal0c287a00f29f01c8f977078ff96faed4; ?>
<?php unset($__attributesOriginal0c287a00f29f01c8f977078ff96faed4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c287a00f29f01c8f977078ff96faed4)): ?>
<?php $component = $__componentOriginal0c287a00f29f01c8f977078ff96faed4; ?>
<?php unset($__componentOriginal0c287a00f29f01c8f977078ff96faed4); ?>
<?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/pxlrbt/filament-activity-log/resources/views/pages/list-activities.blade.php ENDPATH**/ ?>