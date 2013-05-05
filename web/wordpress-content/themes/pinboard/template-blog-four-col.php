<?php
/*
Template Name: Blog, Four Columns
*/
?><?php get_header(); ?>
	<?php global $pinboard_page_template; ?>
	<?php $pinboard_page_template = 'template-blog-four-col.php'; ?>
	<?php if( pinboard_get_option( 'location' ) ) : ?>
		<?php pinboard_current_location(); ?>
	<?php endif; ?>
	<div id="container">
		<section id="content" class="column onecol">
			<?php $args = array( 'posts_per_page' => get_option( 'posts_per_page' ), 'paged' => max( 1, get_query_var( 'paged' ) ) ); ?>
			<?php if( pinboard_get_option( 'blog_exclude_portfolio' ) ) : ?>
				<?php $args['cat'] = '-' . pinboard_get_option( 'portfolio_cat' ); ?>
			<?php endif; ?>
			<?php global $wp_query, $wp_the_query; ?>
			<?php $wp_query = new WP_Query( $args ); ?>
			<?php if( $wp_query->have_posts() ) : ?>
				<div class="entries">
					<?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</div><!-- .entries -->
				<?php pinboard_posts_nav(); ?>
			<?php else : ?>
				<?php pinboard_404(); ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			<?php $wp_query = $wp_the_query; ?>
		</section><!-- #content -->
		<div class="clear"></div>
	</div><!-- #container -->
<?php get_footer(); ?>