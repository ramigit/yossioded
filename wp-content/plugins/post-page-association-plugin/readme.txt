=== Post Page Associator ===
Contributors: dhoppe
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=1220480
Tags: post, posts, page, pages, associate, association, attach, list, admin, content, cms, category, categories, tag, tags, author
Requires at least: 2.9
Tested up to: 3.1
Stable tag: trunk

The Post-Page-Associator enables you to attach posts to a page. This Plugin has been granted the "Famous Software" Award!


== Description ==

= LATEST NEWS! =
* [There is a PROFESSIONAL EDITION of this Plugin available now](http://wpplugins.com/plugin/247/associated-posts-pro)!
* Post-Page-Associator has been granted the "Famous Software" Award! [To the post &raquo;](http://download.famouswhy.com/post_page_associator/)

= Description =
As the name suggests the Post-Page-Associator enables you to attach posts to a page. You can select a set of posts by category, tag, author or you just select some posts explicitly. 


= Handling =
The handling is very easy. When you are going to edit a page you will see a box with the title "Associate posts with this page". There you can choose categories, tags, authors and posts which should attached to this page. Optionally you can set the number of posts which should be shown on the page and some more settings like the post order.


= It doesn't work! =
If you are wondering why there are no associated posts when you view the page i guess you aren't using PHP5. **Post-Page-Associator requires PHP5!**


= Settings =
You can change the association settings in WP Admin Panel &raquo; Settings &raquo; Associated Posts.


= ShortCode =
In case you won't have the associated posts at the end of your page you can use the <code>[associated_posts]</code> Shortcode anywhere in your pages content. So the posts will be shown at the place you inserted the ShortCode.
The old <code>[associated_posts enforce]</code> ShortCode is deprecated.


= Customization =
If you need a customized template of the associated posts. E.g. as list or with author, date, time or meta data feel free to send me an E-Mail. For a small fee i will write a customized template for you.


= How to write an own customization =
A template is a php file which renders the output of the associated posts (a WP Query). You can find example template files in the plugin folder (templates/). You can store these templates in:

* PPA plugin templates folder (or a sub folder) (inadvisable)
* your theme folder (or a sub folder)
* wp-content/ppa-templates/ (or a sub folder)

The default header of a PPA template looks like that:
<code>
/*
PPA Template: Example Template
Description: This is the description.
Version: 1.0
Author: Your name
Author URI: http://example.com
Author E-Mail: yourname@example.com
*/
</code>

The only required information in the header is the "PPA Template" line. So the Plugin knows this is a PPA Template.


= For Theme Designers =
If you want to integrate this plug-in in your theme you have to add a new file to your theme directory: *associated-posts.php*

The plugin will use your template to show the associated posts on pages by default. You can find a working example file of this template in the plug-in directory (*templates/title-excerpt-thumbnail.php*). Just copy it in your template directory and modify it until it fits in your theme.

If you want to disable the auto append feature of the plug-in you can use the '*associated_posts_auto_append*' filter.
Just add this line of code to your *functions.php*:
<code>
Add_Filter ('associated_posts_auto_append', Create_Function('',' return False; ') );
</code>


= For real developers ;) =
As a real developer you can easy access to the associated posts via functions:

<code>
wp_plugin_post_page_associator::get_associated_posts ($page_id = Null){
/* $page_id: the id of the page which associated posts you want to read.
             if $page_id = Null, the plugin will read from current page.
   
   return:   By default the function returns a WP_Query Object.
             The object is very well documented in the Codex.
             If there are no posts this function returns false.
*/
}

wp_plugin_post_page_associator::has_associated_posts ($deprecated = True){
/*

  This function is deprecated. I will remove it in future releases!

*/
}
</code>

Real developers love the clout of their code. And as a real WordPress developer you know about the magic of hooks and filters. The Post-Page-Associator uses a filter with the name '*associated_posts_template*'. You can use this filter to set the template file of the associated posts. (You can overwrite the users template option with this filter.) You can find an example file of this template in the plug-in directory (*templates/title-excerpt-thumbnail.php*).


= Questions =
If you have any questions feel free to leave a comment in my blog. But please think about this: I will not add features, write customizations or write tutorials for free. Please think about a donation. I'm a human and to write code is hard work.


= In the Press =
* Bradley from [GetMochi.com](http://getmochi.com) has written a worth reading post how he uses the Post-Page-Associator Plugin. [To the post &raquo;](http://getmochi.com/blog/get-your-stylists-blogging-heres-how)
* [Tom Altman](http://tomaltman.com/) said "*Why are posts and pages so oil and water in WordPress?  This plugin bridges the gap and makes them more like chocolate and peanut butter.*" [To the post &raquo;](http://tomaltman.com/wordpress/wordpress-plugin/post-page-association/)
* [Annie Stasse](http://www.penseelibre.fr/) posted "Association des pages avec billets, catégories, mots-clés". [To the post &raquo;](http://www.penseelibre.fr/association-des-pages-avec-billets-categories-mots-cles/)



= Language =
* This Plugin is available in English.
* Dieses Plugin ist in Deutsch verfügbar. ([Dennis Hoppe](http://dennishoppe.de/))
* Este plugin está disponible en Español. ([Francisco Chaves](http://wikichaves.com/))
* Cette extension est traduite en français. ([Annie Stasse](http://www.penseelibre.fr/))
* Este Plugin está disponível em Português. (Paulo Teixeira)
* Questo Plugin è disponibilie in Italiano. (Pierfausto Martina)

If you have translated this plugin in your language feel free to send me the language file (.po file) via E-Mail with your name and this translated sentence: "This plugin is available in %YOUR_LANGUAGE_NAME%." So i can add it to the plugin.

You can find the *Translation.pot* file in the *language/* folder in the plugin directory.

* Copy it.
* Rename it (to your language code).
* Translate everything.
* Send it via E-Mail to mail@DennisHoppe.de.
* Thats it. Thank you! =)


== Installation ==
Installation as usual.

1. Unzip and Upload all files to a sub directory in "/wp-content/plugins/".
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to edit a page.
1. There is a new box with title "Associate posts with this page"

== Screenshots ==

1. Screenshot of the post selection box.


== Changelog ==

= 1.3.8 =
* Added 'plugin_locale' filter support


= 1.3.7 =
* Fixed: Warnings in "Choose Template" area in the meta box
 

= 1.3.6 =
* Fixed: Password protected pages does not show associated posts anymore.


= 1.3.5 =
* Fixed Quick Edit bug
* Added Multi Template Engine


= 1.3.4 =
* Added Portuguese translation file by Paulo Teixeira.
* Added Italian translation file by Pierfausto Martina.
* Updated the Translation.pot.


= 1.3.3 =
* Fixed: Avoid errors while reading thumbnail (array_merge() [function.array-merge]: Argument #2 is not an array)
* Added PHP4 Warning


= 1.3.2 =
* Fixed the template. User could now display thumb and/or excerpt
* User can select empty categories
* User can select unused tags


= 1.3.1 =
* Read template directory with get_query_template()
* Read style sheet directory with get_stylesheet_directory()
* Template Engine should now work with child themes


= 1.3 =
* renamed plugin class to "wp_plugin_post_page_associator"
* renamed default template file to "associated-posts.php"
* changed default template: renamed class of the posts from "associatd_posts" to "associated-posts"
* changed default template: wrapped post content in <div class="post-content" />
* changed default template: wrapped post excerpt in <div class="post-excerpt" />
* Added style sheet and style sheet filter
* Added new option: User can disable the auto append feature
* Load_Setting() is now get_option()


= 1.2.14 =
* Avoid directory listings


= 1.2.13 =
* Max hight of the selection fields inside the meta box is limited to 250px. This is the end of happy scrolling ;)


= 1.2.12 =
* Fixed Cloning bug of the current post var after the loop
* Cleand up the admin interface
* faster Queries for less parameters. :)


= 1.2.11 =
* Fixed author selection bug.
* Fixed the "all posts instead of nothing" bug. get_associated_posts() will return (bool) False if there are no posts associated.


= 1.2.10 =
* Changed variable in object to store current post query in function ShortCode().
* Swapped Desc for Asc in Edit page meta box order field.


= 1.2.9 =
* Added French translation file by [Annie Stasse](http://www.penseelibre.fr/).


= 1.2.8 =
* Fixed: Sticky posts will not be shown as associated.
* Fixed: PPA crashed in WP 2.8.6. Should work now.


= 1.2.7 =
* Fixed: Removed php warning if there are no authors
* Added new filter '*associated_posts_auto_append*', you can set this false to avoid auto appening the posts
* Removed *myPrint()* function... embarrassing :-(


= 1.2.6 =
* Added Spanish translation file by [Francisco Chaves](http://wikichaves.com/).


= 1.2.5 =
* Fixed: The Auto-Append Function sometimes failed because of a small bug in the wordpress core (ShortCode handler).


= 1.2.4 =
* The "enforce" attribute of the ShortCode is deprecated now
* The ShortCode will run as often as you insert it in your page
* the plugin adds thumbnail support to the theme


= 1.2.3 =
* Optimized the *template.php*. Please take a look of you use it in your theme.
* Removed the old Italian translation. Can someone make a new one?


= 1.2.2 =
* Use post object cloning to restore the last point after using a template
* Linked the thumbnails in the default template (you should assign that in your version)
* removed the function *get_the_excerpt()* (please notice)
* fixed the shortcode bug. Shortcodes should work now.


= 1.2.1 =
* Fixed some translation mistakes


= 1.2 =
* Change the post selection algorithm
* Easier integration in other themes and plugins


= 1.1.8 =
* Small code optimization.


= 1.1.7 (DEPRECATED) =
* Added the new parameter <code>$return_query</code> to the function <code>get_associated_posts</code>.


= 1.1.6 =
* Added Italian translation.


= 1.1.5 =
* You can hide the category name header above the associated posts area.


= 1.1.4 =
* Now you can change the header tag for the associated post area and the associated posts


= 1.1.3 =
* Tried to correct my bad English in the plug-in back end
* updated the German translations
* optimized the get_the_excerpt() function. (takes now an object as parameter.)
* corrected some Markdown mistakes in the readme.txt
* increased the version release number xD


= 1.1.2 =
* Added support for servers which do not allow using $_REQUEST
* New Feature: The plugin can show the full content of the posts


= 1.1.1 =
* Bug Fix: Fixed the Auto Append Bug.


= 1.1 (DEPRECATED - REMOVED IN 1.2) =
* Added Theme Support: If you use this plug-in in your theme add these line to your functions.php:
  <code>
  add_theme_support('associated_posts');
  </code>
  So the plug-in knows that your theme supports associated posts.
* Added new feature: You can make the plug-in to show a thumb of the associated posts and an excerpt.


= 1.0 =
* Everything works fine.
