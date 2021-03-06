<?php get_header(); ?>

<div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class();?>id="post-<?php the_ID();?>">
<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Post <?php the_ID(); ?> - permanent link"><?php the_title(); ?></a></h2>

<ul class="meta">
<li><?php the_time("F j, Y"); ?> <?php the_time(); ?></li>
<li><?php edit_post_link('Edit'); ?></li>
</ul>

<div class="postcontent">
<?php the_content(the_title('', '', false)." - continue reading"); ?>
</div>

<?php wp_link_pages('before=<div class="pagelist">Pages:&after=</div>&link_before=&link_after=&pagelink=%');?>

<ul class="meta postfoot">
<?php if('open' == $post->comment_status) : ?><li class="comment_link"><?php comments_popup_link('Comment on '.$post->post_title, '1 Comment on '.$post->post_title, '% Comments on '.$post->post_title,'postcomment','Comments are off for '.$post->post_title); ?></li><?php endif;?>
<li>Author: <?php the_author_posts_link(); ?></li>
<li>Filed under: <ul><li><?php the_category(',</li> <li>') ?></li></ul></li>
<?php if(get_the_tag_list()) :?>
<li>Tags: <?php the_tags('<ul><li>',',</li> <li>','</li></ul>');?></li>
<?php endif;?>
</ul>

</div>

<?php endwhile; ?>

<ul class="prevnext">
<li><?php next_posts_link('&laquo; Older Posts'); ?></li>
<li><?php previous_posts_link('Newer Posts &raquo;');?></li>
</ul>

<?php endif; ?>

<?php get_footer(); ?>