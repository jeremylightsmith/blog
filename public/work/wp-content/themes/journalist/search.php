<?php get_header(); ?>

<div id="content" class="group">
<?php if (have_posts()) : ?>

<h2 class="archive">Search Results</h2>

<?php while (have_posts()) : the_post(); ?>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p class="comments"><a href="<?php comments_link(); ?>"><?php comments_number('without comments','with one comment','with % comments'); ?></a></p>

<div class="main">
	<?php the_content('Read the rest of this entry &raquo;'); ?>
</div>

<div class="meta group">
<div class="signature">
    <p>Written by <?php the_author() ?> <span class="edit"><?php edit_post_link('Edit'); ?></span></p>
    <p><?php the_time('F jS, Y'); ?> <?php _e("at"); ?> <?php the_time('g:i a'); ?></p>
</div>	
<div class="tags">
    <p>Posted in <?php the_category(',') ?></p>
    <?php if ( the_tags('<p>Tagged with ', ', ', '</p>') ) ?>
</div>
</div>

<?php if ( comments_open() ) comments_template(); ?>

<?php endwhile; ?>
<div class="navigation">
	<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
	<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
</div>
<?php else : ?>
	<h2>No posts found.</h2>
	<div class="warning">
		<p>Apologies, but we were unable to find what you were looking for. Try a different search?</p>
	</div>
<?php endif; ?>

</div> 

<?php get_sidebar(); ?>

<?php get_footer(); ?>
