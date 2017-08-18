<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
 * Save Lead collecting method
 */

function lfb_save_lead_settings() {
    $data_recieve_method = intval($_POST['data-recieve-method']);
    $this_form_id = intval($_POST['action-lead-setting']);
    global $wpdb;
    $table_name = LFB_FORM_FIELD_TBL;
    $update_query = "update " . LFB_FORM_FIELD_TBL . " set storeType='" . esc_sql($data_recieve_method) . "' where id='" . esc_sql($this_form_id) . "'";
    $th_save_db = new LFB_SAVE_DB($wpdb);
    $update_leads = $th_save_db->lfb_update_form_data($update_query);
    if ($update_leads) {
        echo "updated";
    }

    die();
}

add_action('wp_ajax_SaveLeadSettings', 'lfb_save_lead_settings');

/*
 * Save Email Settings
 */

function lfb_save_email_settings() {
    unset($_POST['action']);
    $email_setting = maybe_serialize($_POST);
    $this_form_id = $_POST['email_setting']['form-id'];
    global $wpdb;
    $table_name = LFB_FORM_FIELD_TBL;
    $update_query = "update " . LFB_FORM_FIELD_TBL . " set mail_setting='" . esc_sql($email_setting) . "' where id='" . esc_sql($this_form_id) . "'";
    $th_save_db = new LFB_SAVE_DB($wpdb);
    $update_leads = $th_save_db->lfb_update_form_data($update_query);
    if ($update_leads) {
        echo "updated";
    }
    die();
}

add_action('wp_ajax_SaveEmailSettings', 'lfb_save_email_settings');
/*
 * Save Form Size
 */

function lfb_SaveFormsize() {
    $this_size = sanitize_text_field($_POST['lf_form_size']);
    $this_form_id = intval($_POST['lf-form-size-setting']);
    global $wpdb;
    $table_name = LFB_FORM_FIELD_TBL;
    $update_query = "update " . LFB_FORM_FIELD_TBL . " set form_size='" . esc_sql($this_size) . "' where id='" . esc_sql($this_form_id) . "'";
    $th_save_db = new LFB_SAVE_DB($wpdb);
    $update_leads = $th_save_db->lfb_update_form_data($update_query);
    if ($update_leads) {
        echo "updated";
    }
    die();
}

add_action('wp_ajax_LFSaveFormsize', 'lfb_SaveFormsize');

/*
 * Save Form Skin
 */

function lfb_SaveFormskin() {
    $this_skin = sanitize_text_field($_POST['lf_form_color']);
    $this_form_id = intval($_POST['lf-form-color-setting']);
    global $wpdb;
    $table_name = LFB_FORM_FIELD_TBL;
    $update_query = "update " . LFB_FORM_FIELD_TBL . " set form_skin='" . esc_sql($this_skin) . "' where id='" . esc_sql($this_form_id) . "'";
    $th_save_db = new LFB_SAVE_DB($wpdb);
    $update_leads = $th_save_db->lfb_update_form_data($update_query);
    if ($update_leads) {
        echo "updated";
    }
    die();
}

add_action('wp_ajax_LFSaveFormskin', 'lfb_SaveFormskin');

/*
 * Save captcha Keys
 */

function lfb_save_captcha_settings() {
$captcha_setting_sitekey = esc_html($_POST['captcha-setting-sitekey']);
$captcha_setting_secret = esc_html($_POST['captcha-setting-secret']);

if ( get_option('captcha-setting-sitekey') !== false ) {
    update_option('captcha-setting-sitekey', $captcha_setting_sitekey);
    update_option('captcha-setting-secret', $captcha_setting_secret);
} else {
    add_option('captcha-setting-sitekey', $captcha_setting_sitekey);
    add_option('captcha-setting-secret', $captcha_setting_secret);
}
    die();
}

add_action('wp_ajax_SaveCaptchaSettings', 'lfb_save_captcha_settings');

/*
 * Delete Leads From Back-end
 */
