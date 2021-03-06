<?php
/*
* Plugin Name: WP-VR-view - 360 photo/video
* Description: Add 360 photos and  360 videos to wordpress pages, post, widgets etc. Google cardboard compatible. For additional information and usecases please visit demo website.
* Version: 2.2
* Author: Tumanov Alexander
* Author URI: https://alexander-tumanov.name
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'WP_NR_VERSION', '2.2' );
define( 'WP_NR_URL', esc_url( plugin_dir_url( __FILE__ ), array( 'http', 'https' ) ) );
//define( 'WP_NR_PATH', wp_normalize_path( dirname( __FILE__ ) . '/' ) );

require_once __DIR__ . '/includes/php/autoload.php';

/**
 * Register our stylesheet to be used later
 *
 * @return void
 */
function vr_register_style() {
	wp_register_style(
		'wp_nr_vr_style',
		WP_NR_URL . 'includes/css/style.css',
		array(),
		WP_NR_VERSION
	);
}

add_action( 'init', 'vr_register_style' );

/**
 * Shortcode to display form on any page or post.
 *
 * @param $atts
 *
 * @return string
 */
function vr_creation( $atts ) {
	wp_enqueue_style( 'wp_nr_vr_style' );

	/**  NEW fields
	 * is_vr_off
	 * is_autopan_off
	 * loop
	 * hide_fullscreen_button
	 * muted
	 */
	$a = shortcode_atts( array(
		'img'         => '',
		'video'       => '',
		'pimg'        => '',
		'width'       => '640',
		'height'      => '360',
		'stereo'      => 'false',
		'yaw'         => 0,
		'hascontrols' => true,
		'is_vr_off' => '',
		'is_autopan_off' => '',
		'loop' => true,
		'hide_fullscreen_button' => '',
		'muted' => false
	), $atts );

	if ( $a['video'] ) {
		$vrVideo1 = new VrVideo( $a );

		return $vrVideo1->generateHtmlCode();
	}

	$vrImage1 = new VrImage( $a );

	return $vrImage1->generateHtmlCode();
}

add_shortcode( 'vrview', 'vr_creation' );
