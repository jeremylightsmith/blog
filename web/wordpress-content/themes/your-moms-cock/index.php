<?php get_header(); ?>

	<div id="content">
	
		<?php while(have_posts()) : the_post(); ?>
		<div class="post">
			<div class="title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div>
			
			<div class="info">
				<ul>
					<li><?php the_time('F dS, Y') ?></li>
					<li><?php the_category(', '); ?></li>
					<li><?php the_tags(); ?></li>
					<li><?php comments_popup_link(); ?></li>
					<li><em><?php the_author(); ?></em></li>
				</ul>
			</div>
			
			<div class="text">
				<?php the_content(''); ?>
			</div>
			
		</div>
		<div class="divider"></div>
		<?php endwhile; ?>
	</div>

<?php get_footer(); ?>
