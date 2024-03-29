<?php
/**
 * WordPress Book List WPPluginToplevel Extension
 *
 * @package     WordPress Book List WPPluginToplevel Extension
 * @author      Jake Evans
 * @copyright   2018 Jake Evans
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: WPPluginToplevel Extension
 * Plugin URI: https://www.jakerevans.com
 * Description: A Boilerplate Extension for WPPlugin that creates a menu page and has it's own tabs.
 * Version: 1.0.0
 * Author: Jake Evans
 * Text Domain: wpplugintoplevel
 * Author URI: https://www.jakerevans.com
 */

/*
* FUNCTIONALITY NOTES
* This boilerplate plugin comes with these features out-of-the-box:
* 1. Ability to create a new generic User. Basic info such as name and contact info. 
* 	- The 'uniqueness' is set by the email address - it's impossible to add a user that has the same email as another user.
* 	- There is an ability to add a new User from the Admin Dashboard
*
* 2. Front-end Dashboard functionality for Users
*   - Use this Shortcode to place a Dashboard for front-end users: [wpplugintoplevel_login_shortcode]
*	- On this Dashboard, Users can Login or Register, and see and edit their account Info
*	- Users can also see their saved posts
*
* 3. Ability to save posts
*	- This plugin gives Users the ability to save a post they like to their account
*	- A "Save This Post" feature is appended to the end of every Blog Post title
*	- If the user is logged in and wants to save the post, they can click the text to do so
*	- If they aren't logged in, they'll be taken to the Dashboard page to login or register
*	- If they are logged in and already liked the post, the button will say so
*	- Be sure to change this Constant once the URL for the Dashboard is decided on: WPPLUGINTOPLEVEL_FRONTEND_USER_DASHBOARD_SHORTCODE_URL
*/

/*
 * SETUP NOTES:
 *
 * Rename root plugin folder to an all-lowercase version of wpplugintoplevel
 *
 * Change all filename instances from wpplugintoplevel to desired plugin name
 *
 * Modify Plugin Name
 *
 * Modify Description
 *
 * Modify Version Number in Block comment and in Constant
 *
 * Find & Replace these strings:
 * wpplugintoplevel
 * wppluginToplevel
 * WPPlugintoplevel
 * WPPluginToplevel
 * WPPLUGINTOPLEVEL
 * WPPlugin
 * wpplugin
 * $toplevel
 * TOPLEVEL
 * wpplugintoplevel-extension
 * WPPLUGINTOPLEVEL_FRONTEND_USER_DASHBOARD_SHORTCODE_URL - Change this value to the final URL the User Dashboard will live on
 * SITETHING - rename to whatever we're 'saving' or recording to the database. Is this for cars, vendors, contacts, etc. really to be used for the editing of whatever this database is concenred with in the 'class-settings-two-form.php' file. Replace it with something lowercase.
 * repw with something also random - db column that holds license.
 *
 * Rename and/or delete the Node_Modules folder to prevent that Sass error message when running Gulp
 *
 * Change the EDD_SL_ITEM_ID_WPPLUGINTOPLEVEL contant below.
 *
 * Install Gulp & all Plugins listed in gulpfile.js
 *
 *
 *
 *
 */

/*
* HOW TO SEARCH FOR TEXT BETWEEN TWO CHARACTERS!
* =([^;]*);
* the above will let you search for and select all characters between an "=" sign and a ";"
*
*
*/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;

/* REQUIRE STATEMENTS */
	require_once 'includes/class-wpplugintoplevel-general-functions.php';
	require_once 'includes/class-wpplugintoplevel-ajax-functions.php';
	require_once 'includes/classes/update/class-wpplugintoplevel-update.php';
/* END REQUIRE STATEMENTS */

