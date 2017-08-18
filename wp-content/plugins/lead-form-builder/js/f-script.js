function SavedataByAjaxRequest(data, method) {
    return jQuery.ajax({
        url: frontendajax.ajaxurl,
        type: method,
        data: data,
        cache: false
    });
}

jQuery(document).ready(function(){
    jQuery('.lf-jquery-datepicker').datepicker();
});

/*
 *Save form data from front-end
 */
jQuery("form.lead-form-front").submit(function(event) {
    event.preventDefault(); 
    var element = jQuery(this);
	element.find('input[type=submit]').prop('disabled', true);
    //alert(element);	
    var form_id = element.find("#hidden_field").val();    
    var captcha_status = element.find("#this_form_captcha_status").val();
    var captcha_res = element.find("#g-recaptcha-response").val();
    element.find('#loading_image').show();	
    element.find(".leadform-show-message-form-"+form_id).empty();
    var this_form_data = element.serialize();
    if(captcha_status=='disable'){
    form_data = this_form_data + "&action=Save_Form_Data";
    SavedataByAjaxRequest(form_data, 'POST').success(function(response) {
        //alert(response);
		element.find('#loading_image').hide();;
        if (jQuery.trim(response) == 'invalidcaptcha') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='error'><p>Invalid Captcha</p></div>");
        } else if (jQuery.trim(response) == 'inserted') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='error'><p>Thank you for submitting form..!!</p></div>");
			jQuery("form.lead-form-front")[0].reset();
        }
    });
    }else{
    form_data = "&captcha_res="+captcha_res+"&action=verifyFormCaptcha";
    SavedataByAjaxRequest(form_data, 'POST').success(function(response) {
	//alert(response);
    element.find('#loading_image').hide();
        if (jQuery.trim(response) == 'Yes') {
        form_data = this_form_data + "&action=Save_Form_Data";
        SavedataByAjaxRequest(form_data, 'POST').success(function(response) {
		 //alert(response);
        if (jQuery.trim(response) == 'invalidcaptcha') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='error'><p>Invalid Captcha</p></div>");
			grecaptcha.reset();
        } else if (jQuery.trim(response) == 'inserted') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='error'><p>Thank you for submitting form..!!</p></div>");
            jQuery("form.lead-form-front")[0].reset();
            grecaptcha.reset();
        }
    });

        } else{
          element.find(".leadform-show-message-form-"+form_id).append("<div class='error'><p>Invalid Captcha</p></div>");
		  grecaptcha.reset();
        
        }
    });
}
 element.find('input[type=submit]').prop('disabled', false);
})