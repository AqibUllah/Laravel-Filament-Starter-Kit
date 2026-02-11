<?php
    $extraAttributes = $getExtraAttributes();
    $id = $getId();
?>

<!--[if BLOCK]><![endif]--><?php if(filled($id) || filled($extraAttributes)): ?>
    <?php echo '<div'; ?>

    
    <?php echo e($attributes
            ->merge([
                'id' => $id,
            ], escape: false)
            ->merge($extraAttributes, escape: false)); ?>

    >
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<!--[if BLOCK]><![endif]--><?php if(filled($key = $getLivewireKey())): ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split($getComponent(), $getComponentProperties());

$__html = app('livewire')->mount($__name, $__params, $key, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php else: ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split($getComponent(), $getComponentProperties());

$__html = app('livewire')->mount($__name, $__params, 'lw-1171713621-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if(filled($id) || filled($extraAttributes)): ?>
    <?php echo '</div>'; ?>

    
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\vendor\filament\schemas\resources\views/components/livewire.blade.php ENDPATH**/ ?>