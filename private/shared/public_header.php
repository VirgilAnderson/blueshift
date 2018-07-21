<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo url_for('/stylesheets/bootstrap.min.css'); ?>" />
    <title>Blue Shift tech: Staff Page</title>
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff_styles.css'); ?>" />
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top navbar-expand-sm">
      <div class="container">

        <a class="navbar-brand text-uppercase  d-sm-inline-block" href="<?php echo url_for('index.php'); ?>"><img class="d-inline mr-2" src="<?php echo url_for('/images/logo.png'); ?>" style="width: 40px" alt="Blue Shift Staff Page"><span class="font-weight-bold">BlueShift</span> Tech</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myToggleNav" aria-controls="myToggleNav" aria-expanded="false" aria-label="Toggle Navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="myToggleNav">
          <span class="navbar-text text-capitalize d-sm-none d-lg-inline ml-auto mr-auto">Not just a website; a marketing <em class="font-weight-bold">solution</em>!</span>
          <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="<?php echo url_for('index.php'); ?>">Home</a>
            <a class="nav-item nav-link" href="#">Mission</a>
            <a class="nav-item nav-link" href="#">Services</a>
            <a class="nav-item nav-link" href="#">Blog</a>
            <a class="nav-item nav-link" href="<?php echo url_for('/staff/login.php'); ?>">Login</a>
          </div><!-- navbar -->
        </div><!-- .collapse -->

      </div><!-- container -->
    </nav><!-- nav -->
