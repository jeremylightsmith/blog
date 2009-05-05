<?php get_header(); ?>

<div id="content">

	<div id="content-left">

<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
	
			<div class="box-left" id="post-<?php the_ID(); ?>">
			
				<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<div class="meta">
					<span class="meta-date"><?php the_time('l, F jS, Y'); ?></span> | 
					<span class="meta-categories"><?php the_category(', '); ?></span> | 
					<span class="meta-comments"><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></span>
				</div>
				
				<?php the_content(__('&rsaquo; Continue reading')); ?>
				
				<?php the_tags('<p class="tags">', ', ', '</p>'); ?>
				
				<div class="clear"></div></div>
		
		<?php endwhile; ?>
		
		<div class="box-left navigation">
		
        	<?php next_posts_link('&laquo; Previous Entries') ?> <?php previous_posts_link('Next Entries &raquo;') ?>
        	
		</div>
		
		<?php else : ?>

		<h3>Not found!</h3>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

<?php endif; ?>
	
	  </div><!-- end content-left -->
	  
	  <?php get_sidebar(); ?>
	  
	  <div class="clear"></div>
	
</div><!-- end content -->
	
<?php get_footer(); ?>