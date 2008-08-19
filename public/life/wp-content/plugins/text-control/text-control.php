<?php
/*
Plugin Name: Text Control
Plugin URI: http://dev.wp-plugins.org/wiki/TextControl
Description: Take total control of how your blog formats text: Textile 1+2, Markdown, AutoP, nl2br, SmartyPant, and Texturize. Blog wide, individual posts, and defaults for comments.
Author: Jeff Minard
Version: 2.0b1
Author URI: http://thecodepro.com/
*/ 

// Hey!
// Get outta here! All configuration is done in WordPress
// Check the "options > Text Control Config" in your admin section

function tc_post($text) {
	global $id;
	
	/* Start with the default values */
	$do_text = get_option('tc_post_format');
	$do_char = get_option('tc_post_encoding');
	
	/* Now for the updated format that will take precedence */
	if ( get_post_meta($id, '_tc_post_format', true) ) {
		$do_text = get_post_meta($id, '_tc_post_format', true);
	}
	if( get_post_meta($id, '_tc_post_encoding', true) ) {
		$do_char =  get_post_meta($id, '_tc_post_encoding', true);
	}
	
	$text = tc_post_process($text, $do_text, $do_char);
	
	return $text;
}

function tc_comment($text) {
	
	$do_text = get_option('tc_comment_format');
	$do_char = get_option('tc_comment_encoding');
	
	$text = tc_post_process($text, $do_text, $do_char);
	
	return $text;
}

function tc_post_process($text, $do_text='', $do_char='') {
	
	if($do_text == 'textile2') {
		require_once('text-control/textile2.php');
		$t = new Textile();
		$text = $t->process($text);
		
	} else if($do_text == 'textile1') {
		require_once('text-control/textile1.php');
		$text = textile($text);
		
	} else if($do_text == 'markdown') {
		require_once('text-control/markdown.php');
		$text = Markdown($text);
		
	} else if($do_text == 'wpautop') {
		$text = wpautop($text);
		
	} else if($do_text == 'nl2br') {
		$text = nl2br($text);
		
	} else if($do_text == 'none') {
		$text = $text;
		
	} else {
		$text = wpautop($text);
	}
	
	if($do_char == 'smartypants') {
		require_once('text-control/smartypants.php');
		$text = SmartyPants($text);
		
	} else if($do_char == 'wptexturize') {
		$text = wptexturize($text);
		
	} else if($do_char == 'none') {
		$text = $text;
		
	} else {
		$text = wptexturize($text);
	}
	
	return $text;
	
}


remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'tc_post');

remove_filter('the_excerpt', 'wpautop');
remove_filter('the_excerpt', 'wptexturize');
add_filter('the_excerpt', 'tc_post');

remove_filter('comment_text', 'wpautop', 30);
remove_filter('comment_text', 'wptexturize');
add_filter('comment_text', 'tc_comment');



function tc_post_option_page() {
	global $wpdb;
?>

<div class="wrap">
	<h2>Text Control Settings</h2>
	<p>Set up the default settings for your blog text formatting.</p>
	
	<?php
	
	if( $_POST['tc_post_format'] && $_POST['tc_post_encoding'] ) {
		// set the post formatting options
		update_option('tc_post_format', $_POST['tc_post_format']);
		update_option('tc_post_encoding', $_POST['tc_post_encoding']);
		
		echo '<div class="updated"><p>Post/Excerpt formatting updated.</p></div>';
		
	}
	
	if( $_POST['tc_comment_format'] && $_POST['tc_comment_encoding'] ) {
		// set the comment formatting options
		update_option('tc_comment_format', $_POST['tc_comment_format']);
		update_option('tc_comment_encoding', $_POST['tc_comment_encoding']);
		
		echo '<div class="updated"><p>Comment formatting updated.</p></div>';
		
	}
	
	?>
	
	<form method="post">
	<fieldset class="options">
		<legend>Posts &amp; Excerpts</legend>
		
		<p>These will set up what the blog parses posts with by default unless over ridden on a per-post basis.</p>
		
		<?php
		
		$do_text = get_option('tc_post_format');
		$do_char = get_option('tc_post_encoding');
		
		?>
			<select name="tc_post_format">
				<option value="wpautop"<?php if($do_text == 'wpautop' OR $do_text == ''){ echo(' selected="selected"');}?>>Default (wpautop)</option>
				<option value="textile1"<?php if($do_text == 'textile1'){ echo(' selected="selected"');}?>>Textile 1</option>
				<option value="textile2"<?php if($do_text == 'textile2'){ echo(' selected="selected"');}?>>Textile 2</option>
				<option value="markdown"<?php if($do_text == 'markdown'){ echo(' selected="selected"');}?>>Markdown</option>
				<option value="nl2br"<?php if($do_text == 'nl2br'){ echo(' selected="selected"');}?>>nl2br</option>
				<option value="none"<?php if($do_text == 'none'){ echo(' selected="selected"');}?>>No Formatting</option>
			</select>
			
			<select name="tc_post_encoding">
				<option value="wptexturize"<?php if($do_char == 'wptexturize'){ echo(' selected="selected"');}?>>Default (wptexturize)</option>
				<option value="smartypants"<?php if($do_char == 'smartypants'){ echo(' selected="selected"');}?>>Smarty Pants</option>
				<option value="none"<?php if($do_char == 'none'){ echo(' selected="selected"');}?>>No Character Encoding</option>
			</select>
			
			<input type="submit" value="Change Default Post/Excerpt Formatting" />
			
	</fieldset>
	</form>
	
	<form method="post">
	<fieldset class="options">
		<legend>Comments</legend>
		<p>All comments will be processed with these:</p>
		
		<form method="post">
		
		<?php
		
		$do_text = get_option('tc_comment_format');
		$do_char = get_option('tc_comment_encoding');
		
		?>
			<select name="tc_comment_format">
				<option value="wpautop"<?php if($do_text == 'wpautop' OR $do_text == ''){ echo(' selected="selected"');}?>>Default (wpautop)</option>
				<option value="textile1"<?php if($do_text == 'textile1'){ echo(' selected="selected"');}?>>Textile 1</option>
				<option value="textile2"<?php if($do_text == 'textile2'){ echo(' selected="selected"');}?>>Textile 2</option>
				<option value="markdown"<?php if($do_text == 'markdown'){ echo(' selected="selected"');}?>>Markdown</option>
				<option value="nl2br"<?php if($do_text == 'nl2br'){ echo(' selected="selected"');}?>>nl2br</option>
				<option value="none"<?php if($do_text == 'none'){ echo(' selected="selected"');}?>>No Formatting</option>
			</select>
			
			<select name="tc_comment_encoding">
				<option value="wptexturize"<?php if($do_char == 'wptexturize'){ echo(' selected="selected"');}?>>Default (wptexturize)</option>
				<option value="smartypants"<?php if($do_char == 'smartypants'){ echo(' selected="selected"');}?>>Smarty Pants</option>
				<option value="none"<?php if($do_char == 'none'){ echo(' selected="selected"');}?>>No Character Encoding</option>
			</select>
			
			<input type="submit" value="Change Default Comment Formatting" />
			
	</fieldset>
	</form>
	
	
</div>


<?php

}

