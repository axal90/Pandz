<?php

/* Theme Setup */
require_once locate_template('/functions/setup.php');         // Theme setup
require_once locate_template('/functions/theme-functions.php');         // Theme Helper Functions

/* Cleanup Wordpress Output */
require_once locate_template('/functions/cleanup.php');         // Cleanup Wordpress output

/* Woocommerce support */
require_once locate_template('/functions/woocommerce.php');
?>