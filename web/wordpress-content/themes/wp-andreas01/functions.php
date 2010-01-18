<?php

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Right Sidebar',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

// WP-Andreas01 Page Navigation 	
	function widget_andreas01_pagenav() {
?>
<h2 class="hide">Site menu:</h2>
<ul class="page">
<?php if (is_page()) { $highlight = "page_item"; } else {$highlight = "page_item current_page_item"; } ?>
<li class="<?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>">Home</a></li>
<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
</ul>
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Pages'), 'widget_andreas01_pagenav');

// WP-Andreas01 Search 	
	function widget_andreas01_search() {
?>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_andreas01_search');

// WP-Andreas01 Links 	
	function widget_andreas01_links() {
?>
<h2>Links:</h2>
<ul class="menulist">
<?php get_links_list(); ?>
</ul>
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Links'), 'widget_andreas01_links');	 

// List Subpages - Code from a plugin by Rob Miller (http://robm.me.uk/). Thanks Rob!
function list_subpages_andreas01($return = 0) {
global $wpdb, $post;
$current_page = $post->ID;
while($current_page) {
$page_query = $wpdb->get_row("SELECT ID, post_title, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
$current_page = $page_query->post_parent; }
$parent_id = $page_query->ID;
$parent_title = $page_query->post_title;
if($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' and post_type = 'page' AND post_status = 'publish' ")) {
echo'<div id="subpages"><h2>Subpages for '; echo $parent_title; echo':</h2> <ul class="submenu">';
$html = wp_list_pages("child_of=$parent_id&depth=$depth&echo=".(!$return)."&title_li=0&sort_column=menu_order");
echo'</ul></div>'; } 
if($return) {
return $html;
} else {
echo $html; } } 
?>