<?php
/**
 * 3alemni — Premium Student Dashboard Template
 *
 * Renders the authenticated student workspace:
 * - Welcome banner with personalized greeting
 * - Real-time learning overview metrics
 * - Prominent "Continue Learning" hero section
 * - Responsive "My Courses" grid with real progress
 * - Recent learning activity & refined empty states
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use Tutor\Components\Avatar;
use Tutor\Components\Constants\Size;
use TUTOR\Icon;

$user_id      = get_current_user_id();
$current_user = wp_get_current_user();

if ( ! $user_id ) {
	return;
}

$display_name = function_exists( 'tutor_utils' )
	? tutor_utils()->display_name( $user_id )
	: ( $current_user->display_name ?: $current_user->user_login );

// Retrieve enrolled courses for currently authenticated student
$enrolled_courses = null;
if ( function_exists( 'tutor_utils' ) ) {
	$enrolled_courses = tutor_utils()->get_enrolled_courses_by_user( $user_id );
}

$courses_list       = array();
$enrolled_count     = 0;
$in_progress_count  = 0;
$completed_count    = 0;
$continue_course    = null;

if ( $enrolled_courses && $enrolled_courses->have_posts() ) {
	$enrolled_count = (int) $enrolled_courses->found_posts;

	while ( $enrolled_courses->have_posts() ) {
		$enrolled_courses->the_post();
		$course_id = get_the_ID();

		$progress = function_exists( 'tutor_utils' )
			? (int) tutor_utils()->get_course_completed_percent( $course_id, $user_id )
			: 0;

		$is_completed = ( $progress >= 100 );
		if ( function_exists( 'tutor_utils' ) && method_exists( tutor_utils(), 'is_completed_course' ) ) {
			$is_completed = $is_completed || tutor_utils()->is_completed_course( $course_id, $user_id );
		}

		if ( $is_completed ) {
			$completed_count++;
			$progress = 100;
		} else {
			$in_progress_count++;
		}

		// Next or current lesson link
		$next_lesson_id = 0;
		if ( function_exists( 'tutor_utils' ) ) {
			if ( method_exists( tutor_utils(), 'get_next_lesson_by_course' ) ) {
				$next_lesson_id = tutor_utils()->get_next_lesson_by_course( $course_id, $user_id );
			}
			if ( ! $next_lesson_id && method_exists( tutor_utils(), 'get_course_first_lesson' ) ) {
				$next_lesson_id = tutor_utils()->get_course_first_lesson( $course_id );
			}
		}

		$continue_url = $next_lesson_id ? get_permalink( $next_lesson_id ) : get_permalink( $course_id );
		$lesson_title = $next_lesson_id ? get_the_title( $next_lesson_id ) : '';

		// Instructor name
		$instructor_name = function_exists( 'tutor_utils' ) && method_exists( tutor_utils(), 'get_instructor_name' )
			? tutor_utils()->get_instructor_name( $course_id )
			: get_the_author();

		$course_item = array(
			'id'              => $course_id,
			'title'           => get_the_title(),
			'permalink'       => get_permalink( $course_id ),
			'continue_url'    => $continue_url,
			'thumbnail_url'   => get_the_post_thumbnail_url( $course_id, 'medium_large' ),
			'instructor_name' => $instructor_name,
			'progress'        => $progress,
			'is_completed'    => $is_completed,
			'lesson_title'    => $lesson_title,
		);

		$courses_list[] = $course_item;

		// Select the first active in-progress course as the primary "Continue Learning" course
		if ( ! $continue_course && ! $is_completed ) {
			$continue_course = $course_item;
		}
	}
	wp_reset_postdata();

	// If no in-progress course found but has courses, pick the first enrolled course
	if ( ! $continue_course && ! empty( $courses_list ) ) {
		$continue_course = $courses_list[0];
	}
}

// Calculate overall completion rate
$completion_rate = $enrolled_count > 0 ? (int) round( ( $completed_count / $enrolled_count ) * 100 ) : 0;

// Course archive URL
$course_archive_url = function_exists( 'tutor_utils' )
	? tutor_utils()->course_archive_page_url()
	: home_url( '/courses/' );
?>

<div class="alemni-student-workspace space-y-8" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">

	<!-- 1. WELCOME SECTION -->
	<section class="card-base bg-white border border-line p-6 sm:p-8 rounded-xl relative overflow-hidden shadow-subtle">
		<div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
			<div class="space-y-2 max-w-2xl">
				<div class="flex items-center gap-2">
					<span class="badge badge-primary">
						<?php esc_html_e( 'مساحة المتعلّم', '3alemni' ); ?>
					</span>
					<span class="text-xs text-muted">
						<?php echo esc_html( wp_date( 'l، j F Y' ) ); ?>
					</span>
				</div>

				<h1 class="text-2xl sm:text-3xl font-bold text-ink tracking-tight flex items-center gap-2">
					<span><?php echo esc_html_x( 'مرحباً بك،', 'greeting', '3alemni' ); ?></span>
					<span class="text-blue"><?php echo esc_html( $display_name ); ?></span>
					<span class="text-xl" aria-hidden="true">👋</span>
				</h1>

				<p class="text-sm text-ink-secondary leading-relaxed">
					<?php
					if ( $in_progress_count > 0 ) {
						/* translators: %d: number of courses in progress */
						printf( esc_html__( 'لديك %d دورات قيد التعلّم. واصل التقدّم واكتسب مهارات عملية جديدة.', '3alemni' ), (int) $in_progress_count );
					} elseif ( $enrolled_count > 0 ) {
						esc_html_e( 'تهانينا! لقد أكملت مساراتك المسجلة. استكشف دورات جديدة لتوسيع آفاقك.', '3alemni' );
					} else {
						esc_html_e( 'أهلاً بك في منصة علّمني. ابدأ رحلتك التعليمية اليوم باختيار أول مساق يناسب اهتماماتك.', '3alemni' );
					}
					?>
				</p>
			</div>

			<div class="flex items-center gap-3 shrink-0">
				<?php if ( $continue_course && ! $continue_course['is_completed'] ) : ?>
					<a
						href="<?php echo esc_url( $continue_course['continue_url'] ); ?>"
						class="btn btn-primary btn-md shadow-subtle"
					>
						<span><?php esc_html_e( 'متابعة آخر درس', '3alemni' ); ?></span>
						<svg class="size-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
						</svg>
					</a>
				<?php else : ?>
					<a
						href="<?php echo esc_url( $course_archive_url ); ?>"
						class="btn btn-primary btn-md shadow-subtle"
					>
						<span><?php esc_html_e( 'استكشاف الدورات', '3alemni' ); ?></span>
						<svg class="size-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
						</svg>
					</a>
				<?php endif; ?>

				<a
					href="<?php echo esc_url( function_exists( 'tutor_utils' ) ? tutor_utils()->get_tutor_dashboard_page_permalink( 'enrolled-courses' ) : '#' ); ?>"
					class="btn btn-secondary btn-md"
				>
					<?php esc_html_e( 'سجل الدورات', '3alemni' ); ?>
				</a>
			</div>
		</div>
	</section>

	<!-- 2. LEARNING OVERVIEW METRICS -->
	<section class="grid grid-cols-2 sm:grid-cols-4 gap-4">
		<!-- Enrolled Courses -->
		<div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
			<div class="flex items-center justify-between mb-3">
				<span class="text-xs font-semibold uppercase tracking-wider text-muted">
					<?php esc_html_e( 'الدورات المسجلة', '3alemni' ); ?>
				</span>
				<span class="grid size-8 place-items-center rounded-lg bg-blue-subtle text-blue text-sm">
					📚
				</span>
			</div>
			<div class="flex items-baseline gap-2">
				<span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">
					<?php echo esc_html( number_format_i18n( $enrolled_count ) ); ?>
				</span>
				<span class="text-xs text-muted"><?php esc_html_e( 'دورة', '3alemni' ); ?></span>
			</div>
		</div>

		<!-- In Progress -->
		<div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
			<div class="flex items-center justify-between mb-3">
				<span class="text-xs font-semibold uppercase tracking-wider text-muted">
					<?php esc_html_e( 'قيد التعلّم', '3alemni' ); ?>
				</span>
				<span class="grid size-8 place-items-center rounded-lg bg-warning-subtle text-warning text-sm">
					⏳
				</span>
			</div>
			<div class="flex items-baseline gap-2">
				<span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">
					<?php echo esc_html( number_format_i18n( $in_progress_count ) ); ?>
				</span>
				<span class="text-xs text-muted"><?php esc_html_e( 'دورة جارية', '3alemni' ); ?></span>
			</div>
		</div>

		<!-- Completed -->
		<div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
			<div class="flex items-center justify-between mb-3">
				<span class="text-xs font-semibold uppercase tracking-wider text-muted">
					<?php esc_html_e( 'الدورات المكتملة', '3alemni' ); ?>
				</span>
				<span class="grid size-8 place-items-center rounded-lg bg-success-subtle text-success text-sm">
					✓
				</span>
			</div>
			<div class="flex items-baseline gap-2">
				<span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">
					<?php echo esc_html( number_format_i18n( $completed_count ) ); ?>
				</span>
				<span class="text-xs text-muted"><?php esc_html_e( 'شهادة جاهزة', '3alemni' ); ?></span>
			</div>
		</div>

		<!-- Completion Rate -->
		<div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
			<div class="flex items-center justify-between mb-3">
				<span class="text-xs font-semibold uppercase tracking-wider text-muted">
					<?php esc_html_e( 'معدل الإنجاز', '3alemni' ); ?>
				</span>
				<span class="grid size-8 place-items-center rounded-lg bg-blue-light text-blue text-sm">
					🎯
				</span>
			</div>
			<div class="flex items-baseline gap-2">
				<span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">
					<?php echo esc_html( $completion_rate ); ?>%
				</span>
				<span class="text-xs text-muted"><?php esc_html_e( 'إجمالي المسارات', '3alemni' ); ?></span>
			</div>
		</div>
	</section>

	<!-- 3. CONTINUE LEARNING (PRIMARY HERO SECTION) -->
	<?php if ( $continue_course ) : ?>
		<section class="space-y-4">
			<div class="flex items-center justify-between">
				<div class="flex items-center gap-2">
					<h2 class="text-lg sm:text-xl font-bold text-ink">
						<?php esc_html_e( 'متابعة التعلّم', '3alemni' ); ?>
					</h2>
					<span class="badge badge-primary">
						<?php echo esc_html( $continue_course['progress'] ); ?>% <?php esc_html_e( 'منجز', '3alemni' ); ?>
					</span>
				</div>
				<a
					href="<?php echo esc_url( $continue_course['permalink'] ); ?>"
					class="text-xs font-semibold text-blue hover:text-blue-dark transition"
				>
					<?php esc_html_e( 'تفاصيل الدورة', '3alemni' ); ?> &larr;
				</a>
			</div>

			<div class="card-base bg-white border border-line rounded-xl p-6 shadow-card hover:border-line-strong transition">
				<div class="flex flex-col md:flex-row gap-6 items-start">
					<!-- Course Thumbnail -->
					<div class="w-full md:w-56 shrink-0 aspect-video md:aspect-[4/3] rounded-lg overflow-hidden bg-paper-subtle border border-line relative">
						<?php if ( ! empty( $continue_course['thumbnail_url'] ) ) : ?>
							<img
								src="<?php echo esc_url( $continue_course['thumbnail_url'] ); ?>"
								alt="<?php echo esc_attr( $continue_course['title'] ); ?>"
								class="w-full h-full object-cover"
							>
						<?php else : ?>
							<div class="w-full h-full flex flex-col items-center justify-center p-4 text-muted bg-paper-subtle">
								<span class="text-3xl mb-1">📖</span>
								<span class="text-xs text-center font-medium"><?php esc_html_e( 'علّمني', '3alemni' ); ?></span>
							</div>
						<?php endif; ?>
					</div>

					<!-- Course Details & Next Step -->
					<div class="flex-1 space-y-4 min-w-0 w-full">
						<div class="space-y-1.5">
							<div class="flex items-center gap-2">
								<span class="text-xs text-muted">
									<?php esc_html_e( 'المدرّب:', '3alemni' ); ?>
									<strong class="text-ink"><?php echo esc_html( $continue_course['instructor_name'] ); ?></strong>
								</span>
								<?php if ( $continue_course['is_completed'] ) : ?>
									<span class="badge badge-success text-[11px]"><?php esc_html_e( 'مكتملة', '3alemni' ); ?></span>
								<?php else : ?>
									<span class="badge badge-primary text-[11px]"><?php esc_html_e( 'قيد التقدّم', '3alemni' ); ?></span>
								<?php endif; ?>
							</div>

							<h3 class="text-xl font-bold text-ink hover:text-blue transition line-clamp-2">
								<a href="<?php echo esc_url( $continue_course['permalink'] ); ?>">
									<?php echo esc_html( $continue_course['title'] ); ?>
								</a>
							</h3>
						</div>

						<!-- Lesson indicator if ongoing -->
						<?php if ( ! empty( $continue_course['lesson_title'] ) && ! $continue_course['is_completed'] ) : ?>
							<div class="p-3 bg-paper-subtle rounded-lg border border-line-subtle flex items-center justify-between gap-3 text-xs">
								<div class="flex items-center gap-2 text-ink">
									<span class="size-2 rounded-full bg-blue shrink-0"></span>
									<span class="text-muted"><?php esc_html_e( 'الدرس التالي:', '3alemni' ); ?></span>
									<strong class="truncate max-w-xs sm:max-w-md"><?php echo esc_html( $continue_course['lesson_title'] ); ?></strong>
								</div>
								<span class="text-muted shrink-0"><?php esc_html_e( 'جاهز للبدء', '3alemni' ); ?></span>
							</div>
						<?php endif; ?>

						<!-- Progress Bar -->
						<div class="space-y-1.5">
							<div class="flex items-center justify-between text-xs text-muted">
								<span><?php esc_html_e( 'نسبة الإنجاز', '3alemni' ); ?></span>
								<strong class="text-ink tabular-nums"><?php echo esc_html( $continue_course['progress'] ); ?>%</strong>
							</div>
							<div class="w-full h-2.5 bg-paper rounded-full overflow-hidden border border-line-subtle">
								<div
									class="h-full bg-blue transition-all duration-500 rounded-full"
									style="width: <?php echo esc_attr( $continue_course['progress'] ); ?>%;"
								></div>
							</div>
						</div>

						<!-- Action -->
						<div class="pt-2 flex items-center gap-3">
							<a
								href="<?php echo esc_url( $continue_course['continue_url'] ); ?>"
								class="btn btn-primary btn-md shadow-subtle"
							>
								<span><?php echo $continue_course['is_completed'] ? esc_html__( 'مراجعة محتوى الدورة', '3alemni' ) : esc_html__( 'متابعة الدورة الآن', '3alemni' ); ?></span>
								<svg class="size-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
								</svg>
							</a>
							<a
								href="<?php echo esc_url( $continue_course['permalink'] ); ?>"
								class="btn btn-ghost btn-md text-muted hover:text-ink"
							>
								<?php esc_html_e( 'فهرس الدروس', '3alemni' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 4. MY COURSES (RESPONSIVE GRID) -->
	<section class="space-y-5">
		<div class="flex items-center justify-between">
			<div class="flex items-center gap-3">
				<h2 class="text-lg sm:text-xl font-bold text-ink">
					<?php esc_html_e( 'دوراتي التعليمية', '3alemni' ); ?>
				</h2>
				<span class="badge badge-neutral text-xs">
					<?php echo esc_html( number_format_i18n( count( $courses_list ) ) ); ?>
				</span>
			</div>

			<a
				href="<?php echo esc_url( $course_archive_url ); ?>"
				class="btn btn-secondary btn-sm"
			>
				<span><?php esc_html_e( 'استعراض المزيد من الدورات', '3alemni' ); ?></span>
			</a>
		</div>

		<?php if ( ! empty( $courses_list ) ) : ?>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php foreach ( $courses_list as $course ) : ?>
					<article class="card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full">
						<!-- Thumbnail -->
						<a
							href="<?php echo esc_url( $course['permalink'] ); ?>"
							class="block aspect-video w-full bg-paper-subtle overflow-hidden relative group border-b border-line"
						>
							<?php if ( ! empty( $course['thumbnail_url'] ) ) : ?>
								<img
									src="<?php echo esc_url( $course['thumbnail_url'] ); ?>"
									alt="<?php echo esc_attr( $course['title'] ); ?>"
									class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
								>
							<?php else : ?>
								<div class="w-full h-full flex flex-col items-center justify-center text-muted bg-paper-subtle">
									<span class="text-2xl mb-1">📘</span>
									<span class="text-xs font-semibold"><?php esc_html_e( '3alemni Course', '3alemni' ); ?></span>
								</div>
							<?php endif; ?>

							<div class="absolute top-3 right-3 rtl:right-auto rtl:left-3">
								<?php if ( $course['is_completed'] ) : ?>
									<span class="badge badge-success shadow-xs">
										<?php esc_html_e( 'مكتملة', '3alemni' ); ?>
									</span>
								<?php else : ?>
									<span class="badge badge-primary shadow-xs">
										<?php echo esc_html( $course['progress'] ); ?>%
									</span>
								<?php endif; ?>
							</div>
						</a>

						<!-- Body -->
						<div class="p-5 flex-1 flex flex-col justify-between space-y-4">
							<div class="space-y-2">
								<span class="text-xs text-muted block">
									<?php echo esc_html( $course['instructor_name'] ); ?>
								</span>

								<h3 class="text-base font-bold text-ink leading-snug line-clamp-2 hover:text-blue transition">
									<a href="<?php echo esc_url( $course['permalink'] ); ?>">
										<?php echo esc_html( $course['title'] ); ?>
									</a>
								</h3>
							</div>

							<!-- Progress Bar -->
							<div class="space-y-1.5 pt-2 border-t border-line-subtle">
								<div class="flex items-center justify-between text-xs text-muted">
									<span><?php esc_html_e( 'التقدّم', '3alemni' ); ?></span>
									<span class="font-semibold text-ink tabular-nums"><?php echo esc_html( $course['progress'] ); ?>%</span>
								</div>
								<div class="w-full h-1.5 bg-paper rounded-full overflow-hidden">
									<div
										class="h-full bg-blue rounded-full"
										style="width: <?php echo esc_attr( $course['progress'] ); ?>%;"
									></div>
								</div>
							</div>

							<!-- Card Action -->
							<div class="pt-1">
								<a
									href="<?php echo esc_url( $course['continue_url'] ); ?>"
									class="btn btn-secondary btn-sm w-full justify-between"
								>
									<span><?php echo $course['is_completed'] ? esc_html__( 'مراجعة المحتوى', '3alemni' ) : esc_html__( 'متابعة التعلّم', '3alemni' ); ?></span>
									<span class="text-blue rtl:rotate-180">&rarr;</span>
								</a>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

		<?php else : ?>
			<!-- EMPTY STATE: NO ENROLLED COURSES -->
			<div class="card-base bg-white border border-line rounded-xl p-8 sm:p-12 text-center space-y-4 max-w-lg mx-auto shadow-subtle">
				<div class="grid size-14 place-items-center rounded-2xl bg-paper mx-auto text-2xl border border-line">
					🎓
				</div>
				<div class="space-y-1">
					<h3 class="text-lg font-bold text-ink">
						<?php esc_html_e( 'لم تقم بالتسجيل في أي دورة بعد', '3alemni' ); ?>
					</h3>
					<p class="text-xs text-muted leading-relaxed">
						<?php esc_html_e( 'استكشف مساراتنا المتاحة في التكنولوجيا، البرمجة، والتصميم وابدأ في بناء مهاراتك المستقبلية الآن.', '3alemni' ); ?>
					</p>
				</div>
				<div class="pt-2">
					<a
						href="<?php echo esc_url( $course_archive_url ); ?>"
						class="btn btn-primary btn-md shadow-subtle inline-flex"
					>
						<?php esc_html_e( 'تصفح دليل الدورات', '3alemni' ); ?>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</section>

</div>
