
<?php
/**
 * 3alemni Theme Setup and Functions
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme setup.
 */
function alemni_theme_setup(): void {
    load_theme_textdomain(
        '3alemni',
        get_template_directory() . '/languages'
    );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );

    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]
    );

    register_nav_menus(
        [
            'primary' => __( 'Primary Menu', '3alemni' ),
            'footer'  => __( 'Footer Menu', '3alemni' ),
        ]
    );
}
add_action( 'after_setup_theme', 'alemni_theme_setup' );

/**
 * Enqueue theme stylesheets.
 */
function alemni_enqueue_assets(): void {
    $css_path = get_theme_file_path( '/assets/css/main.css' );

    // Unified theme stylesheet compiled by Tailwind CSS v4 (includes design system tokens, primitives, Tutor LMS, and hero styling).
    if ( file_exists( $css_path ) ) {
        wp_enqueue_style(
            'alemni-main',
            get_theme_file_uri( '/assets/css/main.css' ),
            [],
            (string) filemtime( $css_path )
        );
    }

    $scroll_reveal_path = get_theme_file_path( 'assets/js/scroll-reveal.js' );
    if ( file_exists( $scroll_reveal_path ) ) {
        wp_enqueue_script(
            'alemni-scroll-reveal',
            get_theme_file_uri( 'assets/js/scroll-reveal.js' ),
            [],
            (string) filemtime( $scroll_reveal_path ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'alemni_enqueue_assets' );


/**
 * Enqueue the contact FAQ accordion script.
 */
function alemni_enqueue_faq_accordion(): void {
    if ( ! is_page_template( 'contact-page.php' ) ) {
        return;
    }

    $relative_path = '/assets/js/faq-accordion.js';
    $file_path     = get_theme_file_path( $relative_path );

    if ( ! file_exists( $file_path ) ) {
        return;
    }

    wp_enqueue_script(
        'alemni-faq-accordion',
        get_theme_file_uri( $relative_path ),
        [],
        (string) filemtime( $file_path ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'alemni_enqueue_faq_accordion' );


/**
 * Enqueue the header JavaScript.
 */
function alemni_enqueue_header_script(): void {
    $relative_path = '/assets/js/header.js';
    $file_path     = get_theme_file_path( $relative_path );

    if ( ! file_exists( $file_path ) ) {
        return;
    }

    wp_enqueue_script(
        'alemni-header',
        get_theme_file_uri( $relative_path ),
        [],
        (string) filemtime( $file_path ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'alemni_enqueue_header_script' );
