
<?php
/**
 * 3alemni Custom Dashboard Layout
 *
 * Preserves Tutor LMS dashboard logic while providing
 * custom CSS hooks for the 3alemni theme.
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;

use Tutor\Components\Alert;
use Tutor\Components\EmptyState;
use TUTOR\Dashboard;
use TUTOR\Icon;
use TUTOR\Template;
use TUTOR\User;

global $wp_query;

$dashboard_page_slug    = '';
$dashboard_page_subslug = '';
$dashboard_page_name    = '';
$page_data              = array();

/**
 * Get the current dashboard page.
 */
if (
	isset( $wp_query->query_vars['tutor_dashboard_page'] ) &&
	$wp_query->query_vars['tutor_dashboard_page']
) {
	$dashboard_page_slug = $wp_query->query_vars['tutor_dashboard_page'];
	$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_page'];
}

/**
 * Get the current dashboard subpage.
 */
if (
	isset( $wp_query->query_vars['tutor_dashboard_sub_page'] ) &&
	$wp_query->query_vars['tutor_dashboard_sub_page']
) {
	$dashboard_page_subslug = $wp_query->query_vars['tutor_dashboard_sub_page'];
	$dashboard_page_name    = $dashboard_page_subslug;

	if ( $dashboard_page_slug ) {
		$dashboard_page_name = $dashboard_page_slug . '/' . $dashboard_page_name;
	}
}

$dashboard_page_name = apply_filters(
	'tutor_dashboard_sub_page_template',
	$dashboard_page_name
);

/**
 * Dashboard navigation and page metadata.
 */
$dashboard_pages = tutor_utils()->tutor_dashboard_nav_ui_items();

$dashboard_pages = array_merge(
	array(
		'index' => array(
			'title' => __( 'Dashboard', 'tutor' ),
		),
	),
	$dashboard_pages
);

$page_meta = Dashboard::get_page_meta_data(
	$dashboard_page_slug ? $dashboard_page_slug : 'index',
	$dashboard_page_subslug,
	$dashboard_pages
);

$meta_title = $page_meta['meta_title'];

Dashboard::set_document_title( $meta_title );

/**
 * Theme shell configuration.
 */
$is_by_short_code           = isset( $is_shortcode ) && true === $is_shortcode;
$site_shell                 = Template::get_site_shell_data( Template::SITE_SHELL_CONTEXT_DASHBOARD );
$show_dashboard_site_header = $site_shell['show_site_header'];
$show_dashboard_site_footer = $site_shell['show_site_footer'];

$has_dashboard_site_shell = (
	! $is_by_short_code &&
	! defined( 'OTLMS_VERSION' ) &&
	$site_shell['has_site_shell']
);

$has_dashboard_site_footer = (
	$has_dashboard_site_shell &&
	$show_dashboard_site_footer
);

$theme_header_selector = $site_shell['theme_header_selector'];

/**
 * Render the theme header when configured by Tutor LMS.
 */
if ( ! $is_by_short_code && ! defined( 'OTLMS_VERSION' ) ) {
	tutor_utils()->tutor_custom_header( $show_dashboard_site_header );
}

/**
 * Current user and dashboard state.
 */
$user_id                   = get_current_user_id();
$user                      = get_user_by( 'ID', $user_id );
$enable_profile_completion = tutor_utils()->get_option( 'enable_profile_completion' );
$is_instructor             = tutor_utils()->is_instructor();
$is_tour_completed         = get_user_meta(
	$user_id,
	User::TOUR_COMPLETED_META,
	true
);

/**
 * Dashboard footer navigation.
 */
$current_url = tutor()->current_url;

$footer_url_1 = trailingslashit(
	tutor_utils()->tutor_dashboard_url(
		$is_instructor ? 'my-courses' : ''
	)
);

$footer_url_2 = trailingslashit(
	tutor_utils()->tutor_dashboard_url(
		$is_instructor ? 'question-answer' : 'my-quiz-attempts'
	)
);

