<?php
/**
 * WPPlugin Book Display Options Form Tab Class - class-wpplugin-book-display-options-form.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPlugin_Settings1_Form', false ) ) :

	/**
	 * WPPlugin_Admin_Menu Class.
	 */
	class WPPlugin_Settings1_Form {


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {

			// For grabbing an image from media library.
			wp_enqueue_media();

			wp_enqueue_script( 'password-strength-meter' );

		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings1_form() {
			global $wpdb;

			$contact_form_html = '
				<div class="wpplugin-form-section-wrapper">
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Username</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-username" type="text" placeholder="User\'s Username" />
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Password</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-password" name="password" type="text" placeholder="User\'s Password" />
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Verify Password</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-passwordverify" name="password_retyped" type="text" placeholder="Verify User\'s Password" />
						</div>
					</div>
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<p style="opacity:0" id="password-strength">Password Strength is...</p>
						</div>
					</div>
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">First Name</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-firstname" type="text" placeholder="User\'s First Name" />
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Last Name</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-lastname" type="text" placeholder="User\'s Last Name" />
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Cell Phone</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-cellphone" type="text" placeholder="User\'s Cell Phone" />
						</div>
					</div>
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Office Phone</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-officephone" type="text" placeholder="Users\'s Office Phone" />
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Email</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-email" type="text" placeholder="User\'s Email Address" />
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Street Address</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-streetaddress" type="text" placeholder="User\'s Street Address" />
						</div>
					</div>
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">City</label>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-city" type="text" placeholder="User\'s City" />
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">State</label>
							<select class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-select" id="wpplugin-user-state" type="text" placeholder="User\'s State">
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
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-zip" type="text" placeholder="User\'s Zip Code" />
						</div>
					</div>
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">General Notes & Comments about this User</label>
							<textarea class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-textarea" id="wpplugin-user-comments" type="text" placeholder="Enter comments about this User here!"></textarea>
						</div>
					</div>
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">User Image #1</label>
							<div class="wpplugin-form-section-placeholder-image-wrapper">
								<img class="wpplugin-form-section-placeholder-image" id="wpplugin-form-section-placeholder-image-frontcover-actual" src="' . WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'user-image-placeholder.png" />
							</div>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-image1" type="text" placeholder="Enter URL or use button below" />
							<button class="wpplugin-form-section-placeholder-image-button" id="wpplugin-form-section-placeholder-image-button-frontcover">Choose Image...</button>
						</div>
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">User Image #2</label>
							<div class="wpplugin-form-section-placeholder-image-wrapper">
								<img class="wpplugin-form-section-placeholder-image" id="wpplugin-form-section-placeholder-image-backcover-actual" src="' . WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'user-image-placeholder.png" />
							</div>
							<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-image2" type="text" placeholder="Enter URL or use button below" />
							<button class="wpplugin-form-section-placeholder-image-button" id="wpplugin-form-section-placeholder-image-button-backcover">Choose Image...</button>
						</div>
					</div>
					<div class="wpplugin-form-section-fields-wrapper">
						<div class="wpplugin-form-section-fields-indiv-wrapper">
							<label class="wpplugin-form-section-fields-label">Add This User Now!</label>
							<button class="wpplugin-form-section-submit-button" id="wpplugin-form-section-add-new-user-button">Add User</button>
							<div class="wpplugin-spinner"></div>
		 					<div class="wpplugin-response-div-actual-container">
		 						<p class="wpplugin-response-div-p"></p>
		 					</div>
						</div>
					</div>
				</div>';


			$string1 = '
				<div id="wpplugin-display-options-container">
					<p class="wpplugin-tab-intro-para">Here you\'ll create brand-new Users from scratch!</p>
					<div class="wpplugin-form-wrapper wpplugin-form-wrapper-create-users">
						' . $contact_form_html . '

					


					</div>
				</div>';

			echo $string1;
		}
	}
endif;
