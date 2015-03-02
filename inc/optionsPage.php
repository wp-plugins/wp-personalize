<?php $resultArr = checkThemeFooter(wp_get_theme()); ?>
<h3 class="section-top-title">
	<i class="whhg-edit section-top-icon"></i>
	<?php echo PLUGIN_TITLE_NAME; ?>
</h3>
<div class="section-container">
	<table class="section-table">
		<thead>
			<tr>
				<th><?php _e('Footer Text', PLUGIN_LANG_DOMAIN); ?></th>
				<th class="section-cell-center"><?php _e('Info Text', PLUGIN_LANG_DOMAIN); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr class="section-update-footer-row">
				<td class="section-info-update">
					<textarea class="form-control update-text<?php if ($resultArr['stat'] != 'Fixed') { echo " disabled"; } ?>" rows="7"<?php if ($resultArr['stat'] != 'Fixed') { echo " disabled=\"disabled\""; } ?>><?php echo get_option('wp_footer_elegantthemes'); ?></textarea>
					<button class="btn btn-success btn-update-footer<?php if ($resultArr['stat'] != 'Fixed') { echo " disabled"; } ?>" type="button"<?php if ($resultArr['stat'] != 'Fixed') { echo " disabled=\"disabled\""; } ?>>
						<?php _e('Update', PLUGIN_LANG_DOMAIN); ?>
					</button>
					<button class="btn btn-darkest btn-default<?php if ($resultArr['stat'] != 'Fixed') { echo " disabled"; } ?>" type="button" template="<?php echo get_template(); ?>"<?php if ($resultArr['stat'] != 'Fixed') { echo " disabled=\"disabled\""; } ?>>
						<?php _e('Default', PLUGIN_LANG_DOMAIN); ?>
					</button>
					<?php if (!is_multisite()): ?>
						<?php if ($resultArr['stat'] != 'Fixed'): ?>
							<button class="btn btn-primary btn-fix-footer" singlesite="true" type="button" template="<?php echo get_template(); ?>">
								<?php _e('Fix', PLUGIN_LANG_DOMAIN); ?>
							</button>
						<?php else: ?>
							<button class="btn btn-primary btn-restore-footer" singlesite="true" type="button" template="<?php echo get_template(); ?>">
								<?php _e('Restore', PLUGIN_LANG_DOMAIN); ?>
							</button>
						<?php endif; ?>	
					<?php endif; ?>
				</td>
				<td class="section-info-text">
					<?php if (is_multisite()): ?>
						<?php if ($resultArr['stat'] == 'Fixed'): ?>
							<font class="section-info-fixed">
								<?php _e('Your theme seems to be from Elegant Themes where the footer text is editable.', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('Due to your theme\'s CSS styling and HTML structure,', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('we recommend that you load the default footer text, before editing.', PLUGIN_LANG_DOMAIN); ?>
							</font>
						<?php elseif (($resultArr['stat'] == 'Fix') OR ($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NotExists') OR ($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NotWritable')): ?>
							<font class="section-info-warning">
								<?php _e('Your theme seems to be from Elegant Themes where the footer text is fixable.', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('But your privileges prevents you from fixing the footer text.', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('Contact Administrator to help you with this issue.', PLUGIN_LANG_DOMAIN); ?>
							</font>
						<?php elseif (($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NA') OR ($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NotElegantTheme')): ?>
							<font class="section-info-warning">
								<?php _e('This plugin is not compatible with your current active theme.', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('If possible, check your theme\'s documentation on how to change the footer text.', PLUGIN_LANG_DOMAIN); ?>
							</font>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($resultArr['stat'] == 'Fixed'): ?>
							<font class="section-info-fixed">
								<?php _e('Your theme seems to be from Elegant Themes where the footer text is editable.', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('Due to your theme\'s CSS styling and HTML structure,', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('we recommend that you load the default footer text, before editing.', PLUGIN_LANG_DOMAIN); ?>
							</font>
						<?php elseif (($resultArr['stat'] == 'Fix') OR ($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NotExists') OR ($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NotWritable')): ?>
							<font class="section-info-warning">
								<?php _e('Your theme seems to be from Elegant Themes where the footer text is fixable.', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<br/>
								<?php _e('So please "Fix" the footer file, before editing.', PLUGIN_LANG_DOMAIN); ?>
							</font>
						<?php elseif (($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NA') OR ($resultArr['stat'] == 'Info' AND $resultArr['desc'] == 'NotElegantTheme')): ?>
							<font class="section-info-warning">
								<?php _e('This plugin is not compatible with your current active theme.', PLUGIN_LANG_DOMAIN); ?>
								<br/>
								<?php _e('If possible, check your theme\'s documentation on how to change the footer text.', PLUGIN_LANG_DOMAIN); ?>
							</font>
						<?php endif; ?>
					<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
