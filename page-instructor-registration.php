<?php
/**
 * Template Name: Instructor Registration
 *
 * Dedicated registration page template for instructors.
 * Automatically matched by WordPress template hierarchy for slug 'instructor-registration'.
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

            if ( ! empty( trim( $content ) ) ) {
                the_content();
            } else {
                if ( function_exists( 'tutor_load_template' ) ) {
                    tutor_load_template( 'dashboard.instructor.registration' );
                } else {
                    get_template_part( 'tutor/dashboard/instructor/registration' );
                }
            }
        endwhile;
        ?>

    </div>
</main>

<?php get_footer(); ?>
