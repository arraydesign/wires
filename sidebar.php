<?php
/**
 * @package WordPress
 * @subpackage Wires
 * @since wires 2.1
 */
?>

<?php if (is_ie()) { ?><div class="aside"><?php } else { ?><aside><?php } ?>
	<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'primary-sidebar' ); ?>
	<?php endif; ?>
<?php if (is_ie()) { ?></div><?php } else { ?></aside><?php } ?><!-- END aside -->