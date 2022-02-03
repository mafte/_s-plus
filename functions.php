<?php

/**
 * _s_plus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s_plus
 */

/*------------------------------------------------------*\
	|| BASIC SETUP
\*------------------------------------------------------*/
include_once('includes/_setup_functions_file/basic.php');


/*	|> Widgets
\*------------------------------------------------------*/
// include_once('includes/_setup_functions_file/widgets.php');


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
	if ('acf-field-group' != get_current_screen()->id) {
		wp_enqueue_style('acf-styles', get_template_directory_uri() . '/assets/source/css/' . 'acf-styles.css', false, filemtime(get_template_directory() . '/assets/source/css/' . 'acf-styles.css'));
	}
}

add_action('admin_head', function () {
	echo <<<HERE
	<style>
		:root {
			--icon-settings: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'%3E%3Cpath d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z'/%3E%3C/svg%3E");
		}
		.icon-acf {
			background-repeat: no-repeat;
			background-size: contain;
			background-position: center;
			width: 22px;
			height: 15px;
			display: inline-block;
			-webkit-transition: .3s;
			-o-transition: .3s;
			transition: .3s;
			transform: scale(1.3) translate(0px, 3px);
		}

		.icon-settings {
			background-image: var(--icon-settings)
		}
	</style>
	HERE;
});

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

/*------------------------------------------------------*\
	|| IMPROVE: WP MENU NAV
\*------------------------------------------------------*/

include_once('includes/improvements_and_others/improve_wp_nav.php');
