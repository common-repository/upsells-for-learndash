<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( class_exists( 'LearnDash_Settings_Page' ) ) && ( ! class_exists( 'LearnDash_Upsells_Settings_Page' ) ) ) {
	/**
	 * Class LearnDash Settings Page Advanced.
	 */
	class LearnDash_Upsells_Settings_Page extends LearnDash_Settings_Page {

		/**
		 * Public constructor for class
		 */
		public function __construct() {

			$this->parent_menu_page_url  = 'admin.php?page=learndash_lms_settings';
			$this->menu_page_capability  = LEARNDASH_ADMIN_CAPABILITY_CHECK;
			$this->settings_page_id      = 'ldups_upsell_settings';
			$this->settings_page_title   = esc_html__( 'UpSells', 'ldups-upsells' );
			$this->settings_tab_priority = 120;

			add_action( 'learndash_settings_page_init', array( $this, 'ldups_upsells_settings_page_init' ), 10, 1 );

			parent::__construct();
		}

		/**
		 * Settings page init.
		 *
		 * Called from `learndash_settings_page_init` action.
		 *
		 * @param string $settings_page_id   Settings Page ID.
		 */
		public function ldups_upsells_settings_page_init( $settings_page_id ) {
			$this->show_submit_meta      = true;
			$this->show_quick_links_meta = false;
			$this->settings_columns      = 2;
		}
	}
}
add_action(
	'learndash_settings_pages_init',
	function() {
		LearnDash_Upsells_Settings_Page::add_page_instance();
	}
);


add_action(
	'in_admin_footer',
	'ldups_footer_upgrade_to_pro_banner'
);
function ldups_footer_upgrade_to_pro_banner() {
	// echo home_url( $_SERVER['REQUEST_URI'] );
	if ( isset( $_GET['page'] ) && $_GET['page'] === 'ldups_upsell_settings' ) {
		echo '<div class="ldups-footer-upgrade">
		<div class="sft-logo">
		<a href="' . esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ) . '">
		<img src="' . esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ) . '">
		</a>
		</div>
		<div class="ldups-upgrade-col1">
		<h3>' . esc_html__( 'Unlock Advanced Features For UpSells for LearnDash', 'ldups-upsells' ) . '</h3>
		<div class="ldups-moneyback-badge">
		<div>
		<a href="' . esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ) . '">
		<img src="' . esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ) . '">
		</a>
		</div>
		<div class="ldups-cashback-text">
		<h3>' . esc_html__( '100% Risk-Free Money Back Guarantee!', 'ldups-upsells' ) . '</h3>
		<p>' . esc_html__( 'We guarantee you a complete refund for new purchases or renewals if a request is made within 15 Days of purchase.', 'ldups-upsells' ) . '</p>
		<input type="button" value="Upgrade To Pro!" class="btn" onclick="window.open(\'https://www.saffiretech.com/frequently-bought-together-for-learndash/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=ldups\', \'_blank\');" />
		</div>
		</div>

		</div>
		<div class="ldups-upgrade-col">
		<ul>
		<li><i class="fa fa-check" aria-hidden="true"></i><strong>' . esc_html__( 'WooCommerce / EDD Compatibility: ', 'ldups-upsells' ) . '</strong>' . esc_html__( 'Now, show UpSells widgets on WooCommerce / EDD product page.' ) . '</li><li><i class="fa fa-check" aria-hidden="true"></i><strong>' . esc_html__( 'Flexible Widget Placement: ', 'ldups-upsells' ) . '</strong>' . esc_html__( ': Effortlessly integrate the UpSells widget wherever you like, post-course description or via shortcode.', 'ldups-upsells' ) . '</li><li><i class="fa fa-check" aria-hidden="true"></i><strong>' . esc_html__( 'Enhanced Visibility: ', 'ldups-upsells' ) . '</strong>' . esc_html__( 'Showcase more than 3 UpSells at a time using the “Show More” button  without slowing down the page, ensuring no opportunity for selling is missed.', 'ldups-upsells' ) . '</li>
		</ul>
		</div>
		</div> ';
	}
}


