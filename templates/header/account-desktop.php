
<?php
defined( 'ABSPATH' ) || exit;

$is_logged_in = is_user_logged_in();
$current_user = wp_get_current_user();

$dashboard_url = function_exists( 'tutor_utils' )
    ? tutor_utils()->tutor_dashboard_url()
    : admin_url();

$register_url = function_exists( 'tutor_utils' )
    ? tutor_utils()->student_register_url()
    : wp_registration_url();

$login_url = wp_login_url();

$display_name = $current_user->display_name;

$user_initial = $display_name
    ? mb_strtoupper( mb_substr( $display_name, 0, 1 ) )
    : 'U';
?>

<div class="hidden shrink-0 items-center gap-3 md:flex">
    <?php if ( $is_logged_in ) : ?>

        <a
            href="<?php echo esc_url( $dashboard_url ); ?>"
            class="group inline-flex min-h-11 max-w-[210px] items-center gap-2.5 rounded-xl border border-line/80 bg-white px-3 py-2 text-sm font-semibold text-ink no-underline shadow-sm transition-all duration-200 hover:border-blue/40 hover:shadow-md lg:px-4"
            title="<?php esc_attr_e( 'لوحة التحكم', '3alemni' ); ?>"
        >
            <span class="grid size-8 shrink-0 place-items-center rounded-full bg-blue/10 text-xs font-bold text-blue transition-colors group-hover:bg-blue/15">
                <?php echo esc_html( $user_initial ); ?>
            </span>

            <span class="max-w-[100px] truncate transition-colors group-hover:text-blue lg:max-w-[120px]">
                <?php echo esc_html( $display_name ); ?>
            </span>

            <svg
                class="size-4 shrink-0 text-muted transition-transform duration-200 group-hover:translate-x-0.5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </a>

    <?php else : ?>

        <a
            href="<?php echo esc_url( $login_url ); ?>"
            class="inline-flex min-h-11 items-center justify-center rounded-3xl border border-line/80 bg-blue px-5 text-sm font-semibold text-white! no-underline shadow-sm transition-all duration-200 hover:border-blue/40 hover:bg-blue/5 hover:text-ink! focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue"
        >
            <?php esc_html_e( 'تسجيل الدخول', '3alemni' ); ?>
        </a>

        <?php if ( get_option( 'users_can_register' ) ) : ?>
            <a
                href="<?php echo esc_url( $register_url ); ?>"
                class="group inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue px-5 text-sm font-semibold text-white! no-underline shadow-sm shadow-blue/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-dark hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue"
            >
                <?php esc_html_e( 'إنشاء حساب', '3alemni' ); ?>

                <svg
                    aria-hidden="true"
                    viewBox="0 0 24 24"
                    fill="none"
                    class="h-4 w-4 transition-transform duration-200 group-hover:-translate-y-0.5 group-hover:translate-x-0.5"
                >
                    <path
                        d="M7 17 17 7M7 7h10v10"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </a>
        <?php endif; ?>

    <?php endif; ?>
</div>
