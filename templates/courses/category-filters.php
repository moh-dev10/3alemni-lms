<?php
defined( 'ABSPATH' ) || exit;

$categories = get_terms( [
    'taxonomy'   => 'course-category',
    'hide_empty' => true,
] );

if ( empty( $categories ) || is_wp_error( $categories ) ) {
    return;
}
?>

<nav
    data-reveal="up"
    class="mb-16 flex flex-wrap items-center justify-center gap-3"
    style="--reveal-delay: 150ms"
    aria-label="<?php esc_attr_e( 'تصنيفات الدورات', '3alemni' ); ?>"
>

    <a
        href="<?php echo esc_url( get_post_type_archive_link( 'courses' ) ); ?>"
        aria-current="page"
        class="rounded-2xl border border-blue bg-blue px-5 py-2.5 text-xs font-bold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-dark hover:shadow-md"
    >
        <?php esc_html_e( 'الكل', '3alemni' ); ?>
    </a>

    <?php foreach ( $categories as $cat ) : ?>

        <a
            href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
            class="rounded-2xl border border-line bg-white px-5 py-2.5 text-xs font-semibold text-ink transition-all duration-300 hover:-translate-y-0.5 hover:border-blue/40 hover:text-blue hover:shadow-sm"
        >
            <?php echo esc_html( $cat->name ); ?>
        </a>

    <?php endforeach; ?>

</nav>