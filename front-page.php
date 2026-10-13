
<?php
defined( 'ABSPATH' ) || exit;

get_header();

$courses_url = get_post_type_archive_link( 'courses' );

if ( ! $courses_url ) {
    $courses_url = home_url( '/' );
}

$courses = new WP_Query(
    [
        'post_type'           => 'courses',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ]
);
?>

<main id="main-content">
 
    <section class="relative isolate overflow-hidden bg-paper py-16 sm:py-20 lg:py-28
    before:pointer-events-none before:absolute before:inset-0 before:-z-10
    before:bg-[radial-gradient(ellipse_at_85%_20%,rgba(36,78,232,0.13),transparent_42%),radial-gradient(ellipse_at_10%_85%,rgba(36,78,232,0.07),transparent_35%)]
    after:pointer-events-none after:absolute after:inset-0 after:-z-10
    after:bg-[radial-gradient(circle,rgba(32,35,31,0.16)_1px,transparent_1.2px)]
    after:bg-[size:22px_22px]" dir="rtl" lang="ar">
        <div class="mx-auto grid w-full max-w-[1240px] grid-cols-1 items-center gap-12 px-[clamp(20px,5vw,72px)] lg:grid-cols-[minmax(0,1.1fr)_minmax(300px,0.9fr)] lg:gap-16">

            <div class="min-w-0">
                <p class="mb-6 inline-flex items-center gap-3 text-xs font-semibold tracking-wide text-muted sm:text-sm">
                    <span class="h-2 w-2 rounded-full bg-blue" aria-hidden="true"></span>
                    <span>3alemni / منصة التعلّم</span>
                </p>

                <h1 class="max-w-3xl text-5xl font-semibold leading-[1.35] tracking-normal text-ink sm:text-6xl lg:text-7xl">
                    تعلّم مهارة.
                    <br>
                    ابنِ ثقتك.
                    <br>
                    <span class="text-blue">وابدأ.</span>
                </h1>

                <p class="mt-7 max-w-xl text-base leading-8 text-muted sm:text-lg sm:leading-9">
                    طريقك للتعلّم ما لازم يكون معقّد.
                    اكتشف دورات واضحة، تعلّم في وقتك،
                    وطبّق واش تتعلّم خطوة بخطوة.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3 sm:gap-4">
                    <a
                        class="inline-flex min-h-14 items-center justify-center gap-5 rounded-full bg-blue px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-blue-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"
                        href="<?php echo esc_url( $courses_url ); ?>"
                    >
                        اكتشف الدورات
                        

<svg
    aria-hidden="true"
    viewBox="0 0 24 24"
    fill="none"
    class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1 group-hover:-translate-y-1"
>
    <path
        d="M7 17 17 7M7 7h10v10"
        transform="rotate(-90 12 12)"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
    />
</svg>
                    </a>

                    <a
                        class="inline-flex min-h-14 items-center justify-center rounded-full border border-line px-6 py-3 text-sm font-semibold text-ink transition-colors hover:border-ink focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"
                        href="#approach"
                    >
                        كيفاش نتعلّم؟
                    </a>
                </div>

                <div class="mt-8 flex items-center gap-3 text-sm text-muted">
                    <span class="h-px w-8 bg-blue" aria-hidden="true"></span>
                    <span>تعلّم على وتيرتك. تقدّم بخطواتك.</span>
                </div>
            </div>

            <div
                class="relative flex min-h-[360px] flex-col justify-between overflow-hidden rounded-[2rem] bg-ink p-6 text-white sm:min-h-[440px] sm:p-9 lg:min-h-[500px]"
                dir="ltr"
                aria-label="Learn. Practice. Grow."
            >
                <div class="flex items-center justify-between gap-4 border-b border-white/20 pb-4 text-[10px] font-medium tracking-[0.16em] text-white/70 sm:text-xs">
                    <span>3ALEMNI®</span>
                    <span>LEARNING / 001</span>
                </div>

                <div class="relative flex flex-1 items-center justify-center py-8">
                    <span
                        class="absolute right-2 top-1/2 h-24 w-24 -translate-y-1/2 rotate-12 rounded-2xl bg-blue sm:right-8 sm:h-32 sm:w-32"
                        aria-hidden="true"
                    ></span>

                    <span
                        class="relative z-10 text-[clamp(10rem,24vw,18rem)] font-semibold leading-none tracking-normal text-paper"
                        aria-hidden="true"
                    >ع</span>

                    <span class="absolute bottom-5 left-0 text-[10px] font-medium tracking-[0.2em] text-white/50 sm:text-xs">
                        LEARN / PRACTICE / GROW
                    </span>
                </div>

                <div class="flex items-end justify-between gap-4 border-t border-white/20 pt-5">
                    <p class="max-w-[190px] text-sm leading-6 text-white/75 sm:text-base sm:leading-7">
                        Learn with intent.
                        <br>
                        Build with confidence.
                    </p>
                    <span class="shrink-0 text-xs font-semibold tracking-wider text-white sm:text-sm">
                        LEARN → DO  
                    </span>
                </div>
            </div>

        </div>
    </section>


