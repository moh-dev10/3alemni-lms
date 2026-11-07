<?php
/**
 * 3alemni — Single Course Reviews Component
 *
 * Displays real rating breakdowns, authentic student reviews,
 * and preserves native Tutor LMS review submission logic.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();
if ( ! $course_id ) {
	return;
}

$rating = function_exists( 'tutor_utils' ) ? tutor_utils()->get_course_rating( $course_id ) : null;
$rating_avg   = ( ! empty( $rating->rating_avg ) && (float) $rating->rating_avg > 0 )
	? (float) $rating->rating_avg
	: 0;
$rating_count = ! empty( $rating->rating_count ) ? (int) $rating->rating_count : 0;

// Fetch reviews
$reviews = function_exists( 'tutor_utils' ) ? tutor_utils()->get_course_reviews( $course_id ) : array();

// Tally star count percentages (only from real data)
$star_counts = array(
	5 => 0,
	4 => 0,
	3 => 0,
	2 => 0,
	1 => 0,
);

if ( ! empty( $reviews ) && is_iterable( $reviews ) ) {
	foreach ( $reviews as $rev ) {
		$stars = isset( $rev->rating ) ? (int) round( (float) $rev->rating ) : 0;
		if ( isset( $star_counts[ $stars ] ) ) {
			$star_counts[ $stars ]++;
		}
	}
}

// User enrollment check for submitting reviews
$user_id = get_current_user_id();
$is_enrolled = is_user_logged_in() && function_exists( 'tutor_utils' ) && tutor_utils()->is_enrolled( $course_id, $user_id );
?>

<section class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-xs" aria-labelledby="reviews-heading">

	<div class="mb-6 flex flex-wrap items-center justify-between gap-4 border-b border-line/60 pb-5">
		<div class="flex items-center gap-2.5">
			<div class="grid size-9 place-items-center rounded-xl bg-paper text-ink">
				<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
				</svg>
			</div>
			<h2 id="reviews-heading" class="text-lg sm:text-xl font-bold text-ink">
				<?php esc_html_e( 'تقييمات الطلاب', '3alemni' ); ?>
			</h2>
		</div>

		<?php if ( $rating_count > 0 ) : ?>
			<span class="text-xs sm:text-sm font-medium text-muted">
				<?php echo esc_html( sprintf( _n( 'تقييم واحد', '%s تقييمات', $rating_count, '3alemni' ), number_format_i18n( $rating_count ) ) ); ?>
			</span>
		<?php endif; ?>
	</div>

	<?php if ( $rating_count > 0 ) : ?>
		<!-- Rating Breakdown & Summary -->
		<div class="mb-8 grid grid-cols-1 md:grid-cols-12 gap-6 items-center rounded-xl bg-paper-subtle p-5 sm:p-6 border border-line/60">
			<!-- Overall Score -->
			<div class="md:col-span-4 text-center md:border-l md:border-line/60 md:pl-6">
				<div class="text-4xl sm:text-5xl font-black text-ink tracking-tight font-sans">
					<?php echo esc_html( number_format( $rating_avg, 1 ) ); ?>
				</div>
				<div class="mt-2 flex items-center justify-center gap-1 text-amber-500">
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
						<svg class="size-4.5 <?php echo ( $i <= round( $rating_avg ) ) ? 'fill-current' : 'fill-none stroke-current stroke-1 text-line'; ?>" viewBox="0 0 20 20" aria-hidden="true">
							<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
						</svg>
					<?php endfor; ?>
				</div>
				<p class="mt-2 text-xs text-muted">
					<?php echo esc_html( sprintf( __( 'بناءً على %s تقييم موثّق', '3alemni' ), number_format_i18n( $rating_count ) ) ); ?>
				</p>
			</div>

			<!-- Star Bars -->
			<div class="md:col-span-8 space-y-2">
				<?php for ( $star = 5; $star >= 1; $star-- ) : ?>
					<?php
					$count = $star_counts[ $star ];
					$pct   = ( $rating_count > 0 ) ? round( ( $count / $rating_count ) * 100 ) : 0;
					?>
					<div class="flex items-center gap-3 text-xs">
						<span class="w-12 text-ink-secondary font-medium shrink-0 flex items-center gap-1">
							<?php echo esc_html( $star ); ?>
							<svg class="size-3 fill-amber-500 text-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
						</span>
						<div class="h-2 flex-1 rounded-full bg-paper overflow-hidden border border-line/40">
							<div class="h-full bg-amber-500 transition-all duration-500" style="width: <?php echo esc_attr( $pct ); ?>%"></div>
						</div>
						<span class="w-10 text-muted text-left shrink-0 font-medium" dir="ltr">
							<?php echo esc_html( $pct ); ?>%
						</span>
					</div>
				<?php endfor; ?>
			</div>
		</div>

		<!-- Reviews Feed -->
		<?php if ( ! empty( $reviews ) && is_iterable( $reviews ) ) : ?>
			<div class="space-y-4 divide-y divide-line/50">
				<?php foreach ( $reviews as $rev ) : ?>
					<?php
					$rev_user = get_userdata( $rev->user_id );
					$user_name = $rev_user ? $rev_user->display_name : __( 'طالب في علّمني', '3alemni' );
					$rev_avatar = get_avatar_url( $rev->user_id, array( 'size' => 48 ) );
					$rev_score = isset( $rev->rating ) ? (float) $rev->rating : 5;
					$rev_comment = isset( $rev->comment_content ) ? $rev->comment_content : '';
					$rev_date = isset( $rev->comment_date ) ? date_i18n( 'j F Y', strtotime( $rev->comment_date ) ) : '';
					?>
					<div class="pt-4 first:pt-0 space-y-2.5">
						<div class="flex items-center justify-between gap-3">
							<div class="flex items-center gap-3">
								<img
									src="<?php echo esc_url( $rev_avatar ); ?>"
									alt="<?php echo esc_attr( $user_name ); ?>"
									class="size-9 rounded-full object-cover border border-line/60"
									loading="lazy"
								/>
								<div>
									<h4 class="text-sm font-bold text-ink"><?php echo esc_html( $user_name ); ?></h4>
									<div class="flex items-center gap-1 text-amber-500 mt-0.5">
										<?php for ( $s = 1; $s <= 5; $s++ ) : ?>
											<svg class="size-3.5 <?php echo ( $s <= round( $rev_score ) ) ? 'fill-current' : 'fill-none stroke-current stroke-1 text-line'; ?>" viewBox="0 0 20 20">
												<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
											</svg>
										<?php endfor; ?>
									</div>
								</div>
							</div>

							<?php if ( ! empty( $rev_date ) ) : ?>
								<span class="text-xs text-muted"><?php echo esc_html( $rev_date ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $rev_comment ) ) : ?>
							<p class="text-xs sm:text-sm leading-relaxed text-ink-secondary pr-12">
								<?php echo esc_html( $rev_comment ); ?>
							</p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	<?php else : ?>
		<!-- Clean Empty State (No fabricated reviews) -->
		<div class="rounded-xl border border-dashed border-line bg-paper-subtle p-6 text-center">
			<div class="mx-auto mb-3 grid size-12 place-items-center rounded-xl bg-blue/5 text-blue">
				<svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
				</svg>
			</div>
			<p class="text-sm font-semibold text-ink">
				<?php esc_html_e( 'لا توجد تقييمات لهذه الدورة بعد.', '3alemni' ); ?>
			</p>
			<p class="mt-1 text-xs text-muted">
				<?php esc_html_e( 'كن أول من يقيّم الدورة بعد إتمام دروسها.', '3alemni' ); ?>
			</p>
		</div>
	<?php endif; ?>

	<!-- Native Review Submission Hook (Preserving Tutor LMS native form & nonces) -->
	<?php if ( $is_enrolled ) : ?>
		<div class="mt-6 pt-5 border-t border-line/60">
			<?php do_action( 'tutor_course/single/reviews' ); ?>
		</div>
	<?php endif; ?>

</section>
