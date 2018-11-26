<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

	<div id="main">
<?php get_sidebar(); ?>
			
		<div id="content">
		
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
			<div id="item-<?php the_ID();?>" class="work">

			<div class="left_col">

				<h1><?php the_title(); ?></h1>
				<?php the_content()?>
				
				<!-- if it's a press post let's add press info-->				
				<?php 
				setup_postdata($post);
    				$author = get_post_meta($post->ID, 'YBOG_press_author', true);
    				$source = get_post_meta($post->ID, 'YBOG_press_source', true);
    			?>
				<div id="press_info" class="press">
	 				<?php
	 				if (!empty($author) && (!empty($source))) {?>
	 				<h3>&ndash; <?php echo $author .", ".$source ; ?></h3>
	 				<?php } elseif (!empty($author) && (empty($source))) {
	 				?> <h3>&ndash; <?php echo $author; ?></h3>
	 				<?php } elseif (!empty($source) && (empty($author))) {
	 				?> <h3>&ndash; <?php echo $source; ?></h3>
	 				<?php } else echo '' ; ?>
	 			</div>
<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
			</div> <!-- END OF LEFT COLUMN -->
			
			<div class="right_col">
			
		    	<?php if ( has_post_thumbnail() ) { ?>
		    	<div>
					<div class="featured_img"><?php the_post_thumbnail('full', array('class' => 'alignright'));  // Display a single image as  featured image if there is one ?></div>
					<div class= "featured_caption"><p><?php the_post_thumbnail_caption();?></p></div>
				</div>
			<?php				
			} else {
			 	echo do_shortcode('[photospace]'); // display image gallery
			}	
			?>
			
				</div> <!-- END OF RIGHT COLUMN -->	
	
	
			</div>
<?php endwhile; ?>

		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>