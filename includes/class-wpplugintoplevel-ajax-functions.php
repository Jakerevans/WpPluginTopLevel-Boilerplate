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
	        		'wpuserid' => $user_id,
	        		'password' =>  wp_hash_password( $password ),
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
	        		'%s',
	        	);

	        	$result = $wpdb->insert(  $table_name, $db_insert_array, $db_mask_insert_array );

	        	wp_die( $username );
			}	
		}

		function wpplugintoplevel_edit_existing_user_action_callback(){
			global $wpdb;
			//check_ajax_referer( 'wpplugintoplevel_action_callback', 'security' );

			$password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
			$id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
			$wpuserid = filter_var($_POST['wpuserid'],FILTER_SANITIZE_STRING);
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

			// First lets get the current entry for this user
			$table_name = $wpdb->prefix . 'wpplugintoplevel_users';
			$user_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE ID = %s", $id ) );

			// First see if they're even trying to change their email.
			$change_email_flag = false;
			if ( $email !== $user_info->email ) {

				// Now if they are trying to change their email, check and see if there's a WordPress user with that email address already.
				if( email_exists( $email ) ) {
					error_log('second one');
					wp_die( 'Whoops! Looks like someone is already registered with this Email Address!' );
				}

				// Now check and see if there's a user with that email address registered already in our plugin.
				$user_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE email = %s", $email ) );
				if ( null !== $user_info ) {
					wp_die( 'Whoops! Looks like someone is already registered with this Email Address!' );
				}

				$change_email_flag = true;
        	}

        	// Determine if we need to change the password
        	$change_password_flag = false;
        	if ( '' !== $password && null !== $password ) {
        		$change_password_flag = true;
        	}

        	if ( $change_password_flag ) {
	        	$db_insert_array = array(
	        		'password' =>  wp_hash_password( $password ),
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
	        	);

        	} else {
        		$db_insert_array = array(
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
	        	);
        	}

			$result =$wpdb->update( $table_name, $db_insert_array, array( 'ID'=>$id ) );

			// Now make some actual WordPress updates to the User if needed.
			if( $change_email_flag ){
        		wp_update_user( array ('ID' => $wpuserid, 'user_email' => sanitize_email( $email )));
        	}

        	if( $change_password_flag ){
        		wp_set_password( $password, $wpuserid );
        	}

        	wp_die( $result );
		}

		function wpplugintoplevel_save_user_post_action_callback(){
			global $wpdb;
			//check_ajax_referer( 'wpplugintoplevel_action_callback', 'security' );

			$postid = filter_var($_POST['postid'],FILTER_SANITIZE_STRING);
			$userid = filter_var($_POST['userid'],FILTER_SANITIZE_STRING);

			// First get any existing saved posts...
			$table_name = $wpdb->prefix . 'wpplugintoplevel_user_saved_posts';
			$user_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE wpuserid = %s", $userid ) );
			
	        	
        	// Building array to add to DB.
        	$db_insert_array = array(
        		'postids' =>  $user_info->postids . ',' . $postid,
        	);

        	$result =$wpdb->update( $table_name, $db_insert_array, array( 'wpuserid'=>$userid ) );

        	wp_die( $result );
		}



	}

endif;



