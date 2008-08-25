<div id="extras">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar') ) : else : ?>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<h2>Categories</h2>
<ul>
<?php wp_list_cats('sort_column=name&list=1&optioncount=0&hierarchical=1&children=1&hide_empty=1&feed=RSS'); ?>
</ul>
<?php get_calendar(1); ?>
<h2>Tags</h2>
<ul>
<li><?php wp_tag_cloud('unit=em&smallest=0.8&largest=1.8&number=40'); ?></li>
</ul>
<?php wp_list_bookmarks('title_li=&category_before=&category_after=&show_images=0&show_description=0'); ?> 
<?php wp_meta(); ?>
<?php endif; ?>
</div>