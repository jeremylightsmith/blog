=== Pinboard ===
Contributors: Daniel Tara
Tags: blue, brown, gray, green, tan, white,
light, one-column, two-columns, three-columns, four-columns,
left-sidebar, right-sidebar, fixed-width, flexible-width,
custom-background, custom-colors, custom-header, custom-menu,
editor-style, featured-images, full-width-template, microformats,
post-formats, sticky-post, theme-options, threaded-comments, translation-ready
Requires at least: 3.5
Tested up to: 3.5.1
Stable tag: 1.0.7

Description: A crafty and elegant theme powered by an advanced theme framework and grid system. With virtually unlimited layout options and styles, ideal for showcasing your portfolio of works or other multimedia elements like images, photo galleries, videos and podcasts.

== Description ==

A crafty and elegant theme powered by an advanced theme framework and grid system.
With virtually unlimited layout options and styles,
ideal for showcasing your portfolio of works or other multimedia elements
like images, photo galleries, videos and podcasts.


== Installation ==

Manual installation:

1. Upload the `pinboard` folder to the `/wp-content/themes/` directory

Installation using "Add New Theme"

1. From your Admin UI (Dashboard), use the menu to select Themes -> Add New
2. Search for 'pinboard'
3. Click the 'Install' button to open the theme's repository listing
4. Click the 'Install' button

Activiation and Use

1. Activate the Theme through the 'Themes' menu in WordPress
2. See Appearance -> Theme Options to change theme specific options

== License ==

Unless otherwise specified, all the theme files, scripts and images
are licensed under GNU General Public Licemse version 2, see file license.txt.
The exceptions to this license are as follows:
* The script colorbox.js is licensed under MIT
* The script html5.js is licensed under MIT
* The script fitvids.js is licensed under WTFPL
* The script jquery.infinitescroll.js is dual licensed under GPL & MIT
* The script jquery.masonry.min.js is licensed under MIT
* The script mediaelement.js is licensed under MIT
* The script mediaelementplayer.js is licensed under MIT
* The image bg.jpg is free for personal and commercial use. Reference: http://comments.deviantart.com/1/59069393/679276021
* The social media icons are the theme's author personal creations and are free for personal and commercial use
* The MediaElement.js skin is designed by Premium Pixels and coded by One Designs and is free for personal and commercial use.
* The AJAX loaders are free for personal and commercial use courtesy of http://preloaders.net/


== Theme Notes ==

=== Featured Post Slider ===

The slider handles sticky posts as featured. If the slider option is enabled
sticky posts will be displayed in the slider and the main loop will ignore them.
If the option is disabled the loop will display normally, with sticky posts on top.

=== Portfolio Section ===

The theme allows setting a category as portfolio. The portfolio page displays only
the post's attached media (images, galleries, videos, sound files) and post titles.
Post content and meta are not displayed. Additionally, posts in the portfolio category
display all of the post's custom fields that are not hidden.
The portfolio section is completely optional and turned off by default.

=== Post Thumbnail Functionality ===

Post Thumbnails appear only in post lists, not on single posts.
They can be set by choosing "Set as Featured Image" when uploading an image.

=== Audio & Video Post Formats ===

Posts with the audio & video post format will display the attached media files
in a HTML5 <audio> tag with flash fallback.
If more than one media file is attached to the post,
then these will be used as fallback sources.

=== Other Post Formats ===

Posts with the aside, status & quote post formats will displayed with no title;
the status post format will display the user's avatar, in a manner similar to Twitter;
the quote post format will only display the post's first <blockquote> tag.
Posts with the link post format will link out to the first <a> tag in the post.

=== Widgets Areas ===

The Theme has 4 customizable sidebars, a widget area in the footer and one on the 404 page.
Additionally the theme has 3 sidebars that display only on the home page and pages using the Landing Page template.
You can use these area to customize the content of your website.
If no content is be added to the sidebars these will not display.

=== Custom Header and Background ===

You need at least WordPress 3.4 to use the custom header and background functionality.
The API for adding this functionality has changed since this version and the old method is not supported.

== Frequently Asked Questions ==

= How do I add descriptions to menu items? =

Under Appearance > Menus, open the menu item and enter the description in the title tag.
It will appear below the menu item name in the navigation bar.

= How do I add thumbnails to posts? =

