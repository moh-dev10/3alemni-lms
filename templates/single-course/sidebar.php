<?php
/**
 * 3alemni — Single Course Sticky Sidebar Component
 *
 * Displays course video/thumbnail, pricing, native Tutor LMS enrollment &
 * cart actions (with full security nonces), and course feature highlights.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();
if ( ! $course_id ) {
	return;
}

$user_id = get_current_user_id();

// Enrollment & access status
$is_enrolled = is_user_logged_in() && function_exists( 'tutor_utils' ) && tutor_utils()->is_enrolled( $course_id, $user_id );
$is_completed = ( $is_enrolled && function_exists( 'tutor_utils' ) ) ? tutor_utils()->is_completed_course( $course_id, $user_id ) : false;
$progress = ( $is_enrolled && function_exists( 'tutor_utils' ) ) ? (int) tutor_utils()->get_course_completed_percent( $course_id, $user_id ) : 0;

// Pricing
$is_public = function_exists( 'tutor_utils' ) ? tutor_utils()->is_public_course( $course_id ) : false;
$is_free   = function_exists( 'tutor_utils' ) ? ( tutor_utils()->is_course_free( $course_id ) || $is_public ) : false;
$price_info = function_exists( 'tutor_utils' ) ? tutor_utils()->get_raw_course_price( $course_id ) : null;

$regular_price = ! empty( $price_info->regular_price ) ? $price_info->regular_price : '';
$sale_price    = ! empty( $price_info->sale_price ) ? $price_info->sale_price : '';

// Course metadata highlights
$duration_str = function_exists( 'tutor_utils' ) ? tutor_utils()->get_course_duration_context( $course_id ) : '';
$level_raw    = get_post_meta( $course_id, '_tutor_course_level', true );
$level_labels = array(
	'all_levels'   => __( 'جميع المستويات', '3alemni' ),
	'beginner'     => __( 'مبتدئ', '3alemni' ),
	'intermediate' => __( 'متوسط', '3alemni' ),
	'expert'       => __( 'متقدم', '3alemni' ),
);
$level_label = isset( $level_labels[ $level_raw ] ) ? $level_labels[ $level_raw ] : __( 'جميع المستويات', '3alemni' );

$has_certificate = get_post_meta( $course_id, '_tutor_enable_certificate', true );

// First lesson link for continue learning
$start_lesson_url = '';
if ( $is_enrolled && function_exists( 'tutor_utils' ) ) {
	$first_lesson = tutor_utils()->get_course_first_lesson( $course_id );
	if ( $first_lesson ) {
		$start_lesson_url = get_permalink( $first_lesson );
	}
}
?>

<aside class="single-course-sidebar sticky top-6 z-10 w-full" aria-label="<?php esc_attr_e( 'صندوق التسجيل والاشتراك', '3alemni' ); ?>">

	<div class="overflow-hidden rounded-3xl border border-line bg-white shadow-card">

		<!-- 1. Video Intro / Featured Thumbnail -->
		<div class="relative aspect-video w-full overflow-hidden bg-slate-900">
			<?php if ( function_exists( 'tutor_utils' ) && tutor_utils()->has_video() ) : ?>
				<!-- Tutor LMS Native Video Player -->
				<div class="tutor-course-video-wrapper w-full h-full [&_iframe]:w-full [&_iframe]:h-full [&_video]:w-full [&_video]:h-full">
					<?php tutor_course_video(); ?>
				</div>
			<?php elseif ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'large',
					array(
						'class'   => 'h-full w-full object-cover',
						'loading' => 'eager',
					)
				);
				?>
			<?php else : ?>
				<div class="grid h-full w-full place-items-center bg-blue/10 text-blue">
					<span class="text-4xl font-bold">ع</span>
				</div>
			<?php endif; ?>
		</div>

		<!-- 2. Pricing & Enrollment CTA Block -->
		<div class="p-6 sm:p-7 space-y-5">

			<?php if ( $is_enrolled ) : ?>
				<!-- Authenticated Enrolled Student State -->
				<div class="space-y-4">
					<div class="flex items-center justify-between">
						<span class="inline-flex items-center gap-1.5 rounded-full bg-success-subtle border border-success/20 px-3 py-1 text-xs font-bold text-success">
							<svg class="size-3.5 fill-current" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
							</svg>
							<?php esc_html_e( 'أنت مسجّل في هذه الدورة', '3alemni' ); ?>
						</span>
						<span class="text-xs font-bold text-ink" dir="ltr"><?php echo esc_html( $progress ); ?>%</span>
					</div>

					<!-- Progress Bar -->
					<div class="h-2 w-full rounded-full bg-paper overflow-hidden border border-line/60">
						<div class="h-full bg-blue transition-all duration-500 rounded-full" style="width: <?php echo esc_attr( $progress ); ?>%"></div>
					</div>

					<!-- Continue Learning CTA -->
					<?php if ( ! empty( $start_lesson_url ) ) : ?>
						<a
							href="<?php echo esc_url( $start_lesson_url ); ?>"
							class="btn btn-primary w-full py-3.5 text-base font-bold shadow-sm justify-center gap-2 group"
						>
							<svg class="size-5 transition-transform group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<polygon points="5 3 19 12 5 21 5 3"/>
							</svg>
							<span>
								<?php echo ( $progress > 0 ) ? esc_html__( 'متابعة الدورة', '3alemni' ) : esc_html__( 'بدء التعلّم الآن', '3alemni' ); ?>
							</span>
						</a>
					<?php endif; ?>
				</div>

			<?php else : ?>
				<!-- Guest or Non-Enrolled Student State -->
				<div class="space-y-4">
					<!-- Price Display -->
					<div class="flex items-baseline gap-2.5">
						<?php if ( $is_free ) : ?>
							<span class="text-3xl font-black text-success tracking-tight">
								<?php esc_html_e( 'مجانـاً', '3alemni' ); ?>
							</span>
						<?php elseif ( function_exists( 'tutor_course_loop_price' ) ) : ?>
							<div class="text-3xl font-black text-ink tracking-tight">
								<?php tutor_course_loop_price(); ?>
							</div>
						<?php elseif ( ! empty( $regular_price ) ) : ?>
							<?php if ( ! empty( $sale_price ) && $sale_price < $regular_price ) : ?>
								<span class="text-3xl font-black text-ink tracking-tight"><?php echo esc_html( $sale_price ); ?></span>
								<span class="text-lg text-muted line-through"><?php echo esc_html( $regular_price ); ?></span>
							<?php else : ?>
								<span class="text-3xl font-black text-ink tracking-tight"><?php echo esc_html( $regular_price ); ?></span>
							<?php endif; ?>
						<?php endif; ?>
					</div>

					<!-- Native Tutor LMS Enrollment / Purchase Form (Preserves Nonces & WooCommerce/EDD) -->
					<div class="tutor-native-enrollment-wrap [&_.tutor-btn]:w-full [&_.tutor-btn]:justify-center [&_.tutor-btn]:py-3.5 [&_.tutor-btn]:rounded-xl [&_.tutor-btn]:font-bold [&_.tutor-btn]:text-base">
						<?php
						if ( function_exists( 'tutor_course_enroll_form' ) ) {
							tutor_course_enroll_form();
						} else {
							do_action( 'tutor_course/single/entry_box' );
						}
						?>
					</div>

					<!-- Money-back guarantee notice -->
					<div class="flex items-center justify-center gap-2 text-center text-xs text-muted pt-1">
						<svg class="size-4 text-success shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
						</svg>
						<span><?php esc_html_e( 'تسجيل آمن ومحمي 100% مع ضمان الجودة', '3alemni' ); ?></span>
					</div>
				</div>
			<?php endif; ?>

			<!-- 3. Course Features Checklist -->
			<div class="border-t border-line/60 pt-5 space-y-3">
				<h4 class="text-xs font-bold uppercase tracking-wider text-muted">
					<?php esc_html_e( 'تتضمّن هذه الدورة:', '3alemni' ); ?>
				</h4>

				<ul class="space-y-2.5 text-xs sm:text-sm text-ink-secondary">
					<?php if ( ! empty( $duration_str ) ) : ?>
						<li class="flex items-center gap-3">
							<svg class="size-4 text-blue shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<circle cx="12" cy="12" r="10"/>
								<polyline points="12 6 12 12 16 14"/>
							</svg>
							<span><?php echo esc_html( sprintf( __( 'المدة: %s', '3alemni' ), $duration_str ) ); ?></span>
						</li>
					<?php endif; ?>

					<li class="flex items-center gap-3">
						<svg class="size-4 text-blue shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
						</svg>
						<span><?php echo esc_html( sprintf( __( 'المستوى: %s', '3alemni' ), $level_label ) ); ?></span>
					</li>

					<li class="flex items-center gap-3">
						<svg class="size-4 text-blue shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<circle cx="12" cy="12" r="10"/>
							<path d="m4.93 4.93 4.24 4.24"/>
							<path d="m14.83 9.17 4.24-4.24"/>
							<path d="m14.83 14.83 4.24 4.24"/>
							<path d="m9.17 14.83-4.24 4.24"/>
						</svg>
						<span><?php esc_html_e( 'وصول كامل مدى الحياة', '3alemni' ); ?></span>
					</li>

					<li class="flex items-center gap-3">
						<svg class="size-4 text-blue shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
							<line x1="12" y1="18" x2="12.01" y2="18"/>
						</svg>
						<span><?php esc_html_e( 'الوصول من الهاتف والحاسوب', '3alemni' ); ?></span>
					</li>

					<?php if ( 'yes' === $has_certificate || true ) : ?>
						<li class="flex items-center gap-3">
							<svg class="size-4 text-blue shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<circle cx="12" cy="8" r="7"/>
								<polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
							</svg>
							<span><?php esc_html_e( 'شهادة إتمام معتمدة', '3alemni' ); ?></span>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			<!-- 4. Share Link -->
			<div class="border-t border-line/60 pt-4">
				<button
					type="button"
					onclick="if (navigator.share) { navigator.share({title: document.title, url: window.location.href}); } else { navigator.clipboard.writeText(window.location.href); alert('<?php echo esc_js( __( 'تم نسخ رابط الدورة بنجاح!', '3alemni' ) ); ?>'); }"
					class="w-full flex items-center justify-center gap-2 rounded-xl border border-line bg-paper-subtle py-2.5 text-xs font-semibold text-ink-secondary hover:bg-white hover:text-blue hover:border-blue/30 transition-colors"
				>
					<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<circle cx="18" cy="5" r="3"/>
						<circle cx="6" cy="12" r="3"/>
						<circle cx="18" cy="19" r="3"/>
						<line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
						<line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
					</svg>
					<span><?php esc_html_e( 'مشاركة الدورة', '3alemni' ); ?></span>
				</button>
			</div>

		</div>

	</div>

</aside>
