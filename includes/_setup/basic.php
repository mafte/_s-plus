<?php
if (!defined('_S_PLUS_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_PLUS_VERSION', '1.0.0');
}

if (!function_exists('_s_plus_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function _s_plus_setup() {
        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s_plus, use a find and replace
		 * to change '_s_plus' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('_s_plus', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        // add_theme_support('automatic-feed-links');

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support('title-tag');

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support('post-thumbnails');


        /* |> Menus
        \*------------------------------------------------------*/
        include_once('menus.php');

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        /*	|> Images sizes
        \*------------------------------------------------------*/
        include_once('img_sizes.php');
    }
endif;
add_action('after_setup_theme', '_s_plus_setup');


/*------------------------------------------------------*\
    || SETTINGS FOR IMAGES
\*------------------------------------------------------*/

/**
 * Increases the threshold for scaling big images to value.
 *
 * @param $threshold
 * @return int
 */
function dg_big_image_size_threshold($threshold) {
    return 2000; // new threshold
}
// completely disable image size threshold
add_filter('big_image_size_threshold', '__return_false');

/*	|> Disable intermediate images
\*------------------------------------------------------*/
add_filter('intermediate_image_sizes', function ($sizes) {
    return array_diff($sizes, ['1536x1536', '2048x2048']);
});



/*	|> Autoscaled images by Imsanity plugin
\*------------------------------------------------------*/

//If Imsanity plugin is not actived
if (!defined('IMSANITY_VERSION')) {

    define('_S_PLUS_IMSANITY_DEFAULT_MAX_WIDTH', 2000);
    define('_S_PLUS_IMSANITY_DEFAULT_MAX_HEIGHT', 0);
    define('_S_PLUS_IMSANITY_DEFAULT_QUALITY', 90);

    include(get_template_directory() . '/includes/others/imsanity-images.php');

    // Add filter to hook into uploads.
    add_filter('wp_handle_upload', 'sp_imsanity_handle_upload');
}

/*------------------------------------------------------*/


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * The value must be greater than or equal to the defined value of the image size "large".
 * It is necessary for the proper functioning of responsive images.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_plus_content_width() {
    $GLOBALS['content_width'] = apply_filters('_s_plus_content_width', 1200);
}
add_action('after_setup_theme', '_s_plus_content_width', 0);


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/includes/others/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/others/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/includes/others/jetpack.php';
}
