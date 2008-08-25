<h2>Site search</h2>
<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
<label for="s">Search for:</label>
<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" size="14" />
<input type="hidden" id="searchsubmit" value="Search" />
</div>
</form>