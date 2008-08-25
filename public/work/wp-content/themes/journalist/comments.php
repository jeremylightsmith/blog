<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');

if (!empty($post->post_password)) { // if there's a password
	if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
		?>
		
		<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
		
		<?php
		return;
	}
}

/* This variable is for alternating comment background */
$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<a name="comments" id="comments"></a>

<?php if ($comments) : ?>
<h3 class="reply"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to '<?php the_title(); ?>'</h3> 
<p class="comment_meta">Subscribe to comments with <?php comments_rss_link('RSS'); ?> 
<?php if ( pings_open() ) : ?>
	or <a href="<?php trackback_url() ?>" rel="trackback">TrackBack</a> to '<?php the_title(); ?>'.
<?php endif; ?>
</p>

<ol class="commentlist">

<?php foreach ($comments as $comment) : ?>

<li id="comment-<?php comment_ID() ?>" class="<?php echo tj_comment_class() ?>">
	<div class="comment_mod">
	<?php if ($comment->comment_approved == '0') : ?>
	<em>Your comment is awaiting moderation.</em>
	<?php endif; ?>
	</div>
	
	<div class="comment_text">
	<?php comment_text() ?>
	</div>
	
	<div class="comment_author">
	<?php if (function_exists('get_avatar')) { ?>
	<?php echo get_avatar(get_comment_author_email(), '32'); ?>
	<?php } ?>
	<p><strong><?php comment_author_link() ?></strong></p>
	<p><small><?php comment_date('j M y') ?> at <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a> <? edit_comment_link(__('Edit', 'sandbox'), ' ', ''); ?></small></p>
	</div>
	<div class="clear"></div>
</li>

<?php endforeach; /* end for each comment */ ?>

</ol>

<?php else : // this is displayed if there are no comments so far ?>

<?php if ('open' == $post-> comment_status) : ?> 
<!-- If comments are open, but there are no comments. -->

<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments">Comments are closed.</p>

<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post-> comment_status) : ?>

<a name="respond" id="respond"></a>

<h3 class="reply">Leave a Reply</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<div class="postinput">
<?php if ( $user_ID ) : ?>

<p class="logged">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>

<?php else : ?>
<p><input class="comment" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small>Name <?php if ($req) _e('(required)'); ?></small></label></p>

<p><input class="comment" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small>Mail (will not be published) <?php if ($req) _e('(required)'); ?></small></label></p>

<p><input class="comment" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small>Website</small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input class="submit" name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" title="Please review your comment before submitting" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>
</div>
</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>