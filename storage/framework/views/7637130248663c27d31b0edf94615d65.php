
    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        <?php echo e($data['preheader'] ?? ''); ?>

    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="<?php echo e($data['theme']["header_bg_color"]); ?>" align="center" style="background-color: <?php echo e($data['theme']["header_bg_color"]); ?>">
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
                    <tr>
                        <td align="center" valign="top" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: <?php echo e(config('filament-email-templates.content_width')); ?>px;" >
                    <tr>
                        <td align="center" valign="top" style="padding: 30px 10px 30px 10px;">
                            <a href="<?php echo e(\Illuminate\Support\Facades\URL::to('/')); ?>" target="_blank" title="<?php echo e(config('app.name')); ?>">
                                <img alt="<?php echo e(config('app.name')); ?> Logo"
                                     src="<?php echo e($data['logo']); ?>"
                                     width="<?php echo e(config('filament-email-templates.logo_width')); ?>"
                                     height="<?php echo e(config('filament-email-templates.logo_height')); ?>"
                                     style="display: block; width: <?php echo e(config('filament-email-templates.logo_width')); ?>px; max-width: <?php echo e(config('filament-email-templates.logo_width')); ?>px; min-width: <?php echo e(config
                                     ('email-templates.logo_width')); ?>px;" border="0">
                            </a>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr><?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\resources\views/vendor/vb-email-templates/email/parts/_body.blade.php ENDPATH**/ ?>