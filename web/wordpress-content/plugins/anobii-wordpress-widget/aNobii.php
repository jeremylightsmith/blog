<?php
/*
Plugin Name: aNobii WordPress Widget
Plugin URI: http://www.jhack.it/wp-anobii
Description: The first plugin which integrates aNobii in Wordpress as a widget
Author: Giacomo Boccardo
Version: 1.1
Author URI: http://www.jhack.it


Copyright 2008  Giacomo Boccardo  (email : gboccard@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/



// Variabili
define('anobiiDirpath','/wp-content/plugins' . strrchr(dirname(__FILE__),'/') . '/');


define("key_anobiiUrl", "anobiiUrl", true);
define("key_nBooks", "nBooks", true);
define("key_recent", "recent", true);
define("key_progress", "progress", true);
define("key_coverSize", "coverSize", true);
define("key_removeNoCover", "removeNoCover", true);


//add_option(key_anobiiUrl, anobiiUrl_default, "Default aNobii profile URL");
//add_option(key_nBooks, anobii_nBooks_default, "Number of books to display");
//add_option(key_coverSize, anobii_coverSize_default, "Size of covers");


$anobii_defaults = array(
	'anobiiUrl'		=> '',
	'nBooks'		=> 6,
	'recent'		=> 0,
	'progress'		=> 3,
	'coverSize'		=> 'small',
	'removeNoCover'	=> false,
	'title'			=> 'aNobii',
	'showCredits'	=> 1
);

function anobii_options_page() {
	global $anobii_defaults;
	
	// If it's called after a POST...
 	if (isset($_POST['anobii_submit'])) 
	{
		$options = (array) get_option('anobii_options');
			
		$options['anobiiUrl'] 		= trim(strip_tags(stripslashes($_POST['anobiiUrl'])));
		$options['nBooks'] 			= intval(strip_tags($_POST['nBooks']));
		$options['recent'] 			= intval(strip_tags($_POST['recent']));
		$options['progress'] 		= intval(strip_tags($_POST['progress']));		
		$options['coverSize'] 		= strip_tags($_POST['coverSize']);
		$options['removeNoCover'] 	= $_POST['removeNoCover'];

		update_option('anobii_options', $options);
	
		// Update message
		echo "<div class='updated'><p><strong>aNobii Options Updated</strong></p></div>";
	}
	
	$options = get_option('anobii_options');

	$anobiiUrl 		= ( $options['anobiiUrl'] != '' ) ? $options['anobiiUrl'] : $anobii_defaults['anobiiUrl'];
	$nBooks 		= ( $options['nBooks'] != '' ) ? $options['nBooks'] : $anobii_defaults['nBooks'];
	$recent 		= ( $options['recent'] != '' ) ? $options['recent'] : $anobii_defaults['recent'];
	$progress 		= ( $options['progress'] != '' ) ? $options['progress'] : $anobii_defaults['progress'];
	$coverSize		= ( $options['coverSize'] != '' ) ? $options['coverSize'] : $anobii_defaults['coverSize'];
	$removeNoCover	= ( $options['removeNoCover'] != '' ) ? $options['removeNoCover'] : $anobii_defaults['removeNoCover'];	
	?>
			
		
	<form method="post" action="options-general.php?page=aNobii.php">

		<div class="wrap">
			<h2>aNobii Plugin Options</h2>
			<p>
				In the following extremely complex form you need to specify the url to the main page of your aNobii's profile using the <strong>alphanumeric format</strong>. 
				<br/>
				If you chose a short format for your aNobii url (e.g.: <a href="http://www.anobii.com/people/jhack">http://www.anobii.com/people/jhack</a> ) you must retrieve your user-id from the Feed RSS url near to the bottom of your aNobii's Home Profile.
				<br />
				Therefore the url you must provide here must be something like <a href="http://www.anobii.com/people/010c51b082b89840a7"> http://www.anobii.com/people/010c51b082b89840a7</a>.
			
			</p>
			<br/>
			<br/>

			<label for="<?php echo key_anobiiUrl; ?>">URL (with alphanumeric ID):</label>
			<?php
				echo "<input type='text' size='50' ";
				echo "name='".key_anobiiUrl."' ";
				echo "id='".key_anobiiUrl."' ";
				echo "value='".$anobiiUrl."' />\n";
			?>
			
			<br/>
			<br/>

			<label for="<?php echo key_progress; ?>">Reading progress:</label>
			<select id="<?php echo key_progress; ?>" name="<?php echo key_progress; ?>">
				<option value="3" <?php echo ( $progress == 3 ) ? 'selected="selected"' : '' ?>>All books on my shelf</option>
				<option value="2" <?php echo ( $progress == 2 ) ? 'selected="selected"' : '' ?>>Reading + Finished</option>
				<option value="1" <?php echo ( $progress == 1 ) ? 'selected="selected"' : '' ?>>Finished only</option>
				<option value="4" <?php echo ( $progress == 4 ) ? 'selected="selected"' : '' ?>>Reading only</option>
			</select>
			
			<br/>
			<br/>
			
			<label for="<?php echo key_nBooks; ?>">Books to show:</label>
			<select id="<?php echo key_nBooks; ?>" name="<?php echo key_nBooks; ?>">
				<?php
					for ($i=1; $i<11; $i++)
					{
						$selected = "";
						if ( $i == $nBooks ) $selected="selected=selected";
						echo "<option value='$i' $selected>$i</option>";
					}
				?>
			</select>	

			<label for="mostRecent">Most recent</label>
			<input id="mostRecent" name="<?php echo key_recent; ?>" value="1" type="radio" <?php echo ( $recent == 1 ) ? 'checked="checked"' : ''; ?> />  

			<label for="random">Random</label>
			<input id="random" name="<?php echo key_recent; ?>" value="0" type="radio" <?php echo ( $recent == 0 or $recent == '') ? 'checked="checked"' : ''; ?> />

			<br/>
			<br/>
			
			<label for="<?php echo key_coverSize; ?>">Cover size:</label>
			<select id="<?php echo key_coverSize; ?>" name="<?php echo key_coverSize; ?>">
				<?php
					$coverSizes=array("small", "large", "square");
					for ($i=0; $i<sizeof($coverSizes); $i++)
					{
						$selected = "";
						if ( $coverSizes[$i] == $coverSize ) $selected="selected=selected";
						echo "<option value='$coverSizes[$i]' $selected>$coverSizes[$i]</option>";
					}
				?>
			</select>
			
			<br/>
			<br/>
				
			<label for="<?php echo key_removeNoCover; ?>">Remove books without cover? </label>
			<input type="checkbox" value="true" id="<?php echo key_removeNoCover; ?>" name="<?php echo key_removeNoCover; ?>" <?php echo ( $removeNoCover ) ? 'checked="checked"' : ''; ?> />
							
			<br/>
			<br/>

												
			<p class="submit">
				<input type='submit' name='anobii_submit' value='Update Options' />
			</p>
		</div>
	</form>
		
	
	<?php
}

function anobii_options_menu() {
	add_options_page('aNobii Plugin Options', 'aNobii Plugin', 8, basename(__FILE__), 'anobii_options_page');
}

function anobii_widget($args)
{
	global $anobii_defaults;
	extract($args);
	
	?>
		<?php			
		
			$options = (array) get_option('anobii_options');

			/*
			$options['title'] =  ( $title == '' ) ? ( ( $options['title'] != '' ) ? $options['title'] : $anobii_defaults['title'] ) : $title;
			$options['nBooks'] =  ( isset($nBooks)  ) ? $nBooks : ( ( isset($options['nBooks']) ) ? $options['nBooks'] : $anobii_defaults['nBooks'] );
			$options['recent'] =  ( isset($recent)  ) ? $recent : ( ( isset($options['recent']) ) ? $options['recent'] : $anobii_defaults['recent'] );
			$options['progress'] =  ( isset($progress)  ) ? $recent : ( ( isset($options['progress']) ) ? $options['progress'] : $anobii_defaults['progress'] );			
			$options['coverSize'] =  ( isset($coverSize)  ) ? $coverSize : ( ( isset($options['coverSize']) ) ? $options['coverSize'] : $anobii_defaults['coverSize'] );
			$options['removeNoCover'] =  ( isset($removeNoCover)  ) ? $coverSize : ( ( isset($options['removeNoCover']) ) ? $options['removeNoCover'] : $anobii_defaults['removeNoCover'] );
			*/
			$nBooks = $options['nBooks'];
			$recent = $options['recent'];
			$progress = $options['progress'];			
			$coverSize = $options['coverSize'];
			$removeNoCover = $options['removeNoCover'];			
			$uid = basename($options['anobiiUrl']);
			$curPath = get_option('siteurl').anobiiDirpath;
			$options['anobiiUrl'] =  ( isset($anobiiUrl)  ) ? $anobiiUrl : ( ( isset($options['anobiiUrl']) ) ? $options['anobiiUrl'] : '' );			
			$options['showCredits'] =  ( isset($showCredits)  ) ? $showCredits : ( ( isset($options['showCredits']) ) ? $options['showCredits'] : $anobii_defaults['showCredits'] );
						
			$before_widget = isset($before_widget) ? $before_widget : '<li id="anobii_widget" class="widget widget_anobii">';
			$before_title = isset($before_title) ? $before_title : '<h2 class="widgettitle">';
			$after_title = isset($after_title) ? $after_title : '</h2>';						
			$after_widget = isset($after_widget) ? $after_widget : '</li>';			

		
			echo $before_widget;
			
			echo $before_title . $options['title'] . $after_title;
		
				echo "<div id=\"anobiiContent\">";

					echo "<div id=\"anobiiHeader\">";
				
						echo "<div id=\"anobiiProfile\"> <a target=\"_blank\" href=\"http://www.anobii.com/people/$uid\">aNobii Profile</a> </div>";
				
						echo "<div id=\"anobiiReload\"> <a  href=\"#\" onclick=\"javascript:anobiiReload();return false;\"><img src=\"$curPath/images/reload.png\" alt=\"Reload the widget\" title=\"Reload the widget\" /></a></div>"; 

					echo "</div>";


					echo "<div id=\"anobiiBooks\">";
						echo "You must configure the plugin";
					echo "</div>";
					
					if ( ! $options['showCredits'] ) $hide = 'class="hide"';

					echo '<div id="anobiiCredits" '. $hide.'>developed by <a href="http://www.jhack.it">Jhack</a></div>';
					
				echo "</div>";
		
				echo "	<script src=\"" . $curPath . "aNobiiWidget-min.js\" type=\"text/javascript\"></script>\n";

				echo "	<script type=\"text/javascript\">anobiiInit(\"$curPath\", \"$uid\", $progress, $nBooks, $recent, \"$coverSize\", ". ($removeNoCover ? 'true' : 'false') .");</script>\n";
	
			
			echo $after_widget; 
		?>
	<?php
}

