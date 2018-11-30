=== Extra Attachment Fields ===
Contributors: giannis4,
Tags: extra fields, attachments, inputs, media, library, image, url
Requires at least: 4.6.1
Tested up to: 4.6.1
Stable tag: 1.2.1
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=J7GGEGDD4XV5S
License: GPLv2 or later
Author: Giannis Kipouros
Author URI: http://www.digitalworks.gr

Add extra custom fields to attachments at media library.

== Description ==

Extra Attachment Fields plugin allows the creation of custom extra input fields for attachments in media library. The user can create  custom fields for attachments, after enabling the plugin and selecting "Media" -> "Attachment Fields".

Enabled Extra Attachment Fields can be found on the properties page of each attachment.

Extract custom field values in your theme using:
aef21_show_field_value('Attachment ID', 'Custom field slug');

For example
$custom_value = aef21_show_field_value($attachment->ID, 'license-type');

= Field Types =
* Text
* Textarea
* Checkbox

= Please Vote and donate =
If you like this plugin, please vote and if you feel generous make a donation :).

== Installation ==
1. Upload Extra Attachment Fields into the directory `wp-content/plugins/`.
2. Enable Extra Attachment Fields plugin.
3. Go to Media -> Attachment Fields to start creating extra fields.

== Screenshots ==

1. Creating new Extra Attachment Fields and editing existing.
2. Showing extra fields at attachment edit page.
3. Showing extra fields at attachment quick edit.

== Frequently Asked Questions ==

There are no FAQ just yet.

== Upgrade Notice ==

There is no need to upgrade just yet.

== Changelog ==

= 1.2.1 =
First online release of Extra Attachment Fields
