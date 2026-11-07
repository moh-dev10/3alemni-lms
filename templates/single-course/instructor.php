<?php
/**
 * 3alemni — Single Course Instructor Profile Component
 *
 * Displays real instructor information, avatar, bio, job title,
 * and verified Tutor LMS platform statistics.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();
if ( ! $course_id ) {
	return;
}

$author_id = (int) get_post_field( 'post_author', $course_id );
$instructor = get_userdata( $author_id );

if ( ! $instructor ) {
	return;
}

$instructor_name = $instructor->display_name ?: $instructor->user_login;
$avatar_url = get_avatar_url( $author_id, array( 'size' => 128 ) );

// Job title & bio
$job_title = get_user_meta( $author_id, '_tutor_profile_job_title', true );
$bio = get_user_meta( $author_id, '_tutor_profile_bio', true );
if ( empty( $bio ) ) {
	$bio = get_the_author_meta( 'description', $author_id );
}

// Real instructor stats
$courses_count = 0;
$students_count = 0;
$instructor_rating_avg = null;
$instructor_rating_count = 0;

if ( function_exists( 'tutor_utils' ) ) {
	$instructor_courses = tutor_utils()->get_courses_by_instructor( $author_id );
	if ( is_array( $instructor_courses ) ) {
		$courses_count = count( $instructor_courses );
	}

	$students_count = (int) tutor_utils()->get_total_students_by_instructor( $author_id );

	$rating = tutor_utils()->get_instructor_rating( $author_id );
	if ( ! empty( $rating->rating_avg ) && (float) $rating->rating_avg > 0 ) {
		$instructor_rating_avg = number_format( (float) $rating->rating_avg, 1 );
		$instructor_rating_count = ! empty( $rating->rating_count ) ? (int) $rating->rating_count : 0;
	}
}

// Profile link
$profile_url = function_exists( 'tutor_utils' ) ? tutor_utils()->profile_url( $author_id ) : get_author_posts_url( $author_id );
?>

<section class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-xs" aria-labelledby="instructor-heading">

	<div class="mb-5 flex items-center gap-2.5 border-b border-line/60 pb-4">
		<div class="grid size-9 place-items-center rounded-xl bg-paper text-ink">
			<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
				<circle cx="12" cy="7" r="4"/>
			</svg>
		</div>
		<h2 id="instructor-heading" class="text-lg sm:text-xl font-bold text-ink">
			<?php esc_html_e( 'عن المدرّب', '3alemni' ); ?>
		</h2>
	</div>

	<div class="flex flex-col sm:flex-row items-start gap-5 sm:gap-6">
		<!-- Avatar -->
		<a href="<?php echo esc_url( $profile_url ); ?>" class="group shrink-0" aria-label="<?php echo esc_attr( $instructor_name ); ?>">
			<?php if ( ! empty( $avatar_url ) ) : ?>
				<img
					src="<?php echo esc_url( $avatar_url ); ?>"
					alt="<?php echo esc_attr( $instructor_name ); ?>"
					class="size-20 sm:size-24 rounded-2xl border border-line object-cover shadow-xs transition-transform duration-300 group-hover:scale-105"
					loading="lazy"
				/>
			<?php else : ?>
				<div class="grid size-20 sm:size-24 place-items-center rounded-2xl bg-blue/10 text-2xl font-bold text-blue border border-blue/20">
					<?php echo esc_html( mb_substr( $instructor_name, 0, 1 ) ); ?>
				</div>
			<?php endif; ?>
		</a>

		<!-- Info & Stats -->
		<div class="flex-1 space-y-3">
			<div>
				<h3 class="text-base sm:text-lg font-bold text-ink hover:text-blue transition-colors">
					<a href="<?php echo esc_url( $profile_url ); ?>">
						<?php echo esc_html( $instructor_name ); ?>
					</a>
				</h3>
				<?php if ( ! empty( $job_title ) ) : ?>
					<p class="text-xs sm:text-sm font-medium text-muted mt-0.5">
						<?php echo esc_html( $job_title ); ?>
					</p>
				<?php endif; ?>
			</div>

			<!-- Real Stats Pill Row (Only displayed if verified) -->
			<div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs sm:text-sm text-ink-secondary">
				<?php if ( $courses_count > 0 ) : ?>
					<div class="flex items-center gap-1.5">
						<svg class="size-4 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
							<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
						</svg>
						<span>
							<?php echo esc_html( sprintf( _n( 'دورة واحدة', '%s دورات', $courses_count, '3alemni' ), number_format_i18n( $courses_count ) ) ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $students_count > 0 ) : ?>
					<div class="flex items-center gap-1.5">
						<svg class="size-4 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
							<circle cx="9" cy="7" r="4"/>
							<path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
							<path d="M16 3.13a4 4 0 0 1 0 7.75"/>
						</svg>
						<span>
							<?php echo esc_html( sprintf( _n( 'طالب واحد', '%s طالب', $students_count, '3alemni' ), number_format_i18n( $students_count ) ) ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $instructor_rating_avg && $instructor_rating_count > 0 ) : ?>
					<div class="flex items-center gap-1.5">
						<svg class="size-4 fill-amber-500 text-amber-500" viewBox="0 0 20 20" aria-hidden="true">
							<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
						</svg>
						<span class="font-bold text-ink"><?php echo esc_html( $instructor_rating_avg ); ?></span>
						<span class="text-muted">(<?php echo esc_html( sprintf( _n( 'تقييم واحد', '%s تقييم', $instructor_rating_count, '3alemni' ), number_format_i18n( $instructor_rating_count ) ) ); ?>)</span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Bio -->
			<?php if ( ! empty( $bio ) ) : ?>
				<div class="pt-2 text-xs sm:text-sm leading-relaxed text-muted">
					<?php echo wp_kses_post( wpautop( $bio ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

</section>
