<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="content">
<?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>

<div class="post">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<div class="contenttext">
<?php the_content('Read more &raquo;'); ?>
</div>

<p class="postinfo"><strong>Posted:</strong> <?php the_time('F jS, Y') ?> under <?php the_category(', ') ?>.<br />
<?php the_tags('Tags: ', ', ', '<br />'); ?>
<a href="<?php comments_link(); ?>"><strong>Comments:</strong> <?php comments_number('none','1','%'); ?></a>
<?php edit_post_link('[e]',' | ',''); ?></p>
</div>
	
<?php endwhile; ?>

<div class="navigation">
<p><span class="prevlink"><?php next_posts_link('&laquo; Previous entries') ?></span>
<span class="nextlink"><?php previous_posts_link('Next entries &raquo;') ?></span></p>
</div>
		
<?php else : ?>
<h2>Not found!</h2>
<p>Could not find the requested page. Use the navigation menu to find your target, or use the search box below:</p>
<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>

</div>
<?php get_footer(); ?>