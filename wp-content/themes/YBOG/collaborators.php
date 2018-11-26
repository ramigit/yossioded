<?php
/**
 * Template Name:Collaborators
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

<div id="main">
<?php get_sidebar(); ?>
			
		<div id="content">
		
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
			<div id="item-<?php the_ID();?>" class="item">
			
			<?php if ( is_front_page() ) { ?>
						<h2><?php the_title(); ?></h2>
					<?php } else { ?>	
						<h1><?php the_title(); ?></h1>
					<?php } ?>	
				<div class="top">
					<?php the_content(); ?> 
				</div>
				<div class="right_col">
			
		    	<?php if ( has_post_thumbnail() ) { ?>
		    	<div>
					<div class="featured_img"><?php the_post_thumbnail('full', array('class' => 'alignright'));  // Display a single image as  featured image if there is one ?></div>
					<div class= "featured_caption"><p><?php the_post_thumbnail_caption();?></p></div>
				</div>
			<?php	
			} elseif ( wp_plugin_post_page_associator::get_associated_posts ($page_id = Null) ) { 
				
				echo do_shortcode('[associated_posts]');  // display video (embed or not) as associated post if there is one			
			} else {
			 	echo do_shortcode('[photospace]'); // display image gallery
			}	
			?>
			
				</div> <!-- END OF RIGHT COLUMN -->	
	
				<div class="left_col">
				<?php 
					 $idObj = get_category_by_slug('collaborators'); 
  					 $cat_id = $idObj->term_id;
  					 $cat_name = get_cat_name( $cat_id );
				?>
	 			<h1><?php echo $cat_name ?></h1>

				 <?php
				 $args = array(
					'numberposts' => -1,				
					'category_name'=>'collaborators',
					'orderby' => 'title',
					'order' =>'ASC',
				);

				$collaborators = get_posts($args);
 					foreach ($collaborators as $post) : 
   					setup_postdata($post);
	 			?> 
	    			<div id="item-<?php the_ID();?>" class="collaborators">
              			<div><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
	    			</div>
				<?php endforeach; ?>

						
				<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
				</div> <!-- END OF LEFT COLUMN -->
			
					
			</div>
<?php endwhile; ?>


		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>