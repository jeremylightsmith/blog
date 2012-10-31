<?php get_header();?>

<div id="content">
<div <?php post_class();?>>

<h2 class="post-title">Search Results</h2>

<?php if (have_posts()) : ?>
<ul class="search_results">

<?php while (have_posts()) : the_post(); ?>
<li><h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h3>

<ul class="meta postfoot">
<li>Date: <?php the_time('j F Y');?></li>
<?php if($post->post_type == 'post') :?>
<li>Filed under: <ul><li><?php the_category(',</li> <li>') ?></li></ul></li>
<?php endif;?>
<?php if(get_the_tag_list()) :?>
<li>Tags: <?php the_tags('<ul><li>',',</li> <li>','</li></ul>');?></li>
<?php endif;?>
</ul>

</li>
<?php endwhile; ?>
</ul>

<ul class="prevnext">
<li><?php next_posts_link('&laquo; Older Posts'); ?></li>
<li><?php previous_posts_link('Newer Posts &raquo;');?></li>
</ul>

<?php else : ?>
<p class="sorry">Sorry - I couldn't find anything on '<em><?php echo wp_specialchars($s,1); ?></em>'.</p>
<?php endif; ?>

</div>

<?php get_footer();?>