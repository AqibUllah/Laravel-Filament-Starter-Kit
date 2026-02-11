<!--[if BLOCK]><![endif]--><?php if($this instanceof \Filament\Actions\Contracts\HasActions && (! $this->hasActionsModalRendered)): ?>
    <div
        wire:partial="action-modals"
        x-data="filamentActionModals({
                    livewireId: <?php echo \Illuminate\Support\Js::from($this->getId())->toHtml() ?>,
                })"
        style="height: 0"
    >
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getMountedActions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php if((! $loop->last) || $this->mountedActionShouldOpenModal()): ?>
                <?php echo e($action->toModalHtmlable()); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <?php
        $this->hasActionsModalRendered = true;
    ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\vendor\filament\actions\resources\views/components/modals.blade.php ENDPATH**/ ?>