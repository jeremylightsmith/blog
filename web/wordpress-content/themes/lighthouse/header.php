<?php
/**
 * @package WordPress
 * @subpackage Lighthouse_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen">

<?php
// Checks to see whether it needs a sidebar or not
if ( empty($withcomments) && !is_single() ) {
?>
  #page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbg-<?php bloginfo('text_direction'); ?>.jpg") repeat-y top; border: none; }
<?php } else { // No sidebar ?>
  #page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbgwide.jpg") repeat-y top; border: none; }
<?php } ?>

</style>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="fixed">
  <div class="header">
    <img class="small-logo" src="<?php bloginfo('stylesheet_directory'); ?>/images/small_logo.png"></img>
    <img class="coming-soon" src="<?php bloginfo('stylesheet_directory'); ?>/images/coming_fall_2011.png"></img>
    <div class="menu">
      <a href="/">Home</a>
      <a href="/">About Us</a>
      <a href="/">Programs</a>
      <a href="/">Admissions</a>
      <a href="/blog">Blog</a>
      <a href="/contact_us">Contact Us</a>
    </div>
  </div>

  <div class="content">
    <div class="banner">
      <!-- <h1>Blog</h1> -->
      <img src="<?php bloginfo('stylesheet_directory'); ?>/images/stock/stock<?php echo rand(1, 8) ?>.jpg"></img>
      <div class="overlay"><div class="focus">we nurture the love of learning &amp; compassion in every child</div></div>
    </div>
