<?php
/**
 * 3alemni — Lesson Distraction-Free Header Component
 *
 * Sticky topbar featuring course navigation, progress metrics,
 * and curriculum drawer toggles.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$lesson_id = get_the_ID();
$course_id = function_exists( 'tutor_utils' ) ? (int) tutor_utils()->get_course_id_by_subcontent_id( $lesson_id ) : 0;
$course_title = $course_id ? get_the_title( $course_id ) : __( 'الدورة التعليمية', '3alemni' );
$course_url   = $course_id ? get_permalink( $course_id ) : home_url( '/courses/' );

$user_id = get_current_user_id();
$total_lessons     = ( $course_id && function_exists( 'tutor_utils' ) ) ? (int) tutor_utils()->get_lesson_count_by_course( $course_id ) : 0;
$completed_lessons = ( $course_id && $user_id && function_exists( 'tutor_utils' ) ) ? (int) tutor_utils()->get_completed_lesson_count_by_course( $course_id, $user_id ) : 0;
$progress_pct      = ( $course_id && $user_id && function_exists( 'tutor_utils' ) ) ? (int) tutor_utils()->get_course_completed_percent( $course_id, $user_id ) : 0;
?>

<header class="sticky top-0 z-30 h-16 w-full border-b border-line/80 bg-white/95 backdrop-blur-md px-4 sm:px-6">
	<div class="mx-auto flex h-full w-full items-center justify-between gap-4">

		<!-- Right (RTL Start): Return to Course & Title -->
		<div class="flex items-center gap-3 sm:gap-4 min-w-0">
			<!-- Back to course button -->
			<a
				href="<?php echo esc_url( $course_url ); ?>"
				class="inline-flex size-9 shrink-0 items-center justify-center rounded-xl border border-line bg-paper-subtle text-ink-secondary hover:border-blue/30 hover:bg-white hover:text-blue transition-colors"
				aria-label="<?php esc_attr_e( 'العودة لصفحة تفاصيل الدورة', '3alemni' ); ?>"
				title="<?php esc_attr_e( 'العودة لصفحة تفاصيل الدورة', '3alemni' ); ?>"
			>
				<svg class="size-4.5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<polyline points="15 18 9 12 15 6"/>
				</svg>
			</a>

			<!-- Course Title -->
			<div class="min-w-0">
				<a href="<?php echo esc_url( $course_url ); ?>" class="truncate block text-sm sm:text-base font-bold text-ink hover:text-blue transition-colors">
					<?php echo esc_html( $course_title ); ?>
				</a>
				<span class="text-[11px] text-muted hidden sm:block">
					<?php esc_html_e( 'بيئة التعلّم التفاعلية', '3alemni' ); ?>
				</span>
			</div>
		</div>

		<!-- Center: Progress Indicator (Desktop & Tablet) -->
		<?php if ( $total_lessons > 0 ) : ?>
			<div class="hidden md:flex items-center gap-3 bg-paper-subtle border border-line/60 rounded-full px-4 py-1.5 text-xs">
				<span class="font-medium text-ink-secondary">
					<?php echo esc_html( sprintf( __( '%1$s من %2$s درساً مكملاً', '3alemni' ), number_format_i18n( $completed_lessons ), number_format_i18n( $total_lessons ) ) ); ?>
				</span>
				<div class="h-2 w-24 rounded-full bg-paper overflow-hidden border border-line/60">
					<div class="h-full bg-blue transition-all duration-300 rounded-full" style="width: <?php echo esc_attr( $progress_pct ); ?>%"></div>
				</div>
				<span class="font-bold text-ink" dir="ltr"><?php echo esc_html( $progress_pct ); ?>%</span>
			</div>
		<?php endif; ?>

		<!-- Left (RTL End): Curriculum Drawer / Sidebar Toggle Button -->
		<div class="flex items-center gap-2.5">
			<button
				type="button"
				id="toggle-curriculum-btn"
				class="inline-flex items-center gap-2 rounded-xl border border-line bg-paper-subtle px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-ink-secondary hover:border-blue/30 hover:bg-white hover:text-blue transition-colors"
				aria-expanded="false"
				aria-controls="curriculum-sidebar"
			>
				<svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M4 6h16M4 12h16M4 18h7"/>
				</svg>
				<span class="hidden sm:inline"><?php esc_html_e( 'محتوى الدورة', '3alemni' ); ?></span>
			</button>
		</div>

	</div>
</header>
