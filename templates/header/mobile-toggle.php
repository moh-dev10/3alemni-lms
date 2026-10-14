
<?php
defined( 'ABSPATH' ) || exit;
?>

<button
    id="mobile-menu-button"
    type="button"
    class="inline-flex size-11 shrink-0 flex-col items-center justify-center gap-[5px] rounded-xl border border-line/80 bg-white text-ink shadow-sm transition-all duration-200 hover:border-blue/40 hover:bg-blue/5 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue md:hidden"
    aria-controls="primary-navigation"
    aria-expanded="false"
    aria-label="<?php esc_attr_e( 'Open navigation menu', '3alemni' ); ?>"
    data-open-label="<?php echo esc_attr__( 'Open navigation menu', '3alemni' ); ?>"
    data-close-label="<?php echo esc_attr__( 'Close navigation menu', '3alemni' ); ?>"
>
    <span
        id="menu-line-top"
        class="h-0.5 w-[18px] rounded-full bg-current transition-transform duration-300 ease-out"
    ></span>

    <span
        id="menu-line-bottom"
        class="h-0.5 w-[18px] rounded-full bg-current transition-transform duration-300 ease-out"
    ></span>
</button>
