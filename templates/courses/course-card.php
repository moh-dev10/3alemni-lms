<?php
/**
 * Reusable Course Card Component
 *
 * Expects the current WordPress post to be a course.
 *
 * @package 3alemni
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();

if ( ! $course_id ) {
    return;
}

$course_index = (int) get_query_var( 'course_index', 0 );

$instructor = get_userdata(
    get_post_field( 'post_author', $course_id )
);

$instructor_name = $instructor
    ? $instructor->display_name
    : '3alemni';

$avatar_url = $instructor
    ? get_avatar_url( $instructor->ID, [ 'size' => 72 ] )
    : '';

/**
 * Course access and pricing.
 */
$is_public = function_exists( 'tutor_utils' )
    ? tutor_utils()->is_public_course( $course_id )
    : false;

$is_free = function_exists( 'tutor_utils' )
    ? (
        tutor_utils()->is_course_free( $course_id )
        || $is_public
    )
    : false;

$price_info = function_exists( 'tutor_utils' )
    ? tutor_utils()->get_raw_course_price( $course_id )
    : null;

$regular_price = ! empty( $price_info->regular_price )
    ? $price_info->regular_price
    : '';

$sale_price = ! empty( $price_info->sale_price )
    ? $price_info->sale_price
    : '';

/**
 * Course rating.
 */
$rating = function_exists( 'tutor_utils' )
    ? tutor_utils()->get_course_rating( $course_id )
    : null;

$rating_avg = ! empty( $rating->rating_avg )
    ? number_format( (float) $rating->rating_avg, 1 )
    : '5.0';

$reveal_delay = min( $course_index * 100, 500 );
?>

<article
    data-reveal="up"
    class="course-card group flex flex-col overflow-hidden rounded-3xl border border-line/80 bg-white shadow-sm transition-[transform,box-shadow,border-color] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)] hover:-translate-y-1.5 hover:border-blue/30 hover:shadow-lg motion-reduce:transition-none"    style="--reveal-delay: <?php echo esc_attr( $reveal_delay ); ?>ms"
>

    <!-- Thumbnail -->
    <a
        href="<?php the_permalink(); ?>"
        class="relative aspect-[16/10] overflow-hidden bg-paper"
        aria-label="<?php echo esc_attr( get_the_title() ); ?>"
    >

        <?php if ( has_post_thumbnail() ) : ?>

            <?php
            the_post_thumbnail(
                'medium_large',
                [
                    'class'   => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105',
                    'loading' => 'lazy',
                ]
            );
            ?>

        <?php else : ?>

            <div class="grid h-full w-full place-items-center bg-blue/5 text-blue">
                <span class="text-3xl font-bold">ع</span>
            </div>

        <?php endif; ?>

        <!-- Price Badge -->
        <div class="absolute right-4 top-4">

            <?php if ( $is_free ) : ?>

                <span class="rounded-xl border border-emerald-500/20 bg-emerald-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm backdrop-blur-md">
                    <?php esc_html_e( 'مجاني', '3alemni' ); ?>
                </span>

            <?php else : ?>

                <span class="rounded-xl border border-line/20 bg-ink/90 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm backdrop-blur-md">
                    <?php
                    if ( ! empty( $sale_price ) ) {
                        echo esc_html( $sale_price ) . '$';
                    } elseif ( ! empty( $regular_price ) ) {
                        echo esc_html( $regular_price ) . '$';
                    } else {
                        esc_html_e( 'مدفوع', '3alemni' );
                    }
                    ?>
                </span>

            <?php endif; ?>

        </div>
    </a>

    <!-- Card Body -->
    <div class="flex flex-1 flex-col justify-between p-7">

        <div>

            <!-- Rating & Meta -->
            <div class="mb-3 flex items-center justify-between text-xs font-medium text-muted">

                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 text-amber-500">
                        ★
                        <span class="font-semibold text-ink">
                            <?php echo esc_html( $rating_avg ); ?>
                        </span>
                    </span>
                </div>

                <span class="rounded-lg bg-paper px-2.5 py-1 text-[11px] font-semibold text-muted">
                    <?php esc_html_e( 'دورة تفاعلية', '3alemni' ); ?>
                </span>

            </div>

            <!-- Course Title -->
            <h2 class="text-lg font-bold leading-snug text-ink transition-colors duration-300 group-hover:text-blue">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

        </div>

        <!-- Instructor & Action -->
        <div class="mt-8 flex items-center justify-between border-t border-line/60 pt-5">

            <!-- Instructor -->
            <div class="flex items-center gap-3">

                <?php if ( $avatar_url ) : ?>

                    <img
                        src="<?php echo esc_url( $avatar_url ); ?>"
                        alt="<?php echo esc_attr( $instructor_name ); ?>"
                        class="size-9 rounded-full border border-line object-cover"
                        loading="lazy"
                    >

                <?php else : ?>

                    <div class="grid size-9 place-items-center rounded-full bg-blue/10 text-xs font-bold text-blue">
                        <?php
                        echo esc_html(
                            strtoupper(
                                substr( $instructor_name, 0, 1 )
                            )
                        );
                        ?>
                    </div>

                <?php endif; ?>

                <span class="text-xs font-semibold text-ink">
                    <?php echo esc_html( $instructor_name ); ?>
                </span>

            </div>

            <!-- CTA -->
            <a
                href="<?php the_permalink(); ?>"
                class="inline-flex items-center gap-1.5 text-xs font-bold text-blue transition-transform duration-300 group-hover:-translate-x-1"
            >
                <span>
                    <?php esc_html_e( 'ابدأ التعلم', '3alemni' ); ?>
                </span>

                <svg
                    class="size-3.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 12H5m7 7l-7-7 7-7"
                    />
                </svg>
            </a>

        </div>

    </div>

</article>