<?php
/**
 * Template Name:Works
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

	<div id="main">
<?php get_sidebar(); ?>
			
		<div id="content">
            <h1><?php the_title();?></h1>
            <?php
            $args = array(
            'post_parent' => 22,
            'post_type'   => 'any', 
            'numberposts' => -1,
            'post_status' => 'any' 
            );
            $children = get_children( $args );
            foreach ($children as $work) {
                print $work->post_title;
                print "<br>";
                // $media = get_attached_media( 'image' );
                $args = array(
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'numberposts' => -1,
                    'post_status' => 'inherit',
                    'post_parent' => $work->ID
                );
                $attachments = get_children( $args );
                // var_dump($attachments);
                foreach ($attachments as $attachment) {
                    // print $attachment->post_content . "<br>";
                    $querystr = "SELECT * from wp_postmeta where meta_key = 'display_on_works' and meta_value = 'on' and post_id = '" . $attachment->ID . "'";
                    $image_selected = $wpdb->get_results($querystr, OBJECT);
                    foreach ($image_selected as $image) {
                        var_dump($image);
                    }
                }
            }
            ?>
		</div> <!-- END OF CONTENT-->

	 </div> <!--END OF MAIN-->
<?php get_footer(); ?>
<!--
["ID"] => (int)
["post_author"] => (string)
["post_date"] => (string)
["post_date_gmt"] => (string)
["post_content"] => (string)
["post_title"] => (string)
["post_excerpt"] => (string)
["post_status"] => (string)
["comment_status"] => (string)
["ping_status"] => (string)
["post_password"] => (string)
["post_name"] => (string)
["to_ping"] => (string)
["pinged"] => (string)
["post_modified"] => (string)
["post_modified_gmt"] => (string)
["post_content_filtered"] => (string)
["post_parent"] => (int)
["guid"] => (string)
["menu_order"] => (int)
["post_type"] => (string)
["post_mime_type"] => (string)
["comment_count"] => (string)
["filter"] => (string)
-->