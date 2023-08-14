<?php

define( 'ACF_NESTED', true ); //Allow flexible content nested
define( 'ACF_ONLY_CP', false ); //Allow use only components ACF. Disable Blocks
define( 'ACF_MODAL', false ); //Allow modal for add components en flexible content


/*  |> Custom save
——————————————————————————————————————————————————————*/

add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_save_point( $path ) {

	// Set custom path
	$path = get_stylesheet_directory() . '/ACF/acf-json';

	return $path;
}

/*  |> Custom load
——————————————————————————————————————————————————————*/

add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );

function my_acf_json_load_point( $paths ) {

	// remove original path (optional)
	unset( $paths[0] );

	// append path
	$paths[] = get_stylesheet_directory() . '/ACF/acf-json';

	return $paths;
}


/*  |> Styles admin
——————————————————————————————————————————————————————*/


add_action( 'acf/input/admin_enqueue_scripts', 'sp_acf_register_assets' );
add_action( 'acf/input/admin_enqueue_scripts', 'sp_acf_enqueue_assets' );

/**
 * Register assets
 */
function sp_acf_register_assets() {
	wp_enqueue_style( 'acf-styles', get_template_directory_uri() . '/assets/css/acf-styles.css', false, filemtime( get_template_directory() . '/assets/css/acf-styles.css' ) );

	if ( ACF_MODAL ) {
		wp_register_style( 'acf-fl', get_template_directory_uri() . '/assets/css/acf-flexible-content.css', false, '1.0' );
		wp_register_script( 'acf-fl', get_template_directory_uri() . '/assets/js/acf-flexible-content.js', false, '1.0', true );
	}
}

/**
 * Enqueue assets
 */
function sp_acf_enqueue_assets() {
	wp_enqueue_script( 'acf-fl' );
	wp_enqueue_style( 'acf-fl' );
	wp_enqueue_style( 'acf-styles' );
}

add_action(
	'admin_head',
	function () {
		$styles_injected = <<<HERE
		<style>
		:root {
			--icon-settings: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'%3E%3Cpath d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z'/%3E%3C/svg%3E");
		}

		.icon-acf {
			background-repeat: no-repeat;
			background-size: contain;
			background-position: center;
			width: 22px;
			height: 15px;
			display: inline-block;
			-webkit-transition: .3s;
			-o-transition: .3s;
			transition: .3s;
			transform: scale(1.3) translate(0px, 3px);
		}

		.icon-settings {
			background-image: var(--icon-settings)
		}
	</style>
	HERE;

		echo $styles_injected;
	}
);

/*  |> Filter HTML anchor before save into DB
——————————————————————————————————————————————————————*/

function filter_slug_id( $field ) {
	return sp_acf_slugify( $field );
}
add_filter( 'acf/update_value/name=html_anchor', 'filter_slug_id', 10, 1 );

/**
 * Returns a slug friendly string.
 *
 * @date    24/12/17
 * @since   5.6.5
 *
 * @param   string $str The string to convert.
 * @param   string $glue The glue between each slug piece.
 * @return  string
 */
function sp_acf_slugify( $str = '', $glue = '-' ) {
	$raw  = $str;
	$slug = str_replace( array( '_', '-', '/', ' ' ), $glue, strtolower( remove_accents( $raw ) ) );
	$slug = preg_replace( '/[^A-Za-z0-9' . preg_quote( $glue ) . ']/', '', $slug );

	/**
	 * Filters the slug created by acf_slugify().
	 *
	 * @since 5.11.4
	 *
	 * @param string $slug The newly created slug.
	 * @param string $raw  The original string.
	 * @param string $glue The separator used to join the string into a slug.
	 */
	return apply_filters( 'sp_acf_slugify', $slug, $raw, $glue );
}

if ( ! ACF_ONLY_CP ) {

	/*  |> Register blocks for ACF
	——————————————————————————————————————————————————————*/

	function my_acf_block_render_callback( $block ) {

		// convert name ("acf/nameblock") into path friendly slug ("nameblock")
		$slug = str_replace( 'acf/', '', $block['name'] );

		// include a template part from within the "ACF/blocks/template-blocks" folder
		if ( file_exists( get_theme_file_path( "/ACF/blocks/template-blocks/bk_{$slug}.php" ) ) ) {
			include get_theme_file_path( "/ACF/blocks/template-blocks/bk_{$slug}.php" );
		}
	}

	add_action( 'acf/init', 'my_acf_blocks_init' );
	function my_acf_blocks_init() {

		foreach ( glob( get_theme_file_path( 'ACF/blocks/init-blocks/*.php' ) ) as $filename ) {
			include $filename;
		}
	}
}

