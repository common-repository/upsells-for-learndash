<?php
add_action( 'learndash-course-after', 'ldups_upsells_show_learndash_course' );

/**
 * Display upsell's on learndash page.
 */
function ldups_upsells_show_learndash_course() {
	ldups_upsells_related_course();
}

/**
 * Return course id after converting from product id.
 *
 * @return int $course id.
 */
function ldups_upsells_get_post_id() {
	global $post;

	// is learndash page.
	if ( get_post_type() === 'sfwd-courses' ) {
		return $post->ID;
	}
}

/**
 * Returns metabox selected course ids.
 *
 * @param int $page_course_id post id.
 * @return array course ids.
 */
function ldups_upsells_get_courses( $page_course_id ) {
	if ( metadata_exists( 'post', $page_course_id, 'ldups-upsells-related-course' ) ) {
		$related_course_ids = get_post_meta( $page_course_id, 'ldups-upsells-related-course', true );
	} else {
		$related_course_ids = array();
	}

	// return valid course id after matching from course id from metabox courses.
	if ( $related_course_ids ) {
		return $related_course_ids;
	} else {
		return null;
	}
}

/**
 * Display upsells course widget on learndash course page
 */
function ldups_upsells_related_course() {
	global $wpdb;
	$currency               = ''; // stores currency symbol.
	$currency               = function_exists( 'learndash_get_currency_symbol' ) ? learndash_get_currency_symbol() : '';
	$related_course_ids     = ldups_upsells_get_courses( ldups_upsells_get_post_id() );
	$upsell_setting_options = get_option( 'ldups_upsells' );
	$upsells_widget_heading = '';
	$course_enrolled_count  = '';

	if ( isset( $upsell_setting_options['upsells_heading'] ) ) {
		$upsells_widget_heading = $upsell_setting_options['upsells_heading'];
	} else {
		$upsells_widget_heading = 'Students also bought';
	}

	if ( isset( $upsell_setting_options['enrolled_count'] ) ) {
		$course_enrolled_count = $upsell_setting_options['enrolled_count'];
	} else {
		$course_enrolled_count = '';
	}

	if ( ! empty( $related_course_ids ) ) {
		if ( get_post_type() === 'sfwd-courses' ) {
			?>
			<!-- Main parent container that holds all upsell courses -->
			<div id="ldups-widget-container">
				<h2 id="ldups-widget-container-heading"><?php echo esc_html( $upsells_widget_heading ); ?></h2>
				<?php
				foreach ( $related_course_ids as $id ) {

					// gets course author name.
					$author_id    = get_post_field( 'post_author', $id );
					$display_name = get_the_author_meta( 'display_name', $author_id );

					// gets total enrolled user count.
					$enrolled_courses = learndash_get_users_for_course( $id, array(), true );
					$enrolled_count   = isset( $enrolled_courses->total_users ) ? $enrolled_courses->total_users : 0;

					// course thumbnail image.
					$course_image   = wp_get_attachment_image_src( get_post_thumbnail_id( $id ) );
					$course_img_src = ! empty( $course_image ) ? $course_image[0] : '#';

					// course price.
					$course_price    = empty( get_post_meta( $id, '_sfwd-courses' )[0]['sfwd-courses_course_price'] ) ? 0 : get_post_meta( $id, '_sfwd-courses' )[0]['sfwd-courses_course_price'];
					$currency_symbol = apply_filters( 'ldups_course_currency_change', $currency, $id );
					?>
					<!-- Container that holds course content -->
					<div class="ldups-course-list">
						<!-- Stores Course Image -->
						<div class="ldups-course-image-wrapper">
							<a href=<?php echo esc_url( get_the_guid( $id ) ); ?>>
								<img src="<?php echo esc_url( $course_img_src ); ?>" class="ldups-course-img"/>
							</a>
						</div>
						<div class="rightpartOflist">
							<!-- Holds title, name and hook below title -->
							<div class="ldups-course-list-section-one">
								<a href=<?php echo esc_url( get_the_guid( $id ) ); ?>>	
									<h4 class="ldups-course-title">
										<?php echo esc_html( get_the_title( $id ) ); ?>
									</h4>
								</a>
								<h5 class="ldups-course-author-name">
									<?php echo esc_html( $display_name ); ?>
									<span class="ldups-below-course-title">
										<?php do_action( 'ldups_below_course_title', $id ); ?>
									</span>
								</h5>
							</div>
							<!-- Holds enroller count price and hooks-->
							<div class="ldups-course-list-section-two">
								<div class="ldups-after-course-title">
									<?php do_action( 'ldups_after_course_title', $id ); ?>
								</div>
								<?php
								if ( 'yes' === $course_enrolled_count ) {
									?>
									<div class="ldups-course-enrolled">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"/></svg>
										<span class="ldups-course-enrolled-count"><?php echo intval( $enrolled_count ); ?></span>
									</div>
									<?php
								}
								?>
								<div class="ldups-course-price"><?php echo esc_html( $currency_symbol ); ?><?php echo esc_html( $course_price ); ?></div>
								<div class="ldups-after-course-price">
									<?php do_action( 'ldups_after_course_price', $id ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
