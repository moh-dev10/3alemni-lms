
<?php
defined( 'ABSPATH' ) || exit;

$courses_url = get_post_type_archive_link( 'courses' );

if ( ! $courses_url ) {
    $courses_url = home_url( '/' );
}
?>

<nav aria-label="<?php esc_attr_e( 'Main navigation', '3alemni' ); ?>">
    <?php if ( has_nav_menu( 'primary' ) ) : ?>

        <?php
        wp_nav_menu(
            [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-nav__list flex flex-col gap-1 pb-4 pt-3 md:flex-row md:items-center md:gap-12 text-sm font-medium md:py-0',
                'fallback_cb'    => false,
                'depth'          => 2,
            ]
        );
        ?>

    <?php else : ?>

        <ul class="site-nav__list flex flex-col gap-1 pb-4 pt-3 md:flex-row md:items-center md:gap-1 md:py-0">
            <li>
                <a
                    class="block rounded-lg px-4 py-3 text-sm font-semibold text-muted no-underline transition-colors duration-200 hover:bg-white hover:text-blue md:py-2.5"
                    href="<?php echo esc_url( $courses_url ); ?>"
                >
                    <?php esc_html_e( 'Courses', '3alemni' ); ?>
                </a>
            </li>

            <li>
                <a
                    class="block rounded-lg px-4 py-3 text-sm font-semibold text-muted no-underline transition-colors duration-200 hover:bg-white hover:text-blue md:py-2.5"
                    href="<?php echo esc_url( home_url( '/#approach' ) ); ?>"
                >
                    <?php esc_html_e( 'Our approach', '3alemni' ); ?>
                </a>
            </li>
        </ul>

    <?php endif; ?>
</nav>
