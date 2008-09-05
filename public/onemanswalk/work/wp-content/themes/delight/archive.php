<?php get_header(); ?>

	<div id="content">
	
		<div id="content-left">

<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		
		<?php /* If this is a category archive */ if (is_category()) { ?>
			<h3 class="archive-title"><?php single_cat_title(); ?></h3>
			
 	  	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			<h3 class="archive-title"><?php single_tag_title(); ?></h3>
			
 	  	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h3 class="archive-title">Archive for <?php the_time('F jS, Y'); ?></h3>
			
 	 	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h3 class="archive-title">Archive for <?php the_time('F, Y'); ?></h3>
			
 	  	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h3 class="archive-title">Archive for <?php the_time('Y'); ?></h3>
			
 	  	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h3 class="archive-title">Blog Archives</h3>
			
 	  	<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
	
			<div class="box-left" id="post-<?php the_ID(); ?>">
			
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<h4><?php the_time('l, F jS, Y'); ?> | <?php the_category(', '); ?> | <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></h4>
				
				<?php the_content(__('&rsaquo; Continue reading')); ?>
				
				<?php the_tags('<p class="tags">Tags: ', ', ', '</p>'); ?>
			
			<div class="clear"></div></div>
		
		<?php endwhile; ?>

		<div class="box-left navigation">
		
        	<?php next_posts_link('&laquo; Previous Entries') ?> <?php previous_posts_link('Next Entries &raquo;') ?>
        	
		</div>
		
		<?php else : ?>

		<div class="box-left">

			<h2>Not found!</h2>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
		</div>

<?php endif; ?>
	
	  </div><!-- end content-left -->
	  
	  <?php get_sidebar(); ?>
	  
	  <div class="clear"></div>
	
</div><!-- end content -->
	
<?php get_footer(); ?>