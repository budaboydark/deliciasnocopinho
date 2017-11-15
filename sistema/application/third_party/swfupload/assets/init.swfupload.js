
var swfu;
window.onload = function () {
    swfu = new SWFUpload({
        // Backend Settings
        upload_url: SWFU_UPLOAD_URL,
        post_params: { "PHPSESSID": SWFU_SESSION },
        
        // File Upload Settings
        file_size_limit : SWFU_SIZE, //10MB
        file_types : SWFU_FORMAT,
        file_types_description : SWFU_FORMAT_DESCRIPTION,
        file_upload_limit : SWFU_LIMIT,

        // Event Handler Settings - these functions as defined in Handlers.js
        //  The handlers are not part of SWFUpload but are part of my website and control how
        //  my website reacts to the SWFUpload events.
        file_queue_error_handler : fileQueueError,
        file_dialog_complete_handler : fileDialogComplete,
        upload_progress_handler : uploadProgress,
        upload_error_handler : uploadError,
        upload_success_handler : uploadSuccess,
        upload_complete_handler : uploadComplete,

        // Button Settings
        button_placeholder_id : "spanButtonPlaceholder",
        button_image_url : '/',
        button_width: 325,
        button_height: 43,
        button_text : '',
        button_text_style : '',
        button_text_top_padding: 0,
        button_text_left_padding: 18,
        button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
        button_cursor: SWFUpload.CURSOR.HAND,

        // Flash Settings
        flash_url : "application/third_party/swfupload/assets/swfupload.swf",

        custom_settings : { upload_target : "divFileProgressContainer" },

        // Debug Settings
        debug: false
    });
};


/* order elements */
function swfu_order(rel,files) {
    jQuery.ajax({ type: "POST", data: 'files='+files, url: "swfupload/order/"+rel, success: function(msg){ } });
}

/* delete element */
function swfu_delete_file(rel,file) {
    jQuery.ajax({ type: "POST", url: "swfupload/delete_file/"+rel+"/"+file, success: function(msg){ } });
}

jQuery(document).ready(function(){
    //image edit
    jQuery('.ajax').live('click', function() {  
        jQuery.fn.colorbox({
            href: jQuery(this).attr('href'), open:true,
            onComplete: function(){
                jQuery('.cancel').click(function(){
                    jQuery.fn.colorbox.close();
                    return false;   //we use return false because we use button and to prevent form submission 
                });
                
                jQuery('#editphoto').submit(function(){
                    var file     = jQuery(this).attr('data-file');
                    var title    = jQuery(this).find('input[name="title"]').val();
                    var formdata = jQuery(this).serialize();    //get all form data
                    var url = jQuery(this).attr('action');      //get the url to be submitted
                    jQuery.post(url, formdata, function(data){                          
                        //if success, then show message notification as success message
                        jQuery('.notifyMessage').addClass('notifySuccess');
                        //otherwise
                        //jQuery('.notifyMessage').addClass('notifyError');
                        jQuery('#thumbnails ul li[data-file="'+file+'"]').find('a.name').html(title);
                        
                        jQuery.fn.colorbox.resize();    
                    });
                    return false;
                });
            }
        });
        return false;
    });
    
    //a little image effectts
    jQuery('#thumbnails ul.imagelist li img').live('mouseover',function(){
        jQuery(this).stop().animate({opacity: 0.75});
    });
    jQuery('#thumbnails ul.imagelist li img').live('mouseout',function(){
        jQuery(this).stop().animate({opacity: 1});
    });
    
    //image view
    jQuery('.view').live('click', function() {  
        jQuery.fn.colorbox({
            href: jQuery(this).attr('href'), open:true
        });
        return false;
    });
    
    //delete image in grid
    jQuery('#thumbnails .delete').live('click',function(){
        var rel     = jQuery(this).parents('#thumbnails').attr('data-rel');
        var parent  = jQuery(this).parents('li');
        
        jConfirm('Deseja realmente excluir?', 'Excluir', function(r) {
            if(r) {
                parent.hide('explode',500);
                swfu_delete_file(rel,parent.attr('data-file'));  
            }
        });
        return false;
    });
    
    //sortable images
    jQuery('#thumbnails ul.imagelist').sortable({
        stop: function( event, ui ) {
            var rel         = jQuery('#thumbnails').attr('data-rel');
            var var_order   = new Array();
            
            ui.item.parents('ul').find('li').each(function(e,i) {
                var_order[e] = jQuery(this).attr('data-file');
            });
            
            swfu_order(rel,var_order.join(';'));
        }
    });
});