<?php
defined( 'ABSPATH' ) || exit;

$courses_url = get_post_type_archive_link( 'courses' );

if ( ! $courses_url ) {
    $courses_url = home_url( '/' );
}
?>

<!-- About Hero Section -->
<section
    class="about-hero relative isolate overflow-hidden py-20 text-center sm:py-24 md:py-28"
    dir="rtl"
>
    <!-- Full-Width Decorative Background -->
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0 -z-10 overflow-hidden"
    >
        <!-- Main Blue Glow -->
        <div
            class="absolute left-1/2 top-0 h-[28rem] w-full max-w-5xl -translate-x-1/2 -translate-y-1/3 rounded-full bg-blue/10 blur-3xl sm:h-[34rem]"
        ></div>

        <!-- Left Glow -->
        <div
            class="absolute -left-32 top-1/3 size-64 rounded-full bg-blue/5 blur-3xl sm:size-96"
        ></div>

        <!-- Right Glow -->
        <div
            class="absolute -right-32 top-0 size-64 rounded-full bg-blue/5 blur-3xl sm:size-96"
        ></div>

        <!-- Subtle Grid -->
        <div
            class="about-hero__grid absolute inset-0 opacity-40"
        ></div>

        <!-- Decorative Rings -->
        <div
            class="absolute -right-24 top-8 size-48 rounded-full border border-blue/10 sm:-right-12 sm:size-64"
        ></div>

        <div
            class="absolute -right-12 top-20 size-32 rounded-full border border-blue/10 sm:right-4 sm:top-24 sm:size-44"
        ></div>

        <div
            class="absolute -bottom-24 -left-20 size-48 rounded-full border border-blue/10 sm:-left-10 sm:size-64"
        ></div>

        <!-- Bottom Accent -->
        <div
            class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-blue/25 to-transparent"
        ></div>
    </div>

    <!-- Content Container -->
    <div class="relative mx-auto max-w-5xl px-[clamp(20px,5vw,72px)]">

        <!-- Eyebrow -->
        <span
            data-reveal="up"
            class="about-reveal inline-flex items-center gap-2 rounded-full border border-blue/20 bg-white/80 px-4 py-2 text-xs font-semibold tracking-wide text-blue shadow-sm shadow-blue/5"
            style="--reveal-delay: 0ms"
        >
            <span
                class="size-1.5 rounded-full bg-blue"
                aria-hidden="true"
            ></span>

            <?php esc_html_e( 'عن علّمني', '3alemni' ); ?>
        </span>

        <!-- Heading -->
        <h1
            data-reveal="up"
            class="about-reveal mx-auto mt-6 max-w-3xl text-3xl font-extrabold leading-[1.5] tracking-tight text-ink sm:text-4xl md:mt-7 md:text-5xl md:leading-[1.4] lg:text-6xl"
            style="--reveal-delay: 100ms"
        >
            <?php esc_html_e( 'ماشي غير تتفرّج،', '3alemni' ); ?>

            <span class="relative inline-block whitespace-nowrap text-blue">
                <?php esc_html_e( 'تعلّم وطبّق', '3alemni' ); ?>

                <svg
                    class="absolute -bottom-1 right-0 h-2 w-full text-blue/30 sm:-bottom-2 sm:h-3"
                    viewBox="0 0 200 12"
                    fill="none"
                    aria-hidden="true"
                    preserveAspectRatio="none"
                >
                    <path
                        d="M3 8.5C48 2.5 126 2 197 6"
                        stroke="currentColor"
                        stroke-width="5"
                        stroke-linecap="round"
                    />
                </svg>
            </span>
        </h1>

        <!-- Description -->
        <p
            data-reveal="up"
            class="about-reveal mx-auto mt-6 max-w-2xl text-sm leading-8 text-muted sm:text-base md:mt-7 md:text-lg md:leading-9"
            style="--reveal-delay: 200ms"
        >
            <?php esc_html_e( 'علّمني منصة تعليمية تساعدك تفهم، تطبّق، وتبني مهارات حقيقية. نؤمن أن التعلّم ما يكملش بالمشاهدة فقط، بل بالتجربة والممارسة وإنجاز مشاريع تقدر تفتخر بها.', '3alemni' ); ?>
        </p>

        <!-- Actions -->
        <div
            data-reveal="up"
            class="about-reveal mt-8 flex flex-col items-stretch justify-center gap-3 sm:mt-9 sm:flex-row sm:items-center"
            style="--reveal-delay: 300ms"
        >
            <a
                href="<?php echo esc_url( $courses_url ); ?>"
                class="group inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue/15 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 motion-reduce:transition-none"
            >
                <?php esc_html_e( 'اكتشف الدورات', '3alemni' ); ?>

                <svg
                    class="size-4 transition-transform duration-300 group-hover:-translate-x-1 motion-reduce:transition-none"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M19 12H5" />
                    <path d="m12 19-7-7 7-7" />
                </svg>
            </a>

            <a
                href="#about-values"
                class="inline-flex min-h-12 items-center justify-center rounded-xl border border-line bg-white/80 px-6 py-3 text-sm font-semibold text-ink transition duration-300 hover:border-blue/30 hover:bg-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 motion-reduce:transition-none"
            >
                <?php esc_html_e( 'اكتشف مبادئنا', '3alemni' ); ?>
            </a>
        </div>

    </div>
</section>