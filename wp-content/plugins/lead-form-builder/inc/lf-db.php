<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Class LFB_SAVE_DB{
	private $thdb;
 function __construct($wpdb){
 $this->thdb = $wpdb;
    }
 function lfb_get_form_content($get_form_query){
  return $this->thdb->get_results($get_form_query);
 }
 function lfb_delete_form($deletequery){
  return $this->thdb->query($deletequery); 
  //return $this->thdb->query($this->thdb->prepare($deletequery)); 
 }
 function lfb_update_form_data($updatequery){
 $update_data = $this->thdb->query($updatequery);
 //$update_data = $this->thdb->query($this->thdb->prepare($updatequery));
 return $update_data;
}
 function lfb_insert_form_data($insertquery){
 //$this->thdb->query($this->thdb->prepare($insertquery));
 $this->thdb->query($insertquery);
}
}