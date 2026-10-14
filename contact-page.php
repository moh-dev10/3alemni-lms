
<?php
/**
 * Template Name: Contact Page
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main bg-paper mb-20" dir="rtl">
    <div class="mx-auto max-w-[1240px] px-[clamp(20px,5vw,72px)]">

        <?php get_template_part( 'templates/contact/hero' ); ?>

        <div class="grid items-start gap-8 lg:grid-cols-12 lg:gap-12">

            <?php get_template_part( 'templates/contact/contact-info' ); ?>

            <?php get_template_part( 'templates/contact/contact-form' ); ?>

            
        </div>
        
        <?php get_template_part( 'templates/contact/faq' ); ?>

        <?php get_template_part( 'templates/contact/social-links' ); ?>
        
        <?php get_template_part( 'templates/contact/cta' ); ?>
    </div>
</main>

<?php get_footer(); ?>