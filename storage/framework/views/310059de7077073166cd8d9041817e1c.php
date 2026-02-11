<!-- SUPPORT CALLOUT -->
<tr>
    <td bgcolor="<?php echo e($data['theme']["footer_bg_color"]); ?>" align="center" style="padding: 30px 10px 0px 10px; background-color: <?php echo e($data['theme']["footer_bg_color"]); ?>">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
            <tr>
                <td align="center" valign="top" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: <?php echo e(config('filament-email-templates.content_width')); ?>px; margin-bottom: 30px">
            <!-- HEADLINE -->
            <tr>
                <td bgcolor="<?php echo e($data['theme']["callout_bg_color"]); ?>" align="center"
                    style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color:<?php echo e($data['theme']["callout_color"]); ?>; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                    <h2 style="font-size: 20px; font-weight: 400; color: <?php echo e($data['theme']["callout_color"]); ?>; margin: 0;"><?php echo e(__('vb-email-templates::email-templates.general-labels.need-help')); ?></h2>
                    <p style="margin: 0; color: <?php echo e($data['theme']["callout_color"]); ?>; "><?php echo e(__('vb-email-templates::email-templates.general-labels.call-support')); ?>

                        <a href="tel:<?php echo e(config('filament-email-templates.customer-services.phone')); ?>" target="_blank">
                            <?php echo e(config('filament-email-templates.customer-services.phone')); ?>

                        </a>
                    </p>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </td>
</tr>
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\resources\views/vendor/vb-email-templates/email/parts/_support_block.blade.php ENDPATH**/ ?>