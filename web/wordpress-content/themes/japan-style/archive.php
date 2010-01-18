<?php get_header(); ?>

	<div id="content">

		<?php if (have_posts()) : ?>
			<div class="post post-list">
			
			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<?php /* If this is a category archive */ if (is_category()) { ?>
			<h1>Archive for the <span><?php single_cat_title(); ?></span> Category</h1>
			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			<h1>Posts Tagged <span><?php single_tag_title(); ?></span> </h1>
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h1>Archive for <span><?php the_time('F jS, Y'); ?></span></h1>
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h1>Archive for <span><?php the_time('F, Y'); ?></span></h1>
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h1>Archive for <span><?php the_time('Y'); ?></span></h1>
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h1>Author Archive</h1>
			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h1>Blog Archives</h1>
			<?php } ?>
			
				<ul>
				<?php while (have_posts()) : the_post(); ?>

						<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> - <?php the_time('F jS, Y') ?></li>

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
