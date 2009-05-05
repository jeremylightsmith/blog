<?php
ini_set('display_errors',1);
require_once("../../../wp-config.php");
require_once("../../../wp-includes/wp-db.php");
require_once("../../../wp-includes/pluggable.php");
global $flickr_manager, $flickr_settings;

get_currentuserinfo();
$upload_level = $flickr_settings->getSetting("upload_level");
if(intval($userdata->user_level) < intval($upload_level)) {
	die("You do not have permission to upload photos to this stream, you may adjust this in the settings page!");	
}

if(isset($_FILES['uploadPhoto'])) {
	$token = $flickr_settings->getSetting('token');

	/* Perform file upload */
	$file = $_FILES['uploadPhoto'];
	if($file['error'] == 0) {
		
		$params = array('auth_token' => $token, 'photo' => '@'.$file['tmp_name']);
		if(isset($_POST['photoTitle']) && !empty($_POST['photoTitle'])) $params = array_merge($params,array('title' => $_POST['photoTitle']));
		if(isset($_POST['photoTags']) && !empty($_POST['photoTags'])) $params = array_merge($params,array('tags' => $_POST['photoTags']));
		if(isset($_POST['photoDesc']) && !empty($_POST['photoDesc'])) $params = array_merge($params,array('description' => $_POST['photoDesc']));
		$rsp = $flickr_manager->upload($params);
		
		if($rsp !== false) {
		
			$xml_parser = xml_parser_create();
			xml_parse_into_struct($xml_parser, $rsp, $vals, $index);
			xml_parser_free($xml_parser);
			
			$pindex = $index['PHOTOID'][0];
			$pid = $vals[$pindex]['value'];
			$upload_success = true;
		}
	}
}
?>
<html>

<head>
	<link rel='stylesheet' href='<?php echo get_option('siteurl'); ?>/wp-admin/css/global.css' type='text/css' />
	<link rel='stylesheet' href='<?php echo get_option('siteurl'); ?>/wp-admin/wp-admin.css' type='text/css' />
	<link rel="stylesheet" href="<?php echo $flickr_manager->getAbsoluteUrl(); ?>/css/admin_style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo get_option('siteurl'); ?>/wp-admin/css/colors-fresh.css?version=2.5" type="text/css" />
</head>

<body class="wp-admin">
	<div id="uploadContainer">
		<form id="file_upload_form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="padding: 0px 20px;">
			<?php if($upload_success) : ?>
			
				<div id="wfm-success">
					<strong>Image successfully uploaded</strong>
				</div>
			
			<?php endif; ?>
			<h3>Upload Photo</h3>
			
			<table>
				<tbody>
					<tr>
						<td><label for="uploadPhoto">Upload Photo:</label></td>
						<td><input type="file" name="uploadPhoto" id="uploadPhoto" /></td>
					</tr>
					<tr>
						<td><label for="photoTitle">Title:</label></td>
						<td><input type="text" name="photoTitle" id="flickrTitle" /></td>
					</tr>
					<tr>
						<td><label for="photoTags">Tags:</label></td>
						<td><input type="text" name="photoTags" id="flickrTags" /> <sup>*Space separated list</sup></td>
					</tr>
					<tr>
						<td><label for="photoDesc">Description:</label></td>
						<td><textarea name="photoDesc" id="flickrDesc" rows="4"></textarea></td>
					</tr>
				</tbody>
			</table>
			<p class="submit" style="text-align: right;">
				<input type="submit" name="Submit" class="button submit" value="<?php _e('Upload &raquo;') ?>" />
				<input type="hidden" name="faction" id="flickr-action" value="<?php echo $_REQUEST['faction']; ?>" />
			</p>
			
		</form>
	</div>
</body>

</html>
