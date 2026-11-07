<?php
/**
 * 3alemni — Premium Student My Courses Template
 *
 * Renders the authenticated student's courses page:
 * - Page Header with title, context description, course counter badge & search input
 * - Category filter pills: All, In Progress, Completed (with real counts)
 * - Responsive 3-column course card grid
 * - Instant client-side search & filtering with no-JS fallback
 * - Polished empty states: no enrolled courses, no filter matches, no search matches
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$user_id      = get_current_user_id();
$current_user = wp_get_current_user();

if ( ! $user_id ) {
	return;
}

$display_name = function_exists( 'tutor_utils' )
	? tutor_utils()->display_name( $user_id )
	: ( $current_user->display_name ?: $current_user->user_login );

// Determine initial filter from URL sub_page or GET param
global $wp_query;
$sub_page = isset( $wp_query->query_vars['tutor_dashboard_sub_page'] )
	? sanitize_key( $wp_query->query_vars['tutor_dashboard_sub_page'] )
	: '';

if ( empty( $sub_page ) && isset( $_GET['filter'] ) ) {
	$sub_page = sanitize_key( wp_unslash( $_GET['filter'] ) );
}

$initial_filter = 'all';
if ( in_array( $sub_page, array( 'active', 'in-progress', 'in_progress' ), true ) ) {
	$initial_filter = 'in-progress';
} elseif ( 'completed' === $sub_page ) {
	$initial_filter = 'completed';
}

$initial_search = isset( $_GET['search'] ) ? sanitize_text_field( wp_unslash( $_GET['search'] ) ) : '';

// Retrieve enrolled courses for student
$enrolled_courses = null;
if ( function_exists( 'tutor_utils' ) ) {
	$enrolled_courses = tutor_utils()->get_enrolled_courses_by_user( $user_id );
}

$courses_list      = array();
$enrolled_count    = 0;
$in_progress_count = 0;
$completed_count   = 0;

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
			$status_key = 'completed';
		} else {
			$in_progress_count++;
			$status_key = 'in-progress';
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

		// Lessons count if available
		$total_lessons = function_exists( 'tutor_utils' ) && method_exists( tutor_utils(), 'get_lesson_count_by_course' )
			? (int) tutor_utils()->get_lesson_count_by_course( $course_id )
			: 0;

		$completed_lessons = function_exists( 'tutor_utils' ) && method_exists( tutor_utils(), 'get_completed_lesson_count_by_course' )
			? (int) tutor_utils()->get_completed_lesson_count_by_course( $course_id, $user_id )
			: 0;

		// Instructor name
		$instructor_name = function_exists( 'tutor_utils' ) && method_exists( tutor_utils(), 'get_instructor_name' )
			? tutor_utils()->get_instructor_name( $course_id )
			: get_the_author();

		$courses_list[] = array(
			'id'                => $course_id,
			'title'             => get_the_title(),
			'permalink'         => get_permalink( $course_id ),
			'continue_url'      => $continue_url,
			'thumbnail_url'     => get_the_post_thumbnail_url( $course_id, 'medium_large' ),
			'instructor_name'   => $instructor_name,
			'progress'          => $progress,
			'status'            => $status_key,
			'is_completed'      => $is_completed,
			'lesson_title'      => $lesson_title,
			'total_lessons'     => $total_lessons,
			'completed_lessons' => $completed_lessons,
		);
	}
	wp_reset_postdata();
}

$course_archive_url = function_exists( 'tutor_utils' )
	? tutor_utils()->course_archive_page_url()
	: home_url( '/courses/' );
?>

<div
	class="alemni-my-courses-page space-y-7"
	dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>"
	id="alemni-my-courses-app"
>

	<!-- 1. PAGE HEADER -->
	<header class="card-base bg-white border border-line p-6 sm:p-7 rounded-xl shadow-subtle">
		<div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
			<!-- Title & Context -->
			<div class="space-y-1.5 max-w-xl">
				<div class="flex items-center gap-2.5">
					<h1 class="text-2xl sm:text-3xl font-bold text-ink tracking-tight">
						<?php esc_html_e( 'دوراتي', '3alemni' ); ?>
					</h1>
					<span class="badge badge-primary text-xs font-bold tabular-nums" id="enrolled-badge-count">
						<?php
						/* translators: %s: number of courses */
						printf( esc_html( _n( '%s دورة', '%s دورات', $enrolled_count, '3alemni' ) ), esc_html( number_format_i18n( $enrolled_count ) ) );
						?>
					</span>
				</div>
				<p class="text-xs sm:text-sm text-muted leading-relaxed">
					<?php esc_html_e( 'تابع تقدّمك الدراسي، استكمل دروسك، واستعرض شهاداتك في مكان واحد.', '3alemni' ); ?>
				</p>
			</div>

			<!-- Search Input -->
			<div class="w-full md:w-80 shrink-0 relative">
				<div class="relative">
					<span class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-muted">
						<svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
						</svg>
					</span>
					<input
						type="search"
						id="course-search-input"
						class="input-field ps-10 pe-9 text-xs sm:text-sm"
						placeholder="<?php esc_attr_e( 'ابحث في دوراتك بالعنوان أو المدرّب...', '3alemni' ); ?>"
						value="<?php echo esc_attr( $initial_search ); ?>"
						aria-label="<?php esc_attr_e( 'بحث في الدورات', '3alemni' ); ?>"
						autocomplete="off"
					>
					<button
						type="button"
						id="course-search-clear"
						class="absolute inset-y-0 end-0 flex items-center pe-3 text-muted hover:text-ink transition hidden"
						aria-label="<?php esc_attr_e( 'مسح البحث', '3alemni' ); ?>"
					>
						<svg class="size-4" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
						</svg>
					</button>
				</div>
			</div>
		</div>
	</header>

	<!-- 2. COURSE FILTERS -->
	<nav
		class="flex items-center justify-between flex-wrap gap-3 border-b border-line pb-3"
		aria-label="<?php esc_attr_e( 'تصفية الدورات', '3alemni' ); ?>"
	>
		<div class="flex items-center gap-2" role="tablist">
			<!-- All Courses Tab -->
			<button
				type="button"
				role="tab"
				data-filter="all"
				aria-selected="<?php echo ( 'all' === $initial_filter ) ? 'true' : 'false'; ?>"
				class="filter-tab-btn btn btn-sm rounded-lg transition <?php echo ( 'all' === $initial_filter ) ? 'btn-primary' : 'btn-secondary text-ink-secondary'; ?>"
			>
				<span><?php esc_html_e( 'جميع الدورات', '3alemni' ); ?></span>
				<span class="text-[11px] opacity-80 tabular-nums">(<?php echo esc_html( number_format_i18n( $enrolled_count ) ); ?>)</span>
			</button>

			<!-- In Progress Tab -->
			<button
				type="button"
				role="tab"
				data-filter="in-progress"
				aria-selected="<?php echo ( 'in-progress' === $initial_filter ) ? 'true' : 'false'; ?>"
				class="filter-tab-btn btn btn-sm rounded-lg transition <?php echo ( 'in-progress' === $initial_filter ) ? 'btn-primary' : 'btn-secondary text-ink-secondary'; ?>"
			>
				<span><?php esc_html_e( 'قيد التعلّم', '3alemni' ); ?></span>
				<span class="text-[11px] opacity-80 tabular-nums">(<?php echo esc_html( number_format_i18n( $in_progress_count ) ); ?>)</span>
			</button>

			<!-- Completed Tab -->
			<button
				type="button"
				role="tab"
				data-filter="completed"
				aria-selected="<?php echo ( 'completed' === $initial_filter ) ? 'true' : 'false'; ?>"
				class="filter-tab-btn btn btn-sm rounded-lg transition <?php echo ( 'completed' === $initial_filter ) ? 'btn-primary' : 'btn-secondary text-ink-secondary'; ?>"
			>
				<span><?php esc_html_e( 'المكتملة', '3alemni' ); ?></span>
				<span class="text-[11px] opacity-80 tabular-nums">(<?php echo esc_html( number_format_i18n( $completed_count ) ); ?>)</span>
			</button>
		</div>

		<!-- Link to catalog -->
		<a
			href="<?php echo esc_url( $course_archive_url ); ?>"
			class="text-xs font-semibold text-blue hover:text-blue-dark transition flex items-center gap-1.5"
		>
			<span><?php esc_html_e( 'استكشاف دورات جديدة', '3alemni' ); ?></span>
			<span class="rtl:rotate-180 text-sm">&rarr;</span>
		</a>
	</nav>

	<!-- 3. COURSE GRID -->
	<div
		id="courses-grid"
		class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
	>
		<?php if ( ! empty( $courses_list ) ) : ?>
			<?php foreach ( $courses_list as $course ) : ?>
				<?php
				$is_match_filter = ( 'all' === $initial_filter || $course['status'] === $initial_filter );
				$display_class   = $is_match_filter ? '' : 'hidden';
				?>
				<article
					class="course-card-item card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full <?php echo esc_attr( $display_class ); ?>"
					data-course-id="<?php echo esc_attr( $course['id'] ); ?>"
					data-course-status="<?php echo esc_attr( $course['status'] ); ?>"
					data-course-title="<?php echo esc_attr( mb_strtolower( $course['title'], 'UTF-8' ) ); ?>"
					data-course-instructor="<?php echo esc_attr( mb_strtolower( $course['instructor_name'], 'UTF-8' ) ); ?>"
				>
					<!-- Thumbnail & Status Badge -->
					<a
						href="<?php echo esc_url( $course['permalink'] ); ?>"
						class="block aspect-video w-full bg-paper-subtle overflow-hidden relative group border-b border-line"
						tabindex="-1"
						aria-hidden="true"
					>
						<?php if ( ! empty( $course['thumbnail_url'] ) ) : ?>
							<img
								src="<?php echo esc_url( $course['thumbnail_url'] ); ?>"
								alt="<?php echo esc_attr( $course['title'] ); ?>"
								class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
								loading="lazy"
							>
						<?php else : ?>
							<div class="w-full h-full flex flex-col items-center justify-center text-muted bg-paper-subtle">
								<span class="text-3xl mb-1">📘</span>
								<span class="text-xs font-semibold"><?php esc_html_e( 'علّمني', '3alemni' ); ?></span>
							</div>
						<?php endif; ?>

						<!-- Top Floating Status Badge -->
						<div class="absolute top-3 right-3 rtl:right-auto rtl:left-3">
							<?php if ( $course['is_completed'] ) : ?>
								<span class="badge badge-success shadow-xs font-bold text-xs">
									<?php esc_html_e( 'مكتملة 100%', '3alemni' ); ?>
								</span>
							<?php else : ?>
								<span class="badge badge-primary shadow-xs font-bold text-xs tabular-nums">
									<?php echo esc_html( $course['progress'] ); ?>%
								</span>
							<?php endif; ?>
						</div>
					</a>

					<!-- Card Body -->
					<div class="p-5 flex-1 flex flex-col justify-between space-y-4">
						<div class="space-y-2">
							<!-- Instructor -->
							<div class="flex items-center gap-1.5 text-xs text-muted">
								<svg class="size-3.5 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
								</svg>
								<span class="truncate"><?php echo esc_html( $course['instructor_name'] ); ?></span>
							</div>

							<!-- Title -->
							<h3 class="text-base font-bold text-ink leading-snug line-clamp-2 hover:text-blue transition">
								<a href="<?php echo esc_url( $course['permalink'] ); ?>">
									<?php echo esc_html( $course['title'] ); ?>
								</a>
							</h3>
						</div>

						<!-- Lesson indicator if ongoing -->
						<?php if ( ! empty( $course['lesson_title'] ) && ! $course['is_completed'] ) : ?>
							<div class="p-2.5 bg-paper-subtle rounded-lg border border-line-subtle text-xs flex items-center gap-2 text-ink">
								<span class="size-1.5 rounded-full bg-blue shrink-0"></span>
								<span class="text-muted shrink-0"><?php esc_html_e( 'الدرس التالي:', '3alemni' ); ?></span>
								<strong class="truncate max-w-[170px]"><?php echo esc_html( $course['lesson_title'] ); ?></strong>
							</div>
						<?php endif; ?>

						<!-- Progress Section -->
						<div class="space-y-1.5 pt-2 border-t border-line-subtle">
							<div class="flex items-center justify-between text-xs text-muted">
								<span>
									<?php echo $course['is_completed'] ? esc_html__( 'حالة الإنجاز', '3alemni' ) : esc_html__( 'نسبة التقدّم', '3alemni' ); ?>
								</span>
								<strong class="text-ink tabular-nums">
									<?php
									if ( $course['is_completed'] ) {
										esc_html_e( 'مكتملة بالكامل', '3alemni' );
									} elseif ( $course['total_lessons'] > 0 ) {
										/* translators: 1: completed lessons, 2: total lessons */
										printf( esc_html__( '%1$s من %2$s درساً', '3alemni' ), esc_html( number_format_i18n( $course['completed_lessons'] ) ), esc_html( number_format_i18n( $course['total_lessons'] ) ) );
									} else {
										echo esc_html( $course['progress'] ) . '%';
									}
									?>
								</strong>
							</div>

							<!-- Progress Bar -->
							<div class="w-full h-2 bg-paper rounded-full overflow-hidden border border-line-subtle">
								<div
									class="h-full rounded-full transition-all duration-500 <?php echo $course['is_completed'] ? 'bg-success' : 'bg-blue'; ?>"
									style="width: <?php echo esc_attr( $course['progress'] ); ?>%;"
								></div>
							</div>
						</div>

						<!-- Action Button -->
						<div class="pt-1">
							<a
								href="<?php echo esc_url( $course['continue_url'] ); ?>"
								class="btn btn-secondary btn-sm w-full justify-between group-hover:border-line-strong"
							>
								<span>
									<?php
									echo $course['is_completed']
										? esc_html__( 'مراجعة محتوى الدورة', '3alemni' )
										: esc_html__( 'متابعة التعلّم', '3alemni' );
									?>
								</span>
								<span class="text-blue rtl:rotate-180">&rarr;</span>
							</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<!-- 4. EMPTY STATES -->

	<!-- Empty State A: No enrolled courses at all -->
	<div
		id="empty-state-no-enrolled"
		class="card-base bg-white border border-line rounded-xl p-8 sm:p-14 text-center space-y-4 max-w-lg mx-auto shadow-subtle <?php echo ( 0 === $enrolled_count ) ? '' : 'hidden'; ?>"
	>
		<div class="grid size-16 place-items-center rounded-2xl bg-paper mx-auto text-3xl border border-line">
			🎓
		</div>
		<div class="space-y-1.5">
			<h2 class="text-xl font-bold text-ink">
				<?php esc_html_e( 'لم تقم بالتسجيل في أي دورة بعد', '3alemni' ); ?>
			</h2>
			<p class="text-xs sm:text-sm text-muted leading-relaxed">
				<?php esc_html_e( 'استكشف مساراتنا المعتمدة في البرمجة، التصميم، والتكنولوجيا وابدأ مسيرتك المهنية الآن.', '3alemni' ); ?>
			</p>
		</div>
		<div class="pt-2">
			<a
				href="<?php echo esc_url( $course_archive_url ); ?>"
				class="btn btn-primary btn-md shadow-subtle inline-flex"
			>
				<span><?php esc_html_e( 'تصفح دليل الدورات المتاحة', '3alemni' ); ?></span>
				<span class="rtl:rotate-180">&rarr;</span>
			</a>
		</div>
	</div>

	<!-- Empty State B: No matches for search query -->
	<div
		id="empty-state-search"
		class="card-base bg-white border border-line rounded-xl p-8 sm:p-12 text-center space-y-4 max-w-md mx-auto shadow-subtle hidden"
	>
		<div class="grid size-14 place-items-center rounded-2xl bg-paper mx-auto text-2xl border border-line">
			🔍
		</div>
		<div class="space-y-1.5">
			<h2 class="text-lg font-bold text-ink">
				<?php esc_html_e( 'لم نجد أي دورة مطابقة', '3alemni' ); ?>
			</h2>
			<p class="text-xs text-muted leading-relaxed" id="empty-search-message">
				<?php esc_html_e( 'لا توجد نتائج مطابقة لبحثك الحالي. حاول استخدام كلمات مفتاحية أخرى أو إعادة ضبط التصفية.', '3alemni' ); ?>
			</p>
		</div>
		<div class="pt-1">
			<button
				type="button"
				id="btn-reset-search"
				class="btn btn-secondary btn-sm inline-flex"
			>
				<?php esc_html_e( 'إعادة ضبط البحث', '3alemni' ); ?>
			</button>
		</div>
	</div>

	<!-- Empty State C: No courses in selected filter -->
	<div
		id="empty-state-filter"
		class="card-base bg-white border border-line rounded-xl p-8 sm:p-12 text-center space-y-4 max-w-md mx-auto shadow-subtle hidden"
	>
		<div class="grid size-14 place-items-center rounded-2xl bg-paper mx-auto text-2xl border border-line">
			📂
		</div>
		<div class="space-y-1.5">
			<h2 class="text-lg font-bold text-ink" id="empty-filter-title">
				<?php esc_html_e( 'لا توجد دورات في هذا القسم', '3alemni' ); ?>
			</h2>
			<p class="text-xs text-muted leading-relaxed" id="empty-filter-message">
				<?php esc_html_e( 'لم تسجل بعد أي تقدم في هذا التصنيف. يمكنك استعراض كافة دوراتك التعليمية.', '3alemni' ); ?>
			</p>
		</div>
		<div class="pt-1 flex items-center justify-center gap-2">
			<button
				type="button"
				id="btn-view-all-filter"
				class="btn btn-primary btn-sm inline-flex"
			>
				<?php esc_html_e( 'عرض جميع الدورات', '3alemni' ); ?>
			</button>
		</div>
	</div>

