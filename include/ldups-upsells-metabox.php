<?php
/**
 * Get upsell course name and id in metabox.
 *
 * @param object $post .
 */
function ldups_upsells_course_metabox_callback( $post ) {
	global $wpdb;
	$current_course_id   = $post->ID; // current post id.
	$related_course_ids  = array(); // All linked course id's available.
	$selected_course_ids = array(); // All selected courses id after checking from all linked courses available.

	// Gets all learndash course ids.
	$learndash_course_ids = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE `meta_key` LIKE '_sfwd-courses'" );

	if ( ! empty( $learndash_course_ids ) ) {

		// iterates over all learndash course id.
		foreach ( $learndash_course_ids as $id ) {

			// if found course id is published then add to all course id.
			if ( 'publish' === get_post_status( $id ) ) {
				if ( intval( $id ) !== intval( $current_course_id ) ) {
					array_push( $related_course_ids, intval( $id ) );
				}
			}
		}
	}

	// selected course ids that was selected from metabox.
	if ( metadata_exists( 'post', $current_course_id, 'ldups-upsells-related-course' ) ) {
		$selected_course_array = get_post_meta( $current_course_id, 'ldups-upsells-related-course', true );
	} else {
		$selected_course_array = array();
	}

	// selected metabox course value.
	if ( ! empty( $selected_course_array ) ) {
		foreach ( $selected_course_array as $id ) {
			if ( 'publish' === get_post_status( $id ) ) {
				if ( in_array( $id, $related_course_ids, true ) ) {
					array_push( $selected_course_ids, intval( $id ) );
				}
			}
		}
	}
	?>

	<!-- Display selectbox in metabox -->
	<select class="ldups-learndash-select2" name="ldups-ld-related-course[]" multiple="multiple">
		<?php
		foreach ( $related_course_ids as $id ) {
			if ( in_array( $id, $selected_course_ids, true ) ) {
				?>
				<option selected="selected" value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?> (<?php echo esc_html( $id ); ?>)</option>
		<?php } else { ?>
				<option value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?> (<?php echo esc_html( $id ); ?>)</option>
				<?php
		}
		}
		?>
	</select>
	<?php
}

/**
 * Add upsell course metabox on every course page.
 */
function ldups_upsells_metaboxes_callback() {
	add_meta_box( 'ldups-upsells-related-course', __( 'UpSells Widget', 'ldups-upsells' ), 'ldups_upsells_course_metabox_callback', array( 'sfwd-courses' ), 'advanced', 'high' );
}
add_action( 'add_meta_boxes', 'ldups_upsells_metaboxes_callback' );

/**
 * Save value in related-course meta field that is selected from the metabox.
 */
function ldups_upsells_update_metafield() {
	$course_id                = get_the_ID(); // current course id.
	$ldups_related_course_ids = array(); // all course ids.

	// Take the current page post editor type skip updating to metafield when updating with elementor.
	if ( isset( $_REQUEST['action'] ) ) {

		if ( 'elementor_ajax' !== $_REQUEST['action'] ) {

			// if there some selected value in metabox.
			if ( ! empty( $_POST['ldups-ld-related-course'] ) ) {
				$ldups_related_course_ids = map_deep( $_POST['ldups-ld-related-course'], 'intval' );
				update_post_meta( $course_id, 'ldups-upsells-related-course', $ldups_related_course_ids );
			} else {
				update_post_meta( $course_id, 'ldups-upsells-related-course', '' );
			}
		}
	}
}
add_action( 'save_post_sfwd-courses', 'ldups_upsells_update_metafield' );

/**
 * Update rating notice.
 */
function ldups_upsells_ajax_update_notice() {
	global $current_user;
	if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldups-upsells' ) ) {
			wp_die( esc_html__( 'Permission Denied.', 'ldups-upsells' ) );
		}
		update_user_meta( $current_user->ID, 'ldups_rate_notices', 'rated' );
		echo esc_url( network_admin_url() );
	}
	die();
}
add_action( 'wp_ajax_ldups_update', 'ldups_upsells_ajax_update_notice' );
add_action( 'wp_ajax_nopriv_ldups_update', 'ldups_upsells_ajax_update_notice' );

/**
 * Rating notice widget.
 * Save the date to display notice after 10 days.
 */
function ldups_upsells_plugin_notice() {
	global $current_user;

	$today_date = strtotime( 'now' ); // gets the cuttent timestamp.

	// Add 10 days to the current timestamp.
	if ( ! get_user_meta( $current_user->ID, 'ldups_notices_time' ) ) {
		$after_10_day = strtotime( '+10 day', $today_date );
		update_user_meta( $current_user->ID, 'ldups_notices_time', $after_10_day );
	}

	// gets the option of user rating status and week status.
	$rate_status = get_user_meta( $current_user->ID, 'ldups_rate_notices', true );
	$next_w_date = get_user_meta( $current_user->ID, 'ldups_notices_time', true );

	// show if user has not rated the plugin and it has been 1 week.
	if ( 'rated' !== $rate_status && $today_date > $next_w_date ) {
		?>
		<div class="notice notice-warning is-dismissible">
			<p><span><?php esc_html_e( "Awesome, you've been using", 'ldups-upsells' ); ?></span><span><?php echo '<strong> UpSells for learndash </strong>'; ?><span><?php esc_html_e( 'for more than 1 week', 'ldups-upsells' ); ?></span></p>
			<p><?php esc_html_e( 'If you like our plugin Would you like to rate our plugin at WordPress.org ?', 'ldups_upsells' ); ?></p>
			<span><a href="https://wordpress.org/plugins/upsells-for-learndash/#reviews" target="_blank"><?php esc_html_e( "Yes, I'd like to rate it!", 'ldups-upsells' ); ?></a></span>&nbsp; - &nbsp;<span><a class="ldups_hide_rate" href="#"><?php esc_html_e( 'I already did!', 'ldups-upsells' ); ?></a></span>
			<br/><br/>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'ldups_upsells_plugin_notice' );
