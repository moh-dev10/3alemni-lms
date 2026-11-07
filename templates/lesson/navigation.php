<?php
/**
 * 3alemni — Lesson Navigation & Completion Component
 *
 * Controls Previous/Next navigation and native Tutor LMS
 * completion tracking with valid security nonces.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$lesson_id = get_the_ID();
$course_id = function_exists( 'tutor_utils' ) ? (int) tutor_utils()->get_course_id_by_subcontent_id( $lesson_id ) : 0;
$user_id   = get_current_user_id();

// Previous & Next Lesson IDs
$previous_id = function_exists( 'tutor_utils' ) ? tutor_utils()->get_previous_lesson( $lesson_id ) : 0;
$next_id     = function_exists( 'tutor_utils' ) ? tutor_utils()->get_next_lesson( $lesson_id ) : 0;

// Completion Status
$is_completed = ( $user_id && function_exists( 'tutor_utils' ) ) ? tutor_utils()->is_completed_lesson( $lesson_id, $user_id ) : false;
?>

<div class="lesson-navigation border-y border-line/80 bg-white py-4 px-4 sm:px-6 lg:px-8">
	<div class="mx-auto flex flex-wrap items-center justify-between gap-4">

		<!-- 1. Previous Lesson Button -->
		<div>
			<?php if ( $previous_id ) : ?>
				<a
					href="<?php echo esc_url( get_permalink( $previous_id ) ); ?>"
					class="btn btn-secondary text-xs sm:text-sm font-semibold py-2.5 px-4 gap-2"
					title="<?php echo esc_attr( get_the_title( $previous_id ) ); ?>"
				>
					<svg class="size-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<polyline points="15 18 9 12 15 6"/>
					</svg>
					<span class="hidden sm:inline"><?php esc_html_e( 'الدرس السابق', '3alemni' ); ?></span>
					<span class="sm:hidden"><?php esc_html_e( 'السابق', '3alemni' ); ?></span>
				</a>
			<?php else : ?>
				<span class="inline-flex items-center gap-2 rounded-xl border border-line/40 bg-paper-subtle px-4 py-2.5 text-xs text-muted/60 cursor-not-allowed select-none">
					<svg class="size-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<polyline points="15 18 9 12 15 6"/>
					</svg>
					<span class="hidden sm:inline"><?php esc_html_e( 'الدرس السابق', '3alemni' ); ?></span>
				</span>
			<?php endif; ?>
		</div>

		<!-- 2. Native Lesson Completion Action -->
		<div class="flex items-center gap-2">
			<?php if ( $is_completed ) : ?>
				<div class="inline-flex items-center gap-2 rounded-xl bg-success-subtle border border-success/30 px-4 py-2.5 text-xs sm:text-sm font-bold text-success shadow-xs">
					<svg class="size-4.5 fill-current" viewBox="0 0 20 20" aria-hidden="true">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
					</svg>
					<span><?php esc_html_e( 'تم إكمال هذا الدرس', '3alemni' ); ?></span>
				</div>
			<?php else : ?>
				<form method="post" action="" class="tutor-complete-lesson-form inline-block">
					<?php
					if ( function_exists( 'tutor_nonce_field' ) ) {
						tutor_nonce_field();
					} else {
						wp_nonce_field( tutor()->nonce_action, tutor()->nonce );
					}
					?>
					<input type="hidden" name="tutor_action" value="tutor_complete_lesson" />
					<input type="hidden" name="lesson_id" value="<?php echo esc_attr( $lesson_id ); ?>" />
					<button
						type="submit"
						class="btn btn-primary text-xs sm:text-sm font-bold py-2.5 px-5 shadow-sm gap-2"
					>
						<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<polyline points="20 6 9 17 4 12"/>
						</svg>
						<span><?php esc_html_e( 'إكمال الدرس ومتابعة', '3alemni' ); ?></span>
					</button>
				</form>
			<?php endif; ?>
		</div>

		<!-- 3. Next Lesson Button -->
		<div>
			<?php if ( $next_id ) : ?>
				<a
					href="<?php echo esc_url( get_permalink( $next_id ) ); ?>"
					class="btn btn-primary text-xs sm:text-sm font-semibold py-2.5 px-4 gap-2"
					title="<?php echo esc_attr( get_the_title( $next_id ) ); ?>"
				>
					<span class="hidden sm:inline"><?php esc_html_e( 'الدرس التالي', '3alemni' ); ?></span>
					<span class="sm:hidden"><?php esc_html_e( 'التالي', '3alemni' ); ?></span>
					<svg class="size-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<polyline points="9 18 15 12 9 6"/>
					</svg>
				</a>
			<?php else : ?>
				<a
					href="<?php echo esc_url( get_permalink( $course_id ) ); ?>"
					class="btn btn-secondary text-xs sm:text-sm font-semibold py-2.5 px-4 gap-2"
					title="<?php esc_attr_e( 'إنهاء الدورة والعودة للتفاصيل', '3alemni' ); ?>"
				>
					<span><?php esc_html_e( 'إنهاء الدورة', '3alemni' ); ?></span>
					<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
						<polyline points="22 4 12 14.01 9 11.01"/>
					</svg>
				</a>
			<?php endif; ?>
		</div>

	</div>
</div>
