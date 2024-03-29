<?php
/**
 * Class WPPluginToplevel_General_Functions - class-toplevel-general-functions.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes
 * @version  6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPluginToplevel_General_Functions', false ) ) :
	/**
	 * WPPluginToplevel_General_Functions class. Here we'll do things like enqueue scripts/css, set up menus, etc.
	 */
	class WPPluginToplevel_General_Functions {

		/**
		 *  Functions that loads up all menu pages/contents, etc.
		 */
		public function wpplugintoplevel_jre_admin_page_function() {
			global $wpdb;
			require_once WPPLUGINTOPLEVEL_ROOT_INCLUDES_UI_ADMIN_DIR . 'class-admin-master-ui.php';
		}

		/**
		 *  Function that logs in a user automatically after they've first registered.
		 */
		public function wpplugintoplevel_autologin_after_registering() {

			if ( false !== stripos( $_SERVER['REQUEST_URI'], '?un=' ) ) {

				$username = filter_var( $_GET['un'], FILTER_SANITIZE_STRING );
				$user     = get_user_by( 'login', $username );

				// Redirect URL.
				if ( ! is_wp_error( $user ) ) {
					clean_user_cache( $user->ID );
					wp_clear_auth_cookie();
					wp_set_current_user($user->ID);
					wp_set_auth_cookie( $user->ID, true, false );
					update_user_caches( $user );
				}
			}
		}

		/**
		 *  Code for adding ajax
		 */
		public function wpplugintoplevel_jre_prem_add_ajax_library() {

			$html = '<script type="text/javascript">';

			// Checking $protocol in HTTP or HTTPS.
			if ( isset( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] ) {
				// This is HTTPS.
				$protocol = 'https';
			} else {
				// This is HTTP.
				$protocol = 'http';
			}
			$temp_ajax_path = admin_url( 'admin-ajax.php' );
			$good_ajax_url  = $protocol . strchr( $temp_ajax_path, ':' );

			$html .= 'var ajaxurl = "' . $good_ajax_url . '"';
			$html .= '</script>';
			echo $html;
		}

		/** Functions that loads up the menu page entry for this Extension.
		 *
		 *  @param array $submenu_array - The array that contains submenu entries to add to.
		 */
		public function wpplugintoplevel_jre_my_admin_menu() {
			add_menu_page( 'Bell  WPPluginToplevel', 'WPPluginToplevel', 'manage_options', 'WPPluginToplevel-Options', array( $this, 'wpplugintoplevel_jre_admin_page_function' ), WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'belllogonocanvas.png', 6 );

			$submenu_array = array(
				'Users',
				'Submenu Page1',
				'Submenu Page2',
				'Submenu Page3',
			);

			// Filter to allow the addition of a new subpage.
			if ( has_filter( 'toplevel_add_sub_menu' ) ) {
				$submenu_array = apply_filters( 'toplevel_add_sub_menu', $submenu_array );
			}

			foreach ( $submenu_array as $key => $submenu ) {
				$menu_slug = strtolower( str_replace( ' ', '-', $submenu ) );
				add_submenu_page( 'WPPluginToplevel-Options', 'WPPluginToplevel', $submenu, 'manage_options', 'WPPluginToplevel-Options-' . $menu_slug, array( $this, 'wpplugintoplevel_jre_admin_page_function' ) );
			}

			remove_submenu_page( 'WPPluginToplevel-Options', 'WPPluginToplevel-Options' );
		}

		/**
		 *  Here we take the Constant defined in wpplugin.php that holds the values that all our nonces will be created from, we create the actual nonces using wp_create_nonce, and the we define our new, final nonces Constant, called WPPLUGIN_FINAL_NONCES_ARRAY.
		 */
		public function wpplugintoplevel_create_nonces() {

			$temp_array = array();
			foreach ( json_decode( WPPLUGINTOPLEVEL_NONCES_ARRAY ) as $key => $noncetext ) {
				$nonce              = wp_create_nonce( $noncetext );
				$temp_array[ $key ] = $nonce;
			}

			// Defining our final nonce array.
			define( 'TOPLEVEL_FINAL_NONCES_ARRAY', wp_json_encode( $temp_array ) );

		}

		/**
		 *  Function to run the compatability code in the Compat class for upgrades/updates, if stored version number doesn't match the defined global in wpplugintoplevel.php
		 */
		public function wpplugintoplevel_update_upgrade_function() {

			// Get current version #.
			global $wpdb;
			$existing_string = $wpdb->get_row( 'SELECT * from ' . $wpdb->prefix . 'wpplugintoplevel_jre_user_options' );

			// Check to see if Extension is already registered and matches this version.
			if ( false !== strpos( $existing_string->extensionversions, 'wpplugintoplevel' ) ) {
				$split_string = explode( 'wpplugintoplevel', $existing_string->extensionversions );
				$version      = substr( $split_string[1], 0, 5 );

				// If version number does not match the current version number found in wpplugin.php, call the Compat class and run upgrade functions.
				if ( WPPLUGINTOPLEVEL_VERSION_NUM !== $version ) {
					require_once TOPLEVEL_CLASS_COMPAT_DIR . 'class-toplevel-compat-functions.php';
					$compat_class = new WPPluginToplevel_Compat_Functions();
				}
			}
		}

		/**
		 * Adding the admin js file
		 */
		public function wpplugintoplevel_admin_js() {

			wp_register_script( 'wpplugintoplevel_adminjs', WPPLUGINTOPLEVEL_JS_URL . 'wpplugintoplevel_admin.min.js', array( 'jquery' ), WPPLUGINTOPLEVEL_VERSION_NUM, true );

			global $wpdb;

			$final_array_of_php_values = array();

			// Now grab all of our Nonces to pass to the JavaScript for the Ajax functions and merge with the Translations array.
			$final_array_of_php_values = array_merge( $final_array_of_php_values, json_decode( TOPLEVEL_FINAL_NONCES_ARRAY, true ) );

			// Adding some other individual values we may need.
			$final_array_of_php_values['WPPLUGINTOPLEVEL_ROOT_IMG_ICONS_URL']   = WPPLUGINTOPLEVEL_ROOT_IMG_ICONS_URL;
			$final_array_of_php_values['WPPLUGINTOPLEVEL_ROOT_IMG_URL']   = WPPLUGINTOPLEVEL_ROOT_IMG_URL;
			$final_array_of_php_values['FOR_TAB_HIGHLIGHT']    = admin_url() . 'admin.php';
			$final_array_of_php_values['SAVED_ATTACHEMENT_ID'] = get_option( 'media_selector_attachment_id', 0 );
			$final_array_of_php_values['SETTINGS_PAGE_URL'] = menu_page_url( 'WPBookList-Options-settings', false );
			$final_array_of_php_values['DB_PREFIX'] = $wpdb->prefix;


			// Now registering/localizing our JavaScript file, passing all the PHP variables we'll need in our $final_array_of_php_values array, to be accessed from 'wpbooklist_php_variables' object (like wpbooklist_php_variables.nameofkey, like any other JavaScript object).
			wp_localize_script( 'wpplugintoplevel_adminjs', 'wppluginToplevelPhpVariables', $final_array_of_php_values );

			wp_enqueue_script( 'wpplugintoplevel_adminjs' );

		}

		/**
		 * Adding the frontend js file
		 */
		public function wpplugintoplevel_frontend_js() {

			global $wpdb;

			wp_register_script( 'wpplugintoplevel_frontendjs', WPPLUGINTOPLEVEL_JS_URL . 'wpplugintoplevel_frontend.min.js', array( 'jquery' ), WPPLUGINTOPLEVEL_VERSION_NUM, true );

			$final_array_of_php_values = array();

			// Now grab all of our Nonces to pass to the JavaScript for the Ajax functions and merge with the Translations array.
			$final_array_of_php_values = array_merge( $final_array_of_php_values, json_decode( TOPLEVEL_FINAL_NONCES_ARRAY, true ) );

			// Adding some other individual values we may need.
			$final_array_of_php_values['WPPLUGINTOPLEVEL_ROOT_IMG_ICONS_URL']   = WPPLUGINTOPLEVEL_ROOT_IMG_ICONS_URL;
			$final_array_of_php_values['WPPLUGINTOPLEVEL_ROOT_IMG_URL']   = WPPLUGINTOPLEVEL_ROOT_IMG_URL;
			$final_array_of_php_values['FOR_TAB_HIGHLIGHT']    = admin_url() . 'admin.php';
			$final_array_of_php_values['SAVED_ATTACHEMENT_ID'] = get_option( 'media_selector_attachment_id', 0 );
			$final_array_of_php_values['DB_PREFIX'] = $wpdb->prefix;
			$final_array_of_php_values['IS_USER_LOGGED_IN']   = is_user_logged_in();
			$final_array_of_php_values['USER_WPID']   = get_current_user_id();
			$final_array_of_php_values['CURRENT_POST_ID']   = get_the_ID();

			// Get some info to provide to the front-end for the saving of posts.
			$current_user = wp_get_current_user();
			$table_name = $wpdb->prefix . 'wpplugintoplevel_user_saved_posts';
			$user_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE email = %s", $current_user->user_email ) );
			error_log($current_user->user_email);
			$final_array_of_php_values['USER_SAVED_POST_IDS']   = $user_info->postids;
			$final_array_of_php_values['FRONTEND_USER_DASHBOARD_SHORTCODE_URL']   = WPPLUGINTOPLEVEL_FRONTEND_USER_DASHBOARD_SHORTCODE_URL;


			// Now registering/localizing our JavaScript file, passing all the PHP variables we'll need in our $final_array_of_php_values array, to be accessed from 'wpbooklist_php_variables' object (like wpbooklist_php_variables.nameofkey, like any other JavaScript object).
			wp_localize_script( 'wpplugintoplevel_frontendjs', 'wppluginToplevelPhpVariables', $final_array_of_php_values );

			wp_enqueue_script( 'wpplugintoplevel_frontendjs' );

		}

		/**
		 * Adding the admin css file
		 */
		public function wpplugintoplevel_admin_style() {

			wp_register_style( 'wpplugintoplevel_adminui', WPPLUGINTOPLEVEL_CSS_URL . 'wpplugintoplevel-main-admin.css', null, WPPLUGINTOPLEVEL_VERSION_NUM );
			wp_enqueue_style( 'wpplugintoplevel_adminui' );

		}

		/**
		 * Adding the frontend css file
		 */
		public function wpplugintoplevel_frontend_style() {

			wp_register_style( 'wpplugintoplevel_frontendui', WPPLUGINTOPLEVEL_CSS_URL . 'wpplugintoplevel-main-frontend.css', null, WPPLUGINTOPLEVEL_VERSION_NUM );
			wp_enqueue_style( 'wpplugintoplevel_frontendui' );

		}

		/**
		 *  Function to add table names to the global $wpdb.
		 */
		public function wpplugintoplevel_register_table_name() {
			global $wpdb;
			$wpdb->wpplugintoplevel_settings = "{$wpdb->prefix}wpplugintoplevel_settings";
			$wpdb->wpplugintoplevel_users = "{$wpdb->prefix}wpplugintoplevel_users";
			$wpdb->wpplugintoplevel_user_saved_posts = "{$wpdb->prefix}wpplugintoplevel_user_saved_posts";
		}

		/**
		 *  Function that calls the Style and Scripts needed for displaying of admin pointer messages.
		 */
		public function wpplugintoplevel_admin_pointers_javascript() {
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'utils' );
		}

		/**
		 *  Runs once upon plugin activation and creates the table that holds info on WPPlugin Pages & Posts.
		 */
		public function wpplugintoplevel_create_tables() {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			global $wpdb;
			global $charset_collate;

			// Call this manually as we may have missed the init hook.
			$this->wpplugintoplevel_register_table_name();

			$sql_create_table1 = "CREATE TABLE {$wpdb->wpplugintoplevel_settings}
			(
				ID bigint(190) auto_increment,
				repw varchar(255),
				PRIMARY KEY  (ID),
				KEY repw (repw)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'wpplugintoplevel_settings';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table1 );
				$table_name = $wpdb->prefix . 'wpplugintoplevel_settings';
				$wpdb->insert( $table_name, array( 'ID' => 1, ) );
			}

			$sql_create_table2 = "CREATE TABLE {$wpdb->wpplugintoplevel_users}
			(
				ID bigint(190) auto_increment,
				wpuserid varchar(255),
				username varchar(255),
				password varchar(255),
				firstname varchar(255),
				lastname varchar(255),
				contactstreetaddress varchar(255),
				contactcity varchar(255),
				contactstate varchar(255),
				contactzip varchar(255),
				billingstreetaddress varchar(255),
				billingcity varchar(255),
				billingstate varchar(255),
				billingzip varchar(255),
				phonecell varchar(255),
				phoneoffice varchar(255),
				email varchar(255),
				userimage1 varchar(255),
				userimage2 varchar(255),
				comments MEDIUMTEXT,
				PRIMARY KEY  (ID),
				KEY email (email)
			) $charset_collate; ";

			// If table doesn't exist, create table.
			$test_name = $wpdb->prefix . 'wpplugintoplevel_users';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table2 );
			}


			$sql_create_table3 = "CREATE TABLE {$wpdb->wpplugintoplevel_user_saved_posts}
			(
				ID bigint(190) auto_increment,
				email varchar(255),
				wpuserid varchar(255),
				postids MEDIUMTEXT,
				PRIMARY KEY  (ID),
				KEY wpuserid (wpuserid)
			) $charset_collate; ";

			// If table doesn't exist, create table.
			$test_name = $wpdb->prefix . 'wpplugintoplevel_user_saved_posts';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table3 );
			}
		}

		/**
		 *  The shortcode for displaying the login form / register forms / dashboard.
		 */
		public function wpplugintoplevel_login_shortcode_function() {

			ob_start();
			include_once WPPLUGINTOPLEVEL_CLASS_DIR . 'class-wpplugintoplevel-dashboard-ui.php';
			$front_end_ui = new WPPluginToplevel_Dashboard_UI();
			return ob_get_clean();

		}

	}
endif;
