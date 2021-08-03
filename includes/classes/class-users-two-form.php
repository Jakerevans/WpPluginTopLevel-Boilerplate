<?php
/**
 * WPPlugin Book Display Options Form Tab Class - class-wpplugin-book-display-options-form.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

/*
* INSTRUCTIONS
* Replace SITETHING with the thing we're editing here. Is this plugin for recording SITETHINGs, Leads, Cars, Websites, Properties, etc.?
* Replace 'THING1' through 'THING6' with an individual item we're going to be searching for.
* Replace 'wpplugintoplevel_SITETHING' with the database table THING5 of the main thing we're recording here.
* Replace 'THINGWENEEDWILDCARDSEARCHFOR' with one of the search things (THING1, THING2, THING3, THING4, THING5, or THING6) that we need to perform a Wildcard search on, using the MySQL 'LIKE' Operator, as opposed to a straight = operation.
* Replace 'SITETHINGTHING5' with the main THING5 of the thing we're recording. This is also the thing we'll be ordering the Queries by.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPlugin_settings2_Form', false ) ) :

	/**
	 * WPPlugin_Admin_Menu Class.
	 */
	class WPPlugin_settings2_Form {

	


		/**
		 * Class Constructor
		 */
		public function __construct() {

			wp_enqueue_script( 'password-strength-meter' );

			$this->opening_html();
			$this->build_bulk_of_html();
			$this->closing_html();
			$this->stitch_ui_html();

		}

		/**
		 * Function to output simply opening htm.
		 */
		public function opening_html()
		{
		
			$this->opening_html_actual = '
			<div id="wpplugin-display-options-container">
				<p class="wpplugin-tab-intro-para">Here you\'ll edit your existing Users!</p>
			<div class="wpplugin-form-wrapper wpplugin-form-wrapper-edit-users">';


		}

		/**
		 * Function to build bulk of HTML.
		 */
		public function build_bulk_of_html()
		{


			// Get every single user, period.
			global $wpdb;
			$users_table_name  = $wpdb->prefix . 'wpplugintoplevel_users';
			$this->all_users_array = $wpdb->get_results( $wpdb->prepare("SELECT * FROM {$users_table_name}") );

			$this->html_bulk = '';
			foreach ( $this->all_users_array as $key => $user_info ) {

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

				// Set user images
				if ( ( '' === $user_info->userimage1 ) ) {
					$user_info->userimage1 = WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'user-image-placeholder.png';
				}

				if ( ( '' === $user_info->userimage2 ) ) {
					$user_info->userimage2 = WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'user-image-placeholder.png';
				}
		
				$this->html_bulk = $this->html_bulk . '
					<div class="wpplugin-users-update-container wpplugin-all-users" >
						<button class="accordion wpplugin-users-update-container-accordion-heading" data-expandedstatus="false">
							' .  $user_info->firstname .' '. $user_info->lastname . '
						</button>
						<div class="wpplugin-users-update-info-container" data-open="false">
							<div class="wpplugin-form-wrapper">
								<div class="wpplugin-form-section-wrapper">
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Username</label>
											<input disabled value="' . $user_info->username . '"  class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-username" type="text" placeholder="Your Username" />
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">New Password</label>
											<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-password-' . $user_info->ID . '" name="password" type="password" placeholder="New Password" data-id="' . $user_info->ID . '"/>
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Verify Password</label>
											<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-passwordverify-' . $user_info->ID . '" name="password_retyped" type="password" placeholder="Verify New Password" data-id="' . $user_info->ID . '"/>
										</div>
									</div>
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<p style="opacity:0" id="password-strength-' . $user_info->ID . '">Password Strength is...</p>
										</div>
									</div>
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">First Name</label>
											<input value="' . $user_info->firstname . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-firstname" type="text" placeholder="Your First Name" />
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Last Name</label>
											<input value="' . $user_info->lastname . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-lastname" type="text" placeholder="Your Last Name" />
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Cell Phone</label>
											<input value="' . $user_info->phonecell . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-cellphone" type="text" placeholder="Your Cell Phone" />
										</div>
									</div>
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Office Phone</label>
											<input value="' . $user_info->phoneoffice . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-officephone" type="text" placeholder="Users\'s Office Phone" />
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Email</label>
											<input value="' . $user_info->email . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-email" type="text" placeholder="Your Email Address" />
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Street Address</label>
											<input value="' . $user_info->contactstreetaddress . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-streetaddress" type="text" placeholder="Your Street Address" />
										</div>
									</div>
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">City</label>
											<input value="' . $user_info->contactcity . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-city" type="text" placeholder="Your City" />
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
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
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Zip Code</label>
											<input value="' . $user_info->contactzip . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-zip" type="text" placeholder="Your Zip Code" />
										</div>
									</div>
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">User Image #1</label>
											<div class="wpplugin-form-section-placeholder-image-wrapper">
												<img class="wpplugin-form-section-placeholder-image" id="wpplugin-form-section-placeholder-image-frontcover-actual" src="' . $user_info->userimage1 . '" />
											</div>
											<input value="' . $user_info->userimage1 . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-image1" type="text" placeholder="Enter URL or use button below" />
											<button class="wpplugin-form-section-placeholder-image-button" id="wpplugin-form-section-placeholder-image-button-frontcover">Choose Image...</button>
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">User Image #2</label>
											<div class="wpplugin-form-section-placeholder-image-wrapper">
												<img class="wpplugin-form-section-placeholder-image" id="wpplugin-form-section-placeholder-image-backcover-actual" src="' . $user_info->userimage2 . '" />
											</div>
											<input value="' . $user_info->userimage2 . '" class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-user-image2" type="text" placeholder="Enter URL or use button below" />
											<button class="wpplugin-form-section-placeholder-image-button" id="wpplugin-form-section-placeholder-image-button-backcover">Choose Image...</button>
										</div>
									</div>
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Edit This User Now!</label>
											<button class="wpplugin-form-section-submit-button wpplugin-form-section-submit-edits-button" data-wpuserid="' . $user_info->wpuserid . '" data-userid="' . $user_info->ID . '">Edit User</button>
											<div class="wpplugin-spinner"></div>
						 					<div class="wpplugin-response-div-actual-container">
						 						<p class="wpplugin-response-div-p" id="wpplugin-response-div-p-' . $user_info->ID . '"></p>
						 					</div>
										</div>
									</div>
								</div>
							</div>
						</div>						
					</div>';
				}

		}

		public function closing_html()
		{
		
			$this->closing_html_actual = '</div>
			</div>';


		}

		
		/**
		 * Stitches together and outputs all HTML elements on the page.
		 */
		public function stitch_ui_html()
		{

			$this->final_html = $this->opening_html_actual . $this->html_bulk . $this->closing_html_actual;
		}







	}
endif;
