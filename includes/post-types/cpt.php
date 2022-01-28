<?php
// Register News Custom Post Type
function news_post_type() {

    $labels = array(
        'name'                  => _x('News', 'Post Type General Name', '_s_plus'),
        'singular_name'         => _x('News', 'Post Type Singular Name', '_s_plus'),
        'menu_name'             => __('News', '_s_plus'),
        'name_admin_bar'        => __('News', '_s_plus'),
        'archives'              => __('News Archives', '_s_plus'),
        'attributes'            => __('Item Attributes', '_s_plus'),
        'parent_item_colon'     => __('Parent News:', '_s_plus'),
        'all_items'             => __('All News', '_s_plus'),
        'add_new_item'          => __('Add News', '_s_plus'),
        'add_new'               => __('Add News', '_s_plus'),
        'new_item'              => __('New News', '_s_plus'),
        'edit_item'             => __('Edit News', '_s_plus'),
        'update_item'           => __('Update Item', '_s_plus'),
        'view_item'             => __('View News', '_s_plus'),
        'view_items'            => __('View News', '_s_plus'),
        'search_items'          => __('Search News', '_s_plus'),
        'not_found'             => __('Not found', '_s_plus'),
        'not_found_in_trash'    => __('Not found in Trash', '_s_plus'),
        'featured_image'        => __('Featured Image', '_s_plus'),
        'set_featured_image'    => __('Set featured image', '_s_plus'),
        'remove_featured_image' => __('Remove featured image', '_s_plus'),
        'use_featured_image'    => __('Use as featured image', '_s_plus'),
        'insert_into_item'      => __('Insert into issue', '_s_plus'),
        'uploaded_to_this_item' => __('Uploaded to this item', '_s_plus'),
        'items_list'            => __('News list', '_s_plus'),
        'items_list_navigation' => __('News list navigation', '_s_plus'),
        'filter_items_list'     => __('Filter News list', '_s_plus'),
    );
    $args = array(
        'label'                 => __('News', '_s_plus'),
        'description'           => __('News Post Type', '_s_plus'),
        'labels'                => $labels,
        'show_in_rest'          => true,
        'supports'              => array('title', 'editor'),
        // 'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-edit-page',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type('news', $args);
}
add_action('init', 'news_post_type', 0);
