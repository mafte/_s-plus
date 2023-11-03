<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s_plus
 */

get_header();
?>

<main id="main-content" class="site-main">

	<section class="error-404 not-found">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="error-404__wrapper">
						<div class="error-404__error-number">
							<span class="number">404</span>
							<span class="text"><?php esc_html_e( 'error', '_s_plus' ); ?></span>
						</div>
						<div class="error-404__error-message">
							<h1 class="title"><?php esc_html_e( 'Oops! That page cant be found', '_s_plus' ); ?></h1>
							<p class="message">Don't worry, <a href="<?php echo esc_url( home_url( '/' ) ); ?>">go back to the page and continue browsing.</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- .error-404 -->

	<div class="error-404__ornament-wrapper">
		<div class="error-404__sun"></div>
		<div class="error-404__ornament">
			<?php echo file_get_contents( sp_get_asset( 'img/ornament-404.svg' ) ); ?>
			<div class="error-404__ornament-base"></div>
		</div>
	</div>

</main><!-- #main -->

<?php
get_footer();
