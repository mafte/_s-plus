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

	<?php
	while (have_posts()) :
		the_post();

		//get_template_part('template-parts/content', 'page');

		the_content();

		// If comments are open or we have at least one comment, load up the comment template.
		if (comments_open() || get_comments_number()) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>

	<?php include(get_template_directory() . '/ACF/acf-generate-layout.php'); ?>

	<?php include(get_template_directory() . '/template-parts/searchform.php'); ?>



</main><!-- #main -->

<?php

get_footer();
