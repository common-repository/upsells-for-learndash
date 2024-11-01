<?php
/**
 * Plugin Name: UpSells For LearnDash
 * Description: UpSells for LearnDash allows you to create a widget on LearnDash course page that enables you to display other related courses of your choice. It enables you to  increase visibility of your higher end course offerings to your customers and thus driving more sales.
 * Plugin URI:  https://www.saffiretech.com/upsells-for-learndash/
 * Author URI:  https://www.saffiretech.com
 * Author:      SaffireTech
 * Text Domain: ldups-upsells
 * Domain Path: /languages
 * Stable Tag: 1.0.6
 * Requires at least: 5.3
 * Tested up to: 6.4.3
 * Requires PHP: 7.4
 * LD Requires at least: 3.6.0.3
 * LD tested up to: 4.10.3
 * License:     GPLv3
 * License URI: URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Version:     1.0.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if accessed directly.
}

/**
 * Check the installation of pro version.
 *
 * @return bool
 */
function ldups_upsells_check_pro_version() {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( is_plugin_active( 'upsells-for-learndash-pro/upsells-for-learndash-pro.php' ) ) {
		return true;
	} else {
		return false;
	}
}


add_action( 'plugins_loaded', 'ldups_upsells_free_plugin_install' );

/**
 * Display notice if pro plugin found.
 */
function ldups_upsells_free_plugin_install() {
	// if pro plugin found deactivate free plugin.
	if ( ldups_upsells_check_pro_version() ) {
		deactivate_plugins( plugin_basename( __FILE__ ), true );
		if ( defined( 'LDUPS_PRO_PLUGIN' ) ) {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			add_action( 'admin_notices', 'ldups_upsells_install_free_admin_notice' );
		}
	}
}


/**
 * Add message if paid version is installed.
 */
function ldups_upsells_install_free_admin_notice() {    ?>
	<div class="notice notice-error is-dismissible">
		<p><?php esc_html_e( 'Free version deactivated', 'ldups-upsells' ); ?></p>
	</div>
	<?php
}


add_action( 'plugins_loaded', 'ldups_upsells_free_load_settings_page' );

/**
 * Loads upsells settings files.
 */
function ldups_upsells_free_load_settings_page() {
	if ( ! ldups_upsells_check_pro_version() ) {
		require_once dirname( __FILE__ ) . '/include/ldups-upsells-class-setting-page.php';
		require_once dirname( __FILE__ ) . '/include/ldups-upsells-class-setting-fields.php';
	}
}


add_action( 'init', 'ldups_upsells_free_load_css_js_files' );

/**
 * Loads required js & css file.
 */
function ldups_upsells_free_load_css_js_files() {
	if ( ! ldups_upsells_check_pro_version() ) {
		require_once dirname( __FILE__ ) . '/include/ldups-upsells-metabox.php'; // metabox display.
		require_once dirname( __FILE__ ) . '/include/ldups-upsells-widget.php'; // upsell widget display.
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'ldups-upsells-course-css', plugins_url( 'assets/css/ldups-upsells-courses.css', __FILE__ ), array(), '1.0.0' );
		wp_enqueue_style( 'ldups-upsells-select2-css', plugins_url( 'assets/css/select2.min.css', __FILE__ ), array(), '1.1.0' );
		wp_enqueue_style( 'ldups-upsells-slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), '1.1.0' );
		wp_enqueue_style( 'ldups-upsells-group-css', esc_url( 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' ), array(), '1.0.0' );
		wp_enqueue_script( 'ldups-upsells-course-js', plugins_url( 'assets/js/ldups-upsells-courses.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'ldups-upsells-slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'ldups_sweet_alert_script', plugins_url( 'assets/js/sweetalert2.all.min.js', __FILE__ ), array(), '10.10.1', false );
		load_plugin_textdomain( 'ldups-upsells', false, basename( dirname( __FILE__ ) ) . '/languages/' );
		wp_localize_script(
			'ldups-upsells-course-js',
			'ldups_data',
			array(
				'ajaxurl'                                  => admin_url( 'admin-ajax.php' ),
				'nonce'                                    => wp_create_nonce( 'ldups-upsells' ),
				// Free to Pro Upgrade alert translation.
				'ldups_free_to_pro_alert_title'            => __( 'Pro Field Alert !', 'ldups-upsells' ),
				'ldups_free_to_pro_alert_messgae'          => __( 'This field is available with pro version of UpSells For LearnDash', 'ldups-upsells' ),
				'ldups_free_to_pro_upgrade'                => __( 'Upgrade Now!', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_line_one'         => __( 'Looking for this cool feature? Go Pro!', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_line_two'         => __( 'Go with our premium version to unlock the following features:', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_listing_one_bold' => __( 'WooCommerce / EDD Compatibility: ', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_listing_one'      => __( 'Now, show UpSells widgets on WooCommerce / EDD product page.', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_listing_two_bold' => __( 'Flexible Widget Placement: ', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_listing_two'      => __( 'Effortlessly integrate the UpSells widget wherever you like, post-course description or via shortcode.', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_listing_three_bold' => __( 'Enhanced Visibility: ', 'ldups-upsells' ),
				'ldups_free_to_pro_popup_listing_three'    => __( 'Showcase more than 3 UpSells at a time using the “Show More” button  without slowing down the page, ensuring no opportunity for selling is missed.', 'ldups-upsells' ),
			)
		);
		wp_enqueue_script( 'ldups-upsells-customscript-js', plugins_url( 'assets/js/custom-script.js', __FILE__ ), array( 'jquery' ), '1.1.0', false );
	}
}


add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ldups_upsells_free_action_links_callback', 10, 1 );

/**
 * Settings link on plugin page.
 *
 * @param array $links links Plugin links on plugins.php.
 * @return array
 */
function ldups_upsells_free_action_links_callback( $links ) {
	if ( ! ldups_upsells_check_pro_version() ) {
		$settinglinks = array(
			'<a href="' . admin_url( 'admin.php?page=ldups_upsell_settings' ) . '">' . __( 'Setting', 'ldups-upsells' ) . '</a>',
			'<a class="rpwfr-setting-upgrade" href="https://www.saffiretech.com/upsells-for-learndash/?utm_source=wp_plugin&utm_medium=plugins_archive&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=ldups" target="_blank">' . __( 'UpGrade to Pro!', 'ldups-upsells' ) . '</a>',
		);
		return array_merge( $settinglinks, $links );
	} else {
		return $links;
	}
}

/**
 * Including select2.
 *
 * @return void
 */
function ldups_include_selecet2() {

	if ( 'sfwd-courses' === get_post_type() ) {
		wp_enqueue_style( 'ldups-sweetalert-css', plugins_url( 'assets/css/sweetalert2.min.css', __FILE__ ), array(), '1.0.0' );
		wp_enqueue_script( 'ldups-select2-js', plugins_url( 'assets/js/select2.min.js', __FILE__ ), array( 'jquery' ), '1.1.0', false );
		wp_enqueue_script( 'ldups-backend-js', plugins_url( 'assets/js/ldups-backend.js', __FILE__ ), array( 'jquery' ), '1.1.0', false );
	}
}

add_action( 'admin_enqueue_scripts', 'ldups_include_selecet2' );

// HPOS Compatibility.
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);
