<?php

$GLOBALS['content_width'] = 900;

if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

// Amended Gallery shortcode
remove_shortcode('gallery');
add_shortcode('gallery', 'theme_gallery_shortcode');
function theme_gallery_shortcode($attr) {
	global $post;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )  return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] ) unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail'
	), $attr));

	$id = intval($id);
	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

	if ( empty($attachments) ) return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;

	$output = '<div class="gallery">'."\n";

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		$output .= "\n<".$itemtag.' class="gallery-item" style="width:'.$itemwidth.'%;">'."\n";
		$output .= '<'.$icontag.' class="gallery-icon">'.$link.'</'.$icontag.'>';
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= '<'.$captiontag.' class="gallery-caption">'.$attachment->post_excerpt.'</'.$captiontag.'>';
		}
		$output .= '</'.$itemtag.'>'."\n";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= "\n".'<br class="clear" />'."\n";
	}

	$output .= "\n".'<br class="clear" />'."</div>\n";

	return $output;
}

/* Header customisation starts */
define('HEADER_TEXTCOLOR', '606060');
define('HEADER_IMAGE', '%s/images/banner.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 1000);
define('HEADER_IMAGE_HEIGHT', 150);

function theme_admin_header_style() {
?>
<style type="text/css">
@import url(<?php bloginfo('template_directory'); ?>/admin-custom-header.css);
</style>
<?php
}

function theme_header_style() {
?>
<style type="text/css">
#header-image {background-image:url(<?php header_image(); ?>);}
#header h1,#header h1 a,#header h1 small {color:#<?php header_textcolor();?>;}
</style>
<?php
}
if ( function_exists('add_custom_image_header') ) add_custom_image_header('theme_header_style', 'theme_admin_header_style');

/* Header customisation ends */

?>