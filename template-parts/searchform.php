<?php

/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_unique_id/
 *
 * @package _s_plus
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$s_plus_unique_id = wp_unique_id( 'search-form-' );

$s_plus_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
?>
<form role="search" <?php echo $s_plus_aria_label; ?> method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $s_plus_unique_id ); ?>">
		<?php
		_e( 'Search&hellip;', '_s-plus' );
		?>
	</label>
	<input type="search" id="<?php echo esc_attr( $s_plus_unique_id ); ?>" class="search-field" value="<?php echo get_search_query(); ?>" name="s" />
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', '_s-plus' ); ?>" />
</form>
