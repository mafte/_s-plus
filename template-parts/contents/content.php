<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s_plus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php echo sp_img_resp('large', 0, 'optional-class'); ?>
        <?php echo sp_img_resp('large', 83, 'optional-class'); ?>

        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>

    </header><!-- .entry-header -->


    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->