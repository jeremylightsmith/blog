<?php ob_start(); ?>
<?php header("HTTP/1.1 404 Not Found"); ?>
<?php header("Status: 404 Not Found"); ?>
<?php get_header(); ?>

<div id="content">
<div <?php post_class('page'); ?>>
<h2 class="post-title">Page Not Found</h2>

<p>Uh oh! I can't seem to find the file you asked for.</p>

<p>Perhaps you:</p>

<ul>
<li>tried to access a post or archive which has been removed</li>
<li>followed a bad link</li>
<li>mis-typed something</li>
</ul>

<p>Try using the main navigation menu to find what you're looking for.</p>

<p>Or you may just wish to return to the <a href="<?php bloginfo('url'); ?>/">Home page</a>.</p>

</div>

<?php get_footer(); ?>