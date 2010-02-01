<?php get_header(); ?>

<div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class();?>id="post-<?php the_ID();?>">

<h2 class="post-title"><?php the_title(); ?></h2>

<ul class="meta">
<li><?php the_time("F j, Y"); ?> <?php the_time(); ?></li>
<li><?php edit_post_link('Edit'); ?></li>
</ul>

<div class="postcontent">
<?php the_content(); ?>
</div>

<?php wp_link_pages('before=<div class="pagelist">Pages:&after=</div>&link_before=&link_after=&pagelink=%');?>

<ul class="meta postfoot">
<li>Author: <?php the_author_posts_link(); ?></li>
<li>Filed under: <ul><li><?php the_category(',</li> <li>') ?></li></ul></li>
<?php if(get_the_tag_list()) :?>
<li>Tags: <?php the_tags('<ul><li>',',</li> <li>','</li></ul>');?></li>
<?php endif;?>
</ul>

</div>
<?php comments_template();?>

<?php endwhile; ?>

<?php  endif; ?>

<?php get_footer(); ?>
