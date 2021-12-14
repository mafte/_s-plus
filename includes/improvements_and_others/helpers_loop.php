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
     * @param  string  $size       Keyword for image size.
     * @param  int     $image_id   Image ID. Optional. By default it is the image id of the current post.
     * @param  boolean $lazyload   Native attribute for lazyload. By default it is TRUE.
     * @return string  Url and responsive image attributes.
     */
    function sp_get_img__resp($size = 'large', $image_id = 0, $lazyload = true) {

        /* If the image ID is incorrect or non-existent then return the image placeholder. */
        if (!wp_get_attachment_image_url($image_id, $size)) {
            $placeholder_img = get_template_directory_uri() . '/assets/img/placeholder-image.jpg';

            return 'src"' . $placeholder_img . '"';
        }

        /* Agregar todos los tamaños de imagen permitidos en la generación automatica. */
        $sizes_img_names  = array('medium', 'large', 'full', 'example-size');
        $sizes_img_widths = wp_get_registered_image_subsizes();
        $sizes_img_filter = array();

        $html_srcset = array();
        $html_sizes  = array();

        $html_output = '';

        /* Obtener datos de la imagen solicitada para los atributos width y height */
        if ($image_id === 0) {
            if (get_post_thumbnail_id()) {
                $image_id = get_post_thumbnail_id();
            }
        }

        $img_object = wp_get_attachment_image_src($image_id, $size);

        //var_dump($img_object);

        $html_output .= ' width="' . $img_object[1] . '" ';
        $html_output .= ' height="' . $img_object[2] . '"';

        // /* Filtrar los tamaños adecuados */

        // $indexKey = array_search($size, $sizes_img_names);

        // if ($indexKey !== count($sizes_img_names)) {

        //     //Cortara el array despues del tamaño deseado y lo asignara de nuevo a la variable ya filtrado

        //     $sizes_img_names = array_slice($sizes_img_names, 0, $indexKey + 1);

        // }

        /* FILTRAR TAMAÑOS DE IMAGEN *******************************/
        $i = 0;

        foreach ($sizes_img_names as $value) {

            /* Si es la imagen original, entonces asignamos los atributos necesarios. Por defecto no forma parte de los tamaños predeterminados.  */
            if ($value == 'full') {
                $sizes_img_filter[$i]['name']  = $value;
                $sizes_img_filter[$i]['width'] = wp_get_attachment_image_src($image_id, 'full')[1];
            } else {
                $sizes_img_filter[$i]['name']  = $value;
                $sizes_img_filter[$i]['width'] = $sizes_img_widths[$value]['width'];
            }
            $i++;
        }

        /* Ordenar los tamaños de menor a mayor con el valor 'width' */

        foreach ($sizes_img_filter as $key => $row) {
            $aux[$key] = $row['width'];
        }

        array_multisort($aux, SORT_ASC, $sizes_img_filter);


        /* CONSTRUCCION DE URLS *******************************/

        //Si el tamaño de imagen solicitado es igual al primer tamaño del array ordenado, entonces omitimos la imagen responsive.
        if ($size != $sizes_img_filter[0]['name']) {

            $i         = 1;
            $items_all = count($sizes_img_filter);

            foreach ($sizes_img_filter as $size_name_current) {

                $size_img_width_current = $size_name_current['width'];

                /* GENERACION DE SRCSET */
                $html_srcset[] = sp_get_img__url($size_name_current['name'], $image_id) . ' ' . $size_img_width_current . 'w';

                /*Si el nombre de imagen actual es igual al tamaño de imagen solicitado, entonces salimos del foreach porque no deseamos el resto,
            de tamaños de imagen. Ademas de eso, agregamos el ultimo size*/
                if ($size_name_current['name'] == $size) {
                    $html_sizes[] = '100vw';
                    break;
                }

                /* GENERACION DE SIZES */

                /* Si la condicion no se cumple, es el ultimo elemento, lo que no es necesario el max-width */
                if ($items_all != $i) {
                    $html_sizes[] = '(max-width:' . ($size_img_width_current + 48) . 'px) ' . $size_img_width_current . 'px';
                } else {
                    $html_sizes[] = '100vw';
                }

                $i++;
            }
        }
        /* PREPARAR SALIDA *******************************/

        $html_output .= 'src="' . sp_get_img__url($size, $image_id) . '" ';

        //Si el tamaño de imagen solicitado es igual al primer tamaño del array ordenado, entonces omitimos la imagen responsive.
        if ($size != $sizes_img_filter[0]['name']) {
            $html_output .= 'srcset="' . implode(', ', array_filter($html_srcset)) . '" ';
            $html_output .= 'sizes="' . implode(', ', array_filter($html_sizes)) . '" ';
        }


        if ($lazyload === true) {
            $html_output .= ' loading="lazy" ';
        }

        $html_output .= ' alt="' . sp_get_img__alt($image_id) . '" ';

        //Alt text

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
