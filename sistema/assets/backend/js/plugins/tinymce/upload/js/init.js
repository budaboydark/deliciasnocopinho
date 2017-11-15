jQuery.noConflict();

function ajaxImageUpload() {
	jQuery("#buttonUpload").ajaxStart(function(){
		jQuery(this).addClass('loading');
		_disabled(jQuery(this));
	}).ajaxComplete(function(){
		jQuery(this).removeClass('loading');
		_enabled(jQuery(this));
	});
	
	jQuery.ajaxFileUpload({
		url:'../../upload/php/upimage.php',
		secureuri:false,
		fileElementId:'fileToUpload',
		dataType: 'json',
		success: function (data, status) {
			if(typeof(data.error) != 'undefined') {
				if(data.error != '')	tinyMCEPopup.alert(data.error);
				else					tinyMCEPopup.alert(data.msg);
			} else {
				jQuery('#src').empty();
				jQuery('#src').val(data.msg).change();
				jQuery('#fileToUpload').val('');
				mcTabs.displayTab('general_tab','general_panel');
			}
		},
		error: function (data, status, e) {
			tinyMCEPopup.alert(e);
		}
	});
	
	return false;
}

function ajaxFileUpload() {
	jQuery("#buttonUpload").ajaxStart(function(){
		jQuery(this).addClass('loading');
		_disabled(jQuery(this));
	}).ajaxComplete(function(){
		jQuery(this).removeClass('loading');
		_enabled(jQuery(this));
	});
	
	jQuery.ajaxFileUpload({
		url:'../../upload/php/upfile.php',
		secureuri:false,
		fileElementId:'fileToUpload',
		dataType: 'json',
		success: function (data, status) {
			if(typeof(data.error) != 'undefined') {
				if(data.error != '')	tinyMCEPopup.alert(data.error);
				else					tinyMCEPopup.alert(data.msg);
			} else {
				jQuery('#href').empty();
				jQuery('#href').val(data.msg).change();
				jQuery('#fileToUpload').val('');
			}
		},
		error: function (data, status, e) {
			tinyMCEPopup.alert(e);
		}
	});
	
	return false;
}

function _disabled(_e) { jQuery(_e).attr('disabled','disabled').css('cursor','default').css('filter','alpha(opacity=40)').css('-moz-opacity','0.4').css('opacity','0.4'); }
function _enabled(_e) { jQuery(_e).removeAttr('disabled').css('cursor','pointer').css('filter','alpha(opacity=100)').css('-moz-opacity','1').css('opacity','1'); }
