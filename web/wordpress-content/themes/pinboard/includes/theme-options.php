<?php

function pinboard_theme_page() {
	add_theme_page( __( 'Pinboard Theme Options', 'pinboard' ), __( 'Theme Options', 'pinboard' ), 'edit_theme_options', 'pinboard_options', 'pinboard_admin_options_page' );
}

add_action( 'admin_menu', 'pinboard_theme_page' );

function pinboard_register_settings() {
	register_setting( 'pinboard_theme_options', 'pinboard_theme_options', 'pinboard_validate_theme_options' );
}

add_action( 'admin_init', 'pinboard_register_settings' );

function pinboard_admin_scripts( $page_hook ) {
	if( 'appearance_page_pinboard_options' == $page_hook ) {
		wp_enqueue_style( 'pinboard_admin_style', get_template_directory_uri() . '/styles/admin.css' );
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'json2' );
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'wp-color-picker' );
	}
}

add_action( 'admin_enqueue_scripts', 'pinboard_admin_scripts' );

function pinboard_admin_options_page() { ?>
	<div class="wrap">
		<?php pinboard_admin_options_page_tabs(); ?>
		<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
			<div class='updated'><p><?php _e( 'Theme settings updated successfully.', 'pinboard' ); ?></p></div>
		<?php endif; ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'pinboard_theme_options' ); ?>
			<?php do_settings_sections('pinboard_options'); ?>
			<p>&nbsp;</p>
			<?php $tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ); ?>
			<input name="pinboard_theme_options[submit-<?php echo $tab; ?>]" type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'pinboard' ); ?>" />
			<input name="pinboard_theme_options[reset-<?php echo $tab; ?>]" type="submit" class="button-secondary" value="<?php _e( 'Reset Defaults', 'pinboard' ); ?>" />
			<script>
				jQuery(document).ready(function($) {
					$('.wp-color-picker').wpColorPicker();
				});
			</script>
		</form>
	</div>
<?php
}

function pinboard_admin_options_page_tabs( $current = 'general' ) {
	$current = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
	$tabs = array(
		'general' => __( 'General', 'pinboard' ),
		'design' => __( 'Design', 'pinboard' ),
		'layout' => __( 'Layout', 'pinboard' ),
		'typography' => __( 'Typography', 'pinboard' ),
		'seo' => __( 'SEO', 'pinboard' )
	);
	$links = array();
	foreach( $tabs as $tab => $name )
		$links[] = "<a class='nav-tab" . ( $tab == $current ? ' nav-tab-active' : '' ) ."' href='?page=pinboard_options&tab=$tab'>$name</a>";
	echo '<div id="icon-themes" class="icon32"><br /></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $links as $link )
		echo $link;
	echo '</h2>';
}

function pinboard_admin_options_init() {
	global $pagenow;
	if( 'themes.php' == $pagenow && isset( $_GET['page'] ) && 'pinboard_options' == $_GET['page'] ) {
		$tab = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
		switch ( $tab ) {
			case 'general' :
				pinboard_general_settings_sections();
				break;
			case 'design' :
				pinboard_design_settings_sections();
				break;
			case 'layout' :
				pinboard_layout_settings_sections();
				break;
			case 'typography' :
				pinboard_typography_settings_sections();
				break;
			case 'seo' :
				pinboard_seo_settings_sections();
				break;
		}
	}
}

add_action( 'admin_init', 'pinboard_admin_options_init' );

function pinboard_general_settings_sections() {
	add_settings_section( 'pinboard_global_options', __( 'Global Options', 'pinboard' ), 'pinboard_global_options', 'pinboard_options' );
	add_settings_section( 'pinboard_social_media_options', __( 'Social Media Links', 'pinboard' ), 'pinboard_social_media_options', 'pinboard_options' );
	add_settings_section( 'pinboard_home_page_options', __( 'Home Page', 'pinboard' ), 'pinboard_home_page_options', 'pinboard_options' );
	add_settings_section( 'pinboard_portfolio_page_options', __( 'Portfolio Page', 'pinboard' ), 'pinboard_portfolio_page_options', 'pinboard_options' );
	add_settings_section( 'pinboard_archive_page_options', __( 'Blog Pages', 'pinboard' ), 'pinboard_archive_page_options', 'pinboard_options' );
	add_settings_section( 'pinboard_single_options', __( 'Single Posts', 'pinboard' ), 'pinboard_single_options', 'pinboard_options' );
	add_settings_section( 'pinboard_footer_options', __( 'Footer', 'pinboard' ), 'pinboard_footer_options', 'pinboard_options' );
}

function pinboard_global_options() {
	add_settings_field( 'pinboard_retina_header', __( 'Retina Header Image', 'pinboard' ), 'pinboard_retina_header', 'pinboard_options', 'pinboard_global_options' );
	add_settings_field( 'pinboard_fancy_dropdowns', __( 'Fancy Drop-down Menus', 'pinboard' ), 'pinboard_fancy_dropdowns', 'pinboard_options', 'pinboard_global_options' );
	add_settings_field( 'pinboard_crop_thumbnails', __( 'Post Thumbnails', 'pinboard' ), 'pinboard_crop_thumbnails', 'pinboard_options', 'pinboard_global_options' );
	add_settings_field( 'pinboard_use_lightbox', __( 'Lightbox', 'pinboard' ), 'pinboard_use_lightbox', 'pinboard_options', 'pinboard_global_options' );
	add_settings_field( 'pinboard_posts_nav', __( 'Posts Navigation', 'pinboard' ), 'pinboard_posts_nav', 'pinboard_options', 'pinboard_global_options' );
	add_settings_field( 'pinboard_posts_nav_labels', __( 'Posts Navigation Labels', 'pinboard' ), 'pinboard_posts_nav_labels', 'pinboard_options', 'pinboard_global_options' );
}

