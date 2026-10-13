
<?php
defined( 'ABSPATH' ) || exit;
?>

<footer class="border-t border-line/80 bg-white/50">
    <div
        class="mx-auto flex w-full max-w-[1240px] flex-col gap-6 px-[clamp(20px,5vw,72px)] py-8 sm:flex-row sm:items-center sm:justify-between sm:py-10"
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
                class="grid size-11 place-items-center rounded-xl bg-blue text-xl font-bold text-white transition-transform duration-300 group-hover:-translate-y-0.5"
                aria-hidden="true"
            >ع</span>

            <span class="flex flex-col gap-0.5">
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

        <!-- Copyright -->
        <p class="text-xs leading-6 text-muted sm:text-left">
            &copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
            <?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
            <?php echo esc_html__( 'Made for curious minds by moh-dev10.', '3alemni' ); ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>