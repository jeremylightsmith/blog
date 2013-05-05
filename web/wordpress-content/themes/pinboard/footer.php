		<?php if( is_front_page() || is_page_template( 'template-landing-page.php' ) || ( is_home() && ! is_paged() ) ) : ?>
			<?php get_sidebar( 'footer-wide' ); ?>
		<?php endif; ?>
		<div id="footer">
			<?php get_sidebar( 'footer' ); ?>
			<div id="copyright">
				<p class="copyright twocol"><?php pinboard_copyright_notice(); ?></p>
				<?php if( pinboard_get_option( 'theme_credit_link' ) || pinboard_get_option( 'author_credit_link' )  || pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
					<p class="credits twocol">
						<?php $theme_credit_link = '<a href="' . esc_url( 'http://www.onedesigns.com/wordpress-themes/pinboard' ) . '" title="' . esc_attr( __( 'Pinboard Theme', 'pinboard' ) ) . '">' . __( 'Pinboard Theme', 'pinboard' ) . '</a>'; ?>
						<?php $author_credit_link = '<a href="' . esc_url( 'http://www.onedesigns.com/' ) . '" title="' . esc_attr( __( 'One Designs', 'pinboard' ) ) . '">' . __( 'One Designs', 'pinboard' ) . '</a>'; ?>
						<?php $wordpress_credit_link = '<a href="' . esc_url( 'http://wordpress.org/' ) . '" title="' . esc_attr( __( 'WordPress', 'pinboard' ) ) . '">' . __( 'WordPress', 'pinboard' ) . '</a>';; ?>
						<?php if( pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s and %3$s', 'pinboard' ), $theme_credit_link, $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && ! pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s', 'pinboard' ), $theme_credit_link, $author_credit_link ); ?>
						<?php elseif( pinboard_get_option( 'theme_credit_link' ) && ! pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'pinboard' ), $theme_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( ! pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'pinboard' ), $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( pinboard_get_option( 'theme_credit_link' ) && ! pinboard_get_option( 'author_credit_link' ) && ! pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'pinboard' ), $theme_credit_link ); ?>
						<?php elseif( ! pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && ! pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'pinboard' ), $author_credit_link ); ?>
						<?php elseif( ! pinboard_get_option( 'theme_credit_link' ) && ! pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'pinboard' ), $wordpress_credit_link ); ?>
						<?php endif; ?>
					</p>
				<?php endif; ?>
				<div class="clear"></div>
			</div><!-- #copyright -->
		</div><!-- #footer -->
	</div><!-- #wrapper -->
<?php wp_footer(); ?>
</body>
</html>