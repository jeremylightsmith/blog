</div><!--#main-->

<div id="recent">
    <div class="content">
        
        <div class="box blogroll">
            <h3><?php _e('Blogroll:'); ?></h3>
        	<ul>
        	    <?php get_links(-1, '<li>', '</li>', '', FALSE, 'name', FALSE, FALSE, -1, FALSE); ?>
        	</ul>
        </div>
        <div class="meta box">
        	<h3><?php _e('Meta:'); ?></h3>
        	<ul>
            	<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
            	<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
            	<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
            	<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
            	<?php wp_meta(); ?>
        	</ul>
        </div>
        
        <div class="box posts">
            <h3>Recent Posts</h3>
            <?php query_posts('showposts=5'); ?>
            <ul>
                <?php while (have_posts()) : the_post(); ?>
                <li>
                    <span class="date"><?php the_time('m-d-Y') ?></span> / <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a>
                </li>
            <?php endwhile;?>
            </ul>
        </div>
    </div>
</div><!--#recent-->

<div id="footer">
    <span class="copyright">&copy; <?php echo date('Y');?> Your Name Here. All Rights Reserved.</span>
    <span class="links">
        <a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>" class="rss">Entries <?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a>
        <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>" class="rss">Comments <?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a>
        <a href="<?php bloginfo('url'); ?>/wp-admin/" class="login" title="<?php _e('Login to post an entry'); ?>">Login</a>
        <a href="http://www.aoemedia.de" class="powered"><img src="<?php bloginfo('template_directory'); ?>/images/cubes.gif" alt="OpenSource CMS" /></a>
    </span>
</div><!--#footer-->


<?php wp_footer(); ?>
</div>
</body>
</html>
