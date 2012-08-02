<?php
/**
 * @package WordPress
 * @subpackage Wires
 * @since wires 2.1
 */
?>
	</div><!-- END .wrapper -->

	<?php if (is_ie()) { ?><div class="footer"><?php } else { ?><footer><?php } ?>
		<div>
			<p>&copy; <?php echo date('Y'); ?>. <span class="source-org vcard copyright">Copyright info.</span> <span>Designed & developed by <a href="http://arraydesign.ca">Array Design Studio</a>. Powered by <a href="http://wordpress.org">WordPress</a>.</span></p>
		</div>
	<?php if (is_ie()) { ?></div><?php } else { ?></footer><?php } ?><!-- END footer -->
	<?php wp_footer(); ?>
	<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
	<script type="text/javascript">
		WebFont.load({
			typekit: { id: 'xxxxxx' },
			custom: { families: ['optima-std'], urls: ['/css/assets/'] }
		});
	</script> -->
	<script type="text/javascript" src="https://raw.github.com/OscarGodson/jKey/master/jquery.jkey.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.fancybox.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/wires.js"></script>
<?php if (is_ie()) { ?>
	<!--[if lte IE 8]><script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/lte-ie8.js"></script><![endif]-->
	<!--[if IE 7]><script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/ie7.js"></script><![endif]-->
<?php } else { ?>
	<!--[if IE 9]><script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/ie9.js"></script><![endif]-->
<?php } ?>
</body>
</html>