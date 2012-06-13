<?php if (is_ie()) { ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><?php } else { ?><!DOCTYPE html><?php } ?>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" class="wf-inactive">
<head>
	<style type="text/css" media="screen">html.wf-loading h1, html.wf-loading h2, html.wf-loading h3, html.wf-loading h4, html.wf-loading p, html.wf-loading li, html.wf-loading a, html.wf-loading span, html.wf-loading label, html.wf-loading td, html.wf-loading th, html.wf-loading input, html.wf-loading select, html.wf-loading textarea, html.wf-loading small {visibility: hidden;}
	</style>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php
		global $page, $paged;
		wp_title( '|', true, 'right' );
		
		// Add the blog name.
		bloginfo( 'name' );
					
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'inpa' ), max( $paged, $page ) );
	?></title>
	<!-- <meta name="description" content="<?php bloginfo('description'); ?>"> -->
	<!-- <meta name="keywords" content=""> -->
	<!-- <meta property="og:title" content="<?php bloginfo( 'name' ); ?>"> -->
	<!-- <meta property="og:type" content="company"> -->
	<!-- <meta property="og:image" content="<?php bloginfo( 'stylesheet_directory' ); ?>/IMG-wires-og.png"> -->
	<!-- <meta property="og:url"	content="<?php bloginfo('url'); ?>"> -->
	<!-- <meta property="og:description" content="<?php bloginfo('description'); ?>"> -->
	<!-- <link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_directory' ); ?>/favicon.ico"> -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>">
	<?php wp_head();
//	if (is_page()) { remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' ); }
	?>
<?php if (is_ie()) { ?>
	<!--[if lte IE 8]><link rel="stylesheet" type="text/css" media="screen" href="<?= $burl ?>css/ie8.css" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href=<?= $burl ?>"css/ie7.css" /><![endif]-->
<?php } else { ?>
	<!--[if IE 9]><link rel="stylesheet" type="text/css" media="screen" href="<?= $burl ?>css/lte-ie9.css" /><![endif]-->
<?php } ?>
	<!-- wires.js is in the footer -->
</head>

<body <?php
$extraclass = '';
if (is_home() || is_single() || is_archive() || is_search()) { $extraclass = ' blog'; }
body_class( $extraclass ); ?>>

<ul id="grid"><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li><li class="img-txt">column</li></ul><!-- END #grid -->

<div class="wrapper">
	<?php if (is_ie()) { ?><div class="header"><?php } else { ?><header><?php } ?>
		<a href="index.php" id="logo"><?php bloginfo( 'name' ); ?></a>
		<?php if (is_ie()) { ?><div class="nav"><?php } else { ?><nav><?php } ?>
			<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
		<?php if (is_ie()) { ?></div><?php } else { ?></nav><?php } ?><!-- END nav -->
	<?php if (is_ie()) { ?></div><?php } else { ?></header><?php } ?><!-- END header -->
