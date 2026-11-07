<?php
/**
 * Template Name: Student Registration
 *
 * Dedicated registration page template for students.
 * Automatically matched by WordPress template hierarchy for slug 'student-registration'.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main min-h-[calc(100vh-70px)] bg-paper pb-16 pt-24 sm:pb-20 sm:pt-28 md:pb-24 md:pt-32" dir="rtl">
    <div class="site-container mx-auto max-w-[1240px] px-[clamp(20px,5vw,72px)]">

        <?php
        while ( have_posts() ) :
            the_post();
            $content = get_the_content();

            // If page content contains shortcode or blocks, let WordPress render it (which calls our overridden tutor/dashboard/registration.php)
            if ( ! empty( trim( $content ) ) ) {
                the_content();
            } else {
                // If page is empty, directly load the student registration template
                if ( function_exists( 'tutor_load_template' ) ) {
                    tutor_load_template( 'dashboard.registration' );
                } else {
                    get_template_part( 'tutor/dashboard/registration' );
                }
            }
        endwhile;
        ?>

    </div>
</main>

<?php get_footer(); ?>
