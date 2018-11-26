<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?>

	<div id="footer">
		<div id="bottom_menu">
			<?php
				if (is_page ("contact")) {
				
				} else { 
				
				}
			?>
			<div id="links"
				<ul>
					<?php wp_list_bookmarks('title_li=&categorize=0&orderby=id'); ?>
				</ul>
			</div>		
			<div id="sub_contact">
				<span class="divider">|</span>
				<span>JOIN OUR NEWSLETTER :&nbsp;&nbsp;</span>
			</div>
			<div id="newsletter">
				<?php echo do_shortcode('[contact-form 1 "newsletter"]');?>
			</div>	 						
			<div id="copy">
				<span class="divider">|</span>
				<span>&copy; YOSSIODED.COM</span>
			</div>	
		</div>
	</div><!-- END OF FOOTER -->
</div> <!-- END OF CONTAINER -->
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>