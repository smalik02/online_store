<?php
/*
Plugin Name: StoreOne Extension
Description: Advance Extension For StoreOne Theme. enjoy full functionality of StoreOne theme by installing this plugin.
Author: ThemeFarmer
Author URI: https://www.themefarmer.com/
Domain Path: /lang/
Version: 1.2
Text Domain: storeone-extension

StoreOne Extension is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

StoreOne Extension is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with StoreOne Extension. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

define( 'STOREONE_EXTENSION_DIR', plugin_dir_path( __FILE__ ) );
require_once STOREONE_EXTENSION_DIR.'/inc/custom-post-type.php';


if (!function_exists('storeone_extension')) {
	function storeone_extension() {

	}
}

function storeone_extension_init() {
	load_plugin_textdomain('storeone-extension', false, dirname(plugin_basename(__FILE__)) . '/lang');

	if (class_exists('Kirki')) {
		Kirki::add_section('storeone_home_slider_section', array(
			'title'    => __('Home Slider', 'storeone'),
			'panel'    => 'storeone_homepage',
			'priority' => 20,
		));

		Kirki::add_section('storeone_home_testimonial_section', array(
			'title'    => __('Home Testimonial', 'storeone'),
			'panel'    => 'storeone_homepage',
			'priority' => 50,
		));

		Kirki::add_field('storeone_settings', array(
			'type'     => 'text',
			'section'  => 'storeone_home_testimonial_section',
			'settings' => 'storeone_testimonial_heading',
			'label'    => __('Heading', 'storeone-extension'),
			'priority' => 10,
		));

		Kirki::add_field('storeone_settings', array(
			'type'     => 'text',
			'section'  => 'storeone_home_testimonial_section',
			'settings' => 'storeone_testimonial_desc',
			'label'    => __('Description', 'storeone-extension'),
			'priority' => 10,
		));

		
		Kirki::add_panel('storeone_shop_panel', array(
			'priority' => 4,
			'title'    => __('Shop Options', 'storeone'),
		));

		Kirki::add_section('storeone_shop_slider_section', array(
			'title'    => __('Shop Slider', 'storeone'),
			'panel'    => 'storeone_shop_panel',
			'priority' => 10,
		));

		Kirki::add_field('storeone_settings', array(
			'type'        => 'switch',
			'section'     => 'storeone_shop_slider_section',
			'settings'    => 'storeone_shop_slider_enable',
			'label'       => __('Slider ON/OFF', 'storeone-extension'),
			'description' => __('Enable or Disable Slider on Shop', 'storeone-extension'),
			'default'     => '1',
			'priority'    => 10,
		));

		Kirki::add_panel('storeone_blog_panel', array(
			'priority' => 4,
			'title'    => __('Blog Options', 'storeone'),
		));

		Kirki::add_section('storeone_blog_slider_section', array(
			'title'    => __('Blog Slider', 'storeone'),
			'panel'    => 'storeone_blog_panel',
			'priority' => 10,
		));

		Kirki::add_field('storeone_settings', array(
			'type'        => 'switch',
			'section'     => 'storeone_blog_slider_section',
			'settings'    => 'storeone_blog_slider_enable',
			'label'       => __('Slider ON/OFF', 'storeone-extension'),
			'description' => __('Enable or Disable Slider on Blog', 'storeone-extension'),
			'default'     => '1',
			'priority'    => 10,
		));
	}
}
add_action('plugins_loaded', 'storeone_extension_init');


register_activation_hook( __FILE__, 'storeone_extension_activation' );
function storeone_extension_activation() {
	storeone_extension_cpt_init();
	flush_rewrite_rules();
}
