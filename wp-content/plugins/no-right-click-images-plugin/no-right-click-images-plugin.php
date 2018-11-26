<?PHP
/*
Plugin Name: No Right Click Images Plugin
Plugin URI: http://www.BlogsEye.com/
Description: Uses Javascript to prevent right clicking of images to help keep leaches from copying images
Version: 1.2
Author: Keith P. Graham
Author URI: http://www.BlogsEye.com/

This software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/************************************************************
* 	kpg_no_rc_img_fixup()
*	Shows the javascript in the footer so that the image events can be adjusted
*
*************************************************************/
function kpg_no_rc_img_fixup() {
	// this is the No Right Click Images functionality.
	
?>
<script language="javascript" type="text/javascript">
	// <!--
	// No Right Click Images Plugin
	function kpg_nrci_context(event) {
		//alert("context");
		var ev=event||window.event;
		var targ=ev.srcElement||ev.target;
		ev.returnValue=false;
		if (ev.preventDefault) {  
			ev.preventDefault(); 
		}
		ev.returnValue=false;
		return false;
	}
	var targImg=null;
	function kpg_nrc1_mousedown(event) {
		var ev=event||window.event;
		var targ=ev.srcElement||ev.target;
		if (targ.tagName=="IMG"||targ.tagName=="img") {
			targImg=targ;
		}
		return true
	}
	function kpg_nrci_contextAll(event) {
		if (targImg==null) return true;
		var ev=event||window.event;
		if (targImg.tagName=="IMG"||targImg.tagName=="img") {
			ev.returnValue=false;
			if (ev.preventDefault) {  
				ev.preventDefault(); 
			}
			ev.returnValue=false;
			targImg=null;
			return false;
		}
		return true;
	}
	// sets the image onclick event
	function kpg_nrci_action(event) {
		try {
			var b=document.getElementsByTagName("IMG");
			for (var i = 0; i < b.length; i++) {
			    b[i].oncontextmenu=function(event) { return kpg_nrci_context(event);}   
				b[i].onmousedown=function(event) { return kpg_nrc1_mousedown(event);} 
				b[i].ondragstart=function() { return false;}  
			}
		} catch (ee) {}
		// set the document onclick in case someone loads a new image 
		document.onmousedown=function(event) { return kpg_nrc1_mousedown(event);} 
		document.oncontextmenu=function(event) { return kpg_nrci_contextAll(event);}   
		// other events
		document.ondragstart=function(event) { return kpg_nrci_contextAll(event);}  
		
	}
	// set the onload event
	if (document.addEventListener) {
		document.addEventListener("DOMContentLoaded", function(event) { kpg_nrci_action(event); }, false);
	} else if (window.attachEvent) {
		window.attachEvent("onload", function(event) { kpg_nrci_action(event); });
	} else {
		var oldFunc = window.onload;
		window.onload = function() {
			if (oldFunc) {
				oldFunc();
			}
				kpg_nrci_action('load');
			};
	}
	// end of No Right Click Images Plugin
	// -->
</script>

<?php
}
function kpg_no_rc_img_control()  {
// this is the display of information about the page.
	$bname=urlencode(get_bloginfo('name'));
	$burl=urlencode(get_bloginfo('url'));
	$bdesc=urlencode(get_bloginfo('description'));

?>

<div class="wrap">
<h2>No Right Click Images Plugin</h2>
<h4>The No Right Click Images Plugin is installed and working correctly.</h4>
<p>This plugin installs some javascript in the footer of every page. When your page finishes loading, the javascript steps through the tags on the page looking for Images and sets them so the context menu won't appear.</p>
<p>There are no configurations options. The plugin is on when it is installed and enabled. To turn it off just disable the plugin from the plugin menu.. </p>

<hr/>
<h3>If you like this plugin, why not try out these other interesting plugins.</h3>
<?php
// list of plugins
$p=array(
"facebook-open-graph-widget"=>"The easiest way to add a Facebook Like buttons to your blog' sidebar",
"threat-scan-plugin"=>"Check your blog for virus, trojans, malicious software and other threats",
"open-in-new-window-plugin"=>"Keep your surfers. Open all external links in a new window, automatically.",
"youtube-poster-plugin"=>"Automagically add YouTube videos as posts. All from inside the plugin. Painless, no heavy lifting.",
"permalink-finder"=>"Never get a 404 again. If you have restructured or moved your blog, this plugin will find the right post or page every time",
);
  $f=$_SERVER["REQUEST_URI"];
  // get the php out
  $ff=explode('page=',$f);
  $f=$ff[1];
  $ff=explode('/',$f);
  $f=$ff[0];
  foreach ($p as $key=>$data) {
	if ($f!=$key) { 
	$kk=urlencode($key);
		?><p>&bull;<span style="font-weight:bold;"> <?PHP echo $key ?>: </span> <a href="plugin-install.php?tab=plugin-information&plugin=<?PHP echo $kk ?>&TB_iframe=true&width=640&height=669">Install Plugin</a> - <span style="font-style:italic;font-weight:bold;"><?PHP echo $data ?></span></p><?PHP 
	}
  }
?>


<hr/>

<p>This plugin is free and I expect nothing in return. However, a link on your blog to one of my personal sites would be appreciated.</p>


<p>Keith Graham</p>
<p><a target="_blank" href="http://www.cthreepo.com/blog">Wandering Blog </a>(My personal Blog) <br />
  <a target="_blank"  href="http://www.cthreepo.com">Resources for Science Fiction</a> (Writing Science Fiction) <br />
  <a target="_blank"  href="http://www.jt30.com">The JT30 Page</a> (Amplified Blues Harmonica) <br />
  <a target="_blank"  href="http://www.harpamps.com">Harp Amps</a> (Vacuum Tube Amplifiers for Blues) <br />
  <a target="_blank"  href="http://www.blogseye.com">Blog's Eye</a> (PHP coding) <br />
  <a target="_blank"  href="http://www.cthreepo.com/bees">Bee Progress Beekeeping Blog</a> (My adventures as a new beekeeper) </p>
</div

>
<form method="post" action="options.php">
<?php settings_fields( 'myoption-group' ); ?>

</form>
<?php
}
// no unistall because I have not created any meta data to delete.
function kpg_no_rc_img_init() {
   add_options_page('No Right Click Images', 'No Right Click Images', 'manage_options',__FILE__,'kpg_no_rc_img_control');
}
  // Plugin added to Wordpress plugin architecture
	add_action('admin_menu', 'kpg_no_rc_img_init');	
	add_action( 'wp_footer', 'kpg_no_rc_img_fixup' );

	
?>