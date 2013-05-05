<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>/" >
	<input type="text" value="" placeholder="<?php esc_attr_e( 'Search this website', 'pinboard' ); ?>&#8230;" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'pinboard' ); ?>" />
</form>