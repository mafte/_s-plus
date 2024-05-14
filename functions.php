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


/*  |> REST API disabled for unauthenticated users
——————————————————————————————————————————————————————*/
add_filter(
	'rest_authentication_errors',
	function ( $result ) {
		// If a previous authentication check was applied,
		// pass that result along without modification.
		if ( true === $result || is_wp_error( $result ) ) {
			return $result;
		}

		// No authentication has been performed yet.
		// Return an error if user is not logged in.
		if ( ! is_user_logged_in() ) {
			return new WP_Error(
				'rest_not_logged_in',
				__( 'You are not currently logged in.' ),
				array( 'status' => 401 )
			);
		}

		// Our custom authentication check should have no effect
		// on logged-in requests
		return $result;
	}
);
