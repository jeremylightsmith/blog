<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="entry">
		<?php if( ( 'full-width' != pinboard_get_option( 'layout' ) && ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) || pinboard_is_teaser() ) : ?>
			<?php pinboard_post_thumbnail(); ?>
		<?php endif; ?>
		<div class="entry-container">
		<?php if( 'full-width' == pinboard_get_option( 'layout' ) || is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
				<header class="entry-header">
					<?php pinboard_entry_meta(); ?>
				</header><!-- .entry-header -->
			<?php endif; ?>
			<?php if( ( 'full-width' == pinboard_get_option( 'layout' ) || is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) && ! pinboard_is_teaser() ) : ?>
				<?php pinboard_post_thumbnail(); ?>
			<?php endif; ?>
			<?php if( ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) : ?>
				<div class="entry-summary">
					<?php pinboard_first_blockquote(); ?>
				</div><!-- .entry-summary -->
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .entry-container -->
		<?php if( 'full-width' != pinboard_get_option( 'layout' ) && ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
			<?php pinboard_entry_meta(); ?>
		<?php endif; ?>
	</div><!-- .entry -->
</article><!-- .post -->