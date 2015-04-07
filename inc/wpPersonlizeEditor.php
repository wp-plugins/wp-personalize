<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/lib/codemirror.js'; ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) .'codemirror/lib/codemirror.css'; ?>">
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/mode/javascript/javascript.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/addon/edit/matchbrackets.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/mode/htmlmixed/htmlmixed.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/mode/xml/xml.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/mode/javascript/javascript.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/mode/css/css.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/mode/clike/clike.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__).'codemirror/mode/php/php.js'; ?>"></script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$.ajaxSetup ({cache: false});
		
		var lastRowID				= 0;
		var lastScriptCode	= '';
		var locationArr			= <?php echo json_encode($locationArr); ?>;
		var typeArr					= <?php echo json_encode($typeArr); ?>;
		var areaArr					= <?php echo json_encode($areaArr); ?>;

		var html_val 	= '<div>\n\n</div>';
		var css_val 	= '<style type="text/css">\n\n</style>';
		var php_val 	= '<php\n\n?>';
		var js_val 		= '<script type="text/javascript">\n\n<script>';
		js_val = js_val.replace('\n<', '\n</');
		
		var codeEditor = CodeMirror.fromTextArea(
			$('#codeEditor').get(0), { 
				lineNumbers: true,
				matchBrackets: true,
				mode: "application/x-httpd-php",
				indentUnit: 2,
				indentWithTabs: true
			});
		
		loadScriptList();
		
		function loadScriptList() {
			var postData = {
				'action'			: 'wpp_load_list'
			};
			
			$.post(ajaxurl, postData, function(response) {
				$('#bodyScriptList .scriptItemRow').remove();
				if (response.indexOf('{"') >= 0) {
					response = response.substring(response.indexOf('{"'));
					var parsedData = JSON.parse(response);

					var prependHTML = '';
					var j = 0;
					
					$.each(parsedData, function(i, obj) {
						prependHTML += '<tr id="tr-' + j + '" class="scriptItemRow">';
						prependHTML += '<td>' + obj.title + '</td>';
						prependHTML += '<td class="wpp-cell-center">' + locationArr[obj.location] + '</td>';
						prependHTML += '<td class="wpp-cell-center">' + typeArr[obj.type] + '</td>';
						prependHTML += '<td class="wpp-cell-center">' + areaArr[obj.area] + '</td>';
						prependHTML += '<td class="wpp-cell-center" style="white-space: nowrap;">';
						prependHTML += '<button class="wpp-btn wpp-btn-sm wpp-btn-success btn-load-script" type="button" id="' + j + '" scriptTitle="' + obj.title + '">';
						prependHTML += '	<?php _e("Load", PLUGIN_LANG_DOMAIN); ?>';
						prependHTML += '</button>&nbsp;';
						prependHTML += '<button class="wpp-btn wpp-btn-sm wpp-btn-danger btn-delete-script" type="button" id="' + j + '" scriptTitle="' + obj.title + '">';
						prependHTML += '	<?php _e("Delete", PLUGIN_LANG_DOMAIN); ?>';
						prependHTML += '</button>';
						prependHTML += '</td>';
						prependHTML += '</tr>';
						j++;
					});
					$('#rowNoScripts').hide();
					$('#bodyScriptList').prepend(prependHTML);
				} else {
					$('#rowNoScripts').show();
				}

			});
		}
		
		function setDDValues(ddTitle, ddLocation, ddType, ddArea, buttonAttr) {
			$('#wpp-title').val(ddTitle);
			$('#wpp-location').val(ddLocation);
			$('#wpp-type').val(ddType);
			$('#wpp-area').val(ddArea);
			$('#wpp-submit-button').html($('#wpp-submit-button').attr(buttonAttr));
		}
		
		function checkCodeEditorChanges(codeVal) {
			if (codeVal == '') {
				return false;
			} else if (lastScriptCode != '' && lastScriptCode != codeVal) {
				return true;
			} else if (lastScriptCode == '' && codeVal != '') {
				return true;
			} else {
				return false;
			}
		}
		
		function loadScript(this_obj) {
			$('.wpp-section-container').block({message: null});
			
			var this_id 			= this_obj.id;
			var script_title 	= $(this_obj).attr('scriptTitle');
			
			var postData = {
				'action'	: 'wpp_load_script',
				'title'		:  script_title
			};

			$.post(ajaxurl, postData, function(response) {
				response = response.split('{"');
				response = '{"' + response[1];
				var parsedData = JSON.parse(response);

				codeEditor.setValue(parsedData['code']);
				lastScriptCode = parsedData['code'];
				
				setDDValues(script_title, parsedData['location'], parsedData['type'], parsedData['area'], 'updateTxt');
			});
			
			$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
			$('#tr-' + this_id).css({'background-color' : '#EEEEEE'});
			
			setTimeout(function() {
				$('.wpp-section-container').unblock();
			}, 1000);
			
			lastRowID = this_id;
		}
		
		
		$('.btn-submit-code').click(function() {
			var codeVal = codeEditor.getValue();
			
			if (codeVal == '') {
				return;
			}
			
			if ($('#wpp-title').val() == '') {
				$('#wpp-title').focus();
				return;
			}
			
			if ($('#wpp-location').val() == '') {
				$('#wpp-location').focus();
				return;
			}
			
			if ($('#wpp-type').val() == '') {
				$('#wpp-type').focus();
				return;
			}
			
			if ($('#wpp-area').val() == '') {
				$('#wpp-area').focus();
				return;
			}
			
			$('.wpp-section-container').block({message: null});
			
			var postData = {
				'action'			: 'wpp_update_script',
				'codeEditor'	: codeVal, 
				'location'		: $('#wpp-location').val(),
				'type'				: $('#wpp-type').val(),
				'area'				: $('#wpp-area').val(),
				'title'				: $('#wpp-title').val()
			};
			
			$.post(ajaxurl, postData, function(response) {
				response = response.split('{"');
				response = '{"' + response[1];
				var parsedData = JSON.parse(response);
				
				lastScriptCode = codeVal;

				setTimeout(function() {
					loadScriptList();
					$('.wpp-section-container').unblock();
				}, 1000);
			});

		});
		
		$('#wpp-type').change(function() {
			var script_type = $('#wpp-type').val();
			if (script_type == 'html') {
				$('.btn-load-html').trigger("click");
			} else if (script_type == 'css') {
				$('.btn-load-css').trigger("click");
			} else if (script_type == 'js') {
				$('.btn-load-js').trigger("click");
			} else if (script_type == 'php') {
				$('.btn-load-php').trigger("click");
			}
		});
		
		$(document).on('click', '.btn-load-script', function() {
			var codeVal 	= codeEditor.getValue();
			var this_obj 	= this;
			if (checkCodeEditorChanges(codeVal)) {
				$("#wpp-dialog-confirm-body").html("<?php _e('You haven\'t saved your changes, proceed?', WWP_PLUGIN_LANG_DOMAIN); ?>");
				$("#wpp-dialog-confirm").dialog({
					resizable: false,
					height: 140,
					modal: true,
					buttons: {
						"<?php _e('Yes', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							loadScript(this_obj);
						},
						"<?php _e('No', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							return;			
						}
					}
				});
			} else {
				loadScript(this_obj);
			}
			
		});
		
		$(document).on('click', '.btn-delete-script', function() {
			var this_id		= this.id;
			var this_obj	= this;
			
			$("#wpp-dialog-confirm-body").html("<?php _e('Are you sure?', WWP_PLUGIN_LANG_DOMAIN); ?>");
			$("#wpp-dialog-confirm").dialog({
				resizable: false,
				height: 140,
				modal: true,
				buttons: {
					"<?php _e('Yes', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
						$("#wpp-dialog-confirm").dialog("close");
						$('.wpp-section-table').block({message: null});
						var script_title = $(this_obj).attr('scriptTitle');
						var postData = {
							'action'	: 'wpp_delete_script',
							'title'		:  script_title
						};
			
						$.post(ajaxurl, postData, function(response) {
							response = response.split('{"');
							response = '{"' + response[1];
							var parsedData = JSON.parse(response);
				
							setTimeout(function() {
								$('.wpp-section-table').unblock();
								loadScriptList();
								codeEditor.setValue('');
								setDDValues('', '', '', '', 'createTxt');
								lastScriptCode = '';
							}, 1000);
						});
					},
					"<?php _e('No', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
						$("#wpp-dialog-confirm").dialog("close");					
					}
				}
			});
			
		});
		
		$('.btn-load-html').click(function() {
			var codeVal 	= codeEditor.getValue();
			var this_obj 	= this;
						
			if (checkCodeEditorChanges(codeVal)) {
				$("#wpp-dialog-confirm-body").html("<?php _e('You haven\'t saved your changes, proceed?', WWP_PLUGIN_LANG_DOMAIN); ?>");
				$("#wpp-dialog-confirm").dialog({
					resizable: false,
					height: 140,
					modal: true,
					buttons: {
						"<?php _e('Yes', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							codeEditor.setValue(html_val);
							setDDValues('', '', 'html', '', 'createTxt');
							lastScriptCode = html_val;
							$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
							lastRowID = 0;
						},
						"<?php _e('No', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							return;			
						}
					}
				});
			} else {
				codeEditor.setValue(html_val);
				setDDValues('', '', 'html', '', 'createTxt');
				lastScriptCode = html_val;
				$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
				lastRowID = 0;
			}
		});
		
		$('.btn-load-css').click(function() {
			var codeVal 	= codeEditor.getValue();
			var this_obj 	= this;
						
			if (checkCodeEditorChanges(codeVal)) {
				$("#wpp-dialog-confirm-body").html("<?php _e('You haven\'t saved your changes, proceed?', WWP_PLUGIN_LANG_DOMAIN); ?>");
				$("#wpp-dialog-confirm").dialog({
					resizable: false,
					height: 140,
					modal: true,
					buttons: {
						"<?php _e('Yes', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							codeEditor.setValue(css_val);
							setDDValues('', '', 'css', '', 'createTxt');
							lastScriptCode = css_val;
							$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
							lastRowID = 0;
						},
						"<?php _e('No', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							return;			
						}
					}
				});
			} else {
				codeEditor.setValue(css_val);
				setDDValues('', '', 'css', '', 'createTxt');
				lastScriptCode = css_val;
				$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
				lastRowID = 0;
			}
		});
		
		$('.btn-load-js').click(function() {
			var codeVal 	= codeEditor.getValue();
			var this_obj 	= this;
						
			if (checkCodeEditorChanges(codeVal)) {
				$("#wpp-dialog-confirm-body").html("<?php _e('You haven\'t saved your changes, proceed?', WWP_PLUGIN_LANG_DOMAIN); ?>");
				$("#wpp-dialog-confirm").dialog({
					resizable: false,
					height: 140,
					modal: true,
					buttons: {
						"<?php _e('Yes', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							codeEditor.setValue(js_val);
							setDDValues('', '', 'js', '', 'createTxt');
							lastScriptCode = js_val;
							$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
							lastRowID = 0;
						},
						"<?php _e('No', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							return;			
						}
					}
				});
			} else {
				codeEditor.setValue(js_val);
				setDDValues('', '', 'js', '', 'createTxt');
				lastScriptCode = js_val;
				$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
				lastRowID = 0;
			}
		});
		
		$('.btn-load-php').click(function() {
			var codeVal 	= codeEditor.getValue();
			var this_obj 	= this;
						
			if (checkCodeEditorChanges(codeVal)) {
				$("#wpp-dialog-confirm-body").html("<?php _e('You haven\'t saved your changes, proceed?', WWP_PLUGIN_LANG_DOMAIN); ?>");
				$("#wpp-dialog-confirm").dialog({
					resizable: false,
					height: 140,
					modal: true,
					buttons: {
						"<?php _e('Yes', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							codeEditor.setValue(php_val);
							setDDValues('', '', 'php', '', 'createTxt');
							lastScriptCode = php_val;
							$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
							lastRowID = 0;
						},
						"<?php _e('No', WWP_PLUGIN_LANG_DOMAIN); ?>": function() {
							$("#wpp-dialog-confirm").dialog("close");	
							return;			
						}
					}
				});
			} else {
				codeEditor.setValue(php_val);
				setDDValues('', '', 'php', '', 'createTxt');
				lastScriptCode = php_val;
				$('#tr-' + lastRowID).css({'background-color' : '#FFFFFF'});
				lastRowID = 0;
			}
		});
		
	});
