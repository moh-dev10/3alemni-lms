
<?php
defined( 'ABSPATH' ) || exit;

$is_logged_in = is_user_logged_in();

$dashboard_url = function_exists( 'tutor_utils' )
    ? tutor_utils()->tutor_dashboard_url()
    : admin_url();

$register_url = function_exists( 'tutor_utils' )
    ? tutor_utils()->student_register_url()
    : wp_registration_url();

$login_url  = wp_login_url();
$logout_url = wp_logout_url( home_url( '/' ) );
?>

<div class="flex flex-col gap-2 border-t border-line/80 py-4 md:hidden">
    <?php if ( $is_logged_in ) : ?>

        <a
            href="<?php echo esc_url( $dashboard_url ); ?>"
            class="group inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-ink px-5 py-3 text-sm font-semibold text-white! no-underline transition-all duration-200 hover:bg-blue focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue"
        >
            <span><?php esc_html_e( 'Go to dashboard', '3alemni' ); ?></span>

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

        <a
            href="<?php echo esc_url( $logout_url ); ?>"
            class="inline-flex min-h-11 items-center justify-center rounded-xl px-5 py-3 text-sm font-medium text-muted no-underline transition-colors duration-200 hover:bg-red-50 hover:text-red-600"
        >
            <?php esc_html_e( 'تسجيل الخروج', '3alemni' ); ?>
        </a>

    <?php else : ?>

        <a
            href="<?php echo esc_url( $login_url ); ?>"
            class="inline-flex min-h-11 items-center justify-center rounded-xl border border-line bg-white px-5 py-3 text-sm font-semibold text-ink no-underline transition-all duration-200 hover:border-blue/40 hover:bg-blue/5 hover:text-blue focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue"
        >
            <?php esc_html_e( 'تسجيل الدخول', '3alemni' ); ?>
        </a>

        <?php if ( get_option( 'users_can_register' ) ) : ?>
            <a
                href="<?php echo esc_url( $register_url ); ?>"
                class="group inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-blue px-5 py-3 text-sm font-semibold text-white! no-underline shadow-sm shadow-blue/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-dark hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue"
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
