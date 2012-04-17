<?php if (is_ie()) { ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><?php } else { ?><!DOCTYPE html><?php } ?>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" class="wf-inactive">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<title><?php
		global $page, $paged;
		wp_title( '|', true, 'right' );
		
		// Add the blog name.
		bloginfo( 'name' );
					
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'inpa' ), max( $paged, $page ) );
	?></title>
	
	<!-- <meta name="description" content="<?php bloginfo('description'); ?>" /> -->
	<!-- <meta property="og:title" content="<?php bloginfo( 'name' ); ?>" /> -->
	<!-- <meta property="og:type" content="company" /> -->
	<!-- <meta property="og:image" content="<?php bloginfo( 'stylesheet_directory' ); ?>/IMG-wires-og.png" /> -->
	<!-- <meta property="og:url"	content="<?php bloginfo('url'); ?>" /> -->
	<!-- <meta property="og:description" content="<?php bloginfo('description'); ?>" /> -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
<!-- 	<script type="text/javascript">
		WebFont.load({
			typekit: { id: 'xxxxxx' },
			custom: { families: ['optima-std'], urls: ['<?php bloginfo( 'stylesheet_directory' ); ?>/css/assets/'] }
		});
	</script> -->
	<?php wp_head();
//	if (is_page()) { remove_filter( 'the_content', 'wpautop' ); remove_filter( 'the_excerpt', 'wpautop' ); }
	?>	
	<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.fancybox.js"></script>
	<script type="text/javascript" src="https://github.com/jeresig/jquery.hotkeys/raw/master/jquery.hotkeys.js"></script>
	<!--[if lte IE 9]><link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/lte-ie9.css" /><![endif]-->
	<!--[if IE 8]><link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/ie8.css" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/ie7.css" /><![endif]-->
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
