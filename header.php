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
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<meta name="theme-color" content="gray">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link visually-hidden-focusable" href="#main-content"><?php esc_html_e('Skip to content', '_s_plus'); ?></a>
		<header id="masthead" class="site-header">

			<div class="container py-16">
				<div class="row cent-y">
					<div class="col">
						<div class="site-header__branding cent-y">

							<?php if (is_front_page()) : ?>
								<h1 class="site-title">
									<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php echo get_bloginfo('name'); ?>">
										<?php if (!get_theme_mod('custom_logo')) : ?>
											<img class="site-header__logo" src="<?php echo sp_get_asset('placeholder-logo.svg') ?>" alt="">
										<?php else : ?>
											<?php echo sp_img_resp('medium', get_theme_mod('custom_logo'), 'site-header__logo'); ?>
										<?php endif; ?>
										<span class="visually-hidden"><?php echo get_bloginfo('name'); ?></span>
									</a>
								</h1>
							<?php else : ?>
								<p class="site-title">
									<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php echo get_bloginfo('name'); ?>">
										<?php if (!get_theme_mod('custom_logo')) : ?>
											<img class="site-header__logo" src="<?php echo sp_get_asset('placeholder-logo.svg') ?>" alt="">
										<?php else : ?>
											<?php echo sp_img_resp('medium', get_theme_mod('custom_logo'), 'site-header__logo'); ?>
										<?php endif; ?>
									</a>
								</p>
							<?php endif; ?>

						</div>
					</div>
					<div class="col position-static">
						<div class="site-header__menu">

							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="icon icon-menu"><span class="visually-hidden"><?php esc_html_e('Menu', '_s_plus'); ?></span></span></button>

							<nav id="site-navigation" class="main-navigation effect--fadeIn">
								<button class="menu-toggle menu-toggle__close"><span class="icon icon-close"><span class="visually-hidden"><?php esc_html_e('Close Menu', '_s_plus'); ?></span></span></button>

								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'menu-1',
										'menu_id'        => 'primary-menu',
										'show_toggles' => true,
									)
								);
								?>
							</nav><!-- #site-navigation -->
						</div>
					</div>
				</div>
			</div>


		</header><!-- #masthead -->