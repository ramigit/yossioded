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
			
			<?php 
			$idObj = get_category_by_slug('press'); 
  			$cat_id = $idObj->term_id;	
			if ( in_category($cat_id)) { ?>
				<?php the_content() ?>
				<h3> &ndash; <?php the_title(); ?></h3>
			<?php
			}
			else { ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content()?>
			<?php
			}
			?>
			</div> <!-- END OF LEFT COLUMN -->
			
			<div class="right_col">

			<?php if ( has_post_thumbnail() ) { 
				the_post_thumbnail('full');  // Display a single image as  featured image if there is one 
				
			} elseif ( wp_plugin_post_page_associator::get_associated_posts ($page_id = Null) ) { 
				
				echo do_shortcode('[associated_posts]');  // display video (embed or not) as associated post if there is one			
			} else {
			 	echo do_shortcode('[photospace]'); // display image gallery
			}	
			?>
			
			</div> <!-- END OF RIGHT COLUMN -->
	
	<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
			</div>
<?php endwhile; ?>


		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>