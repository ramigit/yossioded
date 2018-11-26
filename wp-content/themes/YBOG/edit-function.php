<?php 

	function smart_add_custom_box() {
 		if( function_exists( 'add_meta_box' )) {			
			add_meta_box( 'promote_to_front', 'Promote to NEWS Page', 'promote_to_front_custom_box','post' ,'side', 'high' );	 	
			add_meta_box( 'smart_sectionid', 'Event Info', 'smart_inner_custom_box','post', 'side', 'high' );
			add_meta_box( 'smart_sectionid', 'Full title for Work Page', 'insert_title_custom_box','page' ,'side', 'high' );
			add_meta_box( 'press_sectionid', 'Press info', 'press_info_custom_box','post' ,'normal', 'high' );

		}
	}

// Sticky posts	
   function promote_to_front_custom_box() {
		
		global $post;
		
		$news = get_post_meta($post->ID,'YBOG_news',true);
		$img = get_post_meta($post->ID,'YBOG_front_img',true);
		
		?>

	<input type="hidden" name="smart_noncename" id="smart_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />
	<p><?php
	_e('Select if the post should appear in the News page','YBOG');
	?>
	</p>

	<p>
		
		<input type="checkbox" name="YBOG_news" id="YBOG_news"
			size="25" value="1" <?php
				if ($news== "1")
					echo ' checked ';
			
			?>/>
			<label for="YBOG_news">
			<strong><?php _e('Display News Item','YBOG'); ?></strong>
		</label>
	</p>
	
	<p>
		
		<input type="checkbox" name="YBOG_front_img" id="YBOG_front_img"
			size="25" value="1" <?php
				if ($img== "1")
					echo ' checked ';
			
			?>/>
			<label for="YBOG_front_img">
			<strong><?php _e('Display NEWS Image','YBOG'); ?></strong>
		</label>
	</p>
	
		
	<?php
	}
	
	
	function promote_to_front_save_postdata( $post_id ) {

	  if ( !wp_verify_nonce( $_POST['smart_noncename'], plugin_basename(__FILE__) )) {
	    return $post_id;
	  }

	   if ( !current_user_can( 'edit_post', $post_id ))
	     return $post_id;
 
	  // Get and save data
		
		$metas = array(
			'YBOG_news',
			'YBOG_front_img',				
			
		);
		
		foreach ($metas as $meta) {
			$new = stripslashes($_POST[$meta]);
			$old = get_post_meta ($post_id,$meta,true);
			if (empty($new)) {
				delete_post_meta ($post_id,$meta,$old);
			} else {
				if (empty($old)) {
					add_post_meta ($post_id,$meta,$new,true);
				} else {
					update_post_meta ($post_id,$meta,$new,$old);
				}
			}	
		}

	}
   	
//Event's Info (link + dates)      	
 	function smart_inner_custom_box (){
 	global $post;
 	
 	$link = get_post_meta($post->ID,'YBOG_link_to_page',true); // adding link to page for news and calendar items
 	$start_date =  get_post_meta($post->ID,'YBOG_start_date',true); //  dates for events to use in the calendar
	$end_date = get_post_meta($post->ID,'YBOG_end_date',true); //  dates for events to use in the calendar

 	?>
 	<input type="hidden" name="smart_noncename" id="smart_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />
	<p><?php
	_e('Setting a link here will link the post to other page (like link to Work Page)','YBOG');
	?>
	</p>
	<p>
		<label for="YBOG_link_to_page">
			<strong><?php _e('Insert link:','YBOG'); ?></strong>
		</label><br />
		<input type="text" name="YBOG_link_to_page" id="YBOG_link_to_page"
			size="25" value="<?php echo $link ?>"
			style="width: 250px;" />
	</p>
	
	<p>
		<label for="YBOG_start_date">
			<strong><?php _e('Events Start date','YBOG'); ?></strong>
		</label><br />
		<input type="text" name="YBOG_start_date" id="YBOG_start_date"
			size="25" value="<?php if($start_date) echo date('d.m.Y',$start_date) ?>"
			style="width: 250px;" />
	</p>
	<p>
		<label for="YBOG_end_date">
			<strong><?php _e('Events End date','cca'); ?></strong>
		</label><br />
		<input type="text" name="YBOG_end_date" id="YBOG_end_date"
			size="25" value="<?php if($end_date) echo date('d.m.Y',$end_date) ?>"
			style="width: 250px;" />
	</p>
<?php
 	
 	}
 	
 	function smart_inner_save_postdata ( $post_id ){
 	 if ( !wp_verify_nonce( $_POST['smart_noncename'], plugin_basename(__FILE__) )) {
	    return $post_id;
	  }

	   if ( !current_user_can( 'edit_post', $post_id ))
	     return $post_id;
 
	  // Get and save data
		
		$metas = array(
			'YBOG_link_to_page',
			'YBOG_start_date',
			'YBOG_end_date'
		
		);
		
		foreach ($metas as $meta) {
			$new = stripslashes($_POST[$meta]);
			if($meta=='YBOG_start_date' || $meta=='YBOG_end_date')
				$new = proccess_meta_date($new);
			
			$old = get_post_meta ($post_id,$meta,true);
			if (empty($new)) {
				delete_post_meta ($post_id,$meta,$old);
			} else {
				if (empty($old)) {
					add_post_meta ($post_id,$meta,$new,true);
				} else {
					update_post_meta ($post_id,$meta,$new,$old);
				}
			}	
		}

	}

