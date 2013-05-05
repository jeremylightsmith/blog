<?php if( is_active_sidebar( 3 ) ) : ?>
	<div class="column twocol">
		<div id="sidebar-left" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 3 ) ; ?>
		</div><!-- #sidebar-left -->
	</div><!-- .twocol -->
<?php endif; ?>