/*
 *Tabs in admin area
 */
jQuery(function() {
    jQuery( "#sortable tbody" ).sortable();
    //jQuery( "#sortable tbody" ).disableSelection();
  });

jQuery(document).on('click', '.lfb-nav-tab-wrapper a.nav-tab', function() {
        jQuery('section').hide();
        jQuery(this).parent().find('a').removeClass('nav-tab-active');
        jQuery(this).addClass('nav-tab-active');
        jQuery('section').eq(jQuery(this).index()).show();
        return false;
    })
/*
 *Add dynamic Form Fields in admin area
 */
function add_new_form_fields(this_field_id) {
    var f_name = jQuery("#field_name_" + this_field_id).val();
    var f_type = jQuery("#field_type_" + this_field_id).val();
    if (f_type != "select") {
        jQuery("#field_type_" + this_field_id).removeClass('form_field_error');
    } else {
        jQuery("#field_type_" + this_field_id).addClass('form_field_error');
        jQuery("#field_type_" + this_field_id).focus();
    }
    if (f_name != '') {
        jQuery("#field_name_" + this_field_id).removeClass('form_field_error');
    } else {
        jQuery("#field_name_" + this_field_id).addClass('form_field_error');
        jQuery("#field_type_" + this_field_id).focus();
    }
    if ((f_type != "select") && (f_name != '')) {
        jQuery('#add_new_' + this_field_id).remove();
        jQuery("#wpth_add_form_table_" + this_field_id).append("<input type='button' class='button lf_remove' name='remove_field' id='remove_field_" + this_field_id + "' onclick='remove_form_fields(" + this_field_id + ")' value='Remove'>");
        var field_id = this_field_id + 1;
        var field_sr = "<td>" + field_id + "</td>";
        var field_name = "<td><input type='text' name='form_field_" + field_id + "[field_name]' id='field_name_" + field_id + "' value=''></td>";
        var field_type = "<td><select name='form_field_" + field_id + "[field_type][type]' id='field_type_" + field_id + "'><option value='select'>Select Field Type</option><option value='name'>Name</option><option value='email'>Email</option><option value='message'>Message</option><option value='dob'>DOB</option><option value='radio'>Radio</option><option value='option'>Option</option><option value='checkbox'>Checkbox</option><option value='url'>Url</option><option value='number'>Number</option><option value='date'>Date</option><option value='text'>Text</option><option value='textarea'>Textarea</option></select><div class='add_radio_checkbox_" + field_id + "' id='add_radio_checkbox'><div class='' id='add_radio'></div><div class='' id='add_checkbox'></div><div class='' id='add_option'></div></div></td>";
        var field_default = "<td><input type='text' class='default_value' name='form_field_" + field_id + "[default_value]' id='default_value_" + field_id + "' value=''><div class='add_default_radio_checkbox_" + field_id + "' id='add_default_radio_checkbox'><div class='' id='default_add_radio'></div><div class='' id='default_add_checkbox'></div><div class='' id='default_add_option'></div></div></td>";
        var field_placeholder = "<td><input type='checkbox' class='default_placeholder' name='form_field_" + field_id + "[default_placeholder]' id='default_placeholder_" + field_id + "' value='1'></td>";
        var field_required = "<td><input type='checkbox' name='form_field_" + field_id + "[is_required]' id='is_required_" + field_id + "' value='1'></td>";
        var field_add_button = "<td id='wpth_add_form_table_" + field_id + "'><input type='button' class='button lf_addnew' name='save' id='add_new_" + field_id + "' onclick='add_new_form_fields(" + field_id + ")' value='Add New'></td>";
        var field_hidden_id = "<input type='hidden' value=" + field_id + " name='form_field_" + field_id + "[field_id]'>";
        var new_form_field = "<tr id='form_field_row_" + field_id + "'>" + field_sr + field_name + field_type + field_default + field_placeholder + field_required + field_add_button + field_hidden_id + "</tr>";
        jQuery("#wpth_add_form table .append_new").append(new_form_field);
    }
}
/*
 *Delete Form Fields in admin area
 */
