<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package s_plus
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	if (is_page()) {
		include(get_template_directory() . '/template-parts/page.php');
	} elseif (is_single()) {
		include(get_template_directory() . '/template-parts/single.php');
	} elseif (is_archive()) {
		include(get_template_directory() . '/template-parts/archive.php');
	} elseif (is_404()) {
		include(get_template_directory() . '/template-parts/404.php');
	} elseif (is_search()) {
		include(get_template_directory() . '/template-parts/search.php');
	} else {
		//Content index
		include(get_template_directory() . '/template-parts/index.php');
	}
	?>

</main><!-- #main -->

<?php

get_footer();
