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

include_once('includes/_setup/basic.php');


/*  |> Widgets
——————————————————————————————————————————————————————*/
// include_once('includes/_setup/widgets.php');


/*  |> Enqueue scripts and styles.
——————————————————————————————————————————————————————*/
include_once('includes/_setup/scripts_and_styles.php');


/*  |> Helpers loop functions
——————————————————————————————————————————————————————*/
include_once('includes/others/helpers_loop.php');


/*————————————————————————————————————————————————————*\
    ●❱ ACF
\*————————————————————————————————————————————————————*/

include_once('includes/others/acf.php');

/*————————————————————————————————————————————————————*\
    ●❱ CUSTOMIZER
\*————————————————————————————————————————————————————*/

//include_once('includes/others/settings_customizer.php');


/*————————————————————————————————————————————————————*\
    ●❱ IMPROVE: WP MENU NAV
\*————————————————————————————————————————————————————*/

include_once('includes/others/improve_wp_nav.php');

function display_admin_notice() {
?>
    <?php if (!class_exists('ACF')) : ?>
        <div class="notice notice-warning">
            <p>The current theme <code><?php echo wp_get_theme()->get('Name'); ?></code> works with Advanced Custom Fields (ACF), please install it.</p>
        </div>
    <?php endif; ?>

<?php
}
add_action('admin_notices', 'display_admin_notice');
