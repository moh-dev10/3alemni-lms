
<?php
defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header fixed inset-x-0 top-0 z-50 w-full border-b border-line/70 bg-paper/90 backdrop-blur-2xl supports-[backdrop-filter]:bg-paper/85">
    <div class="relative mx-auto flex min-h-[70px] w-full max-w-[1440px] items-center justify-between gap-5 px-5 sm:px-8 lg:gap-8 lg:px-12">

        <?php get_template_part( 'templates/header/brand' ); ?>

        <?php get_template_part( 'templates/header/mobile-toggle' ); ?>

        <div
            id="primary-navigation"
            inert
            class="site-navigation invisible pointer-events-none absolute inset-x-0 top-full z-50 -translate-y-2 border-b border-line/80 bg-paper opacity-0 shadow-xl shadow-ink/5 transition-[opacity,transform,visibility] duration-200 ease-out md:visible md:pointer-events-auto md:static md:translate-y-0 md:border-0 md:bg-transparent md:opacity-100 md:shadow-none md:!transition-none"
        >
            <div class="px-5 pb-5 pt-3 sm:px-8 md:p-0">
                <?php get_template_part( 'templates/header/navigation' ); ?>
                <?php get_template_part( 'templates/header/account-mobile' ); ?>
            </div>
        </div>

        <?php get_template_part( 'templates/header/account-desktop' ); ?>

    </div>
</header>
