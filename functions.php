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

/*	|> Register blocks for ACF
\*------------------------------------------------------*/

function my_acf_block_render_callback($block) {

	// convert name ("acf/nameblock") into path friendly slug ("nameblock")
	$slug = str_replace('acf/', '', $block['name']);

	// include a template part from within the "ACF/blocks/template-blocks" folder
	if (file_exists(get_theme_file_path("/ACF/blocks/template-blocks/bk_{$slug}.php"))) {
		include(get_theme_file_path("/ACF/blocks/template-blocks/bk_{$slug}.php"));
	}
}

add_action('acf/init', 'my_acf_blocks_init');
function my_acf_blocks_init() {

	foreach (glob(get_theme_file_path("ACF/blocks/init-blocks/*.php")) as $filename) {
		include $filename;
	}
}


/*------------------------------------------------------*\
	|| CUSTOMIZER
\*------------------------------------------------------*/

//include_once('includes/improvements_and_others/settings_customizer.php');
