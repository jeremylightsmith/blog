<?php get_header(); ?>

	<div id="content">
	
		<?php while(have_posts()) : the_post(); ?>
		<div class="post page">
			<div class="title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div>
			
			<div class="text">
				<?php the_content(''); ?>
			</div>
			
		</div>
		<div class="divider"></div>
		<?php endwhile; ?>
	</div>

<?php get_footer(); ?>
