<?php
/**
 * 3alemni — Single Course Hero Component
 *
 * Displays course breadcrumbs, title, category, instructor info,
 * rating summary, enrolled students count, and last update date.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();
if ( ! $course_id ) {
	return;
}

$instructor = get_userdata( (int) get_post_field( 'post_author', $course_id ) );
$instructor_name = $instructor ? $instructor->display_name : __( 'منصة علّمني', '3alemni' );
$instructor_avatar = $instructor ? get_avatar_url( $instructor->ID, array( 'size' => 96 ) ) : '';

// Course categories
$terms = get_the_terms( $course_id, 'course-category' );
$category_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
$category_link = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? get_term_link( $terms[0] ) : '';

// Rating data
$rating = function_exists( 'tutor_utils' ) ? tutor_utils()->get_course_rating( $course_id ) : null;
$rating_avg   = ( ! empty( $rating->rating_avg ) && (float) $rating->rating_avg > 0 )
	? number_format( (float) $rating->rating_avg, 1 )
	: null;
$rating_count = ! empty( $rating->rating_count ) ? (int) $rating->rating_count : 0;

// Enrolled students count
$enrolled_count = function_exists( 'tutor_utils' )
	? (int) tutor_utils()->count_enrolled_users_by_course( $course_id )
	: 0;

// Course level
$level_raw = get_post_meta( $course_id, '_tutor_course_level', true );
$level_labels = array(
	'all_levels'   => __( 'جميع المستويات', '3alemni' ),
	'beginner'     => __( 'مبتدئ', '3alemni' ),
	'intermediate' => __( 'متوسط', '3alemni' ),
	'expert'       => __( 'متقدم', '3alemni' ),
);
$level_label = isset( $level_labels[ $level_raw ] ) ? $level_labels[ $level_raw ] : '';

// Course duration
$duration_str = '';
if ( function_exists( 'tutor_utils' ) ) {
	$duration_ctx = tutor_utils()->get_course_duration_context( $course_id );
	if ( ! empty( $duration_ctx ) ) {
		$duration_str = $duration_ctx;
	}
}

// Last updated date
$modified_date = get_the_modified_date( 'j F Y' );
?>

<section class="single-course-hero relative isolate overflow-hidden border-b border-line/60 bg-paper py-8 sm:py-12 lg:py-16">
	<!-- Decorative background glows -->
	<div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
		<div class="absolute left-1/2 top-0 h-[26rem] w-full max-w-5xl -translate-x-1/2 -translate-y-1/3 rounded-full bg-blue/10 blur-3xl sm:h-[32rem]"></div>
		<div class="absolute -right-32 top-0 size-64 rounded-full bg-blue/5 blur-3xl sm:size-96"></div>
		<div class="absolute -left-32 bottom-0 size-64 rounded-full bg-blue/5 blur-3xl sm:size-96"></div>
	</div>

	<div class="mx-auto w-full max-w-[1360px] px-4 sm:px-6 lg:px-8">
		<!-- Breadcrumbs -->
		<nav aria-label="<?php esc_attr_e( 'مسار التنقل', '3alemni' ); ?>" class="mb-4 sm:mb-6">
			<ol class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-muted">
				<li>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-blue">
						<?php esc_html_e( 'الرئيسية', '3alemni' ); ?>
					</a>
				</li>
				<li aria-hidden="true" class="select-none text-line">&lsaquo;</li>
				<li>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'courses' ) ?: home_url( '/courses/' ) ); ?>" class="transition-colors hover:text-blue">
						<?php esc_html_e( 'الدورات التعليمية', '3alemni' ); ?>
					</a>
				</li>
				<?php if ( ! empty( $category_name ) && ! empty( $category_link ) && ! is_wp_error( $category_link ) ) : ?>
					<li aria-hidden="true" class="select-none text-line">&lsaquo;</li>
					<li>
						<a href="<?php echo esc_url( $category_link ); ?>" class="transition-colors hover:text-blue">
							<?php echo esc_html( $category_name ); ?>
						</a>
					</li>
				<?php endif; ?>
				<li aria-hidden="true" class="select-none text-line">&lsaquo;</li>
				<li class="truncate max-w-[200px] sm:max-w-xs font-medium text-ink" aria-current="page">
					<?php echo esc_html( get_the_title() ); ?>
				</li>
			</ol>
		</nav>

		<!-- Hero Core Info -->
		<div class="max-w-3xl space-y-4 sm:space-y-5">
			<!-- Meta chips: Category & Level -->
			<div class="flex flex-wrap items-center gap-2.5">
				<?php if ( ! empty( $category_name ) ) : ?>
					<span class="inline-flex items-center gap-1.5 rounded-full border border-blue/20 bg-blue/10 px-3 py-1 text-xs font-semibold text-blue">
						<svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
							<polyline points="9 22 9 12 15 12 15 22"/>
						</svg>
						<?php echo esc_html( $category_name ); ?>
					</span>
				<?php endif; ?>

				<?php if ( ! empty( $level_label ) ) : ?>
					<span class="inline-flex items-center gap-1.5 rounded-full border border-line bg-white px-3 py-1 text-xs font-medium text-ink-secondary">
						<svg class="size-3.5 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
						</svg>
						<?php echo esc_html( $level_label ); ?>
					</span>
				<?php endif; ?>

				<?php if ( ! empty( $duration_str ) ) : ?>
					<span class="inline-flex items-center gap-1.5 rounded-full border border-line bg-white px-3 py-1 text-xs font-medium text-ink-secondary">
						<svg class="size-3.5 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<circle cx="12" cy="12" r="10"/>
							<polyline points="12 6 12 12 16 14"/>
						</svg>
						<?php echo esc_html( $duration_str ); ?>
					</span>
				<?php endif; ?>
			</div>

			<!-- Course Title -->
			<h1 class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-ink leading-[1.3] text-balance">
				<?php echo esc_html( get_the_title() ); ?>
			</h1>

			<!-- Course Excerpt / Subtitle -->
			<?php if ( has_excerpt() ) : ?>
				<p class="text-base sm:text-lg leading-relaxed text-muted max-w-2xl">
					<?php echo esc_html( get_the_excerpt() ); ?>
				</p>
			<?php endif; ?>

			<!-- Instructor & Social Proof Row -->
			<div class="flex flex-wrap items-center gap-y-3 gap-x-6 pt-1 text-xs sm:text-sm text-ink-secondary">
				<!-- Instructor -->
				<?php if ( $instructor ) : ?>
					<div class="flex items-center gap-2.5">
						<?php if ( ! empty( $instructor_avatar ) ) : ?>
							<img
								src="<?php echo esc_url( $instructor_avatar ); ?>"
								alt="<?php echo esc_attr( $instructor_name ); ?>"
								class="size-8 rounded-full border border-line object-cover"
								loading="lazy"
							/>
						<?php endif; ?>
						<span>
							<?php esc_html_e( 'المدرّب:', '3alemni' ); ?>
							<strong class="font-semibold text-ink"><?php echo esc_html( $instructor_name ); ?></strong>
						</span>
					</div>
				<?php endif; ?>

				<!-- Rating Summary (Only if real ratings exist) -->
				<?php if ( $rating_avg && $rating_count > 0 ) : ?>
					<div class="flex items-center gap-1.5">
						<div class="flex items-center text-amber-500" aria-label="<?php echo esc_attr( sprintf( __( 'التقييم: %s من 5', '3alemni' ), $rating_avg ) ); ?>">
							<svg class="size-4 fill-current" viewBox="0 0 20 20" aria-hidden="true">
								<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
							</svg>
						</div>
						<span class="font-bold text-ink"><?php echo esc_html( $rating_avg ); ?></span>
						<span class="text-muted">(<?php echo esc_html( sprintf( _n( 'تقييم واحد', '%s تقييم', $rating_count, '3alemni' ), number_format_i18n( $rating_count ) ) ); ?>)</span>
					</div>
				<?php endif; ?>

				<!-- Enrolled Students (Only if > 0) -->
				<?php if ( $enrolled_count > 0 ) : ?>
					<div class="flex items-center gap-1.5 text-muted">
						<svg class="size-4 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
							<circle cx="9" cy="7" r="4"/>
							<path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
							<path d="M16 3.13a4 4 0 0 1 0 7.75"/>
						</svg>
						<span>
							<?php echo esc_html( sprintf( _n( 'طالب واحد مسجّل', '%s طالب مسجّل', $enrolled_count, '3alemni' ), number_format_i18n( $enrolled_count ) ) ); ?>
						</span>
					</div>
				<?php endif; ?>

				<!-- Last Updated -->
				<div class="flex items-center gap-1.5 text-muted">
					<svg class="size-4 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M12 20h9"/>
						<path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
					</svg>
					<span>
						<?php esc_html_e( 'آخر تحديث:', '3alemni' ); ?>
						<?php echo esc_html( $modified_date ); ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</section>
