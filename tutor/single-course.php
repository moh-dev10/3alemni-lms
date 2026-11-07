<?php
/**
 * 3alemni — Single Course Details Template
 *
 * Master Tutor LMS single course template override for 3alemni.
 * Orchestrates modular components while preserving native Tutor LMS
 * hooks, enrollment logic, security nonces, and access restrictions.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main bg-paper min-h-screen text-ink selection:bg-blue/10 selection:text-blue" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">

	<?php
	/**
	 * Hook: tutor_course/single/before/wrap
	 *
	 * Allows plugins and Tutor addons to output prerequisite notices or trackers.
	 */
	do_action( 'tutor_course/single/before/wrap' );
	?>

	<!-- 1. Hero Section -->
	<?php get_template_part( 'templates/single-course/hero' ); ?>

	<!-- 2. Course Details Layout (Content + Sticky Sidebar) -->
	<section class="single-course-body mx-auto w-full max-w-[1360px] px-4 sm:px-6 lg:px-8 py-10 sm:py-12 lg:py-16">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

			<!-- Main Content Column (70% on large viewports) -->
			<div class="lg:col-span-8 space-y-10 min-w-0">

				<!-- A. Course Overview (Benefits, Description, Prerequisites, Target Audience) -->
				<?php get_template_part( 'templates/single-course/overview' ); ?>

				<!-- B. Interactive Curriculum Accordion -->
				<?php get_template_part( 'templates/single-course/curriculum' ); ?>

				<!-- C. Instructor Profile & Platform Stats -->
				<?php get_template_part( 'templates/single-course/instructor' ); ?>

				<!-- D. Verified Student Reviews & Native Rating Form -->
				<?php get_template_part( 'templates/single-course/reviews' ); ?>

			</div>

			<!-- Sticky Enrollment Sidebar (30% on large viewports) -->
			<div class="lg:col-span-4 min-w-0">
				<?php get_template_part( 'templates/single-course/sidebar' ); ?>
			</div>

		</div>
	</section>

	<?php
	/**
	 * Hook: tutor_course/single/after/wrap
	 */
	do_action( 'tutor_course/single/after/wrap' );
	?>

</main>

<?php
get_footer();
