
<?php

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="min-h-screen bg-slate-950 text-white">
    <div class="site-container">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h1>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h1>

                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No content found.', '3alemni' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>