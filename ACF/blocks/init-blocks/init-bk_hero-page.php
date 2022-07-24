<?php

/*————————————————————————————————————————————————————*\
    INIT BLOCK: Hero page
\*————————————————————————————————————————————————————*/

acf_register_block(array(
    'name'                  => 'hero-page',
    'title'                 => __('Hero page', '_s_plus'),
    'description'           => __('Show content with image in two columns', '_s_plus'),
    'render_callback'       => 'my_acf_block_render_callback',
    'category'              => 'formatting',
    'icon'                  => array(
        'background' => '#fff',
        'foreground' => '#108898',
        'src'        => 'layout',
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
