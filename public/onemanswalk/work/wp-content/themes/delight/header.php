<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="robots" content="index,follow" />
<meta http-equiv="Content-Language" content="de" />
<meta name="author" content="webdemar" />
<meta name="copyright" content="Copyright © 2008 webdemar, All Rights Reserved" />
<meta name="revisit-after" content="7 Days" />

<title>
		<?php if ( is_home() ) { ?><?php bloginfo('description'); ?> | <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_search() ) { ?><?php echo $s; ?> | <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_single() ) { ?><?php wp_title(''); ?> | <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_page() ) { ?><?php wp_title(''); ?> | <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_category() ) { ?>Archive <?php single_cat_title(); ?> | <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_month() ) { ?>Archive <?php the_time('F'); ?> | <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_tag() ) { ?><?php single_tag_title();?> | <?php bloginfo('name'); ?><?php } ?>
</title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

</head>

<body>

<div id="header">

	<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	<h2><?php bloginfo('description'); ?></h2>

</div><!-- end header -->

<ul id="menu">
	<li class="page_item"><a href="/">home</a></li>
	<li class="page_item current_page_item"><a href="/work">work</a></li>
	<li class="page_item"><a href="/life">life</a></li>
	<li class="page_item"><a href="http://flickr.com/photos/onemanswalk/collections">pictures</a></li>
	<li class="page_item"><a href="http://facilitationpatterns.org/">facilitation patterns</a></li>
</ul><div class="clear"></div>