</script>

<div class="wpp-section-container">
	<table class="wpp-section-table">
		<thead>
			<tr>
				<th><?php echo $titleName; ?></th>
				<th><?php _e('Control Panel', WWP_PLUGIN_LANG_DOMAIN); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<textarea id="codeEditor" name="codeEditor"></textarea>
				</td>
				<td style="height: 100%;">
					
					<table class="wpp-sub-section-table" style="height: 90%;">
						<thead>
							<tr>
								<th><?php _e('Script Title', WWP_PLUGIN_LANG_DOMAIN); ?></th>
								<th><center><?php _e('Location', WWP_PLUGIN_LANG_DOMAIN); ?></center></th>
								<th><center><?php _e('Type', WWP_PLUGIN_LANG_DOMAIN); ?></center></th>
								<th><center><?php _e('Area', WWP_PLUGIN_LANG_DOMAIN); ?></center></th>
								<th><center><?php _e('Action', WWP_PLUGIN_LANG_DOMAIN); ?></center></th>
							</tr>
						</thead>
						<tbody id="bodyScriptList">
							<tr id="rowNoScripts" style="display: none;">
								<td colspan="5" class="wpp-cell-center">
									<?php _e('No Scripts', WWP_PLUGIN_LANG_DOMAIN); ?>
								</td>
							</tr>
							<tr>
								<td colspan="5" style="height: 100%; border-bottom: 0px;">
									
								</td>
							</tr>
						</tbody>
					</table>
					
				</td>
			</tr>
			<tr>
				<td>
					<div class="wpp-subsection-script-types">
						<font class="wpp-subsection-create-new"><?php _e('Create new', WWP_PLUGIN_LANG_DOMAIN); ?></font>
						<?php if (!isset($scriptSetArr['type']['html']) OR $scriptSetArr['type']['html'] == 'true' OR ($isNetworkAdmin AND $isSuperAdmin)): ?>
							<button class="wpp-btn wpp-btn-sm wpp-btn-danger wpp-btn-scripts btn-load-html" type="button" title="<?php _e('HTML', WWP_PLUGIN_LANG_DOMAIN); ?>">
								<i class="whhg-htmlfive"></i>
							</button>&nbsp;&nbsp;&nbsp;
						<?php endif; ?>
						<?php if (!isset($scriptSetArr['type']['css']) OR $scriptSetArr['type']['css'] == 'true' OR ($isNetworkAdmin AND $isSuperAdmin)): ?>
							<button class="wpp-btn wpp-btn-sm wpp-btn-primary wpp-btn-scripts btn-load-css" type="button" title="<?php _e('CSS', WWP_PLUGIN_LANG_DOMAIN); ?>">
								<i class="whhg-cssthree"></i>
							</button>&nbsp;&nbsp;&nbsp;
						<?php endif; ?>
						<?php if (!isset($scriptSetArr['type']['js']) OR $scriptSetArr['type']['js'] == 'true' OR ($isNetworkAdmin AND $isSuperAdmin)): ?>
							<button class="wpp-btn wpp-btn-sm wpp-btn-warning wpp-btn-scripts btn-load-js" type="button" title="<?php _e('Javascript', WWP_PLUGIN_LANG_DOMAIN); ?>">
								<i class="whhg-code"></i>
							</button>&nbsp;&nbsp;&nbsp;
						<?php endif; ?>
						<?php if (!isset($scriptSetArr['type']['php']) OR $scriptSetArr['type']['php'] == 'true' OR ($isNetworkAdmin AND $isSuperAdmin)): ?>
							<button class="wpp-btn wpp-btn-sm wpp-btn-php wpp-btn-scripts btn-load-php" type="button" title="<?php _e('PHP', WWP_PLUGIN_LANG_DOMAIN); ?>">
								<i class="whhg-php"></i>
							</button>
						<?php endif; ?>
						<font class="wpp-subsection-create-network"><?php echo $createNetworkTxt; ?></font>
					</div>
				</td>
				<td>
					
					<table class="wpp-sub-section-table"  style="height: 100%;">
						<tbody>
							<tr>
								<td style="border-bottom: 0px;">
									<input type="text" id="wpp-title" name="wpp-title" placeholder="Script Title" title="Script Title" />
								</td>
								<td style="border-bottom: 0px;">
									<select id="wpp-location" name="wpp-location">
										<option value=""><?php _e('Location', PLUGIN_LANG_DOMAIN); ?></option>
										<?php foreach ($locationArr AS $key => $value): ?>
											<?php if (!isset($scriptSetArr['location'][$key]) OR $scriptSetArr['location'][$key] == 'true' OR ($isNetworkAdmin AND $isSuperAdmin)): ?>
												<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</td>
								<td style="border-bottom: 0px;">
									<select id="wpp-type" name="wpp-type">
										<option value=""><?php _e('Type', PLUGIN_LANG_DOMAIN); ?></option>
										<?php foreach ($typeArr AS $key => $value): ?>
											<?php if (!isset($scriptSetArr['type'][$key]) OR $scriptSetArr['type'][$key] == 'true' OR ($isNetworkAdmin AND $isSuperAdmin)): ?>
												<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</td>
								<td style="border-bottom: 0px;">
									<select id="wpp-area" name="wpp-area">
										<option value=""><?php _e('Area', PLUGIN_LANG_DOMAIN); ?></option>
										<?php foreach ($areaArr AS $key => $value): ?>
											<?php if (!isset($scriptSetArr['area'][$key]) OR $scriptSetArr['area'][$key] == 'true' OR ($isNetworkAdmin AND $isSuperAdmin)): ?>
												<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</td>
								<td class="wpp-cell-center" style="border-bottom: 0px;">
									<button class="wpp-btn wpp-btn-sm wpp-btn-primary btn-submit-code" type="button" id="wpp-submit-button" 
											updateTxt="<?php _e('Update', PLUGIN_LANG_DOMAIN); ?>" createTxt="<?php _e('Create', PLUGIN_LANG_DOMAIN); ?>">
										<?php _e('Create', PLUGIN_LANG_DOMAIN); ?>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
					
				</td>
			</tr>			
		</tbody>
	</table>
</div>

<h3 class="wpp-section-bottom">
	<section class="wpp-section-bottom-wrap">
		<div class="wpp-section-bottom-left">
			2012-<?php  echo date('Y'); ?> &#64; <a href="https://ecalon.it" target="_new">Ecalon IT LTD.</a> All rights reserved.
		</div>
		<div class="wpp-section-bottom-right">
			 <a href="mailto:info@ecalon.it" target="_new">Report a Bug</a> |  <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5GB537F64NUDE" target="_new">Donate</a>
		</div>
	</section>
</h3>