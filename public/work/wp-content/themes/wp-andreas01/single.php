<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="post">
<h2><?php the_title(); ?></h2>

<div class="contenttext">
<?php the_content('<p>Read more &raquo;</p>'); ?>
</div>

<?php link_pages('<p><strong>Pages:<strong> ', '</p>', 'number'); ?>
<p class="postinfo"><strong>Posted:</strong> <?php the_time('F jS, Y') ?> under <?php the_category(', ') ?>.<br />
<?php the_tags('Tags: ', ', ',''); ?><?php edit_post_link('[e]',' | ',''); ?></p>

<div class="navigation">
<p><span class="prevlink"><?php previous_post_link('&laquo; %link','Previous post',''); ?></span>
<span class="nextlink"><?php next_post_link('%link &raquo;','Next post',''); ?></span></p>
</div>

<?php comments_template(); ?>

<?php endwhile; else: ?>
<p>No matching entries found.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>