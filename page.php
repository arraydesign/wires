<?php
/**
 * @package WordPress
 * @subpackage Wires
 * @since wires 2.1
 */

get_header(); ?>

	<div class="content">
		<?php if (is_paged()) : ?>

			<div class="main">
				<?php if (have_posts()) :
					while (have_posts()) :
						the_post();
						the_content();
						wp_link_pages_aus();
					endwhile;
				else: ?>

					<div id="not-found">
						<h2 class="brd-bott">Not Found.</h2>
						<p>Sorry, it seems you’ve been led astray.</p>
					</div><!-- END #not-found -->
	
				<?php endif; ?>
			</div><!-- END .main -->

		<?php else: ?>
	
			<?php if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>	
				
					<?php $the_deck = get_post_meta($post->ID, 'deck', true); if ($the_deck != "") : ?>
						<div class="deck">
							<?php echo $the_deck; ?>
						</div><!-- END .deck -->
					<?php endif; ?>
	
					<div class="main">
						<?php the_content(); wp_link_pages_aus(); ?>				
					</div><!-- END .main -->

				<?php endwhile;
			else: ?>

				<div class="main">
					<div id="not-found">
						<h2 class="brd-bott">Not Found.</h2>
						<p>Sorry, it seems you’ve been led astray.</p>
					</div><!-- END #not-found -->
				</div><!-- END .main -->
	
			<?php endif; ?>

		<?php endif;
		get_sidebar(); ?>
	</div><!-- END .content -->

<?php get_footer(); ?>
