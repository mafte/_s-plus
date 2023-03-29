<?php

/**
 * _s_plus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s_plus
 */

/*————————————————————————————————————————————————————*\
	●❱ BASIC SETUP
\*————————————————————————————————————————————————————*/

require_once 'includes/_setup/basic.php';


/*
  |> Widgets
——————————————————————————————————————————————————————*/
// include_once('includes/_setup/widgets.php');


/*
  |> Enqueue scripts and styles.
——————————————————————————————————————————————————————*/
require_once 'includes/_setup/scripts_and_styles.php';


/*
  |> Helpers loop functions
——————————————————————————————————————————————————————*/
require_once 'includes/others/helpers_loop.php';


/*
————————————————————————————————————————————————————*\
	●❱ ACF
\*————————————————————————————————————————————————————*/

require_once 'includes/others/acf.php';

/*
————————————————————————————————————————————————————*\
	●❱ CUSTOMIZER
\*————————————————————————————————————————————————————*/

// include_once('includes/others/settings_customizer.php');


/*
————————————————————————————————————————————————————*\
	●❱ IMPROVE: WP MENU NAV
\*————————————————————————————————————————————————————*/

require_once 'includes/others/improve_wp_nav.php';