function remove_form_fields(field_id) {
    jQuery("#form_field_row_" + field_id).remove();
}
/*
 *Save forms in admin area

function save_new_form() {
    var form_heading = jQuery(".new_form_heading").val();
    if (form_heading != '') {
        jQuery(".new_form_heading").removeClass('form_field_error');
        jQuery(".new_lead_form").submit();
    } else {
        jQuery(".new_form_heading").addClass('form_field_error');
    }
}

 *Save forms in admin area
 */
    jQuery("form#new_lead_form").submit(function(event) {
        var form_heading = jQuery(".new_form_heading").val();
        if (form_heading != '') {
            jQuery(".new_form_heading").removeClass('form_field_error');
        } else {
		    event.preventDefault();
            jQuery(".new_form_heading").addClass('form_field_error');
            jQuery(".new_form_heading").focus();
        }
    })
    /*
     *Add dynamic sub-fields according to Field Type
     */
jQuery("#wpth_add_form").on('change', 'select', function() {
    var this_parent_id = jQuery(this).parent().parent().attr("id");
    var parent_id = String("#" + this_parent_id);
    var this_parent_id = this_parent_id.replace("form_field_row_", "");
    var field_id = "1";
    var str = "";
    str = jQuery(parent_id + " select option:selected").text();
    if (str == 'Radio') {
        jQuery(parent_id).find('#add_radio').css("display", "block");
        jQuery(parent_id).find('#add_checkbox').css("display", "none");
        jQuery(parent_id).find('#add_option').css("display", "none");
        jQuery(parent_id).find('#default_add_radio').css("display", "block");
        jQuery(parent_id).find('#default_add_checkbox').css("display", "none");
        jQuery(parent_id).find('#default_add_option').css("display", "none");
        var radio_res = jQuery(parent_id).find('#add_radio input').length;
        if (radio_res < 1) {
            var radio_fields = "<input type='text' class='input_radio_val' name='form_field_" + this_parent_id + "[field_type][field_1]' id='radio_field_1' placeholder='radio name 1'value=''><p class='button lf_minus' id='delete_radio_1' onclick='delete_radio_fields(" + this_parent_id + ",1)'>-</p><p class='button lf_plus' id='add_new_radio_1' onclick='add_new_radio_fields(" + this_parent_id + ",1)'>+</p>";
            var default_add_radio = "<p id='default_radio_value_1'>radio name 1 <input type='radio' class='' name='form_field_" + this_parent_id + "[default_value][field]' id='default_radio_value_1' value='1'></p>";
            jQuery(parent_id).find('#add_radio').append(radio_fields);
            jQuery(parent_id).find('#default_add_radio').append(default_add_radio);
            jQuery(parent_id).find('#delete_radio_1').css("display", "none");
            jQuery(parent_id).find('input.default_value').attr('disabled', 'disabled');
            jQuery(parent_id).find('input.default_placeholder').attr('disabled', 'disabled');

        }
    } else if (str == 'Option') {
        jQuery(parent_id).find('#add_option').css("display", "block");
        jQuery(parent_id).find('#add_radio').css("display", "none");
        jQuery(parent_id).find('#add_checkbox').css("display", "none");
        jQuery(parent_id).find('#default_add_option').css("display", "block");
        jQuery(parent_id).find('#default_add_radio').css("display", "none");
        jQuery(parent_id).find('#default_add_checkbox').css("display", "none");
        var radio_res = jQuery(parent_id).find('#add_option input').length;
        if (radio_res < 1) {
            var option_fields = "<input type='text' class='input_option_val' name='form_field_" + this_parent_id + "[field_type][field_1]' id='option_field_1' placeholder='option name 1'value=''><p class='button lf_minus' id='delete_option_1' onclick='delete_option_fields(" + this_parent_id + ",1)'>-</p><p class='button lf_plus' id='add_new_option_1' onclick='add_new_option_fields(" + this_parent_id + ",1)'>+</p>";
            var default_add_option = "<p id='default_option_value_1'>option name 1 <input type='radio' class='' name='form_field_" + this_parent_id + "[default_value][field]' id='default_option_value_1' value='1'></p>";
            jQuery(parent_id).find('#add_option').append(option_fields);
            jQuery(parent_id).find('#default_add_option').append(default_add_option);
            jQuery(parent_id).find('#delete_option_1').css("display", "none");
            jQuery(parent_id).find('input.default_value').attr('disabled', 'disabled');
            jQuery(parent_id).find('input.default_placeholder').attr('disabled', 'disabled');

        }
    } else if (str == 'Checkbox') {
        jQuery(parent_id).find(' #add_checkbox').css("display", "block");
        jQuery(parent_id).find(' #add_radio').css("display", "none");
        jQuery(parent_id).find(' #add_option').css("display", "none");
        jQuery(parent_id).find(' #default_add_checkbox').css("display", "block");
        jQuery(parent_id).find(' #default_add_radio').css("display", "none");
        jQuery(parent_id).find('#default_add_option').css("display", "none");
        var checkbox_res = jQuery(parent_id).find('#add_checkbox input').length;
        if (checkbox_res < 1) {
            var checkbox_fields = "<input type='text' class='input_checkbox_val' name='form_field_" + this_parent_id + "[field_type][field_1]' id='checkbox_field_1' placeholder='check box name 1'value=''><p class='button lf_minus' id='delete_checkbox_1' onclick='delete_checkbox_fields(" + this_parent_id + ",1)'>-</p><p class='button lf_plus' id='add_new_checkbox_1' onclick='add_new_checkbox_fields(" + this_parent_id + ",1)'>+</p>";
            var default_add_checkbox = "<p id='default_checkbox_value_1'>checkbox name 1 <input type='checkbox' class='' name='form_field_" + this_parent_id + "[default_value][field_1]' id='default_checkbox_value_1' value='1'></p>";
            jQuery(parent_id).find('#add_checkbox').append(checkbox_fields);
            jQuery(parent_id).find('#default_add_checkbox').append(default_add_checkbox);
            jQuery(parent_id).find('#delete_checkbox_1').css("display", "none");
            jQuery(parent_id).find('input.default_value').attr('disabled', 'disabled');
            jQuery(parent_id).find('input.default_placeholder').attr('disabled', 'disabled');
        }
    } else {
        jQuery(parent_id).find('#add_radio').css("display", "none");
        jQuery(parent_id).find('#default_add_radio').css("display", "none");
        jQuery(parent_id).find('#add_checkbox').css("display", "none");
        jQuery(parent_id).find('#default_add_checkbox').css("display", "none");
        jQuery(parent_id).find('#add_option').css("display", "none");
        jQuery(parent_id).find('#default_add_option').css("display", "none");
        jQuery(parent_id).find('input.default_value').removeAttr('disabled');
        jQuery(parent_id).find('input.default_placeholder').removeAttr('disabled');
    }
});
/*
 *Delete dynamic sub-fields of Radio
 */
