<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
Class LFB_Front_end_FORMS {
    function lfb_show_front_end_forms($this_form_id) {
        $form_elemets ='';
        $submit_button='';
        global $wpdb;
        $th_save_db = new LFB_SAVE_DB($wpdb);
        $table_name = LFB_FORM_FIELD_TBL;
        $prepare_11 = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d and form_status = %s LIMIT 1",$this_form_id, 'ACTIVE' );
        $posts = $th_save_db->lfb_get_form_content($prepare_11);
        if (!empty($posts)) {
            $form_title = $posts[0]->form_title;
            $form_data_result = maybe_unserialize($posts[0]->form_data);
            $form_id = $posts[0]->id;
            $captcha_option = $posts[0]->captcha_status;
			$this_form_color = $posts[0]->form_skin;
			$this_form_size = $posts[0]->form_size;
            $submit_field_type=0;
            foreach ($form_data_result as $results) {
                $field_name = '';
                $field_type = '';
                $default_value = '';
                $default_placeholder = '';
                $is_required = '';
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
                        if (isset($default_value['field'])) {
                            $default_value = $default_value['field'];
                        } else {
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
                $data_array=array(
                    'field_name'=>$field_name,
                    'field_type_array'=>$field_type_array,
                    'default_value'=>$default_value,
                    'default_placeholder'=>$default_placeholder,
                    'is_required'=>$is_required,
                    'field_id'=>$field_id,
                    'field_type'=>$field_type
                );

                /***Email, Url, Number, Date and Text***/
                if ($field_type == 'email' || $field_type == 'url'|| $field_type == 'dob' || $field_type == 'number' || $field_type == 'date' || $field_type == 'text') {
                    $form_elemets .=$this->lfb_front_end_field_type_text($data_array);
                }
                /***Name***/
                if ($field_type == 'name') {
                    $form_elemets .=$this->lfb_front_end_field_type_name($data_array);
                }
                /***Upload***/
                if ($field_type == 'upload') {
                    $form_elemets .=$this->lfb_front_end_field_type_upload($data_array);
                }
                /***Textarea & Message***/
                if ($field_type == 'textarea' || $field_type == 'message') {
                 $form_elemets .=$this->lfb_front_end_field_type_textarea($data_array);
                }
                /***Radio***/
                if ($field_type == 'radio') {
                    $form_elemets .=$this->lfb_front_end_field_type_radio($data_array);
                }
                /***Option***/
                if ($field_type == 'option') {
                    $form_elemets .=$this->lfb_front_end_field_type_option($data_array);
                }
                /***Checkbox***/
                if ($field_type == 'checkbox') {
                    $form_elemets .=$this->lfb_front_end_field_type_checkbox($data_array);
                }
                /***Submit button***/
                if ($field_type == 'submit') {
                    $submit_field_type++;
                    $submit_button .=$this->lfb_front_end_field_type_submit($data_array,$captcha_option);
                }
                }

                /***Complete Form***/
            if($captcha_option == 'ON'){
                $captcha_status='enable';
                $captcha_script='<script src="https://www.google.com/recaptcha/api.js"></script>';
            }
            if($captcha_option == 'OFF'){
                $captcha_status='disable';
                $captcha_script='';
            }
            if($submit_field_type < 1){
                    $captcha_field = '';
                    if ($captcha_option == 'ON') {
                        $captcha_field = '<div class="g-recaptcha" data-sitekey="' . get_option('captcha-setting-sitekey') . '"></div><br/>';
                        }
            $submit_button .='<label><span></span></label><span>' . $captcha_field . '</span><label><span></span></label>
                <span><input id="default-submit" class="lf-form-submit" type="submit" name="submit-form" value="submit"/></span>
                 <br/><br/>';
                }
        $return =  '<div class="leadform-show-form '.$this_form_size.' lf-form-'.$this_form_color.'">'.$captcha_script.'
               <form action="" method="post" class="lead-form-front" id="form_' . $this_form_id . '" enctype="multipart/form-data">
                <h1>' . $form_title . '</h1>' . $form_elemets . '<div class="lf-form-panel">' . $submit_button . '</div>
                <div class="captcha-field-area" id="captcha-field-area"></div>
                <input type="hidden" id="hidden_field" name="hidden_field" value="' . $this_form_id . '"/>
                <input type="hidden" id="this_form_captcha_status" value="' . $captcha_status . '"/>
                <div class="leadform-show-loading front-loading leadform-show-message-form-'.$this_form_id.'"></div>
                <div class="lf-loading"><img src="'.LFB_PLUGIN_URL. 'images/load.gif" style="display: none;" id="loading_image"></div>
                </form></div>';

            return $return;
        }
    }

    function lfb_front_end_field_type_text($data_array){
    $text_email_url_number ='<div class="text-type lf-field"><label>' . $data_array['field_name'] . '</label>
        <span><input id="' . $data_array['field_id'] . '" type="' . ((($data_array['field_type'] == "date" )||($data_array['field_type'] == "dob"))? "text" : $data_array['field_type'] ) . '" class="lf-form-text ' . ((($data_array['field_type'] == "date" )||($data_array['field_type'] == "dob"))? "lf-jquery-datepicker" : "" ) . '" name="' . $data_array['field_name'] . '" ' . ($data_array['is_required'] == 1 ? 'required' : "" ) . ' value="' . ($data_array['default_placeholder'] == 1 ? "" : $data_array['default_value'] ) . '" placeholder="' . ($data_array['default_placeholder'] == 1 ? $data_array['default_value'] : "" ) . '" />
        </span></div>';
         return $text_email_url_number;
    }

    function lfb_front_end_field_type_name($data_array){
    $name  ='<div class="name-type lf-field"><label>' . $data_array['field_name'] . '</label>
        <span><input id="' . $data_array['field_id'] . '" type="text" name="' . $data_array['field_name'] . '" class="lf-form-name" value="' . ($data_array['default_placeholder'] == 1 ? "" : $data_array['default_value'] ) . '" ' . ($data_array['is_required'] == 1 ? 'required' : "" ) . ' placeholder="' . ($data_array['default_placeholder'] == 1 ? $data_array['default_value'] : "" ) . '" />
        </span></div>';
        return $name;
    }

    function lfb_front_end_field_type_textarea($data_array){
        $textbox ='<div class="textarea-type lf-field"><label>' . $data_array['field_name'] . '</label>
            <span><textarea id="' . $data_array['field_id'] . '" name="' . $data_array['field_name'] . '" class="lf-form-textarea" value="' . $data_array['default_value'] . '" placeholder="' . ($data_array['default_placeholder'] == 1 ? $data_array['default_value'] : "" ) . '" ' . ($data_array['is_required'] == 1 ? 'required' : "" ) . '></textarea>
            </span></div>';
        return $textbox;
    }

    function lfb_front_end_field_type_upload($data_array){
         $upload ='<div class="upload-type lf-field"><label>' . $data_array['field_name'] . '</label>
        <span><input id="' . $data_array['field_id'] . '" type="file" name="' . $data_array['field_name'] . '" class="lf-form-upload" value="" ' . ($data_array['is_required'] == 1 ? 'required' : "" ) . ' placeholder="" />
        </span></div>';
        return $upload;
    }

    function lfb_front_end_field_type_radio($data_array){
         $field_type_array= $data_array['field_type_array'];
         $default_value=$data_array['default_value'];
         $field_id=$data_array['field_id'];
         $field_name=$data_array['field_name'];
         $radio_fields='';
        foreach ($field_type_array as $field_type_array_element => $radio_options) {
                $field_type_array_element_id = str_replace("field_", "", $field_type_array_element);
                    if (($field_type_array_element_id == $default_value) && ($default_value > 0)) {
                        $radio_fields .='<li><input id="' . $field_id . '" type="radio" name="' . $field_name . '" value="' . $radio_options . '" checked />' . $radio_options.'</li>';
                    } else {
                        $radio_fields .='<li><input id="' . $field_id . '" type="radio" name="' . $field_name . '" value="' . $radio_options . '" />' . $radio_options.'</li>';
                    }
                        }
                $radio ='<div class="radio-type lf-field"><label>' . $field_name . '</label>
                        <span><ul>' . $radio_fields . '</ul></span></div>';
            return $radio;           
    }

    function lfb_front_end_field_type_option($data_array){
         $field_type_array= $data_array['field_type_array'];
         $default_value=$data_array['default_value'];
         $field_id=$data_array['field_id'];
         $field_name=$data_array['field_name'];
         $option_fields='';
            foreach ($field_type_array as $field_type_array_element => $option_options) {
                $field_type_array_element_id = str_replace("field_", "", $field_type_array_element);
                if (($field_type_array_element_id == $default_value) && ($default_value > 0)) {
                    $option_fields .='<option value="'.$option_options.'" selected >' . $option_options . '</option>';
                } else {
                    $option_fields .='<option value="'.$option_options.'">' . $option_options . '</option>';
                }
            }
            $option ='<div class="select-type lf-field"><label>' . $field_name . '</label>
            <span><select id="' . $field_id . '" name="' . $field_name . '" >' . $option_fields . '</select></span></div>';
            return $option;        
    }
    function lfb_front_end_field_type_checkbox($data_array){
         $field_type_array= $data_array['field_type_array'];
         $default_value=$data_array['default_value'];
         $field_id=$data_array['field_id'];
         $field_name=$data_array['field_name'];
         $checkbox_fields='';
            foreach ($field_type_array as $field_type_array_element => $checkbox_options) {
                $default_element_val_counter = 0;
                if (is_array($default_value)) {
                    foreach ($default_value as $default_value_element => $default_value_val) {
                     $default_element_val_counter = 0;
                    if ($default_value_element == $field_type_array_element) {
                        $default_element_val_counter++;
                        $checkbox_fields .='<li><input id="' . $field_id . '" type="checkbox" name="' . $field_name . '[]" value="' . $checkbox_options . '"  checked/>' . $checkbox_options.'</li>';
                        break;
                        }
                    }
                }
            if ($default_element_val_counter == 0) {
                $checkbox_fields .='<li><input id="' . $field_id . '" type="checkbox" name="' . $field_name . '[]" value="' . $checkbox_options . '"  />' . $checkbox_options.'</li>';
            }
        }
        $checkbox ='<div class="checkbox-type lf-field"><label>' . $field_name . '</label>
                    <span><ul>' . $checkbox_fields . '</ul></span></div>';
        return $checkbox;
    }

    function lfb_front_end_field_type_submit($data_array,$captcha_option){
        $captcha_field = '';
        $submit = '';
        //captch on/off
        if ($captcha_option == 'ON') {
            $captcha_field = '<div class="g-recaptcha" data-sitekey="' . get_option('captcha-setting-sitekey') . '"></div><br/>';
            $submit ='<div class="captcha-type lf-field"><label>' . $captcha_field . '</label></div>';
        }
        // submit button
            $submit_button = ($data_array['default_value']=='')?'Submit':$data_array['default_value'];

       $submit .= '<div class="submit-type lf-field"><label><input id="' . $data_array['field_id'] . '" class="lf-form-submit" type="submit" name="' . $data_array['field_name'] . '" value="' . $submit_button . '"/>
                </label></div>';
        return $submit;        
    }
}