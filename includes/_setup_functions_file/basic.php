<?php
if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

if (!defined('_SP_THEME_D')) {
    define('_SP_THEME_D', get_template_directory());
}
if (!defined('_SP_THEME_U')) {
    define('_SP_THEME_U', get_template_directory_uri());
}

// DIST Directory
if (!defined('_SP_STYLE_D')) {
    define('_SP_STYLE_D', get_template_directory() . '/assets/dist/css/');
}
if (!defined('_SP_STYLE_U')) {
    define('_SP_STYLE_U', get_template_directory_uri() . '/assets/dist/css/');
}
if (!defined('_SP_SCRIPTS_D')) {
    define('_SP_SCRIPTS_D', get_template_directory() . '/assets/dist/js/');
}
if (!defined('_SP_SCRIPTS_U')) {
    define('_SP_SCRIPTS_U', get_template_directory_uri() . '/assets/dist/js/');
}
if (!defined('_SP_IMG_D')) {
    define('_SP_IMG_D', get_template_directory() . '/assets/dist/img/');
}
if (!defined('_SP_IMG_U')) {
    define('_SP_IMG_U', get_template_directory_uri() . '/assets/dist/img/');
}

// SOURCE Directory
if (!defined('_SP_STYLE_SO_D')) {
    define('_SP_STYLE_SO_D', get_template_directory() . '/assets/source/css/');
}
if (!defined('_SP_STYLE_SO_U')) {
    define('_SP_STYLE_SO_U', get_template_directory_uri() . '/assets/source/css/');
}
if (!defined('_SP_SCRIPTS_SO_D')) {
    define('_SP_SCRIPTS_SO_D', get_template_directory() . '/assets/source/js/');
}
if (!defined('_SP_SCRIPTS_SO_U')) {
    define('_SP_SCRIPTS_SO_U', get_template_directory_uri() . '/assets/source/js/');
}


if (!function_exists('s_plus_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function s_plus_setup() {
        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s_plus, use a find and replace
		 * to change 's-plus' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('s-plus', get_template_directory() . '/languages');

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
    }
endif;
add_action('after_setup_theme', 's_plus_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function s_plus_content_width() {
    $GLOBALS['content_width'] = apply_filters('s_plus_content_width', 640);
}
add_action('after_setup_theme', 's_plus_content_width', 0);


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/includes/improvements_and_others/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/improvements_and_others/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/includes/improvements_and_others/jetpack.php';
}
