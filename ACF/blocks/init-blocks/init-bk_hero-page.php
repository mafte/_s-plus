<?php

/*------------------------------------------------------*\
    || INIT BLOCK: Hero page
\*------------------------------------------------------*/

acf_register_block(array(
    'name'                  => 'hero-page',
    'title'                 => __('Hero page', 's-plus'),
    'description'           => __('Show content with image in two columns', 's-plus'),
    'render_callback'       => 'my_acf_block_render_callback',
    'category'              => 'formatting',
    'icon'                  => array(
        'background' => '#fff',
        'foreground' => '#08A0FD',
        'src'        => 'superhero-alt',
    ),
    'keywords'            => array('blocks', 'content'),
    'mode' => 'edit',
    'example'             => array(
        'attributes' => array(
            'data' => array(
                'is_preview'  => false
            )
        )
    )
));
