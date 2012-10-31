<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/stylesheets/reset-min.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/stylesheets/superfish.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/stylesheets/layout.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/stylesheets/application.css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Great+Vibes|Ruthie|Arizonia' rel='stylesheet' type='text/css'>

<!--[if IE]> <style type="text/css">@import "<?php bloginfo('template_directory'); ?>/stylesheets/ie-overrides.css";</style> <![endif]-->

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src="<?php bloginfo('template_directory'); ?>/javascripts/jquery.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/javascripts/hoverIntent.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/javascripts/superfish.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/javascripts/jquery.flickr-1.0.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/javascripts/application.js" type="text/javascript"></script>

<title><?php if(is_search()) {
	if(wp_specialchars($s,1) != '' ) {_e('Search Results for - '); the_search_query();_e(' - on ');bloginfo('name');}
	else {bloginfo('name');_e(' - No search query entered!');}
}
elseif (is_category() || is_author()) {wp_title(':',true,'right'); bloginfo('name');}
elseif(is_tag()) {_e('Entries tagged with '); wp_title('',true);_e(' on '); bloginfo('name');}
elseif(is_archive() ) {_e('Archives for ');wp_title('',true,'right') ;_e(' on '); bloginfo('name');}
elseif(is_404()) {bloginfo('name'); _e(' - Page not found!');}
elseif (have_posts()) {wp_title(':',true,'right'); bloginfo('name');}
else {bloginfo('name');}?>
</title>

<?php wp_head(); ?>
</head>

<body id="top" <?php if (function_exists('body_class')) body_class(); ?>>
  <div class="header">
    <div class="content">
      <div class="logo">
        <img src="<?php bloginfo('template_directory'); ?>/images/text/brenda_dances.gif"/>
      </div>
      <div class="menu">
        <ul class="sf-menu">
          <li><a href="/">HOME</a></li>
          <li>
            
            <?php wp_list_pages(array('title_li' => '<a href="#b">MY EVENTS</a>', 'child_of' => 63)) ?>
<!--               <% next_events.each do |event| %>
                <li><%= link_to event.title, File.join("/", event.full_path) %></li>
              <% end %> -->
          </li>
          <li>
            <a href="#c">BOOK ME</a>
            <ul>
              <li><a href="/private-lessons">PRIVATE CLASSES</a></li>
              <li><a href="/book-an-event">EVENTS</a></li>
              <li><a href="/book-a-workshop">WORKSHOPS</a></li>
            </ul>
          </li>
          <li><a href="/calendar">CALENDAR</a></li>
          <li><a href="/about-me">ABOUT ME</a></li>
        </ul>
        <div style="clear:both"></div>
      </div>
    </div>

    <script type="text/javascript"> 
      $(function() {
        $('ul.sf-menu').superfish();
      });
    </script>

    <div class="knot">
      <img src="<?php bloginfo('template_directory'); ?>/images/top_knot.png"/>
    </div>
  </div>
  <div class="middle">
    <div class="center">
      <div class="content">
