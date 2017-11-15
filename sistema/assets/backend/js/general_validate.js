jQuery(document).ready(function(){
    /*
    * Form Validation
    */
	jQuery.metadata.setType("attr", "data-validate");
	jQuery("#form1").validate({
		meta: "validate",
        submitHandler: function(form) {
            jQuery(form).find('button').attr('disabled','disabled');
            form.submit();
        }
	});

    /*
     * Validator addMethods
     */
    jQuery.validator.addMethod("notEqual", function(value,element) {
        var data_value = jQuery(element).attr('data-value');
        return value != data_value;
    }, 'Campo obrigatório');
});