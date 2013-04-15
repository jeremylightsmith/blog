<html>
<head>
  <title>Jeremy Lightsmith<?php if ($title) { echo " - $title"; } ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
  <link href="stylesheets/bootstrap-responsive.min.css" media="all" rel="stylesheet" type="text/css">
  <link href="stylesheets/new_style.css" media="all" rel="stylesheet" type="text/css">
</head>
<body class="<?php echo $css ?>">

  <div class="navbar-wrapper">
    <div class="navbar navbar-inverse navbar-static-top">
      <div class="navbar-inner">
        <div class="container">
        <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="/">Jeremy Lightsmith</a>
        <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
        <div class="nav-collapse collapse">
          <ul class="nav pull-right">
            <li class="active"><a href="/">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Introducing Agile to Your Company</a></li>
                <li><a href="#">Small Hi-Performing Teams</a></li>
                <li><a href="#">Agility in the Enterprise</a></li>
              </ul>
            </li>
            <li><a href="events">Events</a></li>
            <li><a href="http://onemanswalk.com/work">Articles</a></li>
          </ul>
        </div>
        </div>
      </div>
    </div>
  </div>