</div>

<!-- 5. CLIENT-SIDE SEARCH & FILTER CONTROLLER -->
<script>
(function() {
	var currentFilter = '<?php echo esc_js( $initial_filter ); ?>';
	var searchInput = document.getElementById('course-search-input');
	var clearBtn = document.getElementById('course-search-clear');
	var filterBtns = document.querySelectorAll('.filter-tab-btn');
	var cards = document.querySelectorAll('.course-card-item');
	var emptySearch = document.getElementById('empty-state-search');
	var emptyFilter = document.getElementById('empty-state-filter');
	var emptyEnrolled = document.getElementById('empty-state-no-enrolled');
	var emptySearchMsg = document.getElementById('empty-search-message');
	var resetSearchBtn = document.getElementById('btn-reset-search');
	var viewAllBtn = document.getElementById('btn-view-all-filter');

	if (!cards.length) {
		return;
	}

	function applyFilterAndSearch() {
		var query = (searchInput ? searchInput.value : '').trim().toLowerCase();
		var visibleCount = 0;
		var filterMatchCount = 0;

		if (clearBtn) {
			clearBtn.classList.toggle('hidden', query.length === 0);
		}

		cards.forEach(function(card) {
			var cardStatus = card.getAttribute('data-course-status') || '';
			var cardTitle = card.getAttribute('data-course-title') || '';
			var cardInstructor = card.getAttribute('data-course-instructor') || '';

			var matchesFilter = (currentFilter === 'all' || cardStatus === currentFilter);
			if (matchesFilter) {
				filterMatchCount++;
			}

			var matchesSearch = (query.length === 0 || cardTitle.indexOf(query) !== -1 || cardInstructor.indexOf(query) !== -1);

			if (matchesFilter && matchesSearch) {
				card.classList.remove('hidden');
				visibleCount++;
			} else {
				card.classList.add('hidden');
			}
		});

		// Manage Empty States
		if (emptySearch) {
			emptySearch.classList.add('hidden');
		}
		if (emptyFilter) {
			emptyFilter.classList.add('hidden');
		}

		if (visibleCount === 0) {
			if (query.length > 0) {
				if (emptySearch) {
					emptySearch.classList.remove('hidden');
					if (emptySearchMsg) {
						emptySearchMsg.textContent = 'لم نعثر على أي دورة تطابق "' + query + '". جرب البحث باسم آخر.';
					}
				}
			} else if (filterMatchCount === 0) {
				if (emptyFilter) {
					emptyFilter.classList.remove('hidden');
				}
			}
		}
	}

	// Filter Tabs Click
	filterBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var targetFilter = this.getAttribute('data-filter') || 'all';
			currentFilter = targetFilter;

			filterBtns.forEach(function(b) {
				var isActive = (b.getAttribute('data-filter') === targetFilter);
				b.setAttribute('aria-selected', isActive ? 'true' : 'false');
				if (isActive) {
					b.classList.remove('btn-secondary', 'text-ink-secondary');
					b.classList.add('btn-primary');
				} else {
					b.classList.remove('btn-primary');
					b.classList.add('btn-secondary', 'text-ink-secondary');
				}
			});

			applyFilterAndSearch();
		});
	});

	// Search Input Handling
	if (searchInput) {
		searchInput.addEventListener('input', applyFilterAndSearch);
	}

	if (clearBtn) {
		clearBtn.addEventListener('click', function() {
			searchInput.value = '';
			searchInput.focus();
			applyFilterAndSearch();
		});
	}

	if (resetSearchBtn) {
		resetSearchBtn.addEventListener('click', function() {
			if (searchInput) {
				searchInput.value = '';
			}
			applyFilterAndSearch();
		});
	}

	if (viewAllBtn) {
		viewAllBtn.addEventListener('click', function() {
			var allBtn = document.querySelector('.filter-tab-btn[data-filter="all"]');
			if (allBtn) {
				allBtn.click();
			}
		});
	}

	// Initial Run
	applyFilterAndSearch();
})();
</script>
