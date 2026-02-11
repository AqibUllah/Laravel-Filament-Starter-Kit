<!-- COPY BLOCK -->
<tr>
    <td bgcolor="<?php echo e($data['theme']["body_bg_color"]); ?>" align="center" style="padding: 0px 10px 0px 10px; background-color: <?php echo e($data['theme']["body_bg_color"]); ?>">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
            <tr>
                <td align="center" valign="top" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: <?php echo e(config('filament-email-templates.content_width')); ?>px; margin-bottom: 30px" >
            <!-- COPY -->
            <tr>
                <td bgcolor="<?php echo e($data['theme']["content_bg_color"]); ?>" align="left" style="padding: 20px 30px 40px 30px; color: <?php echo e($data['theme']["body_color"]); ?>; font-family: 'Lato',
                Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 1.8;" >

                    <?php echo $data['content']??''; ?>


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
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\resources\views/vendor/vb-email-templates/email/parts/_content.blade.php ENDPATH**/ ?>