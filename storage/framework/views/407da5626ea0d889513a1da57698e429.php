<!-- FOOTER -->
<tr>
	<td bgcolor="<?php echo e($data['theme']["footer_bg_color"]); ?>" align="center" style="padding: 0px 10px 0px 10px;">
		<!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
            <tr>
                <td align="center" valign="top" width="<?php echo e(config('filament-email-templates.content_width')); ?>">
        <![endif]-->
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: <?php echo e(config('filament-email-templates.content_width')); ?>px;">
					<!-- NAVIGATION -->
					<tr>
						<td bgcolor="<?php echo e($data['theme']["body_bg_color"]); ?>" align="left" style="padding: 30px; color: <?php echo e($data['theme']["body_color"]); ?>; border-radius: 4px 4px 4px 4px;
		                font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;">
							<p style="margin: 0;">
								<?php $__currentLoopData = config('filament-email-templates.links'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a href="<?php echo e($link['url']); ?>" target="_blank" style="font-weight: 700;" title="<?php echo e($link['title']); ?>"><?php echo e($link['name']); ?></a>
									<?php if(! $loop->last): ?>
										|
									<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</p>
						</td>
					</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: <?php echo e(config('filament-email-templates.content_width')); ?>px; margin: 20px 0">

					<!-- ADDRESS -->
					<tr>
						<td bgcolor="<?php echo e($data['theme']["body_bg_color"]); ?>" align="left"
						    style="padding: 30px; color: <?php echo e($data['theme']["body_color"]); ?>; border-radius: 4px 4px 4px 4px; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px;
						    font-weight: 400; line-height: 18px;">
							<p style="margin: 0;"> &copy; <?= date('Y'); ?> <?php echo e(config('app.name')); ?>. <?php echo e(__('vb-email-templates::email-templates.general-labels.all-rights-reserved')); ?>.</p>
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
</table>

<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\resources\views/vendor/vb-email-templates/email/parts/_footer.blade.php ENDPATH**/ ?>