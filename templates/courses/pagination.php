<?php
defined( 'ABSPATH' ) || exit;
?>

<nav
    class="mt-16 flex justify-center"
    aria-label="<?php esc_attr_e( 'التنقل بين صفحات الدورات', '3alemni' ); ?>"
>
    <?php
    the_posts_pagination( [
        'mid_size'  => 2,
        'prev_text' => '→',
        'next_text' => '←',
    ] );
    ?>
</nav>