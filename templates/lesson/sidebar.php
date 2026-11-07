<?php
/**
 * 3alemni — Lesson Curriculum Sidebar / Off-Canvas Drawer
 *
 * Interactive syllabus browser showing topics, completed states,
 * active indicator, and locked lesson markers with full responsive behavior.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$current_lesson_id = get_the_ID();
$course_id         = function_exists( 'tutor_utils' ) ? (int) tutor_utils()->get_course_id_by_subcontent_id( $current_lesson_id ) : 0;
$user_id           = get_current_user_id();

$is_enrolled      = is_user_logged_in() && function_exists( 'tutor_utils' ) && tutor_utils()->is_enrolled( $course_id, $user_id );
$is_admin         = current_user_can( 'administrator' );
$is_course_author = ( (int) get_post_field( 'post_author', $course_id ) === $user_id );
$can_access_all   = $is_enrolled || $is_admin || $is_course_author;

$topics = ( $course_id && function_exists( 'tutor_utils' ) ) ? tutor_utils()->get_topics( $course_id ) : null;
?>

<!-- Mobile Backdrop Overlay -->
<div id="curriculum-backdrop" class="fixed inset-0 z-40 bg-ink/40 backdrop-blur-xs transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden" aria-hidden="true"></div>

<!-- Off-Canvas Sidebar / Drawer Container -->
<aside
	id="curriculum-sidebar"
	class="fixed inset-y-0 start-0 z-50 w-full max-w-sm sm:w-96 bg-white border-e border-line shadow-2xl flex flex-col transition-transform duration-300 ease-in-out -translate-x-full rtl:translate-x-full lg:static lg:z-10 lg:w-96 lg:shrink-0 lg:translate-x-0 lg:shadow-none lg:border-e lg:border-line/80 h-[calc(100vh-64px)] overflow-hidden"
	aria-label="<?php esc_attr_e( 'فهرس ومحتوى الدورة', '3alemni' ); ?>"
>

	<!-- Drawer Header -->
	<div class="flex items-center justify-between border-b border-line/80 p-4 sm:px-5 bg-paper-subtle">
		<div class="flex items-center gap-2.5">
			<div class="grid size-8 place-items-center rounded-lg bg-blue text-white">
				<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M4 6h16M4 12h16M4 18h7"/>
				</svg>
			</div>
			<div>
				<h2 class="text-sm font-bold text-ink leading-tight">
					<?php esc_html_e( 'محتوى الدورة', '3alemni' ); ?>
				</h2>
				<span class="text-[11px] text-muted block">
					<?php esc_html_e( 'الفصول والدروس التعليمية', '3alemni' ); ?>
				</span>
			</div>
		</div>

		<!-- Mobile Close Button -->
		<button
			type="button"
			id="close-curriculum-btn"
			class="grid size-8 place-items-center rounded-lg border border-line bg-white text-muted hover:text-ink hover:bg-paper transition-colors lg:hidden"
			aria-label="<?php esc_attr_e( 'إغلاق الفهرس', '3alemni' ); ?>"
		>
			<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<line x1="18" y1="6" x2="6" y2="18"/>
				<line x1="6" y1="6" x2="18" y2="18"/>
			</svg>
		</button>
	</div>

	<!-- Scrollable Topics & Lessons List -->
	<div class="flex-1 overflow-y-auto divide-y divide-line/60">
		<?php if ( ! empty( $topics ) && is_iterable( $topics ) ) : ?>
			<?php foreach ( $topics as $topic_idx => $topic ) : ?>
				<?php
				$topic_id = isset( $topic->topic_id ) ? (int) $topic->topic_id : (int) $topic->ID;
				$contents = function_exists( 'tutor_utils' ) ? tutor_utils()->get_course_contents_by_topic( $topic_id ) : null;
				$topic_title = isset( $topic->topic_title ) ? $topic->topic_title : $topic->post_title;

				// Check if current lesson belongs to this topic to open by default
				$contains_current = false;
				$topic_items = array();

				if ( $contents && $contents->have_posts() ) {
					while ( $contents->have_posts() ) {
						$contents->the_post();
						$item_id   = get_the_ID();
						$post_type = get_post_type();

						if ( $item_id === $current_lesson_id ) {
							$contains_current = true;
						}

						$is_completed = ( $user_id && function_exists( 'tutor_utils' ) ) ? tutor_utils()->is_completed_lesson( $item_id, $user_id ) : false;
						$is_preview   = function_exists( 'tutor_utils' ) ? (bool) tutor_utils()->is_preview( $item_id ) : (bool) get_post_meta( $item_id, '_is_preview', true );

						// Runtime
						$duration = '';
						$v_meta = get_post_meta( $item_id, '_video', true );
						if ( is_array( $v_meta ) && ! empty( $v_meta['runtime'] ) ) {
							$rt = $v_meta['runtime'];
							$h = ! empty( $rt['hours'] ) ? (int) $rt['hours'] : 0;
							$m = ! empty( $rt['minutes'] ) ? (int) $rt['minutes'] : 0;
							$s = ! empty( $rt['seconds'] ) ? (int) $rt['seconds'] : 0;
							if ( $h > 0 ) {
								$duration = sprintf( '%d:%02d:%02d', $h, $m, $s );
							} elseif ( $m > 0 || $s > 0 ) {
								$duration = sprintf( '%d:%02d', $m, $s );
							}
						}

						$topic_items[] = array(
							'id'           => $item_id,
							'title'        => get_the_title(),
							'post_type'    => $post_type,
							'permalink'    => get_permalink( $item_id ),
							'is_current'   => ( $item_id === $current_lesson_id ),
							'is_completed' => $is_completed,
							'is_preview'   => $is_preview,
							'duration'     => $duration,
						);
					}
					wp_reset_postdata();
				}
				?>

				<details class="group/topic" <?php echo ( $contains_current || 0 === $topic_idx ) ? 'open' : ''; ?>>
					<summary class="flex items-center justify-between gap-3 p-3.5 sm:px-4 bg-paper/60 cursor-pointer select-none hover:bg-paper transition-colors list-none">
						<div class="flex items-center gap-2 min-w-0">
							<span class="grid size-5 shrink-0 place-items-center rounded bg-white border border-line text-muted transition-transform group-open/topic:rotate-180">
								<svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
							</span>
							<h3 class="text-xs sm:text-sm font-bold text-ink truncate">
								<?php echo esc_html( $topic_title ); ?>
							</h3>
						</div>
						<span class="text-[11px] text-muted shrink-0">
							<?php echo esc_html( sprintf( _n( '%s درس', '%s دروس', count( $topic_items ), '3alemni' ), number_format_i18n( count( $topic_items ) ) ) ); ?>
						</span>
					</summary>

					<!-- Lessons in topic -->
					<div class="divide-y divide-line/30 bg-white">
						<?php foreach ( $topic_items as $item ) : ?>
							<?php
							$can_view = $can_access_all || $item['is_preview'];
							?>
							<div class="flex items-center justify-between gap-2.5 px-4 py-3 text-xs transition-colors <?php echo $item['is_current'] ? 'bg-blue/5 border-s-4 border-blue' : 'hover:bg-paper-subtle'; ?>">
								<div class="flex items-center gap-2.5 min-w-0">
									<!-- Status Icon -->
									<div class="grid size-6 shrink-0 place-items-center rounded-md">
										<?php if ( $item['is_completed'] ) : ?>
											<span class="text-success" title="<?php esc_attr_e( 'مكتمل', '3alemni' ); ?>">
												<svg class="size-4.5 fill-current" viewBox="0 0 20 20">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
												</svg>
											</span>
										<?php elseif ( $item['is_current'] ) : ?>
											<span class="text-blue" title="<?php esc_attr_e( 'الدرس الحالي', '3alemni' ); ?>">
												<svg class="size-4.5 animate-pulse" viewBox="0 0 24 24" fill="currentColor">
													<polygon points="5 3 19 12 5 21 5 3"/>
												</svg>
											</span>
										<?php elseif ( ! $can_view ) : ?>
											<span class="text-muted/60" title="<?php esc_attr_e( 'محتوى مقفل', '3alemni' ); ?>">
												<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
													<path d="M7 11V7a5 5 0 0 1 10 0v4"/>
												</svg>
											</span>
										<?php else : ?>
											<span class="text-muted">
												<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<polygon points="5 3 19 12 5 21 5 3"/>
												</svg>
											</span>
										<?php endif; ?>
									</div>

									<!-- Title / Link -->
									<?php if ( $can_view ) : ?>
										<a
											href="<?php echo esc_url( $item['permalink'] ); ?>"
											class="truncate font-medium <?php echo $item['is_current'] ? 'text-blue font-bold' : 'text-ink hover:text-blue'; ?>"
										>
											<?php echo esc_html( $item['title'] ); ?>
										</a>
									<?php else : ?>
										<span class="truncate font-medium text-muted/80">
											<?php echo esc_html( $item['title'] ); ?>
										</span>
									<?php endif; ?>
								</div>

								<!-- Duration / Preview Pill -->
								<div class="flex items-center gap-1.5 shrink-0">
									<?php if ( $item['is_preview'] && ! $can_access_all ) : ?>
										<span class="rounded bg-blue/10 px-1.5 py-0.5 text-[10px] font-semibold text-blue">
											<?php esc_html_e( 'معاينة', '3alemni' ); ?>
										</span>
									<?php endif; ?>

									<?php if ( ! empty( $item['duration'] ) ) : ?>
										<span class="text-[11px] text-muted" dir="ltr">
											<?php echo esc_html( $item['duration'] ); ?>
										</span>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</details>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="p-6 text-center text-xs text-muted">
				<?php esc_html_e( 'لا توجد دروس مضافة بعد.', '3alemni' ); ?>
			</div>
		<?php endif; ?>
	</div>

</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const sidebar = document.getElementById('curriculum-sidebar');
	const backdrop = document.getElementById('curriculum-backdrop');
	const toggleBtn = document.getElementById('toggle-curriculum-btn');
	const closeBtn = document.getElementById('close-curriculum-btn');

	if (!sidebar) return;

	function openDrawer() {
		sidebar.classList.remove('-translate-x-full', 'rtl:translate-x-full');
		if (backdrop) {
			backdrop.classList.remove('opacity-0', 'pointer-events-none');
			backdrop.classList.add('opacity-100');
		}
		if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
	}

	function closeDrawer() {
		sidebar.classList.add('-translate-x-full', 'rtl:translate-x-full');
		if (backdrop) {
			backdrop.classList.remove('opacity-100');
			backdrop.classList.add('opacity-0', 'pointer-events-none');
		}
		if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
	}

	if (toggleBtn) {
		toggleBtn.addEventListener('click', function () {
			const isClosed = sidebar.classList.contains('-translate-x-full') || sidebar.classList.contains('rtl:translate-x-full');
			if (isClosed) {
				openDrawer();
			} else {
				closeDrawer();
			}
		});
	}

	if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
	if (backdrop) backdrop.addEventListener('click', closeDrawer);
});
</script>
