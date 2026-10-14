<?php
defined( 'ABSPATH' ) || exit;

$courses_url = get_post_type_archive_link( 'courses' );

if ( ! $courses_url ) {
    $courses_url = home_url( '/' );
}

$contact_page = get_page_by_path( 'contact' );
$contact_url  = $contact_page
    ? get_permalink( $contact_page )
    : home_url( '/' );
?>

<!-- About Story Section -->
<section
    data-reveal="up"
    class="about-reveal about-story group relative mt-20 overflow-hidden rounded-3xl border border-line/80 bg-white p-6 shadow-sm transition-shadow duration-500 hover:shadow-lg hover:shadow-blue/5 motion-reduce:transition-none sm:p-8 md:mt-24 md:p-12"
    style="--reveal-delay: 100ms"
    aria-labelledby="about-story-title"
    dir="rtl"
>
    <!-- Decorative Accent -->
    <div
        aria-hidden="true"
        class="pointer-events-none absolute -left-16 -top-16 size-48 rounded-full bg-blue/5 blur-3xl sm:size-64"
    ></div>

    <div class="relative grid items-center gap-10 lg:grid-cols-12 lg:gap-12">

        <!-- Story Content -->
        <div class="lg:col-span-7">

            <span class="inline-flex items-center gap-2 text-xs font-bold tracking-wide text-blue">
                <span class="h-px w-6 bg-blue/50" aria-hidden="true"></span>
                <?php esc_html_e( 'منهجيتنا', '3alemni' ); ?>
            </span>

            <h2
                id="about-story-title"
                class="mt-4 text-2xl font-extrabold leading-relaxed tracking-tight text-ink sm:text-3xl md:text-4xl"
            >
                <?php esc_html_e( 'علاش بنينا منصة علّمني؟', '3alemni' ); ?>
            </h2>

            <p class="mt-5 max-w-2xl text-sm leading-8 text-muted sm:text-base">
                <?php esc_html_e( 'نؤمنوا بلي التعلّم الفعّال ما يوقفش عند مشاهدة الدروس. الفهم الحقيقي يجي مع التجربة، التطبيق، وبناء مشاريع تساعدك تحوّل المعرفة إلى مهارة.', '3alemni' ); ?>
            </p>

            <p class="mt-3 max-w-2xl text-sm leading-8 text-muted sm:text-base">
                <?php esc_html_e( 'لهذا نطمحوا نخلو رحلة التعلّم أوضح وأكثر عملية، ونشجعوا كل متعلّم يجرّب، يغلط، يتعلّم، ويواصل التطوّر.', '3alemni' ); ?>
            </p>

            <!-- Actions -->
            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">

                <a
                    href="<?php echo esc_url( $courses_url ); ?>"
                    class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-blue px-6 py-3 text-sm font-bold text-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue/15 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 motion-reduce:transition-none"
                >
                    <?php esc_html_e( 'استكشف الدورات', '3alemni' ); ?>

                    <svg
                        class="size-4 transition-transform duration-200 motion-reduce:transition-none"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M19 12H5m7 7-7-7 7-7"/>
                    </svg>
                </a>

                <a
                    href="<?php echo esc_url( $contact_url ); ?>"
                    class="inline-flex min-h-12 items-center justify-center rounded-xl border border-line bg-white px-6 py-3 text-sm font-semibold text-ink transition duration-300 hover:border-blue/40 hover:text-blue focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 motion-reduce:transition-none"
                >
                    <?php esc_html_e( 'تواصل معنا', '3alemni' ); ?>
                </a>

            </div>
        </div>

        <!-- Brand Visual -->
        <div
            class="about-story__visual lg:col-span-5"
            aria-label="<?php esc_attr_e( 'هوية منصة علّمني', '3alemni' ); ?>"
        >
            <div class="relative mx-auto w-full max-w-sm">

                <!-- Decorative Frame -->
                <div
                    aria-hidden="true"
                    class="absolute -inset-3 rotate-3 rounded-3xl border border-blue/10 transition-transform duration-500 group-hover:rotate-2 motion-reduce:transition-none"
                ></div>

                <div class="relative overflow-hidden rounded-3xl border border-line/80 bg-paper p-7 shadow-sm sm:p-9">

                    <div class="flex items-center justify-between gap-4">
                        <span class="text-xs font-semibold tracking-wide text-muted">
                            <?php esc_html_e( 'رحلتك تبدأ هنا', '3alemni' ); ?>
                        </span>

                        <span class="size-2 rounded-full bg-blue" aria-hidden="true"></span>
                    </div>

                    <!-- Brand Mark -->
                    <div class="mx-auto mt-9 grid size-20 place-items-center rounded-3xl bg-blue text-3xl font-extrabold text-white shadow-lg shadow-blue/20 transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none">
                        <span aria-hidden="true">ع</span>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-2xl font-extrabold tracking-tight text-ink">
                            3alemni
                        </p>

                        <p class="mt-2 text-xs font-semibold tracking-[0.18em] text-blue">
                            LEARN · PRACTICE · GROW
                        </p>
                    </div>

                    <!-- Three Principles -->
                    <div class="mt-8 grid grid-cols-3 gap-2 border-t border-line pt-5 text-center">
                        <div class="rounded-xl bg-white px-2 py-3">
                            <span class="text-xs font-bold text-ink">
                                <?php esc_html_e( 'تعلّم', '3alemni' ); ?>
                            </span>
                        </div>

                        <div class="rounded-xl bg-white px-2 py-3">
                            <span class="text-xs font-bold text-ink">
                                <?php esc_html_e( 'طبّق', '3alemni' ); ?>
                            </span>
                        </div>

                        <div class="rounded-xl bg-white px-2 py-3">
                            <span class="text-xs font-bold text-ink">
                                <?php esc_html_e( 'تطوّر', '3alemni' ); ?>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>