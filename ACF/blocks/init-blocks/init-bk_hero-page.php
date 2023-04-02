<?php

/*————————————————————————————————————————————————————*\
	●❱ INIT BLOCK: Hero page
\*————————————————————————————————————————————————————*/

acf_register_block(
	array(
		'name'            => 'hero-page',
		'title'           => __( 'Hero page', '_s_plus' ),
		'description'     => __( 'Short description about gutenberg Block', '_s_plus' ),
		'render_callback' => 'my_acf_block_render_callback',
		'category'        => 'formatting',
		'icon'            => file_get_contents( get_template_directory() . '/assets/source/img/icon-gutenberg.svg' ),
		'keywords'        => array( 'blocks', 'content' ),
		'mode'            => 'edit',
		'example'         => array(
			'attributes' => array(
				'data' => array(
					'is_preview' => false,
				),
			),
		),
		'supports'        => array( 'anchor' => true ),
	)
);
