<?php
/**
 * Template Name: Home
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>


<div class="news-page-slider">
    <?php echo do_shortcode('[slideshow ID="106"]');?>
</div>
</div>


<div id="main">
    
    <?php get_sidebar(); ?>
			
		<div id="content">
		
			<div class="left_col">
			<?php
		//$sticky = get_option('sticky_posts');
		$args = array(
			'posts_per_page' => 7,		
			//'post__not_in'=> get_option('sticky_posts'),		
			'meta_key'=>'YBOG_news',
			'meta_value'=>'1',
			'post_type'=>'any',
			'caller_get_posts' => 0,
			);
		query_posts($args);

		if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<div id="item-<?php the_ID();?>" class="news">
				
				<?php 
				
				$key = "YBOG_link_to_page";
				$link = get_post_meta($post->ID, $key, true);
				if (empty($key) || (empty($link))) {
				?>
					<h1><?php the_title();?></h1>
				<?php
				} else { ?>
					<h1><a href="<?php echo $link; ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></h1>
		  <?php } ?>
				<?php the_content(); ?>
				</div>
		<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
			</div> <!-- END OF LEFT COLUMN -->
			
			<div class="right_col">
			<?php
		//$sticky = get_option('sticky_posts');
		$args = array(
			'posts_per_page' => 1,		
			//'post__not_in'=> get_option('sticky_posts'),		
			'meta_key'=>'YBOG_front_img',
			'meta_value'=>'1',
			'post_type'=>'any',
			'caller_get_posts' => 0,
			);
		query_posts($args);

		if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<!--<div id="item-<?php the_ID();?>" class="front_img">-->
				<?php the_content(); ?>
				<!--</div>-->
		<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
			
			</div> <!-- END OF RIGHT COLUMN -->

		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>