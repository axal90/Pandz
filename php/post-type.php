<?php 



function pandz_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'pandz_rewrite_flush' );
?>