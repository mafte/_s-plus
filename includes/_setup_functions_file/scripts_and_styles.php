<?php
function s_plus_scripts() {

    /*	|> STYLES
    \*------------------------------------------------------*/
    wp_enqueue_style('s-plus-style', get_stylesheet_uri(), array(), '1.' . filemtime(_SP_THEME_D . '/style.css'));
    wp_style_add_data('s-plus-style', 'rtl', 'replace');

    /*	|> SCRIPTS
    \*------------------------------------------------------*/
    wp_enqueue_script('s-plus-navigation', _SP_THEME_U . '/assets/source/js/navigation.js', array(), '1.' . filemtime(_SP_THEME_D . '/assets/source/js/navigation.js'), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 's_plus_scripts');
