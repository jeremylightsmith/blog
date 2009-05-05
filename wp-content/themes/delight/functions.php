<?php

// Widget Settings

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div id="%1$s" class="box-right">', 
	'after_widget' => '</div><div class="box-right-bottom"></div></div>', 
	'before_title' => '<h3>', 
	'after_title' => '</h3><div class="box-right-content">', 
	));
	
function widget_webdemar_search() {
?>
    	<div class="box-right">
		<h3>Search</h3>
			<div id="searchform">
				<form method="get" action="<?php bloginfo('url'); ?>/">
					<input type="text" value="search..." onfocus="if (this.value == 'search...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'search...';}" name="s" id="search" />
					<input type="submit" id="search-submit" name="submit" value="GO" />
				</form>
			</div>
			<div class="box-right-bottom"></div>
		</div>
	
<?php
}

if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_webdemar_search');

?>