function anobii_widget_control()
{
	global $anobii_defaults;
	
	if ( $_POST['anobii_submit'] )
	{
		$options = (array) get_option('anobii_options');
					
		$options['title'] 	= strip_tags(stripslashes($_POST['anobii_title']));
		$options['showCredits'] 	= isset($_POST['anobii_showCredits']);
		
		update_option('anobii_options', $options);
	}
	
	$options = get_option('anobii_options');
	
	$title 	= ( $options['title'] != '' ) ? $options['title'] : $anobii_defaults['title'];
	$showCredits 	= isset($options['showCredits']) ? ( $options['showCredits'] ? 'checked="checked"' : '' ) : 'checked="checked"';
	

	echo '<p style="text-align:right;"><label for="anobii_title">Widget Title: <input style="width: 100px;" id="anobii_title" name="anobii_title" type="text" value="'.$title.'" /></label></p>';
	echo '<p style="text-align:right;"><label for="anobii_showCredits">Show credits: <input style="width: 100px;" '. $showCredits.' type="checkbox" id="anobii_showCredits" name="anobii_showCredits"  /></label></p>';	

	echo '<input type="hidden" id="anobii_submit" name="anobii_submit" value="1" />';
}

function anobii_widget_init()
{	
	// Check if the environment supports widgets
	if (!function_exists('register_sidebar_widget'))
    	return;
	
	register_sidebar_widget(array('aNobii Widget', 'widgets'), 'anobii_widget');
	register_widget_control(array('aNobii Widget', 'widgets'), 'anobii_widget_control', 200, 100);
}


function anobii_stylesheet() 
{
	$curPath = get_option('siteurl').anobiiDirpath;
	
	echo "<link rel=\"stylesheet\" href=\"".$curPath."css/aNobiiStyle-min.css\" type=\"text/css\" media=\"screen\" />";	
}


// Create the option menu
add_action('admin_menu', 'anobii_options_menu' );

// Initialize the widget
add_action('widgets_init', 'anobii_widget_init');

// Add stylesheet to head
add_action('wp_head', 'anobii_stylesheet');
?>
