<?php get_header(); ?>
	<div id="container">
		<section id="content" class="column twothirdcol">
			<?php if( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="entry">
						<header class="entry-header">
							<<?php pinboard_title_tag( 'post' ); ?> class="entry-title"><?php the_title(); ?></<?php pinboard_title_tag( 'post' ); ?>>
							<?php pinboard_entry_meta(); ?>
						</header><!-- .entry-header -->
						<div class="entry-content">
							<figure class="entry-attachment">
								<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
									<?php _e( 'Download', 'pinboard' ); ?>
								</a>
								<?php if ( ! empty( $post->post_excerpt ) ) : ?>
									<figcaption class="entry-caption">
										<?php the_excerpt(); ?>
									</figcaption><!-- .entry-caption -->
								<?php endif; ?>
							</figure><!-- .entry-attachment -->
							<?php the_content(); ?>
							<div class="clear"></div>
						</div><!-- .entry-content -->
						<footer class="entry-utility">
							<?php wp_link_pages( array( 'before' => '<p class="post-pagination">' . __( 'Pages:', 'pinboard' ), 'after' => '</p>' ) ); ?>
							<?php pinboard_social_bookmarks(); ?>
						</footer><!-- .entry-utility -->
					</div><!-- .entry -->
					<?php comments_template(); ?>
				</article><!-- .post -->
			<?php else : ?>
				<?php pinboard_404(); ?>
			<?php endif; ?>
		</section><!-- #content -->
		<?php if( ( 'no-sidebars' != pinboard_get_option( 'layout' ) ) && ( 'full-width' != pinboard_get_option( 'layout' ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div><!-- #container -->
<?php get_footer(); ?>