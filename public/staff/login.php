<?php require_once('../../private/initialize.php'); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container mt-4">

<h2>Login</h2>

<form>

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
