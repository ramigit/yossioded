<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
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
		
			<div id="item-<?php the_ID();?>" class="item">

			<div class="left_col">

					<?php if ( is_front_page() ) { ?>
						<h2><?php the_title(); ?></h2>
					<?php } else { ?>	
						<h1><?php the_title(); ?></h1>
					<?php } ?>				

					<?php the_content() ?>
			
			</div> <!-- END OF LEFT COLUMN -->
			
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
	
	<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
			</div>
<?php endwhile; ?>


		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>