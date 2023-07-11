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

require_once 'includes/base/basic.php';


/*  |> Widgets
——————————————————————————————————————————————————————*/
// include_once('includes/base/widgets.php');


/*  |> Enqueue scripts and styles.
——————————————————————————————————————————————————————*/
require_once 'includes/base/scripts-and-styles.php';


/*  |> Helpers loop functions
——————————————————————————————————————————————————————*/
require_once 'includes/features/helpers-loop.php';


/*————————————————————————————————————————————————————*\
	●❱ ACF
\*————————————————————————————————————————————————————*/

require_once 'includes/features/acf.php';

/*————————————————————————————————————————————————————*\
	●❱ CUSTOMIZER
\*————————————————————————————————————————————————————*/

//include_once('includes/features/settings-customizer.php');


/*————————————————————————————————————————————————————*\
	●❱ IMPROVE: WP MENU NAV
\*————————————————————————————————————————————————————*/

require_once 'includes/features/improve-wp-nav.php';
