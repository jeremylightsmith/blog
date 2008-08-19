<?php
/*
 * Wordpress 2.5 Flickr media button panel setup
 */
function media_upload_flickr_form() {
	global $type, $tab, $post_mime_types, $flickr_manager;
	
	add_filter('media_upload_tabs', array($flickr_manager, 'modifyMediaTab'));
	?>
	
	<div id="media-upload-header">
		<?php media_upload_header(); ?>
	</div>
	
    <?php
    
    flickrMediaBrowse();
    
}

/*
 * Flickr media browse panel
 */
function flickrMediaBrowse() {
	global $type, $tab, $flickr_manager, $flickr_settings;
	ini_set('display_errors', 0);
	?>
	
	<input type="hidden" id="wfm-ajax-url" value="<?php echo $flickr_manager->getAbsoluteUrl(); ?>" />
	<form id="flickr-form" class="media-upload-form type-form validate" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<?php
		$settings = $flickr_settings->getSettings();
		
		if(!empty($settings['token'])) {
			$params = array('auth_token' => $settings['token']);
			$auth_status = $flickr_manager->call('flickr.auth.checkToken',$params, true);
			if($auth_status['stat'] != 'ok') {
				echo '<h3>Error: Please authenticate through <a href="'.get_option('siteurl')."/wp-admin/options-general.php?page=$flickr_manager->plugin_directory/$flickr_manager->plugin_filename\">Options->Flickr</a></h3>";
				return;
			}
		} else {
			echo '<h3>Error: Please authenticate through <a href="'.get_option('siteurl')."/wp-admin/options-general.php?page=$flickr_manager->plugin_directory/$flickr_manager->plugin_filename\">Options->Flickr</a></h3>";
			return;
		}
		?>
		
		<div id="wfm-close-block" class="right">
			<label><input type="checkbox" name="wfm-close" id="wfm-close" value="true" checked="checked" /> Close on insert</label>
		</div>
		
		<h3 id="wfm-media-header">Browse Flickr</h3>
				
		<div id="wfm-browse-content">
			
			<?php
			// Load Settings
			$_REQUEST['wfm-lightbox'] = (empty($_REQUEST['wfm-lightbox'])) ? $settings['lightbox_enable'] : $_REQUEST['wfm-lightbox'];
			$_REQUEST['wfm-page'] = (empty($_REQUEST['wfm-page'])) ? '1' : $_REQUEST['wfm-page'];
			$_REQUEST['wfm-per_page'] = (!empty($settings['per_page'])) ? $settings['per_page'] : '5';
			$_REQUEST['wfm-size'] = (!empty($_REQUEST['wfm-size'])) ? $_REQUEST['wfm-size'] : "thumbnail";
			$_REQUEST['wfm-scope'] = (!empty($_REQUEST['wfm-scope'])) ? $_REQUEST['wfm-scope'] : "Personal";
			
			$size = ($settings['browse_check'] == "true") ? $settings['browse_size'] : $_REQUEST['wfm-size'];
			$lightbox_default = ($settings['lightbox_default']) ? $settings['lightbox_default'] : "medium";
			
			
			// Request Photos
			$params = array('extras'	=> 'original_format,license,owner_name',
							'per_page'	=> $_REQUEST['wfm-per_page'],
							'page' 		=> $_REQUEST['wfm-page']);
			
			if(!empty($_REQUEST['wfm-filter'])) {
				$params = array_merge($params,array('tags' => $_REQUEST['wfm-filter'],'tag_mode' => 'all'));
			} elseif($_REQUEST['wfm-scope'] == "Public") {
				$params = array_merge($params,array('text' => " "));
			}
			
			if($_REQUEST['wfm-scope'] == "Personal") {
				$params = array_merge($params, array('user_id' => $settings['nsid'], 'auth_token' => $settings['token']));
				if(!empty($_REQUEST['wfm-photoset'])) {
					$params = array('per_page'		=> $_REQUEST['wfm-per_page'],
									'page' 			=> $_REQUEST['wfm-page'], 
									'extras' 		=> 'original_format,license,owner_name',
									'photoset_id' 	=> $_REQUEST['wfm-photoset'], 
									'auth_token' 	=> $settings['token']);
					
					if(!empty($_REQUEST['wfm-filter']))
						$params = array_merge($params,array('tags' => $_REQUEST['wfm-filter'],'tag_mode' => 'all'));
					
					$photos = $flickr_manager->call('flickr.photosets.getPhotos', $params, true);
					$photos['photos'] = $photos['photoset'];
					unset($photos['photoset']);
					$owner = $photos['photos']['owner'];
				} else {
					$photos = $flickr_manager->call('flickr.photos.search', $params, true);
				}
			} else {
				$licences = $flickr_manager->call('flickr.photos.licenses.getInfo',array());
				$licence_search = array();
				for($i = 1; $i < count($licences['licenses']['license']); $i++) {
					array_push($licence_search,$i);
				}
				$licence_search = implode(',', $licence_search);
				$params = array_merge($params, array('license' => $licence_search));
				
				$photos = $flickr_manager->call('flickr.photos.search', $params, true);
			}
			
			if(is_array($photos['photos']['photo']) && count($photos['photos']['photo']) > 0) : 
			
			// Display Photos
			foreach ($photos['photos']['photo'] as $photo) : 
				if($_REQUEST['wfm-scope'] == "Personal" && !empty($_REQUEST['wfm-photoset'])) 
					$photo['owner'] = $owner;
			?>
			
				<div class="flickr-img" id="flickr-<?php echo $photo['id']; ?>">
				
					<img src="<?php echo $flickr_manager->getPhotoUrl($photo,$size); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" <?php 
						if($flickr_settings->getSetting('is_pro') == '1') echo 'longdesc="' . $flickr_manager->getPhotoUrl($photo, 'original') . '"';
					?> />
					
					<?php 
					if($_REQUEST['wfm-scope'] == "Public") {
						foreach ($licences['licenses']['license'] as $licence) {
							if($licence['id'] == $photo['license']) {
								if($licence['url'] == '') $licence['url'] = "http://www.flickr.com/people/{$photo['owner']}/";
								echo "<br /><small><a href='{$licence['url']}' title='{$licence['name']}' rel='license' id='license-{$photo['id']}' onclick='return false;'><img src='".$flickr_manager->getAbsoluteUrl()."/images/creative_commons_bw.gif' alt='{$licence['name']}'/></a> by {$photo['ownername']}</small>";
							}
						}
					}
					?>
					<input type="hidden" id="url-<?php echo $photo['id']; ?>" value="<?php echo $flickr_manager->getPhotoUrl($photo, $_REQUEST['wfm-size']); ?>" />
					<input type="hidden" id="owner-<?php echo $photo['id']; ?>" value="<?php echo $photo['owner'] . "|". htmlspecialchars($photo['ownername']); ?>" />
					
				</div>
			
			<?php endforeach; 
			
			else : ?>
			
				<div class="error">
					<h3>No photos found</h3>
				</div>
			
			<?php endif; ?>
			
		</div>
		<div id="wfm-dashboard">
			
			<span id="wfm-scope-block">
					<label><input type="radio" name="wfm-scope" id="flickr-personal" value="Personal" checked="checked" /> Personal</label>
					<label><input type="radio" name="wfm-scope" id="flickr-public" value="Public" /> Public</label>
			</span>
		
			<div id="wfm-navigation">
				<div id="wfm-set-block" class="left">
			
				<?php if($_REQUEST['wfm-scope'] == "Personal") : ?>
				
				<select name="wfm-photoset" id="wfm-photoset">
					<option value="" <?php if(empty($_REQUEST['wfm-photoset'])) echo 'selected="selected"'; ?>></option>
							
					<?php	
					$photosets = $flickr_manager->call('flickr.photosets.getList', array('user_id' => $settings['nsid']), true);
					foreach ($photosets['photosets']['photoset'] as $photoset) :
					?>
					
					<option value="<?php echo $photoset['id']; ?>" <?php if($_REQUEST['wfm-photoset'] == $photoset['id']) echo 'selected="selected"'; ?>><?php echo $photoset['title']['_content']; ?></option>
				
					<?php endforeach; ?>
				
				</select> 
				
					<?php if(!empty($_REQUEST['wfm-photoset'])) : ?>
					<a href="#" id="wfm-entire-set" title="Insert Set">+</a>
					<?php endif; ?>
					
				<?php endif; ?>
				
				</div>
				
			
				<?php if($_REQUEST['wfm-page'] > 1) :?>
		
				<a href="#?&amp;wfm-page=1" title="&laquo; First Page" >&laquo;</a>&nbsp;
				<a href="#?&amp;wfm-page=<?php echo $_REQUEST['wfm-page'] - 1; ?>" title="&lsaquo; Previous Page">&lsaquo;</a>&nbsp;
				
				<?php endif; ?>
				
				<label><input type="text" name="wfm-filter" id="wfm-filter" value="<?php echo $_REQUEST['wfm-filter']; ?>" /></label>
				<input type="hidden" name="wfm-page" id="wfm-page" value="<?php echo $_REQUEST['wfm-page']; ?>" />
				<input type="hidden" name="wfm-size" id="wfm-size" value="<?php echo $_REQUEST['wfm-size']; ?>" />
				<input type="hidden" name="wfm-filter-old" id="wfm-filter-old" value="<?php echo $_REQUEST['wfm-filter']; ?>" />
				<input type="hidden" name="wfm-blank" id="wfm-blank" value="<?php echo $settings['new_window']; ?>" />
				<input type="submit" class="button" name="button" value="Search" id="wfm-filter-submit" />
				
				<?php if($_REQUEST['wfm-page'] < $photos['photos']['pages']) :?>
				
				&nbsp;<a href="#?&amp;wfm-page=<?php echo $_REQUEST['wfm-page'] + 1; ?>" title="Next Page &rsaquo;">&rsaquo;</a>
				&nbsp;<a href="#?&amp;wfm-page=<?php echo $photos['photos']['pages']; ?>" title="Last Page &raquo;">&raquo;</a>
				
				<?php endif; ?>
			</div>
			
			<h3>Options</h3>
			<div class="right">
				<label>Insert with JS viewer: <input type="checkbox" id="wfm-lightbox" name="wfm-lightbox" value="true" <?php if($_REQUEST['wfm-lightbox'] == "true") echo 'checked="checked"'; ?>/></label>
				<div id="wfm-lbsize-block"><label>JS viewer size: <select name="wfm-lbsize" id="wfm-lbsize">
				<?php
				$lightbox_sizes = array("small","medium","large");
				$lightbox_default = (empty($settings['lightbox_default'])) ? "medium" : $settings['lightbox_default'];
				if($settings['is_pro'] == '1') $lightbox_sizes = array_merge($lightbox_sizes, array("original"));
				foreach ($lightbox_sizes as $lightbox_size) {
					echo "<option value=\"flickr-$lightbox_size\"";
					if($lightbox_default == $lightbox_size) echo ' selected="selected"';
					echo ">" . ucfirst($lightbox_size) . "</option>\n";
				}
				?>
				</select></label></div>
			</div>
			
			<p><?php 
			$sizes = array("square", 'thumbnail', 'small', 'medium', 'large'); 
			if($settings['is_pro'] == '1') $sizes = array_merge($sizes, array('original'));
			?><label>Image Size: <select name="wfm-size" id="wfm-size">
			
				<?php
				foreach ($sizes as $v) {
					echo '<option value="' . strtolower($v) . '" ';
					if($v == $_REQUEST['wfm-size']) echo 'selected="selected" ';
					echo '>' . ucfirst($v) . "</option>\n";
				}
				?>
				
			</select></label></p>
			
			<label><input type="checkbox" name="wfm-insert-set" id="wfm-insert-set" value="true" <?php if($_REQUEST['wfm-insert-set'] == "true") echo 'checked="checked"'; ?> /> Insert into a set </label>
			<label id="wfm-set-name-label">with the name: <input type="text" name="wfm-set-name" id="wfm-set-name" value="<?php echo $_REQUEST['wfm-set-name']; ?>" style="width: 70px; padding: 2px;" /></label>
			
			<input type="hidden" name="wfm-insert-before" id="wfm-insert-before" value="<?php 
				$settings['before_wrap'] = str_replace("\n", "", $settings['before_wrap']);
				echo rawurlencode($settings['before_wrap']);
			?>" />
			
			<input type="hidden" name="wfm-insert-after" id="wfm-insert-after" value="<?php 
				$settings['after_wrap'] = str_replace("\n", "", $settings['after_wrap']);
				echo rawurlencode($settings['after_wrap']);
			?>" />
			
		</div>
		
	</form>
	
	<?php
}


