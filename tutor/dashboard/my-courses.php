<?php
/**
 * 3alemni — Student / Instructor My Courses Route Delegator
 *
 * Directs students to the dedicated Student My Courses template,
 * while preserving Tutor LMS instructor course management logic.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\User;

// If student view, load the student My Courses template
if ( ! function_exists( 'tutor_utils' ) || ! tutor_utils()->is_instructor() || User::is_student_view() ) {
	include __DIR__ . '/enrolled-courses.php';
	return;
}

// Otherwise, fallback to standard instructor my-courses template if tutor core has it
$instructor_template = tutor()->path . 'templates/dashboard/my-courses.php';
if ( file_exists( $instructor_template ) ) {
	include $instructor_template;
}
