<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Class LFB_SHOW_FORMS {
    function lfb_show_form_nonce(){
    $nonce = wp_create_nonce( '_nonce_verify' );
    return $nonce;
    }
    function lfb_show_all_forms($id) {
        echo '<div class="wrap show-all-form">
<h1>Lead Forms <a href="' . admin_url() . 'admin.php?page=add-new-form&_wpnonce='.$this->lfb_show_form_nonce().'" class="add-new-h2">Add New</a></h1>
<div>
<table class="wp-list-table widefat fixed striped posts ">
	<thead>
	<tr>
		<th scope="col" id="title" class="manage-column column-title column-primary sortable asc"><a href=""><span>Title</span><span class="sorting-indicator"></span></a></th>
		<th scope="col" id="shortcode" class="manage-column column-shortcode">Shortcode</th>
		<th scope="col" id="date" class="manage-column column-form-date sortable desc"><a href=""><span>Date</span><span class="sorting-indicator"></span></a></th>
		<th scope="col" id="today_count" class="manage-column column-form-count sortable desc"><a href=""><span>Today Lead</span></a></th>
		<th scope="col" id="total_count" class="manage-column column-form-count sortable desc"><a href=""><span>Total Lead</span></a></th>
		<th scope="col" id="captcha" class="manage-column column-date sortable desc"><a href=""><span>Captcha</span></a></th>
		</tr>
	</thead>

	<tbody id="the-list" data-wp-lists="list:post">';

        global $wpdb;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $table_name = LFB_FORM_FIELD_TBL;
		$start = 0;//
        $limit = 10;//
        $id = $id; 
        $start = ($id - 1) * $limit;
        $form_count = $start;
              $prepare_12 = $wpdb->prepare("SELECT * FROM $table_name WHERE form_status = %s ORDER BY id DESC LIMIT $start , $limit", 'ACTIVE' );
		$posts = $th_save_db->lfb_get_form_content($prepare_12);
        if ($posts){
            foreach ($posts as $results) {
            	$form_count++;
                $form_title = $results->form_title;
                $form_date = $results->date;
                $form_id = $results->id;
                $captcha_status = $results->captcha_status;
        $data_table = LFB_FORM_DATA_TBL;
        $today_date= date('Y/m/d');
        $newDate = date("Y/m/d H:i:s", strtotime($today_date));
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $prepare_13 = $wpdb->prepare("SELECT id FROM $data_table WHERE date > %s and form_id = %d ", $newDate, $form_id );
        $count_result = $th_save_db->lfb_get_form_content($prepare_13);
        $lead_count = count($count_result);

        $prepare_14 = $wpdb->prepare("SELECT id FROM $data_table WHERE form_id = %d ", $form_id );
        $total_lead_result = $th_save_db->lfb_get_form_content($prepare_14);
        $total_lead_result = count($total_lead_result);
        $edit_url_nonce =admin_url() . 'admin.php?page=add-new-form&action=edit&formid=' . $form_id.'&_wpnonce='.$this->lfb_show_form_nonce();

        echo '<tr><td class="title column-title has-row-actions column-primary" data-colname="Title"><strong>' . $form_count . '.  <a class="row-title" href="'.$edit_url_nonce. '" title="Edit “' . $form_title . '”">' . $form_title . '</a></strong>
		<div class="row-actions"><span class="edit"><a href="' . $edit_url_nonce. '">Edit</a></span>|<span class="edit"><a href="' . admin_url() . 'admin.php?page=wplf-plugin-menu&action=delete&page_id='.$id.'&formid=' . $form_id . '">Delete</a></span>|<span class="edit"><a href="' . admin_url() . 'admin.php?page=wplf-plugin-menu&action=show&formid=' . $form_id . '" target="_blank" >View Form</a></span>
		</div>
		<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
		<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
		</td>
		<td class="shortcode column-shortcode" data-colname="Shortcode"><span class="shortcode">
		<input type="text" onfocus="this.select();" readonly="readonly" value="[lead-form form-id=' . $form_id . ' title=' . $form_title . ']" class="large-text code"></span>
		</td>
		<td class="form-date column-form-date" data-colname="Form-date">
		<abbr title="' . $form_date . '">' . $form_date . '</abbr>
		</td>
		<td class="form-date column-form-date" data-colname="Form-date">
		<abbr title="' . $lead_count . '"><a href="' . admin_url() . 'admin.php?page=wplf-plugin-menu&action=today_leads&formid=' . $form_id . '" target="_blank">' . $lead_count . '</a></abbr>
		</td>
		<td class="form-date column-form-date" data-colname="Form-date">
		<abbr title="' . $total_lead_result . '"><a href="' . admin_url() . 'admin.php?page=wplf-plugin-menu&action=total_leads&formid=' . $form_id . '" target="_blank">' . $total_lead_result . '</a></abbr>
		</td>
		<td class="captcha lf-column-captcha" data-colname="Captcha">';
if ( get_option('captcha-setting-sitekey') !== false ) {
		echo '<ul>
        <li id ="lf-column-captcha-'.$form_id.'" class="'.($captcha_status == "OFF"? 'lf-on':"").'"><p>OFF</p></li>
        <li id ="lf-column-captcha-'.$form_id.'" class="'.($captcha_status == "ON"? 'lf-on':"").'"><p>ON</p></li>
        </ul>';
}else{
       echo '<abbr title="' . $captcha_status . '">Missing Keys</abbr>';
}
		echo '</td>
		</tr>';
            }
        }
        echo '</tbody>
  </table><div class="tablenav bottom"><br class="clear">';
  
            $prepare_15 = $wpdb->prepare("SELECT * FROM $table_name WHERE form_status = %s ", 'ACTIVE' );
            $rows = $th_save_db->lfb_get_form_content($prepare_15);//
            $rows = count($rows);//
            $total = ceil($rows / $limit);//
            if ($id > 1) {//
                echo "<a href='". admin_url() . "admin.php?page=wplf-plugin-menu&page_id=" . ($id - 1) . "' class='button'>PREVIOUS</a>";//
            }//
            if ($id != $total) {//
                echo "<a href='". admin_url() . "admin.php?page=wplf-plugin-menu&page_id=" . ($id + 1) . "' class='button'>NEXT</a>";//
            }//
            echo "<ul class='page'>";//
            for ($i = 1; $i <= $total; $i++) {//
                if ($i == $id) {//
                    echo "<li class='lf-current'>" . $i . "</li>";//
                } else {
                    echo "<li><a href='". admin_url() . "admin.php?page=wplf-plugin-menu&page_id=" .$i. "'>" . $i . "</a></li>";//
                }//
            }//
             echo '</ul>';//
  /**/
echo '</div> </div>

</div>';
    }
}