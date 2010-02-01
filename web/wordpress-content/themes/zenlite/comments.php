<?php 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
	echo '<p class="nocomments">'._e('This post is password protected. Enter the password to view comments.','web2zen') .'</p>';
	return;
}
?>

<?php if(have_comments()) : ?>
<h2 id="comments" class="total-comments"><?php comments_number(__('No comments') , '1'.__(' Comment') , '%'.__(' Comments') ); ?> on <?php the_title(); ?></h2>
<?php endif;?>

<?php if ('open' == $post->comment_status) ?><ul class="comment_links">
<?php if ('open' == $post->comment_status) : ?><li><a href="#respond"><?php _e('Add your comment');?></a></li><?php endif;?>
<?php if (have_comments()) : ?><li><?php comments_rss_link('<abbr title="Really Simple Syndication">RSS</abbr> '.__('comments feed for this post') ); ?></li><?php endif;?>
<?php if(pings_open()) : ?><li><a href="<?php trackback_url();?>" rel="trackback">TrackBack <abbr title="Uniform Resource Identifier">URI</abbr></a></li><?php endif;?>
<?php if ('open' == $post->comment_status) ?></ul>

<?php if(have_comments()) : ?>

<?php paginate_comments_links('type=list'); ?>

<ol id="commentlist">
<?php wp_list_comments(); ?>
</ol>

<?php paginate_comments_links('type=list'); ?>

<?php endif;?>

<?php if('open' == $post->comment_status) : ?>
<div id="respond">
<h3><?php comment_form_title(__( 'Leave a comment') , __('Reply to %s')  ); ?></h3>
<div class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></div>

<p class="comment_log_status">
<?php if (get_option('comment_registration') && !$user_ID ) : ?><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment');?>.
<?php elseif($user_ID ) : ?><?php _e('You are currently logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> - <a href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('Log out');?></a><?php endif;?>
</p>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<fieldset>
<legend><?php _e('Add Your Comment');?></legend>

<?php if(!$user_ID) : ?>
<p><label for="author" <?php if($req) echo 'class="req"';?>><?php _e('Name');?> <?php if($req) echo '<small>('.__('required') .')</small>';?></label> <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="20" /></p>
<p><label for="email"<?php if($req) echo 'class="req"';?>><?php _e('Email');?>  <?php if($req) echo '<small>('.__('required but will not be published') .')</small>'; ?></label> <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" /></p>
<p><label for="url"><?php _e('Website');?></label> <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" /></p>
<?php endif; ?>

<p><label for="comment" class="textarea"><span class="req"><?php _e('Comments');?> <small>(<?php _e('required');?>)</small></span></label>
<textarea name="comment" id="comment" cols="100%" rows="10"></textarea></p>

<p class="submit_wrap"><input name="submit" type="submit" class="submit" value="<?php _e('Submit Comment');?>" /> 
<?php do_action('comment_form', $post->ID); ?>
<?php comment_id_fields(); ?></p>
</fieldset>
</form>
</div>

<?php elseif(have_comments()) : ?>
<p class="comments-closed"><strong><?php _e('Sorry, the comment form is now closed.');?></strong></p>
<?php endif;?>
