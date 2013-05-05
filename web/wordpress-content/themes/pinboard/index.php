<?php get_header(); ?>
	<?php if( is_home() && ! is_paged() ) : ?>
		<?php if( pinboard_get_option( 'slider' ) ) : ?>
			<?php get_template_part( 'slider' ); ?>
		<?php endif; ?>
		<?php get_sidebar( 'wide' ); ?>
		<?php get_sidebar( 'boxes' ); ?>
	<?php elseif( ( is_home() && is_paged() ) || ( ! is_home() && pinboard_get_option( 'location' ) ) ) : ?>
		<?php pinboard_current_location(); ?>
	<?php endif; ?>
	<div id="container">
		<section id="content" <?php pinboard_content_class(); ?>>
			<?php if( is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
				<?php pinboard_category_filter( pinboard_get_option( 'portfolio_cat' ) ); ?>
			<?php endif; ?>
			<?php if( have_posts() ) : ?>
				<div class="entries">
					<?php while( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</div><!-- .entries -->
				<?php pinboard_posts_nav(); ?>
			<?php else : ?>
				<?php pinboard_404(); ?>
			<?php endif; ?>
		</section><!-- #content -->
		<?php if( 'no-sidebars' != pinboard_get_option( 'layout' ) && 'full-width' != pinboard_get_option( 'layout' ) && ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div class="clear"></div>
	</div><!-- #container -->
<?php get_footer(); ?>