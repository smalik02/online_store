<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once('lf-db.php');
Class LFB_EDIT_DEL_FORM {
    function lfb_edit_form_content($form_action, $this_form_id) {
        global $wpdb;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $table_name = LFB_FORM_FIELD_TBL;
            $prepare_8 =  $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d LIMIT 1", $this_form_id  );
        $posts = $th_save_db->lfb_get_form_content($prepare_8);
        if ($posts){
            $form_title = $posts[0]->form_title;
            $form_data_result = maybe_unserialize($posts[0]->form_data);
            $mail_setting_result = $posts[0]->mail_setting;
			$usermail_setting_result = $posts[0]->usermail_setting;
            $captcha_option = $posts[0]->captcha_status;
            $lead_store_option = $posts[0]->storeType;

            $all_form_fields = $this->lfb_create_form_fields_for_edit($form_title, $form_data_result);
        }
       $form_message ='';
        if(isset($_GET['redirect'])){
        	$redirect_value= $_GET['redirect'];
        	if($redirect_value=='create'){
        $form_message='<div id="message" class="updated notice is-dismissible"><p>Form <strong>Saved</strong>.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	    }if($redirect_value=='update'){
	        $form_message='<div id="message" class="updated notice is-dismissible"><p>Form <strong>Updated</strong>.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	        }
	    }
        $nonce = wp_create_nonce( '_nonce_verify' );
        $update_url ="admin.php?page=add-new-form&action=edit&redirect=update&formid=".$this_form_id.'&_wpnonce='.$nonce;
        
        echo '<div class="wrap">
        <h2> Edit From</h2>'.$form_message.'
        <h2 class="nav-tab-wrapper lfb-nav-tab-wrapper">
            <a class="nav-tab nav-tab-active" href="#">Edit Form</a>
            <a class="nav-tab" href="#">Email Setting</a>
            <a class="nav-tab" href="#">Captcha Setting</a>
            <a class="nav-tab" href="#">Setting</a>
        </h2>
        <div id="sections">
            <section><div class="wrap">
        <h1>Form Settings</h1>
        <form method="post" action="'.$update_url.'" id="new_lead_form">
            <div id="poststuff">
                <div id="post-body">
                    <div id="post-body-content">
                        <div id="titlediv">
                            <div id="titlewrap">
                                <input type="text" class="new_form_heading" name="post_title" placeholder="Enter title here" value="' . $form_title . '" size="30" id="title" spellcheck="true" autocomplete="off"></div><!-- #titlewrap -->
                            <div class="inside">
                            </div>
                        </div><!-- #titlediv -->
                    </div><!-- #post-body-content -->
                </div>
            </div>';
        $this->lfb_basic_form();
        echo $all_form_fields;
        echo '</tbody><div id="append_new_field"></div>
            </table>
            <p class="submit"><input type="submit" class="update_form button-primary" name="update_form" id="update_form" value="Update Form"><input type="hidden" class="update_form_id button-primary" name="update_form_id" id="update_form_id" value="'.$this_form_id.'"></p>
                <input type="hidden" name = "_wpnonce" value="'.$nonce.'" />
            </td>
    </form>	
    </div>
    </section>
            <section>';
        if (is_admin()) {
            $lf_email_setting_form = new LFB_EmailSettingForm($this_form_id);
            $lf_email_setting_form->lfb_email_setting_form($this_form_id,$mail_setting_result,$usermail_setting_result);
        }
        echo '</section>
        <section>';
           if (is_admin()) {
                    $lf_email_setting_form = new LFB_EmailSettingForm($this_form_id);
                    $lf_email_setting_form->lfb_captcha_setting_form($this_form_id, $captcha_option);
                }
           echo '</section><section>';
           if (is_admin()) {
                    $lf_email_setting_form = new LFB_EmailSettingForm($this_form_id);
                    $lf_email_setting_form->lfb_lead_setting_form($this_form_id, $lead_store_option);
                }
           echo '</section></div>
    </div>';
    }
    
    function lfb_delete_form_content($form_action, $this_form_id, $page_id) {
    	global $wpdb;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $table_name = LFB_FORM_FIELD_TBL;
    $update_leads = $wpdb->update( 
    $table_name,
    array( 
        'form_status' => 'Disable'
    ), 
    array( 'id' =>$this_form_id));
    if($update_leads){    
        $th_show_forms = new LFB_SHOW_FORMS();
        $th_show_forms->lfb_show_all_forms($page_id);
    }
    }

    function lfb_basic_form() {
        echo "<div class='inside spth_setting_section'  id='wpth_add_form'>
	      <h2 class='sec_head'>Form Fields</h2>
	      <table class='widefat' id='sortable'>          
          <tbody class='append_new'>
	      <tr>
	      <th>S.N.</th>
	      <th>Field name</th>
	      <th>Field Type</th>
	      <th>Default Value</th>
	      <th>Use Default Value as Placeholder</th>
	      <th>Required</th>
	      <th>Action</th>
	      </tr>";
    }
/*
 * *For each for each form fields 
 */
    function lfb_create_form_fields_for_edit($form_title, $form_data_result) {
        $all_form_fields = "";
        $total_form_fields = count($form_data_result);
        $field_counter = 0;
        foreach ($form_data_result as $results) {
            $field_counter++;
            $this_form_fields = "";
	        $default_value = "";
	        $field_name= "";
	        $field_type= "";
	        $default_placeholder="";
	        $is_required="";
	        $field_id="";
            if (isset($results['field_name'])) {
                $field_name = $results['field_name'];
            }
            if (isset($results['field_type'])) {
                $field_type_array = $results['field_type'];
                $field_type = $field_type_array['type'];
                if (is_array($field_type_array)) {
                    unset($field_type_array['type']);
                } else {
                    $field_type = $field_type_array;
                }
            }
            if (isset($results['default_value'])) {
                $default_value = $results['default_value'];
                if (is_array($default_value)) {
                	if(isset($default_value['field'])){
                    $default_value = $default_value['field'];
                }else{
                    $default_value = $default_value;
                }
                } else {
                    $default_value = $default_value;
                }
            }

            if (isset($results['default_placeholder'])) {
                $default_placeholder = $results['default_placeholder'];
               } else {
                $default_placeholder = 0;
            }

            if (isset($results['is_required'])) {
                $is_required = $results['is_required'];
            } else {
                $is_required = 0;
            }

            if (isset($results['field_id'])) {
                $field_id = trim($results['field_id']);
            }

            $radio_fields = '';
            $default_add_radio = '';
            $option_fields = '';
            $default_add_option = '';
            $checkbox_fields = '';
            $default_add_checkbox = '';
            if ($field_type == "radio" || $field_type == "option" || $field_type == "checkbox") {

                $total_form_field_fields = count($field_type_array);
                $field_field_counter = 0;

                if ($field_type == "radio") {
                    foreach ($field_type_array as $field_type_array_element => $field_type_array_val) {
                        $field_field_counter++;
                        $field_type_array_element_id = str_replace("field_", "", $field_type_array_element);
                        if ($total_form_field_fields == $field_field_counter) {
                            $form_field_field_button = '<p class="button lf_minus" style="display:none;" id="delete_radio_' . $field_type_array_element_id . '" onclick="delete_radio_fields(' . $field_id . ',' . $field_type_array_element_id . ')">-</p><p class="button lf_plus" id="add_new_radio_' . $field_type_array_element_id . '" onclick="add_new_radio_fields(' . $field_id . ',' . $field_type_array_element_id . ')">+</p>';
                        } else {
                            $form_field_field_button = '<p class="button lf_minus" id="delete_radio_' . $field_type_array_element_id . '" onclick="delete_radio_fields(' . $field_id . ',' . $field_type_array_element_id . ')">-</p>';
                        }
                        $radio_fields .= '<input type="text" class="input_radio_val" name="form_field_' . $field_id . '[field_type][field_' . $field_type_array_element_id . ']" id="radio_field_' . $field_type_array_element_id . '" placeholder="radio name ' . $field_type_array_element_id . '"value="' . $field_type_array_val . '">' . $form_field_field_button;
                        if (($field_type_array_element_id == $default_value) && ($default_value > 0)) {
                            $default_add_radio .= '<p id="default_radio_value_' . $field_type_array_element_id . '">radio name ' . $field_type_array_element_id . ' <input type="radio" class="" name="form_field_' . $field_id . '[default_value][field]" id="default_radio_value_' . $field_type_array_element_id . '" value="' . $field_type_array_element_id . '" checked></p>';
                        } else {
                            $default_add_radio .= '<p id="default_radio_value_' . $field_type_array_element_id . '">radio name ' . $field_type_array_element_id . ' <input type="radio" class="" name="form_field_' . $field_id . '[default_value][field]" id="default_radio_value_' . $field_type_array_element_id . '" value="' . $field_type_array_element_id . '"</p>';
                        }
                    }
                }

                if ($field_type == "option") {
                    foreach ($field_type_array as $field_type_array_element => $field_type_array_val) {
                        $field_field_counter++;
                        $field_type_array_element_id = str_replace("field_", "", $field_type_array_element);
                        if ($total_form_field_fields == $field_field_counter) {
                            $form_field_field_button = '<p class="button lf_minus" style="display:none;" id="delete_option_' . $field_type_array_element_id . '" onclick="delete_option_fields(' . $field_id . ',' . $field_type_array_element_id . ')">-</p><p class="button lf_plus" id="add_new_option_' . $field_type_array_element_id . '" onclick="add_new_option_fields(' . $field_id . ',' . $field_type_array_element_id . ')">+</p>';
                        } else {
                            $form_field_field_button = '<p class="button lf_minus" id="delete_option_' . $field_type_array_element_id . '" onclick="delete_option_fields(' . $field_id . ',' . $field_type_array_element_id . ')">-</p>';
                        }
                        $option_fields .= '<input type="text" class="input_option_val" name="form_field_' . $field_id . '[field_type][field_' . $field_type_array_element_id . ']" id="option_field_' . $field_type_array_element_id . '" placeholder="option name ' . $field_type_array_element_id . '"value="' . $field_type_array_val . '">' . $form_field_field_button;
                        if (($field_type_array_element_id == $default_value) && ($default_value > 0)) {
                            $default_add_option .= '<p id="default_option_value_' . $field_type_array_element_id . '">option name ' . $field_type_array_element_id . ' <input type="radio" class="" name="form_field_' . $field_id . '[default_value][field]" id="default_option_value_' . $field_type_array_element_id . '" value="' . $field_type_array_element_id . '" checked></p>';
                        } else {
                            $default_add_option .= '<p id="default_option_value_' . $field_type_array_element_id . '">option name ' . $field_type_array_element_id . ' <input type="radio" class="" name="form_field_' . $field_id . '[default_value][field]" id="default_option_value_' . $field_type_array_element_id . '" value="' . $field_type_array_element_id . '"</p>';
                        }
                    }
                }

                if ($field_type == "checkbox") {
                    foreach ($field_type_array as $field_type_array_element => $field_type_array_val) {
                        $field_field_counter++;
                        $field_type_array_element_id = str_replace("field_", "", $field_type_array_element);
                        if ($total_form_field_fields == $field_field_counter) {
                            $form_field_field_button = '<p class="button lf_minus" style="display:none;" id="delete_checkbox_' . $field_type_array_element_id . '" onclick="delete_checkbox_fields(' . $field_id . ',' . $field_type_array_element_id . ')">-</p><p class="button lf_plus" id="add_new_checkbox_' . $field_type_array_element_id . '" onclick="add_new_checkbox_fields(' . $field_id . ',' . $field_type_array_element_id . ')">+</p>';
                        } else {
                            $form_field_field_button = '<p class="button lf_minus" id="delete_checkbox_' . $field_type_array_element_id . '" onclick="delete_checkbox_fields(' . $field_id . ',' . $field_type_array_element_id . ')">-</p>';
                        }

                        $checkbox_fields .= '<input type="text" class="input_checkbox_val" name="form_field_' . $field_id . '[field_type][field_' . $field_type_array_element_id . ']" id="checkbox_field_' . $field_type_array_element_id . '" placeholder="checkbox name ' . $field_type_array_element_id . '"value="'.$field_type_array_val.'">' . $form_field_field_button;

                        $default_element_val_counter = 0;
                        if(is_array($default_value)){
                        foreach ($default_value as $default_value_element => $default_value_val) {
                            $default_element_val_counter = 0;
                            if ($default_value_element == $field_type_array_element) {
                                $default_element_val_counter++;
                                $default_add_checkbox .='<p id="default_checkbox_value_' . $field_type_array_element_id . '">checkbox name ' . $field_type_array_element_id . ' <input type="checkbox" class="" name="form_field_' . $field_id . '[default_value][field_' . $field_type_array_element_id . ']" id="default_checkbox_val_' . $field_type_array_element_id . '" checked value="1"></p>';
                                break;
                            }
                        }
                    }
                        if ($default_element_val_counter == 0) {
                            $default_add_checkbox .='<p id="default_checkbox_value_' . $field_type_array_element_id . '">checkbox name ' . $field_type_array_element_id . ' <input type="checkbox" class="" name="form_field_' . $field_id . '[default_value][field_' . $field_type_array_element_id . ']" id="default_checkbox_val_' . $field_type_array_element_id . '" value="1"></p>';
                        }
                    }
                }
            }

            $select_option = '';
            if (($total_form_fields-1) == $field_counter) {
                $form_field_button = '<input type="button" class="button lf_addnew" name="add_new" id="add_new_' . $field_id . '" onclick="add_new_form_fields(' . $field_id . ')" value="Add New">';
                $form_field_last = '</tbody><div id="append_new_field"></div>';
            }else if ($total_form_fields == $field_counter) {
                $form_field_button = '';
                $form_field_last = '</table>';
            }
            else {
                $form_field_last ='';
                $form_field_button = '<input type="button" class="button lf_remove" name="remove_field" id="remove_field_"' . $field_id . '" onclick="remove_form_fields(' . $field_id . ')" value="Remove">';
            }

            if($field_type == "submit"){
            $form_field_select_op = '<option value="submit" selected="selected">Submit Button</option>';
            }else{
/*            <option value="upload" ' . ($field_type == "upload" ? 'selected="selected"' : "" ) . '>Upload</option>
*/
            $form_field_select_op = '<option value="select">Select Field Type</option>
            <option value="name" ' . ($field_type == "name" ? 'selected="selected"' : "" ) . '>Name</option>    
            <option value="email" ' . ($field_type == "email" ? 'selected="selected"' : "" ) . '>Email</option>
            <option value="message" ' . ($field_type == "message" ? 'selected="selected"' : "" ) . '>Message</option>    
            <option value="dob" ' . ($field_type == "dob" ? 'selected="selected"' : "" ) . '>DOB</option>    
            <option value="radio" ' . ($field_type == "radio" ? 'selected="selected"' : "" ) . '>Radio</option> 
            <option value="option" ' . ($field_type == "option" ? 'selected="selected"' : "" ) . '>Option</option>      
            <option value="checkbox" ' . ($field_type == "checkbox" ? 'selected="selected"' : "" ) . '>Checkbox</option>
            <option value="url" ' . ($field_type == "url" ? 'selected="selected"' : "" ) . '>Url</option>
            <option value="number" ' . ($field_type == "number" ? 'selected="selected"' : "" ) . '>Number</option>
            <option value="date" ' . ($field_type == "date" ? 'selected="selected"' : "" ) . '>Date</option>            
            <option value="text" ' . ($field_type == "text" ? 'selected="selected"' : "" ) . '>Text</option>
            <option value="textarea" ' . ($field_type == "textarea" ? 'selected="selected"' : "" ) . '>Textarea</option>';
            }
            $all_form_fields.= '<tr id="form_field_row_' . $field_id . '"><td>' . $field_id . '</td>
	      <td><input type="' . ($field_type == "submit" ? 'hidden' : "text" ) . '" name="form_field_' . $field_id . '[field_name]" id="field_name_' . $field_id . '" value="' . $field_name . '"></td>
		  <td>
		  <select class="form_field_select" name="form_field_' . $field_id . '[field_type][type]" id="field_type_' . $field_id . '">
           '.$form_field_select_op.'
           </select>
			<div class="add_radio_checkbox_' . $field_id . '" id="add_radio_checkbox">
			<div class="" id="add_radio">' . $radio_fields . '</div>
			<div class="" id="add_checkbox">' . $checkbox_fields . '</div>
			<div class="" id="add_option">' . $option_fields . '</div>
			</div>
		</td>
		<td><input type="text" class="default_value" name="form_field_' . $field_id . '[default_value]" id="default_value_' . $field_id . '" value="' . ($field_type == "radio" || $field_type == "option" || $field_type == "checkbox" ? "" : $default_value ) . '" ' . ($field_type == "radio" || $field_type == "option" || $field_type == "checkbox" ? 'disabled="disabled"' : "" ) . '>
		<div class="add_default_radio_checkbox_' . $field_id . '" id="add_default_radio_checkbox">
			<div class="" id="default_add_radio">' . $default_add_radio . '</div>
			<div class="" id="default_add_checkbox">' . $default_add_checkbox . '</div>
			<div class="" id="default_add_option">' . $default_add_option . '</div>
		</div>
		</td>
		<td><input type="' . ($field_type == "submit" ? 'hidden' : "checkbox" ) . '" class="default_placeholder" name="form_field_' . $field_id . '[default_placeholder]" ' . ($default_placeholder == 1 ? 'checked' : "" ) . ' id="default_placeholder_' . $field_id . '" value="1" ' . ($field_type == "radio" || $field_type == "option" || $field_type == "checkbox" ? 'disabled="disabled"' : "" ) . '>
		</td>
		<td><input type="' . ($field_type == "submit" ? 'hidden' : "checkbox" ) . '" name="form_field_' . $field_id . '[is_required]" id="is_required_' . $field_id . '" ' . ($is_required == 1 ? 'checked' : "" ) . ' value="1">
		</td>
		<td id="wpth_add_form_table_' . $field_id . '">' . ($field_type == "submit" ? '' : $form_field_button ) . '
		
		</td><input type="hidden" value="' . $field_id . '" name="form_field_' . $field_id . '[field_id]">
		</tr>'.$form_field_last;
        }
        return $all_form_fields;
    }
}