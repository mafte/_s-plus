<?php

/**
 * Template used to redirect to the requested template.
 * This is an additional step in order to take better advantage
 * of the order of the theme files.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s_plus
 */

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
