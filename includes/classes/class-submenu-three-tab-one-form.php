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

			

		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings1_form() {
			global $wpdb;

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="wpplugin-display-options-container">
							<p class="wpplugin-tab-intro-para">This is some intro text for the first tab of the 3rd Submenu Page</p>
							<div class="wpplugin-form-section-wrapper wpplugin-form-section-create-db-wrapper">
								<div class="wpplugin-table-creator-wrapper">
									<div class="wpplugin-form-section-fields-wrapper">
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Table Name</label>
											<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-form-title" type="text" placeholder="The name of the table" />
										</div>
										<div class="wpplugin-form-section-fields-indiv-wrapper">
											<label class="wpplugin-form-section-fields-label">Table Description</label>
											<textarea class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" type="text" placeholder="A Description of what this Table holds and what it\'s used for"></textarea>
										</div>
									</div>
								</div>
								<div class="wpplugin-form-section-fields-wrapper">
									<div class="wpplugin-form-section-fields-indiv-wrapper">
										<label class="wpplugin-form-section-fields-label">Column 1</label>
										<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-form-title" type="text" placeholder="Database Name of Column 1" />
									</div>
									<div class="wpplugin-form-section-fields-indiv-wrapper">
										<label class="wpplugin-form-section-fields-label">Column 1 Type</label>
										<select class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-select" aria-labelledby="label-type">
											<optgroup label="Numbers">
												<option>tinyint</option>
												<option>smallint</option>
												<option>mediumint</option>
												<option>int</option>
												<option selected="">bigint</option>
												<option>decimal</option>
												<option>float</option>
												<option>double</option>
											</optgroup>
											<optgroup label="Date and time">
												<option>date</option>
												<option>datetime</option>
												<option>timestamp</option>
												<option>time</option>
												<option>year</option>
											</optgroup>
											<optgroup label="Strings">
												<option>char</option>
												<option>varchar</option>
												<option>tinytext</option>
												<option>text</option>
												<option>mediumtext</option>
												<option>longtext</option>
												<option>json</option>
											</optgroup>
											<optgroup label="Lists">
												<option>enum</option>
												<option>set</option>
											</optgroup>
											<optgroup label="Binary">
												<option>bit</option>
												<option>binary</option>
												<option>varbinary</option>
												<option>tinyblob</option>
												<option>blob</option>
												<option>mediumblob</option>
												<option>longblob</option>
											</optgroup>
											<optgroup label="Geometry">
												<option>geometry</option>
												<option>point</option>
												<option>linestring</option>
												<option>polygon</option>
												<option>multipoint</option>
												<option>multilinestring</option>
												<option>multipolygon</option>
												<option>geometrycollection</option>
											</optgroup>
										</select>
									</div>
									<div class="wpplugin-form-section-fields-indiv-wrapper">
										<label class="wpplugin-form-section-fields-label">Display Name of Column</label>
										<input class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" id="wpplugin-form-authorfirst2" type="text" placeholder="Display Name of Column" />
									</div>
									<div class="wpplugin-form-section-fields-indiv-wrapper">
										<label class="wpplugin-form-section-fields-label">Column Description</label>
										<textarea class="wpplugin-form-section-fields-input wpplugin-form-section-fields-input-text" type="text" placeholder="A Description of what this Table holds and what it\'s used for"></textarea>
									</div>
								</div>
								<div class="wpplugin-form-section-create-extra-columns-wrapper">
									<div>

										<button>Add Another Column</button>
									</div>



								</div>
							</div>
						</div>';


			echo $string1;
		}
	}
endif;







