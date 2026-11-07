<?php
/**
 * 3alemni — Breadcrumbs Component
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( is_front_page() ) {
    return;
}
?>

<nav aria-label="<?php esc_attr_e( 'مسار التنقل', '3alemni' ); ?>" class="breadcrumbs mb-6 flex items-center gap-2 text-xs text-muted" dir="rtl">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition hover:text-blue">
        <?php esc_html_e( 'الرئيسية', '3alemni' ); ?>
    </a>

    <span class="text-line" aria-hidden="true">/</span>

    <span class="font-medium text-ink" aria-current="page">
        <?php echo esc_html( wp_strip_all_tags( get_the_title() ) ); ?>
    </span>
</nav>
