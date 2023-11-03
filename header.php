<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s_plus
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<meta name="theme-color" content="#011045">
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,700&family=Lato:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link visually-hidden-focusable" href="#main-content"><?php esc_html_e( 'Skip to content', '_s_plus' ); ?></a>

		<header id="header-content" class="site-header">

			<div class="container">
				<div class="row cent-y">
					<div class="col">
						<div class="site-header__branding cent-y">

							<?php if ( is_front_page() ) : ?>
								<h1 class="site-title">
									<span class="visually-hidden"><?php echo get_bloginfo( 'name' ); ?></span>
									<?php sp_the_header_logo(); ?>
								</h1>
							<?php else : ?>
								<p class="site-title">
									<?php sp_the_header_logo(); ?>
								</p>
							<?php endif; ?>

						</div>
					</div>
					<div class="col position-static">
						<div class="site-header__menu">

							<button id="site-nav-btn-menu" class="menu-toggle js-menu-toggle--open" aria-controls="primary-menu" aria-expanded="false"><span class="icon icon-menu"><span class="visually-hidden"><?php esc_html_e( 'Menu', '_s_plus' ); ?></span></span></button>

							<?php
							/*
							——— Wrapper menu mobile
							*/
							?>
							<div id="site-navigation" class="main-navigation effect--fadeIn">
								<button id="site-nav-btn-close" class="menu-toggle menu-toggle__close js-menu-toggle--close"><span class="icon icon-close"><span class="visually-hidden"><?php esc_html_e( 'Close Menu', '_s_plus' ); ?></span></span></button>

								<nav>
									<?php
									wp_nav_menu(
										array(
											'theme_location' => 'menu-1',
											'menu_id'      => 'primary-menu',
											'show_toggles' => true,
										)
									);
									?>
								</nav>
							</div><!-- #site-navigation -->
						</div>
					</div>
				</div>
			</div>

		</header><!-- #masthead -->

		<?php
		/*
		——— Delete if not use it
		It is necessary active styles css in header.scss
		*/
		$has_different_sticky_header = false;

		?>

		<?php if ( $has_different_sticky_header ) : ?>

			<section id="header-sticky-content" class="site-header-sticky">

				<div class="container">
					<div class="row cent-y">
						<div class="col">
							<div class="site-header-sticky__branding cent-y">

								<p class="site-title">
									<?php sp_the_header_logo(); ?>
								</p>

							</div>
						</div>
						<div class="col position-static">
							<div class="site-header-sticky__menu">

								<button id="site-nav-btn-menu--sticky-menu" class="menu-toggle js-menu-toggle--open" aria-controls="primary-menu" aria-expanded="false"><span class="icon icon-menu"><span class="visually-hidden"><?php esc_html_e( 'Menu', '_s_plus' ); ?></span></span></button>

								<?php
								/*
								——— Wrapper menu mobile
								*/
								?>
								<div id="site-navigation--sticky-menu" class="main-navigation effect--fadeIn">
									<button id="site-nav-btn-close--sticky-menu" class="menu-toggle menu-toggle__close js-menu-toggle--close"><span class="icon icon-close"><span class="visually-hidden"><?php esc_html_e( 'Close Menu', '_s_plus' ); ?></span></span></button>

									<nav>
										<?php
										wp_nav_menu(
											array(
												'theme_location' => 'menu-1',
												'menu_id' => 'primary-menu',
												'show_toggles' => true,
											)
										);
										?>
									</nav>
								</div><!-- #site-navigation -->
							</div>
						</div>
					</div>
				</div>

			</section><!-- #masthead -->

		<?php endif; ?>
