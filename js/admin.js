jQuery(document).ready(function($) {
	$.ajaxSetup ({cache: false});
	
	$('.section-body-row').mouseenter(function() {
		$(this).css({'background-color' : '#E7E7E7'});
	});
	$('.section-body-row').mouseleave(function() {
		$(this).css({'background-color' : '#FFFFFF'});
	});
	
	$('.btn-primary.btn-sm.btn-fix, .btn-fix-footer').click(function() {
		var hasAttr 	= $(this).attr('singlesite');
		var this_id 	= $(this).attr('template');
		var this_obj 	= this;

		$('#' + this_id).block({message: null});
		$(this_obj).block({message: null}); 

		$.post(ajaxurl, {'action' 		: 'fix_footer', 
										 'template' : this_id}, function(response) {
			if (response == 'true') {
				if (hasAttr) {
					location.reload();
				}
				setTimeout(function() {
					$(this_obj).removeClass('btn-primary');
					$(this_obj).addClass('btn-success');
					$(this_obj).addClass('active');
					$(this_obj).html($(this_obj).attr('fixed'));
					$('#' + this_id + '-restore').fadeIn();
				}, 1000);
			} else {
				$("#dialog-confirm").dialog({
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"Delete all items": function() {
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );					
						}
					}
				});
			}
			
			$('#' + this_id).unblock();
			$(this_obj).unblock();
		});
	});
	
	$('.btn-danger.btn-sm.btn-fix').click(function() {
		var dialogHeight = 200;
		if ($(this).attr('desc') == 'NotWritable' || $(this).attr('desc') == 'NotExists') {
			dialogHeight = 300;
		}
		
		$("#dialog-confirm-body").html($(this).attr('text'));
		$("#dialog-confirm").dialog({
			resizable: false,
			height: dialogHeight,
			modal: false,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );					
				}
			}
		});
	});
	
	$('.btn-update-footer').click(function() {
		var this_obj 	= this;
		
		$('.section-table').block({message: null});
		$(this_obj).block({message: null});
		$.post(ajaxurl, {'action' : 'update_footer',
										 'text' 	: encodeURIComponent($('.update-text').val()).replace(/'/g, "%27")}, function(response) {
			
		});
		setTimeout(function() {
			$('.section-table').unblock();
			$(this_obj).unblock();
		}, 1000);
	});
	
	$('.btn-restore, .btn-restore-footer').click(function() {
		var hasAttr 	= $(this).attr('singlesite');
		var this_id 	= $(this).attr('template');
		var this_obj 	= this;

		$('#' + this_id).block({message: null});
		$(this_obj).block({message: null}); 
		
		$.post(ajaxurl, {'action' 		: 'restore_footer', 
										 'template' 	: this_id}, function(response) {
			
			if (response == 'true') {
				if (hasAttr) {
					location.reload();
				}
				setTimeout(function() {
					$('#' + this_id + '-fix').removeClass('btn-success');
					$('#' + this_id + '-fix').addClass('btn-primary');
					$('#' + this_id + '-fix').removeClass('active');
					$('#' + this_id + '-fix').html($(this_obj).attr('fix'));
					$('#' + this_id + '-restore').fadeOut();
				}, 1000);
			} else {
				$("#dialog-confirm").dialog({
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"Delete all items": function() {
							$(this).dialog( "close" );
						},
						Cancel: function() {
							$(this).dialog( "close" );					
						}
					}
				});
			}
			
			$('#' + this_id).unblock();
			$(this_obj).unblock();
		});
	});
	
	$('.btn-default').click(function() {
		var this_obj 	= this;
		
		$('.section-table').block({message: null});
		$(this_obj).block({message: null});
		$.post(ajaxurl, {'action' 	: 'default_footer',
										 'template' : $(this_obj).attr('template')}, function(response) {
			if (response != 'false') {
				$('.form-control.update-text').val(response);
			} else {
				
			}
		});
		setTimeout(function() {
			$('.section-table').unblock();
			$(this_obj).unblock();
		}, 1000);
	});
	
});

jQuery(window).load(function($) {

});

jQuery(window).resize(function($) {

});