function delete_radio_fields(this_parent_id, radio_id) {
    var parent_id = "#form_field_row_" + this_parent_id;
    var radio_del_res = jQuery(parent_id + ' #add_radio_checkbox').find('#add_radio input').length;
    if (radio_del_res > 1) {
        jQuery(parent_id + " #radio_field_" + radio_id).remove();
        jQuery(parent_id + " #delete_radio_" + radio_id).remove();
        jQuery(parent_id + " #add_new_radio_" + radio_id).remove();
        jQuery(parent_id + " #default_radio_value_" + radio_id).remove();
    }
}
/*
 *Add dynamic sub-fields of Radio
 */
function add_new_radio_fields(this_parent_id, radio_id) {
    var parent_id = "#form_field_row_" + this_parent_id;
    var new_radio_id = radio_id + 1;
    jQuery(parent_id + " #add_new_radio_" + radio_id).remove();
    jQuery(parent_id + ' #delete_radio_' + radio_id).css("display", "inline-block");
    var radio_add = "<p class='button lf_plus' id='add_new_radio_" + new_radio_id + "' onclick='add_new_radio_fields(" + this_parent_id + "," + new_radio_id + ")'>+</p>";
    var radio_del = "<p class='button lf_minus' id='delete_radio_" + new_radio_id + "' onclick='delete_radio_fields(" + this_parent_id + "," + new_radio_id + ")'>-</p>";
    var radio_field = "<input type='text' class='input_radio_val' name='form_field_" + this_parent_id + "[field_type][field_" + new_radio_id + "]' id='radio_field_" + new_radio_id + "' placeholder='radio name " + new_radio_id + "'value=''>";
    var radio_fields = radio_field + "" + radio_del + "" + radio_add;
    jQuery(parent_id + ' #add_radio').append(radio_fields);
    var default_add_radio = "<p id='default_radio_value_" + new_radio_id + "'>radio name " + new_radio_id + " <input type='radio' class='' name='form_field_" + this_parent_id + "[default_value][field]' id='default_radio_val_" + new_radio_id + "' value='" + new_radio_id + "'></p>";
    jQuery(parent_id + ' #default_add_radio').append(default_add_radio);
    jQuery(parent_id + ' #delete_radio_' + new_radio_id).css("display", "none");
}
/*
 *Delete dynamic sub-fields of Checkbox
 */
