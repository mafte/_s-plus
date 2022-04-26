<?php

function _s_plus_scripts() {

    $dir_scripts = get_template_directory() . '/assets/source/js/';
    $url_scripts = get_template_directory_uri() . '/assets/dist/js/';
    $dir_styles = get_template_directory() . '/assets/source/css/';
    $url_styles = get_template_directory_uri() . '/assets/source/css/';

    /*	|> STYLES
    \*------------------------------------------------------*/
    // wp_enqueue_style('fluid-spacing', $url_styles . 'spacing-fluid-min.css', array(), '1.' . filemtime($dir_styles . 'spacing-fluid-min.css'));
    // wp_enqueue_style('tiny-slider-styles', $url_styles . 'tiny-slider.css', array(), '1');
    wp_enqueue_style('_s_plus-style', get_stylesheet_uri(), array(), '1.' . filemtime(get_template_directory() . '/style.css'));
    // wp_style_add_data('_s_plus-style', 'rtl', 'replace');

    /*	|> SCRIPTS
    \*------------------------------------------------------*/
    wp_enqueue_script('lazyload', $url_scripts . 'lazyload.min.js', array(), '1', true);
    wp_enqueue_script('_s_plus-main', get_template_directory_uri() . '/assets/dist/js/production.min.js', array(), '1.' . filemtime(get_template_directory() . '/assets/dist/js/production.min.js'), true);

    // if (is_singular() && comments_open() && get_option('thread_comments')) {
    //     wp_enqueue_script('comment-reply');
    // }
}
add_action('wp_enqueue_scripts', '_s_plus_scripts');
