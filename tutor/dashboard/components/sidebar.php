
<?php
/**
 * 3alemni Custom Dashboard Sidebar
 *
 * Preserves Tutor LMS dynamic navigation and permissions.
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;

use Tutor\Components\Constants\Size;
use Tutor\Components\SvgIcon;
use TUTOR\Icon;
use TUTOR\User;

global $wp_query;

$dashboard_page_slug = '';
$dashboard_page_name = '';

if (
	isset( $wp_query->query_vars['tutor_dashboard_page'] ) &&
	$wp_query->query_vars['tutor_dashboard_page']
) {
	$dashboard_page_slug = $wp_query->query_vars['tutor_dashboard_page'];
	$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_page'];
}

if (
	isset( $wp_query->query_vars['tutor_dashboard_sub_page'] ) &&
	$wp_query->query_vars['tutor_dashboard_sub_page']
) {
	$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_sub_page'];

	if ( $dashboard_page_slug ) {
		$dashboard_page_name = $dashboard_page_slug . '/' . $dashboard_page_name;
	}
}

$dashboard_page_name = apply_filters(
	'tutor_dashboard_sub_page_template',
	$dashboard_page_name
);

$dashboard_pages  = tutor_utils()->tutor_dashboard_nav_ui_items();
$show_site_header = (bool) get_tutor_option( 'show_dashboard_site_header' );
$is_kids_mode     = tutor_utils()->is_kids_mode();
$icon_size        = $is_kids_mode ? Size::SIZE_24 : Size::SIZE_20;
?>

<aside class="alemni-dashboard-sidebar tutor-dashboard-sidebar">

	<?php if ( ! $show_site_header ) : ?>
		<a
			href="<?php echo esc_url( home_url( '/' ) ); ?>"
			class="alemni-dashboard-sidebar-logo tutor-dashboard-sidebar-logo"
			aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
		>
			<?php tutor_load_template( 'shared.brand-logo' ); ?>
		</a>
	<?php endif; ?>

	<div
		class="alemni-dashboard-sidebar-nav tutor-dashboard-sidebar-nav"
		role="navigation"
		aria-label="<?php esc_attr_e( 'Dashboard navigation', 'tutor' ); ?>"
	>
		<p class="alemni-dashboard-sidebar-label">
			<?php esc_html_e( 'MENU', 'tutor' ); ?>
		</p>

		<ul>
			<?php foreach ( $dashboard_pages as $dashboard_key => $dashboard_page ) : ?>

				<?php
				$menu_title       = $dashboard_page;
				$menu_link        = tutor_utils()->get_tutor_dashboard_page_permalink( $dashboard_key );
				$menu_icon_name   = '';
				$active_icon_name = '';

				if ( is_array( $dashboard_page ) ) {
					$menu_title = tutor_utils()->array_get(
						'title',
						$dashboard_page
					);

					$menu_icon_name = tutor_utils()->array_get(
						'icon',
						$dashboard_page,
						isset( $dashboard_page['icon'] )
							? $dashboard_page['icon']
							: ''
					);

					$active_icon_name = tutor_utils()->array_get(
						'active_icon',
						$dashboard_page,
						isset( $dashboard_page['active_icon'] )
							? $dashboard_page['active_icon']
							: $menu_icon_name
					);

					if ( isset( $dashboard_page['url'] ) ) {
						$menu_link = $dashboard_page['url'];
					}
				}

				$original_key = $dashboard_key;
				$li_class     = 'alemni-dashboard-menu-item tutor-dashboard-menu-' . $original_key;

				if ( 'index' === $dashboard_key ) {
					$dashboard_key = '';
				}

				$is_active_menu  = $dashboard_key === $dashboard_page_slug;
				$active_class    = $is_active_menu ? 'active' : '';
				$data_no_instant = 'logout' === $dashboard_key
					? 'data-no-instant'
					: '';

				$menu_link = apply_filters(
					'tutor_dashboard_menu_link',
					$menu_link,
					$menu_title
				);
				?>

				<li class="<?php echo esc_attr( $li_class ); ?>">
					<a
						href="<?php echo esc_url( $menu_link ); ?>"
						class="alemni-dashboard-nav-link <?php echo esc_attr( $active_class ); ?>"
						<?php echo esc_attr( $data_no_instant ); ?>
						<?php echo $is_active_menu ? 'aria-current="page"' : ''; ?>
					>
						<span class="alemni-dashboard-nav-icon" aria-hidden="true">
							<?php
							SvgIcon::make()
								->name(
									(
										$is_active_menu && ! $is_kids_mode
									)
										? $active_icon_name
										: $menu_icon_name
								)
								->size( $icon_size )
								->render();
							?>
						</span>

						<span class="alemni-dashboard-nav-text">
							<?php echo esc_html( $menu_title ); ?>
						</span>

						<?php if ( $is_active_menu ) : ?>
							<span class="alemni-dashboard-nav-indicator" aria-hidden="true"></span>
						<?php endif; ?>
					</a>
				</li>

			<?php endforeach; ?>
		</ul>
	</div>

	<?php if ( User::is_student_view() ) : ?>
		<div class="alemni-dashboard-sidebar-footer">
			<div class="alemni-dashboard-explore-card">
				<span class="alemni-dashboard-explore-eyebrow">
					<?php esc_html_e( 'KEEP LEARNING', 'tutor' ); ?>
				</span>

				<p class="alemni-dashboard-explore-title">
					<?php esc_html_e( 'Discover your next course.', 'tutor' ); ?>
				</p>

				<a
					href="<?php echo esc_url( tutor_utils()->course_archive_page_url() ); ?>"
					class="alemni-dashboard-explore-link tutor-see-all-courses"
				>
					<span><?php esc_html_e( 'Explore courses', 'tutor' ); ?></span>

					<?php
					SvgIcon::make()
						->name( Icon::RIGHT_ARROW_UP )
						->size( $icon_size )
						->flip_rtl()
						->render();
					?>
				</a>
			</div>
		</div>
	<?php endif; ?>

</aside>
