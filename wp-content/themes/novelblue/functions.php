<?php
/**
 * Loads the child theme textdomain.
 */
function novelblue_child_theme_setup() {
    load_child_theme_textdomain( 'novelblue');
}
add_action( 'after_setup_theme', 'novelblue_child_theme_setup' );

function novelblue_child_enqueue_styles() {
    $parent_style = 'novelblue-parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	 wp_enqueue_style( 'novelblue-style',get_stylesheet_directory_uri() . '/novelblue.css');
}
add_action( 'wp_enqueue_scripts', 'novelblue_child_enqueue_styles',99);
require_once (get_stylesheet_directory() . '/inc/customizer.php'); 
?>