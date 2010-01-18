=== aNobii WordPress Widget ===
Contributors: giacgbj
Tags: books, libri, anobii, anobi, widget, images, covers, cover, image, ajax
Requires at least: 2.0.2
Tested up to: 2.7.1
Stable tag: 1.1

aNobii WordPress Widget is a Wordpress widget which shows randomly the covers of some books from your aNobii's shelf.

== Description ==

**aNobii WordPress Widget** is a Wordpress widget which shows randomly the covers of some books from your aNobii's shelf.

Changelog:

1.1 - Now you can:
* choose the size of the covers (small, large or square)
* exclude books without covers
* choose the most recent books instead of only showing them randomly
* filtering the books by reading progress (all, reading, finished, reading+finished)

1.0 - It works on Internet Explorer 7!


== Installation ==

= What I need? =

Follow these simple instructions:

* You need to install the latest version of [WordPress](http://wordpress.org/ "WordPress")
* You need widget support (the latest version of Wordpress supports it natively; if you use an older version you can download the [Widgets plugin](http://automattic.com/code/widgets/ "Widgets plugin"))
* Obviously, you need an [aNobii](http://www.anobii.com/ "aNobii") account

= How can I install it? =

* You need to extract the content of the archive and to copy/move the inner directory "<em>anobii-wordpress-widget</em>" to the <strong>wp-content/plugins</strong> folder. Make sure that the path of the main php file is <strong>wp-content/plugins/anobii-wordpress-widget/aNobii.php</strong>.</p>

= And now? =

You have to configure the plugin following the instructions at the page "*Options->aNobii Plugin*".


== Frequently Asked Questions ==

= Why doesn't it show anything? =

Probably, you have to configure it under "*Options->aNobii Plugin*".

= I configured it! It doesn't work! =

Probably, you have specified a "customized" url in the preferences, such as [http://www.anobii.com/people/jhack](http://www.anobii.com/people/jhack "My Anobii Profile"): it will never work! You must retrieve your user-id from the Feed RSS url near to the bottom of your aNobii's Home Profile.

Therefore the url you must provide must be something like [http://www.anobii.com/people/010c51b082b89840a7](http://www.anobii.com/people/010c51b082b89840a7 "My Anobii Profile").

= The URL is correct now, but I can't see any cover

Check if the file "proxy.php" (and the directories which contain it) have the correct permissions. It depends on your host, so I can't say what are the best configurations. For me, 755 for the directories and 644 for "proxy.php", but on different hosts the latter one needs 755.

= What the hell?! It still doesn't work! =

I don't know what could be your problem. Please write a topic and I'll try to understand and correct your problem.



== Screenshots ==

1. aNobii WordPress Widget

