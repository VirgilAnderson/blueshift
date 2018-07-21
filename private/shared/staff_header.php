<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo url_for('/stylesheets/bootstrap.min.css'); ?>" />
    <title>Blue Shift tech: Staff Page</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff_styles.css'); ?>" />
  </head>
  <body class="bg-light">
    <nav class="navbar navbar-dark  navbar-expand-sm">
      <div class="container">

        <a class="navbar-brand text-uppercase  d-sm-inline-block" href="<?php echo url_for('/staff/index.php'); ?>"><img class="d-inline mr-2" src="<?php echo url_for('/images/logo.png'); ?>" style="width: 40px" alt="Blue Shift Staff Page">Blueshift Tech</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myToggleNav" aria-controls="myToggleNav" aria-expanded="false" aria-label="Toggle Navigation">
          <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="myToggleNav">

          <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="<?php echo url_for('staff/index.php'); ?>">Dashboard</a>
            <a class="nav-item nav-link" href="#">Leads</a>
            <a class="nav-item nav-link" href="#">Tasks</a>
            <a class="nav-item nav-link" href="#">Projects</a>
            <a class="nav-item nav-link" href="#">Analytics</a>
          </div><!-- navbar -->
          <form class="form-inline d-none d-lg-inline-block ml-4">
            <input class="form-control form-control-sm" type="text" placeholder="Search">
            <button class="btn btn-sm btn-outline-light" type="submit">Go</button>
          </form>
        </div><!-- .collapse -->

        <div class="dropdown d-none d-lg-inline ml-2">
          <button class="dropbtn"><img class="img-fluid rounded-circle" src="<?php echo url_for('/images/user.png'); ?>" width="25px"></button>
          <div class="dropdown-content">
            <a href="#">Lists</a>
            <a href="#">Users</a>
            <a href="#">Edit Site</a>
            <a href="#">Logout</a>
          </div>
        </div>

      </div><!-- container -->
    </nav><!-- nav -->