function lfb_delete_leads_backend() {
    if (isset($_POST['lead_id'])) {
        $this_lead_id = intval($_POST['lead_id']);
        global $wpdb;
        $table_name = LFB_FORM_DATA_TBL;

        $update_query = $wpdb->prepare(" DELETE FROM $table_name WHERE id = %d ", $this_lead_id);

        $th_save_db = new LFB_SAVE_DB($wpdb);
        $update_leads = $th_save_db->lfb_delete_form($update_query);
        echo $update_leads;
    }
}

add_action('wp_ajax_delete_leads_backend', 'lfb_delete_leads_backend');

/*
 * Save captcha status for form ON/OFF
 */

function lfb_save_captcha_option() {
    $captcha_option = sanitize_text_field($_POST['captcha-on-off-setting']);
    $this_form_id = intval($_POST['captcha_on_off_form_id']);
    global $wpdb;
    $table_name = LFB_FORM_FIELD_TBL;
    $update_query = "update " . LFB_FORM_FIELD_TBL . " set captcha_status='" . esc_sql($captcha_option) . "' where id='" . esc_sql($this_form_id) . "'";
    $th_save_db = new LFB_SAVE_DB($wpdb);
    $update_leads = $th_save_db->lfb_update_form_data($update_query);
    if ($update_leads) {
        echo "updated";
    }
    die();
}

add_action('wp_ajax_SaveCaptchaOption', 'lfb_save_captcha_option');

/*
 * Show Leads on Lead Page Based on form selection
 */

function lfb_ShowAllLeadThisForm() {
    if ((isset($_POST['form_id']) && ($_POST['form_id'] != '')) || (isset($_GET['form_id']) && ($_GET['form_id'] != ''))) {
        global $wpdb;
        $table_name = LFB_FORM_DATA_TBL;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $start = 0;
        $limit = 10;
        $detail_view = '';

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $start = ($id - 1) * $limit;
            $form_id = intval($_GET['form_id']);
            $sn_counter = $start;
        } else {
            $id = 1;
            $form_id = intval($_POST['form_id']);
            $sn_counter = 0;
        }
        if (isset($_GET['detailview'])) {
            $detail_view = isset($_GET['detailview']);
        }
        $prepare = $wpdb->prepare("SELECT * FROM $table_name WHERE form_id = %d ORDER BY id DESC LIMIT $start , $limit",$form_id);

        $posts = $th_save_db->lfb_get_form_content($prepare);

        if (!empty($posts)) {
            $entry_counter = 0;
            echo '<table class="show-leads-table" id="show-leads-table" ><thead><tr><th>S.N.</th>';
            foreach ($posts as $results) {
                $table_row = '';
                $table_head = '';
                $sn_counter++;
                $row_size_limit = 0;
                $form_data = $results->form_data;
                $lead_id = $results->id;
                $form_data = maybe_unserialize($form_data);
                unset($form_data['hidden_field']);
                unset($form_data['action']);
                $entry_counter++;
                $complete_data = '';
				$popup_data_val= '';
                foreach ($form_data as $form_data_key => $form_data_value) {
                    $row_size_limit++;
					if (is_array($form_data_value)) {
					foreach ($form_data_value as $popup_data_check_value) {
                                $popup_data_val .= $popup_data_check_value . ',';
                            }
                            $complete_data .= '<br/> '.$form_data_key.' => '.$popup_data_val;
					}else{
					$complete_data .='<br/> '.$form_data_key.' => '.$form_data_value;
					}
                    if (($detail_view == 1) || ($row_size_limit < 6)) {
                        if ($entry_counter == 1) {
                            $table_head .='<th>' . $form_data_key . '</th>';
                        }
                        if (is_array($form_data_value)) {
                            $form_data_val = '';
                            foreach ($form_data_value as $form_data_check_value) {
                                $form_data_val .= $form_data_check_value . ',';
                            }
                            $table_row .= '<td>' . $form_data_val . '</td>';
                        } else {
                            $table_row .= '<td>' .$form_data_value . '</td>';
                        }
                    }if (($detail_view != 1) && ($row_size_limit == 6) && ($entry_counter == 1)) {
                        $table_head .='<th><input type="button" onclick="show_all_leads(' . $id . ',' . $form_id . ')" value="Show all fields"></th>';
                    }if (($detail_view != 1) && ($row_size_limit == 6)) {
                        $table_row .= '<td>. . . . .</td><td><a href="#lf-openModal-' . $lead_id . '" value="view">view</a></td>';
                    }
                }
						   /****/
			    echo '<div id="lf-openModal-'.$lead_id.'" class="lf-modalDialog">
                          <div><a href="#lf-close" title="Close" class="lf-close">X</a>'.$complete_data.'
                          </div>
                          </div>';
						  /****/
                echo $table_head . '</tr></thead><tbody id="lead-id-' . $lead_id . '">';
                echo '<tr><td>' . $sn_counter . '</td>' . $table_row . '<td><input type="button" onclick="delete_this_lead(' . $lead_id . ')" value="del"></td></tr>';
            }
            echo '</tbody><table>';

            $prepare_2 = $wpdb->prepare("SELECT * FROM $table_name WHERE form_id = %d ",$form_id);
            $rows = $th_save_db->lfb_get_form_content($prepare_2);
            $rows = count($rows);
            $total = ceil($rows / $limit);
            if ($id > 1) {
                echo "<a href=''  onclick='lead_pagination(" . ($id - 1) . "," . $form_id . ")' class='button'>PREVIOUS</a>";
            }
            if ($id != $total) {
                echo "<a href='' onclick='lead_pagination(" . ($id + 1) . "," . $form_id . ")' class='button'>NEXT</a>";
            }
            echo "<ul class='page'>";
            for ($i = 1; $i <= $total; $i++) {
                if ($i == $id) {
                    echo "<li class='lf-current'>" . $i . "</li>";
                } else {
                    echo "<li><a href='' onclick='lead_pagination(" . $i . "," . $form_id . ")'>" . $i . "</a></li>";
                }
            }
            echo '</ul>';
        } else {
            echo "Opps No lead...!!";
        }
        die();
    }
}

