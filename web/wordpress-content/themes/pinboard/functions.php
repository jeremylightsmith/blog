<?php

/**
 * Load the theme options page if in admin mode
 */
if ( is_admin() && is_readable( get_template_directory() . '/includes/theme-options.php' ) )
	require_once( get_template_directory() . '/includes/theme-options.php' );

if ( ! function_exists( 'pinboard_theme_setup' ) ) :
/*
 * Set up theme specific settings
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_image_size() To set custom image sizes.
 *
 * @since Pinboard 1.0
 */
function pinboard_theme_setup() {

	// Set default content width based on the theme's layout. This affects the width of post images and embedded media.
	global $content_width;
	if( ! isset( $content_width ) ) $content_width = 660;
	
	// Automatically add feed links to document head
	add_theme_support( 'automatic-feed-links' );
	
	// Register Primary Navigation Menu
	register_nav_menus(
		array(
			'primary_nav' => 'Primary Menu', // You can add more menus here
		)
	);
	
	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	
	// Add support for post thumbnails and custom image sizes specific to theme locations
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'slider-thumb', 1140, 395, 1 );
	add_image_size( 'blog-thumb', 700, ( pinboard_get_option( 'crop_thumbnails' ) ? 300 : 9999 ), ( pinboard_get_option( 'crop_thumbnails' ) ? 1 : 0 ) );
	add_image_size( 'teaser-thumb', 332, ( pinboard_get_option( 'crop_thumbnails' ) ? 205 : 9999 ), ( pinboard_get_option( 'crop_thumbnails' ) ? 1 : 0 ) );
	add_image_size( 'gallery-1-thumb', 432, 432, 1 );
	add_image_size( 'gallery-2-thumb', 268, 268, 1 );
	add_image_size( 'gallery-3-thumb', 268, 164, 1 );
	add_image_size( 'image-thumb', 700, 9999 );
	add_image_size( 'video-thumb', 700, 393, 1 );
	
	// Allows users to set a custom header image
	add_theme_support( 'custom-header', array(
		'width' => ( pinboard_get_option( 'retina_header' ) ? 392 : 196 ),
		'height' => ( pinboard_get_option( 'retina_header' ) ? 96 : 48 ),
		'default-text-color' => '333',
		'flex-width' => true,
		'flex-height' => true,
		'wp-head-callback' => 'pinboard_header_style',
		'admin-head-callback' => 'pinboard_admin_header_style',
		'admin-preview-callback' => 'pinboard_admin_header_image'
	) );
	
	// Allows users to set a custom background
	add_theme_support( 'custom-background', array(
		'default-image' => get_template_directory_uri() . '/images/bg.jpg',
	) );
	
	// Styles the post editor
	add_editor_style();
	
	// Makes theme translation ready
	load_theme_textdomain( 'pinboard', get_template_directory() . '/languages' );
	
}
endif;

add_action( 'after_setup_theme', 'pinboard_theme_setup' );

if ( ! function_exists( 'pinboard_widgets_init' ) ) :
/**
 * Registers theme widget areas
 *
 * @uses register_sidebar()
 *
 * @since Pinboard 1.0
 */
function  pinboard_widgets_init() {
	$title_tag = pinboard_get_option( 'widget_title_tag' );
	
	register_sidebar(
		array(
			'name' => 'Header',
			'description' => 'Displays in the header. Intended exclusively for displaying ads of standard dimentions.',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Top',
			'description' => 'Displays in in the main sidebar stacked at the top.',
			'before_widget' => '<div class="column onecol"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget --></div>',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Left',
			'description' => 'Displays in in the main sidebar floated to the left.',
			'before_widget' => '<div class="column onecol"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget --></div>',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Right',
			'description' => 'Displays in in the main sidebar floated to the right.',
			'before_widget' => '<div class="column onecol"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget --></div>',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Bottom',
			'description' => 'Displays in in the main sidebar stacked at the bottom.',
			'before_widget' => '<div class="column onecol"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget --></div>',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	$columns = pinboard_get_option( 'footer_columns' );
	if( 1 == $columns )
		$grid_class = 'onecol';
	elseif( 2 == $columns )
		$grid_class = 'twocol';
	elseif( 3 == $columns )
		$grid_class = 'threecol';
	elseif( 4 == $columns )
		$grid_class = 'fourcol';
	register_sidebar(
		array(
			'name' => 'Footer',
			'description' => 'Displays in in the footer area.',
			'before_widget' => '<div class="column ' . $grid_class . '"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget --></div>',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => '404 Page',
			'description' => 'Displays on 404 Pages in the content area.',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Wide',
			'description' => 'Displays on the front page and spans full width.',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	$columns = pinboard_get_option( 'boxes_columns' );
	if( 1 == $columns )
		$grid_class = 'onecol';
	elseif( 2 == $columns )
		$grid_class = 'twocol';
	elseif( 3 == $columns )
		$grid_class = 'threecol';
	elseif( 4 == $columns )
		$grid_class = 'fourcol';
	register_sidebar(
		array(
			'name' => 'Boxes',
			'before_widget' => '<div class="column ' . $grid_class . '"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget --></div>',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Footer Wide',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
}
endif;

add_action( 'widgets_init', 'pinboard_widgets_init' );

if ( ! function_exists( 'pinboard_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Pinboard 1.0
 */
function pinboard_header_style() { ?>
<style type="text/css">
<?php if ( 'blank' == get_header_textcolor() ) : ?>
	#site-title .home,
	#site-description {
		position:absolute !important;
		clip:rect(1px, 1px, 1px, 1px);
	}
<?php else : ?>
	#site-title a,
	#site-description {
		color:#<?php header_textcolor(); ?>;
	}
<?php endif; ?>
</style>
<?php
}
endif;

if ( ! function_exists( 'pinboard_admin_header_style' ) ) :
/**
 * Shows the header image preview in the admin panel.
 *
 * @since Pinboard 1.0
 */
function pinboard_admin_header_style() {
	$header_image = get_header_image(); ?>
<style type="text/css">
	@import url("<?php echo ( is_ssl() ? 'https' : 'http' ); ?>://fonts.googleapis.com/css?family=Oswald:300|Open+Sans:normal&subset=latin");
	.appearance_page_custom-header #headimg {
		max-width:1132px;
		width:100%;
		border:none;
	}
	#headimg {
		padding:0 20px;
		background:#F8F8F8;
	}
	#headimg h1 {
		float:left;
		margin:0;
		font-family:"Oswald", sans-serif;
		font-size:32px;
		font-weight:bold;
		line-height:120px;
	}
	#headimg h1 a {
		text-decoration:none;
	}
	#desc {
		float:left;
		margin-left:20px;
		font-family:"Open Sans", sans-serif;
		font-size:12px;
		font-weight:normal;
		line-height:120px;
	}
	#headimg img {
		max-width: 100%;
		height: auto;
		margin: 38px 0;
		vertical-align:middle;
	}
	#headimg h1 a,
	#desc {
		color:#<?php header_textcolor() ?>;
	}
</style>
<?php
}
endif;