<section
    class="border-y border-line/80 bg-white/50 py-12 sm:py-16 lg:py-20"
    aria-label="مبادئ التعلّم"
    dir="rtl"
    lang="ar"
>
    <div class="mx-auto grid w-full max-w-[1240px] grid-cols-1 px-[clamp(20px,5vw,72px)] sm:grid-cols-2 lg:grid-cols-3">

        <article class="group border-b border-line py-7 sm:pl-7 lg:border-b-0 lg:border-l lg:pl-8 lg:pr-6">
            <div class="mb-7 flex items-center justify-between gap-4">
                <span class="text-xs font-semibold tracking-wide text-muted">01 / تعلّم</span>
            </div>

            <h2 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                مسار واضح
            </h2>

            <p class="mt-3 max-w-sm text-sm leading-7 text-muted">
                اعرف واش تتعلّم، وعلاش تتعلّمو.
            </p>
        </article>

        <article class="group border-b border-line py-7 sm:border-b-0 sm:pr-7 lg:border-l lg:px-8">
            <div class="mb-7 flex items-center justify-between gap-4">
                <span class="text-xs font-semibold tracking-wide text-muted">02 / طبّق</span>
            </div>

            <h2 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                معرفة تتحوّل لمهارة
            </h2>

            <p class="mt-3 max-w-sm text-sm leading-7 text-muted">
                ركّز على الفهم والتطبيق، ماشي المشاهدة فقط.
            </p>
        </article>

        <article class="group py-7 sm:col-span-2 lg:col-span-1 lg:pr-8">
            <div class="mb-7 flex items-center justify-between gap-4">
                <span class="text-xs font-semibold tracking-wide text-muted">03 / تطوّر</span>
            </div>

            <h2 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                تقدّم خطوة بخطوة
            </h2>

            <p class="mt-3 max-w-sm text-sm leading-7 text-muted">
                ابنِ على واش تعلّمت، دورة بعد دورة.
            </p>
        </article>

    </div>
</section>

    
<section class="border-t border-line/80 bg-paper py-20 sm:py-24 lg:py-28" id="courses">
    <div class="mx-auto w-full max-w-[1240px] px-[clamp(20px,5vw,72px)]">

        <!-- Section heading -->
        <div class="mb-10 flex flex-col items-start justify-between gap-6 sm:mb-14 sm:flex-row sm:items-end">
            <div dir="rtl" lang="ar" class="max-w-2xl">
                <p class="mb-4 flex items-center gap-3 text-sm font-semibold text-blue">
                    <span class="h-px w-8 bg-blue" aria-hidden="true"></span>
                    تعلّم حاجة جديدة
                </p>

                <h2 class="text-4xl font-semibold leading-tight tracking-normal text-ink sm:text-5xl lg:text-6xl">
                    ابدأ من هنا<span class="text-blue">.</span>
                </h2>

                <p class="mt-5 max-w-xl text-base leading-8 text-muted sm:text-lg">
                    اكتشف الدورات المتاحة، واختار الخطوة
                    اللي تناسب أهدافك.
                </p>
            </div>

            <a
                href="<?php echo esc_url( $courses_url ); ?>"
                class="group inline-flex min-h-12 shrink-0 items-center gap-4 rounded-full border border-line px-5 py-3 text-sm font-semibold text-ink transition-colors hover:border-blue hover:text-blue focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"
                dir="rtl"
                lang="ar"
            >
                جميع الدورات


