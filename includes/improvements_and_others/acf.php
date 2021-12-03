<?php


/*	|> Custom save
\*------------------------------------------------------*/
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point($path) {

    // Set custom path
    $path = get_stylesheet_directory() . '/ACF/acf-json';

    return $path;
}

/*	|> Custom load
\*------------------------------------------------------*/

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point($paths) {

    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = get_stylesheet_directory() . '/ACF/acf-json';

    return $paths;
}
