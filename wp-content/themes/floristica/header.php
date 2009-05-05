<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>
<!--[if IE ]>
<link type="text/css" rel="stylesheet" media="screen" href="<?php bloginfo('template_directory'); ?>/ie.css" />
<![endif]-->
</head>

<body>
    <div id="root">
        
        <div id="nav-search">
        
            <div id="nav">
                <ul>
                    <li><a href="<?php bloginfo('url'); ?>">Home</a></li>
                    <?php wp_list_pages('title_li=&depth=1'); ?>
                </ul>
            </div>
            
            <div id="search">
                <form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
    			    <input type="text" class="text" value="<?php the_search_query(); ?>" name="s" id="s" />&nbsp;<input type="submit" class="submit" value="Go!" />
    			</form>
            </div>
        
        </div>
        
        <?php get_sidebar(); ?>
        
    <div id="main">
        <div id="header">
    		<div class="search">
    			
    		</div>
    		<h1><a href="<?php bloginfo('home'); ?>"><?php bloginfo('name'); ?></a></h1>
            <div class="description"><?php bloginfo('description'); ?></div>
        </div>