/* CONSTANT DEFINITIONS */

	if ( ! defined('WPPLUGINTOPLEVEL_VERSION_NUM' ) ) {
		define( 'WPPLUGINTOPLEVEL_VERSION_NUM', '1.0.0' );
	}

	// This is the URL our updater / license checker pings. This should be the URL of the site with EDD installed.
	define( 'EDD_SL_STORE_URL_WPPLUGINTOPLEVEL', 'https://wpplugin.com' );

	// The id of your product in EDD.
	define( 'EDD_SL_ITEM_ID_WPPLUGINTOPLEVEL', 46 );

	// This Extension's Version Number.
	define( 'WPPLUGINTOPLEVEL_VERSION_NUM', '1.0.0' );

	// Root plugin folder directory.
	define( 'WPPLUGINTOPLEVEL_ROOT_DIR', plugin_dir_path( __FILE__ ) );

	// Root WordPress Plugin Directory. The If is for taking into account the update process - a temp folder gets created when updating, which temporarily replaces the 'wpplugin-bulkbookupload' folder.
	if ( false !== stripos( plugin_dir_path( __FILE__ ) , '/wpplugintoplevel' ) ) { 
		define( 'WPPLUGINTOPLEVEL_ROOT_WP_PLUGINS_DIR', str_replace( '/wpplugintoplevel', '', plugin_dir_path( __FILE__ ) ) );
	} else {
		$temp = explode( 'plugins/', plugin_dir_path( __FILE__ ) );
		define( 'WPPLUGINTOPLEVEL_ROOT_WP_PLUGINS_DIR', $temp[0] . 'plugins/' );
	}

	// Root plugin folder URL .
	define( 'WPPLUGINTOPLEVEL_ROOT_URL', plugins_url() . '/wpplugintoplevel/' );

	// Root Classes Directory.
	define( 'WPPLUGINTOPLEVEL_CLASS_DIR', WPPLUGINTOPLEVEL_ROOT_DIR . 'includes/classes/' );

	// Root Update Directory.
	define( 'WPPLUGINTOPLEVEL_UPDATE_DIR', WPPLUGINTOPLEVEL_CLASS_DIR . 'update/' );

	// Root REST Classes Directory.
	define( 'WPPLUGINTOPLEVEL_CLASS_REST_DIR', WPPLUGINTOPLEVEL_ROOT_DIR . 'includes/classes/rest/' );

	// Root Compatability Classes Directory.
	define( 'WPPLUGINTOPLEVEL_CLASS_COMPAT_DIR', WPPLUGINTOPLEVEL_ROOT_DIR . 'includes/classes/compat/' );

	// Root Transients Directory.
	define( 'WPPLUGINTOPLEVEL_CLASS_TRANSIENTS_DIR', WPPLUGINTOPLEVEL_ROOT_DIR . 'includes/classes/transients/' );

	// Root Image URL.
	define( 'WPPLUGINTOPLEVEL_ROOT_IMG_URL', WPPLUGINTOPLEVEL_ROOT_URL . 'assets/img/' );

	// Root Image Icons URL.
	define( 'WPPLUGINTOPLEVEL_ROOT_IMG_ICONS_URL', WPPLUGINTOPLEVEL_ROOT_URL . 'assets/img/icons/' );

	// Root CSS URL.
	define( 'WPPLUGINTOPLEVEL_CSS_URL', WPPLUGINTOPLEVEL_ROOT_URL . 'assets/css/' );

	// Root JS URL.
	define( 'WPPLUGINTOPLEVEL_JS_URL', WPPLUGINTOPLEVEL_ROOT_URL . 'assets/js/' );

	// Root UI directory.
	define( 'WPPLUGINTOPLEVEL_ROOT_INCLUDES_UI', WPPLUGINTOPLEVEL_ROOT_DIR . 'includes/ui/' );

	// Root UI Admin directory.
	define( 'WPPLUGINTOPLEVEL_ROOT_INCLUDES_UI_ADMIN_DIR', WPPLUGINTOPLEVEL_ROOT_DIR . 'includes/ui/' );

	// Define the Uploads base directory.
	$uploads     = wp_upload_dir();
	$upload_path = $uploads['basedir'];
	define( 'WPPLUGINTOPLEVEL_UPLOADS_BASE_DIR', $upload_path . '/' );

	// Define the Uploads base URL.
	$upload_url = $uploads['baseurl'];
	define( 'WPPLUGINTOPLEVEL_UPLOADS_BASE_URL', $upload_url . '/' );

	// This is the Dashboard URL - the URL that the Dashboard shortcode is placed on.
	define( 'WPPLUGINTOPLEVEL_FRONTEND_USER_DASHBOARD_SHORTCODE_URL', '/front-end-account-creation-login/' );

	// Nonces array.
	define( 'WPPLUGINTOPLEVEL_NONCES_ARRAY',
		wp_json_encode(array(
			'adminnonce1' => 'wpplugintoplevel_save_license_key_action_callback',
			'adminnonce2' => 'wpplugintoplevel_add_new_user_action_callback',
			'adminnonce3' => 'wpplugintoplevel_save_user_post_action_callback',
			'adminnonce4' => 'wpplugintoplevel_edit_existing_user_action_callback',
		))
	);

/* END OF CONSTANT DEFINITIONS */

/* MISC. INCLUSIONS & DEFINITIONS */

	// Loading textdomain.
	load_plugin_textdomain( 'wpplugintoplevel', false, WPPLUGINTOPLEVEL_ROOT_DIR . 'languages' );