function delete_checkbox_fields(this_parent_id, checkbox_id) {
    var parent_id = "#form_field_row_" + this_parent_id;
    var checkbox_del_res = jQuery(parent_id + ' #add_radio_checkbox').find('#add_checkbox input').length;
    if (checkbox_del_res > 1) {
        jQuery(parent_id + " #checkbox_field_" + checkbox_id).remove();
        jQuery(parent_id + " #delete_checkbox_" + checkbox_id).remove();
        jQuery(parent_id + " #add_new_checkbox_" + checkbox_id).remove();
        jQuery(parent_id + " #default_checkbox_value_" + checkbox_id).remove();
    }
}
/*
 *Add dynamic sub-fields of Checkbox
 */
function add_new_checkbox_fields(this_parent_id, checkbox_id) {
    var new_checkbox_id = checkbox_id + 1;
    var parent_id = "#form_field_row_" + this_parent_id;
    jQuery(parent_id + " #add_new_checkbox_" + checkbox_id).remove();
    jQuery(parent_id + ' #delete_checkbox_' + checkbox_id).css("display", "inline-block");
    var checkbox_add = "<p class='button lf_plus' id='add_new_checkbox_" + new_checkbox_id + "' onclick='add_new_checkbox_fields(" + this_parent_id + "," + new_checkbox_id + ")'>+</p>";
    var checkbox_del = "<p class='button lf_minus' id='delete_checkbox_" + new_checkbox_id + "' onclick='delete_checkbox_fields(" + this_parent_id + "," + new_checkbox_id + ")'>-</p>";
    var checkbox_field = "<input type='text' class='input_checkbox_val' name='form_field_" + this_parent_id + "[field_type][field_" + new_checkbox_id + "]' id='checkbox_field_" + new_checkbox_id + "' placeholder='checkbox name " + new_checkbox_id + "'value=''>";
    var checkbox_fields = checkbox_field + "" + checkbox_del + "" + checkbox_add;
    jQuery(parent_id + ' #add_checkbox').append(checkbox_fields);
    var default_add_checkbox = "<p id='default_checkbox_value_" + new_checkbox_id + "'>checkbox name " + new_checkbox_id + " <input type='checkbox' class='' name='form_field_" + this_parent_id + "[default_value][field_" + new_checkbox_id + "]' id='default_checkbox_val_" + new_checkbox_id + "' value='1'></p>";
    jQuery(parent_id + ' #default_add_checkbox').append(default_add_checkbox);
    jQuery(parent_id + ' #delete_checkbox_' + new_checkbox_id).css("display", "none");
}
/*
 *Delete dynamic sub-fields of Option
 */
