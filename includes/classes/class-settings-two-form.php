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

		public $SITETHING_table    = '';
		public $SITETHINGdbresults = array();
		public $create_opening_html = '';
		public $create_search_ui_html = '';
		public $create_search_ui_results_html = '';
		public $create_individual_SITETHINGs_html = '';
		public $create_pagination_html = '';
		public $create_closing_html = '';
		public $final_echoed_html = '';
		public $final_grabbed_params = '';
		public $total_SITETHINGs_count = 0;
		public $pagination_display_limit = 40;
		public $pagination_place = 0;
		public $search_THING1 = '';
		public $search_THING2 = '';
		public $search_THING3 = '';
		public $search_THING4 = '';
		public $search_THING5 = '';
		public $search_THING6 = '';
		public $active_search = false;
		public $set_params_array = array();
		public $export_button_html = '';
		public $export = '';
		public $query_part_for_export = '';


		/**
		 * Class Constructor
		 */
		public function __construct() {

			$this->grab_url_params();

			$this->query_db();

			$this->create_opening_html();

			$this->create_search_ui();

			$this->create_individual_SITETHING_html();

			$this->create_pagination_html();

			$this->create_closing_html();

		}

		/**
		 * Function to grab URL params, if any exist.
		 */
		public function grab_url_params()
		{
			// Grab all the things we could be searching for from the URL Params.
			$this->search_THING1 = $_GET['THING1'];
			$this->search_THING2 = $_GET['THING2'];
			$this->search_THING3 = $_GET['THING3'];
			$this->search_THING4 = $_GET['THING4'];
			$this->search_THING5 = $_GET['THING5'];
			$this->search_THING6 = $_GET['THING6'];

			// Get where we're at with the Pagination currently.
			if ( isset( $_GET['pn'] ) ) {
				$this->pagination_place = $_GET['pn'];
			}

			// Add to the active Parameters array and set the search flag to true.
			if ( 'null' !== $this->search_THING1 && '' !== $this->search_THING1 && null !== $this->search_THING1 ) {
				$this->set_params_array['SITETHINGTHING1'] = $this->search_THING1;
				$this->active_search = true;
			}

			// Add to the active Parameters array and set the search flag to true.
			if ( 'null' !== $this->search_THING2 && '' !== $this->search_THING2 && null !== $this->search_THING2 ) {
				$this->set_params_array['SITETHINGTHING2'] = $this->search_THING2;
				$this->active_search = true;
			}

			// Add to the active Parameters array and set the search flag to true.
			if ( 'null' !== $this->search_THING3 && '' !== $this->search_THING3 && null !== $this->search_THING3 ) {
				$this->set_params_array['SITETHINGTHING3'] = $this->search_THING3;
				$this->active_search = true;
			}

			// Add to the active Parameters array and set the search flag to true.
			if ( 'null' !== $this->search_THING4 && '' !== $this->search_THING4 && null !== $this->search_THING4 ) {
				$this->set_params_array['SITETHINGTHING4'] = $this->search_THING4;
				$this->active_search = true;
			}

			// Add to the active Parameters array and set the search flag to true.
			if ( 'null' !== $this->search_THING5 && '' !== $this->search_THING5 && null !== $this->search_THING5 ) {
				$this->set_params_array['SITETHINGTHING5'] = $this->search_THING5;
				$this->active_search = true;
			}

			// Add to the active Parameters array and set the search flag to true.
			if ( 'null' !== $this->search_THING6 && '' !== $this->search_THING6 && null !== $this->search_THING6 ) {
				$this->set_params_array['SITETHINGTHING6'] = $this->search_THING6;
				$this->active_search = true;
			}
		}

		/**
		 * Function to house all logic required to query the database depending on URL params, if any exist.
		 */
		public function query_db()
		{

			global $wpdb;
			$this->SITETHING_table = $wpdb->prefix . 'wpplugintoplevel_SITETHING';

			// If we have an active search in play...
			if ( $this->active_search ) {

				// This If-Else and the get_results line directly after it is if we want to do an exclusive search - a serach that returns a smaller, more specific amount of results.
				$query_part = '';
				$count_query_part = '';

				// If there's only 1 Search Parameter in play, this If statement executes, to make sure we're not appending additional stuff to the DB Query.
				if ( 1 === sizeof($this->set_params_array) ) {
					foreach ( $this->set_params_array as $params_search_key => $params_search_value ) {

						// If we need a Wildcard Search for something - if so, we need to do a 'Like' instead of =, else, do a strict = comparison in the else block below.
						if ( 'SITETHINGTHINGWENEEDWILDCARDSEARCHFOR' === $params_search_key ) {
							$query_part = "SELECT * FROM $this->SITETHING_table WHERE " . $params_search_key . " LIKE '%" . $params_search_value . "%'";
							$count_query_part = " WHERE " . $params_search_key . " LIKE '%" . $params_search_value . "%'";
						} else {
							$query_part = "SELECT * FROM $this->SITETHING_table WHERE " . $params_search_key . " = '" . $params_search_value . "'";
							$count_query_part = " WHERE " . $params_search_key . " = '" . $params_search_value . "'";
						}

					}
				} else {
					// All this below executes if there are more searches in play than just 1.
					$counter = 0;
					foreach ( $this->set_params_array as $params_search_key => $params_search_value ) {

						// If this is our first time in the loop, begin the new Query correctly.
						if ( 0 === $counter ) {
							
							// If we need a Wildcard Search for something - if so, we need to do a 'Like' instead of =, else, do a strict = comparison in the else block below.
							if ( 'SITETHINGTHINGWENEEDWILDCARDSEARCHFOR' === $params_search_key ) {
								$query_part = "SELECT * FROM $this->SITETHING_table WHERE " . $params_search_key . " LIKE '%" . $params_search_value . "%'";
								$count_query_part = " WHERE " . $params_search_key . " LIKE '%" . $params_search_value . "%'";
							} else {
								$query_part = "SELECT * FROM $this->SITETHING_table WHERE " . $params_search_key . " = '" . $params_search_value . "'";
								$count_query_part = " WHERE " . $params_search_key . " = '" . $params_search_value . "'";
							}
							$counter++;
						} else {

							// Continue building the Query by appending 'AND' Operators.

							// If we need a Wildcard Search for something - if so, we need to do a 'Like' instead of =, else, do a strict = comparison in the else block below.
							if ( 'SITETHINGTHINGWENEEDWILDCARDSEARCHFOR' === $params_search_key ) {
								$query_part = $query_part . " AND " . $params_search_key . " LIKE '%" . $params_search_value . "%'";
								$count_query_part = $count_query_part . " AND " . $params_search_key . " LIKE '%" . $params_search_value . "%'";
							} else {
								$query_part = $query_part . " AND " . $params_search_key . " = '" . $params_search_value . "'";
								$count_query_part = $count_query_part . " AND " . $params_search_key . " = '" . $params_search_value . "'";
							}

						}
					}
				}

				$this->query_part_for_export = $query_part;
				$query_part . "LIMIT $this->pagination_place, $this->pagination_display_limit";

				$this->SITETHING_final_search_results = $wpdb->get_results($query_part . "ORDER BY SITETHINGTHING5 ASC LIMIT $this->pagination_place, $this->pagination_display_limit");

				$count_query = "select count(*) from $this->SITETHING_table" . $count_query_part;
    			$this->total_SITETHINGs_count = $wpdb->get_var( $count_query );

/*

				// This block of code and the associated if statements is if we want to do an inclusive search - a search that returns a larger amount of results accounting for all search terms.

				$this->SITETHING_search_THING1_results = $wpdb->get_results("SELECT * FROM $this->SITETHING_table WHERE SITETHINGTHING1 = '" . $this->search_THING1 . "' LIMIT $this->pagination_place, $this->pagination_display_limit");
				$this->SITETHING_search_THING2_results = $wpdb->get_results("SELECT * FROM $this->SITETHING_table WHERE SITETHINGTHING2 = '" . $this->search_THING2 . "' LIMIT $this->pagination_place, $this->pagination_display_limit");
				$this->SITETHING_search_THING3_results = $wpdb->get_results("SELECT * FROM $this->SITETHING_table WHERE SITETHINGTHING3 = '" . $this->search_THING3 . "' LIMIT $this->pagination_place, $this->pagination_display_limit");
				$this->SITETHING_search_THING4_results = $wpdb->get_results("SELECT * FROM $this->SITETHING_table WHERE SITETHINGTHING4 = '" . $this->search_THING4 . "' LIMIT $this->pagination_place, $this->pagination_display_limit");
				$this->SITETHING_search_THING5_results = $wpdb->get_results("SELECT * FROM $this->SITETHING_table WHERE SITETHINGTHING5 = '" . $this->search_THING5 . "' LIMIT $this->pagination_place, $this->pagination_display_limit");
				$this->SITETHING_final_search_results = array();
				foreach ($this->SITETHING_search_THING1_results as $SITETHING) {
					if (!in_array($SITETHING, $this->SITETHING_final_search_results)) {
						array_push($this->SITETHING_final_search_results, $SITETHING);
					}
				}
				foreach ($this->SITETHING_search_THING2_results as $SITETHING) {
					if (!in_array($SITETHING, $this->SITETHING_final_search_results)) {
						array_push($this->SITETHING_final_search_results, $SITETHING);
					}
				}
				foreach ($this->SITETHING_search_THING3_results as $SITETHING) {
					if (!in_array($SITETHING, $this->SITETHING_final_search_results)) {
						array_push($this->SITETHING_final_search_results, $SITETHING);
					}
				}
				foreach ($this->SITETHING_search_THING4_results as $SITETHING) {
					if (!in_array($SITETHING, $this->SITETHING_final_search_results)) {
						array_push($this->SITETHING_final_search_results, $SITETHING);
					}
				}
				foreach ($this->SITETHING_search_THING5_results as $SITETHING) {
					if (!in_array($SITETHING, $this->SITETHING_final_search_results)) {
						array_push($this->SITETHING_final_search_results, $SITETHING);
					}
				}
*/
				$this->SITETHINGdbresults = $this->SITETHING_final_search_results;

			} else {
				$this->SITETHINGdbresults = $wpdb->get_results("SELECT * FROM $this->SITETHING_table ORDER BY LTRIM( SITETHINGTHING5 ) ASC LIMIT $this->pagination_place, $this->pagination_display_limit");

				$count_query = "select count(*) from $this->SITETHING_table";
    			$this->total_SITETHINGs_count = $wpdb->get_var( $count_query );
			}
		}

		/**
		 * Creates opening HTML elements on the page. Can be used to intro stuff, or whatever needed really, just add HTML in that $string1 variable.
		 */
		public function create_opening_html()
		{
			global $wpdb;

			$string1 = '';


			$this->create_opening_html = $string1;
		}

		/**
		 * Creates the Search UI.
		 */
		public function create_search_ui()
		{

			global $wpdb;

			// All of this code until we get down to $string1 is for getting entries from individual tables where we record unique entries, and are usually the things we're needing to search for. These DB results will populate the Drop-Down/search menus that give us the options of things to search by. The things we can search by are stored in their own tables so we don't have to pull the entire main table every time this page loads.

			$SITETHING_THING1_table = $wpdb->prefix . 'wpplugintoplevel_SITETHING_THING1';
			$SITETHING_THING1_in_db = $wpdb->get_results("SELECT DISTINCT(SITETHINGTHING1) as SITETHINGTHING1 FROM $SITETHING_THING1_table ORDER BY LTRIM( SITETHINGTHING1 ) ASC");
			// Build the default Select option.
			$THING1_html = '<option value="" default disabled selected>Select A THING1...</option>';
			// Loop through all results and build the actual Select options.
			foreach ($SITETHING_THING1_in_db as $THING1) {
				$THING1_html = $THING1_html . "<option>" . ucwords( strtolower( $THING1->SITETHINGTHING1 ) ) . "</option>";
			}

			$SITETHING_THING2_table = $wpdb->prefix . 'wpplugintoplevel_SITETHING_THING2';
			$SITETHING_THING2_in_db = $wpdb->get_results("SELECT DISTINCT(SITETHINGTHING2) as SITETHINGTHING2 FROM $SITETHING_THING2_table ORDER BY LTRIM( SITETHINGTHING2 ) ASC");
			// Build the default Select option.
			$THING2_html = '<option value="" default disabled selected>Select A THING2...</option>';
			// Loop through all results and build the actual Select options.
			foreach ($SITETHING_THING2_in_db as $THING2) {
				$THING2_html = $THING2_html . "<option>" . $THING2->SITETHINGTHING2 . "</option>";
			}

			$SITETHING_THING3_table = $wpdb->prefix . 'wpplugintoplevel_SITETHING_THING3';
			$SITETHING_THING3_in_db = $wpdb->get_results("SELECT DISTINCT(SITETHINGTHING3) as SITETHINGTHING3 FROM $SITETHING_THING3_table ORDER BY LTRIM( SITETHINGTHING3 ) ASC");
			// Build the default Select option.
			$THING3_html = '<option value="" default disabled selected>Select A THING3...</option>';
			// Loop through all results and build the actual Select options.
			foreach ($SITETHING_THING3_in_db as $THING3) {
				$THING3_html = $THING3_html . "<option>" . $THING3->SITETHINGTHING3 . "</option>";
			}

			$SITETHING_THING4_table = $wpdb->prefix . 'wpplugintoplevel_SITETHING_THING4';
			$SITETHING_THING4_in_db = $wpdb->get_results("SELECT DISTINCT(SITETHINGTHING4) as SITETHINGTHING4 FROM $SITETHING_THING4_table ORDER BY LTRIM( SITETHINGTHING4 ) ASC");
			// Build the default Select option.
			$THING4_html = '<option value="" default disabled selected>Select A THING4...</option>';
			// Loop through all results and build the actual Select options.
			foreach ($SITETHING_THING4_in_db as $THING4) {
				$THING4_html = $THING4_html . "<option>" . $THING4->SITETHINGTHING4 . "</option>";
			}

			$SITETHING_THING5_table = $wpdb->prefix . 'wpplugintoplevel_SITETHING_THING5';
			$SITETHING_THING5_in_db = $wpdb->get_results("SELECT DISTINCT(SITETHINGTHING5) as SITETHINGTHING5 FROM $SITETHING_THING5_table ORDER BY LTRIM( SITETHINGTHING5 ) ASC");
			// Build the default Select option.
			$THING5_html = '<option value="" default disabled selected>Select A Company THING5...</option>';
			// Loop through all results and build the actual Select options.
			foreach ( $SITETHING_THING5_in_db as $THING5) {
				$THING5_html = $THING5_html . "<option>" . $THING5->SITETHINGTHING5 . "</option>";
			}

			// Now start building the actual HTML for the search area.
			$string1 = '<div class="wpplugintoplevel-display-search-ui-top-container">
							<p class="wpplugintoplevel-tab-intro-para">Select your search options below</p>
							<div class="wpplugintoplevel-display-search-ui-inner-container">
								<div class="wpplugintoplevel-display-search-ui-search-fields-container">
									<div class="wpplugintoplevel-form-section-fields-wrapper">
										<div class="wpplugintoplevel-form-section-fields-indiv-wrapper wpplugintoplevel-search-field">
											<label class="wpplugintoplevel-form-section-fields-label">THING1</label>
											<select id="wpplugintoplevel-search-THING1">' .	$THING1_html	. '</select>
										</div>
										<div class="wpplugintoplevel-form-section-fields-indiv-wrapper wpplugintoplevel-search-field">
											<label class="wpplugintoplevel-form-section-fields-label">State</label>
											<select id="wpplugintoplevel-search-states" THING5="search_state">
												<option value="" default disabled selected>Select A State...</option>
												<option value="AL">Alabama</option>
												<option value="AK">Alaska</option>
												<option value="AZ">Arizona</option>
												<option value="AR">Arkansas</option>
												<option value="CA">California</option>
												<option value="CO">Colorado</option>
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="DC">District of Columbia</option>
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
										<div class="wpplugintoplevel-form-section-fields-indiv-wrapper wpplugintoplevel-search-field">
											<label class="wpplugintoplevel-form-section-fields-label">THING2</label>
											<select id="wpplugintoplevel-search-THING2">' .	$THING2_html	. '</select>
										</div>
									</div>
									<div class="wpplugintoplevel-form-section-fields-wrapper">
										<div class="wpplugintoplevel-form-section-fields-indiv-wrapper wpplugintoplevel-search-field">
											<label class="wpplugintoplevel-form-section-fields-label">THING3</label>
											<select id="wpplugintoplevel-search-THING3">' .	$THING3_html	. '</select>
										</div>
										<div class="wpplugintoplevel-form-section-fields-indiv-wrapper wpplugintoplevel-search-field">
											<label class="wpplugintoplevel-form-section-fields-label">THING4</label>
											<select id="wpplugintoplevel-search-THING4">' .	$THING4_html	. '</select>
										</div>
										<div class="wpplugintoplevel-form-section-fields-indiv-wrapper wpplugintoplevel-search-field">
											<label class="wpplugintoplevel-form-section-fields-label">THING5</label>
											<select id="wpplugintoplevel-search-THING5">' .	$THING5_html	. '</select>
										</div>
									</div>

								</div>
								<div class="wpplugintoplevel-display-search-ui-search-buttons-container">
									<button id="wpplugintoplevel-search-button" class="wpplugintoplevel-search-ui-buttons" data-pn="' . $this->pagination_place . '">Search</button>
									<button id="wpplugintoplevel-reset-search-fields" class="wpplugintoplevel-search-ui-buttons">Reset Search Fields</button>
								</div>
							</div>
						</div>
						';

			$search_results_SITETHINGs = $this->SITETHING_final_search_results;
			$this->create_search_ui_html = $string1 . $string2;
		}




















		/**
		 * Creates the HTML for each individual entry from the DB.
		 */
		public function create_individual_SITETHING_html()
		{
			global $wpdb;

			$string1 = '';
			foreach ( $this->SITETHINGdbresults as $key => $value ) {

				$string1 = $string1 . '
					<div class="wpplugintoplevel-SITETHING-udpate-container wpplugintoplevel-all-SITETHING" >
						
						<button class="accordion wpplugintoplevel-SITETHING-update-container-accordion-heading">
							' .  $value->SITETHINGname  . '
						</button>
						<div class="wpplugintoplevel-SITETHING-update-info-container" style="display: none;" data-open="false">
						</div>						
				</div>';
			}

			$this->create_individual_SITETHINGs_html = $string1;
		}








		/**
		 * Creates the Pagination HTML at the bottom.
		 */
		public function create_pagination_html()
		{
			global $wpdb;

			// Builds the Drop-Down for choosing a page to jump to.
			$pagination_option_html = '';
			$loop_control_whole_numbers = floor( $this->total_SITETHING_count / $this->pagination_display_limit );
			if ( $this->total_SITETHING_count < $this->pagination_display_limit ) {
				$pagination_option_html = '<option value="1">Page 1</option>';
			} else {
				for ($i=0; $i < $loop_control_whole_numbers; $i++) { 
					$pagination_option_html = $pagination_option_html  . '<option value="' . ( $i + 1 ) . '">Page ' . ( $i + 1 ) . '</option>';
				}
			}

			// Actual output HTML.
			$string1 = '
				<div class="wpplugintoplevel-pagination-top-container">
					<div class="wpplugintoplevel-pagination-inner-container">

						<div id="wpplugintoplevel-pagecontrols">
							<div class="wpplugintoplevel-prevnextbuttons" id="wpplugintoplevel-previouspage" data-currentpn="' . $this->pagination_place . '" data-pagelimit="' . $this->pagination_display_limit . '">Previous</div>
							<div>
								<select class="wpplugintoplevel-prevnextbuttons" id="wpplugintoplevel-pageselect" data-currentpn="' . $this->pagination_place . '" data-pagelimit="' . $this->pagination_display_limit . '">
									' . $pagination_option_html . '
								</select>
							</div>
							<div class="wpplugintoplevel-prevnextbuttons" id="wpplugintoplevel-nextpage" data-currentpn="' . $this->pagination_place . '" data-pagelimit="' . $this->pagination_display_limit . '">Next</div>
						</div>
					</div>
				</div>
			';

			$this->create_pagination_html = $string1;
		}

		/**
		 * Creates closing HTML elements on the page. Just add HTML in that $string1 variable.
		 */
		public function create_closing_html()
		{
			global $wpdb;

			$string1 = '';


			$this->create_closing_html = $string1;
		}



		/**
		 * Stitches together and outputs all HTML elements on the page.
		 */
		public function stitch_ui_html()
		{

			$this->final_echoed_html = $this->create_opening_html . $this->create_search_ui_html . $this->create_individual_vendors_html . $this->create_pagination_html . $this->create_closing_html;
		}







	}
endif;