$footer_links = array(
	array(
		'title'      => $is_instructor
			? __( 'My Courses', 'tutor' )
			: __( 'Dashboard', 'tutor' ),
		'url'        => $footer_url_1,
		'is_active'  => $footer_url_1 == $current_url,
		'icon_class' => 'ttr tutor-icon-dashboard',
	),
	array(
		'title'      => $is_instructor
			? __( 'Q&A', 'tutor' )
			: __( 'Quiz Attempts', 'tutor' ),
		'url'        => $footer_url_2,
		'is_active'  => $footer_url_2 == $current_url,
		'icon_class' => $is_instructor
			? 'ttr tutor-icon-question'
			: 'ttr tutor-icon-quiz-attempt',
	),
	array(
		'title'      => __( 'Menu', 'tutor' ),
		'url'        => '#',
		'is_active'  => false,
		'icon_class' => 'ttr tutor-icon-hamburger-o tutor-dashboard-menu-toggler',
	),
);
?>

<?php do_action( 'tutor_dashboard/before/wrap' ); ?>

<div
	class="alemni-dashboard tutor-dashboard-layout<?php
		echo esc_attr(
			( $has_dashboard_site_footer ? ' tutor-has-site-footer' : '' ) .
			( $has_dashboard_site_shell ? ' tutor-has-site-shell' : '' )
		);
	?>"
	<?php if ( $has_dashboard_site_shell ) : ?>
		data-tutor-dashboard-site-shell
		data-tutor-theme-header-selector="<?php echo esc_attr( $theme_header_selector ); ?>"
	<?php endif; ?>
>
	<?php
	/**
	 * Customizable sidebar template.
	 */
	tutor_load_template( 'dashboard.components.sidebar' );
	?>

	<div class="alemni-dashboard-main tutor-dashboard-main">

		<?php
		/**
		 * Customizable header template.
		 */
		tutor_load_template( 'dashboard.components.header' );
		?>

		<div
			class="alemni-dashboard-body tutor-dashboard-body"
			role="main"
		>
			<div class="alemni-dashboard-page tutor-dashboard-page">

				<?php
				/**
				 * Keep the original instructor application restrictions.
				 */
				if (
					User::used_instructor_registration() &&
					User::has_pending_instructor_application() &&
					$dashboard_page_slug
				) {
					tutor_load_template(
						'dashboard.instructor.instructor-request-alert'
					);

					EmptyState::make()
						->title(
							__( 'Your application is under review', 'tutor' )
						)
						->subtitle(
							__(
								'Only your dashboard home is available while your instructor application is pending.',
								'tutor'
							)
						)
						->attr(
							'class',
							'tutor-surface-l1 tutor-border tutor-rounded-2xl'
						)
						->render();

				} elseif ( $dashboard_page_name ) {

					/**
					 * Allow Tutor LMS and its addons to hook into page loading.
					 */
					do_action(
						'tutor_load_dashboard_template_before',
						$dashboard_page_name
					);

					$other_location = '';

					$from_other_location = apply_filters(
						'load_dashboard_template_part_from_other_location',
						$other_location
					);

					/**
					 * Load the requested dashboard page.
					 */
					if ( '' == $from_other_location ) {
						tutor_load_template(
							'dashboard.' . $dashboard_page_name
						);
					} else {
						include_once $from_other_location;
					}

					do_action(
						'tutor_load_dashboard_template_after',
						$dashboard_page_name
					);

				} elseif ( User::is_instructor_view() ) {

					tutor_load_template( 'dashboard.dashboard' );

				} else {

					tutor_load_template( 'dashboard.student.dashboard' );

				}
				?>

			</div>
		</div>
	</div>

	<?php
	/**
	 * Keep Tutor LMS mobile navigation.
	 */
	tutor_load_template(
		'dashboard.components.sidebar-nav-mobile',
		array(
			'dashboard_pages'     => $dashboard_pages,
			'dashboard_page_slug' => $dashboard_page_slug,
		)
	);
	?>

</div>

<?php
/**
 * Keep the student onboarding tour.
 */
if ( User::is_student_view() && ! $is_tour_completed ) {
	tutor_load_template( 'shared.tour' );
}
?>

<?php do_action( 'tutor_dashboard/after/wrap' ); ?>

<?php
/**
 * Render the theme footer when configured by Tutor LMS.
 */
if ( ! $is_by_short_code && ! defined( 'OTLMS_VERSION' ) ) {
	tutor_utils()->tutor_custom_footer( $show_dashboard_site_footer );
}
?>
