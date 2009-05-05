<div id="sidebar">
<span class="header"></span><div class="content">
<div class="transparent"></div>
<div class="text">
    <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
    
    <? else : ?>
        <div class="categories box">
        	<h3><?php _e('Category:'); ?></h3>
        	<ul>
        	    <?php wp_list_cats('sort_column=name&hierarchical=1'); ?>
        	</ul>
        </div>
        <div class="archive box">
        	<h3><?php _e('Archives:'); ?></h3>
        	<ul>
        	    <?php wp_get_archives('type=monthly'); ?>
        	</ul>
        </div>
    <?php endif; ?>
</div>
    </div>
    <span class="footer"></span>
</div>