function pinboard_retina_header() { ?>
	<label class="description">
		<input name="pinboard_theme_options[retina_header]" type="checkbox" value="1" <?php checked( pinboard_get_option( 'retina_header' ) ); ?> />
		<span><?php _e( 'Uploaded header images are HiDPI images for retina displays, downsize on normal screen devices.', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_fancy_dropdowns() { ?>
	<label class="description">
		<input name="pinboard_theme_options[fancy_dropdowns]" type="checkbox" value="1" <?php checked( pinboard_get_option( 'fancy_dropdowns' ) ); ?> />
		<span><?php _e( 'Enable transition effects for drop-down menus', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_crop_thumbnails() { ?>
	<label class="description">
		<input name="pinboard_theme_options[crop_thumbnails]" type="checkbox" value="1" <?php checked( pinboard_get_option( 'crop_thumbnails' ) ); ?> />
		<span><?php _e( 'Hard crop post thumbnails', 'pinboard' ); ?></span>
	</label><br />
	<span class="description"><strong>Note:</strong> <?php _e( 'After changing this option, it is recommended to recreate your thumbnails using a plugin like', 'pinboard' ); ?> <a href="<?php echo esc_url('http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/'); ?>">AJAX Thumbnail Rebuild</a></span>
<?php
}

function pinboard_use_lightbox() { ?>
	<label class="description">
		<input name="pinboard_theme_options[lightbox]" type="checkbox" value="1" <?php checked( pinboard_get_option( 'lightbox' ) ); ?> />
		<span><?php _e( 'Open image links in a lightbox', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_posts_nav() { ?>
	<select name="pinboard_theme_options[posts_nav]">
		<option value="static" <?php selected( 'static', pinboard_get_option( 'posts_nav' ) ); ?>><?php _e( 'Static Links', 'pinboard' ); ?></option>
		<option value="ajax" <?php selected( 'ajax', pinboard_get_option( 'posts_nav' ) ); ?>><?php _e( 'AJAX Links', 'pinboard' ); ?></option>
		<option value="infinite" <?php selected( 'infinite', pinboard_get_option( 'posts_nav' ) ); ?>><?php _e( 'Infinite Scroll', 'pinboard' ); ?></option>
	</select>
<?php
}

function pinboard_posts_nav_labels() { ?>
	<select name="pinboard_theme_options[posts_nav_labels]">
		<option value="next/prev" <?php selected( 'next/prev', pinboard_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Next Page', 'pinboard' ); ?> / <?php _e( 'Previous Page', 'pinboard' ); ?></option>
		<option value="older/newer" <?php selected( 'older/newer', pinboard_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Older Posts', 'pinboard' ); ?> / <?php _e( 'Newer Posts', 'pinboard' ); ?></option>
		<option value="earlier/later" <?php selected( 'earlier/later', pinboard_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Earlier Posts', 'pinboard' ); ?> / <?php _e( 'Later Posts', 'pinboard' ); ?></option>
		<option value="numbered" <?php selected( 'numbered', pinboard_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Numbered Pagination', 'pinboard' ); ?></option>
	</select>
<?php
}

function pinboard_social_media_options() {
	add_settings_field( 'pinboard_facebook_link', __( 'Facebook Page', 'pinboard' ), 'pinboard_facebook_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_twitter_link', __( 'Twitter Account', 'pinboard' ), 'pinboard_twitter_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_pinterest_link', __( 'Pinterest Board', 'pinboard' ), 'pinboard_pinterest_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_flickr_link', __( 'Flickr Account', 'pinboard' ), 'pinboard_flickr_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_vimeo_link', __( 'Vimeo Account', 'pinboard' ), 'pinboard_vimeo_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_youtube_link', __( 'Youtube Channel', 'pinboard' ), 'pinboard_youtube_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_googleplus_link', __( 'Google Plus Account', 'pinboard' ), 'pinboard_googleplus_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_dribble_link', __( 'Dribble Account', 'pinboard' ), 'pinboard_dribble_link', 'pinboard_options', 'pinboard_social_media_options' );
	add_settings_field( 'pinboard_linkedin_link', __( 'LinkedIn Account', 'pinboard' ), 'pinboard_linkedin_link', 'pinboard_options', 'pinboard_social_media_options' );
}

function pinboard_facebook_link() { ?>
	<input name="pinboard_theme_options[facebook_link]" type="text" value="<?php echo pinboard_get_option( 'facebook_link' ); ?>" />
<?php
}

function pinboard_twitter_link() { ?>
	<input name="pinboard_theme_options[twitter_link]" type="text" value="<?php echo pinboard_get_option( 'twitter_link' ); ?>" />
<?php
}

function pinboard_pinterest_link() { ?>
	<input name="pinboard_theme_options[pinterest_link]" type="text" value="<?php echo pinboard_get_option( 'pinterest_link' ); ?>" />
<?php
}

function pinboard_flickr_link() { ?>
	<input name="pinboard_theme_options[flickr_link]" type="text" value="<?php echo pinboard_get_option( 'flickr_link' ); ?>" />
<?php
}

function pinboard_vimeo_link() { ?>
	<input name="pinboard_theme_options[vimeo_link]" type="text" value="<?php echo pinboard_get_option( 'vimeo_link' ); ?>" />
<?php
}

function pinboard_youtube_link() { ?>
	<input name="pinboard_theme_options[youtube_link]" type="text" value="<?php echo pinboard_get_option( 'youtube_link' ); ?>" />
<?php
}

function pinboard_googleplus_link() { ?>
	<input name="pinboard_theme_options[googleplus_link]" type="text" value="<?php echo pinboard_get_option( 'googleplus_link' ); ?>" />
<?php
}

function pinboard_dribble_link() { ?>
	<input name="pinboard_theme_options[dribble_link]" type="text" value="<?php echo pinboard_get_option( 'dribble_link' ); ?>" />
<?php
}

function pinboard_linkedin_link() { ?>
	<input name="pinboard_theme_options[linkedin_link]" type="text" value="<?php echo pinboard_get_option( 'linkedin_link' ); ?>" />
<?php
}

function pinboard_home_page_options() {
	add_settings_field( 'pinboard_home_page_excerpts', __( 'Full posts to display', 'pinboard' ), 'pinboard_home_page_excerpts', 'pinboard_options', 'pinboard_home_page_options' );
	add_settings_field( 'pinboard_home_page_slider', __( 'Sticky Posts Slider', 'pinboard' ), 'pinboard_home_page_slider', 'pinboard_options', 'pinboard_home_page_options' );
	add_settings_field( 'pinboard_blog_exclude_portfolio', __( 'Exclude Portfolio', 'pinboard' ), 'pinboard_blog_exclude_portfolio', 'pinboard_options', 'pinboard_home_page_options' );
}

function pinboard_home_page_excerpts() { ?>
	<label class="description">
		<input name="pinboard_theme_options[home_page_excerpts]" type="text" value="<?php echo pinboard_get_option( 'home_page_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_blog_exclude_portfolio() { ?>
	<label class="description">
		<input name="pinboard_theme_options[blog_exclude_portfolio]" type="checkbox" value="<?php echo pinboard_get_option( 'blog_exclude_portfolio' ); ?>" <?php checked( pinboard_get_option( 'blog_exclude_portfolio' ) ); ?> />
		<span><?php _e( 'Exclude Portfolio Category from main loop', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_home_page_slider() { ?>
	<label class="description">
		<input name="pinboard_theme_options[slider]" type="checkbox" value="<?php echo pinboard_get_option( 'slider' ); ?>" <?php checked( pinboard_get_option( 'slider' ) ); ?> />
		<span><?php _e( 'Display a slider of sticky posts on the front page', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_portfolio_page_options() {
	add_settings_field( 'pinboard_portfolio_cat', __( 'Portfolio Category', 'pinboard' ), 'pinboard_portfolio_cat', 'pinboard_options', 'pinboard_portfolio_page_options' );
	add_settings_field( 'pinboard_portfolio_excerpts', __( 'Full posts to display on first page', 'pinboard' ), 'pinboard_portfolio_excerpts', 'pinboard_options', 'pinboard_portfolio_page_options' );
	add_settings_field( 'pinboard_portfolio_archive_excerpts', __( 'Full posts to display on secondary pages', 'pinboard' ), 'pinboard_portfolio_archive_excerpts', 'pinboard_options', 'pinboard_portfolio_page_options' );
}

function pinboard_portfolio_cat() {
	$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) ); ?>
	<select name="pinboard_theme_options[portfolio_cat]">
		<option value="-1" <?php selected( pinboard_get_option( 'portfolio_cat' ), -1 ); ?>>&mdash;</option>
		<?php foreach( $categories as $category ) : ?>
			<option value="<?php echo $category->cat_ID; ?>" <?php selected( pinboard_get_option( 'portfolio_cat' ), $category->cat_ID ); ?>><?php echo $category->cat_name; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_portfolio_excerpts() { ?>
	<label class="description">
		<input name="pinboard_theme_options[portfolio_excerpts]" type="text" value="<?php echo pinboard_get_option( 'portfolio_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_portfolio_archive_excerpts() { ?>
	<label class="description">
		<input name="pinboard_theme_options[portfolio_archive_excerpts]" type="text" value="<?php echo pinboard_get_option( 'portfolio_archive_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_archive_page_options() {
	add_settings_field( 'pinboard_archive_location', 'Archive Page Location', 'pinboard_archive_location', 'pinboard_options', 'pinboard_archive_page_options' );
	add_settings_field( 'pinboard_archive_excerpts', 'Full posts to display', 'pinboard_archive_excerpts', 'pinboard_options', 'pinboard_archive_page_options' );
}

function pinboard_archive_location() { ?>
	<label class="description">
		<input name="pinboard_theme_options[location]" type="checkbox" value="<?php echo pinboard_get_option( 'location' ); ?>" <?php checked( pinboard_get_option( 'location' ) ); ?> />
		<span><?php _e( 'Show current location in archive pages', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_archive_excerpts() { ?>
	<label class="description">
		<input name="pinboard_theme_options[archive_excerpts]" type="text" value="<?php echo pinboard_get_option( 'archive_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_single_options() {
	add_settings_field( 'pinboard_show_social_bookmarks', __( 'Social Bookmarks', 'pinboard' ), 'pinboard_show_social_bookmarks', 'pinboard_options', 'pinboard_single_options' );
	add_settings_field( 'pinboard_show_author_box', __( 'Author Box', 'pinboard' ), 'pinboard_show_author_box', 'pinboard_options', 'pinboard_single_options' );
}

function pinboard_show_social_bookmarks() { ?>
	<label class="description">
		<input name="pinboard_theme_options[facebook]" type="checkbox" value="<?php echo pinboard_get_option( 'facebook' ); ?>" <?php checked( pinboard_get_option( 'facebook' ) ); ?> />
		<span><?php _e( 'Facebook Like', 'pinboard' ); ?></span>
	</label><br />
	<label class="description">
		<input name="pinboard_theme_options[twitter]" type="checkbox" value="<?php echo pinboard_get_option( 'twitter' ); ?>" <?php checked( pinboard_get_option( 'twitter' ) ); ?> />
		<span><?php _e( 'Twitter Button', 'pinboard' ); ?></span>
	</label><br />
	<label class="description">
		<input name="pinboard_theme_options[google]" type="checkbox" value="<?php echo pinboard_get_option( 'google' ); ?>" <?php checked( pinboard_get_option( 'google' ) ); ?> />
		<span><?php _e( 'Google +1', 'pinboard' ); ?></span>
	</label><br />
	<label class="description">
		<input name="pinboard_theme_options[pinterest]" type="checkbox" value="<?php echo pinboard_get_option( 'pinterest' ); ?>" <?php checked( pinboard_get_option( 'pinterest' ) ); ?> />
		<span><?php _e( 'Pinterest', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_show_author_box() { ?>
	<label class="description">
		<input name="pinboard_theme_options[author_box]" type="checkbox" value="<?php echo pinboard_get_option( 'author_box' ); ?>" <?php checked( pinboard_get_option( 'author_box' ) ); ?> />
		<span><?php _e( 'Display a hcard microformatted box featuring author name, avatar and bio', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_footer_options() {
	add_settings_field( 'pinboard_copyright_notice', __( 'Copyright Notice', 'pinboard' ), 'pinboard_copyright_notice', 'pinboard_options', 'pinboard_footer_options' );
	add_settings_field( 'pinboard_credit_links', __( 'Credit Links', 'pinboard' ), 'pinboard_credit_links', 'pinboard_options', 'pinboard_footer_options' );
}

function pinboard_copyright_notice() { ?>
	<label class="description">
		<input name="pinboard_theme_options[copyright_notice]" type="text" value="<?php echo esc_html( pinboard_get_option( 'copyright_notice' ) ); ?>" />
		<span><?php _e( 'Text to display in the footer copyright section (%year% = current year, %blogname% = website name)', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_credit_links() { ?>
	<label class="description">
		<input name="pinboard_theme_options[theme_credit_link]" type="checkbox" value="<?php echo pinboard_get_option( 'theme_credit_link' ); ?>" <?php checked( pinboard_get_option( 'theme_credit_link' ) ); ?> />
		<span><?php _e( 'Show theme credit link', 'pinboard' ); ?></span>
	</label><br />
	<label class="description">
		<input name="pinboard_theme_options[author_credit_link]" type="checkbox" value="<?php echo pinboard_get_option( 'author_credit_link' ); ?>" <?php checked( pinboard_get_option( 'author_credit_link' ) ); ?> />
		<span><?php _e( 'Show author credit link', 'pinboard' ); ?></span>
	</label><br />
	<label class="description">
		<input name="pinboard_theme_options[wordpress_credit_link]" type="checkbox" value="<?php echo pinboard_get_option( 'wordpress_credit_link' ); ?>" <?php checked( pinboard_get_option( 'wordpress_credit_link' ) ); ?> />
		<span><?php _e( 'Show WordPress credit link', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_design_settings_sections() {
	add_settings_section( 'pinboard_backgrounds', __( 'Background Colors', 'pinboard' ), 'pinboard_backgrounds', 'pinboard_options' );
}

function pinboard_backgrounds() {
	add_settings_field( 'pinboard_page_background', __( 'Page Background Color', 'pinboard' ), 'pinboard_page_background', 'pinboard_options', 'pinboard_backgrounds' );
	add_settings_field( 'pinboard_menu_background', __( 'Menu Background Color', 'pinboard' ), 'pinboard_menu_background', 'pinboard_options', 'pinboard_backgrounds' );
	add_settings_field( 'pinboard_submenu_background', __( 'Dropdown Menus Background Color', 'pinboard' ), 'pinboard_submenu_background', 'pinboard_options', 'pinboard_backgrounds' );
	add_settings_field( 'pinboard_sidebar_wide_background', __( 'Site Location Background Color', 'pinboard' ), 'pinboard_sidebar_wide_background', 'pinboard_options', 'pinboard_backgrounds' );
	add_settings_field( 'pinboard_content_background', __( 'Content Background Color', 'pinboard' ), 'pinboard_content_background', 'pinboard_options', 'pinboard_backgrounds' );
	add_settings_field( 'pinboard_post_meta_background', __( 'Post Meta Background Color', 'pinboard' ), 'pinboard_post_meta_background', 'pinboard_options', 'pinboard_backgrounds' );
	add_settings_field( 'pinboard_footer_area_background', __( 'Footer Widgets Background Color', 'pinboard' ), 'pinboard_footer_area_background', 'pinboard_options', 'pinboard_backgrounds' );
	add_settings_field( 'pinboard_footer_background', __( 'Footer Background Color', 'pinboard' ), 'pinboard_footer_background', 'pinboard_options', 'pinboard_backgrounds' );
}

function pinboard_page_background() { ?>
	<input name="pinboard_theme_options[page_background]" type="text" id="page_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'page_background' ) ); ?>" />
	<?php
}

function pinboard_menu_background() { ?>
	<input name="pinboard_theme_options[menu_background]" type="text" id="menu_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'menu_background' ) ); ?>" />
	<?php
}

function pinboard_submenu_background() { ?>
	<input name="pinboard_theme_options[submenu_background]" type="text" id="submenu_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'submenu_background' ) ); ?>" />
	<?php
}

function pinboard_sidebar_wide_background() { ?>
	<input name="pinboard_theme_options[sidebar_wide_background]" type="text" id="sidebar_wide_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'sidebar_wide_background' ) ); ?>" />
	<?php
}

function pinboard_content_background() { ?>
	<input name="pinboard_theme_options[content_background]" type="text" id="content_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'content_background' ) ); ?>" />
	<?php
}

function pinboard_post_meta_background() { ?>
	<input name="pinboard_theme_options[post_meta_background]" type="text" id="post_meta_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'post_meta_background' ) ); ?>" />
	<?php
}

function pinboard_footer_area_background() { ?>
	<input name="pinboard_theme_options[footer_area_background]" type="text" id="footer_area_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'footer_area_background' ) ); ?>" />
	<?php
}

function pinboard_footer_background() { ?>
	<input name="pinboard_theme_options[footer_background]" type="text" id="footer_background" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'footer_background' ) ); ?>" />
	<?php
}

function pinboard_layout_settings_sections() {
	add_settings_section( 'pinboard_layout', __( 'Default Layout Template', 'pinboard' ), 'pinboard_layout', 'pinboard_options' );
	add_settings_section( 'pinboard_layout_dimensions', __( 'Grid Layout Dimensions', 'pinboard' ), 'pinboard_layout_dimensions', 'pinboard_options' );
	add_settings_section( 'pinboard_responsive_layout', __( 'Responsive Layout', 'pinboard' ), 'pinboard_responsive_layout', 'pinboard_options' );
	add_settings_section( 'pinboard_custom_css', __( 'Custom CSS', 'pinboard' ), 'pinboard_custom_css', 'pinboard_options' );
}

function pinboard_layout() {
	add_settings_field( 'pinboard_layout_template', __( 'Choose your preferred Layout', 'pinboard' ), 'pinboard_layout_template', 'pinboard_options', 'pinboard_layout' );
}

function pinboard_layout_dimensions() {
	add_settings_field( 'pinboard_layout_columns', __( 'Content Columns', 'pinboard' ), 'pinboard_layout_columns', 'pinboard_options', 'pinboard_layout_dimensions' );
	add_settings_field( 'pinboard_boxes_columns', __( 'Boxes Sidebar Columns', 'pinboard' ), 'pinboard_boxes_columns', 'pinboard_options', 'pinboard_layout_dimensions' );
	add_settings_field( 'pinboard_footer_columns', __( 'Footer Sidebar Columns', 'pinboard' ), 'pinboard_footer_columns', 'pinboard_options', 'pinboard_layout_dimensions' );
}

function pinboard_responsive_layout() {
	add_settings_field( 'pinboard_hide_sidebar', __( 'Hide Sidebar', 'pinboard' ), 'pinboard_hide_sidebar', 'pinboard_options', 'pinboard_responsive_layout' );
	add_settings_field( 'pinboard_hide_footer_area', __( 'Hide Footer Widgets Area', 'pinboard' ), 'pinboard_hide_footer_area', 'pinboard_options', 'pinboard_responsive_layout' );
}

function pinboard_custom_css() {
	add_settings_field( 'pinboard_user_css', __( 'Enter your custom CSS', 'pinboard' ), 'pinboard_user_css', 'pinboard_options', 'pinboard_custom_css' );
}

function pinboard_layout_template() {
	$current_layout = pinboard_get_option( 'layout' );
	$layouts = array(
		'content-sidebar' => array(
			'name' => 'Content / Sidebar',
			'image' => 'content-sidebar.png'
		),
		'sidebar-content' => array(
			'name' => 'Sidebar / Content',
			'image' => 'sidebar-content.png'
		),
		'content-sidebar-half' => array(
			'name' => 'Content / Sidebar Half',
			'image' => 'content-sidebar-half.png'
		),
		'sidebar-content-half' => array(
			'name' => 'Sidebar / Content Half',
			'image' => 'content-sidebar-half.png'
		),
		'no-sidebars' => array(
			'name' => 'No Sidebars',
			'image' => 'no-sidebars.png'
		),
		'full-width' => array(
			'name' => 'Full Width',
			'image' => 'full-width.png'
		),
	); ?>
	<script>
		jQuery(document).ready(function($) {
			var label_id = '';
			$('.layout').each(function(){
				if($(this).attr('checked')=='checked')
					label_id = '#label-'+$(this).attr('id');
			});
			if('' != label_id)
				$(label_id).addClass('checked');
			$('.layout-label').click(function() {
				$('.layout-label').removeClass('checked');
				$(this).addClass('checked');
			});
		});
	</script>
	<?php foreach( $layouts as $layout => $data ) : ?>
		<label for="<?php echo $layout; ?>" class="layout-label" id="label-<?php echo $layout; ?>"><img src="<?php echo get_template_directory_uri() . '/images/' . $data['image']; ?>" alt="<?php echo $data['name']; ?>" title="<?php echo $data['name']; ?>" />
		<input name="pinboard_theme_options[layout]" class="layout" id="<?php echo $layout; ?>" value="<?php echo $layout; ?>" type="radio" <?php checked( $layout, $current_layout ); ?> /></label>
	<?php endforeach;
}

function pinboard_layout_columns() { ?>
	<select name="pinboard_theme_options[layout_columns]">
		<option value="2" <?php selected( 2, pinboard_get_option( 'layout_columns' ) ); ?>>2</option>
		<option value="3" <?php selected( 3, pinboard_get_option( 'layout_columns' ) ); ?>>3</option>
		<option value="4" <?php selected( 4, pinboard_get_option( 'layout_columns' ) ); ?>>4</option>
	</select><br />
	<span class="description">
		<strong><?php _e( 'Note', 'pinboard' ); ?>:</strong> <?php _e( 'If your layout contains a sidebar, the sidebar accounts for 1 column from the grid.', 'pinboard' ); ?><br />
		<?php _e( 'Not all combinations of layouts and number of columns may be practical.', 'pinboard' ); ?>
	</span>
<?php
}

function pinboard_boxes_columns() { ?>
	<select name="pinboard_theme_options[boxes_columns]">
		<option value="2" <?php selected( 2, pinboard_get_option( 'boxes_columns' ) ); ?>>2</option>
		<option value="3" <?php selected( 3, pinboard_get_option( 'boxes_columns' ) ); ?>>3</option>
		<option value="4" <?php selected( 4, pinboard_get_option( 'boxes_columns' ) ); ?>>4</option>
	</select>
<?php
}

function pinboard_footer_columns() { ?>
	<select name="pinboard_theme_options[footer_columns]">
		<option value="2" <?php selected( 2, pinboard_get_option( 'footer_columns' ) ); ?>>2</option>
		<option value="3" <?php selected( 3, pinboard_get_option( 'footer_columns' ) ); ?>>3</option>
		<option value="4" <?php selected( 4, pinboard_get_option( 'footer_columns' ) ); ?>>4</option>
	</select>
<?php
}

function pinboard_hide_sidebar() { ?>
	<label class="description">
		<input name="pinboard_theme_options[hide_sidebar]" type="checkbox" value="<?php echo pinboard_get_option( 'hide_sidebar' ); ?>" <?php checked( pinboard_get_option( 'hide_sidebar' ) ); ?> />
		<span><?php _e( 'Hide Sidebar on Mobile Devices', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_hide_footer_area() { ?>
	<label class="description">
		<input name="pinboard_theme_options[hide_footer_area]" type="checkbox" value="<?php echo pinboard_get_option( 'hide_footer_area' ); ?>" <?php checked( pinboard_get_option( 'hide_footer_area' ) ); ?> />
		<span><?php _e( 'Hide Footer Widget Area on Mobile Devices', 'pinboard' ); ?></span>
	</label>
<?php
}

function pinboard_user_css() { ?>
	<textarea name="pinboard_theme_options[user_css]" cols="70" rows="15" style="width:97%;font-family:monospace;background:#f9f9f9"><?php echo esc_textarea( pinboard_get_option( 'user_css' ) ); ?></textarea>
<?php
}

function pinboard_typography_settings_sections() {
	add_settings_section( 'pinboard_fonts', __( 'Font Families', 'pinboard' ), 'pinboard_fonts', 'pinboard_options' );
	add_settings_section( 'pinboard_font_sizes', __( 'Font Sizes', 'pinboard' ), 'pinboard_font_sizes', 'pinboard_options' );
	add_settings_section( 'pinboard_colors', __( 'Colors', 'pinboard' ), 'pinboard_colors', 'pinboard_options' );
}

function pinboard_fonts() {
	add_settings_field( 'pinboard_body_font', __( 'Default Font Family', 'pinboard' ), 'pinboard_body_font', 'pinboard_options', 'pinboard_fonts' );
	add_settings_field( 'pinboard_headings_font', __( 'Headings Font Family', 'pinboard' ), 'pinboard_headings_font', 'pinboard_options', 'pinboard_fonts' );
	add_settings_field( 'pinboard_content_font', __( 'Body Copy Font Family', 'pinboard' ), 'pinboard_content_font', 'pinboard_options', 'pinboard_fonts' );
}

function pinboard_body_font() {
	$fonts = pinboard_available_fonts(); ?>
	<select name="pinboard_theme_options[body_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, pinboard_get_option( 'body_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_headings_font() {
	$fonts = pinboard_available_fonts(); ?>
	<select name="pinboard_theme_options[headings_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, pinboard_get_option( 'headings_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_content_font() {
	$fonts = pinboard_available_fonts(); ?>
	<select name="pinboard_theme_options[content_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, pinboard_get_option( 'content_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_font_sizes() {
	add_settings_field( 'pinboard_body_font_size', __( 'Default Font Size', 'pinboard' ), 'pinboard_body_font_size', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_body_line_height', __( 'Default Line Height', 'pinboard' ), 'pinboard_body_line_height', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_h1_font_size', __( 'H1 Font Size', 'pinboard' ), 'pinboard_h1_font_size', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_h2_font_size', __( 'H2 Font Size', 'pinboard' ), 'pinboard_h2_font_size', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_h3_font_size', __( 'H3 Font Size', 'pinboard' ), 'pinboard_h3_font_size', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_h4_font_size', __( 'H4 Font Size', 'pinboard' ), 'pinboard_h4_font_size', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_headings_line_height', __( 'Headings Line Height', 'pinboard' ), 'pinboard_headings_line_height', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_content_font_size', __( 'Body Copy Font Size', 'pinboard' ), 'pinboard_content_font_size', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_content_line_height', __( 'Body Copy Line Height', 'pinboard' ), 'pinboard_content_line_height', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_mobile_font_size', __( 'Body Copy Font Size on Mobile Devices', 'pinboard' ), 'pinboard_mobile_font_size', 'pinboard_options', 'pinboard_font_sizes' );
	add_settings_field( 'pinboard_mobile_line_height', __( 'Body Copy Line Height on Mobile Devices', 'pinboard' ), 'pinboard_mobile_line_height', 'pinboard_options', 'pinboard_font_sizes' );
}

function pinboard_body_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[body_font_size]" type="text" value="<?php echo pinboard_get_option( 'body_font_size' ); ?>" size="4" />
	<select name="pinboard_theme_options[body_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'body_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_body_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[body_line_height]" type="text" value="<?php echo pinboard_get_option( 'body_line_height' ); ?>" size="4" />
	<select name="pinboard_theme_options[body_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'body_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_h1_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[h1_font_size]" type="text" value="<?php echo pinboard_get_option( 'h1_font_size' ); ?>" size="4" />
	<select name="pinboard_theme_options[h1_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'h1_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_h2_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[h2_font_size]" type="text" value="<?php echo pinboard_get_option( 'h2_font_size' ); ?>" size="4" />
	<select name="pinboard_theme_options[h2_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'h2_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_h3_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[h3_font_size]" type="text" value="<?php echo pinboard_get_option( 'h3_font_size' ); ?>" size="4" />
	<select name="pinboard_theme_options[h3_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'h3_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_h4_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[h4_font_size]" type="text" value="<?php echo pinboard_get_option( 'h4_font_size' ); ?>" size="4" />
	<select name="pinboard_theme_options[h4_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'h4_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_headings_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[headings_line_height]" type="text" value="<?php echo pinboard_get_option( 'headings_line_height' ); ?>" size="4" />
	<select name="pinboard_theme_options[headings_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'headings_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_content_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[content_font_size]" type="text" value="<?php echo pinboard_get_option( 'content_font_size' ); ?>" size="4" />
	<select name="pinboard_theme_options[content_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'content_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_content_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[content_line_height]" type="text" value="<?php echo pinboard_get_option( 'content_line_height' ); ?>" size="4" />
	<select name="pinboard_theme_options[content_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'content_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_mobile_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[mobile_font_size]" type="text" value="<?php echo pinboard_get_option( 'mobile_font_size' ); ?>" size="4" />
	<select name="pinboard_theme_options[mobile_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'mobile_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_mobile_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="pinboard_theme_options[mobile_line_height]" type="text" value="<?php echo pinboard_get_option( 'mobile_line_height' ); ?>" size="4" />
	<select name="pinboard_theme_options[mobile_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, pinboard_get_option( 'mobile_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_colors() {
	add_settings_field( 'pinboard_body_color', __( 'Default Font Color', 'pinboard' ), 'pinboard_body_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_headings_color', __( 'Headings Font Color', 'pinboard' ), 'pinboard_headings_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_content_color', __( 'Body Copy Font Color', 'pinboard' ), 'pinboard_content_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_links_color', __( 'Links Color', 'pinboard' ), 'pinboard_links_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_links_hover_color', __( 'Links Hover Color', 'pinboard' ), 'pinboard_links_hover_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_menu_color', __( 'Navigation Links Color', 'pinboard' ), 'pinboard_menu_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_menu_hover_color', __( 'Navigation Links Hover Color', 'pinboard' ), 'pinboard_menu_hover_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_sidebar_color', __( 'Sidebar Widgets Color', 'pinboard' ), 'pinboard_sidebar_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_sidebar_title_color', __( 'Sidebar Widgets Title Color', 'pinboard' ), 'pinboard_sidebar_title_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_sidebar_links_color', __( 'Widgets Links Color', 'pinboard' ), 'pinboard_sidebar_links_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_footer_color', __( 'Footer Widgets Color', 'pinboard' ), 'pinboard_footer_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_footer_title_color', __( 'Footer Widgets Title Color', 'pinboard' ), 'pinboard_footer_title_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_copyright_color', __( 'Footer Color', 'pinboard' ), 'pinboard_copyright_color', 'pinboard_options', 'pinboard_colors' );
	add_settings_field( 'pinboard_copyright_links_color', __( 'Footer Links Color', 'pinboard' ), 'pinboard_copyright_links_color', 'pinboard_options', 'pinboard_colors' );
}

function pinboard_body_color() { ?>
	<input name="pinboard_theme_options[body_color]" type="text" id="body_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'body_color' ) ); ?>" />
	<?php
}

function pinboard_headings_color() { ?>
	<input name="pinboard_theme_options[headings_color]" type="text" id="headings_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'headings_color' ) ); ?>" />
	<?php
}

function pinboard_content_color() { ?>
	<input name="pinboard_theme_options[content_color]" type="text" id="content_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'content_color' ) ); ?>" />
	<?php
}

function pinboard_links_color() { ?>
	<input name="pinboard_theme_options[links_color]" type="text" id="links_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'links_color' ) ); ?>" />
	<?php
}

function pinboard_links_hover_color() { ?>
	<input name="pinboard_theme_options[links_hover_color]" type="text" id="links_hover_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'links_hover_color' ) ); ?>" />
	<?php
}

function pinboard_menu_color() { ?>
	<input name="pinboard_theme_options[menu_color]" type="text" id="menu_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'menu_color' ) ); ?>" />
	<?php
}

function pinboard_menu_hover_color() { ?>
	<input name="pinboard_theme_options[menu_hover_color]" type="text" id="menu_hover_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'menu_hover_color' ) ); ?>" />
	<?php
}

function pinboard_sidebar_color() { ?>
	<input name="pinboard_theme_options[sidebar_color]" type="text" id="sidebar_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'sidebar_color' ) ); ?>" />
	<?php
}

function pinboard_sidebar_title_color() { ?>
	<input name="pinboard_theme_options[sidebar_title_color]" type="text" id="sidebar_title_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'sidebar_title_color' ) ); ?>" />
	<?php
}

function pinboard_sidebar_links_color() { ?>
	<input name="pinboard_theme_options[sidebar_links_color]" type="text" id="sidebar_links_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'sidebar_links_color' ) ); ?>" />
	<?php
}

function pinboard_footer_color() { ?>
	<input name="pinboard_theme_options[footer_color]" type="text" id="footer_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'footer_color' ) ); ?>" />
	<?php
}

function pinboard_footer_title_color() { ?>
	<input name="pinboard_theme_options[footer_title_color]" type="text" id="footer_title_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'footer_title_color' ) ); ?>" />
	<?php
}

function pinboard_copyright_color() { ?>
	<input name="pinboard_theme_options[copyright_color]" type="text" id="copyright_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'copyright_color' ) ); ?>" />
	<?php
}

function pinboard_copyright_links_color() { ?>
	<input name="pinboard_theme_options[copyright_links_color]" type="text" id="copyright_links_color" class="wp-color-picker" value="<?php echo esc_attr( pinboard_get_option( 'copyright_links_color' ) ); ?>" />
	<?php
}
function pinboard_seo_settings_sections() {
	add_settings_section( 'pinboard_home_tags', __( 'Home Page', 'pinboard' ), 'pinboard_home_tags', 'pinboard_options' );
	add_settings_section( 'pinboard_archive_tags', __( 'Archive Pages', 'pinboard' ), 'pinboard_archive_tags', 'pinboard_options' );
	add_settings_section( 'pinboard_single_tags', __( 'Single Posts &amp; Pages', 'pinboard' ), 'pinboard_single_tags', 'pinboard_options' );
	add_settings_section( 'pinboard_other_tags', __( 'Other', 'pinboard' ), 'pinboard_other_tags', 'pinboard_options' );
}

function pinboard_home_tags() {
	add_settings_field( 'pinboard_home_site_title_tag', __( 'Site Title Tag', 'pinboard' ), 'pinboard_home_site_title_tag', 'pinboard_options', 'pinboard_home_tags' );
	add_settings_field( 'pinboard_home_site_desc_tag', __( 'Site Description Tag', 'pinboard' ), 'pinboard_home_site_desc_tag', 'pinboard_options', 'pinboard_home_tags' );
	add_settings_field( 'pinboard_home_post_title_tag', __( 'Post Title Tag', 'pinboard' ), 'pinboard_home_post_title_tag', 'pinboard_options', 'pinboard_home_tags' );
}

function pinboard_home_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[home_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'home_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_home_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[home_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'home_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_home_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[home_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'home_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_archive_tags() {
	add_settings_field( 'pinboard_archive_site_title_tag', __( 'Site Title Tag', 'pinboard' ), 'pinboard_archive_site_title_tag', 'pinboard_options', 'pinboard_archive_tags' );
	add_settings_field( 'pinboard_archive_site_desc_tag', __( 'Site Description Tag', 'pinboard' ), 'pinboard_archive_site_desc_tag', 'pinboard_options', 'pinboard_archive_tags' );
	add_settings_field( 'pinboard_archive_location_title_tag', __( 'Site Location Title Tag', 'pinboard' ), 'pinboard_archive_location_title_tag', 'pinboard_options', 'pinboard_archive_tags' );
	add_settings_field( 'pinboard_archive_post_title_tag', __( 'Post Title Tag', 'pinboard' ), 'pinboard_archive_post_title_tag', 'pinboard_options', 'pinboard_archive_tags' );
}

function pinboard_archive_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[archive_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'archive_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_archive_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[archive_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'archive_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_archive_location_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[archive_location_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'archive_location_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_archive_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[archive_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'archive_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_single_tags() {
	add_settings_field( 'pinboard_single_site_title_tag', __( 'Site Title Tag', 'pinboard' ), 'pinboard_single_site_title_tag', 'pinboard_options', 'pinboard_single_tags' );
	add_settings_field( 'pinboard_single_site_desc_tag', __( 'Site Description Tag', 'pinboard' ), 'pinboard_single_site_desc_tag', 'pinboard_options', 'pinboard_single_tags' );
	add_settings_field( 'pinboard_single_post_title_tag', __( 'Post Title Tag', 'pinboard' ), 'pinboard_single_post_title_tag', 'pinboard_options', 'pinboard_single_tags' );
	add_settings_field( 'pinboard_single_comments_title_tag', __( 'Comments Title Tag', 'pinboard' ), 'pinboard_single_comments_title_tag', 'pinboard_options', 'pinboard_single_tags' );
	add_settings_field( 'pinboard_single_respond_title_tag', __( 'Reply Form Title Tag', 'pinboard' ), 'pinboard_single_respond_title_tag', 'pinboard_options', 'pinboard_single_tags' );
}

function pinboard_single_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[single_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'single_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_single_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[single_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'single_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_single_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[single_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'single_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_single_comments_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[single_comments_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'single_comments_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_single_respond_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[single_respond_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'single_respond_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_other_tags() {
	add_settings_field( 'pinboard_widget_title_tag', __( 'Widget Title Tag', 'pinboard' ), 'pinboard_widget_title_tag', 'pinboard_options', 'pinboard_other_tags' );
}

function pinboard_widget_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="pinboard_theme_options[widget_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, pinboard_get_option( 'widget_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function pinboard_validate_theme_options( $input ) {
	if( isset( $input['submit-general'] ) || isset( $input['reset-general'] ) ) {
		if( ! is_numeric( absint( $input['home_page_excerpts'] ) ) || $input['home_page_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['home_page_excerpts'] )
			$input['home_page_excerpts'] = pinboard_get_option( 'home_page_excerpts' );
		else
			$input['home_page_excerpts'] = absint( $input['home_page_excerpts'] );
		if( -1 != $input['portfolio_cat'] ) {
			$valid = 0;
			$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) );
			foreach( $categories as $category ) {
				if( $input['portfolio_cat'] == $category->cat_ID )
					$valid = 1;
			}
			if( ! $valid )
				$input['portfolio_cat'] = pinboard_get_option( 'portfolio_cat' );
		}
		if( ! is_numeric( absint( $input['portfolio_excerpts'] ) ) || $input['portfolio_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['portfolio_excerpts'] )
			$input['portfolio_excerpts'] = pinboard_get_option( 'portfolio_excerpts' );
		else
			$input['portfolio_excerpts'] = absint( $input['portfolio_excerpts'] );
		if( ! is_numeric( absint( $input['portfolio_archive_excerpts'] ) ) || $input['portfolio_archive_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['portfolio_archive_excerpts'] )
			$input['portfolio_archive_excerpts'] = pinboard_get_option( 'portfolio_archive_excerpts' );
		else
			$input['portfolio_archive_excerpts'] = absint( $input['portfolio_archive_excerpts'] );
		if( ! is_numeric( absint( $input['archive_excerpts'] ) ) || $input['archive_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['archive_excerpts'] )
			$input['archive_excerpts'] = pinboard_get_option( 'archive_excerpts' );
		else
			$input['archive_excerpts'] = absint( $input['archive_excerpts'] );
		$input['slider'] = ( isset( $input['slider'] ) ? true : false );
		$input['blog_exclude_portfolio'] = ( isset( $input['blog_exclude_portfolio'] ) ? true : false );
		$input['location'] = ( isset( $input['location'] ) ? true : false );
		$input['retina_header'] = ( isset( $input['retina_header'] ) ? true : false );
		$input['crop_thumbnails'] = ( isset( $input['crop_thumbnails'] ) ? true : false );
		$input['lightbox'] = ( isset( $input['lightbox'] ) ? true : false );
		if( ! in_array( $input['posts_nav'], array( 'static', 'ajax', 'infinite' ) ) )
			$input['posts_nav'] = pinboard_get_option( 'posts_nav' );
		if( ! in_array( $input['posts_nav_labels'], array( 'next/prev', 'older/newer', 'earlier/later', 'numbered' ) ) )
			$input['posts_nav_labels'] = pinboard_get_option( 'posts_nav_labels' );
		$input['fancy_dropdowns'] = ( isset( $input['fancy_dropdowns'] ) ? true : false );
		$input['facebook_link'] = esc_url_raw( $input['facebook_link'] );
		$input['twitter_link'] = esc_url_raw( $input['twitter_link'] );
		$input['pinterest_link'] = esc_url_raw( $input['pinterest_link'] );
		$input['youtube_link'] = esc_url_raw( $input['youtube_link'] );
		$input['vimeo_link'] = esc_url_raw( $input['vimeo_link'] );
		$input['flickr_link'] = esc_url_raw( $input['flickr_link'] );
		$input['googleplus_link'] = esc_url_raw( $input['googleplus_link'] );
		$input['dribble_link'] = esc_url_raw( $input['dribble_link'] );
		$input['linkedin_link'] = esc_url_raw( $input['linkedin_link'] );
		$input['facebook'] = ( isset( $input['facebook'] ) ? true : false );
		$input['twitter'] = ( isset( $input['twitter'] ) ? true : false );
		$input['google'] = ( isset( $input['google'] ) ? true : false );
		$input['pinterest'] = ( isset( $input['pinterest'] ) ? true : false );
		$input['author_box'] = ( isset( $input['author_box'] ) ? true : false );
		$input['copyright_notice'] = balanceTags( $input['copyright_notice'] );
		$input['theme_credit_link'] = ( isset( $input['theme_credit_link'] ) ? true : false );
		$input['author_credit_link'] = ( isset( $input['author_credit_link'] ) ? true : false );
		$input['wordpress_credit_link'] = ( isset( $input['wordpress_credit_link'] ) ? true : false );
	} elseif( isset( $input['submit-design'] ) || isset( $input['reset-design'] ) ) {
		$input['page_background'] = substr( $input['page_background'], 0, 7 );
		$input['menu_background'] = substr( $input['menu_background'], 0, 7 );
		$input['submenu_background'] = substr( $input['submenu_background'], 0, 7 );
		$input['sidebar_wide_background'] = substr( $input['sidebar_wide_background'], 0, 7 );
		$input['content_background'] = substr( $input['content_background'], 0, 7 );
		$input['post_meta_background'] = substr( $input['post_meta_background'], 0, 7 );
		$input['footer_area_background'] = substr( $input['footer_area_background'], 0, 7 );
		$input['footer_background'] = substr( $input['footer_background'], 0, 7 );
	} elseif( isset( $input['submit-layout'] ) || isset( $input['reset-layout'] ) ) {
		if( ! in_array( $input['layout'], array( 'content-sidebar', 'sidebar-content', 'content-sidebar-half', 'sidebar-content-half', 'no-sidebars', 'full-width' ) ) )
			$input['layout'] = pinboard_get_option( 'layout' );
		if( is_numeric( $input['layout_columns'] ) && 2 <= $input['layout_columns'] && 44 >= $input['layout_columns'] )
			$input['layout_columns'] = absint( $input['layout_columns'] );
		else
			$input['layout_columns'] = pinboard_get_option( 'layout_columns' );
		$input['hide_sidebar'] = ( isset( $input['hide_sidebar'] ) ? true : false );
		$input['hide_footer_area'] = ( isset( $input['hide_footer_area'] ) ? true : false );
		$input['user_css'] = esc_html( $input['user_css'] );
	} elseif( isset( $input['submit-typography'] ) || isset( $input['reset-typography'] ) ) {
		$fonts = pinboard_available_fonts();
		$units = array( 'px', 'pt', 'em', '%' );
		$input['body_font'] = ( array_key_exists( $input['body_font'], $fonts ) ? $input['body_font'] : pinboard_get_option( 'body_font' ) );
		$input['headings_font'] = ( array_key_exists( $input['headings_font'], $fonts ) ? $input['headings_font'] : pinboard_get_option( 'headings_font' ) );
		$input['content_font'] = ( array_key_exists( $input['content_font'], $fonts ) ? $input['content_font'] : pinboard_get_option( 'content_font' ) );
		$input['body_font_size'] = number_format( floatval( $input['body_font_size'] ), 2, '.', '' );
		$input['body_font_size_unit'] = ( in_array( $input['body_font_size_unit'], $units ) ? $input['body_font_size_unit'] : pinboard_get_option( 'body_font_size_unit' ) );
		$input['body_line_height'] = number_format( floatval( $input['body_line_height'] ), 2, '.', '' );
		$input['body_line_height_unit'] = ( in_array( $input['body_line_height_unit'], $units ) ? $input['body_line_height_unit'] : pinboard_get_option( 'body_line_height_unit' ) );
		$input['h1_font_size'] = number_format( floatval( $input['h1_font_size'] ), 2, '.', '' );
		$input['h1_font_size_unit'] = ( in_array( $input['h1_font_size_unit'], $units ) ? $input['h1_font_size_unit'] : pinboard_get_option( 'h1_font_size_unit' ) );
		$input['h2_font_size'] = number_format( floatval( $input['h2_font_size'] ), 2, '.', '' );
		$input['h2_font_size_unit'] = ( in_array( $input['h2_font_size_unit'], $units ) ? $input['h2_font_size_unit'] : pinboard_get_option( 'h2_font_size_unit' ) );
		$input['h3_font_size'] = number_format( floatval( $input['h3_font_size'] ), 2, '.', '' );
		$input['h3_font_size_unit'] = ( in_array( $input['h3_font_size_unit'], $units ) ? $input['h3_font_size_unit'] : pinboard_get_option( 'h3_font_size_unit' ) );
		$input['h4_font_size'] = number_format( floatval( $input['h4_font_size'] ), 2, '.', '' );
		$input['h4_font_size_unit'] = ( in_array( $input['h4_font_size_unit'], $units ) ? $input['h4_font_size_unit'] : pinboard_get_option( 'h4_font_size_unit' ) );
		$input['headings_line_height'] = number_format( floatval( $input['headings_line_height'] ), 2, '.', '' );
		$input['headings_line_height_unit'] = ( in_array( $input['headings_line_height_unit'], $units ) ? $input['headings_line_height_unit'] : pinboard_get_option( 'headings_line_height_unit' ) );
		$input['content_font_size'] = number_format( floatval( $input['content_font_size'] ), 2, '.', '' );
		$input['content_font_size_unit'] = ( in_array( $input['content_font_size_unit'], $units ) ? $input['content_font_size_unit'] : pinboard_get_option( 'content_font_size_unit' ) );
		$input['content_line_height'] = number_format( floatval( $input['content_line_height'] ), 2, '.', '' );
		$input['content_line_height_unit'] = ( in_array( $input['content_line_height_unit'], $units ) ? $input['content_line_height_unit'] : pinboard_get_option( 'content_line_height_unit' ) );
		$input['mobile_font_size'] = number_format( floatval( $input['mobile_font_size'] ), 2, '.', '' );
		$input['mobile_font_size_unit'] = ( in_array( $input['mobile_font_size_unit'], $units ) ? $input['mobile_font_size_unit'] : pinboard_get_option( 'mobile_font_size_unit' ) );
		$input['mobile_line_height'] = number_format( floatval( $input['mobile_line_height'] ), 2, '.', '' );
		$input['mobile_line_height_unit'] = ( in_array( $input['mobile_line_height_unit'], $units ) ? $input['mobile_line_height_unit'] : pinboard_get_option( 'mobile_line_height_unit' ) );
		$input['body_color'] = substr( $input['body_color'], 0, 7 );
		$input['headings_color'] = substr( $input['headings_color'], 0, 7 );
		$input['content_color'] = substr( $input['content_color'], 0, 7 );
		$input['links_color'] = substr( $input['links_color'], 0, 7 );
		$input['links_hover_color'] = substr( $input['links_hover_color'], 0, 7 );
		$input['menu_color'] = substr( $input['menu_color'], 0, 7 );
		$input['menu_hover_color'] = substr( $input['menu_hover_color'], 0, 7 );
		$input['sidebar_color'] = substr( $input['sidebar_color'], 0, 7 );
		$input['sidebar_title_color'] = substr( $input['sidebar_title_color'], 0, 7 );
		$input['sidebar_links_color'] = substr( $input['sidebar_links_color'], 0, 7 );
		$input['footer_color'] = substr( $input['footer_color'], 0, 7 );
		$input['footer_title_color'] = substr( $input['footer_title_color'], 0, 7 );
		$input['copyright_color'] = substr( $input['copyright_color'], 0, 7 );
		$input['copyright_links_color'] = substr( $input['copyright_links_color'], 0, 7 );
	} elseif( isset( $input['submit-seo'] ) || isset( $input['reset-seo'] ) ) {
		$tags = array( 'h1', 'h2', 'h3', 'p', 'div' );
		foreach( $input as $key => $tag )
			if( ( 'reset-seo' != $key ) && ! in_array( $tag, $tags ) )
				$input[$key] = pinboard_get_option( $key );
	}
	if( isset( $input['reset-general'] ) || isset( $input['reset-layout'] ) || isset( $input['reset-design'] ) || isset( $input['reset-typography'] ) || isset( $input['reset-seo'] ) ) {
		$default_options = pinboard_default_options();
		foreach( $input as $name => $value )
			if( 'reset-general' != $name  && 'reset-design' != $name && 'reset-layout' != $name && 'reset-typography' != $name && 'reset-seo' != $name )
				$input[$name] = $default_options[$name];
	}
	$input = wp_parse_args( $input, get_option( 'pinboard_theme_options', pinboard_default_options() ) );
	return $input;
}