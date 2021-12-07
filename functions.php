<?php

/**
 * _s_plus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package s_plus
 */

/*------------------------------------------------------*\
	|| BASIC SETUP
\*------------------------------------------------------*/
include_once('includes/_setup_functions_file/basic.php');


/*	|> Widgets
\*------------------------------------------------------*/
include_once('includes/_setup_functions_file/widgets.php');


/*	|> Enqueue scripts and styles.
\*------------------------------------------------------*/
include_once('includes/_setup_functions_file/scripts_and_styles.php');


/*	|> Helpers loop functions
\*------------------------------------------------------*/
include_once('includes/improvements_and_others/helpers_loop.php');


/*------------------------------------------------------*\
	|| ACF
\*------------------------------------------------------*/

/*	|> load/save custom path
\*------------------------------------------------------*/
include_once('includes/improvements_and_others/acf.php');


/*	|> Styles admin
\*------------------------------------------------------*/

add_action('admin_enqueue_scripts', 'load_admin_styles');
function load_admin_styles() {
	wp_enqueue_style('acf-styles', _SP_STYLE_SO_U . 'acf-styles.css', false, filemtime(_SP_STYLE_SO_D . 'acf-styles.css'));
}

/*	|> Filter HTML anchor before save into DB
\*------------------------------------------------------*/

function filter_slug_id($field) {
	return acf_slugify($field);
}
add_filter('acf/update_value/name=html_anchor', 'filter_slug_id', 10, 1);
