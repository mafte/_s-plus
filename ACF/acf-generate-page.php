<?php
$flexibleContentPath = get_template_directory() . '/ACF/flexible-content/';
if ( have_rows( 'page_builder' ) ) :
	while ( have_rows( 'page_builder' ) ) :
		the_row();
		$layoutPage = get_row_layout();

		//Get all fields for current component
		/* If it is equal to 'null', then we don't have a nested layout, so we get the data in another way */
		if ( $page_builder[ get_row_index() - 1 ] != null ) {
			$cp = (object) $page_builder[ get_row_index() - 1 ];
		} else {
			$cp = (object) get_row( true );
		}

		$file = ( $flexibleContentPath . str_replace( '_', '-', $layoutPage ) . '.php' );

		if ( file_exists( $file ) && $cp->cp_hidden != true ) {

			/* Attributes like ID and data-background */
			$atts_globals = '';
			if ( $cp->html_anchor ) {
				$atts_globals = 'id="' . $cp->html_anchor . '"';
			}

			if ( $cp->background != 'c-none' ) {
				$atts_globals .= ' data-bg="' . $cp->background . '" ';
			}

			include $file;
		}
	endwhile;
endif;
