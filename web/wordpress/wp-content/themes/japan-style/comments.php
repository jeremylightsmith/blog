<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}
?>

<?php if ($comments) : ?>

	<h1 class="comments-title"><?php comments_number('Comments (0)', 'Comments (1)', 'Comments (%)' );?></h1>

	<div id="comments">

		<?php foreach ($comments as $comment) : ?>
			<div class="comment" id="comment-<?php comment_ID() ?>">
			
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 50 ); ?>
				</div>
				
				<div class="comment-content">
					<div class="comment-info"><span><?php comment_author_link() ?></span><?php comment_date('F jS, Y') ?> at <?php comment_time() ?> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></div>
					
					<?php if ($comment->comment_approved == '0') : ?>
						<em>Your comment is awaiting moderation.</em>
					<?php endif; ?>

					<?php comment_text() ?>
				</div>
			</div>
		<?php endforeach; ?>

	</div>

<?php else : // this is displayed if there are no comments so far ?>
 
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->
	<?php endif; ?>
	
<?php endif; ?>



<?php if ('open' == $post->comment_status) : ?>

	<h1 class="comments-title">Leave a comment</h1>

	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			Your comment
			<p><textarea name="comment" id="comment"></textarea></p>
			
			<?php if ( $user_ID ) : ?>
				<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out</a></p>
			<?php else : ?>			
				<p><input type="text" name="author" id="author" class="text" value="<?php echo $comment_author; ?>" />
				<label for="author">Name <?php if ($req) echo "(required)"; ?></label></p>

				<p><input type="text" name="email" id="email" class="text" value="<?php echo $comment_author_email; ?>" />
				<label for="email">Mail (will not be published) <?php if ($req) echo "(required)"; ?></label></p>

				<p><input type="text" name="url" id="url" class="text" value="<?php echo $comment_author_url; ?>" />
				<label for="url">Website</label></p>
			<?php endif; ?>
			
			<?php do_action('comment_form', $post->ID); ?>
			
			<p><input name="submit" type="submit" id="submit" class="bt" value="Submit Comment" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
			
			

		</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
