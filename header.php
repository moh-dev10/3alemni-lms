
<?php
defined( 'ABSPATH' ) || exit;

$courses_url = get_post_type_archive_link( 'courses' );

if ( ! $courses_url ) {
    $courses_url = home_url( '/' );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-50 border-b border-line/80 bg-paper/95 backdrop-blur-md">
    <div
        class="mx-auto flex w-full max-w-[1240px] flex-wrap items-center justify-between gap-x-6 gap-y-4 px-[clamp(20px,5vw,72px)] py-3.5 md:flex-nowrap md:py-4"
        x-data="{ open: false }"
        @keydown.escape.window="open = false"
        @click.outside="open = false"
    >
        <!-- Brand -->
        <a
            class="group inline-flex shrink-0 items-center gap-3 text-ink no-underline"
            href="<?php echo esc_url( home_url( '/' ) ); ?>"
            aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
        >
            <span
                class="grid size-11 place-items-center rounded-xl bg-blue text-xl font-bold text-white transition-transform duration-300 group-hover:-translate-y-0.5"
                aria-hidden="true"
            >ع</span>

            <span class="text-xl font-bold tracking-normal">
                3alemni
            </span>
        </a>

        <!-- Mobile menu toggle -->
        <button
            class="inline-flex size-11 shrink-0 flex-col items-center justify-center gap-1.5 rounded-lg border border-line text-ink transition-colors hover:border-blue/40 hover:bg-white md:hidden"
            type="button"
            aria-controls="primary-navigation"
            aria-label="<?php esc_attr_e( 'Toggle navigation menu', '3alemni' ); ?>"
            :aria-expanded="open.toString()"
            @click="open = !open"
        >
            <span
                class="h-0.5 w-[18px] rounded-full bg-current transition-transform duration-200"
                :class="{ 'translate-y-1 rotate-45': open }"
            ></span>

            <span
                class="h-0.5 w-[18px] rounded-full bg-current transition-transform duration-200"
                :class="{ '-translate-y-1 -rotate-45': open }"
            ></span>
        </button>

        <!-- Primary navigation -->

<!-- Primary navigation -->
<nav
    id="primary-navigation"
    class="absolute inset-x-0 top-full hidden border-t border-line bg-paper px-[clamp(20px,5vw,72px)] py-5 shadow-lg shadow-ink/5 md:static md:order-none md:block md:w-auto md:border-0 md:bg-transparent md:p-0 md:shadow-none"
    aria-label="<?php esc_attr_e( 'Main navigation', '3alemni' ); ?>"
    :class="{ '!block': open }"
    @click="if ($event.target.closest('a')) open = false"
>
    <?php if ( has_nav_menu( 'primary' ) ) : ?>
        <?php
        wp_nav_menu(
            [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-nav__list flex flex-col gap-2 md:flex-row md:items-center md:gap-7',
                'fallback_cb'    => false,
            ]
        );
        ?>
    <?php else : ?>
        <ul class="site-nav__list flex flex-col gap-2 md:flex-row md:items-center md:gap-7">
            <li>
                <a
                    class="block rounded-lg px-3 py-2 text-sm font-medium text-muted transition-colors hover:bg-white hover:text-blue"
                    href="<?php echo esc_url( $courses_url ); ?>"
                >
                    <?php esc_html_e( 'Courses', '3alemni' ); ?>
                </a>
            </li>
            <li>
                <a
                    class="block rounded-lg px-3 py-2 text-sm font-medium text-muted transition-colors hover:bg-white hover:text-blue"
                    href="<?php echo esc_url( home_url( '/#approach' ) ); ?>"
                >
                    <?php esc_html_e( 'Our approach', '3alemni' ); ?>
                </a>
            </li>
        </ul>
    <?php endif; ?>
</nav>

        <!-- Header CTA -->
        <a
            class="hidden shrink-0 items-center gap-3 rounded-lg bg-blue px-5 py-3 text-sm font-semibold text-white no-underline transition-colors hover:bg-blue-dark md:inline-flex"
            href="<?php echo esc_url( $courses_url ); ?>"
        >
            <?php esc_html_e( 'Explore courses', '3alemni' ); ?>
            <span aria-hidden="true">↗</span>
        </a>
    </div>
</header>