When editing a post, open the upload tool, select the image you wish to set as thumbnail
and select "Use as Featured Image". Note that thumbnails appear only in blog post lists.
To display then in single posts you need to insert them manually.

= How do I add posts to the slider? =

The slider displays sticky posts as featured. Mark the posts you wish to add to the slider as sticky
and they will be added automatically. Note that this mode disables the normal post order with sticky posts on top
and sticky posts will appear only in the slider.

= The slider is disproportioned =

You need to set a featured image of at least 1140x395 for the slider's proportions to align.
The slider cannot be given fixed proportions for compatibility with the responsive layout.

= It doesn't look good in Opera browser on smaller screens =

Opera browser doesn't (yet) support decimans in percentage dimensions,
hence support for responsive layouts is only limited.

= Some content is not properly aligned =

Because of the responsive nature of the layout it is not possible to make all types of content
fit in all possible dimensions. The layout has been optimized to format the content well on
most popular desktop and mobile resolutions. If your have a device that does not display them properly
please let us know and we will try to fix it.

= Why does the header widget area have fixed dimensions? =

The header widget area is intended exclusively for displaying ads.
The dimensions are those of standard header ad sizes.

= My media files won't play =

It may be that the server doesn't recognize the media types.
You'll have to register their MIME types.
Add this to your .htaccess file:

AddType audio/ogg .ogg
AddType audio/mpeg .mp3
AddType video/ogg .ogv
AddType video/webm .webm
AddType video/mp4 .mp4
AddType video/x-m4v .m4v

= I can't upload large files =

This is a limitation from your hosting provider.
Try adding the following to your .htaccess file:

php_value upload_max_filesize 128M
php_value max_execution_time 800
php_value post_max_size 128M
php_value max_input_time 800
php_value memory_limit 128M

128M is the maximum file size.
64M should be enough if you're uploading Video
and 16M if you're uploading Audio.

= I don't want to go through all this, isn't there an easier way that just works? =

The simplest way to accomplish this is to add just a FLV video or an MP3 audio.
They should be handled by the flash players and servers should recognize their type.
But you're missing on all the HTML5 goodies.

= I uploaded more media files, but I only see one =

Post formats are designed so only one media file is shown.
The other detected files are used as fallback sources for the first one.
If you would like to embed more media, a plugin may be more helpful.

== Support ==

You can use this support forum, for any support questions:
http://www.onedesigns.com/support/forum/theme-support/pinboard

== Additional Notes ==

The theme is released for free under the terms of the GNU General Public License version 2
and some parts under their respective licenses.
In general words, feel free and encouraged to use, modify and redistribute this theme however you like.
You may remove any copyright references (unless required by third party components) and crediting is not necessary.
The theme is offered free of charge. If someone asked money for it, someone just tricked you.

== Changelog ==

= 1.0.7 =

* Fixed header image stretching full width
* Fixed title of first slide not displaying
* Theme option not present in database returns default value
* Enabled header image flexible height
* Updated color picker to WP Color Picker
* Enabled post thumbnails for all post types
* Made layout borders blend into custom color scheme
* Added background color option for submenus
* Changed default layout when sidebar is inactive from no-sidebars to full-width
* Added compatibility code for jQuery 1.9

= 1.0.6 =

* Slider now displays on blog page and landing page template
* Navigation menu now has solid color background
* Added descriptions to sidebars
* Added HiDPI screenshot
* All images are now HiDPI and Retina Display compatible
* Added support for HiDPI header images
* Added options to customize theme colors
* Removed focus outline from input elements
* Theme options are sanitized on output
* Fixed one column posts on blog, full width template
* Fixed floated elements not clearing on 404 pages
* Fixed non-page menu items not highlighting when current
* Fixed custom fonts not working for some classes

= 1.0.5 =

* Fixed <title> tag not displaying properly
* Fixed certain layouts not rendering correctly
* Added YouTube and Pinterest social media icons

= 1.0.4 =

* Fixed nav icon position position on iPhone devices
* Fixed rendering on iPads in landscape mode

= 1.0.3 =

* Fixed wide logo image overflowing header.
* Added bottom margin to header widget to increase space from navigation when it is pushed down by site title.

= 1.0.2 =
* Fixed invalid CSS error
* Replaced get_bloginfo( 'stylesheet_url' ) with get_stylesheet_uri()
* Placed html5shiv script in a callback
* Provided non-minified versions of scripts

= 1.0 =
* Initial Release