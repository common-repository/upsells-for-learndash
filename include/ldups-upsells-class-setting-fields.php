<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if access directly.
}

if ( ( class_exists( 'LearnDash_Settings_Section' ) ) && ( ! class_exists( 'LearnDash_Upsells_Settings_Fields' ) ) ) {
	/**
	 * Class LearnDash Settings Section for Custom Labels Metabox.
	 */
	class LearnDash_Upsells_Settings_Fields extends LearnDash_Settings_Section {

		/**
		 * Protected constructor for class
		 */
		protected function __construct() {
			$this->settings_page_id = 'ldups_upsell_settings';

			// This is the 'option_name' key used in the wp_options table.
			$this->setting_option_key = 'ldups_upsells';

			// This is the HTML form field prefix used.
			$this->setting_field_prefix = 'ldups_upsells';

			// Used within the Settings API to uniquely identify this section.
			$this->settings_section_key = 'upsells_custom_fields';

			// Section label/header.
			$this->settings_section_label = esc_html__( 'UpSells', 'ldups-upsells' );

			$this->settings_section_description = esc_html__( 'UpSells For LearnDash Settings', 'ldups-upsells' );

			parent::__construct();
		}

		/**
		 * Initialize the metabox settings values.
		 */
		public function load_settings_values() {
			parent::load_settings_values();

			if ( false === $this->setting_option_values ) {
				$this->setting_option_values = get_option( 'learndash_custom_label_settings' );
			}

			if ( ( isset( $_GET['action'] ) ) && ( 'ld_reset_settings' === $_GET['action'] ) && ( isset( $_GET['page'] ) ) && ( $_GET['page'] === $this->settings_page_id ) ) {
				if ( ( isset( $_GET['ld_wpnonce'] ) ) && ( ! empty( $_GET['ld_wpnonce'] ) ) ) {
					if ( wp_verify_nonce( $_GET['ld_wpnonce'], get_current_user_id() . '-' . $this->setting_option_key ) ) {
						if ( ! empty( $this->setting_option_values ) ) {
							foreach ( $this->setting_option_values as $key => $val ) {
								$this->setting_option_values[ $key ] = '';
							}
							$this->save_settings_values();
						}

						$reload_url = remove_query_arg( array( 'action', 'ld_wpnonce' ) );
						learndash_safe_redirect( $reload_url );
					}
				}
			}
		}

		/**
		 * Initialize the metabox settings fields.
		 */
		public function load_settings_fields() {
			$this->setting_option_fields = array(

				// upsells widget heading.
				'upsells_heading'       => array(
					'name'      => 'upsells_heading',
					'type'      => 'text',
					'default'   => 'Students also bought',
					'label'     => esc_html__( 'UpSells Widget Title', 'ldups-upsells' ),
					'help_text' => esc_html__( 'Use this setting to give a suitable heading to your UpSell widget.', 'ldups-upsells' ),
					'value'     => '' !== $this->setting_option_values['upsells_heading'] ? $this->setting_option_values['upsells_heading'] : 'Students also bought',
				),

				// select plugin field.
				'plugin_type'           => array(
					'name'      => 'plugin_type',
					'label'     => esc_html__( 'Choose UpSell Configuration', 'ldups-upsells' ),
					'help_text' => esc_html__( 'Free plugin allows you to show the upsell widget on the learndash course page if you wish to show upsell widget on woocommerce product page or Easy Digital Download (EDD) download page please check out our pro plugin.', 'ldups-upsells' ),
					'type'      => 'radio',
					'options'   => array(
						'woocom'     => array(
							'label' => esc_html__( 'WooCommerce + LearnDash', 'ldups-upsells' ),
						),
						'edd'        => array(
							'label' => esc_html__( 'Easy Digital Downloads (EDD) + LearnDash', 'ldups-upsells' ),
						),
						'standalone' => array(
							'label' => esc_html__( 'LearnDash', 'ldups-upsells' ),
						),
					),
				),

				// enroller count switch.
				'enrolled_count'        => array(
					'name'      => 'enrolled_count',
					'type'      => 'checkbox-switch',
					'label'     => esc_html__( 'Display enroll count for the course', 'ldups_upells' ),
					'help_text' => esc_html__( 'Shows a count of users (who enrolled for that course) next to each course in the UpSell widget.', 'ldups_upells' ),
					'value'     => $this->setting_option_values['enrolled_count'],
					'options'   => array(
						'yes' => '',
					),
				),

				// Show More button.
				'showmore_enabled'      => array(
					'name'                => 'showmore_enabled',
					'type'                => 'checkbox-switch',
					'label'               => esc_html__( "Enable 'Show More' button", 'ldups-upsells' ),
					'help_text'           => esc_html__( "If you have multiple courses that you would like to UpSell then enabling this setting will allow you to show the UpSells courses list in 2 parts.  In the First part the visitor will see the list of related courses by default and the second list is shown after the visitor clicks on 'Show more'. Basically, allowing you to list as many courses for UpSells without taking a lot of space. If you disable this setting, then the UpSell widget will show all the courses in a single list", 'ldups-upsells' ),
					'value'               => $this->setting_option_values['showmore_enabled'],
					'options'             => array(
						'yes' => '',
					),
					'child_section_state' => ( 'yes' === $this->setting_option_values['showmore_enabled'] ) ? 'open' : 'closed',
				),

				// widget position.
				'widget_position'       => array(
					'name'      => 'widget_position',
					'type'      => 'select',
					'label'     => esc_html__( 'UpSell Widget Display', 'ldups-upsells' ),
					'help_text' => esc_html__( 'This setting helps you select the way in which you want to show your UpSells on the course page. The default setting is "After Course Description" . This will show UpSells widget  just below the course description. If you want to show UpSells at a different position on the course page, then you can choose "Using Shortcode" option. You can copy the shortcode and place it anywhere on the LearnDash course page.', 'ldups-upsells' ),
					'value'     => $this->setting_option_values['widget_position'],
					'options'   => array(
						'aftercontent' => esc_html__( 'After Course Description', 'ldups_upells' ),
						'shortcode'    => esc_html__( 'Using Shortcode [ldups_upsells_show_courses]', 'ldups_upells' ),
					),
				),

				'upsells_wocom_section' => array(
					'name'  => 'upsells_wocom_section',
					'type'  => 'html',
					'label' => esc_html__( "WooCommerce UpSell's setting", 'ldups-upsells' ),
				),

				// woocom display upsell.
				'wocom_upsells_option'  => array(
					'name'      => 'wocom_upsells_option',
					'label'     => esc_html__( 'Show UpSells on WooCommerce Product page', 'ldups-upsells' ),
					'help_text' => esc_html__( 'Enabling this setting will set the UpSells for the corressponding WooCommerce product page that is associated with your LearnDash course and display the UpSells courses list on the WooCommerce product page.', 'ldups-upsells' ),
					'type'      => 'checkbox-switch',
					'value'     => $this->setting_option_values['wocom_upsells_option'],
					'options'   => array(
						'yes' => '',
					),
				),

				'upsells_edd_section'   => array(
					'name'  => 'upsells_edd_section',
					'type'  => 'html',
					'label' => esc_html__( "Easy Digital Downloads (EDD) UpSell's Setting", 'ldups-upsells' ),
				),

				// edd display upsell.
				'edd_upsells_enable'    => array(
					'name'      => 'edd_upsells_enable',
					'type'      => 'checkbox-switch',
					'label'     => esc_html__( 'Show UpSells on EDD product page', 'ldups_upells' ),
					'help_text' => esc_html__( 'Enabling this setting will set the UpSells  for the corressponding EDD product page that is associated with your LearnDash course and display the UpSells courses list on the EDD product page.', 'ldups-upsells' ),
					'value'     => $this->setting_option_values['edd_upsells_enable'],
					'options'   => array(
						'yes' => '',
					),
				),
			);

			/**
			 * Filters custom labels setting fields.
			 *
			 * @param array $setting_option_fields Associative array of Setting field details like name,type,label,value.
			 */
			$this->setting_option_fields = apply_filters( 'learndash_custom_label_fields', $this->setting_option_fields );

			$this->setting_option_fields = apply_filters( 'learndash_settings_fields', $this->setting_option_fields, $this->settings_section_key );

			parent::load_settings_fields();
		}

		/**
		 * Save settings
		 *
		 * @param array  $new_values         Array of section fields values.
		 * @param array  $old_values         Array of old values.
		 * @param string $setting_option_key Section option key should match $this->setting_option_key.
		 */
		public function section_pre_update_option( $new_values = '', $old_values = '', $setting_option_key = '' ) {
			if ( $setting_option_key === $this->setting_option_key ) {
				$new_values = parent::section_pre_update_option( $new_values, $old_values, $setting_option_key );

				// cheks the index of all the fields and update the default value.
				if ( $new_values !== $old_values ) {

					// sets the default option for enroller count.
					if ( ! isset( $new_values['enrolled_count'] ) ) {
						$new_values['enrolled_count'] = '';
					}

					// set the default upsell heading.
					if ( ! isset( $new_values['upsells_heading'] ) ) {
						$new_values['upsells_heading'] = 'Students also bought';
					}
				}
			}
			return $new_values;
		}
	}
}
add_action(
	'learndash_settings_sections_init',
	function () {
		LearnDash_Upsells_Settings_Fields::add_section_instance();
	}
);
