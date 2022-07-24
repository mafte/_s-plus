<?php

define('ACF_NESTED', true); //Allow flexible content nested
define('ACF_ONLY_CP', false); //Allow use only components ACF. Disable Blocks


/*  |> Custom save
——————————————————————————————————————————————————————*/

add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point($path) {

    // Set custom path
    $path = get_stylesheet_directory() . '/ACF/acf-json';

    return $path;
}

/*  |> Custom load
——————————————————————————————————————————————————————*/

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point($paths) {

    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = get_stylesheet_directory() . '/ACF/acf-json';

    return $paths;
}


/*  |> Styles admin
——————————————————————————————————————————————————————*/

add_action('admin_enqueue_scripts', 'load_admin_styles');
function load_admin_styles() {
    if ('acf-field-group' != get_current_screen()->id) {
        wp_enqueue_style('acf-styles', get_template_directory_uri() . '/assets/source/css/' . 'acf-styles.css', false, filemtime(get_template_directory() . '/assets/source/css/' . 'acf-styles.css'));
    }
}

add_action('admin_head', function () {
    $styles_injected = <<<HERE
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

    if (ACF_ONLY_CP) {
        $styles_injected = ' <style>
        .components-panel__header ul li:last-child {
            display:none;
        }

        .edit-post-header__toolbar{
            visibility: hidden;
            pointer-events: none;
        }

        .edit-post-visual-editor{
            flex: 0;
        }
        </style>
        ';
    }

    echo $styles_injected;
});

/*  |> Filter HTML anchor before save into DB
——————————————————————————————————————————————————————*/

function filter_slug_id($field) {
    return sp_acf_slugify($field);
}
add_filter('acf/update_value/name=html_anchor', 'filter_slug_id', 10, 1);

/**
 * Returns a slug friendly string.
 *
 * @date    24/12/17
 * @since   5.6.5
 *
 * @param   string $str The string to convert.
 * @param   string $glue The glue between each slug piece.
 * @return  string
 */
function sp_acf_slugify($str = '', $glue = '-') {
    $raw  = $str;
    $slug = str_replace(array('_', '-', '/', ' '), $glue, strtolower(remove_accents($raw)));
    $slug = preg_replace("/[^A-Za-z0-9" . preg_quote($glue) . "]/", '', $slug);

    /**
     * Filters the slug created by acf_slugify().
     *
     * @since 5.11.4
     *
     * @param string $slug The newly created slug.
     * @param string $raw  The original string.
     * @param string $glue The separator used to join the string into a slug.
     */
    return apply_filters('acf/slugify', $slug, $raw, $glue);
}

if (!ACF_ONLY_CP) {

    /*  |> Register blocks for ACF
    ——————————————————————————————————————————————————————*/

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
}

if (ACF_ONLY_CP) {

    /*  |> Disabled all Blocks Gutenberg
    ——————————————————————————————————————————————————————*/

    function wpdocs_allowed_block_types($block_editor_context, $editor_context) {
        if (!empty($editor_context->post)) {
            return array();
        }

        return $block_editor_context;
    }

    add_filter('allowed_block_types_all', 'wpdocs_allowed_block_types', 10, 2);
}
