<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package synextic
 */

if ( function_exists('get_field') ) {
	$theme_header_logo=					get_field('theme_header_logo','options');
	$logo=		get_field('logo_black','options');
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<title><?php bloginfo( 'name' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<?php wp_body_open(); ?>

		<header>
			<div class="container-17">
				<div class="row-flex">
					<div class="site-logo">
						<a href="<?php echo get_site_url() ?>">
							<img src="<?php echo $logo["link"] ?>" alt="<?php echo $logo["title"] ?>">
						</a>
					</div>


					<div class="menu">

						<div class="mobile_menu_top ">
							<span class=""><i class="las la-times"></i></span>
						</div>
							<?php
								wp_nav_menu( array(
									'theme_location' => 'header_main_navigation',
									'menu_class'     => 'ul_s',
									'walker'         => new WP_Bootstrap_Navwalker(),
								) );
							?>
					</div>

					<div class="toggle_mobile">
						<span><i class="las la-bars"></i></span>
					</div>
				</div>
			</div>
		</header> <!-- header  -->

		<main>