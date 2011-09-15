<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;

		wp_title( '|', true, 'right' );

		// Add the blog name.
		bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( 'Page %s', max( $paged, $page ) );

	?></title>

	<meta http-equiv="imagetoolbar" content="false" />

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/libs/modernizr.min.js"></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="header">
		<div class="wrapper">
			<a href="http://happyheartsfund.org/" title="Happy Hearts Fund" class="hhf_logo">
				<img src="<?php bloginfo('stylesheet_directory') ?>/images/hhf_logo.png" alt="Happy Hearts Fund"
			</a>
			<a href="/" title="Schools Connect" class="sc_logo">
				<img src="<?php bloginfo('stylesheet_directory') ?>/images/sc_logo.png" alt="Schools Connect" />
			</a>
		
			<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
		</div>
	</div><!-- #header -->

	<div id="wrapper" class="hfeed">
		<?php if (is_user_logged_in()): ?>
			<div id="user_bar">
				<div class="username">
					<?php global $current_user; get_currentuserinfo(); ?>
					<strong>Hello, <?php echo $current_user->display_name ?></strong>
				</div>

				<nav>
					<ul>
						<li><a href="http://www.freetellafriend.com/?share" title="Share SchoolsConnect with People You Know" id="tellafriend">Tell People You Know</a></li>
						<li><a href="/teamup#school/<?php echo $current_user->ID ?>" title="Your Dashboard">Your School's Profile</a></li>
						<li><a href="<?php bloginfo('site_url') ?>/?a=logout" title="Logout">Logout</a></li>
					</ul>
				</nav>
			</div>
		<?php endif ?>

		<div id="main">