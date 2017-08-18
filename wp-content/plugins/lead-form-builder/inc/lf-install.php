<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
 * Include assets
 */
function lfb_admin_assets() {   
    wp_enqueue_style('wpth_b_css', LFB_PLUGIN_URL . 'css/b-style.css');
    wp_enqueue_script('jquery-ui-datepicker');
	 wp_enqueue_script("jquery-ui-sortable");
   wp_enqueue_script("jquery-ui-draggable");
   wp_enqueue_script("jquery-ui-droppable"); 
    wp_enqueue_script('lfb_b_js', LFB_PLUGIN_URL . 'js/b-script.js', array('jquery'), '1.0.0', true);
    wp_localize_script('lfb_b_js', 'backendajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
 $pageSearch = array('wplf-plugin-menu','add-new-form','all-form-leads','pro-form-leads');
    if(isset($_GET['page']) && in_array($_GET['page'], $pageSearch)){
    add_action('admin_enqueue_scripts', 'lfb_admin_assets');

}

function lfb_wp_assets() {
    wp_enqueue_style('lfb_f_css', LFB_PLUGIN_URL . 'css/f-style.css');
	wp_enqueue_script('jquery-ui-datepicker');        
    wp_enqueue_script('lfb_f_js', LFB_PLUGIN_URL . 'js/f-script.js', array('jquery'), '1.0.0', true);
    wp_localize_script('lfb_f_js', 'frontendajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'lfb_wp_assets', 15);

/*
 * Register custom menu pages.
 */
function lfb_register_my_custom_menu_page() {
       add_menu_page(__('Lead Form', 'th-lead-form'), __('Lead Form', 'th-lead-form'), 'delete_others_posts', 'wplf-plugin-menu', 'lfb_lead_form_page', plugins_url('../images/icon.png', __FILE__ ));
    add_submenu_page('wplf-plugin-menu', __('Add Forms', 'th-lead-form'), __('Add Forms', 'th-lead-form'), 'delete_others_posts', 'add-new-form', 'lfb_add_contact_forms');
    add_submenu_page('wplf-plugin-menu', __('Leads', 'th-lead-form'), __('Leads', 'th-lead-form'), 'delete_others_posts', 'all-form-leads', 'lfb_all_forms_lead');
    add_submenu_page('wplf-plugin-menu', __('About Lead From', 'th-lead-form'), __('About Lead From', 'th-lead-form'), 'delete_others_posts', 'pro-form-leads', 'lfb_pro_feature');
}
add_action('admin_menu', 'lfb_register_my_custom_menu_page');

function lfbButton(){
    echo '<a class="button_lfb" target="_blank" href="//themehunk.com/product/lead-form-builder-pro/">Get Pro Version</a>';
}


function lfb_lead_form_page() {
    lfbButton();
    if (isset($_GET['action']) && isset($_GET['formid'])) {
        $form_action = $_GET['action'];
        $this_form_id = $_GET['formid'];
        if ($form_action == 'delete') {
			$page_id =1;
		    if (isset($_GET['page_id'])) {
		    $page_id = $_GET['page_id'];
		    }
            $th_edit_del_form = new LFB_EDIT_DEL_FORM();
            $th_edit_del_form->lfb_delete_form_content($form_action, $this_form_id,$page_id);
        }
        if ($form_action == 'show') {
            $th_show_form = new LFB_Front_end_FORMS();
            echo $th_show_form->lfb_show_front_end_forms($this_form_id);
        }
        if ($form_action == 'today_leads') {
            $th_show_today_leads = new LFB_Show_Leads();
            $th_show_today_leads->lfb_show_form_leads_datewise($this_form_id,"today_leads");
        }
        if ($form_action == 'total_leads') {
            $th_show_all_leads = new LFB_Show_Leads();
            $th_show_all_leads->lfb_show_form_leads_datewise($this_form_id,"total_leads");
        }
    } else {
        $th_show_forms = new LFB_SHOW_FORMS();
		$page_id =1;
		if (isset($_GET['page_id'])) {
		$page_id = $_GET['page_id'];
		}
        $th_show_forms->lfb_show_all_forms($page_id);
    }
}

function lfb_add_contact_forms() {
        lfbButton();
// form bulider update
if (intval(isset($_POST['update_form']) && wp_verify_nonce($_REQUEST['_wpnonce'],'_nonce_verify')) ) {
    $form_data=$_POST;
    $update_form_id = stripslashes($_POST['update_form_id']);
    $title = sanitize_text_field($_POST['post_title']);
    unset($_POST['_wpnonce']);
    unset($_POST['post_title']);
    unset($_POST['update_form']);
    unset($_POST['update_form_id']);
    $form_data= maybe_serialize($_POST);
    global $wpdb;
    $table_name = LFB_FORM_FIELD_TBL;
    $update_leads = $wpdb->update( 
    $table_name,
    array( 
        'form_title' => $title,
      'form_data' => $form_data
    ), 
    array( 'id' => $update_form_id ));
    $rd_url = admin_url().'admin.php?page=add-new-form&action=edit&redirect=update&formid='.$update_form_id;
    $complete_url = wp_nonce_url($rd_url);
  }


if (isset($_GET['action']) && isset($_GET['formid'])) {
        $form_action = $_GET['action'];
        $this_form_id = $_GET['formid'];
        if ($form_action == 'edit') {
            $th_edit_del_form = new LFB_EDIT_DEL_FORM();
            $th_edit_del_form->lfb_edit_form_content($form_action, $this_form_id);
        }
    } else {
        $lf_add_new_form = new LFB_AddNewForm();
        $lf_add_new_form->lfb_add_new_form();
    }

}

function lfb_all_forms_lead() {
        lfbButton();
    $th_show_forms = new LFB_Show_Leads();
    $th_show_forms->lfb_show_form_leads();
}

function lfb_pro_feature(){
echo '<iframe height="700px" width="100%" src="//themehunk.com/feature/wp-lead-form/" onload="lfbresizeIframe(this)"></iframe>';

}