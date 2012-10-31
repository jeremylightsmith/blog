<?php get_header(); ?>

<div id="content">

<?php if(isset($_GET['author_name'])) $curauth = get_userdatabylogin($author_name);
else $curauth = get_userdata(intval($author));?>

<?php if (function_exists('theme_breadcrumb') && $zen_options['breadcrumb'] != 1) echo theme_breadcrumb($curauth->display_name);?>

<div <?php post_class(); ?>>
<h2 class="post-title">About <?php echo $curauth->display_name; ?></h2>
<dl class="author-details">

<?php if( $curauth->user_description !='' ) :?>
<dt class="bio"><?php _e('Bio');?>:</dt>
<dd class="bio"><?php echo $curauth->user_description; ?></dd>
<?php endif;?>

<?php if( $curauth->user_url !='' ) :?>
<dt class="website"><?php _e('Website');?>:</dt>
<dd class="website"><a href="<?php echo $curauth->user_url;?>"><?php echo $curauth->user_url;?></a></dd>
<?php endif;?>

<?php if(function_exists('get_the_author_meta')) :?>
<?php if( get_the_author_meta('jabber', $curauth->ID) != '') :?>
<dt class="jabber"><?php _e('Jabber / Google Talk');?>:</dt>
<dd class="jabber"><?php the_author_meta('jabber', $curauth->ID);?></dd>
<?php endif;?>

<?php if( get_the_author_meta('aim', $curauth->ID) != '') :?>
<dt class="aim"><abbr title="<?php _e('AOL Instant Messenger');?>"><?php _e('AIM');?></abbr>:</dt>
<dd class="aim"><?php the_author_meta('aim', $curauth->ID);?></dd>
<?php endif;?>

<?php if( get_the_author_meta('yim', $curauth->ID) != '') :?>
<dt class="yim"><?php _e('Yahoo');?> <abbr title="<?php _e('Instant Messenger');?>"><?php _e('IM');?></abbr>:</dt>
<dd class="yim"><?php the_author_meta('yim', $curauth->ID);?></dd>
<?php endif;?>

<?php endif;?>
</dl>

<h2 class="posts-by">Posts by <?php echo $curauth->display_name; ?>:</h2>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<h3 class="post-title" id="post-<?php the_ID();?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Post <?php the_ID(); ?> - permanent link"><?php the_title(); ?></a></h3>

<ul class="meta postfoot">
<li>Date: <?php the_time("F j, Y"); ?></li>
<li>Filed under: <ul><li><?php the_category(',</li> <li>') ?></li></ul></li>
<?php if(get_the_tag_list()) :?>
<li>Tags: <?php the_tags('<ul><li>',',</li> <li>','</li></ul>');?></li>
<?php endif;?>
</ul>

<?php endwhile; ?>

<ul class="prevnext">
<li><?php next_posts_link('&laquo; Older Posts'); ?></li>
<li><?php previous_posts_link('Newer Posts &raquo;');?></li>
</ul>

<?php endif; ?>
</div>

<?php get_footer(); ?>