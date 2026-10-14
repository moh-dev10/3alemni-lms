<?php
/**
 * Contact Page — Closing CTA
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;

$courses_url = get_post_type_archive_link( 'courses' );

if ( ! $courses_url ) {
    $courses_url = home_url( '/' );
}

$cta_image = get_theme_file_uri( '/assets/images/contact-cta.webp' );
?>

<section
    class="contact-cta relative isolate mt-16 overflow-hidden rounded-3xl bg-blue px-6 py-12 text-white sm:px-10 sm:py-16 lg:mt-20 lg:px-14 lg:py-20"
    aria-labelledby="contact-cta-title"
    data-reveal="up"
>
    <!-- Background image -->
    <div
        class="pointer-events-none absolute inset-0 -z-20"
        aria-hidden="true"
    >
        <img
            src="<?php echo esc_url( $cta_image ); ?>"
            alt=""
            loading="lazy"
            decoding="async"
            class="h-full w-full object-cover object-center"
        >
    </div>

    <!-- Dark overlay for text contrast -->
    <div
        class="pointer-events-none absolute inset-0 -z-10 bg-gradient-to-l from-blue/95 via-blue/85 to-blue/60"
        aria-hidden="true"
    ></div>

    <!-- Content -->
    <div class="relative mx-auto flex max-w-3xl flex-col items-center gap-6 text-center">

        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white/90 backdrop-blur-sm">
            <span
                class="h-2 w-2 rounded-full bg-sky-300"
                aria-hidden="true"
            ></span>
            خطوتك القادمة تبدأ هنا
        </span>

        <h2
            id="contact-cta-title"
            class="max-w-2xl text-3xl font-bold leading-tight tracking-tight sm:text-4xl lg:text-5xl"
        >
            تعلّم اليوم، واصنع فرصك غدوة
        </h2>

        <p class="max-w-xl text-sm leading-7 text-white/80 sm:text-base sm:leading-8">
            اكتشف الدورات المتاحة، طوّر مهاراتك، وقرّب خطوة أخرى نحو أهدافك مع 3alemni.
        </p>

        <div class="mt-2 flex w-full flex-col items-center justify-center gap-3 sm:w-auto sm:flex-row">

            <a
                href="<?php echo esc_url( $courses_url ); ?>"
                class="inline-flex min-h-12 w-full items-center justify-center gap-3 rounded-xl bg-white px-7 py-3 font-semibold text-blue! shadow-lg shadow-black/10 transition duration-300 hover:-translate-y-1 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue sm:w-auto"
            >
                اكتشف الدورات
                <span
    class="inline-flex h-5 w-5 items-center justify-center transition-transform duration-200 group-hover:-translate-x-1"
    aria-hidden="true"
>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="h-5 w-5"
    >
        <path d="M19 12H5" />
        <path d="m12 19-7-7 7-7" />
    </svg>
</span>
            </a>

            <a
                href="#contact-form"
                class="inline-flex min-h-12 w-full items-center justify-center rounded-xl border border-white/25 bg-white/5 px-7 py-3 font-semibold text-white backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white sm:w-auto"
            >
                تواصل معنا
            </a>

        </div>
    </div>
</section>