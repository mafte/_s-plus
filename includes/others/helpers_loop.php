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

        $pathPlaceholder = get_template_directory_uri() . '/assets/source/img/placeholder-image.svg';

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
    function sp_get_img__alt($image_id = 0) {

        if ($image_id == 0) {
            $image_id = get_post_thumbnail_id();
        }

        return esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE));
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

if (!function_exists('sp_img_resp_here')) {

    /**
     * Get responsive images with height and width attributes.
     *
     * @param  string  $size      Keyword for image size.
     * @param  int     $image_id  Image ID. Optional. By default it is the image id of the current post.
     * @param  string  $class_css Class CSS. Optional.
     * @param  boolean $lazyload  Native attribute for lazyload. Optional. By default it is TRUE.
     * @return string  Image responsive with attributes.
     */
    function sp_img_resp_here($size = 'large', $image_id = 0, $class_css = '', $lazyload = true) {

        /* If the $image_id is equal to 0, then we get the id of the current post */
        if ($image_id === 0) {
            $image_id = get_post_thumbnail_id();
        }

        /** If you are using the lazyload script then it will work differently. */
        $is_script_lazyload = wp_script_is('lazyload');

        /** LAZYLOAD: if $lazyload is 'false', we deactivate lazyload */
        if ($lazyload == false) {
            $is_script_lazyload = false;
        }

        /* Add all the image sizes allowed in the automatic generation. */
        $sizes_img_names = array('medium', 'medium_large', 'large', 'full');

        /* Maximum container width*/
        $size_default = 1440;
        /* Value for parent container margin */
        $margin_sizes_attribute = '48px';

        /** If the image size does not exist, get the following by default */
        if (!in_array($size, $sizes_img_names)) {
            $size = 'large';
        }

        $sizes_img_widths = wp_get_registered_image_subsizes();

        /**
         * PLACEHOLDER IMAGE
         * ***************************************************
         */

        /* If the image ID is incorrect or non-existent then return the image placeholder. */
        $placeholder_img = get_template_directory_uri() . '/assets/source/img/placeholder-image.svg';

        if (!wp_get_attachment_image_url($image_id, $size)) {

            /* A placeholder of 1920 x 1080 is used, dividing it gives 1.77, which we occupy to get the proportion regardless of size.
            This allows the correct presentation in the browser of the placeholder without sudden jumps. */
            return "<img class=\"{$class_css}\" src=\"{$placeholder_img}\" alt=\"\" width=\"{$sizes_img_widths[$size]['width']}\" height=\"" . round($sizes_img_widths[$size]['width'] / 1.77777777778)
                . "\"/>";
        }

        /**
         * Add 'full' image width to array
         */
        $sizes_img_widths['full'] = array(
            'width'  => wp_get_attachment_image_src($image_id, 'full')[1],
            'height' => 99999
        );
        // $width_img_requested = $sizes_img_widths[$size]['width'];


        /**
         * DECLARATION OF VARIABLES
         * ***************************************************
         */

        /** LAZYLOAD: Add 'lazy' class */
        if ($is_script_lazyload) {
            $class_css .= ' lazy';
        }

        $sizes_img_filter = array();
        $url_img_full     = sp_get_img__url('full', $image_id);

        $html_srcset = array();
        $html_sizes  = array();

        $html_output = '';

        // Start tag img and class CSS
        $html_output .= '<img class="' . $class_css . '" ';

        /**
         * EXTRACT ATTRIBUTES
         * ***************************************************
         */

        /* Get requested image data for width and height attributes */
        if ($image_id === 0) {
            if (get_post_thumbnail_id()) {
                $image_id = get_post_thumbnail_id();
            }
        }

        $img_object = wp_get_attachment_image_src($image_id, $size);

        $html_output .= ' width="' . $img_object[1] . '" ';
        $html_output .= ' height="' . $img_object[2] . '"';

        if (pathinfo(wp_get_attachment_image_url($image_id, 'full'), PATHINFO_EXTENSION) === 'svg') {
            $alt_text = sp_get_img__alt($image_id);
            $url = sp_get_img__url($size, $image_id);
            return <<<HERE
            <img class="{$class_css}" data-src="{$url}" alt="{$alt_text}" width="$img_object[1]" height="$img_object[2]">
            HERE;
        }

        /**
         * GET WIDTH OF IMAGES
         * ***************************************************
         */

        $i = 0;

        foreach ($sizes_img_names as $value) {

            /* If it is the original image, then we assign the necessary attributes. By default it is not considered as an image size. */
            if ($value == 'full') {
                $sizes_img_filter[$i]['name']  = $value;
                $sizes_img_filter[$i]['width'] = wp_get_attachment_image_src($image_id, 'full')[1];
            } else {
                $sizes_img_filter[$i]['name']  = $value;
                $sizes_img_filter[$i]['width'] = $sizes_img_widths[$value]['width'];
            }

            $i++;
        }

        /* Sort the sizes from smallest to largest with the value 'width' */

        foreach ($sizes_img_filter as $key => $row) {
            $aux[$key] = $row['width'];
        }

        array_multisort($aux, SORT_ASC, $sizes_img_filter);

        /**
         * URLs GENERATION
         * ***************************************************
         */

        foreach ($sizes_img_filter as $size_name_current) {

            $size_img_width_current = $size_name_current['width'];
            $url_img_current        = sp_get_img__url($size_name_current['name'], $image_id);

            /* GENERATION OF SRCSET *****************/
            /* If it is not true, then we avoid creating this unnecessary data */

            if ($url_img_current !== $url_img_full || $size_name_current['name'] == 'full') {
                $html_srcset[] = sp_get_img__url($size_name_current['name'], $image_id) . ' ' . $size_img_width_current . 'w';
            }
        }

        /* ADD SIZES ATRRIBUTES *****************/
        if ($size === 'full') {
            $html_sizes[]  = '(max-width: ' . $size_default . 'px) calc(100vw - ' . $margin_sizes_attribute . '), ' . $size_default . 'px';
        } else {
            $html_sizes[] = '(max-width: ' . $sizes_img_widths[$size]['width'] . 'px) calc(100vw - ' . $margin_sizes_attribute . '), ' . $sizes_img_widths[$size]['width'] . 'px';
        }

        /**
         * PREPARE OUTPUT
         * ***************************************************
         */

        /** LAZYLOAD: We rename the attributes and add an image placeholder while the actual image is loading.*/
        if ($is_script_lazyload) {

            $html_output .= 'data-src="' . sp_get_img__url($size, $image_id) . '" ';

            $html_output .= 'data-srcset="' . implode(', ', array_filter($html_srcset)) . '" ';
            $html_output .= 'data-sizes="' . implode(', ', array_filter($html_sizes)) . '" ';
        } else {
            $html_output .= 'src="' . sp_get_img__url($size, $image_id) . '" ';

            $html_output .= 'srcset="' . implode(', ', array_filter($html_srcset)) . '" ';
            $html_output .= 'sizes="' . implode(', ', array_filter($html_sizes)) . '" ';
        }

        // Add lazyload attribute
        if ($lazyload === true && !$is_script_lazyload) {
            $html_output .= ' loading="lazy" ';
        }

        /* Add alt text and tag end img*/
        $html_output .= ' alt="' . sp_get_img__alt($image_id) . '">';

        return $html_output;
    }
}

