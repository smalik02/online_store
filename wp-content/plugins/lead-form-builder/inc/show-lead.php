<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Class LFB_Show_Leads {
    function lfb_show_form_leads() {
        global $wpdb;
        $option_form = '';
        $first_form=0;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $table_name = LFB_FORM_FIELD_TBL;
        $prepare_16 = $wpdb->prepare("SELECT * FROM $table_name WHERE form_status = %s ORDER BY id DESC ",'ACTIVE');
        $posts = $th_save_db->lfb_get_form_content($prepare_16);
        if (!empty($posts)) {
            foreach ($posts as $results) {
                $first_form++;
                $form_title = $results->form_title;
                $form_id = $results->id;
                if($first_form==1){
                $first_form_id = $results->id;
                if (get_option('lf-remember-me-show-lead') !== false ) {
                $first_form_id = get_option('lf-remember-me-show-lead');
                }
                }
                $option_form .= '<option ' . ($first_form_id == $form_id ? 'selected="selected"' : "" ) . ' value=' . $form_id . '>' . $form_title . '</option>';
            }
        }
        echo '<div class="wrap"><div class="inside"><div class="card"><table class="form-table"><tbody><tr><th scope="row">
<label for="select_form_lead">Select From</label></th>
<td><select name="select_form_lead" id="select_form_lead">' . $option_form . '</select>
<td><input type="button" value="Remember this form" onclick="remember_this_form_id();" id="remember_this_form_id"></td>
</tr><tr><td><div id="remember_this_message" ></div></td></tr></tbody></table></div></div></div>';
$leads = $this->lfb_show_leads_first_form($first_form_id);
        echo '<div class="wrap" id="form-leads-show">'.$leads.'</div>';
    }

function lfb_show_leads_first_form($form_id){
        global $wpdb;
        $table_name = LFB_FORM_DATA_TBL;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $start = 0;//
        $limit = 10;//
        $detail_view = '';
        $id = 1;//
        $sn_counter = 0;
        $prepare_17 = $wpdb->prepare("SELECT * FROM $table_name WHERE form_id = %d ORDER BY id DESC LIMIT $start , $limit", $form_id);
        $posts = $th_save_db->lfb_get_form_content($prepare_17);//
        if (!empty($posts)) {
            $entry_counter = 0;
            echo '<div class="wrap" id="form-leads-show"><table class="show-leads-table" id="show-leads-table" ><thead><tr><th>S.N.</th>';
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
                unset($form_data['g-recaptcha-response']);
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
                        $table_head .='<th><input type="button" onclick="show_all_leads(' . $id . ',' . $form_id . ')" value="Show all Columns"></th>';
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
            $prepare_18 = $wpdb->prepare("SELECT * FROM $table_name WHERE form_id = %d ", $form_id);
            $rows = $th_save_db->lfb_get_form_content($prepare_18);//
            $rows = count($rows);//
            $total = ceil($rows / $limit);//
            if ($id > 1) {//
                echo "<a href=''  onclick='lead_pagination(" . ($id - 1) . "," . $form_id . ")' class='button'>PREVIOUS</a>";//
            }//
            if ($id != $total) {//
                echo "<a href='' onclick='lead_pagination(" . ($id + 1) . "," . $form_id . ")' class='button'>NEXT</a>";//
            }//
            echo "<ul class='page'>";//
            for ($i = 1; $i <= $total; $i++) {//
                if ($i == $id) {//
                    echo "<li class='lf-current'>" . $i . "</li>";//
                } else {
                    echo "<li><a href='' onclick='lead_pagination(" . $i . "," . $form_id . ")'>" . $i . "</a></li>";//
                }//
            }//
             echo '</ul>';//
             echo '</div>';
        } else {
             echo '<div class="wrap" id="form-leads-show">';
             echo "No leads...!!";
             echo '</div>';
        }
    }

    function lfb_show_form_leads_datewise($form_id,$leadtype){
        global $wpdb;
        $table_name = LFB_FORM_DATA_TBL;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $start = 0;
        $limit = 10;
        $detail_view = '';
        $id = 1;
        $sn_counter = 0;
        if($leadtype=="total_leads"){
        $prepare_19 = $wpdb->prepare(" SELECT * FROM $table_name WHERE form_id = %d ORDER BY id DESC LIMIT $start , $limit ", $form_id);
        $prepare_20 = $wpdb->prepare(" SELECT * FROM $table_name WHERE form_id = %d ", $form_id);
        $posts = $th_save_db->lfb_get_form_content($prepare_19);
        $rows = $th_save_db->lfb_get_form_content($prepare_20);    
        }else if($leadtype=="today_leads"){
        $today_date= date('Y/m/d');
        $newDate = date("Y/m/d H:i:s", strtotime($today_date));

        $prepare_21 = $wpdb->prepare("SELECT * FROM $table_name WHERE date > %s and form_id = %d ORDER BY id DESC LIMIT $start , $limit ", $newDate, $form_id );
        $prepare_22 = $wpdb->prepare("SELECT * FROM $table_name WHERE date > %s and form_id = %d ", $newDate, $form_id );
        $posts = $th_save_db->lfb_get_form_content($prepare_21);
        $rows = $th_save_db->lfb_get_form_content($prepare_22); 
        }
        if (!empty($posts)) {
            $entry_counter = 0;
            echo '<div class="wrap" id="form-leads-show"><table class="show-leads-table" id="show-leads-table" ><thead><tr><th>S.N.</th>';
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
                unset($form_data['g-recaptcha-response']);
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
                        $table_head .='<th><input type="button" onclick="show_all_leads(' . $id . ',' . $form_id . ')" value="Show all Columns"></th>';
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
                echo "<a href=''  onclick='lead_pagination_datewise(" . ($id - 1) . "," . $form_id . ",\"".$leadtype."\");' class='button'>PREVIOUS</a>";
            }
            if ($id != $total) {
                echo "<a href='' onclick='lead_pagination_datewise(" . ($id + 1) . "," . $form_id . ",\"".$leadtype."\");' class='button'>NEXT</a>";
            }
            echo "<ul class='page'>";
            for ($i = 1; $i <= $total; $i++) {
                if ($i == $id) {
                    echo "<li class='lf-current'>" . $i . "</li>";
                } else {
                    echo "<li><a href='' onclick='lead_pagination_datewise(".$i.",".$form_id.",\"".$leadtype."\");'>" . $i . "</a></li>";
                }
            }
             echo '</ul>';
             echo '</div>';

        } else {
             echo '<div class="wrap" id="form-leads-show">';
             echo "No leads...!!";
             echo '</div>';
        }
    }
}

