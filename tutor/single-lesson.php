<?php
/**
 * 3alemni — Single Lesson Player Master Template
 *
 * Distraction-free learning environment providing native Tutor LMS video
 * playback, accessible curriculum browsing, strict permission gating, and
 * seamless previous/next navigation.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$lesson_id = get_the_ID();
$course_id = function_exists( 'tutor_utils' ) ? (int) tutor_utils()->get_course_id_by_subcontent_id( $lesson_id ) : 0;
$user_id   = get_current_user_id();

// Access permissions check
$is_enrolled      = is_user_logged_in() && function_exists( 'tutor_utils' ) && tutor_utils()->is_enrolled( $course_id, $user_id );
$is_admin         = current_user_can( 'administrator' );
$is_course_author = ( (int) get_post_field( 'post_author', $course_id ) === $user_id );
$is_preview       = function_exists( 'tutor_utils' ) ? (bool) tutor_utils()->is_preview( $lesson_id ) : (bool) get_post_meta( $lesson_id, '_is_preview', true );
$has_access       = $is_enrolled || $is_admin || $is_course_author || $is_preview;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-paper min-h-screen text-ink antialiased selection:bg-blue/10 selection:text-blue overflow-x-hidden font-sans' ); ?>>

	<?php wp_body_open(); ?>

	<!-- 1. Distraction-Free Header -->
	<?php get_template_part( 'templates/lesson/header' ); ?>

	<?php if ( $has_access ) : ?>

		<!-- 2. Learning Workspace (Main Video + Content + Sticky Curriculum) -->
		<div class="flex min-h-[calc(100vh-64px)] w-full relative">

			<!-- Primary Learning Column -->
			<main id="primary" class="flex-1 min-w-0 flex flex-col bg-paper">

				<!-- A. Cinematic Video Player -->
				<?php get_template_part( 'templates/lesson/player' ); ?>

				<!-- B. Lesson Navigation & Complete Action Bar -->
				<?php get_template_part( 'templates/lesson/navigation' ); ?>

				<!-- C. Lesson Explanation, Notes, & Attachments -->
				<?php get_template_part( 'templates/lesson/content' ); ?>

			</main>

			<!-- Collapsible Curriculum Drawer / Sidebar -->
			<?php get_template_part( 'templates/lesson/sidebar' ); ?>

		</div>

	<?php else : ?>

		<!-- Access Denied Protection Screen -->
		<main id="primary" class="w-full">
			<?php get_template_part( 'templates/lesson/access-denied' ); ?>
		</main>

	<?php endif; ?>

	<?php wp_footer(); ?>
</body>
</html>
