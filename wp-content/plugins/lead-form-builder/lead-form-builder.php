<?php
/*
  Plugin Name: Lead Form Builder
  Description: Creating a contact form has never been so easy. Integrate forms anywhere at your website using easy shortcode and widget.
  Version: 1.2.5
  Author: ThemeHunk
  Text Domain: lead-form-builder
  Author URI: http://www.themehunk.com/
 */
  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('LFB_PLUGIN_URL', plugin_dir_url(__FILE__));

// plugin active database
function lfb_plugin_activate() {
  $default_form = 0;
   global $wpdb;
   $lead_form = $wpdb->prefix . 'lead_form';
   $lead_form_data = $wpdb->prefix . 'lead_form_data';
   $charset_collate = $wpdb->get_charset_collate();
   if ($wpdb->get_var("SHOW TABLES LIKE '$lead_form'") != $lead_form) {
       $sql = "CREATE TABLE  $lead_form (
       id INT(10) NOT NULL AUTO_INCREMENT,
       form_title VARCHAR(255) NOT NULL,
       form_data text NOT NULL,
       date datetime NOT NULL,
       mail_setting text NOT NULL,
     usermail_setting text NOT NULL,
     form_size VARCHAR(255) DEFAULT 'medium' NOT NULL,
     form_skin VARCHAR(255) DEFAULT 'default' NOT NULL,
       form_status VARCHAR(50) DEFAULT 'ACTIVE' NOT NULL,       
       captcha_status VARCHAR(255) DEFAULT 'OFF' NOT NULL,
       storeType ENUM('1','2','3') DEFAULT '2' NOT NULL,
       PRIMARY KEY (id)
       ) $charset_collate;";
       $wpdb->query($sql);
       $default_form = 1;
   }
   if ($wpdb->get_var("SHOW TABLES LIKE '$lead_form_data'") != $lead_form_data) {
       $sql = "CREATE TABLE $lead_form_data(
       id INT(10) NOT NULL AUTO_INCREMENT,
       form_id INT(10),
       form_data LONGTEXT,
       ip_address VARCHAR(100),
       server_request TEXT,
       date datetime,
       PRIMARY KEY (id)
       )$charset_collate;";
       $wpdb->query($sql);  
   }
      if ($default_form >= 1) {
       $now_date= date('Y/m/d g:i:s');
     $form_title ='Contact Us';
       $form_data ='a:5:{s:12:"form_field_1";a:6:{s:10:"field_name";s:4:"Name";s:10:"field_type";a:1:{s:4:"type";s:4:"name";}s:13:"default_value";s:4:"Name";s:19:"default_placeholder";s:1:"1";s:11:"is_required";s:1:"1";s:8:"field_id";s:1:"1";}s:12:"form_field_2";a:6:{s:10:"field_name";s:5:"Email";s:10:"field_type";a:1:{s:4:"type";s:5:"email";}s:13:"default_value";s:5:"Email";s:19:"default_placeholder";s:1:"1";s:11:"is_required";s:1:"1";s:8:"field_id";s:1:"2";}s:12:"form_field_3";a:6:{s:10:"field_name";s:10:"Contact No";s:10:"field_type";a:1:{s:4:"type";s:6:"number";}s:13:"default_value";s:14:"Contact number";s:19:"default_placeholder";s:1:"1";s:11:"is_required";s:1:"1";s:8:"field_id";s:1:"3";}s:12:"form_field_4";a:6:{s:10:"field_name";s:7:"Message";s:10:"field_type";a:1:{s:4:"type";s:7:"message";}s:13:"default_value";s:7:"Message";s:19:"default_placeholder";s:1:"1";s:11:"is_required";s:1:"1";s:8:"field_id";s:1:"4";}s:12:"form_field_0";a:6:{s:10:"field_name";s:6:"submit";s:10:"field_type";a:1:{s:4:"type";s:6:"submit";}s:13:"default_value";s:0:"";s:19:"default_placeholder";s:1:"0";s:11:"is_required";s:1:"1";s:8:"field_id";s:1:"0";}}';
       $default_insert = "INSERT INTO $lead_form (form_title, form_data, date) VALUES ( '$form_title', '$form_data', '$now_date' );";
     $wpdb->query($default_insert);
     }
}
register_activation_hook(__FILE__, 'lfb_plugin_activate');

// plugin deactive hook
function lfb_plugin_deactivate(){
    if (get_option('lf-remember-me-show-lead') !== false ) {
    delete_option('lf-remember-me-show-lead',$remember_me);
    }
  }
register_deactivation_hook(__FILE__, 'lfb_plugin_deactivate');

/**
 * Add the settings link to the Lead Form Plugin plugin row
 *
 * @param array $links - Links for the plugin
 * @return array - Links
 */
function lfb_plugin_action_links($links) {
  $settings_page = add_query_arg(array('page' => 'wplf-plugin-menu'), admin_url());
  $settings_link = '<a href="'.esc_url($settings_page).'">'.__('Settings', 'lead-form-builder' ).'</a>';
  array_unshift($links, $settings_link);
  return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'lfb_plugin_action_links', 10, 1);

function lfb_include_file(){
global $wpdb;
define('LFB_FORM_FIELD_TBL', $wpdb->prefix . 'lead_form');
define('LFB_FORM_DATA_TBL', $wpdb->prefix . 'lead_form_data');
require_once( plugin_dir_path(__FILE__) . 'inc/lf-db.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/lf-install.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/lf-shortcode.php' );
if ( is_admin() ) {
require_once( plugin_dir_path(__FILE__) . 'inc/edit-delete-form.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/create-lead-form.php' );
}
require_once( plugin_dir_path(__FILE__) . 'inc/email-setting.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/show-forms-backend.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/front-end.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/show-lead.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/lead-store-type.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/ajax-functions.php' );
require_once( plugin_dir_path(__FILE__) . 'inc/lfb_widget.php' );
}
add_action('init','lfb_include_file');