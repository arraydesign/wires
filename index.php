<?php
/**
 * @package WordPress
 * @subpackage Wires
 * @since wires 2.1
 */
get_header(); ?>

	<div class="content">
		<div class="main">

		<?php if (is_paged()) : ?>
		
			<?php if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>
				
					<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
						<div class="post-meta">
							by <?php the_author(); ?> <br />in <?php the_category(' '); ?> <br />on <?php the_date(); ?>
						</div>
						<div class="post-desc">
							<?php if ( has_post_thumbnail() ) { ?><a href="<?php the_permalink(); ?>" class="thumbnail post-thumb"><span><?php the_post_thumbnail(); ?></span></a><?php } ?>
							<?php the_excerpt(); ?>
						</div>
					</div><!-- END .type-post -->
			
				<?php endwhile;
				if(function_exists('wp_page_numbers')) { wp_page_numbers(); };
			elseif ( ! have_posts() ) : ?>

				<div id="not-found">
					<h1 class="brd-bott">Not Found.</h1>
					<p>Sorry, it seems you’ve been led astray.</p>
				</div><!-- END #not-found -->
		
			<?php endif;
			
		else : ?>

			<?php $blog_loop = new WP_Query(array('post_type' => 'post', 'posts_per_page' => '1'));
			while ($blog_loop->have_posts()) :
				$blog_loop->the_post(); $do_not_duplicate = $post->ID; ?>

				<div <?php post_class('latest'); ?> id="post-<?php the_ID(); ?>">
					<h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
					<div class="post-meta">
						by <?php the_author(); ?> <br />in <?php the_category(' '); ?> <br />on <?php the_date(); ?>
					</div>
					<div class="post-desc">
						<?php if ( has_post_thumbnail() ) { ?><a href="<?php the_permalink(); ?>" class="post-thumb"><span><?php the_post_thumbnail('full-width'); ?></span></a><?php } ?>
						<?php the_excerpt(); ?>
					</div>
				</div><!-- END .type-post.latest -->
						
			<?php endwhile; ?>
				
			<?php query_posts('post_type=post');
			if (have_posts()) :
				while (have_posts()) :
					the_post(); if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
						
					<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
						<div class="post-meta">
							by <?php the_author(); ?> <br />in <?php the_category(' '); ?> <br />on <?php the_date(); ?>
						</div>
						<div class="post-desc">
							<?php if ( has_post_thumbnail() ) { ?><a href="<?php the_permalink(); ?>" class="thumbnail post-thumb"><span><?php the_post_thumbnail(); ?></span></a><?php } ?>
							<?php the_excerpt(); ?>
						</div>
					</div><!-- END .type-post -->
						
				<?php endwhile;
				if (function_exists('wp_page_numbers')) { wp_page_numbers(); };
			else : ?>
					
				<div id="not-found">
					<h2 class="brd-bott">Not Found.</h2>
					<p>Sorry, it seems you’ve been led astray.</p>
				</div><!-- END #not-found -->
					
			<?php endif; /* This ends the second loop */
		endif; /* This ends the is_paged if statement */ ?>
			
		</div><!-- END .main -->
		<?php get_sidebar(); ?>
	</div><!-- END .content -->

<?php get_footer(); ?>
