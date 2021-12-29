<?php
function s_plus_scripts() {

    /*	|> STYLES
    \*------------------------------------------------------*/
    wp_enqueue_style('s-plus-style', get_stylesheet_uri(), array(), '1.' . filemtime(_SP_THEME_D . '/style.css'));
    wp_enqueue_style('fluid-spacing', _SP_STYLE_SO_U . 'spacing-fluid-min.css', array(), '1.' . filemtime(_SP_STYLE_SO_D . 'spacing-fluid-min.css'));
    wp_style_add_data('s-plus-style', 'rtl', 'replace');

    /*	|> SCRIPTS
    \*------------------------------------------------------*/
    wp_enqueue_script('s-plus-navigation', _SP_SCRIPTS_SO_U . 'navigation.js', array(), '1.' . filemtime(_SP_SCRIPTS_SO_D . 'navigation.js'), true);
    wp_enqueue_script('s-plus-main', _SP_SCRIPTS_SO_U . 'main.js', array(), '1.' . filemtime(_SP_SCRIPTS_SO_D . 'main.js'), true);


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 's_plus_scripts');
