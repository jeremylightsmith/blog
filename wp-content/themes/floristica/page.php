<?php get_header(); ?>
<div id="content">
<?php if (have_posts()) : ?>
    <ul>
	<?php while (have_posts()) : the_post(); ?>
		<li class="post" id="post-<?php the_ID(); ?>">
            <div class="title">
        	    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
            </div>
    		<div class="entry">
    		    <?php the_content('<span>Read more &raquo;</span>'); ?>
    		</div>
		</li>
	<?php endwhile; ?>
    </ul>
	<?php else : ?>
        <p>&nbsp;</p>
		<h2 class="t-center">Not Found</h2>
		<p class="t-center">Sorry, but you are looking for something that isn't here.</p>
	<?php endif; ?>
    <span class="footer"></span>
    </div>
<?php get_footer(); ?>













