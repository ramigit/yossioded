<?php
/**
 * Template Name:Yossi&Oded
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

	<div id="main">
<?php get_sidebar(); ?>
			
		<div id="content">
		
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
			<div id="item-<?php the_ID();?>" class="item">

				<div class="left_col">
					
					<h1><?php the_title(); ?></h1>
								
					<?php the_content() ?>
					
					<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
			
				</div> <!-- END OF LEFT COLUMN -->
			
				<div class="right_col">
			
		    	<?php if ( has_post_thumbnail() ) { ?>
		    	<div>
					<div class="featured_img"><?php the_post_thumbnail('full', array('class' => 'alignright'));  // Display a single image as  featured image if there is one ?></div>
				</div>
			<?php	
			} elseif ( wp_plugin_post_page_associator::get_associated_posts ($page_id = Null) ) { 
				
				echo do_shortcode('[associated_posts]');  // display video (embed or not) as associated post if there is one			
			} else {
			 	echo do_shortcode('[photospace]'); // display image gallery
			}	
			?>
			
				</div> <!-- END OF RIGHT COLUMN -->			
			</div>
									
			<?php $page_id = 70; //Yossi's page
			$page_data = get_page( $page_id );
			$title = $page_data->post_title;
			$content = $page_data->post_content;
			$img = get_the_post_thumbnail( $page_id, 'full' );
			?>
		
			<div id="item-<?php echo $page_id;?>" class="sub_item">

				<div class="left_col">
		
					<h1><?php echo $page_data->post_title; ?></h1>
			
					<?php echo $page_data->post_content; ?>
					
					<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '', $page_id ); ?>
	
				</div> <!-- END OF LEFT COLUMN -->
				
				<div class="right_col">
				
					<div class="alignright"><?php echo $img; ?></div>	
						
				</div> <!-- END OF RIGHT COLUMN -->
				
			</div>
			
			<?php $page_id = 72; //Oded's page 
			$page_data = get_page( $page_id );
			$title = $page_data->post_title;
			$content = $page_data->post_content;
			$img = get_the_post_thumbnail( $page_id, 'full' );
			?>
		
			<div id="item-<?php echo $page_id;?>" class="sub_item">

				<div class="left_col">
		
					<h1><?php echo $page_data->post_title; ?></h1>
			
					<?php echo $page_data->post_content; ?>
					
					<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '', $page_id ); ?>

			
				</div> <!-- END OF LEFT COLUMN -->
			
				<div class="right_col">
					<div class="alignright"><?php echo $img; ?></div>
				</div> <!-- END OF RIGHT COLUMN -->
	
			
			</div>

<?php endwhile; ?>

		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>