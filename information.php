<div class="wrap">
	<div id="<?php echo $this->plugin->name; ?>-title" class="icon32"></div>
	<h2><?php echo $this->plugin->displayName; ?></h2>
	
	<div>
		<div class="metabox-holder columns-2">
		
			<div>
				<div class="meta-box-sortables ui-sortable">                        
					<div class="postbox">
					<h3 class="hndle"><?php _e('WP Personalize Plugin Information', $this->plugin->name); ?></h3>
					
						<div class="wp-personalize-info">
							<p>
								<?php _e('Personalize and customize your WordPress site theme and/or your plugins with your own CSS, JS (Javascript), HTML and PHP code fragments by editing the following "WP Personalize" plugin files in your favourite code editor / IDE:', $this->plugin->name); ?><br/>
							</p>
							<p>
								<h2>cssCode.css</h2>
								<strong><?php _e('Location:', $this->plugin->name); ?></strong> "../wp-content/wp-personalize/cssCode.css"<br/>
								<strong><?php _e('Usage:', $this->plugin->name); ?></strong> <?php _e('This file is included in the header section (between "<code>&lt;head&gt;...&lt;/head&gt;</code>"), and can include any custom CSS code.', $this->plugin->name); ?><br/>
							</p>
							<p>
								<h2>jsCode.js</h2>
								<strong><?php _e('Location:', $this->plugin->name); ?></strong> "../wp-content/wp-personalize/jsCode.js"<br/>
								<strong><?php _e('Usage:', $this->plugin->name); ?></strong> <?php _e('This file is included in the header section (between "<code>&lt;head&gt;...&lt;/head&gt;</code>"), and can include any custom JS / Javascript code.', $this->plugin->name); ?><br/>
							</p>
							<p>
								<h2>headCode.php</h2>
								<strong><?php _e('Location:', $this->plugin->name); ?></strong> "../wp-content/wp-personalize/headCode.php"<br/>
								<strong><?php _e('Usage:', $this->plugin->name); ?></strong> <?php _e('This file is included in the beginning of the body section (after "<code>&lt;body&gt;...</code>)", and can include any custom CSS, JS (Javascript), HTML and PHP.', $this->plugin->name); ?><br/>
							</p>
							<p>
								<h2>bodyCode.php</h2>
								<strong><?php _e('Location:', $this->plugin->name); ?></strong> "../wp-content/wp-personalize/bodyCode.php"<br/>
								<strong><?php _e('Usage:', $this->plugin->name); ?></strong> <?php _e('This file is included in the middle of the body section (between "<code>&lt;body&gt;...&lt;/head&gt;</code>"), and can include any custom CSS, JS (Javascript), HTML and PHP.', $this->plugin->name); ?><br/>
							</p>
							<p>
								<h2>footCode.php</h2>
								<strong><?php _e('Location:', $this->plugin->name); ?></strong> "../wp-content/wp-personalize/footCode.php"<br/>
								<strong><?php _e('Usage:', $this->plugin->name); ?></strong> <?php _e('This file is included in the end of the body section (before "<code>...&lt;/head&gt;</code>"), and can include any custom CSS, JS (Javascript), HTML and PHP.', $this->plugin->name); ?><br/>
							</p>
							<br/>
						</div>
						
					</div>
				</div>
			
			</div>
		
		</div>
	</div>
</div>