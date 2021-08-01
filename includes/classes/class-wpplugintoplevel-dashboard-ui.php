

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
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-password" name="password" type="text" placeholder="Your Password" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper">
													<label class="wpplugin-form-section-fields-label">Verify Password</label>
													<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-passwordverify" name="password_retyped" type="text" placeholder="Verify Your Password" />
												</div>
												<div class="wpplugin-form-section-fields-indiv-wrapper" id="password-strength">
													
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

			echo 'Welcome back, here\'s your dashboard!';

		}

	

	}
endif;