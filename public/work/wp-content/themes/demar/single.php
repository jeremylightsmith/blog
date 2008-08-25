<?php get_header(); ?>

	<div id="content">
	
		<div id="content-left">

<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
	
			<div class="box-left" id="post-<?php the_ID(); ?>">
			
				<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<div class="meta">
					<span class="meta-date"><?php the_time('l, F jS, Y'); ?></span> | 
					<span class="meta-categories"><?php the_category(', '); ?></span>
				</div>
				
				<?php the_content(); ?>
				
				<?php the_tags('<p class="tags">Tags: ', ', ', '</p>'); ?>
			
			<div class="clear"></div></div>
			
			<?php comments_template(); ?>
		
		<?php endwhile; ?>
		
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