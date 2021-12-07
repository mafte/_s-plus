<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s_plus
 */

get_header();
?>

<main id="primary" class="site-main">




    <?php include(get_template_directory() . '/ACF/acf-generate-layout.php'); ?>





</main><!-- #main -->

<?php
get_footer();
