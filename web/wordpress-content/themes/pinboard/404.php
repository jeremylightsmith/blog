<?php get_header(); ?>
	<div id="container">
		<section id="content" <?php pinboard_content_class(); ?>>
			<div class="entry">
				<?php pinboard_404(); ?>
			</div><!-- .entry -->
		</section><!-- #content -->
		<?php if( ( 'no-sidebars' != pinboard_get_option( 'layout' ) ) && ( 'full-width' != pinboard_get_option( 'layout' ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div><!-- #container -->
<?php get_footer(); ?>