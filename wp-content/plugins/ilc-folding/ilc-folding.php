<?php
/**
 * @package ILC-Folding
 * @author Elliot
 * @version 1.0
 */
/*
Plugin Name: ILC Folding
Plugin URI: http://www.ilovecolors.com.ar/folding-menu-plugin-wordpress/
Description: This plugin enables folding menus on your Pages widget.
Author: Elliot
Version: 1.0
Author URI: http://www.ilovecolors.com.ar/
*/

function hoverIntent_init (){
	wp_enqueue_script('hoverIntent', '/wp-content/plugins/ilc-folding/jquery.hoverIntent.minified.js',array('jquery'));
}
add_action('init', 'hoverIntent_init'); 

function ilc_addFolding_init(){    
	wp_enqueue_script('ilc_folding', '/wp-content/plugins/ilc-folding/folding.js', array('hoverIntent')); 
}  
add_action('init', 'ilc_addFolding_init'); 

?>
