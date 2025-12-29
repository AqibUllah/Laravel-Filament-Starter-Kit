<?php if(isset($data)): ?>
    <script>
        window.filamentData = <?php echo \Illuminate\Support\Js::from($data)->toHtml() ?>
    </script>
<?php endif; ?>

<?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(! $asset->isLoadedOnRequest()): ?>
        <?php echo e($asset->getHtml()); ?>

    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
    :root {
        <?php $__currentLoopData = $cssVariables ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cssVariableName => $cssVariableValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> --<?php echo e($cssVariableName); ?>:<?php echo e($cssVariableValue); ?>; <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    }

    <?php $__currentLoopData = $customColors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customColorName => $customColorShades): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> .fi-color-<?php echo e($customColorName); ?> { <?php $__currentLoopData = $customColorShades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customColorShade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> --color-<?php echo e($customColorShade); ?>:var(--<?php echo e($customColorName); ?>-<?php echo e($customColorShade); ?>); <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> } <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</style>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/filament/support/resources/views/assets.blade.php ENDPATH**/ ?>