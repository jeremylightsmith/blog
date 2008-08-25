<?php get_header(); ?>

	<div id="content">
	
		<div id="content-left">
	
			<div class="box-left" id="post-<?php the_ID(); ?>">
			
				<h2>Not found!</h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
			</div>
	
	  </div><!-- end content-left -->
	  
	  <?php get_sidebar(); ?>
	  
	  <div class="clear"></div>
	
</div><!-- end content -->
	
<?php get_footer(); ?>