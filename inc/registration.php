<?php
/**
 * 3alemni — Registration Handlers & Validation
 *
 * Hooks into Tutor LMS registration validation filters to ensure
 * strict validation, password confirmation matching, and security.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Validate Student Registration Fields on Server-Side.
 *
 * @param array $errors Existing validation errors from Tutor LMS.
 * @return array Sanitized and appended errors list.
 */
function alemni_validate_student_registration( array $errors ): array {
    // Check if registration action matches
    $tutor_action = isset( $_POST['tutor_action'] ) ? sanitize_text_field( wp_unslash( $_POST['tutor_action'] ) ) : '';
    if ( 'tutor_register_student' !== $tutor_action ) {
        return $errors;
    }

    $first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
    $last_name  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
    $user_login = isset( $_POST['user_login'] ) ? sanitize_user( wp_unslash( $_POST['user_login'] ), true ) : '';
    $email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $password   = isset( $_POST['password'] ) ? (string) $_POST['password'] : '';
    $confirm    = isset( $_POST['password_confirmation'] ) ? (string) $_POST['password_confirmation'] : '';

    if ( empty( $first_name ) ) {
        $errors['first_name'] = __( 'يرجى إدخال الاسم الشخصي.', '3alemni' );
    }

    if ( empty( $last_name ) ) {
        $errors['last_name'] = __( 'يرجى إدخال اللقب.', '3alemni' );
    }

    if ( empty( $user_login ) ) {
        $errors['user_login'] = __( 'يرجى إدخال اسم المستخدم.', '3alemni' );
    } elseif ( ! validate_username( $user_login ) ) {
        $errors['user_login_invalid'] = __( 'اسم المستخدم غير صالح. يرجى استخدام أحرف وأرقام لاتينية.', '3alemni' );
    } elseif ( username_exists( $user_login ) ) {
        $errors['user_login_exists'] = __( 'اسم المستخدم هذا محجوز مسبقاً. يرجى اختيار اسم مستخدم آخر.', '3alemni' );
    }

    if ( empty( $email ) || ! is_email( $email ) ) {
        $errors['email_invalid'] = __( 'يرجى إدخال بريد إلكتروني صالح.', '3alemni' );
    } elseif ( email_exists( $email ) ) {
        $errors['email_exists'] = __( 'البريد الإلكتروني هذا مستخدم بالفعل. هل نسيت كلمة المرور؟', '3alemni' );
    }

    if ( empty( $password ) ) {
        $errors['password_empty'] = __( 'يرجى إدخال كلمة المرور.', '3alemni' );
    } elseif ( strlen( $password ) < 6 ) {
        $errors['password_length'] = __( 'كلمة المرور يجب أن لا تقل عن 6 خانات.', '3alemni' );
    }

    if ( ! empty( $password ) && $password !== $confirm ) {
        $errors['password_mismatch'] = __( 'كلمتا المرور غير متطابقتين. يرجى التأكد وإعادة المحاولة.', '3alemni' );
    }

    return $errors;
}
add_filter( 'tutor_student_register_validation_errors', 'alemni_validate_student_registration', 20 );


/**
 * Validate Instructor Registration Fields on Server-Side.
 *
 * @param array $errors Existing validation errors from Tutor LMS.
 * @return array Sanitized and appended errors list.
 */
function alemni_validate_instructor_registration( array $errors ): array {
    $tutor_action = isset( $_POST['tutor_action'] ) ? sanitize_text_field( wp_unslash( $_POST['tutor_action'] ) ) : '';
    if ( 'tutor_register_instructor' !== $tutor_action ) {
        return $errors;
    }

    $first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
    $last_name  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
    $user_login = isset( $_POST['user_login'] ) ? sanitize_user( wp_unslash( $_POST['user_login'] ), true ) : '';
    $email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $password   = isset( $_POST['password'] ) ? (string) $_POST['password'] : '';
    $confirm    = isset( $_POST['password_confirmation'] ) ? (string) $_POST['password_confirmation'] : '';

    if ( empty( $first_name ) ) {
        $errors['first_name'] = __( 'يرجى إدخال الاسم الشخصي.', '3alemni' );
    }

    if ( empty( $last_name ) ) {
        $errors['last_name'] = __( 'يرجى إدخال اللقب.', '3alemni' );
    }

    if ( empty( $user_login ) ) {
        $errors['user_login'] = __( 'يرجى إدخال اسم المستخدم.', '3alemni' );
    } elseif ( ! validate_username( $user_login ) ) {
        $errors['user_login_invalid'] = __( 'اسم المستخدم غير صالح. يرجى استخدام أحرف وأرقام لاتينية.', '3alemni' );
    } elseif ( username_exists( $user_login ) ) {
        $errors['user_login_exists'] = __( 'اسم المستخدم هذا محجوز مسبقاً. يرجى اختيار اسم مستخدم آخر.', '3alemni' );
    }

    if ( empty( $email ) || ! is_email( $email ) ) {
        $errors['email_invalid'] = __( 'يرجى إدخال بريد إلكتروني صالح.', '3alemni' );
    } elseif ( email_exists( $email ) ) {
        $errors['email_exists'] = __( 'البريد الإلكتروني هذا مستخدم بالفعل. هل نسيت كلمة المرور؟', '3alemni' );
    }

    if ( empty( $password ) ) {
        $errors['password_empty'] = __( 'يرجى إدخال كلمة المرور.', '3alemni' );
    } elseif ( strlen( $password ) < 6 ) {
        $errors['password_length'] = __( 'كلمة المرور يجب أن لا تقل عن 6 خانات.', '3alemni' );
    }

    if ( ! empty( $password ) && $password !== $confirm ) {
        $errors['password_mismatch'] = __( 'كلمتا المرور غير متطابقتين. يرجى التأكد وإعادة المحاولة.', '3alemni' );
    }

    return $errors;
}
add_filter( 'tutor_instructor_register_validation_errors', 'alemni_validate_instructor_registration', 20 );


/**
 * Ensure strict role security on user registration.
 *
 * Public registration must never assign administrator or elevated roles.
 * Tutor LMS assigns 'subscriber' for students and marks instructor applications as pending.
 *
 * @param int $user_id The registered user ID.
 */
function alemni_enforce_registration_role_security( int $user_id ): void {
    if ( ! $user_id ) {
        return;
    }

    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }

    // Never permit public registration to have elevated privileges
    if ( in_array( 'administrator', (array) $user->roles, true ) || in_array( 'editor', (array) $user->roles, true ) ) {
        $user->set_role( 'subscriber' );
    }
}
add_action( 'user_register', 'alemni_enforce_registration_role_security', 99 );