add_action('wp_ajax_ShowAllLeadThisForm', 'lfb_ShowAllLeadThisForm');

/*
 * Show Leads on Lead Page Based on form selection
 */

function lfb_ShowAllLeadThisFormDate() {
    if ((isset($_POST['form_id']) && ($_POST['form_id'] != '')) || (isset($_GET['form_id']) && ($_GET['form_id'] != ''))) {
        global $wpdb;
        $table_name = LFB_FORM_DATA_TBL;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $start = 0;
        $limit = 10;
        $detail_view = '';

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $datewise = $_GET['datewise'];
            $start = ($id - 1) * $limit;
            $form_id = intval($_GET['form_id']);
            $sn_counter = $start;
        } else {
            $id = 1;
            $datewise ='';
            $sn_counter = 0;
        }
        if (isset($_GET['detailview'])) {
            $detail_view = isset($_GET['detailview']);
        }

        if($datewise=="total_leads"){
            $prepare_3 = $wpdb->prepare( "SELECT * FROM $table_name WHERE form_id = %d ORDER BY id DESC LIMIT $start , $limit ",  $form_id);
            $prepare_4 = $wpdb->prepare( "SELECT * FROM $table_name WHERE form_id = %d",  $form_id);

        $posts = $th_save_db->lfb_get_form_content($prepare_3);
        $rows = $th_save_db->lfb_get_form_content($prepare_4);    
        }else if($datewise=="today_leads"){
        $today_date= date('Y/m/d');
        $newDate = date("Y/m/d H:i:s", strtotime($today_date));

         $prepare_5 = $wpdb->prepare( "SELECT * FROM $table_name WHERE date > %s and form_id = %d ORDER BY id DESC LIMIT $start , $limit", $newDate, $form_id);
         $prepare_6 = $wpdb->prepare( "SELECT * FROM $table_name WHERE date > %s and form_id = %d ORDER BY id DESC LIMIT $start , $limit", $newDate, $form_id);
        $posts = $th_save_db->lfb_get_form_content($prepare_5);
        $rows = $posts; 
        }

        if (!empty($posts)) {
            $entry_counter = 0;
            echo '<table class="show-leads-table" id="show-leads-table" ><thead><tr><th>S.N.</th>';
            foreach ($posts as $results) {
                $table_row = '';
                $table_head = '';
                $sn_counter++;
                $row_size_limit = 0;
                $form_data = $results->form_data;
                $lead_id = $results->id;
                $form_data = maybe_unserialize($form_data);
                unset($form_data['hidden_field']);
                unset($form_data['action']);
                $entry_counter++;
				$complete_data = '';
				$popup_data_val= '';
                foreach ($form_data as $form_data_key => $form_data_value) {
                    $row_size_limit++;
					if (is_array($form_data_value)) {
					foreach ($form_data_value as $popup_data_check_value) {
                                $popup_data_val .= $popup_data_check_value . ',';
                            }
                            $complete_data .= '<br/> '.$form_data_key.' => '.$popup_data_val;
					}else{
					$complete_data .='<br/> '.$form_data_key.' => '.$form_data_value;
					}
                    if (($detail_view == 1) || ($row_size_limit < 6)) {
                        if ($entry_counter == 1) {
                            $table_head .='<th>' . $form_data_key . '</th>';
                        }
                        if (is_array($form_data_value)) {
                            $form_data_val = '';
                            foreach ($form_data_value as $form_data_check_value) {
                                $form_data_val .= $form_data_check_value . ',';
                            }
                            $table_row .= '<td>' . $form_data_val . '</td>';
                        } else {
                            $table_row .= '<td>' .$form_data_value. '</td>';
                        }
                    }if (($detail_view != 1) && ($row_size_limit == 6) && ($entry_counter == 1)) {
                        $table_head .='<th><input type="button" onclick="show_all_leads(' . $id . ',' . $form_id . ')" value="Show all fields"></th>';
                    }if (($detail_view != 1) && ($row_size_limit == 6)) {
                        $table_row .= '<td>. . . . .</td><td><a href="#lf-openModal-' . $lead_id . '" value="view">view</a></td>';
                    }
                }
						   /****/
			    echo '<div id="lf-openModal-'.$lead_id.'" class="lf-modalDialog">
                          <div><a href="#lf-close" title="Close" class="lf-close">X</a>'.$complete_data.'
                          </div>
                          </div>';
						  /****/
                echo $table_head . '</tr></thead><tbody id="lead-id-' . $lead_id . '">';
                echo '<tr><td>' . $sn_counter . '</td>' . $table_row . '<td><input type="button" onclick="delete_this_lead(' . $lead_id . ')" value="del"></td></tr>';
            }
            echo '</tbody><table>';

            $rows = count($rows);
            $total = ceil($rows / $limit);
            if ($id > 1) {
                echo "<a href=''  onclick='lead_pagination_datewise(" . ($id - 1) . "," . $form_id . ",\"".$datewise."\");' class='button'>PREVIOUS</a>";
            }
            if ($id != $total) {
                echo "<a href='' onclick='lead_pagination_datewise(" . ($id + 1) . "," . $form_id . ",\"".$datewise."\");' class='button'>NEXT</a>";
            }
            echo "<ul class='page'>";
            for ($i = 1; $i <= $total; $i++) {
                if ($i == $id) {
                    echo "<li class='lf-current'>" . $i . "</li>";
                } else {
                    echo "<li><a href='' onclick='lead_pagination_datewise(".$i.",".$form_id.",\"".$datewise."\");'>" . $i . "</a></li>";
                }
            }
            echo '</ul>';
        } else {
            echo "Opps No lead...!!";
        }
        die();
    }
}