function delete_option_fields(this_parent_id, option_id) {
    var parent_id = "#form_field_row_" + this_parent_id;
    var option_del_res = jQuery(parent_id + ' #add_radio_checkbox').find('#add_option input').length;
    if (option_del_res > 1) {
        jQuery(parent_id + " #option_field_" + option_id).remove();
        jQuery(parent_id + " #delete_option_" + option_id).remove();
        jQuery(parent_id + " #add_new_option_" + option_id).remove();
        jQuery(parent_id + " #default_option_value_" + option_id).remove();
    }
}
/*
 *Add dynamic sub-fields of Option
 */
function add_new_option_fields(this_parent_id, option_id) {
    var new_option_id = option_id + 1;
    var parent_id = "#form_field_row_" + this_parent_id;
    jQuery(parent_id + " #add_new_option_" + option_id).remove();
    jQuery(parent_id + ' #delete_option_' + option_id).css("display", "inline-block");
    var option_add = "<p class='button lf_plus' id='add_new_option_" + new_option_id + "' onclick='add_new_option_fields(" + this_parent_id + "," + new_option_id + ")'>+</p>";
    var option_del = "<p class='button lf_minus' id='delete_option_" + new_option_id + "' onclick='delete_option_fields(" + this_parent_id + "," + new_option_id + ")'>-</p>";
    var option_field = "<input type='text' class='input_option_val' name='form_field_" + this_parent_id + "[field_type][field_" + new_option_id + "]' id='option_field_" + new_option_id + "' placeholder='option name " + new_option_id + "'value=''>";
    var option_fields = option_field + "" + option_del + "" + option_add;
    jQuery(parent_id + ' #add_option').append(option_fields);
    var default_add_option = "<p id='default_option_value_" + new_option_id + "'>option name " + new_option_id + " <input type='radio' class='' name='form_field_" + this_parent_id + "[default_value][field]' id='default_option_val_" + new_option_id + "' value=" + new_option_id + "></p>";
    jQuery(parent_id + ' #default_add_option').append(default_add_option);
    jQuery(parent_id + ' #delete_option_' + new_option_id).css("display", "none");
}
/*
 *Save email setting for each form
 */
jQuery("form#form-email-setting").submit(function(event) {    
        var form_data = jQuery("form#form-email-setting").serialize();
        form_data = form_data + "&action=SaveEmailSettings";
        event.preventDefault();
        jQuery("#error-message-email-setting").find("div").remove();
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
		//alert(response);
        if(jQuery.trim(response)=='updated'|| jQuery.trim(response)==''){
            jQuery("#error-message-email-setting").append("<div class='success'><p>Updated Succesfully..!!</p></div>");
            }else{
             jQuery("#error-message-email-setting").append("<div class='error'><p>Something Went Wrong..!!</p></div>");   
            }
        });
    })
	/*
 *Save user email setting for each form
 */
