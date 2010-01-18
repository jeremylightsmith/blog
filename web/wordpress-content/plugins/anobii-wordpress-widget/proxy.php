<?php
/*  Copyright 2008  Giacomo Boccardo  (email : gboccard@gmail.com)

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
/* Modified by Walter Franchetti (email:walter.franchetti@gmail.com) */	
	
	$uid = $_GET['uid'];
	$nBooks = $_GET['nBooks'];
	$coverSize = $_GET['coverSize'];
	$recent = $_GET['recent'];
	$progress = $_GET['progress'];
	
    $parameters = "p=$uid&count=$nBooks&img=$coverSize&recent=$recent&progress=$progress&title=title&subtitle=subtitle&author=author&link_to=1";
	$url1 = "http://www.anobii.com/anobi/badge_generator.php?".$parameters;
	$url2 = "http://image.anobii.com/anobi/badge_generator.php?".$parameters;
	

	$ret = file_get_contents_ext($url1);
	
	if ( $ret == "" ) {
		$ret = file_get_contents_ext($url2);
	}
	
	echo $ret;


	function file_get_contents_ext ($host) {
		
		$inis = ini_get_all();
		
		if ( $inis['allow_url_fopen']['global_value'] ) {
			
			$file_contents = file_get_contents($host);
			
		} else {
			
			$ch = curl_init();
			$timeout = 5;
			curl_setopt ($ch, CURLOPT_URL, $host);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	
			$file_contents = curl_exec($ch);
			curl_close($ch);
			
		}

		return $file_contents;
		
	}
?>



