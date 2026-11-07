
<?php

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="min-h-[calc(100vh-70px)] bg-paper pb-16 pt-24 sm:pb-20 sm:pt-28 md:pb-24 md:pt-32" dir="rtl">
    <div class="site-container mx-auto max-w-[1240px] px-[clamp(20px,5vw,72px)]">
        <?php if ( have_posts() ) : ?>
            <div class="space-y-8">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'rounded-3xl border border-line/80 bg-white p-6 shadow-sm sm:p-8' ); ?>>
                        <h2 class="text-2xl font-bold text-ink">
                            <a href="<?php the_permalink(); ?>" class="hover:text-blue">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <div class="mt-4 text-muted">
                            <?php is_singular() ? the_content() : the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="mt-12 flex justify-center">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <div class="rounded-3xl border border-line bg-white p-12 text-center text-muted">
                <p><?php esc_html_e( 'No content found.', '3alemni' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>