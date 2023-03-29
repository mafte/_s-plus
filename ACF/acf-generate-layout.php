<?php
if ( ACF_NESTED ) {
	$flexibleContentPath = get_template_directory() . '/ACF/flexible-content/';
	if ( have_rows( 'layout_builder' ) ) :
		while ( have_rows( 'layout_builder' ) ) :
			the_row();
			$layout = get_row_layout();

			//Get current row
			$page_builder = get_sub_field( 'page_builder' );

			$file = ( $flexibleContentPath . str_replace( '_', '-', $layout ) . '.php' );

			if ( file_exists( $file ) && get_sub_field( 'cp_hidden' ) != true ) {
				/* Attributes like ID and data-background */
				$atts_globals = '';
				if ( get_sub_field( 'html_anchor' ) ) {
					$atts_globals = 'id="' . get_sub_field( 'html_anchor' ) . '"';
				}

				if ( get_sub_field( 'background' ) != 'c-none' ) {
					$atts_globals .= ' data-bg="' . get_sub_field( 'background' ) . '" ';
				}
				include $file;
			}
		endwhile;
	endif;
} else {
	include get_template_directory() . '/ACF/acf-generate-page.php';
}
