<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\VerticalAlignment;
?>

<div>
    <div
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-no',
            'fi-align-' . static::$alignment->value,
            'fi-vertical-align-' . static::$verticalAlignment->value,
        ]); ?>"
        role="status"
    >
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($notification); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($broadcastChannel = $this->getBroadcastChannel()): ?>
            <?php
        $__scriptKey = '1105911480-0';
        ob_start();
    ?>
            <script>
                window.addEventListener('EchoLoaded', () => {
                    window.Echo.private(<?php echo \Illuminate\Support\Js::from($broadcastChannel)->toHtml() ?>).notification(
                        (notification) => {
                            setTimeout(
                                () =>
                                    $wire.handleBroadcastNotification(
                                        notification,
                                    ),
                                500,
                            )
                        },
                    )
                })

                if (window.Echo) {
                    window.dispatchEvent(new CustomEvent('EchoLoaded'))
                }
            </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/aqibullah/developement/Laravel/filament-saas-starter-kit/vendor/filament/notifications/resources/views/notifications.blade.php ENDPATH**/ ?>