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
		<p>&copy; <?php echo date('Y'); ?><span>Designed & developed by <a href="http://arraydesign.ca">Array Design Studio</a>. Powered by <a href="http://wordpress.org">WordPress</a>.</span></p>
	</div>
<?php if (is_ie()) { ?></div><?php } else { ?></footer><?php } ?><!-- END footer -->
<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/wires.js"></script>
<!--[if lte IE 9]><script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/lte-ie9.js"></script><![endif]-->
<!--[if IE 8]><script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/ie8.js"></script><![endif]-->
<!--[if IE 7]><script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/ie7.js"></script><![endif]-->
</body>
</html>