<?php
function s_plus_scripts() {
    wp_enqueue_style('s-plus-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('s-plus-style', 'rtl', 'replace');

    wp_enqueue_script('s-plus-navigation', get_template_directory_uri() . '/assets/source/js/navigation.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 's_plus_scripts');
