<!DOCTYPE html>



<!--[if IE 7]>

<html class="ie ie7" <?php language_attributes(); ?>>

<![endif]-->

<!--[if IE 8]>

<html class="ie ie8" <?php language_attributes(); ?>>

<![endif]-->

<!--[if !(IE 7) | !(IE 8)  ]><!-->

<html <?php language_attributes(); ?>>

<!--<![endif]-->



	<head>



		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>" charset="<?php bloginfo('charset'); ?>" />



		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">



		<title><?php wp_title( '|', true, 'right' ); ?></title> 

		

		

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <link rel="Shortcut Icon" type="image/x-icon" href="favicon.ico" />



		

		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->



		<?php wp_head(); ?>



		



	</head>



	<body id="index" <?php body_class(); ?> ontouchstart="">



		<!--[if lt IE 7]>



			<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>



		<![endif]-->



		<div id="wrapper">



			<header id="banner" class="container_4"  role="banner">

				

				

				

				<?php $header_image = get_header_image();

				if ( ! empty( $header_image ) ) { ?>

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo"><img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>

				

				<?php } else { ?>

				

					<hgroup>

						<h1 class="site-title"><a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>

					</hgroup>

				<?php } ?>

				



				<?php if ( has_nav_menu( 'main-menu' ) ) {



					wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu-container', 'menu' => 'main-menu', 'theme_location' => 'main-menu', 'menu_class' => 'main-menu', 'menu_id' => 'main-menu', ) );



				} ?>

				

				



				<div class="clear"></div>



			</header>