function flickrMediaUpload() {
	global $flickr_manager, $flickr_settings;
	
	$token = $flickr_settings->getSetting("token");
	if(!empty($token)) {
		$params = array('auth_token' => $token);
		$auth_status = $flickr_manager->call('flickr.auth.checkToken',$params, true);
		if($auth_status['stat'] != 'ok') {
			echo '<h3>Error: Please authenticate through <a href="'.get_option('siteurl')."/wp-admin/options-general.php?page=$flickr_manager->plugin_directory/$flickr_manager->plugin_filename\">Options->Flickr</a></h3>";
			return;
		}
	} else {
		echo '<h3>Error: Please authenticate through <a href="'.get_option('siteurl')."/wp-admin/options-general.php?page=$flickr_manager->plugin_directory/$flickr_manager->plugin_filename\">Options->Flickr</a></h3>";
		return;
	}
	?>
	
	<div class="center">
		<iframe id="wfm-uploader" name="wfm-uploader" src="<?php echo $flickr_manager->getAbsoluteUrl(); ?>/upload.php" frameborder="0px"></iframe>
	</div>
	
	<?php
}


class FlickrSettings {
	
	var $settings;
	
	function getSettings() {
		global $flickr_manager;
		if(empty($this->settings)) $this->settings = get_option($flickr_manager->plugin_option);
		return $this->settings;
	}
	
	function getSetting($name) {
		global $flickr_manager;
		if(empty($this->settings)) $this->getSettings();
		return $this->settings[$name];
	}
	
	function saveSetting($name, $value) {
		global $flickr_manager;
		if(empty($this->settings)) $this->getSettings();
		$this->settings[$name] = $value;
		update_option($flickr_manager->plugin_option, $this->settings);
	}
	
}
?>
