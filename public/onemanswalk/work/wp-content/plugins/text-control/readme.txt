=== Text Control ===
Tags: Post, Format, Formatting, Encoding
Contributors: chuyskywalker

Take complete control of text formatting options on your blog: Formatting and encoding per post, globally on posts, and globally on comments.

Text Control will allow you to choose from a variety of formatting syntaxes and encoding options. You can choose between Markdown, Textile 1, Textile 2, nl2br, WPautop, and "No Formatting" for formatting along with the choice of SmartyPants, WPTexturize or "No Encoding" for character encodings. 

== Installation ==

1. Download
2. Unzip and upload into wp-content/plugins/
3. Activate in the Plugins section of your admin panel

== Useage ==

When installed, this plugin will format text the exact same way that WordPress does by default.

You can define which text formatting engine to use by changing the values in the drop down menu on individual post pages.

Additionally, you can change the defaults on a blog-wide basis by changing the "Posts & Excerpts" options in "Your site Admin page >> Options >> Text Control Config".

Finally, you can set text processing for all comments as well. Set this up in the "Comments" options in "Your site Admin page >> Options >> Text Control Config".

== KNOWN ISSUES ==

 * Not really a bug so much, but an issue: Textile 2 is freaking huge (145k > 4000 lines of code) so it can be quite a burden on your server. If you can get away with *not* using it, I highly reccomend you do so.
 * Additionally, in Textile 2 there is a feature that would grab an image via PHP and get it's height and width for placing in the IMG tags. This has been disabled It literally took a post from 1 second to display straight to 6 seconds -- completely unacceptable. 

== ChangeLog ==

 * 2.0b Name changed from MTSpp to Text Control. Heavy updates!
 * 1.0.1 - Changed a variable so that this would actually work in places like, oh ya know, the index.php file (places where is_single would be false.)
 * 1.0 - Introduction 

== Screenshots ==

1. A shot of the configuration options that show up in your admin section allowing you to detup how the blog will parse entries and comments by default.

2. The mechanism for setting per-post formatting options.
