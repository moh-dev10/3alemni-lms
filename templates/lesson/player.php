<?php
/**
 * 3alemni — Lesson Video Player Component
 *
 * Cinematic responsive video viewport embedding the native Tutor LMS
 * video player engine and provider configurations.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$lesson_id = get_the_ID();
$has_video = function_exists( 'tutor_utils' ) ? tutor_utils()->has_video( $lesson_id ) : false;

if ( ! $has_video ) {
	$video_info = get_post_meta( $lesson_id, '_video', true );
	$has_video = ( is_array( $video_info ) && ! empty( $video_info['source'] ) && 'html5' !== $video_info['source'] ) || ! empty( $video_info['source_video_id'] ) || ! empty( $video_info['source_external_url'] ) || ! empty( $video_info['source_embedded'] );
}
?>

<div class="lesson-player-container relative w-full overflow-hidden bg-slate-950 border-b border-line/60">

	<?php if ( $has_video ) : ?>
		<!-- Responsive Cinematic 16:9 Video Player -->
		<div class="mx-auto w-full max-w-[1360px] aspect-video max-h-[75vh]">
			<div class="tutor-lesson-video-wrap relative h-full w-full [&_iframe]:h-full [&_iframe]:w-full [&_video]:h-full [&_video]:w-full [&_.plyr]:h-full [&_.plyr]:w-full">
				<?php
				if ( function_exists( 'tutor_lesson_video' ) ) {
					tutor_lesson_video();
				} elseif ( function_exists( 'tutor_course_video' ) ) {
					tutor_course_video();
				}
				?>
			</div>
		</div>

	<?php else : ?>
		<!-- Reading / Text-Only Lesson Banner -->
		<div class="mx-auto w-full max-w-[1360px] py-10 sm:py-14 px-4 sm:px-6 lg:px-8 text-center text-white">
			<div class="mx-auto mb-4 grid size-16 place-items-center rounded-2xl bg-white/10 text-blue-light border border-white/15">
				<svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
					<path d="M6 6h10"/>
					<path d="M6 10h10"/>
					<path d="M6 14h6"/>
				</svg>
			</div>
			<span class="inline-flex items-center gap-1.5 rounded-full bg-blue/20 border border-blue/30 px-3 py-1 text-xs font-semibold text-blue-light mb-2">
				<?php esc_html_e( 'محتوى نصي وقراءة', '3alemni' ); ?>
			</span>
			<h1 class="text-xl sm:text-2xl md:text-3xl font-bold tracking-tight">
				<?php echo esc_html( get_the_title( $lesson_id ) ); ?>
			</h1>
			<p class="mt-2 text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
				<?php esc_html_e( 'هذا الدرس مخصص للقراءة والتطبيق العملي. يمكنك متابعة الشرح والملاحظات والمرفقات أدناه.', '3alemni' ); ?>
			</p>
		</div>

	<?php endif; ?>

</div>