// Full title of Work's to show in work's page

function insert_title_custom_box() {
		
		global $post;
		
		$full_title = get_post_meta($post->ID,'YBOG_full_title',true); // Adding full title for work's page to use in work's page
		?>

		<input type="hidden" name="smart_noncename" id="smart_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />
		
		<p><?php
	_e('If the full title is set - it will be used in the work page. If not - the default title will be used','YBOG');
	?>
		</p>

		<p>
			<label for="YBOG_short_title">
			<strong><?php _e('Full title','YBOG'); ?></strong>
			</label><br />
			<input type="text" name="YBOG_full_title" id="YBOG_full_title"
			size="25" value="<?php echo $full_title ?>"
			style="width: 250px;" />
		</p>

<?php
}

	function smart_save_title( $post_id ) {

	  if ( !wp_verify_nonce( $_POST['smart_noncename'], plugin_basename(__FILE__) )) {
	    return $post_id;
	  }

	   if ( !current_user_can( 'edit_post', $post_id ))
	     return $post_id;
 
	  // Get and save data
		
		$metas = array(
			'YBOG_full_title',

		);
		
		foreach ($metas as $meta) {
			$new = stripslashes($_POST[$meta]);
			$old = get_post_meta ($post_id,$meta,true);
			if (empty($new)) {
				delete_post_meta ($post_id,$meta,$old);
			} else {
				if (empty($old)) {
					add_post_meta ($post_id,$meta,$new,true);
				} else {
					update_post_meta ($post_id,$meta,$new,$old);
				}
			}	
		}

	}

// Add Press info
function press_info_custom_box() {
		
		global $post;
		
		$press_author = get_post_meta($post->ID,'YBOG_press_author',true); // Adding author for press's item
		$press_source = get_post_meta($post->ID,'YBOG_press_source',true); // Adding source for press's item  
		?>

		<input type="hidden" name="smart_noncename" id="smart_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />
		
		<p><?php
	_e('info for Press Item','YBOG');
	?>
		</p>

		<p>
			<label for="YBOG_press_author">
			<strong><?php _e('Author','YBOG'); ?></strong>
			</label><br />
			<input type="text" name="YBOG_press_author" id="YBOG_press_author"
			size="25" value="<?php echo $press_author ?>"
			style="width: 250px;" />
		</p>
		<p>
			<label for="YBOG_press_source">
			<strong><?php _e('Source','YBOG'); ?></strong>
			</label><br />
			<input type="text" name="YBOG_press_source" id="YBOG_press_source"
			size="25" value="<?php echo $press_source ?>"
			style="width: 250px;" />
		</p>

<?php
}

	function smart_save_press_info( $post_id ) {

	  if ( !wp_verify_nonce( $_POST['smart_noncename'], plugin_basename(__FILE__) )) {
	    return $post_id;
	  }

	   if ( !current_user_can( 'edit_post', $post_id ))
	     return $post_id;
 
	  // Get and save data
		
		$metas = array(
			'YBOG_press_author',
			'YBOG_press_source',
		);
		
		foreach ($metas as $meta) {
			$new = stripslashes($_POST[$meta]);
			$old = get_post_meta ($post_id,$meta,true);
			if (empty($new)) {
				delete_post_meta ($post_id,$meta,$old);
			} else {
				if (empty($old)) {
					add_post_meta ($post_id,$meta,$new,true);
				} else {
					update_post_meta ($post_id,$meta,$new,$old);
				}
			}	
		}

	}

 	
	add_action('admin_menu', 'smart_add_custom_box');
   	add_action('save_post', 'promote_to_front_save_postdata');
   	add_action('save_post', 'smart_inner_save_postdata');
   	add_action('save_post', 'smart_save_title');
	add_action('save_post', 'smart_save_press_info');
?>
