jQuery(document).ready(function(){
	/* 
	* login form submit
	* When user submit login form validate a user and pass
	*/
	jQuery('#login').submit(function(){
		
		var _email = jQuery('#email');
		var _pass  = jQuery('#pass');	
		
		/* disable multiples sends */
		jQuery('#login button').attr('disabled','disabled');
				
		jQuery.ajax({
            type: "POST",
            url: "admin/login/logon",
            data: jQuery('#login').serialize(),
            dataType: 'json',
            success: function(msg){
                if(msg.status == 'ok') {
                	jQuery('.nousername').fadeIn().find('.loginmsg').html(msg.message);
	                jQuery('.nopassword').hide();
	                document.location.reload();
                } else if(msg.status == 'erro_pass') {
	                jQuery('.nopassword').fadeIn().find('.loginmsg').html(msg.message);
	                jQuery('.nopassword').fadeIn().find('.userlogged h4').text(msg.user_data.email);
	                jQuery('.nousername,.username').hide();
	                jQuery('.nopassword .loginf .thumb img').attr('src',msg.user_data.image_profile);
                } else if(msg.status == 'erro_user') {
                	jQuery('.nousername').fadeIn().find('.loginmsg').html(msg.message);
                	jQuery('.nopassword').hide();
                } else {
	            	jQuery('.nousername').fadeIn().find('.loginmsg').html(msg.message);
	            	jQuery('.nopassword').hide();
                }
                
                jQuery('#login button').removeAttr('disabled');
            }
        });
		
		return false;
	});
	
	/*
	* add placeholder
	*/
	jQuery('#email').attr('placeholder','Email');
	jQuery('#pass').attr('placeholder','Password');
});
