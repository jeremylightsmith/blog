<?php if( is_active_sidebar( 1 ) ) : ?>
	<div id="sidebar-header" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 1 ); ?>
	</div><!-- #sidebar-header -->
<?php else : ?>
	<?php get_search_form(); ?>
	<?php if( '' != pinboard_get_option( 'facebook_link' ) || '' != pinboard_get_option( 'twitter_link' ) || '' != pinboard_get_option( 'pinterest_link' ) || '' != pinboard_get_option( 'vimeo_link' ) || '' != pinboard_get_option( 'youtube_link' ) || '' != pinboard_get_option( 'flickr_link' ) || '' != pinboard_get_option( 'googleplus_link' ) || '' != pinboard_get_option( 'dribble_link' ) || '' != pinboard_get_option( 'linkedin_link' ) ) : ?>
		<div id="social-media-icons">
			<?php if( '' != pinboard_get_option( 'facebook_link' ) ) : ?>
				<a class="social-media-icon facebook" href="<?php echo esc_url( pinboard_get_option( 'facebook_link' ) ); ?>">Facebook</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'twitter_link' ) ) : ?>
			<a class="social-media-icon twitter" href="<?php echo esc_url( pinboard_get_option( 'twitter_link' ) ); ?>">Twitter</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'pinterest_link' ) ) : ?>
			<a class="social-media-icon pinterest" href="<?php echo esc_url( pinboard_get_option( 'pinterest_link' ) ); ?>">Pinterest</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'flickr_link' ) ) : ?>
			<a class="social-media-icon flickr" href="<?php echo esc_url( pinboard_get_option( 'flickr_link' ) ); ?>">Flickr</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'vimeo_link' ) ) : ?>
			<a class="social-media-icon vimeo" href="<?php echo esc_url( pinboard_get_option( 'vimeo_link' ) ); ?>">Vimeo</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'youtube_link' ) ) : ?>
			<a class="social-media-icon youtube" href="<?php echo esc_url( pinboard_get_option( 'youtube_link' ) ); ?>">Vimeo</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'googleplus_link' ) ) : ?>
			<a class="social-media-icon google-plus" href="<?php echo esc_url( pinboard_get_option( 'googleplus_link' ) ); ?>">Google+</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'dribble_link' ) ) : ?>
			<a class="social-media-icon dribble" href="<?php echo esc_url( pinboard_get_option( 'dribble_link' ) ); ?>">Dribble</a>
			<?php endif; ?>
			<?php if( '' != pinboard_get_option( 'linkedin_link' ) ) : ?>
			<a class="social-media-icon linkedin" href="<?php echo esc_url( pinboard_get_option( 'linkedin_link' ) ); ?>">LinkedIn</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>