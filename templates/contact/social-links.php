<?php
/**
 * Contact Page — Social Links
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;
?>

<section
    class="contact-social mt-16 sm:mt-20"
    aria-labelledby="contact-social-title"
    data-reveal="up"
>
    <div class="mx-auto max-w-3xl text-center">

        <!-- Section heading -->
        <span class="inline-flex items-center gap-2 rounded-full border border-blue/15 bg-blue/5 px-3.5 py-2 text-xs font-bold text-blue">
            <svg
                class="size-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="18" cy="5" r="3" />
                <circle cx="6" cy="12" r="3" />
                <circle cx="18" cy="19" r="3" />
                <path d="m8.7 10.7 6.6-4.4M8.7 13.3l6.6 4.4" />
            </svg>

            <?php esc_html_e( 'مجتمع 3alemni', '3alemni' ); ?>
        </span>

        <h2
            id="contact-social-title"
            class="mt-4 text-2xl font-extrabold leading-tight tracking-tight text-ink sm:text-3xl"
        >
            <?php esc_html_e( 'خليك قريب منّا', '3alemni' ); ?>
        </h2>

        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-muted sm:text-base sm:leading-8">
            <?php esc_html_e( 'تابعنا على مواقع التواصل، واكتشف آخر أخبار المنصة والمحتوى التعليمي الجديد.', '3alemni' ); ?>
        </p>
    </div>

    <!-- Social cards -->
    <div class="mx-auto mt-8 grid max-w-4xl grid-cols-1 gap-3 sm:mt-10 sm:grid-cols-3 sm:gap-4">

        <!-- Facebook -->
        <a
            href="#"
            aria-label="<?php esc_attr_e( 'Facebook — قريبًا', '3alemni' ); ?>"
            class="contact-social__card group flex items-center gap-4 rounded-2xl border border-ink/8 bg-white p-4 text-start shadow-sm shadow-ink/[0.02] transition duration-300 hover:-translate-y-1 hover:border-[#1877F2]/30 hover:shadow-lg hover:shadow-[#1877F2]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 sm:flex-col sm:items-center sm:gap-3 sm:p-6 sm:text-center"
        >
            <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#1877F2]/8 text-[#1877F2] transition duration-300 group-hover:bg-[#1877F2] group-hover:text-white">
                <svg
                    class="size-6"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.019 4.388 11.016 10.125 11.927v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.49 0-1.955.931-1.955 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.089 24 18.092 24 12.073Z" />
                </svg>
            </span>

            <span class="min-w-0 flex-1 sm:flex-none">
                <span class="block text-sm font-bold text-ink">
                    Facebook
                </span>
                <span class="mt-1 block text-xs leading-5 text-muted">
                    <?php esc_html_e( 'تابع آخر الأخبار', '3alemni' ); ?>
                </span>
            </span>

            <svg
                class="ms-auto size-4 shrink-0 text-muted transition duration-300 group-hover:-translate-x-1 group-hover:text-blue sm:hidden"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M19 12H5m7 7-7-7 7-7" />
            </svg>
        </a>

        <!-- Instagram -->
        <a
            href="#"
            aria-label="<?php esc_attr_e( 'Instagram — قريبًا', '3alemni' ); ?>"
            class="contact-social__card group flex items-center gap-4 rounded-2xl border border-ink/8 bg-white p-4 text-start shadow-sm shadow-ink/[0.02] transition duration-300 hover:-translate-y-1 hover:border-[#E1306C]/30 hover:shadow-lg hover:shadow-[#E1306C]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 sm:flex-col sm:items-center sm:gap-3 sm:p-6 sm:text-center"
        >
            <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#E1306C]/8 text-[#E1306C] transition duration-300 group-hover:bg-[#E1306C] group-hover:text-white">
                <svg
                    class="size-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <rect width="18" height="18" x="3" y="3" rx="5" />
                    <circle cx="12" cy="12" r="4" />
                    <path d="M17.5 6.5h.01" />
                </svg>
            </span>

            <span class="min-w-0 flex-1 sm:flex-none">
                <span class="block text-sm font-bold text-ink">
                    Instagram
                </span>
                <span class="mt-1 block text-xs leading-5 text-muted">
                    <?php esc_html_e( 'محتوى تعليمي جديد', '3alemni' ); ?>
                </span>
            </span>

            <svg
                class="ms-auto size-4 shrink-0 text-muted transition duration-300 group-hover:-translate-x-1 group-hover:text-blue sm:hidden"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M19 12H5m7 7-7-7 7-7" />
            </svg>
        </a>

        <!-- YouTube -->
        <a
            href="#"
            aria-label="<?php esc_attr_e( 'YouTube — قريبًا', '3alemni' ); ?>"
            class="contact-social__card group flex items-center gap-4 rounded-2xl border border-ink/8 bg-white p-4 text-start shadow-sm shadow-ink/[0.02] transition duration-300 hover:-translate-y-1 hover:border-[#FF0033]/30 hover:shadow-lg hover:shadow-[#FF0033]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 sm:flex-col sm:items-center sm:gap-3 sm:p-6 sm:text-center"
        >
            <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#FF0033]/8 text-[#FF0033] transition duration-300 group-hover:bg-[#FF0033] group-hover:text-white">
                <svg
                    class="size-6"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8ZM9.6 15.6V8.4l6.3 3.6-6.3 3.6Z" />
                </svg>
            </span>

            <span class="min-w-0 flex-1 sm:flex-none">
                <span class="block text-sm font-bold text-ink">
                    YouTube
                </span>
                <span class="mt-1 block text-xs leading-5 text-muted">
                    <?php esc_html_e( 'دروس وشروحات', '3alemni' ); ?>
                </span>
            </span>

            <svg
                class="ms-auto size-4 shrink-0 text-muted transition duration-300 group-hover:-translate-x-1 group-hover:text-blue sm:hidden"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M19 12H5m7 7-7-7 7-7" />
            </svg>
        </a>

    </div>
</section>