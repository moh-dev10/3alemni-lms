<?php

defined( 'ABSPATH' ) || exit;

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

<section

    class="courses-showcase relative isolate overflow-hidden border-t border-line/80 bg-paper py-20 sm:py-24 lg:py-28"

    id="courses"

    dir="rtl"

    lang="ar"

>

    <div class="courses-showcase__glow" aria-hidden="true"></div>

    <div class="relative mx-auto w-full max-w-[1240px] px-[clamp(20px,5vw,72px)]">

        <!-- Section heading -->

        <div class="courses-heading mb-10 flex flex-col items-start justify-between gap-6 sm:mb-14 sm:flex-row sm:items-end" data-reveal="up">

            <div class="max-w-2xl">

                <p class="mb-4 flex items-center gap-3 text-sm font-semibold text-blue">

                    <span class="h-px w-8 bg-blue" aria-hidden="true"></span>

                    تعلّم حاجة جديدة

                </p>

                <h2 class="text-4xl font-semibold leading-tight tracking-tight text-ink sm:text-5xl lg:text-6xl">

                    ابدأ من هنا<span class="text-blue">.</span>

                </h2>

                <p class="mt-5 max-w-xl text-base leading-8 text-muted sm:text-lg">

                    اكتشف الدورات المتاحة، واختار الخطوة

                    اللي تناسب أهدافك.

                </p>

            </div>

            <a

                href="<?php echo esc_url( $courses_url ); ?>"

                class="courses-all-link group inline-flex min-h-12 shrink-0 items-center gap-4 rounded-full border border-line bg-white/70 px-5 py-3 text-sm font-semibold text-ink transition-all duration-200 hover:border-blue/30 hover:bg-white hover:text-blue focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"

            >

                جميع الدورات

                <svg

                    aria-hidden="true"

                    viewBox="0 0 24 24"

                    fill="none"

                    class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1"

                >

                    <path

                        d="M19 12H5m0 0 6 6m-6-6 6-6"

                        stroke="currentColor"

                        stroke-width="1.8"

                        stroke-linecap="round"

                        stroke-linejoin="round"

                    />

                </svg>

            </a>

        </div>

        <!-- Course cards -->

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">

            <?php if ( $courses->have_posts() ) : ?>

                <?php

                $course_index = 0;

                ?>

                <?php while ( $courses->have_posts() ) : ?>

                    <?php

                    $courses->the_post();

                    $course_id    = get_the_ID();

                    $course_title = get_the_title();

                    $course_url   = get_permalink();

                    $course_index++;

                    ?>

                    <article

                        class="course-card group flex min-w-0 flex-col overflow-hidden rounded-[24px] border border-line/80 bg-white"

                        style="--course-index: <?php echo esc_attr( (string) $course_index ); ?>;"

                    >

                        <!-- Course thumbnail -->

                        <a

                            class="course-card__media relative block aspect-[5/3] shrink-0 overflow-hidden bg-[#EDEFF8] focus-visible:outline-2 focus-visible:outline-offset-[-4px] focus-visible:outline-blue"

                            href="<?php echo esc_url( $course_url ); ?>"

                            aria-label="<?php echo esc_attr( $course_title ); ?>"

                            tabindex="0"

                        >

                            <?php if ( has_post_thumbnail() ) : ?>

                                <?php

                                echo get_the_post_thumbnail(

                                    $course_id,

                                    'large',

                                    [

                                        'class'         => 'course-card__image h-full w-full object-cover',

                                        'loading'       => 'lazy',

                                        'decoding'      => 'async',

                                        'alt'           => $course_title,

                                        'sizes'         => '(max-width: 639px) calc(100vw - 40px), (max-width: 1023px) 50vw, 400px',

                                    ]

                                );

                                ?>

                            <?php else : ?>

                                <span class="course-card__placeholder flex h-full w-full items-center justify-center" aria-hidden="true">

                                    <span class="course-card__placeholder-mark">ع.</span>

                                    <span class="course-card__placeholder-orbit"></span>

                                </span>

                            <?php endif; ?>

                            <span class="course-card__image-overlay" aria-hidden="true"></span>

                            <span class="absolute right-4 top-4 inline-flex items-center gap-2 rounded-full border border-white/70 bg-white/90 px-3 py-1.5 text-[10px] font-bold tracking-wider text-ink backdrop-blur-md sm:text-[11px]">

                                <span class="size-1.5 rounded-full bg-blue" aria-hidden="true"></span>

                                3ALEMNI

                            </span>

                            <span class="course-card__media-arrow absolute bottom-4 left-4 grid size-10 place-items-center rounded-full border border-white/40 bg-white/90 text-ink shadow-sm backdrop-blur-md transition-all duration-300" aria-hidden="true">

                                <svg viewBox="0 0 24 24" fill="none" class="size-4">

                                    <path

                                        d="M19 12H5m0 0 6 6m-6-6 6-6"

                                        stroke="currentColor"

                                        stroke-width="1.8"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                    />

                                </svg>

                            </span>

                        </a>

                        <!-- Course content -->

                        <div class="flex flex-1 flex-col p-5 sm:p-6">

                            <div class="mb-3 flex items-center justify-between gap-3">

                                <span class="text-xs font-semibold text-blue">

                                    دورة تعليمية

                                </span>

                                <span class="text-[10px] font-medium tracking-wider text-muted/80">

                                    <?php

                                    echo esc_html(

                                        sprintf( '%02d', $course_index )

                                    );

                                    ?>

                                </span>

                            </div>

                            <h3 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">

                                <a

                                    class="rounded-sm transition-colors duration-200 hover:text-blue focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"

                                    href="<?php echo esc_url( $course_url ); ?>"

                                >

                                    <?php echo esc_html( $course_title ); ?>

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

                            <div class="mt-auto pt-6">

                                <div class="flex items-center justify-between gap-3 border-t border-line pt-4">

                                    <span class="flex items-center gap-2 text-xs text-muted">

                                        <svg viewBox="0 0 20 20" fill="none" class="size-4 text-blue" aria-hidden="true">

                                            <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>

                                            <path d="M10 6v4l2.5 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>

                                        </svg>

                                        تعلّم على وتيرتك

                                    </span>

                                    <a

                                        class="course-card__action inline-flex min-h-10 items-center gap-2 rounded-full px-3 text-xs font-semibold text-ink transition-all duration-200 hover:bg-blue/5 hover:text-blue focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue"

                                        href="<?php echo esc_url( $course_url ); ?>"

                                        aria-label="<?php

                                        echo esc_attr(

                                            sprintf(

                                                'اكتشف دورة %s',

                                                $course_title

                                            )

                                        );

                                        ?>"

                                    >

                                        اكتشف الدورة

                                        <svg

                                            aria-hidden="true"

                                            viewBox="0 0 24 24"

                                            fill="none"

                                            class="size-4 transition-transform duration-200 group-hover:-translate-x-1"

                                        >

                                            <path

                                                d="M19 12H5m0 0 6 6m-6-6 6-6"

                                                stroke="currentColor"

                                                stroke-width="1.8"

                                                stroke-linecap="round"

                                                stroke-linejoin="round"

                                            />

                                        </svg>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php else : ?>

                <div class="col-span-full rounded-[24px] border border-dashed border-line bg-white/70 px-6 py-12 text-center sm:px-10 sm:py-16" data-reveal="up">

                    <span class="course-card__placeholder-mark mx-auto grid size-14 place-items-center rounded-2xl bg-blue/10 text-2xl font-semibold text-blue" aria-hidden="true">

                        ع.

                    </span>

                    <h3 class="mt-5 text-xl font-semibold text-ink sm:text-2xl">

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

                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" class="size-4">

                            <path d="M19 12H5m0 0 6 6m-6-6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>

                        </svg>

                    </a>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>
