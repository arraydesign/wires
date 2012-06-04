<?php
/**
 * @package WordPress
 * @subpackage Wires
 * @since wires 2.1
 */

/**
 * Returns true if Internet Explorer has been detected.
 * @since wires 2.1
 */
function is_ie() {
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
		return true;
	} else {
		return false;
	}
}

/**
 * Disables the "Please update now" notice on the admin screen
 * @since wires 2.1
 */
add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );

/**
 * This gives us some options for styling the admin area
 * @since wires 2.1
 */
function custom_wires_css() {
	$wires_url = get_bloginfo( 'stylesheet_directory' );
   echo '<link rel="stylesheet" type="text/css" href="' . $wires_url .'/css/admin.css" />';
}
add_action('admin_head', 'custom_wires_css');

/**
 * Loads latest version of jQuery
 * @since wires 2.1
 */
if( !is_admin() ){
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rel_canonical' );	
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	wp_deregister_script('jquery');
	wp_deregister_script('l10n');
	wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"), false, '1.7.1');
	wp_enqueue_script('jquery');
}

/**
 * Removes unwanted styles from the format dropdown in TinyMCE 
 * @since wires 2.1
 */
function customformatTinyMCE($init) {
	// Add block format elements you want to show in dropdown
	$init['theme_advanced_blockformats'] = 'p,h3,h4,h5,h6';

	// Add elements not included in standard tinyMCE doropdown p,h1,h2,h3,h4,h5,h6
	//$init['extended_valid_elements'] = 'code[*]';

	return $init;
}

// Modify Tiny_MCE init
add_filter('tiny_mce_before_init', 'customformatTinyMCE' );
 
/**
 * Creates an is_subpage Conditional Tag
 * @since wires 2.1
 */
function is_subpage() {
	global $post;                                 		// load details about this page
        if ( is_page() && $post->post_parent ) {      // test to see if the page has a parent
               return $post->post_parent;             // return the ID of the parent post
        } else {                                      // there is no parent so...
               return false;                          // ...the answer to the question is false
        }
}

/**
 * Set the content width based on the theme's design and stylesheet.
 * @since wires 2.1
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run wires_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'wires_setup' );

if ( ! function_exists( 'wires_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since wires 2.1
 */
	function wires_setup() {
	
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 'auto', 137 ); // Width is automatic, height is 137px
		add_image_size( 'gallery-width', 365, 'auto' ); // Width is 365px, height is auto
		//add_image_size( 'width-priority', '300', 'auto' ); // Width is 300px, height is automatic
		add_image_size( 'full-width', 'auto', 'auto' ); // Width and height are automatic
	
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'aus' )
			//'secondary' => __( 'Secondary Navigation', 'aus' ),
			//'tertiary' => __( 'Tertiary Navigation', 'aus' )
		));
		
	}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 * @since wires 2.1
 */
function wires_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'wires_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 * @since wires 2.1
 * @return int
 */
function wires_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'wires_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 * @since wires 2.1
 * @return string "Continue Reading" link
 */
function wires_continue_reading_link() {
	return ' <a href="'. get_permalink() . '" class="more-link">' . __( 'More', 'aus' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 * @since wires 2.1
 * @return string An ellipsis
 */
function wires_auto_excerpt_more( $more ) {
	return ' &hellip;' . wires_continue_reading_link();
}
add_filter( 'excerpt_more', 'wires_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 * @since wires 2.1
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function wires_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= wires_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'wires_custom_excerpt_more' );

/**
 * The Pages shortcode, used anytime the <!--nextpage--> is used in a post/page
 * @since wires 2.1
 */
function wp_link_pages_aus($args = '') {
	$defaults = array(
		'before' => '<div id="wp_page_numbers"><ul>', 'after' => '</ul><div style="float: none; clear: both;"></div></div>',
		'link_before' => '<li>', 'link_after' => '</li>',
		'next_or_number' => 'number', 'nextpagelink' => __('&#171;'),
		'previouspagelink' => __('&#187;'), 'pagelink' => '%',
		'echo' => 1
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
				$j = str_replace('%',$i,$pagelink);
//				$output .= ;
				if ( ($i != $page) || ((!$more) && ($page==1)) ) {
					$output .= $link_before . _wp_link_page($i);
				} else {
					$output .= '<li class="active_page"><a href="#">';
				}
				$output .=  $j . '</a>';
				if ( ($i != $page) || ((!$more) && ($page==1)) )
					$output .= $link_after;
			}
			$output .= $after;
		} else {
			if ( $more ) {
				$output .= $before;
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= _wp_link_page($i);
					$output .= $link_before. $previouspagelink . $link_after . '</a>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= _wp_link_page($i);
					$output .= $link_before. $nextpagelink . $link_after . '</a>';
				}
				$output .= $after;
			}
		}
	}

	if ( $echo )
		echo $output;

	return $output;
}

/**
 * The Gallery shortcode.
 * @since wires 2.1
 * @param array $attr Attributes attributed to the shortcode.
 * @return string HTML content to display gallery.
 */
