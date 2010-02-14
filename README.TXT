=== Page.ly MultiEdit ===
Contributors: Joshua Strebel [(@strebel)](http://twitter.com/strebel)
Tags: multiedit, blocks, editable regions, tinymce, custom fields, page.ly
Requires at least: 2.9
Tested up to: 2.9.1

MultiEdit adds tinyMCE editable "blocks" to page templates. 
== Description ==

One thing I always wished WP would do better is allow for multiple editable content blocks on page templates. This plugin uses custom fields to create simple tinyMCE editable regions on page templates. 

See Instructions and Usage Examples here: [Page.ly MultiEdit plugin](http://blog.page.ly/multiedit-plugin/)

Brought to you by: [Page.ly WordPress Hosting](http://page.ly)

== Installation ==

# Upload the MultiEdit plugin to your blog/website
# Create a custom page template and declare MultiEdit regions as a comma separated list under Template Name
'<?php
/*
Template Name: CustomPage
MultiEdit: Right,Bottom,Left
*/
?>'

# Also in the custom page template, decide where to show the MultiEdit content '<?php multieditDisplay('Bottom'); ?>'
# Edit or Create a new WordPress Page, Select your custom template. Refresh the page.
# You will now see tabs above the TinyMCE that allow you to add content to the region block
# Save the page and preview your results.

== Changelog ==

= .9 =
* Ported from an old plugin we wrote: http://saint-rebel.com/2008/09/26/multiedit-region-wordpress-plugin/