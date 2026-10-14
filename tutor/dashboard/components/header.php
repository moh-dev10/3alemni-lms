
<?php
/**
 * 3alemni Custom Tutor Dashboard Header.
 *
 * Preserves Tutor LMS account actions, instructor statistics,
 * profile switching and dropdown behavior.
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;

use Tutor\Components\Avatar;
use Tutor\Components\Button;
use Tutor\Components\Constants\Size;
use Tutor\Components\Constants\Variant;
use Tutor\Components\Constants\Color;
use Tutor\Components\SvgIcon;
use TUTOR\Dashboard;
use TUTOR\Icon;
use TUTOR\Instructors_List;
use TUTOR\User;
use Tutor\Models\CourseModel;

$menu_items = Dashboard::get_account_pages();

$menu_items['logout'] = array(
	'title' => esc_html__( 'Logout', 'tutor' ),
	'icon'  => Icon::LOGOUT,
	'url'   => wp_logout_url( tutor_utils()->tutor_dashboard_url() ),
);

$active_nav                   = '';
$user_id                      = get_current_user_id();
$display_name                 = tutor_utils()->display_name( $user_id );
$current_user                 = wp_get_current_user();
$edit_profile_url             = Dashboard::get_account_page_url( 'settings' ) . '?tab=account';
$is_become_instructor_enabled = tutor_utils()->get_option( 'enable_become_instructor_btn' );
$is_instructor_view           = User::is_instructor_view();
$is_kids_mode                 = tutor_utils()->is_kids_mode();
$avatar_size                  = Size::SIZE_32;
$profile_avatar_size           = Size::SIZE_48;
?>

<header
	x-data="tutorHeader()"
	class="alemni-dashboard-header tutor-dashboard-header"
>
	<div class="alemni-dashboard-header-inner tutor-dashboard-header-inner">

		<div class="alemni-dashboard-header-left tutor-dashboard-header-left">

			<div class="alemni-dashboard-heading">
				<span class="alemni-dashboard-eyebrow">
					<?php esc_html_e( 'YOUR LEARNING SPACE', 'tutor' ); ?>
				</span>

				<h1 class="alemni-dashboard-greeting">
					<span class="alemni-dashboard-greeting-muted">
						<?php echo esc_html_x( 'Hi,', 'greetings', 'tutor' ); ?>
					</span>
					<?php echo esc_html( $display_name ); ?>
					<span class="alemni-dashboard-greeting-emoji" aria-hidden="true">👋</span>
				</h1>

				<?php if ( $is_instructor_view ) : ?>

					<?php
					$course_post_type = apply_filters(
						'tutor_dashboard_course_list_post_type',
						array( tutor()->course_post_type )
					);

					$active_course_count = CourseModel::get_courses_by_instructor(
						$user_id,
						CourseModel::STATUS_PUBLISH,
						0,
						0,
						true,
						$course_post_type,
						''
					);

					$enrolled_student_count = (int) tutor_utils()->get_total_students_by_instructor( $user_id );
					?>

					<div class="alemni-dashboard-header-stats">

						<span class="alemni-dashboard-stat">
							<span class="alemni-dashboard-stat-value">
								<?php echo esc_html( number_format_i18n( $active_course_count ) ); ?>
							</span>

							<?php
							echo esc_html(
								_n(
									'active course',
									'active courses',
									$active_course_count,
									'tutor'
								)
							);
							?>
						</span>

						<span class="alemni-dashboard-stat-separator" aria-hidden="true"></span>

						<span class="alemni-dashboard-stat">
							<span class="alemni-dashboard-stat-value">
								<?php echo esc_html( number_format_i18n( $enrolled_student_count ) ); ?>
							</span>

							<?php
							echo esc_html(
								_n(
									'enrolled student',
									'enrolled students',
									$enrolled_student_count,
									'tutor'
								)
							);
							?>
						</span>

					</div>

				<?php else : ?>

					<p class="alemni-dashboard-subtitle">
						<?php esc_html_e( 'Continue your learning journey at your own pace.', 'tutor' ); ?>
					</p>

				<?php endif; ?>
			</div>

		</div>

		<div class="alemni-dashboard-header-right tutor-dashboard-header-right">

			<div class="alemni-dashboard-header-actions">
				<?php
				/**
				 * Preserve Tutor LMS extension points.
				 */
				do_action( 'tutor_dashboard/before_header_button' );
				?>
			</div>

			<div
				x-data="tutorPopover({
					placement: 'bottom-end',
					offset: 8,
				})"
				class="alemni-dashboard-account tutor-dashboard-header-user"
			>
				<button
					type="button"
					class="alemni-dashboard-account-trigger tutor-dashboard-header-user-avatar"
					x-ref="trigger"
					@click="toggle()"
					:class="{ 'active': open }"
					:aria-expanded="open.toString()"
					aria-haspopup="true"
					aria-label="<?php esc_attr_e( 'Open user menu', 'tutor' ); ?>"
					x-init="$watch('open', value => {
						if (window.innerWidth <= 768) {
							document.body.style.overflow = value ? 'hidden' : '';
						}
					})"
					@resize.window="
						if (window.innerWidth <= 768 && open) {
							document.body.style.overflow = 'hidden';
						} else {
							document.body.style.overflow = '';
						}
					"
				>
					<span class="alemni-dashboard-account-avatar">
						<?php
						Avatar::make()
							->user( $user_id )
							->size( $avatar_size )
							->render();
						?>
					</span>

					<span class="alemni-dashboard-account-identity">
						<span class="alemni-dashboard-account-name">
							<?php echo esc_html( $display_name ); ?>
						</span>

						<span class="alemni-dashboard-account-role">
							<?php
							echo esc_html(
								$is_instructor_view
									? __( 'Instructor', 'tutor' )
									: __( 'Learner', 'tutor' )
							);
							?>
						</span>
					</span>

					<span class="alemni-dashboard-account-chevron" aria-hidden="true">
						<?php
						SvgIcon::make()
							->name( Icon::CHEVRON_DOWN )
							->size( Size::SIZE_16 )
							->render();
						?>
					</span>
				</button>

				<div
					x-ref="content"
					x-show="open"
					x-cloak
					@click.outside="handleClickOutside()"
					@keydown.escape.window="hide()"
					x-transition.origin.top.right
					class="alemni-dashboard-account-popover tutor-popover tutor-dashboard-header-user-popover"
				>

					<div class="alemni-dashboard-account-profile tutor-dashboard-header-user-popover-profile">

						<div class="alemni-dashboard-account-mobile-heading tutor-profile-header-top tutor-hidden tutor-sm-flex tutor-items-center tutor-px-6 tutor-py-5">

							<?php
							Button::make()
								->label( __( 'Back', 'tutor' ) )
								->variant( Variant::GHOST )
								->size( Size::X_SMALL )
								->icon( Icon::LEFT, 'left', 20 )
								->icon_only()
								->flip_rtl()
								->attr( '@click', 'hide()' )
								->render();
							?>

							<h2 class="tutor-profile-header-title tutor-text-h4 tutor-font-semibold tutor-my-none">
								<?php esc_html_e( 'Account', 'tutor' ); ?>
							</h2>

							<?php
							Button::make()
								->variant( Variant::GHOST )
								->size( Size::X_SMALL )
								->icon( Icon::SETTING, 'left', 20 )
								->tag( 'a' )
								->icon_only()
								->attr(
									'href',
									esc_url( Dashboard::get_account_page_url( 'settings' ) )
								)
								->render();
							?>

						</div>

						<div class="alemni-dashboard-profile-summary tutor-user-profile-info">

							<div class="alemni-dashboard-profile-avatar">
								<?php
								Avatar::make()
									->user( $user_id )
									->size( $profile_avatar_size )
									->bordered()
									->render();
								?>
							</div>

							<div class="alemni-dashboard-profile-meta tutor-user-profile-meta tutor-flex tutor-flex-column tutor-items-center tutor-gap-1">

								<strong class="alemni-dashboard-profile-name tutor-text-medium tutor-text-primary tutor-font-semibold">
									<?php echo esc_html( $current_user->display_name ); ?>
								</strong>

								<span class="alemni-dashboard-profile-email tutor-text-tiny tutor-text-secondary">
									<?php echo esc_html( $current_user->user_email ); ?>
								</span>

							</div>

							<a
								href="<?php echo esc_url( $edit_profile_url ); ?>"
								class="alemni-dashboard-profile-edit tutor-btn tutor-btn-ghost tutor-btn-x-small tutor-btn-icon tutor-ml-auto tutor-force-hidden tutor-force-sm-flex"
								aria-label="<?php esc_attr_e( 'Edit profile', 'tutor' ); ?>"
							>
								<?php
								SvgIcon::make()
									->name( Icon::EDIT_2 )
									->size( Size::SIZE_20 )
									->render();
								?>
							</a>

						</div>

						<?php
						/**
						 * Instructor registration status.
						 */
						if (
							! User::is_instructor( $user_id ) &&
							! User::is_admin( $user_id )
						) {
							$instructor_status = tutor_utils()->instructor_status( 0, false );

							$instructor_status = is_string( $instructor_status )
								? strtolower( $instructor_status )
								: '';

							if ( Instructors_List::STATUS_PENDING === $instructor_status ) :
								?>

								<div class="alemni-dashboard-account-notice-wrap tutor-w-full tutor-sm-px-6">
									<div class="alemni-dashboard-account-notice tutor-flex tutor-items-center tutor-gap-3 tutor-py-2 tutor-px-4 tutor-surface-warning-hover-2 tutor-rounded-sm">
										<span class="tutor-flex-center">
											<?php
											SvgIcon::make()
												->name( Icon::INFO_OCTAGON )
												->size( 12 )
												->color( Color::WARNING )
												->render();
											?>
										</span>

										<span class="tutor-p3 tutor-text-warning">
											<?php esc_html_e( 'Application Under Review', 'tutor' ); ?>
										</span>
									</div>
								</div>

								<?php
							elseif (
								Instructors_List::STATUS_BLOCKED !== $instructor_status &&
								$is_become_instructor_enabled
							) :
								?>

								<div class="alemni-dashboard-account-action-wrap tutor-w-full tutor-sm-px-6">
									<a
										href="<?php echo esc_url( tutor_utils()->instructor_register_url() ); ?>"
										class="alemni-dashboard-instructor-link tutor-btn tutor-btn-primary-soft tutor-btn-x-small tutor-btn-block tutor-profile-switch-button"
									>
										<?php
										SvgIcon::make()
											->name( Icon::INSTRUCTOR )
											->render();
										?>

										<span>
											<?php esc_html_e( 'Become an Instructor', 'tutor' ); ?>
										</span>
									</a>
								</div>

								<?php
							endif;
						}

						/**
						 * Preserve learner/instructor mode switching.
						 */
						if ( User::can_switch_mode( $user_id ) ) {
							$current_mode = User::get_current_view_mode();

							$button_label = User::VIEW_AS_INSTRUCTOR === $current_mode
								? esc_html__( 'Switch to Learner', 'tutor' )
								: esc_html__( 'Switch to Instructor', 'tutor' );
							?>

							<div class="alemni-dashboard-account-action-wrap tutor-w-full tutor-sm-px-6">

								<?php
								Button::make()
									->label( $button_label )
									->size( Size::X_SMALL )
									->variant( Variant::PRIMARY_SOFT )
									->icon( Icon::RELOAD_2 )
									->block()
									->attr( ':disabled', 'profileSwitchMutation?.isPending' )
									->attr(
										':class',
										"{ 'tutor-btn-loading': profileSwitchMutation?.isPending }"
									)
									->attr( 'class', 'tutor-profile-switch-button' )
									->attr(
										'@click',
										"profileSwitchMutation.mutate('{$current_mode}')"
									)
									->render();
								?>

							</div>

							<?php
						}
						?>

					</div>

					<div class="alemni-dashboard-account-menu tutor-dashboard-header-user-popover-menu-wrapper">

						<ul class="alemni-dashboard-account-menu-list tutor-dashboard-header-user-popover-menu">

							<?php foreach ( $menu_items as $key => $item ) : ?>

								<?php
								$item_icon = (
									$key === $active_nav &&
									isset( $item['icon_active'] )
								)
									? $item['icon_active']
									: ( $item['icon'] ?? '' );

								$item_url   = $item['url'] ?? '#';
								$item_title = $item['title'] ?? '';
								$is_active  = $key === $active_nav;
								?>

								<li class="alemni-dashboard-account-menu-item">
									<a
										href="<?php echo esc_url( $item_url ); ?>"
										class="alemni-dashboard-account-menu-link tutor-small <?php echo $is_active ? 'active' : ''; ?>"
										<?php echo 'logout' === $key ? 'data-no-instant' : ''; ?>
									>
										<span class="alemni-dashboard-account-menu-icon" aria-hidden="true">
											<?php
											SvgIcon::make()
												->name( $item_icon )
												->size( Size::SIZE_20 )
												->flip_rtl( 'logout' === $key )
												->render();
											?>
										</span>

										<span>
											<?php echo esc_html( $item_title ); ?>
										</span>
									</a>
								</li>

							<?php endforeach; ?>

						</ul>

					</div>

				</div>
			</div>
		</div>
	</div>
</header>
