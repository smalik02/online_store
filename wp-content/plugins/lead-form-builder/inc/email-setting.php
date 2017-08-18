<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Class LFB_EmailSettingForm {
    function __construct($this_form_id) {
        global $wpdb;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $table_name = LFB_FORM_FIELD_TBL;
        $prepare_9 =  $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d LIMIT 1",$this_form_id );
        $posts = $th_save_db->lfb_get_form_content($prepare_9);
        if ($posts){
            $form_title = $posts[0]->form_title;
            $form_status = $posts[0]->form_status;
            $captcha_status = $posts[0]->captcha_status;
            $storeType = $posts[0]->storeType;
            $storedate = $posts[0]->date;
            $mail_setting = maybe_unserialize($posts[0]->mail_setting);
			$usermail_setting = maybe_unserialize($posts[0]->usermail_setting);
            $form_data = maybe_unserialize($posts[0]->form_data);
        }
    }

    function lfb_email_setting_form($this_form_id, $mail_setting_result,$usermail_setting) {
        if (!empty($mail_setting_result)) {
            $mail_setting_result = maybe_unserialize($mail_setting_result);
            $mail_setting_to = $mail_setting_result['email_setting']['to'];
            $mail_setting_from = $mail_setting_result['email_setting']['from'];
            $mail_setting_subject = $mail_setting_result['email_setting']['subject'];
            $mail_setting_message = $mail_setting_result['email_setting']['message'];
			
        } else {
            $mail_setting_to = get_option('admin_email');
            $mail_setting_from = get_option('admin_email');
            $mail_setting_subject = "";
            $mail_setting_message = "";
        }
        echo "<form id='form-email-setting' action='' method='post'>
    <div class='inside email_setting_section'>
     <div class='card'>
	 <div class='infobox'>
        <h1>Admin Email</h1><br>
        <table class='form-table'>
            <tbody>
                <tr><th scope='row'><label for='email_setting_to'>To</label></th>
                    <td><input name='email_setting[to]' required type='email' id='email_setting_to' value='" . $mail_setting_to . "' class='regular-text'>
                        <p class='description' id='from-description'>To address for emails.</p></td>
                </tr>
                <tr><th scope='row'><label for='email_setting_from'>From</label></th>
                    <td><input name='email_setting[from]' required type='email' id='email_setting_from' value='" . $mail_setting_from . "' class='regular-text'>
                        <p class='description' id='from-description'>From address for emails.</p></td>
                </tr>
                <tr>
                    <th scope='row'><label for='email_setting_subject'>Subject</label></th>
                    <td><input name='email_setting[subject]' required type='text' id='email_setting_subject' value='" . $mail_setting_subject . "' class='regular-text'>
                        <p class='description' id='subject-description'>Your emails subject line.</p></td>
                </tr>
                <tr>
                    <th scope='row'><label for='email_setting_message'>Message</th>
                    <td>
                        <textarea name='email_setting[message]' required id='email_setting_message' rows='5' cols='46'>" . $mail_setting_message . "</textarea></label>
                        <p class='description' id='message-description'>Type your message here.<br/> Use code </i><b> [lf-new-form-data] </b></i> in your message to get the new form entry in email.</p></td>
                    </td>
                </tr>
                <tr>
                    <td><input type='hidden' name='email_setting[form-id]' required value='" . $this_form_id . "'> 
                    <input type='submit' class='button-primary' id='button' value='Save Setting'></p>
                    </td>
                </tr>
            </tbody></table>
    </div> </div>
</form><br/>
<div id='error-message-email-setting'></div>";
		if (!empty($usermail_setting)) {
            $usermail_setting_result = maybe_unserialize($usermail_setting);
            $usermail_setting_from = $usermail_setting_result['user_email_setting']['from'];
            $usermail_setting_subject = $usermail_setting_result['user_email_setting']['subject'];
            $usermail_setting_message = $usermail_setting_result['user_email_setting']['message'];
			$usermail_setting_option = $usermail_setting_result['user-email-setting-option'];
			
        } else {
            $usermail_setting_from = get_option('admin_email');
            $usermail_setting_subject = "";
            $usermail_setting_message = "";
			$usermail_setting_option= "OFF";
        	}

echo "<form id='form-user-email-setting' action='' method='post'>
    <div class='inside email_setting_section'>
     <div class='card'>
	 <div class='infobox'>
        <h1>User Email</h1><br>
		<p>To send email to user on form submit please make sure that the form must contain one <b>Email</b> named field to collect emails of users.</p>
        <table class='form-table'>
            <tbody>
                <tr><th scope='row'><label for='user_email_setting_from'>From</label></th>
                    <td><input name='user_email_setting[from]' required type='email' id='user_email_setting_from' value='" . $usermail_setting_from . "' class='regular-text'>
                        <p class='description' id='from-description'>From address for emails.</p></td>
                </tr>
                <tr>
                    <th scope='row'><label for='user_email_setting_subject'>Subject</label></th>
                    <td><input name='user_email_setting[subject]' required type='text' id='user_email_setting_subject' value='" . $usermail_setting_subject . "' class='regular-text'>
                        <p class='description' id='subject-description'>Your emails subject line.</p></td>
                </tr>
                <tr>
                    <th scope='row'><label for='user_email_setting_message'>Message</th>
                    <td>
                        <textarea name='user_email_setting[message]' required id='user_email_setting_message' rows='5' cols='46'>" . $usermail_setting_message . "</textarea></label>
                        <p class='description' id='message-description'>Type Your message here.<br/></i></p></td>
                    </td>
                </tr>
				<tr>
				<th scope='row'><label for='user-email-setting'></th>
                <td>
                <p><input type='radio' name='user-email-setting-option' " . ($usermail_setting_option == 'ON' ? 'checked' : '' ) . " value='ON'><span>Send email to user when submit form.</span></p>
                <p><input type='radio' name='user-email-setting-option' " . ($usermail_setting_option == 'OFF' ? 'checked' : '' ) . " value='OFF'><span>Don't Send.</span></p>
                </td></tr>
				<tr>
                    <td><input type='hidden' name='user_email_setting[form-id]' required value='" . $this_form_id . "'> 
                    <input type='submit' class='button-primary' id='button' value='Save Setting'></p>
                    </td>
                </tr>
            </tbody></table> </div>
    </div> </div>
</form><br/>
<div id='error-message-user-email-setting'></div>";
    }

    function lfb_captcha_setting_form($this_form_id, $captcha_option) {
        if (isset($captcha_option)) {
            $captcha_option_val = $captcha_option;
        } else {
            $captcha_option_val = "OFF";
        }
        $captcha_sitekey = get_option('captcha-setting-sitekey');
        $captcha_secret = get_option('captcha-setting-secret');
        echo '<div class="wrap">
<div class="card" id="recaptcha">
<div class="infobox">
<h1>Captcha Setting</h1><br>
<a href="https://www.google.com/recaptcha/intro/index.html">Get your Keys</a></div>
<br class="clear">
<div class="inside">
<p>reCAPTCHA is a free service to protect your website from spam and abuse.</p>
<form method="post" id="captcha-form" action="">
<table>
<tbody>
<tr>
    <th scope="row"><label for="sitekey">Site Key</label></th>
    <td><input type="text" required value="' . $captcha_sitekey . '" id="sitekey" name="captcha-setting-sitekey" class="regular-text code"></td>
</tr>
<tr>
    <th scope="row"><label for="secret">Secret Key</label></th>
    <td><input type="text" required value="' . $captcha_secret . '" id="secret" name="captcha-setting-secret" class="regular-text code"></td>
</tr>
</tbody>
</table>
<input type="hidden" name="captcha-keys" required value="' . $this_form_id . '">
<p class="submit"><input type="submit" class="button button-primary" id="captcha_save_settings" value="Save" name="submit"></p>
</form><br/>
<div id="error-message-captcha-key"></div>
</div>
</div>
</div>';
        if ($captcha_sitekey) {
            echo '<div class="inside setting_section">
           <div class="card">
                <form name="" id="captcha-on-off-setting" method="post" action="">
                <p class="sec_head">Captcha Option</p>
                <p><input type="radio" name="captcha-on-off-setting" ' . ($captcha_option_val == "ON" ? 'checked' : "" ) . ' value="ON"><span>Enable Captcha in form</span></p>
                <p><input type="radio" name="captcha-on-off-setting" ' . ($captcha_option_val == "OFF" ? 'checked' : "" ) . ' value="OFF"><span>Disable Captcha in form</span></p>
                <p><input type="submit" class="button button-primary" id="captcha_on_off_form_id" value="Save"></p>
                <input type="hidden" name="captcha_on_off_form_id" required value="' . $this_form_id . '">
                </form><br/>
<div id="error-message-captcha-option"></div>            
            </div>
            </div>';
        }
    }

    function lfb_lead_setting_form($this_form_id, $lead_store_option) {
        if (isset($lead_store_option)) {
            $lead_store_option = $lead_store_option;
        } else {
            $lead_store_option = 2;
        }
        echo '<div class="inside setting_section">
           <div class="card">
                <form name="" id="lead-email-setting" method="post" action="">
                <p class="sec_head">Lead Receiving Method</p>
                <p><input type="radio" name="data-recieve-method" ' . ($lead_store_option == 1 ? 'checked' : "" ) . ' value="1"><span>Recieve Leads in Email</span></p>
                <p><input type="radio" name="data-recieve-method" ' . ($lead_store_option == 2 ? 'checked' : "" ) . ' value="2"><span>Save Leads in database(you can see all leads in the lead option)</span></p>
                <p><input type="radio" name="data-recieve-method" ' . ($lead_store_option == 3 ? 'checked' : "" ) . ' value="3"><span>Recieve Leads in Email and Save in database</span><br><span id="data-rec-met-err"></span></p>
                <p><input type="submit" class="button button-primary" id="advance_lead_setting" value="Update Setting"></p>
                <input type="hidden" name="action-lead-setting" value="' . $this_form_id . '">    
                </form><br/>
<div id="error-message-lead-store"></div>          
            </div>
            </div>';
			
		global $wpdb;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $table_name = LFB_FORM_FIELD_TBL;
        $prepare_10 =  $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d LIMIT 1",$this_form_id );
        $posts = $th_save_db->lfb_get_form_content($prepare_10);
        if ($posts){
        	$this_form_color = $posts[0]->form_skin;
            $this_form_size = isset($posts[0]->form_size)?$posts[0]->form_size:'medium';
        }else{
		    $this_form_color ="";
			$this_form_size = "";
		}
		
			echo '<div class="inside setting_section">
           <div class="card">
                <form name="" id="lf-form-size-setting" method="post" action="">
                <h1>Form Size</h1>
				<div class="tablenav top">
	            <p><select name="lf_form_size" id="bulk-action-selector-top">
	            <option value="small" '.($this_form_size == "small" ? 'selected' : "" ).'> Small Form </option>
		        <option value="medium" '.($this_form_size == "medium" ? 'selected' : "" ).'> Medium Form </option>
		        <option value="large" '.($this_form_size == "large" ? 'selected' : "" ).'> Large Form </option>
                </select></p>
                </div>				
                <p><input type="submit" class="button button-primary" id="lf_form_size_setting" value="Update"></p>
                <input type="hidden" name="lf-form-size-setting" value="' . $this_form_id . '">    
                </form><br/>
                <div id="lf-error-message-form-size"></div>          
            </div>
            </div>';
    }
}