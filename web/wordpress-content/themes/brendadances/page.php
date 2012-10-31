<?php
/*
Template Name: Page with Comments
*/
?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?>>

<?php if (get_the_title() != "Home") : ?>
<h1 class="post-title" id="post-<?php the_ID(); ?>">
  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a>
  <?php edit_post_link('Edit','<span class="edit">','</span>'); ?>
</h1>
<?php endif; ?>

<div class="postcontent">
<?php the_content(); ?>
</div>

</div>

<?php endwhile; ?>

<?php  endif; ?>

<?php get_footer(); ?>