<?php
     //  =============================
     //  = Default Theme Customizer Settings  =
     //  @ novelblue Theme
     //  =============================
/*theme customizer*/
function novelblue_customize_register( $wp_customize ) {
 
  $wp_customize->add_section('section_slider_first', array(
        'title'    => __('First Slider Settings', 'novelblue'),
        'priority' => 20,
         'panel'  => 'home_page_slider',
    ));
    $wp_customize->add_setting('first_slider_image', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'NovelLite_sanitize_upload'
    ));
   $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'first_slider_image', array(
        'label'    => __('First Slider Image', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_slider_image',
    )));
    $wp_customize->add_setting('first_slider_heading', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('first_slider_heading', array(
        'label'    => __('Slider Heading', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_slider_heading',
         'type'       => 'text',
    ));
 
    $wp_customize->add_setting('first_slider_desc', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'NovelLite_sanitize_textarea'

    ));
    $wp_customize->add_control('first_slider_desc', array(
        'label'    => __('Slider Description', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_slider_desc',
         'type'       => 'textarea',
    ));
       $wp_customize->add_setting('first_slider_link', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url',
    ));
    $wp_customize->add_control('first_slider_link', array(
        'label'    => __('First Slider Link', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_slider_link',
         'type'       => 'text',
    ));

         $wp_customize->add_setting('first_button_text', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('first_button_text', array(
        'label'    => __('First Button Text', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_button_text',
         'type'       => 'text',
    ));

     $wp_customize->add_setting('first_button_link', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('first_button_link', array(
        'label'    => __('First Link For Button', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_button_link',
         'type'       => 'text',
    ));

   // second button
 $wp_customize->add_setting('first_button_text_scnd', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',


    ));
    $wp_customize->add_control('first_button_text_scnd', array(
        'label'    => __('Second Button Text', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_button_text_scnd',
         'type'       => 'text',
         'priority' => 25,
    ));
$wp_customize->add_setting('first_button_link_scnd', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('first_button_link_scnd', array(
        'label'    => __('Second Link For Button', 'novelblue'),
        'section'  => 'section_slider_first',
        'settings' => 'first_button_link_scnd',
         'type'       => 'text',
         'priority' => 26,
    ));
// SECOND SLIDER
 //Second slider image

     $wp_customize->add_section('section_slider_second', array(
        'title'    => __('Second Slider Settings', 'novelblue'),
        'priority' => 20,
         'panel'  => 'home_page_slider',
    ));
    $wp_customize->add_setting('second_slider_image', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'NovelLite_sanitize_upload'
    ));
   $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'second_slider_image', array(
        'label'    => __('Second Slider Image', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_slider_image',
    )));
    $wp_customize->add_setting('second_slider_heading', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('second_slider_heading', array(
        'label'    => __('Slider Heading', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_slider_heading',
         'type'       => 'text',
    ));

     $wp_customize->add_setting('second_slider_desc', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'NovelLite_sanitize_textarea'
    ));
    $wp_customize->add_control('second_slider_desc', array(
        'label'    => __('Slider Description', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_slider_desc',
         'type'       => 'textarea',
    ));
    $wp_customize->add_setting('second_slider_link', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url',
    ));
    $wp_customize->add_control('second_slider_link', array(
        'label'    => __('Second Slider Link', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_slider_link',
         'type'       => 'text',
    ));

   

    $wp_customize->add_setting('second_button_text', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('second_button_text', array(
        'label'    => __('First Button Text', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_button_text',
         'type'       => 'text',
    ));

     $wp_customize->add_setting('second_button_link', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('second_button_link', array(
        'label'    => __('First Link for button', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_button_link',
         'type'       => 'text',
    ));
// second button
$wp_customize->add_setting('second_button_text_scd', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('second_button_text_scd', array(
        'label'    => __('Second Button Text', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_button_text_scd',
         'type'       => 'text',
          'priority' => 25,
    ));

    $wp_customize->add_setting('second_button_link_scd', array(
        'default'           => '#',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('second_button_link_scd', array(
        'label'    => __('Second Link for button', 'novelblue'),
        'section'  => 'section_slider_second',
        'settings' => 'second_button_link_scd',
         'type'       => 'text',
          'priority' => 26,
    ));
// selective refresh

$wp_customize->selective_refresh->add_partial( 'first_button_text_scnd', array(
        'selector' => '#slides_full .th-two ',
) );
}
add_action('customize_register','novelblue_customize_register');
?>