jQuery("form#form-user-email-setting").submit(function(event) {    
        var form_data = jQuery("form#form-user-email-setting").serialize();
        form_data = form_data + "&action=SaveUserEmailSettings";
        event.preventDefault();
        jQuery("#error-message-user-email-setting").find("div").remove();
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
        if(jQuery.trim(response)=='updated'||jQuery.trim(response)==''){
            jQuery("#error-message-user-email-setting").append("<div class='success'><p>Updated Succesfully..!!</p></div>");
            }else{
             jQuery("#error-message-user-email-setting").append("<div class='error'><p>Something Went Wrong..!!</p></div>");   
            }
        });
    })
    /*
     *Save captcha setting for each form
     */
     jQuery("form#captcha-form").submit(function(event) {
        var form_data = jQuery("form#captcha-form").serialize();
        form_data = form_data + "&action=SaveCaptchaSettings";
		jQuery("#error-message-captcha-key").find("div").remove();
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
		 if(jQuery.trim(response)=='updated'|| jQuery.trim(response)==''){
            jQuery("#error-message-captcha-key").append("<div class='success'><p>Updated Succesfully..!!</p></div>");
            }
            
        });
        event.preventDefault();
    })
    /*
     *Save leads setting for each form
     */
    jQuery("form#lead-email-setting").submit(function(event) {
        var form_data = jQuery("form#lead-email-setting").serialize();
        event.preventDefault();
        form_data = form_data + "&action=SaveLeadSettings";
        jQuery("#error-message-lead-store").find("div").remove();
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
            //alert(response);
             if(jQuery.trim(response)=='updated'|| jQuery.trim(response)==''){
            jQuery("#error-message-lead-store").append("<div class='success'><p>Updated Succesfully..!!</p></div>");
            }else{
             jQuery("#error-message-lead-store").append("<div class='error'><p>Something Went Wrong..!!</p></div>");   
            }
        });
    })
    /*
     *Save captcha enable/disable for each form
     */
jQuery("form#captcha-on-off-setting").submit(function(event) {
        var form_data = jQuery("form#captcha-on-off-setting").serialize();
        form_data = form_data + "&action=SaveCaptchaOption";
        event.preventDefault();
        jQuery("#error-message-captcha-option").find("div").remove();
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
            //alert(response);
            if(jQuery.trim(response)=='updated'|| jQuery.trim(response)==''){
            jQuery("#error-message-captcha-option").append("<div class='success'><p>Updated Succesfully..!!</p></div>");
            }else{
             jQuery("#error-message-captcha-option").append("<div class='error'><p>Something Went Wrong..!!</p></div>");   
            }
        });
    })
    /*
     *Send data to save by Ajax 
     */
function SaveByAjaxRequest(data, method) {
    return jQuery.ajax({
        url: backendajax.ajaxurl,
        type: method,
        data: data,
        cache: false
    });
}
/*
 *Show leads according to form in back-end.
 */
jQuery('#select_form_lead').on('change', function() {
    var form_id = jQuery(this).val();
    form_data = "form_id=" + form_id + "&action=ShowAllLeadThisForm";
    SaveByAjaxRequest(form_data, 'POST').success(function(response) {
        jQuery('#form-leads-show').empty();
        jQuery('#form-leads-show').append(response);
    });
});
/*
 *Delete particular Leads
 */
function delete_this_lead(this_lead_id) {
  if (confirm("OK to Delete?")) {
    jQuery('#lead-id-'+this_lead_id).remove();
    form_data = "&lead_id="+this_lead_id+"&action=delete_leads_backend";
    SaveByAjaxRequest(form_data, 'POST').success(function(response) {
    })
	}
}

function lead_pagination(page_id,form_id){
event.preventDefault();
    var form_data = "form_id=" + form_id + "&id=" + page_id + "&action=ShowAllLeadThisForm";
    SaveByAjaxRequest(form_data, 'GET').success(function(response) {
        jQuery('#form-leads-show').empty();
        jQuery('#form-leads-show').append(response);
    });
}

function lead_pagination_datewise(page_id,form_id,datewise){
event.preventDefault();
    var form_data = "form_id=" + form_id + "&id=" + page_id + "&datewise=" + datewise + "&action=ShowAllLeadThisFormDate";
   //alert(form_data);
   SaveByAjaxRequest(form_data, 'GET').success(function(response) {
    jQuery('#form-leads-show').empty();
    jQuery('#form-leads-show').append(response);
  });
}

function show_all_leads(page_id,form_id){
    event.preventDefault();
    var form_data = "form_id=" + form_id + "&id=" + page_id + "&detailview=1&action=ShowAllLeadThisForm";
    SaveByAjaxRequest(form_data, 'GET').success(function(response) {
        jQuery('#form-leads-show').empty();
        jQuery('#form-leads-show').append(response);
    });
}


