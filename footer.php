<?php
defined( 'ABSPATH' ) || exit;

$footer_menu_exists = has_nav_menu( 'footer' );
?>

<footer class="border-t border-line/80 bg-white/50">
    <div
        class="mx-auto grid w-full max-w-[1240px] gap-8 px-[clamp(20px,5vw,72px)] py-8 sm:grid-cols-2 sm:items-center sm:py-10 lg:grid-cols-3"
        dir="rtl"
        lang="ar"
    >
        <!-- Brand -->
        <a
            class="group inline-flex w-fit items-center gap-3 text-ink no-underline"
            href="<?php echo esc_url( home_url( '/' ) ); ?>"
            aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
        >
            <span
                class="grid size-11 shrink-0 place-items-center rounded-xl bg-blue text-xl font-bold text-white transition-transform duration-300 group-hover:-translate-y-0.5"
                aria-hidden="true"
            >ع</span>

            <span class="flex flex-col gap-1">
                <span class="text-lg font-bold leading-tight tracking-normal">
                    3alemni
                </span>
                <span class="text-xs text-muted">
                    تعلّم. طبّق. تطوّر.
                </span>
            </span>
        </a>

        <!-- Description -->
        <p class="max-w-sm text-sm leading-7 text-muted">
            مساحة للتعلّم، التطبيق، وبناء مهارات تقدر تستعملها في الواقع.
        </p>

        <!-- Footer Navigation -->
        <?php if ( $footer_menu_exists ) : ?>
            <nav
                class="flex flex-wrap items-center gap-x-5 gap-y-3 text-sm text-muted! sm:col-span-2 lg:col-span-1 lg:justify-end"
                aria-label="<?php esc_attr_e( 'روابط أسفل الصفحة', '3alemni' ); ?>"
            >
                <?php
                wp_nav_menu(
                    [
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'flex flex-wrap items-center gap-x-5 gap-y-3',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]
                );
                ?>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-line/60">
        <div
            class="mx-auto flex w-full max-w-[1240px] flex-col gap-2 px-[clamp(20px,5vw,72px)] py-4 text-xs leading-6 text-muted sm:flex-row sm:items-center sm:justify-between"
            dir="rtl"
            lang="ar"
        >
            <p>
                &copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
                <?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
                <?php echo esc_html__( 'Made for curious minds by moh-dev10.', '3alemni' ); ?>
            </p>

            <a
                class="w-fit font-medium text-blue transition-colors duration-200 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2"
                href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"
            >
                تواصل معنا
            </a>
        </div>
    </div>
</footer>

<?php get_template_part( 'template-parts/global/whatsapp-float' ); ?>

<?php wp_footer(); ?>
</body>
</html>