if (!function_exists('sp_get_asset')) {

    /**
     * Generate a URL for a assets folder
     *
     * @param  string $asset  Asset name
     * @return string  Url asset
     */
    function sp_get_asset($asset) {
        $template_uri = get_template_directory_uri();

        return esc_url("{$template_uri}/assets/source/img/{$asset}");
    }
}

if (!function_exists('sp_generate_link')) {

    /**
     * Generate link from the information of the "[CP-INNER] Link"
     *
     * @param  array  $arrayLink The input array from "[CP-INNER] Link".
     * @param  string $classCSS  CSS classes. Optional.
     * @return string Generated HTML link.
     */
    function sp_generate_link($arrayLink, $classCSS = 'button') {

        if ($link = $arrayLink['link']) {

            if ($link) {
                $link_url    = $link['url'];
                $link_title  = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            }

            $adaText = '';
            $arrayLink = $arrayLink['ada'];
            if ($arrayLink['add_ada_label']) {
                $adaText = "aria-label=\"{$arrayLink['ada_label']}\"";
            }

            return "<a class=\"{$classCSS}\" href=\"{$link_url}\" {$adaText} target=\"{$link_target}\">{$link_title}</a>";
        } else {
            return NULL;
        }
    }
}


if (!function_exists('sp_get_the_terms_ids')) {

    /**
     * Gets the IDs of taxonomies corresponding to the post.
     *
     * @param int|WP_Post $post — Post ID or object.
     * @param string $taxonomy — Taxonomy name.
     *
     * @return array Terms IDs or 'null' if taxonomy name no exist.
     */
    function sp_get_the_terms_ids($post, $taxonomy) {
        $terms_ids = array();

        if (taxonomy_exists($taxonomy)) {
            $terms_object = get_the_terms($post, $taxonomy);

            if ($terms_object) {
                foreach ($terms_object as $term_item) {
                    $terms_ids[] = $term_item->term_id;
                }
            }

            return $terms_ids;
        }

        return null;
    }
}

if (!function_exists('sp_img_resp')) {

    /**
     * Get responsive images with height and width attributes.
     *
     * @param  string  $size  Keyword for image size.
     * @param  int     $id    Image ID. Optional. By default it is the image ID of the current post.
     * @param  string  $class Class CSS. Optional.
     * @param  boolean $lazy  Native attribute for lazyload. Optional. By default it is TRUE.
     * @return string  Image responsive with attributes.
     */
    function sp_img_resp($size = 'large', $id = 0, $class = '', $lazy = true) {

        /* If the $id is equal to null, then we get the id of the current post */
        if ($id === 0) {
            $id = get_post_thumbnail_id();
        }

        if ($lazy) {
            $lazy = 'lazy';
        }

        /**
         * If you are using the lazyload script then it will work differently.
         */
        $has_lazyload = wp_script_is('lazyload');
        if ($lazy === true && $has_lazyload === true) {
            $class .= ' lazy';
        }

        $sizes_img_widths = wp_get_registered_image_subsizes();
        $has_exists_size  = false;

        /* If $size value is incorrect then set 'large' by default */
        foreach ($sizes_img_widths as $key => $value) {
            if ($key == $size) {
                $has_exists_size = true;
                break;
            }
        }

        if ($has_exists_size == false && $size != 'full') {
            $size = 'large';
        }

        $sizes_default      = '(max-width: 1440px) calc(100vw - 48px), 1440px';
        $search_atrributes  = array('src="', 'srcset="', 'sizes="');
        $changes_atrributes = array('data-src="', 'data-srcset="', 'data-sizes="');

        /*
        ——— If $size is 'full' then change the sizes
        */
        if ($size == 'full') {
            $original_img_html = wp_get_attachment_image($id, $size, '', array(
                'class'   => trim($class),
                'sizes'   => $sizes_default,
                'loading' => $lazy
            ));
        } else {
            $original_img_html = wp_get_attachment_image($id, $size, '', array(
                'class'   => trim($class),
                'loading' => $lazy
            ));
        }

        /* If the image ID is incorrect or non-existent then return the image placeholder. */
        if ($original_img_html == '') {

            if ($size == 'full') {
                $size = 'large';
            }

            $placeholder_img = get_template_directory_uri() . '/assets/source/img/placeholder-image.svg';

            /* A placeholder of 1920 x 1080 is used, dividing it gives 1.77, which we occupy to get the proportion regardless of size.
            This allows the correct presentation in the browser of the placeholder without sudden jumps. */

            if ($lazy && $has_lazyload) {
                return "<img class=\"{$class}\" data-src=\"{$placeholder_img}\" alt=\"\" width=\"{$sizes_img_widths[$size]['width']}\" height=\"" . round($sizes_img_widths[$size]['width'] / 1.77777777778) . '"/>';
            } elseif ($lazy) {
                return "<img class=\"{$class}\" src=\"{$placeholder_img}\" alt=\"\" width=\"{$sizes_img_widths[$size]['width']}\" height=\"" . round($sizes_img_widths[$size]['width'] / 1.77777777778) . '" loading="lazy"/>';
            } else {
                return "<img class=\"{$class}\" src=\"{$placeholder_img}\" alt=\"\" width=\"{$sizes_img_widths[$size]['width']}\" height=\"" . round($sizes_img_widths[$size]['width'] / 1.77777777778) . '"/>';
            }
        }

        if ($has_lazyload && $lazy) {
            return str_replace($search_atrributes, $changes_atrributes, $original_img_html);
        } else {
            return $original_img_html;
        }
    }
}
