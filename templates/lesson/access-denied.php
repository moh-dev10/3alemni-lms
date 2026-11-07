<?php
/**
 * 3alemni — Lesson Access Denied Component
 *
 * Rendered when an unauthorized guest or non-enrolled user attempts
 * to view a protected lesson that is not configured as a free preview.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$lesson_id = get_the_ID();
$course_id = function_exists( 'tutor_utils' ) ? (int) tutor_utils()->get_course_id_by_subcontent_id( $lesson_id ) : 0;
$course_title = $course_id ? get_the_title( $course_id ) : __( 'الدورة التعليمية', '3alemni' );
$course_url   = $course_id ? get_permalink( $course_id ) : home_url( '/courses/' );
?>

<div class="min-h-[calc(100vh-64px)] flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-paper">
	<div class="w-full max-w-lg rounded-3xl border border-line bg-white p-8 sm:p-10 shadow-card text-center space-y-6">

		<!-- Lock Icon -->
		<div class="mx-auto grid size-20 place-items-center rounded-2xl bg-amber-500/10 text-amber-600 border border-amber-500/20">
			<svg class="size-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
				<path d="M7 11V7a5 5 0 0 1 10 0v4"/>
			</svg>
		</div>

		<!-- Headings -->
		<div class="space-y-2">
			<span class="inline-flex items-center gap-1.5 rounded-full bg-paper px-3 py-1 text-xs font-semibold text-muted border border-line">
				<?php echo esc_html( $course_title ); ?>
			</span>
			<h1 class="text-xl sm:text-2xl font-bold text-ink tracking-tight">
				<?php esc_html_e( 'هذا الدرس متاح حصرياً للمسجلين', '3alemni' ); ?>
			</h1>
			<p class="text-sm leading-relaxed text-muted max-w-md mx-auto">
				<?php esc_html_e( 'لم تشترك في هذه الدورة بعد. يرجى التسجيل في الدورة للوصول إلى هذا الدرس وجميع المحاضرات والملفات المرفقة.', '3alemni' ); ?>
			</p>
		</div>

		<!-- Action Buttons -->
		<div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
			<a
				href="<?php echo esc_url( $course_url ); ?>"
				class="btn btn-primary w-full sm:w-auto px-6 py-3 font-bold shadow-sm justify-center gap-2"
			>
				<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
					<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
				</svg>
				<span><?php esc_html_e( 'الانتقال لصفحة الدورة والتسجيل', '3alemni' ); ?></span>
			</a>

			<?php if ( ! is_user_logged_in() ) : ?>
				<a
					href="<?php echo esc_url( wp_login_url( get_permalink( $lesson_id ) ) ); ?>"
					class="btn btn-secondary w-full sm:w-auto px-6 py-3 font-semibold justify-center gap-2"
				>
					<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
						<polyline points="10 17 15 12 10 7"/>
						<line x1="15" y1="12" x2="3" y2="12"/>
					</svg>
					<span><?php esc_html_e( 'تسجيل الدخول', '3alemni' ); ?></span>
				</a>
			<?php endif; ?>
		</div>

	</div>
</div>
