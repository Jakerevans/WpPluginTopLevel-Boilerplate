<?php
/**
 * WPPlugin_Settings_Settings1_Tab Tab - class-admin-settings-libraries-tab-ui.php.
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPlugin_Settings_Settings1_Tab', false ) ) :

	/**
	 * WPPlugin_Settings_Settings1_Tab Class.
	 */
	class WPPlugin_Settings_Settings1_Tab {

		/**
		 * Class Constructor
		 */
		public function __construct() {
			require_once WPPLUGINTOPLEVEL_CLASS_DIR . 'class-admin-ui-template.php';
			require_once WPPLUGINTOPLEVEL_CLASS_DIR . 'class-submenu-two-tab-two-form.php';

			// Instantiate the class.
			$this->template = new WPPlugin_Admin_UI_Template();
			$this->form     = new WPPlugin_Settings1_Form();
			$this->output_open_admin_container();
			$this->output_tab_content();
			$this->output_close_admin_container();
			$this->output_admin_template_advert();
		}

		/**
		 * Opens the admin container for the tab
		 */
		private function output_open_admin_container() {
			$title    = 'Submenu 2 Tab 2';
			$icon_url = WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'settings.svg';

			echo $this->template->output_open_admin_container( $title, $icon_url );

		}

		/**
		 * Outputs actual tab contents
		 */
		private function output_tab_content() {
			echo $this->form->output_settings1_form();
		}

		/**
		 * Closes admin container.
		 */
		private function output_close_admin_container() {
			echo $this->template->output_close_admin_container();
		}

		/**
		 * Outputs advertisment area.
		 */
		private function output_admin_template_advert() {
			echo $this->template->output_template_advert();
		}


	}
endif;

// Instantiate the class.
$cm = new WPPlugin_Settings_Settings1_Tab();
