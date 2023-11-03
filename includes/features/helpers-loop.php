<?php

if ( ! function_exists( 'sp_get_img__url' ) ) {
	/**
	 * Get the URL of the image according to the size and if desired according to the given image id.
	 *
	 * @param  string $size     Keyword for image size.
	 * @param  int    $image_id Image ID. Optional. By default it is the image id of the current post.
	 * @return string URL of the image.
	 */
	function sp_get_img__url( $size, $image_id = 0 ) {

		$path_placeholder = get_template_directory_uri() . '/assets/img/placeholder-image.svg';

		if ( 0 === $image_id ) {
			if ( get_post_thumbnail_id() ) {
				return esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), $size ) );
			}
		} elseif ( wp_get_attachment_image_url( $image_id, $size ) ) {
			return esc_url( wp_get_attachment_image_url( $image_id, $size ) );
		}

		return $path_placeholder;
	}
}

if ( ! function_exists( 'sp_get_img__alt' ) ) {
	/**
	 * Get alternative text for the given image id. By default it is the alt text of the featured image of the current post
	 *
	 * @param  int    $image_id Image ID. Optional. By default it is the image id of the current post.
	 * @return string Alt text of the image.
	 */
	function sp_get_img__alt( $image_id = 0 ) {

		if ( 0 === $image_id ) {
			$image_id = get_post_thumbnail_id();
		}

		return esc_attr( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) );
	}
}

