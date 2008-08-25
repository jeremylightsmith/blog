<div id="content-right">
		
		<?php
		
			if($post->post_parent)
			$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0"); else
			$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
			if ($children) { ?>

			<div class="box-right">
				
				<h4>Sub-Pages</h4>
			
				<ul>
					<?php echo $children; ?>
				</ul>
			
       		</div>
			
		<?php } ?>

<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
		
		<div class="box-right">
		
			<h4>Categories</h4>
		
			<ul>
				<?php wp_list_categories('title_li='); ?>
			</ul>
		
		</div>

		<div class="box-right">

			<h4>Archive</h4>
		
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		
		</div>

		<div class="box-right">
			
			<h4>Links</h4>
			
			<ul>
				<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
			</ul>
		
		</div>

		<div class="box-right">

			<h4>Meta</h4>
		
			<ul>
            	<?php wp_register(); ?>
			    <li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		
		</div>

		<div class="box-right">

			<h4>Search</h4>
		
		    <?php include (TEMPLATEPATH . '/searchform.php'); ?>

		</div>

<?php endif; // endif widgets ?>
	  
</div><!-- end content-right -->