<div id="sidebarcontainer">


<div id="wrap">
<div id="subscriptionoptions">

<div id="rssmain"><a href="feed:<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/rss.png" alt="RSS Feed" width="300" height="116" border="0"/></a></div>
<div class="clear"></div>
</div>



 <!--Main Ad Body End-->


	<div id="sidebar">
	
	<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
		
		


	<h3><?php _e('Main Menu'); ?></h3>

<ul>

<?php wp_list_pages('title_li='); ?>

</ul>

<div class="ad250">
Insert Your Adsense Code here</div>


			<h3>Categories</h3>
			<ul>
				<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
				</ul>

			<h3>Archives</h3>
			
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
		

			<h3>Resources</h3>
			
			<ul>
				<?php get_links('-1', '<li>', '</li>', '<br />'); ?>
				</ul>
			
			
			
			<h3>Meta</h3>
			<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
					<?php wp_meta(); ?>
				</ul>

			
			
<?php endif; ?>
	</div>

