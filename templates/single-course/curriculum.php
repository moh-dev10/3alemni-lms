<?php
/**
 * 3alemni — Single Course Curriculum Component
 *
 * Displays course topics, lessons, quizzes, and preview badges in an
 * interactive accessible accordion with strict permission enforcement.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();
if ( ! $course_id ) {
	return;
}

$topics = function_exists( 'tutor_utils' ) ? tutor_utils()->get_topics( $course_id ) : null;
if ( empty( $topics ) || ! is_iterable( $topics ) ) {
	return;
}

$user_id = get_current_user_id();
$is_enrolled = is_user_logged_in() && function_exists( 'tutor_utils' ) && tutor_utils()->is_enrolled( $course_id, $user_id );
$is_admin = current_user_can( 'administrator' );
$is_course_author = ( (int) get_post_field( 'post_author', $course_id ) === $user_id );
$can_access_all = $is_enrolled || $is_admin || $is_course_author;

// Tally statistics
$total_topics = 0;
$total_lessons = 0;
$topic_data = array();

foreach ( $topics as $topic ) {
	$topic_id = isset( $topic->topic_id ) ? (int) $topic->topic_id : (int) $topic->ID;
	$contents = function_exists( 'tutor_utils' ) ? tutor_utils()->get_course_contents_by_topic( $topic_id ) : null;

	$content_items = array();
	if ( $contents && $contents->have_posts() ) {
		while ( $contents->have_posts() ) {
			$contents->the_post();
			$item_id   = get_the_ID();
			$post_type = get_post_type();

			$is_preview = false;
			if ( function_exists( 'tutor_utils' ) ) {
				$is_preview = (bool) tutor_utils()->is_preview( $item_id );
			}
			if ( ! $is_preview ) {
				$is_preview = (bool) get_post_meta( $item_id, '_is_preview', true );
			}

			// Lesson duration
			$duration = '';
			$video_meta = get_post_meta( $item_id, '_video', true );
			if ( is_array( $video_meta ) && ! empty( $video_meta['runtime'] ) ) {
				$runtime = $video_meta['runtime'];
				$h = ! empty( $runtime['hours'] ) ? (int) $runtime['hours'] : 0;
				$m = ! empty( $runtime['minutes'] ) ? (int) $runtime['minutes'] : 0;
				$s = ! empty( $runtime['seconds'] ) ? (int) $runtime['seconds'] : 0;
				if ( $h > 0 ) {
					$duration = sprintf( '%d:%02d:%02d', $h, $m, $s );
				} elseif ( $m > 0 || $s > 0 ) {
					$duration = sprintf( '%d:%02d', $m, $s );
				}
			}

			$content_items[] = array(
				'id'         => $item_id,
				'title'      => get_the_title(),
				'post_type'  => $post_type,
				'is_preview' => $is_preview,
				'duration'   => $duration,
				'permalink'  => get_permalink( $item_id ),
			);

			$total_lessons++;
		}
		wp_reset_postdata();
	}

	$topic_data[] = array(
		'id'          => $topic_id,
		'title'       => isset( $topic->topic_title ) ? $topic->topic_title : $topic->post_title,
		'summary'     => isset( $topic->topic_summary ) ? $topic->topic_summary : '',
		'items'       => $content_items,
		'items_count' => count( $content_items ),
	);

	$total_topics++;
}

if ( 0 === $total_topics ) {
	return;
}
?>

<section class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-xs" aria-labelledby="curriculum-heading">

	<!-- Section Header -->
	<div class="mb-6 flex flex-wrap items-center justify-between gap-4 border-b border-line/60 pb-5">
		<div>
			<div class="flex items-center gap-2.5">
				<div class="grid size-9 place-items-center rounded-xl bg-paper text-ink">
					<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
					</svg>
				</div>
				<h2 id="curriculum-heading" class="text-lg sm:text-xl font-bold text-ink">
					<?php esc_html_e( 'محتوى الدورة', '3alemni' ); ?>
				</h2>
			</div>

			<!-- Meta summary stats -->
			<p class="mt-2 text-xs sm:text-sm text-muted">
				<span><?php echo esc_html( sprintf( _n( 'فصل واحد', '%s فصول', $total_topics, '3alemni' ), number_format_i18n( $total_topics ) ) ); ?></span>
				<span class="mx-1.5 text-line">&bull;</span>
				<span><?php echo esc_html( sprintf( _n( 'درس واحد', '%s درساً', $total_lessons, '3alemni' ), number_format_i18n( $total_lessons ) ) ); ?></span>
			</p>
		</div>

		<!-- Expand / Collapse All Toggle -->
		<button
			type="button"
			id="toggle-all-topics"
			class="inline-flex items-center gap-1.5 rounded-lg border border-line bg-paper-subtle px-3 py-1.5 text-xs font-semibold text-ink-secondary hover:border-blue/30 hover:bg-white hover:text-blue transition-colors"
			data-state="collapsed"
		>
			<svg class="size-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<polyline points="7 13 12 18 17 13"/>
				<polyline points="7 6 12 11 17 6"/>
			</svg>
			<span class="toggle-text"><?php esc_html_e( 'توسيع الكل', '3alemni' ); ?></span>
		</button>
	</div>

	<!-- Curriculum Topics List -->
	<div class="space-y-3.5" id="course-curriculum-accordion">
		<?php foreach ( $topic_data as $idx => $t_data ) : ?>
			<?php $is_first = ( 0 === $idx ); ?>
			<details class="topic-item group rounded-xl border border-line bg-surface overflow-hidden transition-all duration-200 open:border-blue/30 open:shadow-xs" <?php echo $is_first ? 'open' : ''; ?>>
				<summary class="flex cursor-pointer items-center justify-between gap-4 bg-paper-subtle p-4 sm:p-5 select-none transition-colors hover:bg-paper list-none">
					<div class="flex items-center gap-3">
						<!-- Chevron indicator -->
						<span class="grid size-6 place-items-center rounded-md bg-white border border-line/60 text-muted transition-transform duration-200 group-open:rotate-180 group-open:text-blue">
							<svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<polyline points="6 9 12 15 18 9"/>
							</svg>
						</span>

						<!-- Topic Title & Index -->
						<div>
							<h3 class="text-sm sm:text-base font-bold text-ink">
								<span class="text-muted ml-1"><?php echo esc_html( sprintf( __( 'الفصل %d:', '3alemni' ), $idx + 1 ) ); ?></span>
								<?php echo esc_html( $t_data['title'] ); ?>
							</h3>
							<?php if ( ! empty( $t_data['summary'] ) ) : ?>
								<p class="mt-0.5 text-xs text-muted max-w-xl truncate">
									<?php echo esc_html( $t_data['summary'] ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>

					<!-- Lesson count badge -->
					<div class="shrink-0 text-xs font-medium text-muted">
						<?php echo esc_html( sprintf( _n( 'درس واحد', '%s دروس', $t_data['items_count'], '3alemni' ), number_format_i18n( $t_data['items_count'] ) ) ); ?>
					</div>
				</summary>

				<!-- Topic Lessons / Contents -->
				<?php if ( ! empty( $t_data['items'] ) ) : ?>
					<div class="divide-y divide-line/40 border-t border-line/60 bg-white">
						<?php foreach ( $t_data['items'] as $item ) : ?>
							<?php
							$can_view = $can_access_all || $item['is_preview'];
							?>
							<div class="flex items-center justify-between gap-4 p-3.5 sm:px-5 sm:py-3.5 text-xs sm:text-sm transition-colors hover:bg-paper-subtle/70">
								<!-- Title & Type Icon -->
								<div class="flex items-center gap-3 min-w-0">
									<!-- Content Type Icon -->
									<div class="grid size-7 shrink-0 place-items-center rounded-lg <?php echo $can_view ? 'bg-blue/10 text-blue' : 'bg-paper text-muted'; ?>">
										<?php if ( 'tutor_quiz' === $item['post_type'] ) : ?>
											<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
												<circle cx="12" cy="12" r="10"/>
												<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
												<line x1="12" y1="17" x2="12.01" y2="17"/>
											</svg>
										<?php elseif ( 'tutor_assignments' === $item['post_type'] ) : ?>
											<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
												<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
												<polyline points="14 2 14 8 20 8"/>
												<line x1="16" y1="13" x2="8" y2="13"/>
												<line x1="16" y1="17" x2="8" y2="17"/>
												<polyline points="10 9 9 9 8 9"/>
											</svg>
										<?php else : ?>
											<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
												<polygon points="5 3 19 12 5 21 5 3"/>
											</svg>
										<?php endif; ?>
									</div>

									<!-- Lesson Title / Accessible Link -->
									<?php if ( $can_view ) : ?>
										<a href="<?php echo esc_url( $item['permalink'] ); ?>" class="truncate font-medium text-ink hover:text-blue transition-colors">
											<?php echo esc_html( $item['title'] ); ?>
										</a>
									<?php else : ?>
										<span class="truncate font-medium text-ink-secondary">
											<?php echo esc_html( $item['title'] ); ?>
										</span>
									<?php endif; ?>
								</div>

								<!-- Badges & Lock / Duration -->
								<div class="flex items-center gap-3 shrink-0">
									<?php if ( $item['is_preview'] && ! $can_access_all ) : ?>
										<a
											href="<?php echo esc_url( $item['permalink'] ); ?>"
											class="inline-flex items-center gap-1 rounded-full border border-blue/20 bg-blue/10 px-2.5 py-0.5 text-[11px] font-semibold text-blue hover:bg-blue hover:text-white transition-colors"
										>
											<svg class="size-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
												<polygon points="5 3 19 12 5 21 5 3"/>
											</svg>
											<?php esc_html_e( 'معاينة مجانية', '3alemni' ); ?>
										</a>
									<?php endif; ?>

									<?php if ( ! empty( $item['duration'] ) ) : ?>
										<span class="text-xs text-muted" dir="ltr">
											<?php echo esc_html( $item['duration'] ); ?>
										</span>
									<?php endif; ?>

									<?php if ( ! $can_view ) : ?>
										<span class="text-muted" title="<?php esc_attr_e( 'محتوى مخصص للمسجلين فقط', '3alemni' ); ?>" aria-label="<?php esc_attr_e( 'مغلق', '3alemni' ); ?>">
											<svg class="size-4 text-muted/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
												<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
												<path d="M7 11V7a5 5 0 0 1 10 0v4"/>
											</svg>
										</span>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</details>
		<?php endforeach; ?>
	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const toggleBtn = document.getElementById('toggle-all-topics');
	const accordion = document.getElementById('course-curriculum-accordion');
	if (!toggleBtn || !accordion) return;

	toggleBtn.addEventListener('click', function () {
		const details = accordion.querySelectorAll('details');
		const isCollapsed = toggleBtn.getAttribute('data-state') === 'collapsed';

		details.forEach(function (detail) {
			detail.open = isCollapsed;
		});

		toggleBtn.setAttribute('data-state', isCollapsed ? 'expanded' : 'collapsed');
		const label = toggleBtn.querySelector('.toggle-text');
		if (label) {
			label.textContent = isCollapsed ? '<?php echo esc_js( __( 'طي الكل', '3alemni' ) ); ?>' : '<?php echo esc_js( __( 'توسيع الكل', '3alemni' ) ); ?>';
		}
	});
});
</script>