<svg
    aria-hidden="true"
    viewBox="0 0 24 24"
    fill="none"
    class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1 group-hover:-translate-y-1"
>
    <path
        d="M7 17 17 7M7 7h10v10"
        transform="rotate(-90 12 12)"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
    />
</svg>            </a>
        </div>

        <!-- Course cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">

            <?php if ( $courses->have_posts() ) : ?>
                <?php while ( $courses->have_posts() ) : ?>
                    <?php
                    $courses->the_post();
                    $course_id = get_the_ID();
                    ?>

                    <article class="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-line bg-white transition duration-300 hover:-translate-y-1 hover:border-blue/30 hover:shadow-[0_18px_45px_rgba(32,35,31,0.08)]">

                        <!-- Course image -->
                        <a
                            class="relative block aspect-[5/3] shrink-0 overflow-hidden bg-[#eeece4] focus-visible:outline-2 focus-visible:outline-offset-[-4px] focus-visible:outline-blue"
                            href="<?php echo esc_url( get_permalink() ); ?>"
                            aria-label="<?php echo esc_attr( get_the_title() ); ?>"
                        >
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php
                                echo get_the_post_thumbnail(
                                    $course_id,
                                    'large',
                                    [
                                        'class'         => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.04]',
                                        'loading'       => 'lazy',
                                        'decoding'      => 'async',
                                        'alt'           => get_the_title(),
                                    ]
                                );
                                ?>
                            <?php else : ?>
                                <span
                                    class="flex h-full w-full items-center justify-center text-7xl font-semibold text-blue/25"
                                    aria-hidden="true"
                                >ع.</span>
                            <?php endif; ?>

                            <span class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/15 to-transparent" aria-hidden="true"></span>

                            <span class="absolute left-4 top-4 inline-flex items-center rounded-full border border-white/70 bg-white/90 px-3 py-1.5 text-[11px] font-semibold tracking-wide text-ink backdrop-blur-sm">
                                3ALEMNI
                            </span>
                        </a>

                        <!-- Course details -->
                        <div class="flex flex-1 flex-col p-5 sm:p-6" dir="rtl" lang="ar">

                            <p class="mb-3 text-xs font-semibold text-blue">
                                دورة تعليمية
                            </p>

                            <h3 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                                <a
                                    class="transition-colors hover:text-blue focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"
                                    href="<?php echo esc_url( get_permalink() ); ?>"
                                >
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <?php if ( has_excerpt() ) : ?>
                                <p class="mt-3 line-clamp-3 text-sm leading-7 text-muted">
                                    <?php echo esc_html( get_the_excerpt() ); ?>
                                </p>
                            <?php else : ?>
                                <p class="mt-3 text-sm leading-7 text-muted">
                                    اكتشف محتوى الدورة وابدأ رحلتك في التعلّم.
                                </p>
                            <?php endif; ?>

                            <div class="mt-6 flex items-center justify-between gap-3 border-t border-line pt-4">
                                <span class="text-xs text-muted">
                                    تعلّم على وتيرتك
                                </span>

                                <a
                                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-paper text-lg text-ink transition-colors group-hover:bg-blue group-hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"
                                    href="<?php echo esc_url( get_permalink() ); ?>"
                                    aria-label="<?php
                                    echo esc_attr(
                                        sprintf(
                                            'اكتشف دورة %s',
                                            get_the_title()
                                        )
                                    );
                                    ?>"
                                >
                                    

<svg
    aria-hidden="true"
    viewBox="0 0 24 24"
    fill="none"
    class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1 group-hover:-translate-y-1"
>
    <path
        d="M7 17 17 7M7 7h10v10"
        transform="rotate(-90 12 12)"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
    />
</svg>
                                </a>
                            </div>

                        </div>
                    </article>

                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>

            <?php else : ?>

                <div class="col-span-full rounded-2xl border border-dashed border-line bg-white/60 px-6 py-12 text-center sm:px-10 sm:py-16" dir="rtl" lang="ar">
                    <span class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue/10 text-2xl font-semibold text-blue" aria-hidden="true">ع.</span>

                    <h3 class="text-xl font-semibold text-ink sm:text-2xl">
                        الدورات تاعك تبدأ من هنا.
                    </h3>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-muted sm:text-base">
                        كي تنشر أول دورة، راح تظهر هنا تلقائيًا.
                    </p>

                    <a
                        class="mt-6 inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-blue px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-blue-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"
                        href="<?php echo esc_url( $courses_url ); ?>"
                    >
                        اكتشف الدورات
                        

