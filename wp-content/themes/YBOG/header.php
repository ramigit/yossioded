<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?><!DOCTYPE html>
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
<!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie.css" />
<![endif]--> 
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

<div id="container">

	<div id=header>
        <div class="header-left">
            <h1><a href="<?php echo home_url( '/news/' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <h2><?php bloginfo( 'description' ); ?></h2>
        </div>
        <?php // if ($_SERVER["REQUEST_URI"] == "" || $_SERVER["REQUEST_URI"] == "/") { ?>
            <div class="header-right">
                <?php print get_post_field('post_content', '106'); ?>
            </div>
        <?php // } ?>
	</div>
