

<?php
/**
 * MedWestHealthPoints_Dashboard_UI Class that dispalys the login form or the user dashboard - class-wpplugin-dashboard-ui.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPluginToplevel_Dashboard_UI', false ) ) :

	/**
	 * MedWestHealthPoints_Admin_Menu Class.
	 */
	class WPPluginToplevel_Dashboard_UI {


		/**
		 * Class Constructor
		 */
		public function __construct() {

			// For grabbing an image from media library.
			wp_enqueue_media();

			wp_enqueue_script( 'password-strength-meter' );

			// See if we have a currently logged-in user.
			$loggedin = is_user_logged_in();

			// If user is logged in...
			if ( $loggedin ) {
				$this->stitch_logged_in_member_html();
			} else {
				$this->stitch_login_or_register_html();
			}

		}

		/**
		 * Builds and outputs the final HTML for individuals to sign in or register.
		 */
		public function stitch_login_or_register_html() {
			$this->display_login_or_register_form();
		}

		/**
		 * Builds and outputs the final HTML for individuals who are already registered.
		 */
		public function stitch_logged_in_member_html() {
			$this->display_registered_user_dashboard();
		}

		/**
		 * The Login/Register HTML.
		 */
		public function display_login_or_register_form() {

			$args = array(
				'echo'           => false,
				'remember'       => true,
				'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
				'form_id'        => 'wpplugin-dashboard-login-row-wrapper',
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'label_username' => __( 'Username' ),
				'label_password' => __( 'Password' ),
				'label_remember' => __( 'Remember Me' ),
				'label_log_in'   => __( 'Log In' ),
				'value_username' => '',
				'value_remember' => false
			);

			$login_register_html = '<div id="wpplugin-dashboard-container">
										<div id="wpplugin-dashboard-login-wrapper">
											<p class="wpplugin-tab-intro-para">' . $this->loginform_text . '</p>' . wp_login_form( $args ) . '
										</div>
										<div class="wpplugin-spinner" id="wpplugin-spinner-1">
										</div>
									<div id="wpplugin-not-registered-top-container">
										<p>Not Registered? Sign up below!</p>
										<div class="wpplugin-form-section-wrapper">
											<div class="wpplugin-form-section-fields-wrapper">
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Username</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-username" type="text" placeholder="Your Username" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Password</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-password" name="password" type="password" placeholder="Your Password" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Verify Password</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-passwordverify" name="password_retyped" type="password" placeholder="Verify Your Password" />
												</div>
											</div>
											<div class="wpplugin-form-section-fields-wrapper">
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<button class="wpplugin-form-section-submit-button" id="wpplugin-form-section-see-new-user-password" data-visibility="hidden">View Password</button>
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<p style="opacity:0" id="password-strength">Password Strength is...</p>
												</div>
											</div>
											<div class="wpplugin-form-section-fields-wrapper">
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">First Name</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-firstname" type="text" placeholder="Your First Name" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Last Name</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-lastname" type="text" placeholder="Your Last Name" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Cell Phone</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-cellphone" type="text" placeholder="Your Cell Phone" />
												</div>
											</div>
											<div class="wpplugin-form-section-fields-wrapper">
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Office Phone</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-officephone" type="text" placeholder="Users\'s Office Phone" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Email</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-email" type="text" placeholder="Your Email Address" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Street Address</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-streetaddress" type="text" placeholder="Your Street Address" />
												</div>
											</div>
											<div class="wpplugin-form-section-fields-wrapper">
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">City</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-city" type="text" placeholder="Your City" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">State</label>
													<select class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-select" id="wpplugin-user-state" type="text" placeholder="Your State">
														<option value="AL">Alabama</option>
														<option value="AK">Alaska</option>
														<option value="AZ">Arizona</option>
														<option value="AR">Arkansas</option>
														<option value="CA">California</option>
														<option value="CO">Colorado</option>
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="DC">District Of Columbia</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="HI">Hawaii</option>
														<option value="ID">Idaho</option>
														<option value="IL">Illinois</option>
														<option value="IN">Indiana</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="MT">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NV">Nevada</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NM">New Mexico</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="ND">North Dakota</option>
														<option value="OH">Ohio</option>
														<option value="OK">Oklahoma</option>
														<option value="OR">Oregon</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="SD">South Dakota</option>
														<option value="TN">Tennessee</option>
														<option value="TX">Texas</option>
														<option value="UT">Utah</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WA">Washington</option>
														<option value="WV">West Virginia</option>
														<option value="WI">Wisconsin</option>
														<option value="WY">Wyoming</option>
													</select>
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Zip Code</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-zip" type="text" placeholder="Your Zip Code" />
												</div>
											</div>
											<div class="wpplugin-form-section-fields-wrapper">
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<button class="wpplugin-form-section-submit-button" id="wpplugin-form-section-add-new-user-button">Register</button>
													<div class="wpplugin-spinner"></div>
								 					<div class="wpplugin-response-div-actual-container">
								 						<p class="wpplugin-response-div-p"></p>
								 					</div>
												</div>
											</div>
										</div>
									</div>
									</div>';




			echo $login_register_html;


		}

		/**
		 * The Dashboard HTML for those already registered.
		 */
		public function display_registered_user_dashboard() {

			// Get logged in user's info
			$current_user = wp_get_current_user();

			global $wpdb;
			$table_name = $wpdb->prefix . 'wpplugintoplevel_users';
			// Check for duplicate email.
			$user_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE email = %s", $current_user->user_email ) );

			// Build the state selction drop-down deal.
				switch ( $user_info->contactstate ) {
					case 'AL':
						$selected1 = 'selected';
						break;
					case 'AK':
						$selected2 = 'selected';
						break;
					case 'AZ':
						$selected3 = 'selected';
						break;
					case 'AR':
						$selected4 = 'selected';
						break;
					case 'CA':
						$selected5 = 'selected';
						break;
					case 'CO':
						$selected6 = 'selected';
						break;
					case 'CT':
						$selected7 = 'selected';
						break;
					case 'DE':
						$selected8 = 'selected';
						break;
					case 'DC':
						$selected9 = 'selected';
						break;
					case 'FL':
						$selected10 = 'selected';
						break;
					case 'GA':
						$selected11 = 'selected';
						break;
					case 'HI':
						$selected12 = 'selected';
						break;
					case 'ID':
						$selected13 = 'selected';
						break;
					case 'IL':
						$selected14 = 'selected';
						break;
					case 'IN':
						$selected15 = 'selected';
						break;
					case 'IA':
						$selected16 = 'selected';
						break;
					case 'KS':
						$selected17 = 'selected';
						break;
					case 'KY':
						$selected18 = 'selected';
						break;
					case 'LA':
						$selected19 = 'selected';
						break;
					case 'ME':
						$selected20 = 'selected';
						break;
					case 'MD':
						$selected21 = 'selected';
						break;
					case 'MA':
						$selected22 = 'selected';
						break;
					case 'MI':
						$selected23 = 'selected';
						break;
					case 'MN':
						$selected24 = 'selected';
						break;
					case 'MS':
						$selected25 = 'selected';
						break;
					case 'MO':
						$selected26 = 'selected';
						break;
					case 'MT':
						$selected27 = 'selected';
						break;
					case 'NE':
						$selected28 = 'selected';
						break;
					case 'NV':
						$selected29 = 'selected';
						break;
					case 'NH':
						$selected30 = 'selected';
						break;
					case 'NJ':
						$selected31 = 'selected';
						break;
					case 'NM':
						$selected32 = 'selected';
						break;
					case 'NY':
						$selected33 = 'selected';
						break;
					case 'NC':
						$selected34 = 'selected';
						break;
					case 'ND':
						$selected35 = 'selected';
						break;
					case 'OH':
						$selected36 = 'selected';
						break;
					case 'OK':
						$selected37 = 'selected';
						break;
					case 'OR':
						$selected38 = 'selected';
						break;
					case 'PA':
						$selected39 = 'selected';
						break;
					case 'RI':
						$selected40 = 'selected';
						break;
					case 'SC':
						$selected41 = 'selected';
						break;
					case 'SD':
						$selected42 = 'selected';
						break;
					case 'TN':
						$selected43 = 'selected';
						break;
					case 'TX':
						$selected44 = 'selected';
						break;
					case 'UT':
						$selected45 = 'selected';
						break;
					case 'VT':
						$selected46 = 'selected';
						break;
					case 'VA':
						$selected47 = 'selected';
						break;
					case 'WA':
						$selected48 = 'selected';
						break;
					case 'WV':
						$selected49 = 'selected';
						break;
					case 'WI':
						$selected50 = 'selected';
						break;
					case 'WY':
						$selected51 = 'selected';
						break;
					
					default:
						// code...
						break;
				}

			$opening_html = '<div id="wpplugin-form-section-wrapper-forms-and-tabs-container">
												<div id="wpplugin-form-section-wrapper-lefthand-tabs-container">
													<div id="wpplugin-form-section-wrapper-lefthand-tabs-inner-wrapper">
														<div class="wpplugin-form-section-wrapper-lefthand-tabs-actual wpplugin-form-section-wrapper-lefthand-tabs-actual-accountinfo wpplugin-form-section-wrapper-lefthand-tabs-actual-active">
															<p>Account&nbsp;Info</p>
														</div>
														<div class="wpplugin-form-section-wrapper-lefthand-tabs-actual wpplugin-form-section-wrapper-lefthand-tabs-actual-savedposts">
															<p>Saved&nbsp;Posts</p>
														</div>
													</div>
												</div>
												<div id="wpplugin-form-section-wrapper-top-container">';

			$logged_in_user_dashboard_accountinfo_html = '
													<div class="wpplugin-form-section-wrapper wpplugin-form-section-wrapper-accountinfo">
														<div class="wpplugin-form-section-fields-wrapper">
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">Username</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->username . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Username</label>
																<input disabled value="' . $user_info->username . '"  class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-username" type="text" placeholder="Your Username" />
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-edit-account-button">
																<button class="wpplugin-form-section-submit-button" id="wpplugin-form-section-edit-user-account-info" data-visibility="hidden">Edit Account Info</button>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">New Password</label>
																<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-password" name="password" type="password" placeholder="New Password" />
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Verify Password</label>
																<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-passwordverify" name="password_retyped" type="password" placeholder="Verify New Password" />
															</div>
														</div>
														<div class="wpplugin-form-section-fields-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
															<div class="wpplugin-form-section-fields-indiv-wrapper">
																<button class="wpplugin-form-section-submit-button" id="wpplugin-form-section-see-new-user-password" data-visibility="hidden">View Password</button>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper">
																<p style="opacity:0" id="password-strength">Password Strength is...</p>
															</div>
														</div>
														<div class="wpplugin-form-section-fields-wrapper">
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">First Name</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->firstname . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">First Name</label>
																<input value="' . $user_info->firstname . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-firstname" type="text" placeholder="Your First Name" />
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">Last Name</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->lastname . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Last Name</label>
																<input value="' . $user_info->lastname . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-lastname" type="text" placeholder="Your Last Name" />
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">Cell Phone</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->phonecell . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Cell Phone</label>
																<input value="' . $user_info->phonecell . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-cellphone" type="text" placeholder="Your Cell Phone" />
															</div>
														</div>
														<div class="wpplugin-form-section-fields-wrapper">
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">Office Phone</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->phoneoffice . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Office Phone</label>
																<input value="' . $user_info->phoneoffice . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-officephone" type="text" placeholder="Users\'s Office Phone" />
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">Email</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->email . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Email</label>
																<input value="' . $user_info->email . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-email" type="text" placeholder="Your Email Address" />
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">Street Address</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->contactstreetaddress . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Street Address</label>
																<input value="' . $user_info->contactstreetaddress . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-streetaddress" type="text" placeholder="Your Street Address" />
															</div>
														</div>
														<div class="wpplugin-form-section-fields-wrapper">
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">City</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->contactcity . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">City</label>
																<input value="' . $user_info->contactcity . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-city" type="text" placeholder="Your City" />
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">State</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->contactstate . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">State</label>
																<select class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-select" id="wpplugin-user-state" type="text" placeholder="Your State">
																	<option ' . $selected1 . ' value="AL">Alabama</option>
																	<option ' . $selected2 . ' ="AK">Alaska</option>
																	<option ' . $selected3 . ' ="AZ">Arizona</option>
																	<option ' . $selected4 . ' ="AR">Arkansas</option>
																	<option ' . $selected5 . ' ="CA">California</option>
																	<option ' . $selected6 . ' ="CO">Colorado</option>
																	<option ' . $selected7 . ' ="CT">Connecticut</option>
																	<option ' . $selected8 . ' ="DE">Delaware</option>
																	<option ' . $selected9 . ' ="DC">District Of Columbia</option>
																	<option ' . $selected10 . ' ="FL">Florida</option>
																	<option ' . $selected11 . ' ="GA">Georgia</option>
																	<option ' . $selected12 . ' ="HI">Hawaii</option>
																	<option ' . $selected13 . ' ="ID">Idaho</option>
																	<option ' . $selected14 . ' ="IL">Illinois</option>
																	<option ' . $selected15 . ' ="IN">Indiana</option>
																	<option ' . $selected16 . ' ="IA">Iowa</option>
																	<option ' . $selected17 . ' ="KS">Kansas</option>
																	<option ' . $selected18 . ' ="KY">Kentucky</option>
																	<option ' . $selected19 . ' ="LA">Louisiana</option>
																	<option ' . $selected20 . ' ="ME">Maine</option>
																	<option ' . $selected21 . ' ="MD">Maryland</option>
																	<option ' . $selected22 . ' ="MA">Massachusetts</option>
																	<option ' . $selected23 . ' ="MI">Michigan</option>
																	<option ' . $selected24 . ' ="MN">Minnesota</option>
																	<option ' . $selected25 . ' ="MS">Mississippi</option>
																	<option ' . $selected26 . ' ="MO">Missouri</option>
																	<option ' . $selected27 . ' ="MT">Montana</option>
																	<option ' . $selected28 . ' ="NE">Nebraska</option>
																	<option ' . $selected29 . ' ="NV">Nevada</option>
																	<option ' . $selected30 . ' ="NH">New Hampshire</option>
																	<option ' . $selected31 . ' ="NJ">New Jersey</option>
																	<option ' . $selected32 . ' ="NM">New Mexico</option>
																	<option ' . $selected33 . ' ="NY">New York</option>
																	<option ' . $selected34 . ' ="NC">North Carolina</option>
																	<option ' . $selected35 . ' ="ND">North Dakota</option>
																	<option ' . $selected36 . ' ="OH">Ohio</option>
																	<option ' . $selected37 . ' ="OK">Oklahoma</option>
																	<option ' . $selected38 . ' ="OR">Oregon</option>
																	<option ' . $selected39 . ' ="PA">Pennsylvania</option>
																	<option ' . $selected40 . ' ="RI">Rhode Island</option>
																	<option ' . $selected41 . ' ="SC">South Carolina</option>
																	<option ' . $selected42 . ' ="SD">South Dakota</option>
																	<option ' . $selected43 . ' ="TN">Tennessee</option>
																	<option ' . $selected44 . ' ="TX">Texas</option>
																	<option ' . $selected45 . ' ="UT">Utah</option>
																	<option ' . $selected46 . ' ="VT">Vermont</option>
																	<option ' . $selected47 . ' ="VA">Virginia</option>
																	<option ' . $selected48 . ' ="WA">Washington</option>
																	<option ' . $selected49 . ' ="WV">West Virginia</option>
																	<option ' . $selected50 . ' ="WI">Wisconsin</option>
																	<option ' . $selected51 . ' ="WY">Wyoming</option>
																</select>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-justtext">
																<label class="wpplugin-form-section-fields-label">Zip Code</label>
																<p class="wpplugin-form-section-fields-label-actualvalue">' . $user_info->contactzip . '</p>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<label class="wpplugin-form-section-fields-label">Zip Code</label>
																<input value="' . $user_info->contactzip . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-zip" type="text" placeholder="Your Zip Code" />
															</div>
														</div>
														<div class="wpplugin-form-section-fields-wrapper">
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<button class="wpplugin-form-section-submit-button" id="wpplugin-form-section-edit-existing-user-button-from-dashboard">Save Changes</button>
																<div class="wpplugin-spinner"></div>
											 					<div class="wpplugin-response-div-actual-container">
											 						<p class="wpplugin-response-div-p"></p>
											 					</div>
															</div>
															<div class="wpplugin-form-section-fields-indiv-wrapper wpplugin-form-section-fields-indiv-wrapper-actualinput">
																<button class="wpplugin-form-section-submit-button" id="wpplugin-form-section-cancel-edit-existing-user-button-from-dashboard">Cancel Editing</button>
																<div class="wpplugin-spinner"></div>
											 					<div class="wpplugin-response-div-actual-container">
											 						<p class="wpplugin-response-div-p"></p>
											 					</div>
															</div>
														</div>
													</div>';

			// Get all of the posts the user has saved.
			$table_name = $wpdb->prefix . 'wpplugintoplevel_user_saved_posts';
			$userid = get_current_user_id();
			$user_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE wpuserid = %s", $userid ) );

			$postids = explode( ',', $user_info->postids );
			$post_html = '';
			foreach( $postids as $id ){
				$title = get_post_field( 'post_title', $id );
				$featured_image = get_the_post_thumbnail( $id, 'large' );
  				$excerpt = get_post_field( 'post_excerpt', $id );
				$post_html = $post_html . '
				<div class="wpplugin-savedposts-indiv-container" data-postid="' . $id . '">
					<a href="' . get_permalink( $id ) . '">
					<div class="wpplugin-savedposts-indiv-container-title">
						<p>' . $title . '</p>
					</div>
					<div class="wpplugin-savedposts-indiv-container-image">
						' . $featured_image . '
					</div>
					<div class="wpplugin-savedposts-indiv-container-excerpt">
						' . $excerpt . '
					</div>
					<div class="wpplugin-savedposts-indiv-container-readmore">

					</div>
					</a>
				</div>';

			}

			$logged_in_user_dashboard_savedpost_html = '
													<div style="display: none;" class="wpplugin-form-section-wrapper wpplugin-form-section-wrapper-savedposts">
														' . $post_html . '
													</div>
												</div>';

			$closing_html = '</div>';


			echo $opening_html . $logged_in_user_dashboard_accountinfo_html . $logged_in_user_dashboard_savedpost_html . $closing_html;
		}

	

	}
endif;