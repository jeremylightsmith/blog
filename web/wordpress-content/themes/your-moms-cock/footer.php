				<div id='footer'>
					<div id='footerinner'>
						<ul>
							<?php 	/* Widgetized sidebar, if you have the plugin installed. */
							if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
							<?php endif; ?>
						</ul>
					</div>
					<br />
					<div id='footnotes'>
					<!--Leaving me credit would be appreciated-->
						Outside The Box Wordpress Theme by <a href='http://megodbike.flashmedia.biz'>Nathan Edwards</a>
						<br /><a href="#">Back to Top</a>
					</div>
				</div>
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>