if ( ACF_ONLY_CP ) {

	/*  |> Disabled all Blocks Gutenberg
	——————————————————————————————————————————————————————*/

	function wpdocs_allowed_block_types( $block_editor_context, $editor_context ) {
		if ( ! empty( $editor_context->post ) ) {
			return array();
		}

		return $block_editor_context;
	}

	add_filter( 'allowed_block_types_all', 'wpdocs_allowed_block_types', 10, 2 );
}

function sp_display_admin_notice() {
	?>
	<?php if ( ! class_exists( 'ACF' ) ) : ?>
		<div class="notice notice-warning">
			<p>The current theme <code><?php echo esc_html( wp_get_theme()->get( 'Name' ) ); ?></code> works with Advanced Custom Fields (ACF), please install it.</p>
		</div>
	<?php endif; ?>

	<?php
}
add_action( 'admin_notices', 'sp_display_admin_notice' );


/*  |> Add flexible content subtitles
——————————————————————————————————————————————————————*/

add_filter( 'acf/fields/flexible_content/layout_title/name=layout_builder', 'my_acf_fields_flexible_content_layout_title', 10, 4 );
add_filter( 'acf/fields/flexible_content/layout_title/name=page_builder', 'my_acf_fields_flexible_content_layout_title', 10, 4 );
function my_acf_fields_flexible_content_layout_title( $title, $field, $layout, $i ) {

	// load text sub field
	if ( $text = get_sub_field( 'section_name' ) ) {
		$title .= '<b class="acf-section-name">' . esc_html( $text ) . '</b>';
	}
	return $title;
}


/*  |> OPTIONS PAGES
——————————————————————————————————————————————————————*/

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		array(
			'page_title' => __( 'Global Options' ),
			'menu_title' => __( 'Global Options' ),
			'menu_slug'  => 'global-options',
			'icon_url'   => 'dashicons-hammer',
			'redirect'   => true, //Si esta en false crea tambien una subpagina con ese nombre
		)
	);

	// acf_add_options_sub_page(
	// 	array(
	// 		'page_title'  => __( 'Footer' ),
	// 		'menu_title'  => __( 'Footer' ),
	// 		'parent_slug' => 'global-options',
	// 	)
	// );
}

/*————————————————————————————————————————————————————*\
	●❱ Modal Flexible Content
\*————————————————————————————————————————————————————*/

if ( ACF_MODAL ) {
	add_action( 'acf/input/admin_footer', 'my_acf_admin_footer' );
}
function my_acf_admin_footer() {
	?>

	<div class="fl__container" data-popup-dest data-url-theme="<?php echo get_template_directory_uri(); ?>">
		<div class="fl__inner-wrp">

			<button class="fl__btn-close button-close"><span class="visually-hidden">Close</span><span class="icon icon-close"></span></button>
			<div class="fl__header">
				<h2 class="fl__title">Select the component</h2>
				<div class="fl__search-wrp">
					<label class="visually-hidden" for="fl-search">Search component</label>
					<input id="fl-search" type="search" placeholder="Search component..." type="button">
				</div>
				<div class="fl__actions">
					<button class="fl__actions-item" data-value="3"><span class="visually-hidden">Grid 3</span><span class="icon icon-grid-3"></span></button>
					<button class="fl__actions-item active" data-value="4"><span class="visually-hidden">Grid 4</span><span class="icon icon-grid-4"></span></button>
				</div>
			</div>

			<div class="fl__content" data-columns="4">

				<?php for ( $i = 0; $i < 10; $i++ ) : ?>
					<a href="#" data-layout="layout_column_2" data-min="" data-max="" class="fl-card">
						<div class="fl-card__img-wrp">
							<img src="https://picsum.photos/550/310" class="fl-card__img" width="550" height="310">
						</div>
						<div class="fl-card__title-wrp">
							<h2 class="fl-card__title">Cards Columns</h2>
						</div>
					</a>
				<?php endfor; ?>

			</div>
		</div>
	</div>

	<?php
}
