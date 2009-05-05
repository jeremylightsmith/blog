<div id="content-right">
		
		<div id="box-rss">
		
			<a href="<?php bloginfo('rss2_url'); ?>">Subscribe RSS Feed now</a>
		
		</div>

<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>

		<div class="box-right">

			<h3>Archive</h3>
			
			<div class="box-right-content">
		
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
			
			</div>
			
			<div class="box-right-bottom"></div>
		
		</div>

		<div class="box-right">
			
			<h3>Links</h3>
			
			<div class="box-right-content">
			
				<ul>
					<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
				</ul>
			
			</div>
			
			<div class="box-right-bottom"></div>
		
		</div>

		<div class="box-right">

			<h3>Meta</h3>
			
			<div class="box-right-content">
		
				<ul>
            		<?php wp_register(); ?>
			    	<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			
			</div>
			
			<div class="box-right-bottom"></div>
		
		</div>

		<div class="box-right">

			<h3>Search</h3>
			
			<div class="box-right-content">
		
		    	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		    
		    </div>
		    
		    <div class="box-right-bottom"></div>

		</div>

<?php endif; // endif widgets ?>
	  
</div><!-- end content-right -->