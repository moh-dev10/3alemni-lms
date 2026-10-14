
<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content">

    <?php get_template_part( 'templates/home/hero' ); ?>

    <?php get_template_part( 'templates/home/principles' ); ?>

    <?php get_template_part( 'templates/home/featured-courses' ); ?>

    <?php get_template_part( 'templates/home/learning-approach' ); ?>

</main>

<?php get_footer(); ?>
