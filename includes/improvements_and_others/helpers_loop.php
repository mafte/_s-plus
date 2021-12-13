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
    function sp_get_img__alt($image_id = 0) {

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

if (!function_exists('sp_get_img__resp')) {

    /**
     * Get responsive images with height and width attributes.
     *
     * @param  string  $size       Keyword for image size.
     * @param  int     $image_id
     * @param  boolean $lazyload
     * @return string  Url and responsive image attributes.
     */
    function sp_get_img__resp($size = 'large', $image_id = 0, $lazyload = true) {

        /* Es esencial agregar los tamaños de imagen del mas pequeño al mas grande. */
        $sizes_img_names = array('medium', 'large', 'full');
        $sizes_img_width = wp_get_registered_image_subsizes();
        $img_url_code  = '';
        $sizesUrlsCode = '';
        $formater      = '';

        /* Filtrar los tamaños adecuados */
        $indexKey = array_search($size, $sizes_img_names);

        if ($indexKey !== count($sizes_img_names)) {
            //Cortara el array despues del tamaño deseado y lo asignara de nuevo a la variable ya filtrado
            $sizes_img_names = array_slice($sizes_img_names, 0, $indexKey + 1);
        }

        /**************************************** */

        foreach ($sizes_img_names as $sizeNameValue) {
            /********* Asigna la url de la imagen *********/
            $sizeWimgCurrent = $sizes_img_width[$sizeNameValue]['width'];
            $img_url_code .= sp_get_img__url($sizeNameValue, $image_id) . ' ' . $sizeWimgCurrent . 'w';

            /* Si la condicion no se cumple significa que es el ultimo array y ya no se necesita la coma */
            if ($size != $sizeNameValue) {
                $img_url_code .= ', ';
            }

            /********* Asigna el max-width complementario *********/

            /* Si la condicion no se cumple, significa que es el ultimo array y no se necesita el max-width */
            if ($size != $sizeNameValue) {
                $sizesUrlsCode .= '(max-width:' . ($sizeWimgCurrent + 48) . 'px) ' . $sizeWimgCurrent . 'px, ';
            } else {
                $sizesUrlsCode .= '100vw';
            }
        }

        /* Preparar la etiqueta para salida */

        $formater .= 'src="' . sp_get_img__url($size, $image_id) . '" ';
        $formater .= 'srcset="' . $img_url_code . '" ';
        $formater .= 'sizes="' . $sizesUrlsCode . '" ';

        /* Obtener datos de la imagen solicitada para los atributos width y height */
        if ($image_id === 0) {
            if (get_post_thumbnail_id()) {
                $image_id = get_post_thumbnail_id();
            }
        }

        $imgObject = wp_get_attachment_image_src($image_id, $size);

        $formater .= 'width="' . $imgObject[1] . '" ';
        $formater .= 'hight="' . $imgObject[2] . '"';

        if ($lazyload === true) {
            $formater .= ' loading="lazy"';
        }

        return $formater;
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