function remember_this_form_id(){
if (confirm("OK to Remember?")) {
var form_id = jQuery('#select_form_lead').val();
jQuery('#remember_this_message').find('div').remove();
var form_data = "form_id=" + form_id + "&action=RememberMeThisForm";
    SaveByAjaxRequest(form_data, 'POST').success(function(response) {
        if(jQuery.trim(form_id)==jQuery.trim(response)){
       jQuery('#remember_this_message').append("<div><i>Saved Succesfully...!!</i></div>");
        }
    });
	}
}

jQuery(function(){
    jQuery(".lf-column-captcha ul li").click(function(){
	if (confirm("OK to Change?")) {
        jQuery(this).parent().find("li").removeClass("lf-on");
        jQuery(this).addClass("lf-on"); 
        var this_catcha_id = jQuery(this).attr("id"); 
        var this_catcha_status = jQuery(this).find("p").text(); 
        var this_catcha_id = this_catcha_id.substr(18);
        var form_data = "captcha-on-off-setting=" + this_catcha_status + "&captcha_on_off_form_id=" + this_catcha_id + "&action=SaveCaptchaOption";
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
         });
		}
    });
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
    SaveByAjaxRequest(form_data, 'POST').success(function(response) {
        //alert(response);
		//element.find(".leadform-show-message-form-"+form_id).append(response);
		element.find('#loading_image').hide();;
        if (jQuery.trim(response) == 'invalidcaptcha') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='error'><p>Invalid Captcha</p></div>");
        } else if (jQuery.trim(response) == 'inserted') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='message'><p>Thank you for submitting form..!!</p></div>");
			jQuery("form.lead-form-front")[0].reset();
        }
    });
    }else{
    form_data = "&captcha_res="+captcha_res+"&action=verifyFormCaptcha";
    SaveByAjaxRequest(form_data, 'POST').success(function(response) {
	//alert(response);
    element.find('#loading_image').hide();
        if (jQuery.trim(response) == 'Yes') {
        form_data = this_form_data + "&action=Save_Form_Data";
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
		 //alert(response);
        if (jQuery.trim(response) == 'invalidcaptcha') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='error'><p>Invalid Captcha</p></div>");
			grecaptcha.reset();
        } else if (response == 'inserted') {
            element.find(".leadform-show-message-form-"+form_id).append("<div class='message'><p>Thank you for submitting form..!!</p></div>");
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

    /*
     *Save form size
     */
    jQuery("form#lf-form-size-setting").submit(function(event) {
        var form_data = jQuery("form#lf-form-size-setting").serialize();
        event.preventDefault();
		//alert(form_data);
        form_data = form_data + "&action=LFSaveFormsize";
        jQuery("#lf-error-message-form-size").find("div").remove();
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
            //alert(response);
             if(jQuery.trim(response)=='updated'||jQuery.trim(response)==''){
            jQuery("#lf-error-message-form-size").append("<div class='success'><p>Updated Succesfully..!!</p></div>");
            }else{
             jQuery("#lf-error-message-form-size").append("<div class='error'><p>Something Went Wrong..!!</p></div>");   
            }
        });
    })
	    /*
     *Save form skin
     */
    jQuery("form#lf-form-color-setting").submit(function(event) {
        var form_data = jQuery("form#lf-form-color-setting").serialize();
        event.preventDefault();
		//alert(form_data);
        form_data = form_data + "&action=LFSaveFormskin";
        jQuery("#lf-error-message-form-color").find("div").remove();
        SaveByAjaxRequest(form_data, 'POST').success(function(response) {
           // alert(response);
             if(jQuery.trim(response)=='updated'|| jQuery.trim(response)==''){
            jQuery("#lf-error-message-form-color").append("<div class='success'><p>Updated Succesfully..!!</p></div>");
            }else{
             jQuery("#lf-error-message-form-color").append("<div class='error'><p>Something Went Wrong..!!</p></div>");   
            }
        });
    })
 function lfbresizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }


