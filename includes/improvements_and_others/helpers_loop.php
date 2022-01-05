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

if (!function_exists('sp_get_img__resp')) {

    /**
     * Get responsive images with height and width attributes.
     *
     * @param  string  $size      Keyword for image size.
     * @param  int     $image_id  Image ID. Optional. By default it is the image id of the current post.
     * @param  string  $class_css Class CSS. Optional.
     * @param  boolean $lazyload  Native attribute for lazyload. Optional. By default it is TRUE.
     * @return string  Image responsive with attributes.
     */
    function sp_get_img__resp($size = 'large', $image_id = 0, $class_css = '', $lazyload = true) {


        /** If you are using the lazyload script then it will work differently. */
        $is_script_lazyload = wp_script_is('lazyload');

        /** LAZYLOAD: if $lazyload is 'false', we deactivate lazyload */
        if ($lazyload == false) {
            $is_script_lazyload = false;
        }

        /** LAZYLOAD: Add 'lazy' class */
        if ($is_script_lazyload) {
            $class_css .= ' lazy';
        }

        /* Add all the image sizes allowed in the automatic generation. */
        $sizes_img_names = array('medium', 'large', 'full', 'custom-size');

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
         * Add 'full' image width to array
         */
        $sizes_img_widths['full'] = array(
            'width'  => wp_get_attachment_image_src($image_id, 'full')[1],
            'height' => 99999
        );
        $width_img_requested = $sizes_img_widths[$size]['width'];

        /**
         * PLACEHOLDER IMAGE
         * ***************************************************
         */

        /* If the image ID is incorrect or non-existent then return the image placeholder. */
        $placeholder_img = get_template_directory_uri() . '/assets/source/img/placeholder-image.svg';

        if (!wp_get_attachment_image_url($image_id, $size)) {

            if (!($placeholder_width = $width_img_requested)) {
                $placeholder_width = $sizes_img_widths['large']['width'];
            }
            echo 'Entro al placeholder';
            return '<img class="' . $class_css . '" src="' . $placeholder_img . '" alt="" width="' . $placeholder_width . '" />';
        }

        /**
         * DECLARATION OF VARIABLES
         * ***************************************************
         */

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
         * URLs GENERACION
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

            $html_output .= 'src="' . $placeholder_img . '" ';

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

if (!function_exists('asset_url')) :

    /**
     * Generate a URL for a asset
     */
    function asset_url($asset) {
        $template_uri = get_template_directory_uri();

        return esc_url("{$template_uri}/assets/dist/img/{$asset}");
    }

endif;
