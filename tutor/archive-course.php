<?php
/**
 * Tutor LMS Course Archive
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main bg-paper" dir="rtl">

    <!-- Courses Hero -->
    <section
        class="courses-hero relative isolate overflow-hidden border-b border-line/60 py-16 sm:py-20 md:py-24"
        dir="rtl"
    >
        <!-- Full-width decorative background -->
        <div
            class="pointer-events-none absolute inset-0 -z-10 overflow-hidden"
            aria-hidden="true"
        >
            <!-- Main blue glow -->
            <div
                class="absolute left-1/2 top-0 h-[28rem] w-full max-w-5xl -translate-x-1/2 -translate-y-1/3 rounded-full bg-blue/10 blur-3xl sm:h-[34rem]"
            ></div>

            <!-- Right glow -->
            <div
                class="absolute -right-32 top-0 size-64 rounded-full bg-blue/5 blur-3xl sm:size-96"
            ></div>

            <!-- Left glow -->
            <div
                class="absolute -left-32 bottom-0 size-64 rounded-full bg-blue/5 blur-3xl sm:size-96"
            ></div>

            <!-- Full-width dot pattern -->
            <div class="courses-hero__grid absolute inset-0"></div>

            <!-- Decorative rings -->
            <div
                class="absolute -right-20 top-8 size-48 rounded-full border border-blue/10 sm:size-64"
            ></div>

            <div
                class="absolute -right-8 top-20 size-32 rounded-full border border-blue/10 sm:size-40"
            ></div>

            <div
                class="absolute -bottom-24 -left-16 size-48 rounded-full border border-blue/10 sm:size-64"
            ></div>
        </div>

        <!-- Hero content -->
        <div class="relative mx-auto w-full max-w-[1240px] px-[clamp(20px,5vw,72px)]">

            <?php get_template_part( 'templates/courses/archive-header' ); ?>

        </div>

        <!-- Bottom accent -->
        <div
            class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-blue/25 to-transparent"
            aria-hidden="true"
        ></div>
    </section>

    <!-- Courses Content -->
    <section
        class="courses-content mx-auto w-full max-w-[1240px] px-[clamp(20px,5vw,72px)] py-12 md:py-16"
        aria-label="<?php esc_attr_e( 'الدورات التعليمية', '3alemni' ); ?>"
    >

        <!-- Category Filters -->
        <?php get_template_part( 'templates/courses/category-filters' ); ?>

        <!-- Course Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8 lg:grid-cols-3">

            <?php if ( have_posts() ) : ?>

                <?php $course_index = 0; ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php
                    set_query_var( 'course_index', $course_index );

                    get_template_part( 'templates/courses/course-card' );

                    $course_index++;
                    ?>

                <?php endwhile; ?>

            <?php else : ?>

                <div class="col-span-full rounded-3xl border border-line bg-white p-8 text-center sm:p-12">
                    <div class="mx-auto mb-4 grid size-14 place-items-center rounded-2xl bg-blue/5 text-blue">
                        <svg
                            class="size-7"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                        </svg>
                    </div>

                    <p class="text-base font-semibold text-ink">
                        <?php esc_html_e( 'ماكاش دورات متوفرة حالياً.', '3alemni' ); ?>
                    </p>

                    <p class="mt-2 text-sm leading-7 text-muted">
                        <?php esc_html_e( 'ارجع لاحقاً، ممكن نضيفوا دورات جديدة قريباً.', '3alemni' ); ?>
                    </p>
                </div>

            <?php endif; ?>

        </div>

        <!-- Pagination -->
        <?php get_template_part( 'templates/courses/pagination' ); ?>

    </section>

</main>

<?php get_footer(); ?>