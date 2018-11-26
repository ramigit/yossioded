=== ILC Folding ===
Contributors: ilovecolors
Donate link: http://ilovecolors.com.ar/#paypal-donate
Tags: pages widget, folding, menu, jquery
Requires at least: 2.6
Tested up to: 2.7
Stable tag: trunk

Creates a folding menu for WordPress built-in Pages Widget.

== Description ==

ILC Folding works with parent/children hierarchy of the Pages Widget. It will progressively reveal the children of each parent page. When you visit a page that has children, they will be reveal, keeping the next level children hidden.
You can see a demo at 
http://www.ilovecolors.com.ar/ilctest/
Visit Page 2 to see their children. Child Page 2.1 works too.

== Installation ==

1. Upload `ilc-folding` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= Which is the version of jQuery that this plugin uses? =
The plugin enqueues the jQuery version included in WordPress. As of version 2.7 WP includes jQuery version 1.2.6. But WP 2.3.2 includes version 1.1.4 so it will probably be ok. I haven't tested Folding with jQuery 1.3 yet. The version included with WordPress is safe to be used along with scriptaculous, mootools and other libraries.