/* END MISC. INCLUSIONS & DEFINITIONS */

/* CLASS INSTANTIATIONS */

	// Call the class found in wpplugin-functions.php.
	$toplevel_general_functions = new WPPluginToplevel_General_Functions();

	// Call the class found in wpplugin-functions.php.
	$toplevel_ajax_functions = new WPPluginToplevel_Ajax_Functions();

	// Include the Update Class.
	$toplevel_update_functions = new WPPlugin_Toplevel_Update();


/* END CLASS INSTANTIATIONS */


/* FUNCTIONS FOUND IN CLASS-WPPLUGIN-GENERAL-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

	// For the admin pages.
	add_action( 'admin_menu', array( $toplevel_general_functions, 'wpplugintoplevel_jre_my_admin_menu' ) );

	// Adding Ajax library.
	add_action( 'wp_head', array( $toplevel_general_functions, 'wpplugintoplevel_jre_prem_add_ajax_library' ) );

	// Adding the function that will take our WPPLUGINTOPLEVEL_NONCES_ARRAY Constant from above and create actual nonces to be passed to Javascript functions.
	add_action( 'init', array( $toplevel_general_functions, 'wpplugintoplevel_create_nonces' ) );

	// Function to run any code that is needed to modify the plugin between different versions.
	//add_action( 'plugins_loaded', array( $toplevel_general_functions, 'wpplugintoplevel_update_upgrade_function' ) );

	// Adding the admin js file.
	add_action( 'admin_enqueue_scripts', array( $toplevel_general_functions, 'wpplugintoplevel_admin_js' ) );

	// Adding the frontend js file.
	add_action( 'wp_enqueue_scripts', array( $toplevel_general_functions, 'wpplugintoplevel_frontend_js' ) );

	// Adding the admin css file for this extension.
	add_action( 'admin_enqueue_scripts', array( $toplevel_general_functions, 'wpplugintoplevel_admin_style' ) );

	// Adding the Front-End css file for this extension.
	add_action( 'wp_enqueue_scripts', array( $toplevel_general_functions, 'wpplugintoplevel_frontend_style' ) );

	// Function to add table names to the global $wpdb.
	add_action( 'admin_footer', array( $toplevel_general_functions, 'wpplugintoplevel_register_table_name' ) );

	// Function that adds in any possible admin pointers
	add_action( 'admin_footer', array( $toplevel_general_functions, 'wpplugintoplevel_admin_pointers_javascript' ) );

	// Creates tables upon activation.
	register_activation_hook( __FILE__, array( $toplevel_general_functions, 'wpplugintoplevel_create_tables' ) );

	// Adding the front-end login / dashboard shortcode.
	add_shortcode( 'wpplugintoplevel_login_shortcode', array( $toplevel_general_functions, 'wpplugintoplevel_login_shortcode_function' ) );

	// Function that logs in a user automatically after they've first registered.
	add_action( 'after_setup_theme', array( $toplevel_general_functions, 'wpplugintoplevel_autologin_after_registering' ) );

/* END OF FUNCTIONS FOUND IN CLASS-WPPLUGIN-GENERAL-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

/* FUNCTIONS FOUND IN CLASS-WPPLUGIN-AJAX-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

// Function for manually adding a new user from the dashboard. 
add_action( 'wp_ajax_wpplugintoplevel_add_new_user_action', array( $toplevel_ajax_functions, 'wpplugintoplevel_add_new_user_action_callback' ) );

// Function for manually adding a new user from the frontend. 
add_action( 'wp_ajax_nopriv_wpplugintoplevel_add_new_user_action', array( $toplevel_ajax_functions, 'wpplugintoplevel_add_new_user_action_callback' ) );

// Function for editing a user from the dashboard. 
add_action( 'wp_ajax_wpplugintoplevel_edit_existing_user_action', array( $toplevel_ajax_functions, 'wpplugintoplevel_edit_existing_user_action_callback' ) );

// Function for saving a post from the frontend. 
add_action( 'wp_ajax_wpplugintoplevel_save_user_post_action', array( $toplevel_ajax_functions, 'wpplugintoplevel_save_user_post_action_callback' ) );

// Function for saving a post from the frontend. 
add_action( 'wp_ajax_nopriv_wpplugintoplevel_save_user_post_action', array( $toplevel_ajax_functions, 'wpplugintoplevel_save_user_post_action_callback' ) );


/* END OF FUNCTIONS FOUND IN CLASS-WPPLUGIN-AJAX-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */



function ajax_check_user_logged_in() {
    echo is_user_logged_in()?'yes':'no';
    die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');













