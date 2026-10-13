<?php

defined( 'ABSPATH' ) || exit;

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


function alemni_enqueue_assets(): void {
    // Main stylesheet.
    $css_path = get_theme_file_path( '/assets/css/main.css' );

    if ( file_exists( $css_path ) ) {
        wp_enqueue_style(
            'alemni-main',
            get_theme_file_uri( '/assets/css/main.css' ),
            [],
            (string) filemtime( $css_path )
        );
    }

    // Alpine.js.
    $script_path = get_theme_file_path( '/assets/js/alpine.min.js' );

    if ( file_exists( $script_path ) ) {
        wp_enqueue_script(
            '3alemni-alpine',
            get_theme_file_uri( '/assets/js/alpine.min.js' ),
            [],
            (string) filemtime( $script_path ),
            [
                'strategy'  => 'defer',
                'in_footer' => true,
            ]
        );
    }
}

add_action( 'wp_enqueue_scripts', 'alemni_enqueue_assets' );
