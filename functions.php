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


/*  |> Widgets
——————————————————————————————————————————————————————*/
// include_once('includes/_setup/widgets.php');


/*  |> Enqueue scripts and styles.
——————————————————————————————————————————————————————*/
require_once 'includes/_setup/scripts-and-styles.php';


/*  |> Helpers loop functions
——————————————————————————————————————————————————————*/
require_once 'includes/others/helpers-loop.php';


/*————————————————————————————————————————————————————*\
	●❱ ACF
\*————————————————————————————————————————————————————*/

require_once 'includes/others/acf.php';

/*————————————————————————————————————————————————————*\
	●❱ CUSTOMIZER
\*————————————————————————————————————————————————————*/

//include_once('includes/others/settings-customizer.php');


/*————————————————————————————————————————————————————*\
	●❱ IMPROVE: WP MENU NAV
\*————————————————————————————————————————————————————*/

require_once 'includes/others/improve-wp-nav.php';
