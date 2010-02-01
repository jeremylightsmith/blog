<?php
/*
Template Name: Page with Comments
*/
?>
<?php get_header(); ?>

<div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?>>

<h2 class="post-title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<ul class="meta">
<li><?php edit_post_link('Edit','<span class="edit">','</span>'); ?></li>
</ul>

<div class="postcontent">
<?php the_content(); ?>
</div>

<?php wp_link_pages('before=<div class="pagelist">Pages:&after=</div>&link_before=&link_after=&pagelink=%');?>

</div>

<?php if( have_comments() || 'open' == $post->comment_status ) : ?>
<?php comments_template();?>
<?php endif;?>

<?php endwhile; ?>

<?php  endif; ?>

<?php get_footer(); ?>