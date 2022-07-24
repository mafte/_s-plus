<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s_plus
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    while (have_posts()) :
        the_post();

        get_template_part('template-parts/contents/content');


    // If comments are open or we have at least one comment, load up the comment template.
    // if (comments_open() || get_comments_number()) :
    // 	comments_template();
    // endif;

    endwhile; // End of the loop.
    ?>


</main><!-- #main -->

<?php

get_footer();
