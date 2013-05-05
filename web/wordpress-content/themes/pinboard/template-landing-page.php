<?php
/*
Template Name: Landing Page
*/
?><?php get_header(); ?>
	<?php if( pinboard_get_option( 'slider' ) ) : ?>
		<?php get_template_part( 'slider' ); ?>
	<?php endif; ?>
	<?php get_sidebar( 'wide' ); ?>
	<?php get_sidebar( 'boxes' ); ?>
	<div id="container">
		<section id="content" class="column onecol">
			<?php if( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="entry">
						<header class="entry-header">
							<<?php pinboard_title_tag( 'post' ); ?> class="entry-title"><?php the_title(); ?></<?php pinboard_title_tag( 'post' ); ?>>
						</header><!-- .entry-header -->
						<div class="entry-content">
							<?php the_content(); ?>
							<div class="clear"></div>
						</div><!-- .entry-content -->
						<?php wp_link_pages( array( 'before' => '<footer class="entry-utility"><p class="post-pagination">' . __( 'Pages:', 'pinboard' ), 'after' => '</p></footer><!-- .entry-utility -->' ) ); ?>
					</div><!-- .entry -->
					<?php comments_template(); ?>
				</article><!-- .post -->
			<?php else : ?>
				<?php pinboard_404(); ?>
			<?php endif; ?>
		</section><!-- #content -->
		<div class="clear"></div>
	</div><!-- #container -->
<?php get_footer(); ?>