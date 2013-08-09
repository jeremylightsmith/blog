<!DOCTYPE html>
<html lang="en">
<head>
  <title>Brian Light Building Services<?php if ($title) { echo " - $title"; } ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-glyphicons.css" media="all" rel="stylesheet" type="text/css">
  <link href="css/style.css" media="all" rel="stylesheet" type="text/css">
  <script src="js/jquery-1.9.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body class="<?php echo $css ?>">
  <div class="navbar">
    <div class="container">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href="index"><img src="images/logo.png"/></a>

      <div class="nav-collapse collapse">
        <ul class="nav navbar-nav pull-right">
          <!-- <li<?php if ($title == "") { echo " class='active'"; } ?>><a href="index">Home</a></li> -->
          
          <!-- <li<?php if ($title == "About") { echo " class='active'"; } ?>><a href="about"><span>About</span> Get to know me</a></li> -->
          <li<?php if ($title == "Services") { echo " class='active'"; } ?>><a href="services"><span>Services</span> How I can help</a></li>
          <li<?php if ($title == "Testimonials") { echo " class='active'"; } ?>><a href="testimonials"><span>Testimonials</span> From happy clients</a></li>
          <li<?php if ($title == "Projects") { echo " class='active'"; } ?>><a href="past_projects"><span>Projects</span> See my work</a></li>
          <li<?php if ($title == "Contact") { echo " class='active'"; } ?>><a href="get_a_bid"><span>Contact</span> Get a bid</a></li>
        </ul>
      </div>
    </div>
  </div>

  <?php if ($title <> "") { ?>

  <div class="stripe">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1><?php echo $title ?></h1>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>