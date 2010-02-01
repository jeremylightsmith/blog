<?php get_header(); ?>

<div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div <?php post_class(); ?>>

<h2><?php the_title(); ?></h2>
<?php edit_post_link(__('Edit', 'zen'),'<p class="edit">','</p>'); ?>

<div class="attachment">
<a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a>
<?php the_content(); ?>

<?php
$args = array(
	'post_type' => 'attachment',
	'post_mime_type' => 'image',
	'numberposts' => -1,
	'post_status' => null,
	'post_parent' => $post->ID
	); 
$images = get_posts($args);
if( $images> 1 ) :?>
<h3><?php _e('More images posted under', 'zen');?> <a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a></h3>

<ul class="prevnext">
<li class="prev_img"><?php previous_image_link(); ?></li>
<li class="next_img"><?php next_image_link();?></li>
</ul>

<?php else :?>
<p><small><?php _e('Posted under', 'zen');?> <a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a></small></p>

<?php endif;?>
 </div>

<?php endwhile; endif; ?>
<!-- end post -->
</div>

<?php get_footer(); ?>