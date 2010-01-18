<?php
/**
 * @package WordPress
 * @subpackage Lighthouse_Theme
 */

/*
Template Name: Home
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/home.css" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

</head>
<body class="home">
  <div class="fixed">
    <img class="big-logo" src="<?php bloginfo('stylesheet_directory'); ?>/images/big_logo.png"></img>
    <img class="coming-soon" src="<?php bloginfo('stylesheet_directory'); ?>/images/coming_fall_2011.png"></img>
    <div class="content">
      <div class="menu">
        <a href="/">Home</a>
        <a href="/">About Us</a>
        <a href="/">Programs</a>
        <a href="/">Admissions</a>
        <a href="/blog">Blog</a>
        <a href="/contact_us">Contact Us</a>
      </div>
      <div class="about-us">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content(''); ?>
        <?php endwhile; endif; ?>
        <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
      </div>
      <div class="footer">
        <a href="mailto:lighthouse.montessori@gmail.com">lighthouse.montessori@gmail.com</a> <span class="sep">|</span>
        <span class="phone">206-201-1730</span> <span class="sep">|</span>
        <span class="address">Shoreline, WA</span>
      </div>
    </div>
  </div>
</body>
</html>