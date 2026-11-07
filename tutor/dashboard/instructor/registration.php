<?php
/**
 * 3alemni — Instructor Registration Template Override
 *
 * Fully compatible with Tutor LMS instructor application and registration workflow.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\User;
use TUTOR\Instructors_List;

// 1. If user is logged in, check their instructor application status
if ( is_user_logged_in() ) :
    $current_user_id   = get_current_user_id();
    $current_user      = wp_get_current_user();
    $dashboard_url     = function_exists( 'tutor_utils' ) ? tutor_utils()->tutor_dashboard_url() : admin_url();
    $instructor_status = function_exists( 'tutor_utils' ) ? tutor_utils()->instructor_status( $current_user_id, false ) : '';
    $instructor_status = is_string( $instructor_status ) ? strtolower( $instructor_status ) : '';

    if ( function_exists( 'tutor_utils' ) && tutor_utils()->is_instructor( $current_user_id ) ) :
        ?>
        <div class="mx-auto w-full max-w-xl rounded-3xl border border-line/80 bg-white p-8 text-center shadow-sm sm:p-10" dir="rtl">
            <div class="mx-auto mb-4 grid size-14 place-items-center rounded-2xl bg-emerald-50 text-2xl font-bold text-emerald-600">
                ✓
            </div>
            <h2 class="text-2xl font-extrabold text-ink">
                <?php esc_html_e( 'أنت مسجّل بالفعل كأستاذ', '3alemni' ); ?>
            </h2>
            <p class="mt-3 text-sm leading-7 text-muted">
                <?php esc_html_e( 'حسابك معتمد كأستاذ في المنصة. يمكنك التوجه إلى لوحة التحكم لإدارة دوراتك وطلابك.', '3alemni' ); ?>
            </p>
            <div class="mt-8">
                <a
                    href="<?php echo esc_url( $dashboard_url ); ?>"
                    class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-blue px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-dark"
                >
                    <?php esc_html_e( 'الانتقال إلى لوحة الأستاذ', '3alemni' ); ?>
                </a>
            </div>
        </div>
        <?php
        return;
    elseif ( Instructors_List::STATUS_PENDING === $instructor_status ) :
        ?>
        <div class="mx-auto w-full max-w-xl rounded-3xl border border-amber-200 bg-amber-50/70 p-8 text-center shadow-sm sm:p-10" dir="rtl">
            <div class="mx-auto mb-4 grid size-14 place-items-center rounded-2xl bg-amber-100 text-2xl font-bold text-amber-600">
                ⏳
            </div>
            <h2 class="text-2xl font-extrabold text-ink">
                <?php esc_html_e( 'طلبك قيد المراجعة', '3alemni' ); ?>
            </h2>
            <p class="mt-3 text-sm leading-7 text-muted">
                <?php esc_html_e( 'تم استلام طلب انضمامك كأستاذ في علّمني وهو حالياً قيد المراجعة من طرف الإدارة. سنقوم بإشعارك فور اعتماده.', '3alemni' ); ?>
            </p>
            <div class="mt-8">
                <a
                    href="<?php echo esc_url( $dashboard_url ); ?>"
                    class="inline-flex min-h-12 items-center justify-center rounded-xl bg-ink px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue"
                >
                    <?php esc_html_e( 'العودة للوحة التحكم', '3alemni' ); ?>
                </a>
            </div>
        </div>
        <?php
        return;
    endif;
endif;

// 2. Check if Instructor Registration is enabled in Tutor LMS settings
$instructor_reg_enabled = function_exists( 'tutor_utils' )
    ? tutor_utils()->get_option( 'enable_become_instructor_btn' )
    : true;

if ( ! $instructor_reg_enabled ) :
    ?>
    <div class="mx-auto w-full max-w-xl rounded-3xl border border-line bg-white p-8 text-center shadow-sm sm:p-10" dir="rtl">
        <div class="mx-auto mb-4 grid size-12 place-items-center rounded-2xl bg-blue/10 text-blue font-bold text-lg">
            !
        </div>
        <h2 class="text-xl font-bold text-ink">
            <?php esc_html_e( 'باب الانضمام مغلق حالياً', '3alemni' ); ?>
        </h2>
        <p class="mt-3 text-sm leading-7 text-muted">
            <?php esc_html_e( 'التسجيل كأستاذ متوقف حالياً. يمكنك متابعتنا للاطلاع على مواعيد فتح باب الترشح للتدريس.', '3alemni' ); ?>
        </p>
        <a
            href="<?php echo esc_url( home_url( '/' ) ); ?>"
            class="mt-6 inline-flex min-h-11 items-center justify-center rounded-xl bg-blue px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-dark"
        >
            <?php esc_html_e( 'الصفحة الرئيسية', '3alemni' ); ?>
        </a>
    </div>
    <?php
    return;
endif;

// 3. Collect Tutor LMS instructor registration errors
$errors = apply_filters( 'tutor_instructor_register_validation_errors', array() );
?>

<div class="mx-auto w-full max-w-[580px]" dir="rtl">
    <?php do_action( 'tutor_before_instructor_reg_form' ); ?>

    <div class="rounded-3xl border border-line/80 bg-white p-6 shadow-sm sm:p-9 md:p-10">

        <!-- Header -->
        <div class="mb-8 text-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-blue/20 bg-blue/5 px-3.5 py-1.5 text-xs font-bold text-blue">
                <span class="size-1.5 rounded-full bg-blue"></span>
                <?php esc_html_e( 'انضم كأستاذ', '3alemni' ); ?>
            </span>

            <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-ink sm:text-3xl">
                <?php esc_html_e( 'شارك خبرتك في علّمني', '3alemni' ); ?>
            </h1>

            <p class="mt-2 text-sm leading-7 text-muted">
                <?php esc_html_e( 'انضم إلى نخبة الأساتذة وساهم في تقديم دورات وتطوير مهارات الشباب.', '3alemni' ); ?>
            </p>
        </div>

        <!-- Error feedback -->
        <?php if ( ! empty( $errors ) && is_array( $errors ) ) : ?>
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50/80 p-4 text-sm text-red-800" role="alert">
                <p class="font-bold"><?php esc_html_e( 'يرجى تصحيح الأخطاء التالية:', '3alemni' ); ?></p>
                <ul class="mt-2 list-inside list-disc space-y-1 text-xs">
                    <?php foreach ( $errors as $error_msg ) : ?>
                        <li><?php echo esc_html( $error_msg ); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Client-side error notice container -->
        <div id="instructor-registration-error-notice" class="mb-6 hidden rounded-2xl border border-red-200 bg-red-50/80 p-4 text-xs font-medium text-red-800" role="alert"></div>

        <!-- Registration Form -->
        <form
            id="tutor-instructor-registration-form"
            method="post"
            enctype="multipart/form-data"
            class="space-y-5"
        >
            <?php do_action( 'tutor_instructor_reg_form_start' ); ?>

            <?php
            if ( function_exists( 'tutor' ) ) {
                wp_nonce_field( tutor()->nonce_action, tutor()->nonce );
            } else {
                wp_nonce_field( 'tutor_nonce', '_tutor_nonce' );
            }
            ?>
            <input type="hidden" value="tutor_register_instructor" name="tutor_action"/>

            <!-- Names Row -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="ins_first_name" class="block text-xs font-bold text-ink">
                        <?php esc_html_e( 'الاسم الشخصي', '3alemni' ); ?>
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="ins_first_name"
                        name="first_name"
                        value="<?php echo esc_attr( function_exists( 'tutor_utils' ) ? tutor_utils()->input_old( 'first_name' ) : '' ); ?>"
                        placeholder="<?php esc_attr_e( 'مثال: كريم', '3alemni' ); ?>"
                        required
                        autocomplete="given-name"
                        class="mt-2 min-h-12 w-full rounded-xl border border-line bg-paper/40 px-4 py-2.5 text-sm text-ink outline-none transition duration-200 placeholder:text-muted/60 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                    >
                </div>

                <div>
                    <label for="ins_last_name" class="block text-xs font-bold text-ink">
                        <?php esc_html_e( 'اللقب', '3alemni' ); ?>
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="ins_last_name"
                        name="last_name"
                        value="<?php echo esc_attr( function_exists( 'tutor_utils' ) ? tutor_utils()->input_old( 'last_name' ) : '' ); ?>"
                        placeholder="<?php esc_attr_e( 'مثال: بن علي', '3alemni' ); ?>"
                        required
                        autocomplete="family-name"
                        class="mt-2 min-h-12 w-full rounded-xl border border-line bg-paper/40 px-4 py-2.5 text-sm text-ink outline-none transition duration-200 placeholder:text-muted/60 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                    >
                </div>
            </div>

            <!-- Username & Email Row -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="ins_user_login" class="block text-xs font-bold text-ink">
                        <?php esc_html_e( 'اسم المستخدم', '3alemni' ); ?>
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="ins_user_login"
                        name="user_login"
                        dir="ltr"
                        value="<?php echo esc_attr( function_exists( 'tutor_utils' ) ? tutor_utils()->input_old( 'user_login' ) : '' ); ?>"
                        placeholder="karim_instructor"
                        required
                        autocomplete="username"
                        class="mt-2 min-h-12 w-full rounded-xl border border-line bg-paper/40 px-4 py-2.5 text-left text-sm text-ink outline-none transition duration-200 placeholder:text-muted/60 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                    >
                </div>

                <div>
                    <label for="ins_email" class="block text-xs font-bold text-ink">
                        <?php esc_html_e( 'البريد الإلكتروني', '3alemni' ); ?>
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="ins_email"
                        name="email"
                        dir="ltr"
                        value="<?php echo esc_attr( function_exists( 'tutor_utils' ) ? tutor_utils()->input_old( 'email' ) : '' ); ?>"
                        placeholder="instructor@example.com"
                        required
                        autocomplete="email"
                        class="mt-2 min-h-12 w-full rounded-xl border border-line bg-paper/40 px-4 py-2.5 text-left text-sm text-ink outline-none transition duration-200 placeholder:text-muted/60 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                    >
                </div>
            </div>

            <!-- Passwords Row -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="ins_password" class="block text-xs font-bold text-ink">
                        <?php esc_html_e( 'كلمة المرور', '3alemni' ); ?>
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="ins_password"
                        name="password"
                        dir="ltr"
                        required
                        minlength="6"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="mt-2 min-h-12 w-full rounded-xl border border-line bg-paper/40 px-4 py-2.5 text-left text-sm text-ink outline-none transition duration-200 placeholder:text-muted/60 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                    >
                </div>

                <div>
                    <label for="ins_password_confirmation" class="block text-xs font-bold text-ink">
                        <?php esc_html_e( 'تأكيد كلمة المرور', '3alemni' ); ?>
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="ins_password_confirmation"
                        name="password_confirmation"
                        dir="ltr"
                        required
                        minlength="6"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="mt-2 min-h-12 w-full rounded-xl border border-line bg-paper/40 px-4 py-2.5 text-left text-sm text-ink outline-none transition duration-200 placeholder:text-muted/60 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                    >
                </div>
            </div>

            <!-- Optional Phone Number -->
            <div>
                <label for="ins_phone" class="block text-xs font-bold text-ink">
                    <?php esc_html_e( 'رقم الهاتف (اختياري للتواصل السريع)', '3alemni' ); ?>
                </label>
                <input
                    type="tel"
                    id="ins_phone"
                    name="phone_no"
                    dir="ltr"
                    value="<?php echo esc_attr( function_exists( 'tutor_utils' ) ? tutor_utils()->input_old( 'phone_no' ) : '' ); ?>"
                    placeholder="0550 00 00 00"
                    class="mt-2 min-h-12 w-full rounded-xl border border-line bg-paper/40 px-4 py-2.5 text-left text-sm text-ink outline-none transition duration-200 placeholder:text-muted/60 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                >
            </div>

            <?php do_action( 'tutor_instructor_reg_form_middle' ); ?>

            <!-- Submit Button -->
            <div class="pt-3">
                <button
                    type="submit"
                    name="tutor_register_btn"
                    value="submit"
                    class="group inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-xl bg-blue px-6 py-3.5 text-sm font-bold text-white shadow-sm shadow-blue/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-dark hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue active:translate-y-0"
                >
                    <span><?php esc_html_e( 'إرسال طلب الانضمام كأستاذ', '3alemni' ); ?></span>
                    <svg class="size-4 transition-transform duration-200 group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            <?php do_action( 'tutor_instructor_reg_form_end' ); ?>

            <!-- Login Prompt -->
            <div class="border-t border-line/60 pt-5 text-center text-xs text-muted">
                <?php esc_html_e( 'عندك حساب بالفعل؟', '3alemni' ); ?>
                <a
                    href="<?php echo esc_url( wp_login_url() ); ?>"
                    class="font-bold text-blue hover:text-blue-dark focus-visible:underline"
                >
                    <?php esc_html_e( 'تسجيل الدخول', '3alemni' ); ?>
                </a>
            </div>
        </form>
    </div>

    <?php do_action( 'tutor_after_instructor_reg_form' ); ?>
</div>

<script>
(function() {
    var form = document.getElementById('tutor-instructor-registration-form');
    if (!form) return;

    var pass1 = document.getElementById('ins_password');
    var pass2 = document.getElementById('ins_password_confirmation');
    var errorBox = document.getElementById('instructor-registration-error-notice');

    form.addEventListener('submit', function(e) {
        if (pass1 && pass2 && pass1.value !== pass2.value) {
            e.preventDefault();
            if (errorBox) {
                errorBox.textContent = '<?php echo esc_js( __( 'كلمتا المرور غير متطابقتين. يرجى التأكد وإعادة المحاولة.', '3alemni' ) ); ?>';
                errorBox.classList.remove('hidden');
                pass2.focus();
            }
            return false;
        }
    });

    if (pass2) {
        pass2.addEventListener('input', function() {
            if (pass1.value && pass2.value && pass1.value !== pass2.value) {
                pass2.classList.add('border-red-400');
                pass2.classList.remove('border-line');
            } else {
                pass2.classList.remove('border-red-400');
                pass2.classList.add('border-line');
                if (errorBox) errorBox.classList.add('hidden');
            }
        });
    }
})();
</script>
