<div id="dialog-confirm" title="<?php _e('Information', PLUGIN_LANG_DOMAIN); ?>" style="display: none;">
  <p id="dialog-confirm-body">
  </p>
</div>
<h3 class="section-top-title">
	<i class="whhg-edit section-top-icon"></i>
	<?php echo PLUGIN_TITLE_NAME; ?>
</h3>
<div class="section-container">
	<table class="section-table">
		<thead>
			<tr>
				<th class="section-cell-center">#</th>
				<th><?php _e('Theme Name', PLUGIN_LANG_DOMAIN); ?></th>
				<th class="section-cell-center"><?php _e('Theme Version', PLUGIN_LANG_DOMAIN); ?></th>
				<th><?php _e('Theme Author', PLUGIN_LANG_DOMAIN); ?></th>
				<th class="section-cell-center"><?php _e('Status / Action', PLUGIN_LANG_DOMAIN); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php $counter = 1; ?>
			<?php foreach(wp_get_themes() AS $theme): ?>
				<?php if (isset($restoreArray[$theme->get_template()])): ?>
					<?php $resultArr = checkThemeFooter($theme); ?>
					<tr class="section-body-row" id="<?php echo $theme->get_template(); ?>">
						<td class="section-cell-center">
							<?php echo $counter; ?>
						</td>
						<td>
							<?php echo $theme->display('Name'); ?>
						</td>
						<td class="section-cell-center">
							<?php echo $theme->display('Version'); ?>
						</td>
						<td>
							<?php echo str_replace('<a ', '<a target="_new" ', $theme->display('Author')); ?>
						</td>
						<td class="section-cell-center">
							<button class="btn btn-<?php echo $resultArr['class']; ?> btn-sm btn-fix" type="button" id="<?php echo $theme->get_template(); ?>-fix"
																																												 template="<?php echo $theme->get_template(); ?>"
																																												 fixed="<?php _e('Fixed', PLUGIN_LANG_DOMAIN); ?>"
																																												 text="<?php echo $resultArr['text']; ?>"
																																												 desc="<?php echo $resultArr['desc']; ?>">
								<?php echo $resultArr['info']; ?>
							</button>
							<?php if ($resultArr['stat'] == 'Fixed'): ?>
								<button class="btn btn-darkest btn-sm btn-restore" type="button" id="<?php echo $theme->get_template(); ?>-restore" 
																																								 template="<?php echo $theme->get_template(); ?>"
																																								 fix="<?php _e('Fix', PLUGIN_LANG_DOMAIN); ?>">
									<?php _e('Restore', PLUGIN_LANG_DOMAIN); ?>
								</button>		
							<?php else: ?>
								<button class="btn btn-darkest btn-sm btn-restore" type="button" id="<?php echo $theme->get_template(); ?>-restore" 
																																								 template="<?php echo $theme->get_template(); ?>" 
																																								 fix="<?php _e('Fix', PLUGIN_LANG_DOMAIN); ?>" 
																																								 style='display: none;'>
									<?php _e('Restore', PLUGIN_LANG_DOMAIN); ?>
								</button>	
							<?php endif; ?>
						</td>
					</tr>
					<?php $counter++; ?>
				<?php elseif (in_array($theme->display('AuthorURI'), array('http://www.elegantthemes.com', 
																															 'http://www.elegantthemes.com/', 
																															 'http://www.elegantwordpressthemes.com'))): ?>
					<?php $counter++; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>