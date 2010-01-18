<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if IE]><link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" media="screen" /><![endif]-->
	
	<?php wp_head(); ?>
</head>

<body>

	<div id="header">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
                <h2><span><?php bloginfo('description'); ?></span></h2>

              <div id="nav">
		<ul>
			<li <?php if(!is_page()) echo 'class="current_page_item"'; ?>><a href="<?php echo get_option('home'); ?>/">Home</a></li>
			<?php wp_list_pages('title_li='); ?>
		</ul>
		
	      </div>
		
	</div>

	
	
	<div id="wrapper">