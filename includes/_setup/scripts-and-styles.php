<?php

function _s_plus_scripts() {

	$dir_assets = get_template_directory() . '/assets';
	$url_assets = get_template_directory_uri() . '/assets';

	/*  STYLES
	——————————————————————————————————————————————————————*/

	wp_enqueue_style( '_s_plus-style', get_stylesheet_uri(), array(), '1.' . filemtime( get_template_directory() . '/style.css' ) );
	// wp_style_add_data('_s_plus-style', 'rtl', 'replace');

	/*  SCRIPTS
	——————————————————————————————————————————————————————*/
	wp_enqueue_script( 'lazyload', "{$url_assets}/js/lazyload.min.js", array(), '17.8.3', true );
	wp_enqueue_script( '_s_plus-main', "{$url_assets}/js/production.min.js", array(), '1.' . filemtime( "{$dir_assets}/js/production.min.js" ), true );
	// wp_enqueue_script('tinyslider', "{$url_assets}/js/tiny-slider.min.js", array(), '2.9.3', true);

	// if (is_singular() && comments_open() && get_option('thread_comments')) {
	//     wp_enqueue_script('comment-reply');
	// }
}
add_action( 'wp_enqueue_scripts', '_s_plus_scripts' );
