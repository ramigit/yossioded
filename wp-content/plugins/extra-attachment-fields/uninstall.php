<?php
// if uninstall.php is not called by WordPress, die

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) die();
global $wpdb;
$wpdb->attachment_extra_fields_table =  $wpdb->prefix . 'attachment_extra_fields';
$sql = "DROP TABLE IF EXISTS `".$wpdb->attachment_extra_fields_table."`";
$wpdb->query( $sql );

delete_option("aef_db_version");

?>