if ( ! function_exists( 'sp_get_cat__name' ) ) {
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

if ( ! function_exists( 'sp_get_cat__url' ) ) {
	/**
	 * Get the url of the first category of the current post.
	 *
	 * @return string Category URL.
	 */
	function sp_get_cat__url() {
		return esc_url( get_category_link( get_the_category()[0]->term_id ) );
	}
}

if ( ! function_exists( 'sp_the_excerpt' ) ) {
	/**
	 * @param $length Maximum number of words
	 */

	function sp_the_excerpt( $length = 120 ) {
		esc_html( wp_trim_words( get_the_excerpt(), $length ) );
	}
}


if ( ! function_exists( 'sp_get_asset' ) ) {

	/**
	 * Generate a URL for a assets folder
	 *
	 * @param  string $asset  Asset name
	 * @return string  Url asset
	 */
	function sp_get_asset( $asset ) {
		$template_uri = get_template_directory_uri();

		return esc_url( "{$template_uri}/assets/{$asset}" );
	}
}


if ( ! function_exists( 'sp_get_asset_img' ) ) {

	/**
	 * Generate img tag with its attributes from assets/img folder
	 *
	 * @param  string $img_name  Asset name
	 * @param  string $class_css  Class CSS
	 * @return string  Print img tag
	 */
	function sp_get_asset_img( $img_name, $class_css = '' ) {

		$template_uri       = get_template_directory_uri();
		$template_directory = get_template_directory();
		$path               = "{$template_uri}/assets/img/{$img_name}";

		if ( ! file_exists( "{$template_directory}/assets/img/{$img_name}" ) ) {
			return;
		}

		$attrs  = getimagesize( $path );
		$width  = $attrs[0];
		$height = $attrs[1];

		echo '<img src="' . $path . '" alt="" class="' . $class_css . '" width="' . $width . '" height="' . $height . '">';
	}
}

if ( ! function_exists( 'sp_generate_link' ) ) {

	/**
	 * Generate link from the information of the "[CP-INNER] Link"
	 *
	 * @param  array  $array_link The input array from "[CP-INNER] Link".
	 * @param  string $class_css  CSS classes. Optional.
	 * @return string Generated HTML link.
	 */
	function sp_generate_link( $array_link, $class_css = 'button' ) {

		$link = $array_link['link'];
		if ( $link ) {

			if ( $link ) {
				$link_url    = $link['url'];
				$link_title  = $link['title'];
				$link_target = $link['target'] ? $link['target'] : '_self';
			}

			$ada_text   = '';
			$array_link = $array_link['ada'];
			if ( $array_link['add_ada_label'] ) {
				$ada_text = "aria-label=\"{$array_link['ada_label']}\"";
			}

			return "<a class=\"{$class_css}\" href=\"{$link_url}\" {$ada_text} target=\"{$link_target}\">{$link_title}</a>";
		} else {
			return null;
		}
	}
}

if ( ! function_exists( 'sp_get_terms_ids' ) ) {

	/**
	 * Gets terms IDs of taxonomies by post iID.
	 *
	 * @param int|WP_Post $post — Post ID or object.
	 * @param string $taxonomy — Taxonomy name.
	 *
	 * @return array Terms IDs or 'null' if taxonomy name no exist.
	 */
	function sp_get_terms_ids( $post, $taxonomy ) {

		if ( taxonomy_exists( $taxonomy ) ) {
			$terms_ids = array();

			$terms_object = get_the_terms( $post, $taxonomy );

			if ( $terms_object ) {
				foreach ( $terms_object as $term_item ) {
					$terms_ids[] = $term_item->term_id;
				}
			}

			return $terms_ids;
		}

		return null;
	}
}

if ( ! function_exists( 'sp_get_resp_img' ) ) {

	/**
	 * Get responsive images with height and width attributes.
	 *
	 * @param  string  $size  Keyword for image size.
	 * @param  int     $id    Image ID. Optional. By default it is the image ID of the current post.
	 * @param  string  $class Class CSS. Optional.
	 * @param  boolean $lazy  Native attribute for lazyload. Optional. By default it is TRUE.
	 * @return string  Image responsive with attributes.
	 */
	function sp_get_resp_img( $size = 'large', $id = 0, $class = '', $lazy = 'lazy' ) {

		/* If the $id is equal to null, then we get the id of the current post */
		if ( 0 === $id ) {
			$id = get_post_thumbnail_id();
		}

		/**
		 * If you are using the lazyload script then it will work differently.
		 */
		$has_lazyload = wp_script_is( 'lazyload' );
		if ( $lazy && ( true === $has_lazyload ) ) {
			$class .= ' lazy';
		}

		$sizes_img_widths = wp_get_registered_image_subsizes();
		$has_exists_size  = false;

		/* If $size value is incorrect then set 'large' by default */
		foreach ( $sizes_img_widths as $key => $value ) {
			if ( $key === $size ) {
				$has_exists_size = true;
				break;
			}
		}

		if ( ( false === $has_exists_size ) && ( 'full' !== $size ) ) {
			$size = 'large';
		}

		$sizes_default      = '(max-width: 1440px) calc(100vw - 48px), 1440px';
		$search_atrributes  = array( 'src="', 'srcset="', 'sizes="', 'loading="lazy"' );
		$changes_atrributes = array( 'data-src="', 'data-srcset="', 'data-sizes="', '' );

		/*
		——— If $size is 'full' then change the sizes
		*/
		if ( 'full' === $size ) {
			$original_img_html = wp_get_attachment_image(
				$id,
				$size,
				'',
				array(
					'class'   => trim( $class ),
					'sizes'   => $sizes_default,
					'loading' => $lazy,
				)
			);
		} else {
			$original_img_html = wp_get_attachment_image(
				$id,
				$size,
				'',
				array(
					'class'   => trim( $class ),
					'loading' => $lazy,
				)
			);
		}

		/* If the image ID is incorrect or non-existent then return the image placeholder. */
		if ( '' === $original_img_html ) {

			if ( 'full' === $size ) {
				$size = 'large';
			}

			$placeholder_img = get_template_directory_uri() . '/assets/img/placeholder-image.svg';

			/* A placeholder of 1920 x 1080 is used, dividing it gives 1.77, which we occupy to get the proportion regardless of size.
			This allows the correct presentation in the browser of the placeholder without sudden jumps. */

			if ( $lazy && $has_lazyload ) {
				return "<img class=\"{$class}\" data-src=\"{$placeholder_img}\" alt=\"\" width=\"{$sizes_img_widths[$size]['width']}\" height=\"" . round( $sizes_img_widths[ $size ]['width'] / 1.77777777778 ) . '"/>';
			} elseif ( $lazy ) {
				return "<img class=\"{$class}\" src=\"{$placeholder_img}\" alt=\"\" width=\"{$sizes_img_widths[$size]['width']}\" height=\"" . round( $sizes_img_widths[ $size ]['width'] / 1.77777777778 ) . '" loading="lazy"/>';
			} else {
				return "<img class=\"{$class}\" src=\"{$placeholder_img}\" alt=\"\" width=\"{$sizes_img_widths[$size]['width']}\" height=\"" . round( $sizes_img_widths[ $size ]['width'] / 1.77777777778 ) . '"/>';
			}
		}

		/* If lazyload is active and lazy option es true then delete attribute HTML 'loading="lazy"' */
		if ( $has_lazyload && $lazy ) {
			return str_replace( $search_atrributes, $changes_atrributes, $original_img_html );
		} else {
			return $original_img_html;
		}
	}
}


if ( ! function_exists( 'sp_the_resp_img' ) ) {

	/**
	 * Get responsive images with height and width attributes.
	 *
	 * @param  string  $size  Keyword for image size.
	 * @param  int     $id    Image ID. Optional. By default it is the image ID of the current post.
	 * @param  string  $class Class CSS. Optional.
	 * @param  boolean $lazy  Native attribute for lazyload. Optional. By default it is TRUE.
	 * @return string  Image responsive with attributes.
	 */
	function sp_the_resp_img( $size = 'large', $id = 0, $class = '', $lazy = 'lazy' ) {
		echo sp_get_resp_img( $size, $id, $class, $lazy );
	}
}


/*
——— Hide admin bar in mobile devices
*/

function hide_admin_bar_in_mobile() {
	?>

	<?php if ( is_user_logged_in() ) : ?>

		<script>
			const mediaQuery = window.matchMedia('(max-width: 786px)');
			const wpAdminBar = document.getElementById('wpadminbar');
			var $htmlElement = document.querySelector('html');

			const handleMediaChange = (mediaQuery) => {
				if (mediaQuery.matches) {
					wpAdminBar.style.display = 'none';
					document.body.classList.remove('admin-bar');
					$htmlElement.setAttribute('style', 'margin-top: 0!important');
				} else {
					wpAdminBar.style.display = 'block';
					document.body.classList.add('admin-bar');
					$htmlElement.setAttribute('style', 'margin-top: 32px!important');
				}
			};

			mediaQuery.addEventListener('change', handleMediaChange);
			handleMediaChange(mediaQuery);
		</script>

	<?php endif; ?>

	<?php
}
add_action( 'wp_footer', 'hide_admin_bar_in_mobile' );