<svg
    aria-hidden="true"
    viewBox="0 0 24 24"
    fill="none"
    class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1 group-hover:-translate-y-1"
>
    <path
        d="M7 17 17 7M7 7h10v10"
        transform="rotate(-90 12 12)"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
    />
</svg>
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>


<section class="relative overflow-hidden border-t border-line/80 bg-paper py-20 sm:py-24 lg:py-28" id="approach">
    <div class="mx-auto w-full max-w-[1240px] px-[clamp(20px,5vw,72px)]" dir="rtl" lang="ar">

        <div class="mb-12 max-w-2xl sm:mb-16">
            <p class="mb-4 flex items-center gap-3 text-sm font-semibold text-blue">
                <span class="h-px w-8 bg-blue" aria-hidden="true"></span>
                طريقة بسيطة، هدف واضح
            </p>

            <h2 class="text-4xl font-semibold leading-[1.4] tracking-normal text-ink sm:text-5xl lg:text-6xl">
                ماشي غير تتفرّج.
                <br>
                <span class="text-muted">تعلّم وتقدّم.</span>
            </h2>

            <p class="mt-5 max-w-xl text-base leading-8 text-muted sm:text-lg">
                تعلّم بطريقة تخليك تفهم، تطبّق، وتبني مهارات تقدر تستعملها.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:gap-5">

            <article class="group relative flex min-h-[250px] flex-col rounded-2xl border border-line bg-white p-6 transition-colors duration-300 hover:border-blue/40 sm:p-8">
                <div class="mb-10 flex items-center justify-between gap-4">
                    <span class="text-xs font-semibold tracking-wide text-muted">01 — افهم</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-paper text-lg text-ink transition-colors group-hover:bg-blue group-hover:text-white" aria-hidden="true">01</span>
                </div>

                <h3 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                    ابدأ بالأساسيات
                </h3>

                <p class="mt-3 max-w-sm text-sm leading-7 text-muted">
                    كوّن فهم واضح قبل ما تنتقل للمفاهيم الأكثر تقدّمًا.
                </p>

            </article>

            <article class="group relative flex min-h-[250px] flex-col rounded-2xl border border-line bg-white p-6 transition-colors duration-300 hover:border-blue/40 sm:p-8">
                <div class="mb-10 flex items-center justify-between gap-4">
                    <span class="text-xs font-semibold tracking-wide text-muted">02 — طبّق</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-paper text-lg text-ink transition-colors group-hover:bg-blue group-hover:text-white" aria-hidden="true">02</span>
                </div>

                <h3 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                    حوّل المعرفة إلى عمل
                </h3>

                <p class="mt-3 max-w-sm text-sm leading-7 text-muted">
                    خصّص وقتًا للتطبيق، وراجع واش قدرت تنجز وحدك.
                </p>

            </article>

            <article class="group relative flex min-h-[250px] flex-col rounded-2xl border border-line bg-white p-6 transition-colors duration-300 hover:border-blue/40 sm:col-span-2 sm:min-h-[220px] sm:flex-row sm:items-end sm:justify-between sm:gap-8 sm:p-8 lg:col-span-1 lg:min-h-[250px] lg:flex-col lg:items-stretch lg:justify-start lg:gap-0">
                <div class="min-w-0">
                    <div class="mb-10 flex items-center justify-between gap-4">
                        <span class="text-xs font-semibold tracking-wide text-muted">03 — واصل</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-paper text-lg text-ink transition-colors group-hover:bg-blue group-hover:text-white" aria-hidden="true">03</span>
                    </div>

                    <h3 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                        ابنِ على تقدّمك
                    </h3>

                    <p class="mt-3 max-w-sm text-sm leading-7 text-muted">
                        واصل التعلّم خطوة بخطوة، حسب هدفك والوقت المتاح ليك.
                    </p>
                </div>

            </article>

        </div>
    </div>
</section>
</main>

<?php get_footer(); ?>