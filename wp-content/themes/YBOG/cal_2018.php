<?php
/**
 * Template Name:2018
 *
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
			
			<div id="item-<?php the_ID();?>" class="calendar">
				<h1><?php the_title(); ?></h1>
			
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
				
				$querystr = "
	SELECT * FROM $wpdb->posts
	LEFT JOIN $wpdb->postmeta ON($wpdb->posts.ID = $wpdb->postmeta.post_id)
	LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
	LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
	LEFT JOIN $wpdb->terms ON($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
	WHERE $wpdb->terms.name = '2018'
	AND $wpdb->term_taxonomy.taxonomy = 'category'
	AND $wpdb->posts.post_status = 'publish'
	AND $wpdb->posts.post_type = 'post'
	AND $wpdb->postmeta.meta_key = 'YBOG_start_date'
	ORDER BY $wpdb->postmeta.meta_value DESC
";


				$events = $wpdb->get_results($querystr, OBJECT);

		?>
			
		<?php if ($events): ?>
 		<?php global $post; ?>
  		<?php foreach ($events as $post): ?>
    	<?php setup_postdata($post); ?>

   			 <div id="item-<?php the_ID();?>" class="news">
              	<div id="event_date">
              	
              	<?php 
				$start = get_meta_by_key('YBOG_start_date',$post->ID );
				$end = get_meta_by_key('YBOG_end_date',$post->ID );
				
				if ($start == $end) {
				?> <h3><?php echo $start ?></h3>
				<?php
				} else {
				?> 	<h3><?php echo $start ." - ".$end ; ?></h3>
				<?php }
				?>	
               	</div>
              	
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

  <?php endforeach; ?>
  
  <?php else : ?>
    <h2 class="center">Not Found</h2>
    <p class="center">Sorry, but you are looking for something that isn't here.</p>
    
 <?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
<?php endwhile; ?>

			</div> <!-- END OF LEFT COLUMN-->
		</div> <!-- END OF ITEM-->	
	</div> <!-- END OF CONTENT-->

</div> <!--END OF MAIN-->
<?php get_footer(); ?>