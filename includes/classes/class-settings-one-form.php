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

			/*
				Below is a default contact form using default class names, ids, and custom data attributes, with associated default styling found in the "BEGIN CSS FOR COMMON FORM FILL" section of the wpplugintoplevel-admin-ui.scss file. The custom data attribute "data-dbname" is supposed to hold the exact name of the corresponding database column in the database, prefixed with a description of the kind of "object" we're working with. For example, if I were creating an App that needed to save Student data, I would probably call that database table 'studentdata' and each column in that database would begin with 'student'. So, I would replace all instances below of data-dbname="contact with data-dbname="student. I would also replace each instance of id="wpplugin-form-contact with id="wpplugin-form-student. If I were creating an app that needed to track customer info, and not students, I would replace all instances below of data-dbname="contact with data-dbname="customer. I would also replace each instance of id="wpplugin-form-contact with id="wpplugin-form-customer.
			*/
			$contact_form_html = '
				<div class="booktrackerwpplugin-form-section-wrapper">
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Book Title</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-title" data-dbname="title" type="text" placeholder="The title of the book" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Author 1 First Name</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-authorfirst1" data-dbname="authorfirst1" type="text" placeholder="1st Author\'s First Name" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Author 1 Last Name</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-authorlast1" data-dbname="authorlast1" type="text" placeholder="1st Author\'s Last Name" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Author 2 First Name</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-authorfirst2" data-dbname="authorfirst2" type="text" placeholder="2nd Author\'s First Name" />
						</div>
					</div>
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Author 2 Last Name</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-authorlast2" data-dbname="authorlast2" type="text" placeholder="2nd Author\'s Last Name" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Author 3 First Name</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-authorfirst3" data-dbname="authorfirst3" type="text" placeholder="3rd Author\'s First Name" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Author 3 Last Name</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-authorlast3" data-dbname="authorlast3" type="text" placeholder="3rd Author\'s Last Name" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Pages</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-pages" data-dbname="pages" type="number" placeholder="# of total pages in book" />
						</div>
					</div>
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">ISBN 10</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-isbn10" data-dbname="isbn10" type="text" placeholder="The ISBN 10 Number" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">ISBN 13</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-isbn13" data-dbname="isbn13" type="text" placeholder="The ISBN 13 Number" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Publisher</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-publisher" data-dbname="publisher" type="text" placeholder="The Book\'s Publisher" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Publication Date</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-firstpubdate" data-dbname="originalpubdate" type="date" placeholder="First Publications Date" />
						</div>
					</div>
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Original Publication Date</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-originalpubdate" data-dbname="firstpubdate" type="date" placeholder="" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Genre</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-genre" data-dbname="genre" type="text" placeholder="The Book\'s Genre" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Subject</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-subject" data-dbname="subject" type="text" placeholder="The Subject of the Book" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Category</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-category" data-dbname="category" type="text" placeholder="The Category of the Book" />
						</div>
					</div>
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Finished?</label>
							<select class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-select" id="booktrackerwpplugin-form-finished" data-dbname="finished">
								<option selected default disabled>Have you finished this book?...</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Date Finished</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-finisheddate" data-dbname="finisheddate" type="date" value="" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Format</label>
							<select class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-select" id="booktrackerwpplugin-form-format" data-dbname="format">
								<option selected default disabled>Make a Selection...</option>
								<option value="Hardcover">Hardcover</option>
								<option value="Paperback">Paperback</option>
								<option value="Mass-MarketPaperback">Mass-Market Paperback</option>
								<option value="LibraryBinding">Library Binding</option>
								<option value="SpiralBinding">Spiral Binding</option>
								<option value="Kindle">Kindle</option>
								<option value="ePUB">ePUB</option>
								<option value="ePUB">eReader</option>
								<option value="PDF">PDF</option>
								<option value="iBooks">iBooks</option>
								<option value="Audiobook,unabridged">Audiobook, unabridged</option>
								<option value="Audiobook,abridged">Audiobook, abridged</option>
							</select>
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Series</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-series" data-dbname="series" type="text" placeholder="The Series this book belongs to" />
						</div>
					</div>
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Number in Series</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-numinseries" data-dbname="numinseries" type="number" placeholder="Which number in the Series?" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Short Description</label>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-shortdescription" data-dbname="shortdescription" type="text" placeholder="Enter a short Description here" />
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Editorial Review</label>
							<textarea class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-editorialnotes" data-dbname="editorialnotes" placeholder="Enter any Editorial Reviews here"></textarea>
							<span class="booktrackerwpplugin-remaining-characters-class" id="booktrackerwpplugin-remaining-characters-id-editorialreview"></span>
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">General Notes</label>
							<textarea class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-generalnotes" data-dbname="generalnotes" placeholder="Enter any general notes about the title here"></textarea>
						</div>
					</div>
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Front Cover Image</label>
							<div class="booktrackerwpplugin-form-section-placeholder-image-wrapper">
								<img class="booktrackerwpplugin-form-section-placeholder-image" id="booktrackerwpplugin-form-section-placeholder-image-frontcover-actual" src="' . BOOKTRACKER_ROOT_IMG_URL . 'book-cover-placeholder.png" />
							</div>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-maincoverimage" data-dbname="maincoverimage" type="text" placeholder="Enter URL or use button below" />
							<button class="booktrackerwpplugin-form-section-placeholder-image-button" id="booktrackerwpplugin-form-section-placeholder-image-button-frontcover">Choose Image...</button>
						</div>
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Back Cover Image</label>
							<div class="booktrackerwpplugin-form-section-placeholder-image-wrapper">
								<img class="booktrackerwpplugin-form-section-placeholder-image" id="booktrackerwpplugin-form-section-placeholder-image-backcover-actual" src="' . BOOKTRACKER_ROOT_IMG_URL . 'book-cover-placeholder.png" />
							</div>
							<input class="booktrackerwpplugin-form-section-fields-input booktrackerwpplugin-form-section-fields-input-text" id="booktrackerwpplugin-form-backcoverimage" data-dbname="backcoverimage" type="text" placeholder="Enter URL or use button below" />
							<button class="booktrackerwpplugin-form-section-placeholder-image-button" id="booktrackerwpplugin-form-section-placeholder-image-button-backcover">Choose Image...</button>
						</div>
					</div>
					<div class="booktrackerwpplugin-form-section-fields-wrapper">
						<div class="booktrackerwpplugin-form-section-fields-indiv-wrapper">
							<label class="booktrackerwpplugin-form-section-fields-label">Add This Book Now!</label>
							<button class="booktrackerwpplugin-form-section-submit-button" id="booktrackerwpplugin-form-section-add-book-button">Add Book</button>
							<div class="booktrackerwpplugin-spinner"></div>
		 					<div class="booktrackerwpplugin-response-div-actual-container"></div>
						</div>
					</div>
				</div>';


			$string1 = '
				<div id="wpplugin-display-options-container">
					<p class="wpplugin-tab-intro-para">This is some intro text for Settings 1</p>
					<div class="wpplugin-form-wrapper">
						' . $contact_form_html . '

					


					</div>
				</div>';

			echo $string1;
		}
	}
endif;
