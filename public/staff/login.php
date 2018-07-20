<?php require_once('../../private/initialize.php'); ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container mt-4">

  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('index.php'); ?>" >Home</a></li>
    <li class="breadcrumb-item active">Login</li>
  </ol>

<form class="col-sm-6">
    <h2>User Login</h2>
    <fieldset class="form-group">
      <legend>Your Info</legend>

      <div class="form-group">
        <label class="form-control-label" for="name">Username</label>
        <input class="form-control" type="text" id="name" placeholder="Username">
      </div><!-- form-group -->

      <div class="form-group">
        <label class="form-control-label" >Password</label>
        <input type="text" class="form-control" placeholder="Password">
      </div><!-- form-group -->

      <button class="btn btn-secondary" type="submit">Login</button>

    </fieldset><!-- fieldset -->
  </form>
</div><!-- content container -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
