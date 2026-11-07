<?php
/**
 * 3alemni — Student / Instructor Courses Route Adapter
 *
 * Directs students visiting the /dashboard/courses/ endpoint to the
 * redesigned Student My Courses template (enrolled-courses.php),
 * while preserving Tutor LMS instructor authored course management.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\User;

// If viewed as a student, load the redesigned student My Courses template
if ( ! function_exists( 'tutor_utils' ) || ! tutor_utils()->is_instructor() || User::is_student_view() ) {
	include __DIR__ . '/enrolled-courses.php';
	return;
}

// For instructors, preserve the original Tutor LMS course management view
$instructor_template = '';
if ( function_exists( 'tutor' ) && isset( tutor()->path ) ) {
	$instructor_template = tutor()->path . 'templates/dashboard/my-courses.php';
	if ( ! file_exists( $instructor_template ) ) {
		$instructor_template = tutor()->path . 'templates/dashboard/courses.php';
	}
}

if ( $instructor_template && file_exists( $instructor_template ) ) {
	include $instructor_template;
}
