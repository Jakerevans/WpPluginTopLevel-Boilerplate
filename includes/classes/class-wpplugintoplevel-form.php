<?php
/**
 * WPPlugin WPPlugin_Toplevel_Form Submenu Class
 *
 * @author   Jake Evans
 * @category ??????
 * @package  ??????
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPPlugin_Toplevel_Form', false ) ) :
/**
 * WPPlugin_Toplevel_Form Class.
 */
class WPPlugin_Toplevel_Form {

	public static function output_wpplugintoplevel_form(){

		global $wpdb;
	
		// For grabbing an image from media library
		wp_enqueue_media();

		$string1 = '';
		
    	return $string1;
	}
}

endif;