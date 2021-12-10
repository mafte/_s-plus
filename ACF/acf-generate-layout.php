<?php
$flexibleContentPath = get_template_directory() . '/ACF/flexible-content/';
if (have_rows('layout_builder')) :
    while (have_rows('layout_builder')) :
        the_row();
        $layout = get_row_layout();

        //Get current row
        $page_builder = get_sub_field('page_builder');

        $file = ($flexibleContentPath . str_replace('_', '-', $layout)  . '.php');
        if (file_exists($file)) {
            include($file);
        }
    endwhile;
endif;