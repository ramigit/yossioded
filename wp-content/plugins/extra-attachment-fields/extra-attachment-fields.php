<?php

/*
Plugin Name: Extra Attachment Fields
Plugin URI:  http://www.digitalworks.gr/
Description: Enable extra fields for media attachments
Version:     1.2.1
Author:      Giannis Kipouros
Author URI:  http://www.digitalworks.gr/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: attachment-extra-fields
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Register variables
global $wpdb;
global $aef_db_version;
global $fetch_ef_sql;
$aef_db_version = '1.2.1';
$wpdb->attachment_extra_fields_table =  $wpdb->prefix . 'attachment_extra_fields';

//Include Functions
include(plugin_dir_path(__FILE__).'inc/functions.php');

//MySQL code to fetch all extra fields
$fetch_ef_sql = "SELECT * FROM `".$wpdb->attachment_extra_fields_table."` ORDER BY enabled DESC, ordering DESC, `field-label` ASC";

//Run on plugin deactivation & create database if it does not exist.
function attachment_extra_fields_activation() {
	global $wpdb;
	global $aef_db_version;


	$charset_collate = $wpdb->get_charset_collate();

  // create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$wpdb->attachment_extra_fields_table'") != $wpdb->attachment_extra_fields_table)
	{

    	$sql = "CREATE TABLE `".$wpdb->attachment_extra_fields_table."` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `field-label` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
        `slug` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
        `input-type` int(5) DEFAULT NULL,
        `help-text` text CHARACTER SET utf8,
        `ordering` int(10) DEFAULT '0',
        `required` tinyint(1) DEFAULT '0',
        `enabled` tinyint(1) DEFAULT '0',
        PRIMARY KEY (`id`)
    	) $charset_collate;";

    	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    	dbDelta( $sql );
    	add_option( 'aef_db_version', $aef_db_version );
    }
}

register_activation_hook(__FILE__, 'attachment_extra_fields_activation');

//Run on plugin deactivation
function attachment_extra_fields_deactivation()
{
    // Add deactivation code here

}
register_deactivation_hook( __FILE__, 'attachment_extra_fields_deactivation' );


function aef21_add_extra_attachment_fields_admin_media_page_enqueue() {
    if ( !current_user_can( 'manage_options' ) )  {
  		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  	}
	  wp_enqueue_style( 'options-media-style', plugins_url('css/options_style.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'aef21_add_extra_attachment_fields_admin_media_page_enqueue' );


// Add extra fields to media uploader
function aef21_add_extra_attachment_fields_edit( $form_fields, $post )
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	global $fetch_ef_sql;
	global $wpdb;

  $results = $wpdb->get_results($fetch_ef_sql) ;

  $classes = get_post_meta( $id, 'classes', true );


  foreach ($results as $result)
  {

    if ($result->enabled==1)
    {
      //Select field type from input type
      if ($result->{'input-type'}==2){$result->ftype='textarea';}
      elseif($result->{'input-type'}==3){$result->ftype='checkbox';}
      elseif($result->{'input-type'}==4){$result->ftype='radio';}
      else{$result->ftype='text';}

      //Check if required;
      $result->is_required=($result->required==1?true:false);


      $form_fields[$result->slug] = array(
    		'label' => __($result->{'field-label'}),
    		'input' => 'html',
				'html'  => aef21_create_field($post,$result),
    		'helps' => __($result->{'help-text'}),
        'required' => $result->is_required
    	);
    }

  }


	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'aef21_add_extra_attachment_fields_edit', 10, 2 );


// Save values of extra attachment fields and URL in media uploader
function aef21_add_extra_attachment_fields_save( $post, $attachment )
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	global $wpdb;
	global $fetch_ef_sql;

  $results = $wpdb->get_results($fetch_ef_sql) or die(mysql_error());

  foreach ($results as $result)
  {
    if( isset( $attachment[$result->slug] ) )

  		update_post_meta( $post['ID'], $result->slug, $attachment[$result->slug] );

  }

	return $post;
}

add_filter( 'attachment_fields_to_save', 'aef21_add_extra_attachment_fields_save', 10, 2 );



/** Include Administration page. */
//echo plugin_dir_path(__FILE__).'admin_options.php';
include(plugin_dir_path(__FILE__).'admin_options.php');

// Create admin menu option in media menu
function aef21_add_extra_attachment_fields_plugin_menu() {
  global $page_hook_suffix;
	$page_hook_suffix = add_media_page( 'Extra Attachment Fields', 'Attachment Fields', 'manage_options', 'aef21_add_extra_attachment_fields', 'aef21_add_extra_attachment_fields_plugin_options' );
}
add_action( 'admin_menu', 'aef21_add_extra_attachment_fields_plugin_menu' );

function aef21_show_field_value($id, $slug)
{
	return get_post_meta($id, $slug, true);
}
?>
