<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="content">

	<?php query_posts("showposts=1000"); ?>
	<?php if (have_posts()) : ?>

		<h1>Blog Archives</h1>

		<div class="post post-list">
			<ul>
			<?php while (have_posts()) : the_post(); ?>

					<li><?php the_time('F jS, Y') ?> - <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>

			<?php endwhile; ?>
			</ul>
		</div>

		<div id="pages">
			<a href="#"><?php next_posts_link('&larr;Older') ?></a>&nbsp;&nbsp;&nbsp;<a href="#"><?php previous_posts_link('Newer&rarr;') ?></a>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>

	<?php endif; ?>

</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
