<?php
/**
 * 3alemni — Lesson Content & Resources Component
 *
 * Displays lesson title, long description, downloadable attachments,
 * and supplementary learning resources.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$lesson_id = get_the_ID();
$course_id = function_exists( 'tutor_utils' ) ? (int) tutor_utils()->get_course_id_by_subcontent_id( $lesson_id ) : 0;

// Lesson Duration
$duration_str = '';
$video_meta = get_post_meta( $lesson_id, '_video', true );
if ( is_array( $video_meta ) && ! empty( $video_meta['runtime'] ) ) {
	$runtime = $video_meta['runtime'];
	$h = ! empty( $runtime['hours'] ) ? (int) $runtime['hours'] : 0;
	$m = ! empty( $runtime['minutes'] ) ? (int) $runtime['minutes'] : 0;
	$s = ! empty( $runtime['seconds'] ) ? (int) $runtime['seconds'] : 0;
	if ( $h > 0 ) {
		$duration_str = sprintf( '%d:%02d:%02d', $h, $m, $s );
	} elseif ( $m > 0 || $s > 0 ) {
		$duration_str = sprintf( '%d:%02d', $m, $s );
	}
}

// Attachments
$attachments = array();
if ( function_exists( 'tutor_utils' ) ) {
	$attachments_raw = tutor_utils()->get_attachments( $lesson_id );
	if ( is_array( $attachments_raw ) ) {
		$attachments = $attachments_raw;
	}
}

if ( empty( $attachments ) ) {
	$meta_att = get_post_meta( $lesson_id, '_tutor_attachments', true );
	if ( is_array( $meta_att ) ) {
		$attachments = $meta_att;
	}
}

$content = get_the_content();
?>

<div class="lesson-content-body max-w-4xl mx-auto py-8 sm:py-10 px-4 sm:px-6 lg:px-8 space-y-8">

	<!-- Lesson Header Info -->
	<div class="space-y-3 border-b border-line/60 pb-6">
		<div class="flex flex-wrap items-center gap-2 text-xs">
			<?php if ( ! empty( $duration_str ) ) : ?>
				<span class="inline-flex items-center gap-1.5 rounded-full border border-line bg-paper px-3 py-1 font-medium text-ink-secondary" dir="ltr">
					<svg class="size-3.5 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<circle cx="12" cy="12" r="10"/>
						<polyline points="12 6 12 12 16 14"/>
					</svg>
					<span><?php echo esc_html( $duration_str ); ?></span>
				</span>
			<?php endif; ?>

			<span class="inline-flex items-center gap-1 rounded-full bg-blue/10 px-3 py-1 font-semibold text-blue">
				<svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<polygon points="5 3 19 12 5 21 5 3"/>
				</svg>
				<?php esc_html_e( 'درس تعليمي', '3alemni' ); ?>
			</span>
		</div>

		<h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-ink tracking-tight">
			<?php echo esc_html( get_the_title( $lesson_id ) ); ?>
		</h1>
	</div>

	<!-- Lesson Text Body -->
	<?php if ( ! empty( trim( $content ) ) ) : ?>
		<section class="prose max-w-none text-sm sm:text-base leading-relaxed text-ink-secondary" aria-label="<?php esc_attr_e( 'شرح وتفاصيل الدرس', '3alemni' ); ?>">
			<?php the_content(); ?>
		</section>
	<?php endif; ?>

	<!-- Downloadable Attachments & Resources -->
	<?php if ( ! empty( $attachments ) ) : ?>
		<section class="rounded-2xl border border-line bg-white p-6 shadow-xs space-y-4" aria-labelledby="lesson-attachments-heading">
			<div class="flex items-center gap-2.5">
				<div class="grid size-8 place-items-center rounded-lg bg-blue/10 text-blue">
					<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
						<polyline points="7 10 12 15 17 10"/>
						<line x1="12" y1="15" x2="12" y2="3"/>
					</svg>
				</div>
				<h2 id="lesson-attachments-heading" class="text-base font-bold text-ink">
					<?php esc_html_e( 'الملفات والمرفقات القابلة للتحميل', '3alemni' ); ?>
				</h2>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
				<?php foreach ( $attachments as $att ) : ?>
					<?php
					$att_id   = is_object( $att ) ? ( isset( $att->media_id ) ? $att->media_id : $att->ID ) : ( is_array( $att ) ? ( isset( $att['id'] ) ? $att['id'] : 0 ) : (int) $att );
					$file_url = $att_id ? wp_get_attachment_url( $att_id ) : ( is_array( $att ) && ! empty( $att['url'] ) ? $att['url'] : '' );
					$name     = is_object( $att ) ? ( isset( $att->name ) ? $att->name : get_the_title( $att_id ) ) : ( is_array( $att ) && ! empty( $att['name'] ) ? $att['name'] : get_the_title( $att_id ) );
					$size     = is_object( $att ) && ! empty( $att->size ) ? $att->size : '';

					if ( empty( $file_url ) ) {
						continue;
					}
					?>
					<a
						href="<?php echo esc_url( $file_url ); ?>"
						download
						class="flex items-center justify-between gap-3 rounded-xl border border-line bg-paper-subtle p-3.5 text-xs sm:text-sm font-medium text-ink hover:border-blue/30 hover:bg-white hover:text-blue transition-colors group"
					>
						<div class="flex items-center gap-2.5 truncate">
							<svg class="size-4.5 text-blue shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
								<polyline points="14 2 14 8 20 8"/>
							</svg>
							<span class="truncate"><?php echo esc_html( $name ?: __( 'ملف مرفق', '3alemni' ) ); ?></span>
						</div>
						<div class="flex items-center gap-2 shrink-0">
							<?php if ( ! empty( $size ) ) : ?>
								<span class="text-xs text-muted" dir="ltr"><?php echo esc_html( $size ); ?></span>
							<?php endif; ?>
							<span class="grid size-6 place-items-center rounded-md bg-white text-muted group-hover:text-blue group-hover:bg-blue/10 transition-colors">
								<svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
									<polyline points="7 10 12 15 17 10"/>
									<line x1="12" y1="15" x2="12" y2="3"/>
								</svg>
							</span>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Native Lesson Action Hook (For Tutor Q&A and Addons) -->
	<?php
	/**
	 * Hook: tutor_lesson/single/after/content
	 */
	do_action( 'tutor_lesson/single/after/content' );
	?>

</div>
