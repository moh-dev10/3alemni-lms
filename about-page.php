
<?php
/**
 * Template Name: About Page
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main about-page bg-paper mb-12 md:mb-20" dir="rtl">    
    <?php get_template_part( 'templates/about/hero' ); ?>

    <div class="about-page__container mx-auto max-w-[1240px] px-[clamp(20px,5vw,72px)]">


        <?php get_template_part( 'templates/about/values' ); ?>

        <?php get_template_part( 'templates/about/story' ); ?>

    </div>
</main>

<?php get_footer(); ?>
