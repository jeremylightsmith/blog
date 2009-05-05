<?php get_header(); ?>

	<div id="content">
	
		<div id="content-left">

<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
	
			<div class="box-left" id="post-<?php the_ID(); ?>">
			
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<h4><?php the_time('l, F jS, Y'); ?> | <?php the_category(', '); ?></h4>
				
				<?php the_content(); ?>
				
				<?php the_tags('<p class="tags">Tags: ', ', ', '</p>'); ?>
			
			<div class="clear"></div></div>
			
			<?php comments_template(); ?>
		
		<?php endwhile; ?>
		
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