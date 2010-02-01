<div class="sidebar">
<ul>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

<li<?php if(is_front_page() || is_home()) echo ' class="current_page_item"';?>><a href="<?php bloginfo('url'); ?>">Home</a></li>
<?php wp_list_pages('title_li=');?>

<?php endif; ?>
</ul>
</div>
