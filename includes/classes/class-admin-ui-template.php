<?php
/**
 * WPPlugin Admin UI Template Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPlugin_Admin_UI_Template', false ) ) :
	/**
	 * WPPlugin_Admin_Menu Class.
	 */
	class WPPlugin_Admin_UI_Template {


		/** Function that outputs the beginning of the admin container.
		 *
		 *  @param string $title - The string that contains the title for that tab.
		 *  @param string $iconurl - The string that contains the icon's URL for that tab.
		 */
		public static function output_open_admin_container( $title, $iconurl ) {
			return '<div class="wpplugin-admin-top-container">
				<p class="wpplugin-admin-top-title"><img class="wpplugin-admin-top-title-icon" src="' . $iconurl . '" />' . $title . '</p>
				<div class="wpplugin-admin-top-inner-container">';
		}

		/**
		 *  Closes the Admin Container.
		 */
		public static function output_close_admin_container() {
			return '</div></div>';
		}

		/**
		 *  Outputs the Bottom advertisment area that appears on every page.
		 */
		public static function output_template_advert() {
			return '<div class="wpplugin-admin-advert-container">
					<div id="wpplugin-admin-advert-flex-container">
					<div class="wpplugin-admin-advert-site-div">
						<div class="wpplugin-admin-advert-visit-me-title">For Everything Bell Media</div>
						<a target="_blank" class="wpplugin-admin-advert-visit-me-link" href="https://www.gobellmedia.com">
							<img src="' . WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'bellmediawebsite.png">
							GoBellMedia.com
						</a>
					</div>
					</div>
					<div id="wpplugin-facebook-link-div">
						<a href="https://www.facebook.com/BellLoveLocal/" target="_blank"><img height="34" style="border:0px;height:34px;" src="' . WPPLUGINTOPLEVEL_ROOT_IMG_URL . 'fbadvert.png" border="0" alt="Visit Bell Media on Facebook!"></a>
					</div>
					<div id="wpplugin-admin-advert-money-container">
						<p>And be sure to <a target="_blank" href="https://search.google.com/local/writereview?placeid=ChIJEyy2974biYgR488s3F3v_AM">leave a 5-star review of Bell Media!</a></p>
					</div>
				</div>';
		}

	}

endif;




