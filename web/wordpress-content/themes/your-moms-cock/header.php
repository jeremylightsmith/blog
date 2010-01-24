<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
		<title><?php bloginfo('name'); wp_title(); ?></title>
		<meta http-equiv='Content Type' content='text/html; charset=UTF-8' />
		<link rel='stylesheet' href='<?php bloginfo('stylesheet_url'); ?>' type='text/css' />
		<link rel="alternate" href="<?php bloginfo('rss2_url'); ?>" type="application/rss+xml" title="RSS 2.0" />
		<script src="<?php bloginfo('stylesheet_directory') ?>/AC_RunActiveContent.js" type="text/javascript"></script> 
		<?php wp_head(); ?>
	</head>
	<body>
		<div id='wrapper'>
			<div id='wrappertitle'>
				<div id="title">
					<h1 id="logo"><a href='<?php bloginfo('url'); ?>'><?php bloginfo('name'); ?></a></h1>
					<h5><?php bloginfo('description'); ?></h5>
					<ul id="nav">
						<li><a href='<?php bloginfo('url'); ?>'>Blog</a></li>
						<?php wp_list_pages('depth=1&title_li='); ?>
					</ul>
					<div id='search'>
						<h3>Search</h3>
						<form method='get' id='searchform' action='<?php bloginfo('url'); ?>/'>
							<input type='text' name='s' class='search' size='30' />
						</form>
					</div>
				</div>
			</div>
			<div id='mainwrapper'>
