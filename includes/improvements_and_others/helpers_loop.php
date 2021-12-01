<?php

if (!function_exists('sp_get_img__url')) {
    /**
     * Get the URL of the image according to the size and if desired according to the given image id.
     *
     * @param  string $size     Keyword for image size.
     * @param  int    $image_id Image ID. Optional. By default it is the image id of the current post.
     * @return string URL of the image.
     */
    function sp_get_img__url($size, $image_id = 0) {

        $pathPlaceholder = get_template_directory_uri() . '/assets/img/placeholder-image.jpg';

        if ($image_id === 0) {

            if (get_post_thumbnail_id()) {

                return esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $size));
            }
        } else {

            if (wp_get_attachment_image_url($image_id, $size)) {

                return esc_url(wp_get_attachment_image_url($image_id, $size));
            }
        }

        return $pathPlaceholder;
    }
}

if (!function_exists('sp_get_img__alt')) {
    /**
     * Get alternative text for the given image id. By default it is the alt text of the featured image of the current post
     *
     * @param  int    $image_id Image ID. Optional. By default it is the image id of the current post.
     * @return string Alt text of the image.
     */
    function getImg__alt($image_id = 0) {

        if ($image_id == 0) {
            $image_id = get_post_thumbnail_id();
        }

        return esc_attr_e(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE));
    }
}

if (!function_exists('sp_get_cat__name')) {
    /**
     * Get the name of the first category of the current post.
     *
     * @return string Category name.
     */
    function sp_get_cat__name() {
        $categorytem = get_the_category();

        return $categorytem[0]->cat_name;
    }
}

if (!function_exists('sp_get_cat__url')) {
    /**
     * Get the url of the first category of the current post.
     *
     * @return string Category URL.
     */
    function sp_get_cat__url() {
        return esc_url(get_category_link(get_the_category()[0]->term_id));
    }
}

if (!function_exists('sp_the_excerpt')) {
    /**
     * @param $length Maximum number of words
     */
    function sp_the_excerpt($length = 120) {
        echo wp_trim_words(get_the_excerpt(), $length);
    }
}
