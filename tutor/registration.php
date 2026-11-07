<?php
/**
 * 3alemni — Tutor LMS Registration Fallback Template
 *
 * Routes to the main student registration template in dashboard/registration.php.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists( 'tutor_load_template' ) ) {
    tutor_load_template( 'dashboard.registration' );
} else {
    require_once get_template_directory() . '/tutor/dashboard/registration.php';
}