add_action('wp_ajax_ShowAllLeadThisFormDate', 'lfb_ShowAllLeadThisFormDate');

/*
 * Save from Data from front-end
 */

    function lfb_Save_Form_Data() {
    $form_id = intval($_POST['hidden_field']);
    unset($_POST['g-recaptcha-response']);
	unset($_POST['action']);
	unset($_POST['hidden_field']);
	if((isset($_POST['Email']))&&($_POST['Email']!='')){
	$user_emailid =sanitize_email($_POST['Email']);
	}else{
	$user_emailid ='invalid_email';
	}
    $form_data = maybe_serialize($_POST);
    global $wpdb;
    $th_save_db = new LFB_SAVE_DB($wpdb);
    $table_name = LFB_FORM_FIELD_TBL;
    $prepare_7 =  $wpdb->prepare( "SELECT storeType, mail_setting, usermail_setting FROM $table_name WHERE id= %d LIMIT 1",$form_id );
    $posts = $th_save_db->lfb_get_form_content($prepare_7);
    $storeType = $posts[0]->storeType;
    $mail_setting = $posts[0]->mail_setting;
    $mail_setting = maybe_unserialize($mail_setting);
    $lf_store = new LFB_LeadStoreType();
    if ($storeType == 1) {
        $lf_store->lfb_store_type_one($form_id, $form_data, $mail_setting);
    }
    if ($storeType == 2) {
        $lf_store->lfb_store_type_two($form_id, $form_data);
    }
    if ($storeType == 3) {
        $lf_store->lfb_store_type_three($form_id, $form_data, $mail_setting);
    }
	$usermail_setting_raw = $posts[0]->usermail_setting;
    $usermail_setting = maybe_unserialize($usermail_setting_raw);
	if(!empty($usermail_setting)){
	$usermail_option = $usermail_setting['user-email-setting-option'];
	if(($usermail_option =="ON")&&($user_emailid !='invalid_email')){
	if (is_email($user_emailid)) {
	$lf_store->lfb_useremail_send($usermail_setting_raw,$user_emailid);
	}
	}
	}
    die();
}

