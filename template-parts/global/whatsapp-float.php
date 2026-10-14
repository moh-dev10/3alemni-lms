<?php
/**
 * Global WhatsApp Floating Button
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;
?>

<a
    href="#"
    class="whatsapp-float group fixed bottom-5 left-5 z-50 inline-flex size-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg shadow-[#25D366]/25 transition duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-xl hover:shadow-[#25D366]/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25D366] focus-visible:ring-offset-4 motion-reduce:transition-none sm:bottom-6 sm:left-6 sm:size-16"
    aria-label="<?php esc_attr_e( 'تواصل معنا عبر واتساب', '3alemni' ); ?>"
    title="<?php esc_attr_e( 'تواصل معنا عبر واتساب', '3alemni' ); ?>"
>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="currentColor"
        class="size-7 transition-transform duration-300 group-hover:scale-110 sm:size-8"
        aria-hidden="true"
    >
        <path d="M20.52 3.48A11.86 11.86 0 0 0 12.07 0C5.5 0 .15 5.34.15 11.91c0 2.1.55 4.15 1.6 5.96L0 24l6.28-1.65a11.9 11.9 0 0 0 5.78 1.47h.01c6.57 0 11.92-5.34 11.92-11.91 0-3.18-1.24-6.17-3.47-8.43ZM12.07 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.73.98.99-3.64-.24-.37a9.86 9.86 0 0 1-1.52-5.27c0-5.48 4.46-9.94 9.95-9.94a9.87 9.87 0 0 1 7.04 2.92 9.87 9.87 0 0 1 2.91 7.04c0 5.48-4.46 9.87-10 9.87Zm5.46-7.43c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.8-1.49-1.78-1.66-2.08-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.2 5.08 4.49.71.3 1.27.48 1.7.62.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z"/>
    </svg>

    <span class="pointer-events-none absolute left-full ml-3 hidden whitespace-nowrap rounded-lg bg-ink px-3 py-2 text-xs font-semibold text-white opacity-0 shadow-lg transition duration-200 group-hover:opacity-100 sm:block">
        <?php esc_html_e( 'راسلنا على واتساب', '3alemni' ); ?>
    </span>
</a>