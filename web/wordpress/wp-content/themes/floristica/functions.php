<?php
if ( function_exists('register_sidebars') )
 register_sidebars(2,array(
        'before_widget' => '<div class="box">',
    'after_widget' => '</div>',
 'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

function widget_aoe_search() {
?>
    	<div class="box">
		<h3>Search</h3>
			<form method="get" action="<?php bloginfo('url'); ?>/">
				<input type="text" value="" name="s" class="text" />
				<input type="submit" id="search-submit" class="button" value="Go!" />
			</form>
		</div>
	
<?php
}

function widget_aoe_tag_cloud($a) {
    $options = get_option('widget_tag_cloud');
    $title = empty($options['title']) ? __('Tags') : apply_filters('widget_title', $options['title']);
?>
	<div class="box">
	<h3><?php echo $title ?></h3>
		<div class="tags">
			<?php wp_tag_cloud();?>
		</div>
	</div>
<?php
}

if ( function_exists('register_sidebar_widget') ) {
    register_sidebar_widget(__('Search'), 'widget_aoe_search');
}

if ( function_exists('register_sidebar_widget') ) {
    register_sidebar_widget(__('tag_cloud'), 'widget_aoe_tag_cloud');
}