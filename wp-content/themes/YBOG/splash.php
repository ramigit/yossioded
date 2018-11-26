<?php
/**
 * Template Name: Splash
 * @package WordPress
 * @subpackage Starkers
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 * We filter the output of wp_title() a bit -- see
	 * twentyten_filter_wp_title() in functions.php.
	 */
	wp_title( '|', true, 'right' );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>

<div id="splash">
		
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
			<div id="item-<?php the_ID();?>" class="splash">
			
				<div id="splash_header">
					<div class="right_col">
					<?php the_content(); ?>
					</div>
					<div class="left_col">
					<h1><a href="<?php echo home_url( '/news/' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2><?php bloginfo( 'description' ); ?></h2>
					</div>
				</div>
				<?php echo do_shortcode('[slideshow]');?>
				<div class="enter_site">
				<a href="http://yossioded.com/news/" title="enter site">Enter Site &gt;&gt;</a>
				</div>		
			</div>
<?php endwhile; ?>

</div> <!-- END OF CONTAINER -->
<?php
	
	wp_footer();
?>
</body>
</html>