if ( ! function_exists( 'pinboard_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @since Pinboard 1.0
 */
function pinboard_admin_header_image() {
	if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
		$style = ' style="display:none;"';
	else
		$style = ' style="color:#' . get_header_textcolor() . ';"';
		$header_image = get_header_image(); ?>
<div id="headimg">
	<h1>
		<?php if ( ! empty( $header_image ) ) : ?>
			<a id="name" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo ( pinboard_get_option( 'retina_header' ) ? absint( get_custom_header()->width / 2 ) : get_custom_header()->width ); ?>" height="<?php echo ( pinboard_get_option( 'retina_header' ) ? absint( get_custom_header()->height / 2 ) : get_custom_header()->height ); ?>" />
			</a>
		<?php endif; ?>
		<a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
	</h1>
	<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	<div class="clear"></div>
</div>
<?php
}
endif;

if ( ! function_exists( 'pinboard_default_options' ) ) :
/**
 * Returns an array of theme default options.
 *
 * @since Pinboard 1.0
 */
function pinboard_default_options() {
	$options = array(
		'home_page_excerpts' => 2,
		'slider' => true,
		'location' => true,
		'retina_header' => false,
		'crop_thumbnails' => false,
		'lightbox' => true,
		'facebook_link' => '',
		'twitter_link' => '',
		'pinterest_link' => '',
		'flickr_link' => '',
		'youtube_link' => '',
		'vimeo_link' => '',
		'googleplus_link' => '',
		'dribble_link' => '',
		'linkedin_link' => '',
		'portfolio_cat' => -1,
		'portfolio_filter' => true,
		'portfolio_excerpts' => 0,
		'portfolio_archive_excerpts' => 0,
		'portfolio_columns' => 3,
		'portfolio_meta' => true,
		'blog_exclude_portfolio' => true,
		'location' => true,
		'archive_excerpts' => 0,
		'posts_nav' => 'infinite',
		'posts_nav_labels' => 'older/newer',
		'fancy_dropdowns' => true,
		'facebook' => true,
		'twitter' => true,
		'google' => true,
		'pinterest' => true,
		'author_box' => false,
		'copyright_notice' => '&copy; %year% %blogname%',
		'theme_credit_link' => true,
		'author_credit_link' => false,
		'wordpress_credit_link' => true,
		'page_background' => '#f8f8f8',
		'menu_background' => '#111',
		'submenu_background' => '#333',
		'sidebar_wide_background' => '#eee',
		'content_background' => '#fff',
		'post_meta_background' => '#fcfcfc',
		'footer_area_background' => '#222',
		'footer_background' => '#111',
		'layout' => 'content-sidebar',
		'layout_columns' => 3,
		'boxes_columns' => 3,
		'footer_columns' => 3,
		'hide_sidebar' => false,
		'hide_footer_area' => false,
		'user_css' => '',
		'body_font' => 'open-sans',
		'headings_font' => 'oswald',
		'content_font' => 'open-sans',
		'body_font_size' => '13',
		'body_font_size_unit' => 'px',
		'body_line_height' => '1.62',
		'body_line_height_unit' => 'em',
		'h1_font_size' => '36',
		'h1_font_size_unit' => 'px',
		'h2_font_size' => '32',
		'h2_font_size_unit' => 'px',
		'h3_font_size' => '24',
		'h3_font_size_unit' => 'px',
		'h4_font_size' => '18',
		'h4_font_size_unit' => 'px',
		'headings_line_height' => '1.62',
		'headings_line_height_unit' => 'em',
		'content_font_size' => '15',
		'content_font_size_unit' => 'px',
		'content_line_height' => '1.62',
		'content_line_height_unit' => 'em',
		'mobile_font_size' => '17',
		'mobile_font_size_unit' => 'px',
		'mobile_line_height' => '1.62',
		'mobile_line_height_unit' => 'em',
		'body_color' => '#333',
		'headings_color' => '#333',
		'content_color' => '#333',
		'links_color' => '#21759b',
		'links_hover_color' => '#d54e21',
		'menu_color' => '#f0f0f0',
		'menu_hover_color' => '#fff',
		'sidebar_color' => '#ccc',
		'sidebar_title_color' => '#ccc',
		'sidebar_links_color' => '#7597B9',
		'footer_color' => '#ccc',
		'footer_title_color' => '#e0e0e0',
		'copyright_color' => '#ccc',
		'copyright_links_color' => '#7597B9',
		'home_site_title_tag' => 'h1',
		'home_desc_title_tag' => 'div',
		'home_post_title_tag' => 'h2',
		'archive_site_title_tag' => 'div',
		'archive_desc_title_tag' => 'div',
		'archive_location_title_tag' => 'h1',
		'archive_post_title_tag' => 'h2',
		'single_site_title_tag' => 'div',
		'single_desc_title_tag' => 'div',
		'single_post_title_tag' => 'h1',
		'single_comments_title_tag' => 'h2',
		'single_respond_title_tag' => 'h2',
		'widget_title_tag' => 'h3',
	);
	return $options;
}
endif;

if ( ! function_exists( 'pinboard_get_option' ) ) :
/**
 * Used to output theme options is an elegant way
 *
 * @uses get_option() To retrieve the options array
 *
 * @since Pinboard 1.0
 */
function pinboard_get_option( $option ) {
	global $pinboard_options, $pinboard_default_options;
	if( ! isset( $pinboard_default_options ) )
		$pinboard_default_options = pinboard_default_options();
	if( ! isset( $pinboard_options ) )
		$pinboard_options = get_option( 'pinboard_theme_options', $pinboard_default_options );
	if( ! isset( $pinboard_options[ $option ] ) )
		return $pinboard_default_options[ $option ];
	return $pinboard_options[ $option ];
}
endif;

if ( ! function_exists( 'pinboard_available_fonts' ) ) :
/**
 * Returns an array of fonts available to the theme.
 *
 * @since Pinboard 1.0
 */
function pinboard_available_fonts() {
	return array(
		'helvetica' => '"Helvetica Neue", "Nimbus Sans L", sans-serif',
		'verdana' => 'Geneva, Verdana, "DejaVu Sans", sans-serif',
		'tahoma' => 'Tahoma, "DejaVu Sans", sans-serif',
		'trebuchet' => '"Trebuchet MS", "Bitstream Vera Sans", sans-serif',
		'lucida-grande' => '"Lucida Grande", "Lucida Sans Unicode", "Bitstream Vera Sans", sans-serif',
		'droid-sans' => '"Droid Sans", sans-serif',
		'lato' => '"Lato", sans-serif',
		'pt-sans' => '"PT Sans", sans-serif',
		'cantarell' => '"Cantarell", sans-serif',
		'open-sans' => '"Open Sans", sans-serif',
		'oswald' => '"Oswald", sans-serif',
		'yanone-kaffeesatz' => '"Yanone Kaffeesatz", sans-serif',
		'quattrocento-sans' => '"Quattrocento Sans", sans-serif',
		'georgia' => 'Georgia, "URW Bookman L", serif',
		'times' => 'Times, "Times New Roman", "Century Schoolbook L", serif',
		'palatino' => 'Palatino, "Palatino Linotype", "URW Palladio L", serif',
		'droid-serif' => '"Droid Serif", serif',
		'lora' => '"Lora", serif',
		'pt-serif' => '"PT Serif", serif',
		'courier' => 'Courier, "Courier New", "Nimbus Mono L", monospace',
		'monaco' => 'Monaco, Consolas, "Lucida Console", "Bitstream Vera Sans Mono", monospace',
	);
}
endif;

if ( ! function_exists( 'pinboard_filter_query' ) ) :
/**
 * Filter the main loop
 *
 * Allows overriding of query parameters
 * for the main loop without performing
 * additional database queries
 *
 * @since Pinboard 1.0
 */
function pinboard_filter_query( $query ) {
	global $wp_the_query;
	if( $wp_the_query === $query ) {
		if( $query->is_home() && pinboard_get_option( 'slider' ) )
			$query->set( 'ignore_sticky_posts', 1 );
		if( $query->is_home() && pinboard_get_option( 'blog_exclude_portfolio' ) )
			$query->set( 'cat', '-' . pinboard_get_option( 'portfolio_cat' ) );
	}
}
endif;

add_action( 'pre_get_posts', 'pinboard_filter_query' );

if ( ! function_exists( 'pinboard_register_styles' ) ) :
/**
 * Register theme styles
 *
 * Registers stylesheets used by the theme.
 * Also offers integration with Google Web Fonts Directory
 * @uses wp_register_style() To register styles
 *
 * @since Pinboard 1.0.
 */
function pinboard_register_styles() {
	$web_fonts = array(
		'droid-sans' => 'Droid+Sans',
		'lato' => 'Lato',
		'pt-sans' => 'PT+Sans',
		'cantarell' => 'Cantarell',
		'open-sans' => 'Open+Sans',
		'oswald' => 'Oswald',
		'yanone-kaffeesatz' => 'Yanone+Kaffeesatz',
		'quattrocento-sans' => 'Quattrocento+Sans',
		'droid-serif' => 'Droid+Serif',
		'lora' => 'Lora',
		'pt-serif' => 'PT+Serif'
	);
	if( array_key_exists( pinboard_get_option( 'body_font' ), $web_fonts ) || in_array( pinboard_get_option( 'headings_font' ), $web_fonts )|| in_array( pinboard_get_option( 'content_font' ), $web_fonts ) ) {
		$web_fonts_stylesheet = 'http' . ( is_ssl() ? 's' : '' ) . '://fonts.googleapis.com/css?family=';
		if( array_key_exists( pinboard_get_option( 'body_font' ), $web_fonts ) ) {
			$web_fonts_stylesheet .= $web_fonts[pinboard_get_option( 'body_font' )] . ':300,300italic,regular,italic,600,600italic';
		}
		if( ( pinboard_get_option( 'headings_font' ) != pinboard_get_option( 'body_font' ) ) && array_key_exists( pinboard_get_option( 'headings_font' ), $web_fonts ) ) {
			$web_fonts_stylesheet .= '|' . $web_fonts[pinboard_get_option( 'headings_font' )] . ':300,300italic,regular,italic,600,600italic';
		}
		if( ( pinboard_get_option( 'content_font' ) != pinboard_get_option( 'body_font' ) ) && ( pinboard_get_option( 'content_font' ) != pinboard_get_option( 'headings_font' ) ) && array_key_exists( pinboard_get_option( 'content_font' ), $web_fonts ) ) {
			$web_fonts_stylesheet .= '|' . $web_fonts[pinboard_get_option( 'content_font' )] . ':300,300italic,regular,italic,600,600italic';
		}
		$web_fonts_stylesheet .= '&subset=latin';
	} else
		$web_fonts_stylesheet = false;
	if( false !== $web_fonts_stylesheet ) {
		wp_register_style( 'pinboard-web-font', $web_fonts_stylesheet, false, null );
		$pinboard_deps = array( 'pinboard-web-font' );
	} else
		$pinboard_deps = false;
	wp_register_style( 'pinboard', get_stylesheet_uri(), $pinboard_deps, null );
	wp_register_style( 'colorbox', get_template_directory_uri() . '/styles/colorbox.css', false, null );
	wp_register_style( 'mediaelementplayer', get_template_directory_uri() . '/styles/mediaelementplayer.css', false, null );
}
endif;

add_action( 'init', 'pinboard_register_styles' );

if ( ! function_exists( 'pinboard_enqueue_styles' ) ) :
/**
 * Enqueue theme styles
 *
 * @uses wp_enqueue_style() To enqueue styles
 *
 * @since Pinboard 1.0
 */
function pinboard_enqueue_styles() {
	//wp_enqueue_style( 'pinboard-web-font' );
	wp_enqueue_style( 'pinboard' );
	if( pinboard_get_option( 'lightbox' ) )
		wp_enqueue_style( 'colorbox' );
	wp_enqueue_style( 'mediaelementplayer' );
}
endif;

add_action( 'wp_enqueue_scripts', 'pinboard_enqueue_styles' );

if ( ! function_exists( 'pinboard_register_scripts' ) ) :
/**
 * Register theme scripts
 *
 * @uses wp_register_scripts() To register scripts
 *
 * @since Pinboard 1.0
 */
function pinboard_register_scripts() {
	wp_register_script( 'ios-orientationchange-fix', get_template_directory_uri() . '/scripts/ios-orientationchange-fix.js', false, null );
	wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/scripts/jquery-migrate.js', array( 'jquery' ), null );
	wp_register_script( 'flexslider', get_template_directory_uri() . '/scripts/jquery.flexslider-min.js', array( 'jquery' ), null );
	wp_register_script( 'masonry', get_template_directory_uri() . '/scripts/jquery.masonry.min.js', array( 'jquery-migrate' ), null );
	wp_register_script( 'colorbox', get_template_directory_uri() . '/scripts/colorbox.js', array( 'jquery-migrate' ), null );
	wp_register_script( 'fitvids', get_template_directory_uri() . '/scripts/fitvids.js', array( 'jquery' ), null );
	wp_register_script( 'mediaelement', get_template_directory_uri() . '/scripts/mediaelement.js', array( 'jquery' ), null );
	wp_register_script( 'mediaelementplayer', get_template_directory_uri() . '/scripts/mediaelementplayer.js', array( 'mediaelement' ), null );
	wp_register_script( 'infinitescroll', get_template_directory_uri() . '/scripts/jquery.infinitescroll.js', array( 'jquery-migrate' ), null );
}
endif;

add_action( 'init', 'pinboard_register_scripts' );

if ( ! function_exists( 'pinboard_enqueue_scripts' ) ) :
/**
 * Enqueue theme scripts
 *
 * @uses wp_enqueue_scripts() To enqueue scripts
 *
 * @since Pinboard 1.0
 */
function pinboard_enqueue_scripts() {
	wp_enqueue_script( 'ios-orientationchange-fix' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-migrate' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'fitvids' );
	wp_enqueue_script( 'mediaelementplayer' );
	if( 'infinite' == pinboard_get_option( 'posts_nav' ) && ! is_singular() && ! is_paged() || ( is_page_template( 'template-blog.php' ) || is_page_template( 'template-blog-full-width.php' ) || is_page_template( 'template-blog-four-col.php' ) || is_page_template( 'template-blog-left-sidebar.php' ) || is_page_template( 'template-blog-no-sidebars.php' ) || is_page_template( 'template-portfolio.php' ) || is_page_template( 'template-portfolio-right-sidebar.php' ) || is_page_template( 'template-portfolio-four-col.php' ) || is_page_template( 'template-portfolio-left-sidebar.php' ) || is_page_template( 'template-portfolio-no-sidebars.php' ) && ! is_paged() ) )
		wp_enqueue_script( 'infinitescroll' );
	if( ! is_singular() || is_page_template( 'template-blog.php' ) || is_page_template( 'template-blog-full-width.php' ) || is_page_template( 'template-blog-four-col.php' ) || is_page_template( 'template-blog-left-sidebar.php' ) || is_page_template( 'template-blog-no-sidebars.php' ) || is_page_template( 'template-blog-no-sidebars.php' ) || is_page_template( 'template-portfolio.php' ) || is_page_template( 'template-portfolio-right-sidebar.php' ) || is_page_template( 'template-portfolio-four-col.php' ) || is_page_template( 'template-portfolio-left-sidebar.php' ) || is_page_template( 'template-portfolio-no-sidebars.php' ) )
		wp_enqueue_script( 'masonry' );
	if( pinboard_get_option( 'lightbox' ) )
		wp_enqueue_script( 'colorbox' );
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
endif;

add_action( 'wp_enqueue_scripts', 'pinboard_enqueue_scripts' );

if ( ! function_exists( 'pinboard_html5_shiv' ) ) :
/**
 * Outputs the html5.js script with IE conditionals
 *
 * @since Pinboard 1.0
 */
function pinboard_html5_shiv() { ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/scripts/html5.js" type="text/javascript"></script>
	<![endif]-->
<?php
}
endif;

add_action( 'wp_print_scripts', 'pinboard_html5_shiv' );

if ( ! function_exists( 'pinboard_call_scripts' ) ) :
/**
 * Call script functions in document head
 *
 * @since Pinboard 1.0
 */
function pinboard_call_scripts() { ?>
<script>
/* <![CDATA[ */
	jQuery(document).ready(function($) {
		$('#access .menu > li > a').each(function() {
			var title = $(this).attr('title');
			if(typeof title !== 'undefined' && title !== false) {
				$(this).append('<br /> <span>'+title+'</span>');
				$(this).removeAttr('title');
			}
		});
		function pinboard_move_elements(container) {
			if( container.hasClass('onecol') ) {
				var thumb = $('.entry-thumbnail', container);
				if('undefined' !== typeof thumb)
					$('.entry-container', container).before(thumb);
				var video = $('.entry-attachment', container);
				if('undefined' !== typeof video)
					$('.entry-container', container).before(video);
				var gallery = $('.post-gallery', container);
				if('undefined' !== typeof gallery)
					$('.entry-container', container).before(gallery);
				var meta = $('.entry-meta', container);
				if('undefined' !== typeof meta)
					$('.entry-container', container).after(meta);
			}
		}
		function pinboard_restore_elements(container) {
			if( container.hasClass('onecol') ) {
				var thumb = $('.entry-thumbnail', container);
				if('undefined' !== typeof thumb)
					$('.entry-header', container).after(thumb);
				var video = $('.entry-attachment', container);
				if('undefined' !== typeof video)
					$('.entry-header', container).after(video);
				var gallery = $('.post-gallery', container);
				if('undefined' !== typeof gallery)
					$('.entry-header', container).after(gallery);
				var meta = $('.entry-meta', container);
				if('undefined' !== typeof meta)
					$('.entry-header', container).append(meta);
				else
					$('.entry-header', container).html(meta.html());
			}
		}
		if( ($(window).width() > 960) || ($(document).width() > 960) ) {
			// Viewport is greater than tablet: portrait
		} else {
			$('#content .post').each(function() {
				pinboard_move_elements($(this));
			});
		}
		$(window).resize(function() {
			if( ($(window).width() > 960) || ($(document).width() > 960) ) {
				<?php if( is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
					$('#content .post').each(function() {
						pinboard_restore_elements($(this));
					});
				<?php else : ?>
					$('.page-template-template-full-width-php #content .post, .page-template-template-blog-full-width-php #content .post, .page-template-template-blog-four-col-php #content .post').each(function() {
						pinboard_restore_elements($(this));
					});
				<?php endif; ?>
			} else {
				$('#content .post').each(function() {
					pinboard_move_elements($(this));
				});
			}
			if( ($(window).width() > 760) || ($(document).width() > 760) ) {
				var maxh = 0;
				$('#access .menu > li > a').each(function() {
					if(parseInt($(this).css('height'))>maxh) {
						maxh = parseInt($(this).css('height'));
					}
				});
				$('#access .menu > li > a').css('height', maxh);
			} else {
				$('#access .menu > li > a').css('height', 'auto');
			}
		});
		if( ($(window).width() > 760) || ($(document).width() > 760) ) {
			var maxh = 0;
			$('#access .menu > li > a').each(function() {
				var title = $(this).attr('title');
				if(typeof title !== 'undefined' && title !== false) {
					$(this).append('<br /> <span>'+title+'</span>');
					$(this).removeAttr('title');
				}
				if(parseInt($(this).css('height'))>maxh) {
					maxh = parseInt($(this).css('height'));
				}
			});
			$('#access .menu > li > a').css('height', maxh);
			<?php if( pinboard_get_option( 'fancy_dropdowns' ) ) : ?>
				$('#access li').mouseenter(function() {
					$(this).children('ul').css('display', 'none').stop(true, true).fadeIn(250).css('display', 'block').children('ul').css('display', 'none');
				});
				$('#access li').mouseleave(function() {
					$(this).children('ul').stop(true, true).fadeOut(250).css('display', 'block');
				});
			<?php endif; ?>
		} else {
			$('#access li').each(function() {
				if($(this).children('ul').length)
					$(this).append('<span class="drop-down-toggle"><span class="drop-down-arrow"></span></span>');
			});
			$('.drop-down-toggle').click(function() {
				$(this).parent().children('ul').slideToggle(250);
			});
		}
		<?php if( ( is_home() && ! is_paged() ) || ( is_front_page() && ! is_home() ) || is_page_template( 'template-landing-page.php' ) ) : ?>
			$('#slider').flexslider({
				selector: '.slides > li',
				video: true,
				prevText: '&larr;',
				nextText: '&rarr;',
				pausePlay: true,
				pauseText: '||',
				playText: '>',
				before: function() {
					$('#slider .entry-title').hide();
				},
				after: function() {
					$('#slider .entry-title').fadeIn();
				}
			});
		<?php endif; ?>
		<?php if( ! is_singular() || is_page_template( 'template-blog.php' ) || is_page_template( 'template-blog-full-width.php' ) || is_page_template( 'template-blog-four-col.php' ) || is_page_template( 'template-blog-left-sidebar.php' ) || is_page_template( 'template-blog-no-sidebars.php' ) || is_page_template( 'template-blog-no-sidebars.php' ) || is_page_template( 'template-portfolio.php' ) || is_page_template( 'template-portfolio-right-sidebar.php' ) || is_page_template( 'template-portfolio-four-col.php' ) || is_page_template( 'template-portfolio-left-sidebar.php' ) || is_page_template( 'template-portfolio-no-sidebars.php' ) ) : ?>
			var $content = $('.entries');
			$content.imagesLoaded(function() {
				$content.masonry({
					itemSelector : '.post',
					columnWidth : function( containerWidth ) {
						return containerWidth / 12;
					},
				});
			});
			<?php if( ( ! is_singular() && ! is_paged() ) || ( ( is_page_template( 'template-blog.php' ) || is_page_template( 'template-blog-full-width.php' ) || is_page_template( 'template-blog-four-col.php' ) || is_page_template( 'template-blog-left-sidebar.php' ) || is_page_template( 'template-blog-no-sidebars.php' ) || is_page_template( 'template-blog-no-sidebars.php' ) || is_page_template( 'template-portfolio.php' ) || is_page_template( 'template-portfolio-right-sidebar.php' ) || is_page_template( 'template-portfolio-four-col.php' ) || is_page_template( 'template-portfolio-left-sidebar.php' ) || is_page_template( 'template-portfolio-no-sidebars.php' ) ) && ! is_paged() ) ) : ?>
				<?php if( 'ajax' == pinboard_get_option( 'posts_nav' ) ) : ?>
					var nav_link = $('#posts-nav .nav-all a');
					if(!nav_link.length)
						var nav_link = $('#posts-nav .nav-next a');
					if(nav_link.length) {
						nav_link.addClass('ajax-load');
						nav_link.html('Load more posts');
						nav_link.click(function() {
							var href = $(this).attr('href');
							nav_link.html('<img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" style="float: none; vertical-align: middle;" /> Loading more posts &#8230;');
							$.get(href, function(data) {
								var helper = document.createElement('div');
								helper = $(helper);
								helper.html(data);
								var content = $('#content .entries', helper);
								$('.entries').append(content.html());
								var nav_url = $('#posts-nav .nav-next a', helper).attr('href');
								if(typeof nav_url !== 'undefined') {
									nav_link.attr('href', nav_url);
									nav_link.html('Load more posts');
								} else {
									$('#posts-nav').html('<span class="ajax-load">There are no more posts to display.</span>');
								}
							});
							return false;
						});
					}
				<?php elseif( 'infinite' == pinboard_get_option( 'posts_nav' ) ) : ?>
					$('#content .entries').infinitescroll({
						debug           : false,
						nextSelector    : "#posts-nav .nav-all a, #posts-nav .nav-next a",
						loadingImg      : ( window.devicePixelRatio > 1 ? "<?php echo get_template_directory_uri(); ?>/images/ajax-loading_2x.gif" : "<?php echo get_template_directory_uri(); ?>/images/ajax-loading.gif" ),
						loadingText     : "Loading more posts &#8230;",
						donetext        : "There are no more posts to display.",
						navSelector     : "#posts-nav",
						contentSelector : "#content .entries",
						itemSelector    : "#content .entries .post",
					}, function(entries){
						var $entries = $( entries ).css({ opacity: 0 });
						$entries.imagesLoaded(function(){
							$entries.animate({ opacity: 1 });
							$content.masonry( 'appended', $entries, true );
						});
						if( ($(window).width() > 960) || ($(document).width() > 960) ) {
							// Viewport is greater than tablet: portrait
						} else {
							$('#content .post').each(function() {
								pinboard_move_elements($(this));
							});
						}
						$('audio,video').mediaelementplayer({
							videoWidth: '100%',
							videoHeight: '100%',
							audioWidth: '100%',
							alwaysShowControls: true,
							features: ['playpause','progress','tracks','volume'],
							videoVolume: 'horizontal'
						});
						$(".entry-attachment, .entry-content").fitVids({ customSelector: "iframe, object, embed"});
						<?php if( pinboard_get_option( 'lightbox' ) ) : ?>
							$('.entry-content a[href$=".jpg"],.entry-content a[href$=".jpeg"],.entry-content a[href$=".png"],.entry-content a[href$=".gif"],a.colorbox').colorbox();
						<?php endif; ?>
					});
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
		$('audio,video').mediaelementplayer({
			videoWidth: '100%',
			videoHeight: '100%',
			audioWidth: '100%',
			alwaysShowControls: true,
			features: ['playpause','progress','tracks','volume'],
			videoVolume: 'horizontal'
		});
		$(".entry-attachment, .entry-content").fitVids({ customSelector: "iframe, object, embed"});
	});
	jQuery(window).load(function() {
		<?php if( pinboard_get_option( 'lightbox' ) ) : ?>
			jQuery('.entry-content a[href$=".jpg"],.entry-content a[href$=".jpeg"],.entry-content a[href$=".png"],.entry-content a[href$=".gif"],a.colorbox').colorbox();
		<?php endif; ?>
	});
/* ]]> */
</script>
<?php
}
endif;

add_action( 'wp_head', 'pinboard_call_scripts' );

if ( ! function_exists( 'pinboard_custom_styles' ) ) :
/**
 * Custom style declarations
 *
 * Outputs CSS declarations generated by theme options
 * and custom user defined CSS in the document <head>
 *
 * @since Pinboard 1.0
 */
function pinboard_custom_styles() {
	$default_options = pinboard_default_options();
	$fonts = pinboard_available_fonts(); ?>
<style type="text/css">
	<?php if( '' == pinboard_get_option( 'facebook_link' ) && '' == pinboard_get_option( 'twitter_link' ) && '' == pinboard_get_option( 'pinterest_link' ) && '' == pinboard_get_option( 'vimeo_link' ) && '' == pinboard_get_option( 'youtube_link' ) && '' == pinboard_get_option( 'flickr_link' ) && '' == pinboard_get_option( 'googleplus_link' ) && '' == pinboard_get_option( 'dribble_link' ) && '' == pinboard_get_option( 'linkedin_link' ) ) : ?>
		#header input#s {
			width:168px;
			box-shadow:inset 1px 1px 5px 1px rgba(0, 0, 0, .1);
			text-indent: 0;
		}
	<?php endif; ?>
	<?php if( is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
		.post.onecol .entry-header {
			float:left;
			width:27.6%;
		}
		.post.onecol .entry-summary {
			float:right;
			width:69.5%;
		}
		.post.onecol .wp-post-image,
		.post.onecol .entry-attachment,
		.post.onecol .post-gallery {
			float:right;
			max-width:69.5%;
		}
		.post.onecol .entry-attachment,
		.post.onecol .post-gallery {
			width:69.5%;
		}
		.twocol .entry-title,
		.threecol .entry-title,
		.fourcol .entry-title {
			margin: 0;
			text-align: center;
		}
		@media screen and (max-width: 960px) {
			.post.onecol .wp-post-image,
			.post.onecol .entry-attachment,
			.post.onecol .post-gallery {
				float:none;
				max-width:100%;
				margin:0;
			}
			.post.onecol .entry-attachment,
			.post.onecol .post-gallery {
				width:100%;
			}
			.post.onecol .entry-header,
			.post.onecol .entry-summary {
				float:none;
				width:auto;
			}
		}
	<?php endif; ?>
	<?php if( pinboard_get_option( 'hide_sidebar' ) ) : ?>
		@media screen and (max-width: 760px) {
			#sidebar {
				display: none;
			}
		}
	<?php endif; ?>
	<?php if( pinboard_get_option( 'hide_footer_area' ) ) : ?>
		@media screen and (max-width: 760px) {
			#footer-area {
				display: none;
			}
		}
	<?php endif; ?>
	<?php if( $default_options['page_background'] != pinboard_get_option( 'page_background' ) ) : ?>
		#wrapper {
			background: <?php echo esc_attr( pinboard_get_option( 'page_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['menu_background'] != pinboard_get_option( 'menu_background' ) ) : ?>
		#header {
			border-color: <?php echo esc_attr( pinboard_get_option( 'menu_background' ) ); ?>;
		}
		#access {
			background: <?php echo esc_attr( pinboard_get_option( 'menu_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['submenu_background'] != pinboard_get_option( 'submenu_background' ) ) : ?>
		#access li li {
			background: <?php echo esc_attr( pinboard_get_option( 'submenu_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['sidebar_wide_background'] != pinboard_get_option( 'sidebar_wide_background' ) ) : ?>
		#sidebar-wide,
		#sidebar-footer-wide,
		#current-location {
			background: <?php echo esc_attr( pinboard_get_option( 'sidebar_wide_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['content_background'] != pinboard_get_option( 'content_background' ) ) : ?>
		.entry,
		#comments,
		#respond,
		#posts-nav {
			background: <?php echo esc_attr( pinboard_get_option( 'content_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['post_meta_background'] != pinboard_get_option( 'post_meta_background' ) ) : ?>
		.home .entry-meta,
		.blog .entry-meta,
		.archive .entry-meta,
		.search .entry-meta {
			background: <?php echo esc_attr( pinboard_get_option( 'post_meta_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['footer_area_background'] != pinboard_get_option( 'footer_area_background' ) ) : ?>
		#footer-area {
			background: <?php echo esc_attr( pinboard_get_option( 'footer_area_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['footer_background'] != pinboard_get_option( 'footer_background' ) ) : ?>
		#copyright {
			background: <?php echo esc_attr( pinboard_get_option( 'footer_background' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['body_font'] != pinboard_get_option( 'body_font' ) ) : ?>
		body,
		#slider .entry-title,
		.page-title,
		#sidebar-wide .widget-title,
		#sidebar-boxes .widget-title,
		#sidebar-footer-wide .widget-title {
			font-family:<?php echo $fonts[pinboard_get_option( 'body_font' )]; ?>;
		}
		h1, h2, h3, h4, h5, h6,
		#site-title,
		#site-description,
		.entry-title,
		#comments-title,
		#reply-title,
		.widget-title {
			font-family:<?php echo $fonts[pinboard_get_option( 'headings_font' )]; ?>;
		}
		.entry-content {
			font-family:<?php echo $fonts[pinboard_get_option( 'content_font' )]; ?>;
		}
	<?php else : ?>
		<?php if( $default_options['headings_font'] != pinboard_get_option( 'headings_font' ) ) : ?>
			h1, h2, h3, h4, h5, h6 {
				font-family:<?php echo $fonts[pinboard_get_option( 'headings_font' )]; ?>;
			}
		<?php endif; ?>
		<?php if( $default_options['content_font'] != pinboard_get_option( 'content_font' ) ) : ?>
			.entry-content {
				font-family:<?php echo $fonts[pinboard_get_option( 'content_font' )]; ?>;
			}
		<?php endif; ?>
	<?php endif; ?>
	<?php if( $default_options['body_font_size'] != pinboard_get_option( 'body_font_size' ) ) : ?>
		body {
			font-size:<?php echo pinboard_get_option( 'body_font_size' ) . pinboard_get_option( 'body_font_size_unit' ); ?>;
			line-height:<?php echo pinboard_get_option( 'body_line_height' ) . pinboard_get_option( 'body_line_height_unit' ); ?>;
		}
	<?php elseif( $default_options['body_line_height'] != pinboard_get_option( 'body_line_height' ) ) : ?>
		body {
			line-height:<?php echo pinboard_get_option( 'body_line_height' ) . pinboard_get_option( 'body_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h1_font_size'] != pinboard_get_option( 'h1_font_size' ) ) : ?>
		h1,
		.single .entry-title,
		.page .entry-title,
		.error404 .entry-title {
			font-size:<?php echo pinboard_get_option( 'h1_font_size' ) . pinboard_get_option( 'h1_font_size_unit' ); ?>;
			line-height:<?php echo pinboard_get_option( 'headings_line_height' ) . pinboard_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h2_font_size'] != pinboard_get_option( 'h2_font_size' ) ) : ?>
		h2,
		.entry-title {
			font-size:<?php echo pinboard_get_option( 'h2_font_size' ) . pinboard_get_option( 'h2_font_size_unit' ); ?>;
			line-height:<?php echo pinboard_get_option( 'headings_line_height' ) . pinboard_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h3_font_size'] != pinboard_get_option( 'h3_font_size' ) ) : ?>
		h3,
		.teaser .entry-title {
			font-size:<?php echo pinboard_get_option( 'h3_font_size' ) . pinboard_get_option( 'h3_font_size_unit' ); ?>;
			line-height:<?php echo pinboard_get_option( 'headings_line_height' ) . pinboard_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h4_font_size'] != pinboard_get_option( 'h4_font_size' ) ) : ?>
		h4 {
			font-size:<?php echo pinboard_get_option( 'h4_font_size' ) . pinboard_get_option( 'h4_font_size_unit' ); ?>;
			line-height:<?php echo pinboard_get_option( 'headings_line_height' ) . pinboard_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['headings_line_height'] != pinboard_get_option( 'headings_line_height' ) ) : ?>
		h1, h2, h3, h4, h5, h6 {
			line-height:<?php echo pinboard_get_option( 'headings_line_height' ) . pinboard_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['content_font_size'] != pinboard_get_option( 'content_font_size' ) ) : ?>
		.entry-content {
			font-size:<?php echo pinboard_get_option( 'content_font_size' ) . pinboard_get_option( 'content_font_size_unit' ); ?>;
			line-height:<?php echo pinboard_get_option( 'content_line_height' ) . pinboard_get_option( 'content_line_height_unit' ); ?>;
		}
		@media screen and (max-width: 640px) {
			.entry-content {
				font-size:<?php echo pinboard_get_option( 'mobile_font_size' ) . pinboard_get_option( 'content_font_size_unit' ); ?>;
				line-height:<?php echo pinboard_get_option( 'mobile_line_height' ) . pinboard_get_option( 'content_line_height_unit' ); ?>;
			}
		}
	<?php elseif( $default_options['content_line_height'] != pinboard_get_option( 'content_line_height' ) ) : ?>
		.entry-content {
			line-height:<?php echo pinboard_get_option( 'content_line_height' ) . pinboard_get_option( 'content_line_height' ); ?>;
		}
		@media screen and (max-width: 640px) {
			.entry-content {
				font-size:<?php echo pinboard_get_option( 'mobile_font_size' ) . pinboard_get_option( 'mobile_font_size_unit' ); ?>;
				line-height:<?php echo pinboard_get_option( 'mobile_line_height' ) . pinboard_get_option( 'mobile_line_height_unit' ); ?>;
			}
		}
	<?php elseif( $default_options['mobile_font_size'] != pinboard_get_option( 'mobile_font_size' ) ) : ?>
		@media screen and (max-width: 640px) {
			.entry-content {
				font-size:<?php echo pinboard_get_option( 'mobile_font_size' ) . pinboard_get_option( 'mobile_font_size_unit' ); ?>;
				line-height:<?php echo pinboard_get_option( 'mobile_line_height' ) . pinboard_get_option( 'mobile_line_height_unit' ); ?>;
			}
		}
	<?php elseif( $default_options['mobile_line_height'] != pinboard_get_option( 'mobile_line_height' ) ) : ?>
		@media screen and (max-width: 640px) {
			.entry-content {
				line-height:<?php echo pinboard_get_option( 'mobile_line_height' ) . pinboard_get_option( 'mobile_line_height_unit' ); ?>;
			}
		}
	<?php endif; ?>
	<?php if( $default_options['body_color'] != pinboard_get_option( 'body_color' ) ) : ?>
		body {
			color:<?php echo esc_attr( pinboard_get_option( 'body_color' ) ); ?>;
		}
		h1, h2, h3, h4, h5, h6,
		.entry-title,
		.entry-title a {
			color:<?php echo esc_attr( pinboard_get_option( 'headings_color' ) ); ?>;
		}
		.entry-content {
			color:<?php echo pinboard_get_option( 'content_color' ); ?>;
		}
	<?php else : ?>
		<?php if( $default_options['headings_color'] != pinboard_get_option( 'headings_color' ) ) : ?>
			h1, h2, h3, h4, h5, h6,
			.entry-title,
			.entry-title a {
				color:<?php echo esc_attr( pinboard_get_option( 'headings_color' ) ); ?>;
			}
		<?php endif; ?>
		<?php if( $default_options['content_color'] != pinboard_get_option( 'content_color' ) ) : ?>
			.entry-content {
				color:<?php echo esc_attr( pinboard_get_option( 'content_color' ) ); ?>;
			}
		<?php endif; ?>
	<?php endif; ?>
	<?php if( $default_options['links_color'] != pinboard_get_option( 'links_color' ) ) : ?>
		a {
			color:<?php echo esc_attr( pinboard_get_option( 'links_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['links_hover_color'] != pinboard_get_option( 'links_hover_color' ) ) : ?>
		a:hover {
			color:<?php echo esc_attr( pinboard_get_option( 'links_hover_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['menu_color'] != pinboard_get_option( 'menu_color' ) ) : ?>
		#access a {
			color:<?php echo esc_attr( pinboard_get_option( 'menu_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['menu_hover_color'] != pinboard_get_option( 'menu_hover_color' ) ) : ?>
		#access a:hover,
		#access li.current_page_item > a {
			color:<?php echo esc_attr( pinboard_get_option( 'menu_hover_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['sidebar_color'] != pinboard_get_option( 'sidebar_color' ) ) : ?>
		#sidebar,
		#sidebar-left,
		#sidebar-right {
			color:<?php echo esc_attr( pinboard_get_option( 'sidebar_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['sidebar_title_color'] != pinboard_get_option( 'sidebar_title_color' ) ) : ?>
		.widget-title {
			color:<?php echo esc_attr( pinboard_get_option( 'sidebar_title_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['sidebar_links_color'] != pinboard_get_option( 'sidebar_links_color' ) ) : ?>
		.widget-area a {
			color:<?php echo esc_attr( pinboard_get_option( 'sidebar_links_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['footer_color'] != pinboard_get_option( 'footer_color' ) ) : ?>
		#footer-area {
			color:<?php echo esc_attr( pinboard_get_option( 'footer_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['footer_title_color'] != pinboard_get_option( 'footer_title_color' ) ) : ?>
		#footer-area .widget-title {
			color:<?php echo esc_attr( pinboard_get_option( 'footer_title_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['copyright_color'] != pinboard_get_option( 'copyright_color' ) ) : ?>
		#copyright {
			color:<?php echo esc_attr( pinboard_get_option( 'copyright_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['copyright_links_color'] != pinboard_get_option( 'copyright_links_color' ) ) : ?>
		#copyright a {
			color:<?php echo esc_attr( pinboard_get_option( 'copyright_links_color' ) ); ?>;
		}
	<?php endif; ?>
	<?php echo esc_html( pinboard_get_option( 'user_css' ) ); ?>
</style>
<?php
}
endif;

add_action( 'wp_head', 'pinboard_custom_styles' );

if ( ! function_exists( 'pinboard_body_class' ) ) :
/**
 * Adds template names to body_class filter
 *
 * The custom layouts are shared with the custom templates
 * and use the same style declarations
 * @since Pinboard 1.0
 */
function pinboard_body_class( $classes ) {
	if( ! is_page_template() ) {
		$default_options = pinboard_default_options();
		if( ( 'full-width' == pinboard_get_option( 'layout' ) ) || ( ! is_active_sidebar( 2 ) && ! is_active_sidebar( 3 ) && ! is_active_sidebar( 4 ) && ! is_active_sidebar( 5 ) ) )
			$classes[] = 'page-template-template-full-width-php';
		elseif( 'sidebar-content' == pinboard_get_option( 'layout' ) )
			$classes[] = 'page-template-template-sidebar-content-php';
		elseif( 'sidebar-content-sidebar' == pinboard_get_option( 'layout' ) )
			$classes[] = 'page-template-template-sidebar-content-sidebar-php';
		elseif( 'content-sidebar-half' == pinboard_get_option( 'layout' ) )
			$classes[] = 'page-template-template-content-sidebar-half-php';
		elseif( 'sidebar-content-half' == pinboard_get_option( 'layout' ) )
			$classes[] = 'page-template-template-sidebar-content-half-php';
		elseif( 'no-sidebars' == pinboard_get_option( 'layout' ) )
			$classes[] = 'page-template-template-no-sidebars-php';
	}
	return $classes;
}
endif;

add_filter( 'body_class', 'pinboard_body_class' );

if ( ! function_exists( 'pinboard_doc_title' ) ) :
/**
 * Output the <title> tag
 *
 * @since Pinboard 1.0
 */
function pinboard_doc_title( $doc_title ) {
	global $page, $paged;
	$doc_title = str_replace( '&raquo;', '', $doc_title );
	$site_description = get_bloginfo( 'description', 'display' );
	$separator = '#124';
	if ( is_singular() ) {
		if( is_front_page() )
			$doc_title .=  get_the_title();
		if ( $paged >= 2 || $page >= 2 )
			$doc_title .=  ', ' . __( 'Page', 'pinboard' ) . ' ' . max( $paged, $page );
	} else {
		if( ! is_home() )
			$doc_title .= ' &' . $separator . '; ';
		$doc_title .= get_bloginfo( 'name' );
		if ( $paged >= 2 || $page >= 2 )
			$doc_title .=  ', ' . __( 'Page', 'pinboard' ) . ' ' . max( $paged, $page );
	}
	if ( ( is_home() ) && $site_description )
		$doc_title .= ' &' . $separator . '; ' . $site_description;
	return $doc_title;
}
endif;

add_filter( 'wp_title', 'pinboard_doc_title' );

if ( ! function_exists( 'pinboard_current_location' ) ) :
/**
 * Highlight current location in the archive
 *
 * @since Pinboard 1.0
 */
function pinboard_current_location() {
	global $pinboard_page_template;
	if ( ! ( is_home() && ! is_paged() ) && ! is_singular() || isset( $pinboard_page_template ) ) {
		if( is_author() )
			$archive = 'author';
		elseif( is_category() || is_tag() ) {
			$archive = get_queried_object()->taxonomy;
			$archive = str_replace( 'post_', '', $archive );
		} else
			$archive = ''; ?>
		<hgroup id="current-location">
			<h6 class="prefix-text"><?php _e( 'Currently browsing', 'pinboard' ); ?> <?php echo $archive; ?></h6>
			<<?php pinboard_title_tag( 'location' ); ?> class="page-title">
				<?php if( isset( $pinboard_page_template ) ) {
					echo the_title();
				} elseif( is_search() ) {
					__( 'Search results for', 'pinboard' ) . ': &quot;' .  get_search_query() . '&quot;';
				} elseif( is_author() ) {
					$author = get_userdata( get_query_var( 'author' ) );
					echo $author->display_name;
				} elseif ( is_year() ) {
					echo get_query_var( 'year' );
				} elseif ( is_month() ) {
					echo get_the_time( 'F Y' );
				} elseif ( is_day() ) {
					echo get_the_time( 'F j, Y' );
				} else {
					single_term_title( '' );
				}
				if( is_paged() ) {
					global $page, $paged;
					if( ! is_home() )
						echo ', ';
					echo sprintf( __( 'Page %d', 'pinboard' ), get_query_var( 'paged' ) );
				}
				?>
			</<?php pinboard_title_tag( 'location' ); ?>>
			<?php if( is_category() || is_tag() || is_tax() ) : ?>
				<div class="category-description">
					<?php echo term_description(); ?>
				</div>
			<?php endif; ?>
		</hgroup>
		<?php
	}
}
endif;

if ( ! function_exists( 'pinboard_title_tag' ) ) :
/**
 * Displays the tag selected in SEO options
 *
 * @param $tag string Title for which to display the tag
 * @since Pinboard 1.0
 */
function pinboard_title_tag( $tag ) {
	global $pinboard_page_template;
	if( isset( $pinboard_page_template ) )
		echo pinboard_get_option( 'archive_' . $tag . '_title_tag' );
	elseif( is_home() && ! is_paged() )
		echo pinboard_get_option( 'home_' . $tag . '_title_tag' );
	elseif( is_singular() )
		echo pinboard_get_option( 'single_' . $tag . '_title_tag' );
	else
		echo pinboard_get_option( 'archive_' . $tag . '_title_tag' );
}
endif;

if ( ! function_exists( 'pinboard_content_class' ) ) :
/**
 * Outputs the class attribute for the content wrapper
 *
 * @since Pinboard 1.0
 */
function pinboard_content_class( $classes = array() ) {
	$classes[] = 'column';
	if( is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) || 'full-width' == pinboard_get_option( 'layout' ) || 'no-sidebars' == pinboard_get_option( 'layout' ) ) || ( ! is_active_sidebar( 2 ) && ! is_active_sidebar( 3 ) && ! is_active_sidebar( 4 ) && ! is_active_sidebar( 5 ) )  )
		$classes[] = 'onecol';
	elseif( 'content-sidebar-half' == pinboard_get_option( 'layout' ) || 'sidebar-content-half' == pinboard_get_option( 'layout' ) )
		$classes[] = 'twocol';
	else {
		if( 2 == pinboard_get_option( 'layout_columns' ) )
			$classes[] = 'twocol';
		elseif( 3 == pinboard_get_option( 'layout_columns' ) )
			$classes[] = 'twothirdcol';
		elseif( 4 == pinboard_get_option( 'layout_columns' ) )
			$classes[] = 'threefourthcol';
	}
	echo 'class="' . implode( ' ', $classes ) . '"';
}
endif;

if ( ! function_exists( 'pinboard_category_filter' ) ) :
/**
 * Show a filter of subcategories for the current category
 *
 * @since Pinboard 1.0
 */
function pinboard_category_filter( $cat = null ) {
	if( null == $cat )
		$cat = get_queried_object();
	$args = array(
		'child_of' => $cat,
		'hide_empty' => 1,
	);
	$categories = get_categories( $args );
	if( ! empty( $categories ) || ( is_category() && cat_is_ancestor_of( $cat, get_queried_object() ) ) ) : ?>
		<div class="category-filter">
			<?php if( null != $cat && ( is_category() && cat_is_ancestor_of( $cat, get_queried_object() ) ) ) : ?>
				<a href="<?php echo get_category_link( $cat ); ?>"><?php $category = get_category( $cat ); echo $category->cat_name; ?></a>
			<?php endif; ?>
			<?php foreach( $categories as $category ) : ?>
				<a href="<?php echo get_category_link( $category->cat_ID ); ?>"><?php echo $category->cat_name; ?></a>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>
	<?php endif;
}
endif;

if ( ! function_exists( 'pinboard_post_class' ) ) :
/**
 * Add class has-thumbnail to posts that have a thumbnail set
 *
 * @since Pinboard 1.0
 */
function pinboard_post_class( $classes, $class, $post_id ) {
	global $pinboard_count;
	if( ! isset( $pinboard_count ) )
		$pinboard_count = 0;
	$pinboard_count++;
	$classes[] = 'column';
	if( pinboard_is_teaser() ) {
		global $pinboard_page_template;
		if( isset( $pinboard_page_template ) ) {
			if( 'template-blog.php' == $pinboard_page_template || 'template-portfolio-right-sidebar.php' == $pinboard_page_template )
				$classes[] = 'twocol';
			elseif( 'template-blog-full-width.php' == $pinboard_page_template || 'template-portfolio.php' == $pinboard_page_template )
				$classes[] = 'threecol';
			elseif( 'template-blog-four-col.php' == $pinboard_page_template || 'template-portfolio-four-col.php' == $pinboard_page_template )
				$classes[] = 'fourcol';
			elseif( 'template-blog-left-sidebar.php' == $pinboard_page_template || 'template-portfolio-left-sidebar.php' == $pinboard_page_template )
				$classes[] = 'twocol';
			elseif( 'template-blog-no-sidebars.php' == $pinboard_page_template || 'template-portfolio-no-sidebars.php' == $pinboard_page_template )
				$classes[] = 'twocol';
		} elseif( is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) {
			if( 2 == pinboard_get_option( 'portfolio_columns' ) )
				$classes[] = 'twocol';
			elseif( 3 == pinboard_get_option( 'portfolio_columns' ) )
				$classes[] = 'threecol';
			elseif( 4 == pinboard_get_option( 'portfolio_columns' ) )
				$classes[] = 'fourcol';
		} elseif( 'full-width' == pinboard_get_option( 'layout' ) || 'no-sidebars' == pinboard_get_option( 'layout' ) ) {
			if( 2 == pinboard_get_option( 'layout_columns' ) )
				$classes[] = 'twocol';
			elseif( 3 == pinboard_get_option( 'layout_columns' ) )
				$classes[] = 'threecol';
			elseif( 4 == pinboard_get_option( 'layout_columns' ) )
				$classes[] = ( 'no-sidebars' == pinboard_get_option( 'layout' ) ? 'threecol' : 'fourcol' );
		} else {
			if( 2 == pinboard_get_option( 'layout_columns' ) )
				$classes[] = 'onecol';
			elseif( 3 == pinboard_get_option( 'layout_columns' ) )
				$classes[] = 'twocol';
			elseif( 4 == pinboard_get_option( 'layout_columns' ) )
				$classes[] = 'threecol';
		}
	} else {
		$classes[] = 'onecol';
	}
	if( ! is_singular() && has_post_thumbnail() && ! has_post_format( 'gallery' ) && ! has_post_format( 'image' ) && ! has_post_format( 'status' ) && ! has_post_format( 'video' )  )
		$classes[] = 'has-thumbnail';
	return $classes;
}
endif;

add_filter( 'post_class', 'pinboard_post_class', 10, 3 );

if ( ! function_exists( 'pinboard_is_teaser' ) ) :
/**
 * Checks whether displayed post is a teaser
 *
 * @since Pinboard 1.0
 */
function pinboard_is_teaser() {
	if( 1 == pinboard_get_option( 'layout_columns' ) )
		return false;
	if( ! is_singular() ) {
		if( is_category( pinboard_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) {
			if( is_paged() )
				$offset = pinboard_get_option( 'portfolio_archive_excerpts' );
			else
				$offset = pinboard_get_option( 'portfolio_excerpts' );
		} elseif( is_home() && ! is_paged() )
			$offset = pinboard_get_option( 'home_page_excerpts' );
		else
			$offset = pinboard_get_option( 'archive_excerpts' );
		global $pinboard_count;
		if( ! isset( $pinboard_count ) )
			$pinboard_count = 0;
		$count = $pinboard_count;
		if ( $pinboard_count > $offset )
			return true;
	}
	return false;
}
endif;

if ( ! function_exists( 'pinboard_post_is_full_width' ) ) :
/**
 * Checks if a post is displayed on one column in full width
 *
 * @since Pinboard 1.0.6
 */
function pinboard_post_is_full_width() {
	global $pinboard_page_template;
	if( ( 'full-width' != pinboard_get_option( 'layout' ) && 'template-blog-full-width.php' != $pinboard_page_template && 'template-blog-four-col.php' != $pinboard_page_template && ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) || pinboard_is_teaser() )
		return false;
	return true;	
}
endif;

if ( ! function_exists( 'pinboard_post_thumbnail' ) ) :
/**
 * Displays post thumbnail and link to post
 *
 * @since Pinboard 1.0
 */
function pinboard_post_thumbnail() {
	if( has_post_thumbnail() ) : ?>
		<figure class="entry-thumbnail">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( ( pinboard_is_teaser() ? 'teaser-thumb' : 'blog-thumb' ) ); ?>
			</a>
		</figure>
	<?php endif;
}
endif;

if ( ! function_exists( 'pinboard_entry_meta' ) ) :
/**
 * Output entry-meta tag
 *
 * @since Pinboard 1.0
 */
function pinboard_entry_meta() {
	if( ! pinboard_is_teaser() ) : ?>
		<aside class="entry-meta">
			<?php if( is_category( pinboard_get_option( 'portfolio_cat' ) ) || in_category( pinboard_get_option( 'portfolio_cat' ) ) ) : ?>
				<span class="custom-meta entry-category"><?php the_category( ' / ' ); ?></span>
				<?php $meta_keys = get_post_meta( get_the_ID() ); ?>
				<?php foreach( $meta_keys as $meta => $value ) : ?>
					<?php if( ( '_' != $meta[0] ) && ( 'enclosure' != $meta ) ) : ?>
						<span class="custom-meta"><strong><?php echo $meta; ?>:</strong> <?php echo $value[0]; ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else : ?>
				<span class="entry-author-link"><?php the_author_posts_link(); ?></span>
				<?php if( ! is_singular() ) : ?>
					<span class="entry-date"><a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
				<?php else : ?>
					<span class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
				<?php endif; ?>
				<?php if( ! is_attachment() ) : ?>
				<span class="entry-category"><?php the_category( ', ' ); ?></span>
				<?php elseif( wp_attachment_is_image() ) : ?>
					<span class="attachment-size"><a href="<?php echo wp_get_attachment_url(); ?>" title="<?php _e( 'Link to full-size image', 'pinboard' ); ?>"><?php $metadata = wp_get_attachment_metadata(); echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?></a> <?php _e( 'pixels', 'pinboard' ); ?></span>
				<?php endif; ?>
				<?php edit_post_link( __( 'Edit', 'pinboard' ), '<span class="edit-link">', '</span>' ); ?>
				<?php if( ! is_singular() ) : ?>
					<span class="entry-permalink"><a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Permalink</a></span>
				<?php endif; ?>
			<?php endif; ?>
			<div class="clear"></div>
		</aside><!-- .entry-meta -->
	<?php endif;
}
endif;

if ( ! function_exists( 'pinboard_excerpt_length' ) ) :
/**
 * Change the number of words shown in excerps
 *
 * @since Pinboard 1.0
 */
function pinboard_excerpt_length( $length ) {
	if( pinboard_is_teaser() ) {
		if( has_post_format( 'aside' ) )
			return 36;
		else
			return 22;
	} else
		return 50;
}
endif;

add_filter( 'excerpt_length', 'pinboard_excerpt_length' );

if ( ! function_exists( 'pinboard_excerpt_more' ) ) :
/**
 * Changes the default excerpt trailing content
 *
 * Replaces the default [...] trailing text from excerpts
 * to a more pleasant ...
 *
 * @since Pinboard 1.0
 */
function pinboard_excerpt_more($more) {
	return ' &#8230;';
}
endif;

add_filter( 'excerpt_more', 'pinboard_excerpt_more' );

if ( ! function_exists( 'pinboard_password_form' ) ) :
/**
 * Add password form on protected posts
 *
 * @since Pinboard 1.0.1
 */
function pinboard_password_form( $excerpt ) {
	if( post_password_required() )
		$excerpt = apply_filters( 'the_content', get_the_content() );
	return $excerpt;
}
endif;

add_filter( 'the_excerpt', 'pinboard_password_form' );

if ( ! function_exists( 'pinboard_excerpt_permalink' ) ) :
/**
 * Add a permalink to post formats that display with no title
 *
 * @since Pinboard 1.0.1
 */
function pinboard_excerpt_permalink( $excerpt ) {
	if( pinboard_is_teaser() && ( has_post_format( 'aside' ) || has_post_format( 'status' ) ) )
		$excerpt = str_replace( '</p>', ' <a href="' . get_permalink() . '" rel="bookmark">&rarr; ' . get_the_time( get_option( 'date_format' ) ) . '</a></p>', $excerpt );
	return $excerpt;
}
endif;

add_filter( 'the_excerpt', 'pinboard_excerpt_permalink' );

if ( ! function_exists( 'pinboard_title_permalink' ) ) :
/**
 * Add a permalink to teasers with no title
 *
 * @since Pinboard 1.0.1
 */
function pinboard_title_permalink( $title ) {
	if( pinboard_is_teaser() && ( '' == $title ) )
		$title = '&rarr; ' . get_the_time( get_option( 'date_format' ) );
	return $title;
}
endif;

add_filter( 'the_title', 'pinboard_title_permalink' );

if ( ! function_exists( 'pinboard_gallery_shortcode' ) ) :
/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post. Replaced the default gallery style with HTML 5 markup.
 * Also disables inline styling by default.
 *
 * @since Pinboard 1.0
 *
 * @param string $output Empty string passed by core function.
 * @param array $attr Attributes attributed to the shortcode.
 * @return string HTML content to display gallery.
 */
function pinboard_gallery_shortcode( $output, $attr ) {
	global $post, $wp_locale;
	static $instance = 0;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'figure',
		'icontag'    => 'span',
		'captiontag' => 'figcaption',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr ) );

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $exclude ) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty( $attachments ) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(90/$columns) : 90;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', false ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				width: {$itemwidth}%;
				margin:0 1.5% 3%;
				text-align: center;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
	$size_class = sanitize_html_class( $size );
	$link = isset($attr['link']) && 'file' == $attr['link'] ? 'file' : 'attachment';
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} gallery-link-{$link}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<div class='clear'></div>
		</div>\n";

	return $output;
}
endif;

add_filter( 'post_gallery', 'pinboard_gallery_shortcode', 10, 2 );

if ( ! function_exists( 'pinboard_rel_attachment' ) ) :
function pinboard_rel_attachment( $link ) {
	return str_replace( "<a ", "<a rel='attachment' ", $link );
}
endif;

add_filter( 'wp_get_attachment_link', 'pinboard_rel_attachment' );

if ( ! function_exists( 'pinboard_get_first_image' ) ) :
/**
 * Show the first image inserted in the current postimage
 *
 * @since Pinboard 1.0.4
 */
function pinboard_get_first_image() {
	$document = new DOMDocument();
	$content = apply_filters( 'the_content', get_the_content( '', true ) );
	if( '' != $content ) {
		libxml_use_internal_errors( true );
		$document->loadHTML( $content );
		libxml_clear_errors();
		$images = $document->getElementsByTagName( 'img' );
		$document = new DOMDocument();
		if( $images->length ) {
			$image= $images->item( $images->length - 1 );
			$src = $image->getAttribute( 'src' );
			$width = ( $image->hasAttribute( 'width' ) ? $image->getAttribute( 'width' ) : false );
			$height = ( $image->hasAttribute( 'height' ) ? $image->getAttribute( 'height' ) : false );
			return array( $src, $width, $height );
		}
	}
	return false;
}
endif;

if ( ! function_exists( 'pinboard_post_image' ) ) :
/**
 * Show the last image attached to the current post
 *
 * Used in image post formats
 * Images attached to image posts should not appear in the post's content
 * to avoid duplicate display of the same content
 *
 * @uses get_posts() To retrieve attached image
 *
 * @since Pinboard 1.0
 */
function pinboard_post_image() {
	if( has_post_thumbnail() ) : ?>
		<figure>
			<a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); echo $image[0] ?>" title="<?php the_title_attribute(); ?>" class="colorbox" rel="attachment">
				<?php the_post_thumbnail( ( pinboard_is_teaser() ? 'teaser-thumb' : 'image-thumb' ) ); ?>
			</a>
		</figure>
	<?php else :
		// Retrieve the last image attached to the post
		$args = array(
			'numberposts' => 1,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'post_parent' => get_the_ID()
		);
		$attachments = get_posts( $args );
		if( count( $attachments ) ) {
			$attachment = $attachments[0];
			if( isset( $attachment ) && ! post_password_required() ) :
				$image = wp_get_attachment_image_src( $attachment->ID, 'full' ); ?>
				<figure>
					<a href="<?php echo $image[0]; ?>" title="<?php the_title_attribute(); ?>" class="colorbox"  rel="attachment">
						<?php echo wp_get_attachment_image( $attachment->ID, 'image-thumb' ); ?>
					</a>
				</figure>
			<?php endif;
		} elseif( false !== pinboard_get_first_image() ) {
			if( ! post_password_required() ) :
				$image = pinboard_get_first_image();
				if( false === $image[1] )
					$image[1] = 695;
				if( false === $image[2] )
					$image[2] = 430;
				$attachment = get_post( get_the_ID() ); ?>
				<figure>
					<a href="<?php echo $image[0]; ?>" title="<?php the_title_attribute(); ?>" class="colorbox"  rel="attachment">
						<img src="<?php echo $image[0]; ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" />
					</a>
				</figure>
			<?php endif;
		} else {
			the_content();
		}
	endif;
}
endif;

if ( ! function_exists( 'pinboard_post_gallery' ) ) :
/**
 * Show a gallery of images attached to the current post
 *
 * Used in gallery post formats
 * Galery post formats shou;d not use the [gallery] shortcode
 * to avoid duplicate display of the same content
 * to avoid duplicate of the same content
 *
 * @uses get_posts() To retrieve attached images
 *
 * @since Pinboard 1.0
 */
function pinboard_post_gallery() {
	// Retrieve images attached to post
	$args = array(
		'numberposts' => 3,
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_parent' => get_the_ID()
	);
	$attachments = get_posts( $args );
	// Reverse array to display them in chronological form instead of reverse chronological
	$attachments = array_reverse( $attachments );
	if( count( $attachments ) && ! post_password_required() ) : ?>
		<div class="post-gallery">
			<?php $count = 0; ?>
			<?php foreach( $attachments as $attachment ) : ?>
				<?php $count++; ?>
				<figure class="post-gallery-item">
					<a href="<?php $image = wp_get_attachment_image_src( $attachment->ID, 'full' ); echo $image[0]; ?>" class="colorbox" title="<?php echo esc_attr( get_the_title( $attachment->ID ) ); ?>" rel="attachment">
						<?php echo wp_get_attachment_image( $attachment->ID, "gallery-{$count}-thumb" ); ?>
					</a>
				</figure><!-- .gallery-item -->
			<?php endforeach; ?>
			<div class="clear"></div>
		</div><!-- .gallery -->
	<?php endif;
}
endif;

if ( ! function_exists( 'pinboard_first_embed' ) ) :
function pinboard_first_embed() {
	$document = new DOMDocument();
	$content = apply_filters( 'the_content', get_the_content( '', true ) );
	if( '' != $content ) {
		libxml_use_internal_errors( true );
		$document->loadHTML( $content );
		libxml_clear_errors();
		$iframes = $document->getElementsByTagName( 'iframe' );
		$objects = $document->getElementsByTagName( 'object' );
		$embeds = $document->getElementsByTagName( 'embed' );
		$document = new DOMDocument();
		if( $iframes->length ) {
				$iframe= $iframes->item( $iframes->length - 1 );
				$document->appendChild( $document->importNode( $iframe, true ) );
		} elseif( $objects->length ) {
				$object= $objects->item( $objects->length - 1 );
				$document->appendChild( $document->importNode( $object, true ) );
		} elseif( $embeds->length ) {
				$embed= $embeds->item( $embeds->length - 1 );
				$document->appendChild( $document->importNode( $embed, true ) );
		}
		echo '<div class="entry-attachment"><p>' . $document->saveHTML() . '</p></div><!-- .entry-attachment -->';
	}
}
endif;

if ( ! function_exists( 'pinboard_post_audio' ) ) :
/**
 * Audio playback support for post with the audio format
 *
 * Displays the attached audio files in a HTML5 <audio> tag with flash fallback
 * If more then one attached audio file is found, they are used as fallback to the first one
 * Should work in most if not all browsers :)
 *
 * @uses get_posts() To retrieve attached audio files
 *
 * @since Pinboard 1.0
 */
function pinboard_post_audio() {
	if( ! post_password_required() ) :
		// Get attached audio files
		$args = array(
			'numberposts' => -1,
			'post_type' => 'attachment',
			'post_mime_type' => 'audio',
			'post_parent' => get_the_ID()
		);
		$attachments = get_posts( $args );
		// Reverse array to display them in chronological form instead of reverse chronological
		$attachments = array_reverse( $attachments );
		if( count( $attachments ) ) :
			// Detect MP3 file to use it as flash fallback
			$mime_types = array();
			foreach( $attachments as $attachment ) :
				if( $attachment->post_mime_type == 'audio/mpeg' )
					$flash_audio = $attachment;
			endforeach; ?>
			<div class="entry-attachment">
				<audio controls id="audio-player-<?php the_ID(); ?>">
					<?php foreach( $attachments as $attachment ) : ?>
						<source src="<?php echo wp_get_attachment_url( $attachment->ID ); ?>">
					<?php endforeach; ?>
				</audio>
			</div><!-- .entry-attachment -->
		<?php elseif( ! is_singular() ) :
			pinboard_first_embed();
		endif;
	endif;
}
endif;

if ( ! function_exists( 'pinboard_file_types' ) ) :
/**
 * Allows uploading of .webm video files
 *
 * @since Pinboard 1.0
 */
function pinboard_file_types( $types ) {
	$types['video'][] = 'webm';
	return $types;
}
endif;

add_filter( 'ext2type', 'pinboard_file_types' );

if ( ! function_exists( 'pinboard_mime_types' ) ) :
/**
 * Registers the webm mime type
 *
 * @since Pinboard 1.0
 */
function pinboard_mime_types( $types ) {
	$types['webm'] = 'video/webm';
	return $types;
}
endif;

add_filter( 'upload_mimes', 'pinboard_mime_types' );

if ( ! function_exists( 'pinboard_post_video' ) ) :
/**
 * Video playback support for post with the video format
 *
 * Displays the attached video in a HTML5 <video> tag with flash fallback
 * If more then one attached video is found, they are used as fallback to the first one
 * Should work in most if not all browsers :)
 *
 * @uses get_posts() To retrieve attached videos
 *
 * @since Pinboard 1.0
 */
function pinboard_post_video() {
	if( ! post_password_required() ) :
		// Get attached videos
		$args = array(
			'numberposts' => -1,
			'post_type' => 'attachment',
			'post_mime_type' => 'video',
			'post_parent' => get_the_ID()
		);
		$attachments = get_posts( $args );
		// Reverse array to display them in chronological order instead of reverse chronological
		$attachments = array_reverse( $attachments );
		if( count( $attachments ) ) :
			// Detect flash video format to use it as fallback
			$mime_types = array(); ?>
			<div class="entry-attachment">
				<video controls width="700" height="444"<?php if( has_post_thumbnail() ) : ?> poster="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'video-thumb' ); echo $image[0]; ?>"<?php endif; ?> id="video-player-<?php the_ID(); ?>">
					<?php foreach( $attachments as $attachment ) :
						// Show each video file as a fallback source ?>
						<source src="<?php echo wp_get_attachment_url( $attachment->ID ); ?>" type='<?php echo $attachment->post_mime_type; if( $attachment->post_mime_type == 'video/mp4' ) echo '; codecs="avc1.42E01E, mp4a.40.2"'; elseif( $attachment->post_mime_type == 'video/webm' ) echo '; codecs="vp8, vorbis"'; elseif( $attachment->post_mime_type == 'video/ogg' ) echo '; codecs="theora, vorbis"'; ?>'>
					<?php endforeach; ?>
				</video>
			</div><!-- .entry-attachment -->
		<?php elseif( ! is_singular() ) :
			pinboard_first_embed();
		endif;
	endif;
}
endif;

if ( ! function_exists( 'pinboard_post_link' ) ) :
function pinboard_post_link( $src ) {
	if( has_post_format( 'link' ) ) {
		$document = new DOMDocument();
		$content = apply_filters( 'the_content', get_the_content( '', true ) );
		if( '' != $content ) {
			libxml_use_internal_errors( true );
			$document->loadHTML( $content );
			libxml_clear_errors();
			$links = $document->getElementsByTagName( 'a' );
			for( $i = 0; $i < $links->length; $i++ ) {
				$link = $links->item($i);
				$document = new DOMDocument();
				$document->appendChild( $document->importNode( $link, true ) );
				$src = $link->getAttribute('href');
			}
		}
	}
	return $src;
}
endif;

add_filter( 'the_permalink', 'pinboard_post_link' );

if ( ! function_exists( 'pinboard_first_blockquote' ) ) :
function pinboard_first_blockquote() {
	$document = new DOMDocument();
	$content = apply_filters( 'the_content', get_the_content( '', true ) );
	if( '' != $content ) {
		libxml_use_internal_errors( true );
		$document->loadHTML( $content );
		libxml_clear_errors();
		$blockquotes = $document->getElementsByTagName( 'blockquote' );
		for( $i = 0; $i < $blockquotes->length; $i++ ) {
			$blockquote = $blockquotes->item($i);
			$document = new DOMDocument();
			$document->appendChild( $document->importNode( $blockquote, true ) );
			echo $document->saveHTML();
		}
	}
	if( pinboard_is_teaser() && has_post_format( 'quote' ) ) {
		echo '<p><a href="' . get_permalink() . '" rel="bookmark">&rarr; ' . get_the_time( get_option( 'date_format' ) ) . '</a></p>';
	}
}
endif;

if ( ! function_exists( 'pinboard_attachment_nav' ) ) :
/**
 * Display social networks share icons
 *
 * @since Pinboard 1.0
 */
function pinboard_attachment_nav() {
	global $post;
	if( ! empty( $post->post_parent ) ) {
		$attachments = array_values( get_children( array(
			'post_parent' => $post->post_parent,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image'
		) ) );
		if( count( $attachments ) > 1 ) : ?>
		<div id="attachment-nav">
			<div class="nav-next"><?php next_image_link(); ?></div>
			<div class="nav-previous"><?php previous_image_link(); ?></div>
			<div class="clear"></div>
		</div><!-- #attachment-nav -->
		<?php endif;
	}
}
endif;

if ( ! function_exists( 'pinboard_social_bookmarks' ) ) :
/**
 * Display social networks share icons
 *
 * @since Pinboard 1.0
 */
function pinboard_social_bookmarks() {
	if( pinboard_get_option( 'facebook' ) || pinboard_get_option( 'twitter' ) || pinboard_get_option( 'google' ) || pinboard_get_option( 'pinterest' ) ) : ?>
		<div class="social-bookmarks">
			<p><?php _e( 'Did you like this article? Share it with your friends!', 'pinboard' ); ?></p>
			<?php if( pinboard_get_option( 'facebook' ) ) : ?>
				<div class="facebook-like">
					<div id="fb-root"></div>
					<script>
						(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
							fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
					</script>
					<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" data-font="arial"></div>
				</div><!-- .facebook-like -->
			<?php endif; ?>
			<?php if( pinboard_get_option( 'twitter' ) ) : ?>
				<div class="twitter-button">
					<a href="<?php echo esc_url( 'https://twitter.com/share' ); ?>" class="twitter-share-button" data-url="<?php the_permalink(); ?>">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div><!-- .twitter-button -->
			<?php endif; ?>
			<?php if( pinboard_get_option( 'google' ) ) : ?>
				<div class="google-plusone">
					<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
					<script type="text/javascript">
						(function() {
							var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							po.src = 'https://apis.google.com/js/plusone.js';
							var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						})();
					</script>
				</div><!-- .google-plusone -->
			<?php endif; ?>
			<?php if( pinboard_get_option( 'pinterest' ) ) :
				if( wp_attachment_is_image( get_the_ID() ) || has_post_thumbnail() )
					$thumb = wp_get_attachment_image_src( ( is_attachment() ? get_the_ID() : get_post_thumbnail_id() ), 'full' );
				else
					$thumb = pinboard_get_first_image(); ?>
				<div class="pinterest-button">
					<a href="<?php echo esc_url( 'http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . ( false !== $thumb ? '&media=' . urlencode( $thumb[0] ) : '' ) . '&description=' . urlencode( apply_filters('the_excerpt', get_the_excerpt() ) ) ); ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
					<script>
						(function(d, s, id) {
							var js, pjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//assets.pinterest.com/js/pinit.js";
							pjs.parentNode.insertBefore(js, pjs);
						}(document, 'script', 'pinterest-js'));
					</script>
				</div>
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .social-bookmarks -->
	<?php endif;
}
endif;

if ( ! function_exists( 'pinboard_post_author' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Pinboard 1.0
 */
function pinboard_post_author() {
	if( pinboard_get_option( 'author_box' ) && ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! in_category( pinboard_get_option( 'portfolio_cat' ) ) ) : ?>
		<div class="entry-author">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 96 ); ?>
			<h3 class="author vcard"><?php _e( 'Written by', 'pinboard' ) ?> <span class="fn"><?php the_author_posts_link(); ?></span></h3>
			<p class="author-bio"><?php the_author_meta( 'description' ); ?></p>
			<div class="clear"></div>
		</div><!-- .entry-author -->
	<?php endif;
}
endif;

if ( ! function_exists( 'pinboard_posts_nav' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Pinboard 1.0
 */
function pinboard_posts_nav() {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) {
		switch( pinboard_get_option( 'posts_nav_labels' ) ) {
			case 'next/prev' :
				$prev_label = __( 'Previous Page', 'pinboard' );
				$next_label = __( 'Next Page', 'pinboard' );
				break;
			case 'older/newer' :
				$prev_label = __( 'Newer Posts', 'pinboard' );
				$next_label = __( 'Older Posts', 'pinboard' );
				break;
			case 'earlier/later' :
				$prev_label = __( 'Later Posts', 'pinboard' );
				$next_label = __( 'Earlier Posts', 'pinboard' );
				break;
			case 'numbered' :
				$big = 999999999; // need an unlikely integer
				$args = array(
					'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'prev_text' => '&larr; <span class="text">' . __( 'Previous Page', 'pinboard' ) . '</span>',
					'next_text' => '<span class="text">' . __( 'Next Page', 'pinboard' ) . '</span> &rarr;'
				);
				break;
		}
		if( 'numbered' == pinboard_get_option( 'posts_nav_labels' ) ) : ?>
			<div id="posts-nav" class="navigation">
				<?php if( function_exists( 'wp_pagenavi' ) ) : ?>
					<?php wp_pagenavi(); ?> 
				<?php else : ?>
					<?php echo paginate_links( $args ); ?>
				<?php endif; ?>
			</div><!-- #posts-nav -->
		<?php else : ?>
			<div id="posts-nav" class="navigation">
				<div class="nav-prev"><?php previous_posts_link( '&larr; ' . $prev_label ); ?></div>
				<?php if( is_home() && ! is_paged() ) : ?>
					<div class="nav-all"><?php next_posts_link( __( 'Read all Articles', 'pinboard' ) . ' &rarr;' ); ?></div>
				<?php else : ?>
					<div class="nav-next"><?php next_posts_link( $next_label . ' &rarr;' ); ?></div>
				<?php endif; ?>
				<div class="clear"></div>
			</div><!-- #posts-nav -->
		<?php endif;
	}
}
endif;

if ( ! function_exists( 'pinboard_404' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Pinboard 1.0
 */
function pinboard_404() { ?>
	<article class="post hentry column onecol" id="post-0">
		<h2 class="entry-title"><?php _e( 'Content not found', 'pinboard' ) ?></h2>
		<div class="entry-content">
			<?php _e( 'The content you are looking for could not be found.', 'pinboard' ); ?></p>
			<?php if( is_active_sidebar( 7 ) ) : ?>
				<?php _e( 'Use the information below or try to seach to find what you\'re looking for:', 'pinboard' ); ?></p>
			<?php endif; ?>
			<?php dynamic_sidebar( 7 ); ?>
		</div><!-- .entry-content -->
	</article><!-- .post -->
	<div class="clear"></div>
<?php
}
endif;

if ( ! function_exists( 'pinboard_sidebar_class' ) ) :
/**
 * Outputs the class attribute for the content wrapper
 *
 * @since Pinboard 1.0
 */
function pinboard_sidebar_class( $classes = array() ) {
	$classes[] = 'column';
	if( 'content-sidebar-half' == pinboard_get_option( 'layout' ) || 'sidebar-content-half' == pinboard_get_option( 'layout' ) || 'content-sidebar-half' == pinboard_get_option( 'layout' ) || is_page_template( 'template-content-sidebar-half.php' ) || is_page_template( 'template-sidebar-content-half.php' ) )
		$classes[] = 'twocol';
	else {
		if( 2 == pinboard_get_option( 'layout_columns' ) || is_page_template( 'template-content-sidebar.php' ) )
			$classes[] = 'twocol';
		elseif( 3 == pinboard_get_option( 'layout_columns' ) || is_page_template( 'template-content-sidebar.php' ) )
			$classes[] = 'threecol';
		elseif( 4 == pinboard_get_option( 'layout_columns' ) )
			$classes[] = 'fourcol';
	}
	echo 'class="' . implode( ' ', $classes ) . '"';
}
endif;

if ( ! function_exists( 'pinboard_copyright_notice' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Pinboard 1.0
 */
function pinboard_copyright_notice() {
	$copyright = pinboard_get_option( 'copyright_notice' );
	$copyright = str_replace( '%year%', date( 'Y' ), $copyright );
	$copyright = str_replace( '%blogname%', get_bloginfo( 'name' ), $copyright );
	echo esc_html( $copyright );
}
endif;