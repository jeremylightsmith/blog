<html>
<head>
  <title>Brian Light Building Services<?php if ($title) { echo " - $title"; } ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-responsive.min.css" media="all" rel="stylesheet" type="text/css">
  <link href="css/style.css" media="all" rel="stylesheet" type="text/css">
</head>
<body class="<?php echo $css ?>">
  <div class="navbar-wrapper">
    <div class="navbar navbar-static-top">
      <div class="navbar-inner">
        <div class="container">
        <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="index"><img src="images/logo.png"/></a>
        <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
        <div class="nav-collapse collapse">
          <ul class="nav pull-right">
            <!-- <li<?php if ($title == "") { echo " class='active'"; } ?>><a href="index">Home</a></li> -->
            
            <li<?php if ($title == "About") { echo " class='active'"; } ?>><a href="about"><span>About</span> Get to know me</a></li>
            <li<?php if ($title == "Services") { echo " class='active'"; } ?>><a href="services"><span>Services</span> How I can help</a></li>
            <li<?php if ($title == "Testimonials") { echo " class='active'"; } ?>><a href="testimonials"><span>Testimonials</span> From happy clients</a></li>
            <li<?php if ($title == "Past Projects") { echo " class='active'"; } ?>><a href="past_projects"><span>Projects</span> See my work</a></li>
            <li<?php if ($title == "Get a Bid") { echo " class='active'"; } ?>><a href="get_a_bid"><span>Contact</span> Get a bid</a></li>
          </ul>
        </div>
        </div>
      </div>
    </div>
  </div>

<div class="container">
  <div class="row">
