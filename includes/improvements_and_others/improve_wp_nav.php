<?php

/**
 * Adds a Sub Nav Toggle to the Expanded Menu and Mobile Menu.
 *
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param WP_Post  $item  Menu item data object.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return stdClass An object of wp_nav_menu() arguments.
 */
function twentytwenty_add_sub_toggles_to_main_menu($args, $item, $depth) {

    // Add sub menu toggles to the Expanded Menu with toggles.
    if (isset($args->show_toggles) && $args->show_toggles) {

        // Wrap the menu item link contents in a div, used for positioning.
        $args->before = '<div class="ancestor-wrapper">';
        $args->after  = '';

        // Add a toggle to items with children.
        if (in_array('menu-item-has-children', $item->classes, true)) {

            $toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' > .sub-menu';
            $toggle_duration      = 250;

            // Add the sub menu toggle.
            $args->after .= '<button class="toggle sub-menu-toggle fill-children-current-color" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="' . absint($toggle_duration) . '" aria-expanded="false"><span class="screen-reader-text">' . __('Show sub menu', 'twentytwenty') . '</span>' . '<span class="icon icon-arrow-down"></span>' . '</button>';
        }

        // Close the wrapper.
        $args->after .= '</div><!-- .ancestor-wrapper -->';

        // Add sub menu icons to the primary menu without toggles.
    } elseif ('primary' === $args->theme_location) {
        if (in_array('menu-item-has-children', $item->classes, true)) {
            $args->after = '<span class="icon"></span>';
        } else {
            $args->after = '';
        }
    }

    return $args;
}

add_filter('nav_menu_item_args', 'twentytwenty_add_sub_toggles_to_main_menu', 10, 3);