function tc_post_add_options() {
	 add_options_page('Text Control Formatting Options', 'Text Control Config', 8, __FILE__, 'tc_post_option_page');
}

add_action('admin_menu', 'tc_post_add_options');





add_filter('edit_post', 'tc_post_edit_post');
add_filter('publish_post', 'tc_post_edit_post');
add_filter('admin_footer', 'tc_post_admin_footer');

function tc_post_edit_post($id) {
	global $wpdb, $id;

	if(!isset($id)) $id = $_REQUEST['post_ID'];
	
	if( $id && $_POST['tc_post_i_format'] && $_POST['tc_post_i_encoding'] ){

		$qry = "DELETE FROM {$wpdb->postmeta} WHERE Post_ID = {$id} AND meta_key = '_tc_post_format';";
		$wpdb->query($qry);
		
		$qry = "DELETE FROM {$wpdb->postmeta} WHERE Post_ID = {$id} AND meta_key = '_tc_post_encoding';";
		$wpdb->query($qry);
			
		$qry = "INSERT INTO {$wpdb->postmeta} (Post_ID, meta_key, meta_value) VALUES ({$id}, '_tc_post_format', '$_POST[tc_post_i_format]');";
		$wpdb->query($qry);
			
		$qry = "INSERT INTO {$wpdb->postmeta} (Post_ID, meta_key, meta_value) VALUES ({$id}, '_tc_post_encoding', '$_POST[tc_post_i_encoding]');";
		$wpdb->query($qry);
	
	}
	
}

function tc_post_admin_footer($content) {
	global $id;

	if(!isset($id)) $id = $_REQUEST['post'];

	// Are we on the right page?
	if(preg_match('|post.php|i', $_SERVER['SCRIPT_NAME']) && $_REQUEST['action'] == 'edit' )
	{
		if(isset($_REQUEST['post'])) {
	
			$do_text = get_option('tc_post_format');
			$do_char = get_option('tc_post_encoding');
		
			if ( get_post_meta($id, '_tc_post_format', true) ) {
				$do_text = get_post_meta($id, '_tc_post_format', true);
			}
			if( get_post_meta($id, '_tc_post_encoding', true) ) {
				$do_char =  get_post_meta($id, '_tc_post_encoding', true);
			}
			
		}
		
		?>
		<div id="mtspp">
			<fieldset class="options">
				<legend>Text Control</legend>
				<p>Format this post with:
				
				<select name="tc_post_i_format">
					<option value="wpautop"<?php if($do_text == 'wpautop' OR $do_text == ''){ echo(' selected="selected"');}?>>Default (wpautop)</option>
					<option value="textile1"<?php if($do_text == 'textile1'){ echo(' selected="selected"');}?>>Textile 1</option>
					<option value="textile2"<?php if($do_text == 'textile2'){ echo(' selected="selected"');}?>>Textile 2</option>
					<option value="markdown"<?php if($do_text == 'markdown'){ echo(' selected="selected"');}?>>Markdown</option>
					<option value="nl2br"<?php if($do_text == 'nl2br'){ echo(' selected="selected"');}?>>nl2br</option>
					<option value="none"<?php if($do_text == 'none'){ echo(' selected="selected"');}?>>No Formatting</option>
				</select>
				
				<select name="tc_post_i_encoding">
					<option value="wptexturize"<?php if($do_char == 'wptexturize'){ echo(' selected="selected"');}?>>Default (wptexturize)</option>
					<option value="smartypants"<?php if($do_char == 'smartypants'){ echo(' selected="selected"');}?>>Smarty Pants</option>
					<option value="none"<?php if($do_char == 'none'){ echo(' selected="selected"');}?>>No Character Encoding</option>
				</select>
			
				<!--<input type="submit" value="Change Post Formatting" />-->
				</p>
					
			</fieldset>
		</div>
		<script language="JavaScript" type="text/javascript"><!--
		var placement = document.getElementById("titlediv");
		var substitution = document.getElementById("mtspp");
		var mozilla = document.getElementById&&!document.all;
		if(mozilla)
			 placement.parentNode.appendChild(substitution);
		else placement.parentElement.appendChild(substitution);
		//--></script>
		<?php


	}
}

?>