<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Class LFB_LeadStoreType{
function lfb_store_type_one($form_id,$form_data,$mail_setting){
	$this->lfb_send_data_email($form_id,$form_data,$mail_setting);
  echo "inserted";
}

function lfb_store_type_two($form_id,$form_data){
	$this->lfb_save_data($form_id,$form_data);
}

function lfb_store_type_three($form_id,$form_data,$mail_setting){
	$this->lfb_save_data($form_id,$form_data);
	$this->lfb_send_data_email($form_id,$form_data,$mail_setting);
}

function lfb_save_data($form_id,$form_data){
    $server_request = $_SERVER['HTTP_USER_AGENT'];
	$ip_address = $this->lfb_get_user_ip_addres();
    global $wpdb;
    $data_table_name = LFB_FORM_DATA_TBL;

   $update_leads = $wpdb->query( $wpdb->prepare( 
     "INSERT INTO $data_table_name ( form_id, form_data, ip_address, server_request, date ) 
     VALUES ( %d, %s, %s, %s, %s )",
      $form_id, $form_data, $ip_address, $server_request, date('Y/m/d g:i:s') ) );
    if ($update_leads) {
        echo "inserted";
    }
}

function lfb_send_data_email($form_id,$form_data,$mail_setting){
    $form_data = maybe_unserialize($form_data);
	$form_entry_data= '';
	foreach($form_data as $form_entry_key => $form_entry_val ){
	$form_entry_data .= "<br/><b>".$form_entry_key."</b> : ".$form_entry_val;
	}
	$form_entry_data .=	"<br/>";
   $headers[] = 'Content-Type: text/html; charset=UTF-8';
   if(!empty($mail_setting)){
   $to = $mail_setting['email_setting']['to'];
   $subject =$mail_setting['email_setting']['subject'];
   $message  =$mail_setting['email_setting']['message'];
   $shortcodes_a =  '[lf-new-form-data]';
   $shortcodes_b =  $form_entry_data;               
   $new_message = '';
   $new_message = str_replace($shortcodes_a, $shortcodes_b, $message);

   $sitelink = preg_replace('#^https?://#', '', site_url());
   $headers[] = "From:".$sitelink." <".$mail_setting['email_setting']['from'].">";
   $headers[] = "Reply-To:".$sitelink." <".$mail_setting['email_setting']['from'].">";

   }else{
   $to = get_option('admin_email');
   $subject ='New Lead Recieved';
   $new_message = '<br/><br/>'.$form_entry_data;
   }
   wp_mail( $to, $subject, $new_message, $headers);
}

function lfb_get_user_ip_addres(){
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
}
function lfb_useremail_send($usermail_setting,$user_emailid){
   $usermail_setting = maybe_unserialize($usermail_setting);
   $headers[] = 'Content-Type: text/html; charset=UTF-8';
   $to = $user_emailid;
   $subject =$usermail_setting['user_email_setting']['subject'];
   $message  =$usermail_setting['user_email_setting']['message'];
   wp_mail( $to, $subject, $message, $headers);
}
}