function wires_gallery_shortcode($null, $attr = array( )) {
	global $post;
	
	static $instance = 0;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'listclass'  => '',
		'itemtag'    => 'li',
		'icontag'    => 'span',
		'captiontag' => 'span',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'collection' => 'galcollection'
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$collection = tag_escape($collection);
	$selector = "gallery-{$instance}";

	$output = apply_filters('gallery_style', "
		<!-- see wires_gallery_shortcode() in wp-content/themes/aus/functions.php -->
		<ul id='$selector' class='inline gallery {$listclass} gallery-id-{$id}'>");

	$i = 0;
	
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, false, false);
		$link = str_replace('<a href=', "<a rel='$collection' href=", $link);
//		$itemSelector = "{$itemId}";
		static $itemId = 0;
		$itemId++;
		
		$output .= "<{$itemtag} class='gallery-item' id='$selector-{$itemId}'>";
		if ($icontag != '') {
			$output .= "
				<{$icontag} class='gallery-icon'>
					$link
				</{$icontag}>";
		} else {
			$output .= "$link";
		}
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $listclass != 'carousel' && $listclass != 'carousel scroll' && $columns > 0 && ++$i % $columns == 0 )
			$output .= '<li class="clear-both"><![if !IE 7]><br/><![endif]><!--[if lte IE 7]>&nbsp;<![endif]--></li>';
	}

	$output .= "</ul>";

	return $output;
}
add_filter( 'post_gallery', 'wires_gallery_shortcode', 10, 2 );

/**
 * Get current page URL
 * @since wires 2.1
 */

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

/**
 * The Links / Bookmarks display function
 * @since wires 2.1
 */

function wires_list_bookmarks($args = '') {
	$defaults = array(
		'orderby' => 'name',
		'order' => 'ASC',
		'limit' => -1,
		'categorize' => 1,
		'category' => '',
		'exclude_category' => '',
		'category_name' => '',
		'hide_invisible' => 1,
		'show_updated' => 0,
		'echo' => 1,
		'title_li' => 0,
		'title_before' => '<li><h3>',
		'title_after' => '</h3></li>',
		'category_orderby' => 'name',
		'category_order' => 'ASC',
		'class' => 'linkcat',
		'category_before' => '',
		'category_after' => ''
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$output = '<ul class="inline small">';

	if ( $categorize ) {
		//Split the bookmarks into ul's for each category
		$cats = get_terms('link_category', array('name__like' => $category_name, 'include' => $category, 'exclude' => $exclude_category, 'orderby' => $category_orderby, 'order' => $category_order, 'hierarchical' => 0));

		foreach ( (array) $cats as $cat ) {
			$params = array_merge($r, array('category'=>$cat->term_id));
			$bookmarks = get_bookmarks($params);
			if ( empty($bookmarks) )
				continue;
			$output .= str_replace(array('%id', '%class'), array("linkcat-$cat->term_id", $class), $category_before);
			$catname = apply_filters( "link_category", $cat->name );
			$output .= "$title_before$catname$title_after\n";
			$output .= _walk_bookmarks($bookmarks, $r);
			$output .= "\n$category_after\n";
		}
	} else {
		//output one single list using title_li for the title
		$bookmarks = get_bookmarks($r);

		if ( !empty($bookmarks) ) {
			if ( !empty( $title_li ) ){
				$output .= str_replace(array('%id', '%class'), array("linkcat-$category", $class), $category_before);
				$output .= "$title_before$title_li$title_after\n\t<ul class='xoxo blogroll'>\n";
				$output .= _walk_bookmarks($bookmarks, $r);
				$output .= "\n\t</ul>\n$category_after\n";
			} else {
				$output .= _walk_bookmarks($bookmarks, $r);
			}
		}
	}

	$output .= '</ul>';
	$output = apply_filters( 'wires_list_bookmarks', $output );

	if ( !$echo )
		return $output;
	echo $output;
}

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 * @since wires 2.1
 * @uses register_sidebar
 */
function wires_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Primary Sidebar', 'aus' ),
		'id' => 'primary-sidebar',
		'description' => __( 'The Primary Sidebar widget area', 'aus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Secondary Sidebar', 'aus' ),
		'id' => 'secondary-sidebar',
		'description' => __( 'The Secondary Sidebar widget area', 'aus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Tertiary Sidebar', 'aus' ),
		'id' => 'tertiary-sidebar',
		'description' => __( 'The Tertiary Sidebar widget area', 'aus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );

}
/** Register sidebars by running wires_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'wires_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 * @since wires 2.1
 */
function wires_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'wires_remove_recent_comments_style' );

if ( ! function_exists( 'wires_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 * @since wires 2.1
 */
	function wires_posted_on() {
		printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'aus' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date()
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'aus' ), get_the_author() ),
				get_the_author()
			)
		);
	}
endif;

