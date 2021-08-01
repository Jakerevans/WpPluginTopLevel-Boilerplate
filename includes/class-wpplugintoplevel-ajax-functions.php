<?php
/**
 * Class WPPluginToplevel_Ajax_Functions - class-wpplugin-ajax-functions.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes
 * @version  6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPluginToplevel_Ajax_Functions', false ) ) :
	/**
	 * WPPluginToplevel_Ajax_Functions class. Here we'll do things like enqueue scripts/css, set up menus, etc.
	 */
	class WPPluginToplevel_Ajax_Functions {

		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {


		}

		function wpplugintoplevel_add_new_user_action_callback(){
			global $wpdb;
			//check_ajax_referer( 'wpplugintoplevel_action_callback', 'security' );

			$username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
			$password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
			$firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_STRING);
			$lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_STRING);
			$contactstreetaddress = filter_var($_POST['contactstreetaddress'],FILTER_SANITIZE_STRING);
			$contactcity = filter_var($_POST['contactcity'],FILTER_SANITIZE_STRING);
			$contactstate = filter_var($_POST['contactstate'],FILTER_SANITIZE_STRING);
			$contactzip = filter_var($_POST['contactzip'],FILTER_SANITIZE_STRING);
			$phonecell = filter_var($_POST['phonecell'],FILTER_SANITIZE_STRING);
			$phoneoffice = filter_var($_POST['phoneoffice'],FILTER_SANITIZE_STRING);
			$email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
			$userimage1 = filter_var($_POST['userimage1'],FILTER_SANITIZE_URL);
			$userimage2 = filter_var($_POST['userimage2'],FILTER_SANITIZE_URL);
			$comments = filter_var($_POST['comments'],FILTER_SANITIZE_STRING);
			$location = filter_var($_POST['location'],FILTER_SANITIZE_STRING);

			if( username_exists( $username ) ) {
				wp_die( 'Whoops! Looks like this Username is already taken!' );
			}

			if( email_exists( $email ) ) {
				wp_die( 'Whoops! Looks like someone is already registered with this Email Address!' );
			}

			//if ( ! username_exists( $username ) && ! email_exists( $email ) ) {
		        //All clear. Go ahead.

		        // Create WP User entry
		        $user_id = wp_create_user( $username, $password, $email );

		        // WP User object
		        $wp_user = new WP_User( $user_id );

		        $display_name_change_result = wp_update_user( array( 'ID' => $user_id, 'display_name' => $firstname . ' ' . $lastname ) );

		        // Set the role of this user to subscriber.
		        $wp_user->set_role( 'subscriber' );

		        if ( ! is_wp_error( $user_id ) ){

		        	$table_name = $wpdb->prefix . 'wpplugintoplevel_users';
		        	
		        	// Building array to add to DB.
		        	$db_insert_array = array(
		        		'username' =>  $username,
		        		'password' =>  $password,
		        		'firstname' =>  $firstname,
		        		'lastname' =>  $lastname,
		        		'contactstreetaddress' =>  $contactstreetaddress,
		        		'contactcity' =>  $contactcity,
		        		'contactstate' =>  $contactstate,
		        		'contactzip' =>  $contactzip,
		        		'phonecell' =>  $phonecell,
		        		'phoneoffice' =>  $phoneoffice,
		        		'email' =>  $email,
		        		'userimage1' =>  $userimage1,
		        		'userimage2' =>  $userimage2,
		        		'comments' =>  $comments,
		        	);

		        	// Building mask array to add to DB.
		        	$db_mask_insert_array = array(
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        		'%s',
		        	);

		        	$result = $wpdb->insert(  $table_name, $db_insert_array, $db_mask_insert_array );

		        	wp_die( $username );


		        }
		   //}






/*




			// Make checks to see if we have a user in the DB with this exact email and/or QCI number already.
			$table_name = $wpdb->prefix . 'wpplugintoplevel_users';
			$email_flag = false;

			// Check for duplicate email.
			$email_check = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE email = %s", $email ) );

			if( null !== $email_check ){
				$email_flag = true;
			}

			if ( $email_flag ) {

				wp_die( '0--duplicate email--Whoops! There\'s already a user registered with this Email Address!--null--null--null' );

			} else {

				// Building array to add to DB.
				$db_insert_array = array(
					'username' =>  $username,
					'password' =>  $password,
					'firstname' =>  $firstname,
					'lastname' =>  $lastname,
					'contactstreetaddress' =>  $contactstreetaddress,
					'contactcity' =>  $contactcity,
					'contactstate' =>  $contactstate,
					'contactzip' =>  $contactzip,
					'phonecell' =>  $phonecell,
					'phoneoffice' =>  $phoneoffice,
					'email' =>  $email,
					'userimage1' =>  $userimage1,
					'userimage2' =>  $userimage2,
					'comments' =>  $comments,
				);

				// Building mask array to add to DB.
				$db_mask_insert_array = array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				);

				$result = $wpdb->insert(  $table_name, $db_insert_array, $db_mask_insert_array );

				error_log('RESULTS'.$result);

				// Now create a WordPress User.
				if ( 1 === $result ) {
					// Check to see if an account exists with the given username and email address value.
				   if ( ! username_exists( $username ) && ! email_exists( $email ) ) {
				        //All clear. Go ahead.

				        // Create WP User entry
				        $user_id = wp_create_user( $username, $password, $email );

				        // WP User object
				        $wp_user = new WP_User( $user_id );

				        $display_name_change_result = wp_update_user( array( 'ID' => $user_id, 'display_name' => $firstname . ' ' . $lastname ) );

				        // Set the role of this user to subscriber.
				        $wp_user->set_role( 'subscriber' );

				        if ( is_wp_error( $user_id ) ){
				        	error_log('IN WP_ERROR');

				        	$result = $result . '--null--null--error creating WordPress user--'. $user_id->get_error_message() . '---' . $username;
				        	wp_die( $result );
				        } else {
				        	error_log('NOT IT IN WP_ERROR');
				        	$result = $result . '--null--null--' . $user_id . '--null--' . $username;
				        	wp_die( $result );
				        }


				        
				   }
				}

				wp_die('guess we')
;
		

			}
*/
			
		}
	}

endif;



