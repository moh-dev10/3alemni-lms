<?php
/**
 * The template for displaying all single pages
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main min-h-[calc(100vh-70px)] bg-paper pb-16 pt-24 sm:pb-20 sm:pt-28 md:pb-24 md:pt-32" dir="rtl">
    <div class="site-container mx-auto max-w-[1240px] px-[clamp(20px,5vw,72px)]">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if ( ! is_front_page() && ! is_page_template( [ 'about-page.php', 'contact-page.php', 'page-student-registration.php', 'page-instructor-registration.php' ] ) ) : ?>
                    <header class="page-header mb-8 text-center sm:mb-10">
                        <h1 class="text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">
                            <?php the_title(); ?>
                        </h1>
                    </header>
                <?php endif; ?>

                <div class="page-content text-ink">
                    <?php
                    the_content();

                    wp_link_pages( [
                        'before' => '<div class="page-links mt-6 flex gap-2">' . esc_html__( 'Pages:', '3alemni' ),
                        'after'  => '</div>',
                    ] );
                    ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