if ( ! function_exists( 'wires_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 * @since wires 2.1
 */
	function wires_posted_in() {
	// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list ) {
			$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'aus' );
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'aus' );
		} else {
			$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'aus' );
		}
		// Prints the string, replacing the placeholders.
		printf(
			$posted_in,
			get_the_category_list( ', ' ),
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	}
endif;

/**
 * The Archives widget
 * @since wires 2.1
 */
class WIRES_Archives_Widget extends WP_Widget {

	function WIRES_Archives_Widget() {
		$widget_ops = array('classname' => 'widget_wires_archive', 'description' => __( 'Archives of your site&#8217;s posts') );
		$this->WP_Widget('wires_archives', __('Archives'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$c = $instance['count'] ? '1' : '0';

		echo $before_widget;
?>
		<div id="cats" class="textwidget">
			<h4>Categories</h4>
			<ul><?php wp_list_categories(array(
				'orderby'				=>	'name',
				'order'              =>	'ASC',
				'show_last_update'   =>	0,
				'style'              =>	'list',
				'show_count'			=>	$c,
				'hide_empty'         =>	1,
				'child_of'           =>	0,
				'title_li'				=>	'',
				'hierarchical'       =>	true,
				'number'             =>	NULL,
				'echo'               =>	1,
				'depth'              =>	0,
				'current_category'   =>	0,
				'pad_counts'         =>	0));
			?></ul>
		</div>
		<div id="years" class="textwidget">
			<h4>Years</h4>
			<ul><?php wp_get_archives(array(
				'type'	=>	'yearly',
				'format'	=>	'html',
				'show_post_count' => $c));
			?></ul>
		</div>		
<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$instance['count'] = $new_instance['count'] ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$count = $instance['count'] ? 'checked="checked"' : '';
?>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
		</p>
<?php
	}
}

/**
 * The Recent Articles widget
 * @since wires 2.1
 */
class WIRES_Recent_Widget extends WP_Widget {

	function WIRES_Recent_Widget() {
		$widget_ops = array('classname' => 'widget_wires_recent', 'description' => __( "List of latest articles") );
		$this->WP_Widget('recent-posts', __('Recent Articles'), $widget_ops);
		$this->alt_option_name = 'widget_wires_recent';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_wires_recent', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 5 )
			$number = 5;

		$r = new WP_Query(array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<h2>From the Blog</h2>
		<ul class="inline">
		<?php while ($r->have_posts()) :
			$r->the_post(); ?>
			<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_ion_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_ion_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_ion_recent_posts', 'widget');
	}

	function form( $instance ) {
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;
?>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}

/**
 * eNewsletter Subscription widget
 * @since wires 2.1
 */
class WIRES_Subscribe_Widget extends WP_Widget {

	function WIRES_Subscribe_Widget() {
		$widget_ops = array('classname' => 'widget_wires_subscribe', 'description' => __('eNewsletter Subscription form'));
		$this->WP_Widget('wires_subscribe', __('eNewsletter Subscription'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$text = apply_filters( 'widget_text', $instance['text'], $instance ); ?>
		<?php echo $before_widget; ?>
			<h2 class="brd-bott">eNewsletter</h2>
			<form action="http://email.arraydesign.ca/t/r/s/myukyl/" method="post" id="subForm" class="textwidget">
				<fieldset>
					<div class="fieldrow text" id="name-row">
						<label for="name">Name</label>
						<input type="text" name="cm-name" id="name" />
					</div>
					<div class="fieldrow text" id="email-row">
						<label for="myukyl-myukyl">Email</label>
						<input type="text" name="cm-myukyl-myukyl" id="myukyl-myukyl" />
					</div>
					<small>We keep your information private</small>					
					<button type="submit" class="btn-large" id="searchsubmit"><span>Submit</span></button>
				</fieldset>
			</form>
		<?php echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'text' => '' ) );
		$text = format_to_edit($instance['text']);
?>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
<?php
	}	
}

/**
 * Registers custom widgets
 * @since wires 2.1
 */
 
function wires_register_widgets() {
	register_widget('WIRES_Archives_Widget');
	register_widget('WIRES_Recent_Widget');
	register_widget('WIRES_Subscribe_Widget');
}
add_action('widgets_init', 'wires_register_widgets' );

/**
 * Unregisters widgets that are not needed
 * @since wires 2.1
 */
 
function wires_unregister_widgets() {
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Custom_Menu');	
	unregister_widget('WP_Widget_Groups');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Members');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Nav_Menu_Widget');
}
add_action( 'widgets_init', 'wires_unregister_widgets' );

/**
 * Create the ID column for media
 * @since wires 2.1
 */
 
function wires_column_id($columns) {
    $columns['colID'] = __('ID');
    return $columns;
}
add_filter( 'manage_media_columns', 'wires_column_id' );
function wires_column_id_row($columnName, $columnID){
    if($columnName == 'colID'){
       echo $columnID;
    }
}
add_filter( 'manage_media_custom_column', 'wires_column_id_row', 10, 2 );