add_action('wp_ajax_Save_Form_Data', 'lfb_Save_Form_Data');
add_action('wp_ajax_nopriv_Save_Form_Data', 'lfb_Save_Form_Data');

function lfb_verifyFormCaptcha() {
if ((isset($_POST['captcha_res'])) && (!empty($_POST['captcha_res']))) {
        $captcha = stripslashes($_POST['captcha_res']);
        $secret_key = get_option('captcha-setting-secret');
$response = wp_remote_post(
  'https://www.google.com/recaptcha/api/siteverify',
  array(
    'method' => 'POST',
    'body' => array(
      'secret' => $secret_key,
      'response' => $captcha
    )
  )
);
$reply_obj = json_decode( wp_remote_retrieve_body( $response ) );
       if(isset($reply_obj->success) && $reply_obj->success==1){
         echo "Yes";
        }
        else{
         echo "No";
        }
    }else{
         echo "Invalid";
    }
    die();
    }
add_action('wp_ajax_verifyFormCaptcha', 'lfb_verifyFormCaptcha');
add_action('wp_ajax_nopriv_verifyFormCaptcha', 'lfb_verifyFormCaptcha');

function lfb_RememberMeThisForm(){
if ((isset($_POST['form_id'])) && (!empty($_POST['form_id']))) {

    $remember_me = intval($_POST['form_id']);
    if (get_option('lf-remember-me-show-lead') !== false ) {
    update_option('lf-remember-me-show-lead',$remember_me);
    }else{
    add_option('lf-remember-me-show-lead',$remember_me);
    }
    echo get_option('lf-remember-me-show-lead');
    die();
}
}
add_action('wp_ajax_RememberMeThisForm', 'lfb_RememberMeThisForm');


/*
 * Save Email Settings
 */

function lfb_SaveUserEmailSettings() {
    unset($_POST['action']);
    $email_setting = maybe_serialize($_POST);
    $this_form_id = $_POST['user_email_setting']['form-id'];
    global $wpdb;
    $table_name = LFB_FORM_FIELD_TBL;
    $update_query = "update " . LFB_FORM_FIELD_TBL . " set usermail_setting='" . esc_sql($email_setting) . "' where id='" . esc_sql($this_form_id) . "'";
    $th_save_db = new LFB_SAVE_DB($wpdb);
    $update_leads = $th_save_db->lfb_update_form_data($update_query);
    if ($update_leads) {
        echo "updated";
    }
    die();
}
add_action('wp_ajax_SaveUserEmailSettings', 'lfb_SaveUserEmailSettings');