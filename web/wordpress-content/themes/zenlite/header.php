<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/1">
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />

<meta name="designer" content="esmi@quirm.net" />

<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/print.css" media="print" />

<!--[if IE]>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/ie.css" media="screen" type="text/css" />
<![endif]-->
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/ie7.css" media="screen" type="text/css" />
<script src="<?php bloginfo('template_directory'); ?>/focus.js" type="text/javascript"></script>
<![endif]-->

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_get_archives('type=monthly&format=link'); ?>

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

<?php if(is_singular()) wp_enqueue_script( 'comment-reply' );?>
<?php wp_head(); ?>
</head>

<body id="top" <?php if (function_exists('body_class')) body_class(); ?>>

<div id="wrapper">

<div id="header">
  <table class="header" cellspacing="20px">
    <tr><td colspan="6" class="title"><img src="<?php bloginfo('template_directory'); ?>/images/title_logo.png"></td></tr>
    <tr class="nav">
      <td class="nav-link"><a href="/">Home</a></td>
      <td class="nav-link"><a href="/services">Services</a></td>
      <td class="nav-link"><a href="/get-a-bid">Get&nbsp;a&nbsp;Bid</a></td>
      <td class="nav-link"><a href="/referrals">Referrals</a></td>
      <td class="nav-link"><a href="/contact-us">Contact&nbsp;Us</a></td>
      <td class="motto">quality building &amp; remodeling</td>
    </tr>
    <tr><td colspan="6" class="header-image"></td></tr>
  </table>
</div>

