<?php
/**
 * Template Name:Press
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

	<div id="main">
<?php get_sidebar(); ?>
			
		<div id="content">
		
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
			<div id="item-<?php the_ID();?>" class="item">
			
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
			
				<h1><?php the_title(); ?></h1>
				
				
				<?php $categories = get_categories(array('parent' => 4, 'orderby' =>'id','order' => 'DESC') );
				foreach ($categories as $category){
					$cat_name =  $category->name;
					?>
				<div class="press_work">
					<h2><?php echo $cat_name;?></h2>
					
					<?php 
					 $args = array(
					'numberposts' => -1,				
					'category_name'=> $cat_name,
					 );

					$press = get_posts($args);
 					foreach ($press as $post) : 
    				setup_postdata($post);
    				$author = get_post_meta($post->ID, 'YBOG_press_author', true);
    				$source = get_post_meta($post->ID, 'YBOG_press_source', true);

	 			?> 
	 
	 				<div id="item-<?php the_ID();?>" class="press">	
	 				<?php the_excerpt(); ?>
	 				<?php
	 				if (!empty($author) && (!empty($source))) {?>
	 				<h3>&ndash; <?php echo $author .", ".$source ; ?></h3>
	 				<?php } elseif (!empty($author) && (empty($source))) {
	 				?> <h3>&ndash; <?php echo $author; ?></h3>
	 				<?php } elseif (!empty($source) && (empty($author))) {
	 				?> <h3>&ndash; <?php echo $source; ?></h3>
	 				<?php } else echo '' ; ?>
	 				</div>

				<?php endforeach; ?>
				</div>	
				<?php	
				};
				?>
				
									
			</div> <!-- END OF LEFT COLUMN -->
	
		</div>
<?php endwhile; ?>


		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>