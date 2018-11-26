/* ILC-Folding
 * http://ilovecolors.com.ar/folding-menu-plugin-wordpress/
 */


jQuery(document).ready(function(){
 // Roll over functions
 jQuery("#sidebar ul li").hoverIntent(  
 function() {
 	jQuery(this).children(".page_item ul").slideDown(); // Show the sub-categories
 },
 function() {
 	if(jQuery(this).children("ul").hasClass(".current_page_item ul") == false) {
 	jQuery(this).children(".page_item ul").slideUp(); // Hide sub-categories if we are not in the current category
 	} 
 }  
 ); // End roll over
 jQuery(".page_item ul").hide();
 jQuery(".children ul").hide();
 jQuery(".current_page_parent").children("ul").show();
 jQuery(".current_page_item ul:first").slideDown();
 // All this just to isolate the parent so it won't be clickable
 jQuery("ul li ul").parent().addClass("parent");
 jQuery("li.parent a").addClass("unclickable");
 jQuery(".children li a").removeClass("unclickable");
 jQuery(".unclickable").removeAttr("href");
 jQuery(".menu ul li a").removeAttr("title"); // Just because they don't like it 
});


