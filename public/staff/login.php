<?php require_once('../../private/initialize.php'); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container mt-4">

<h2>Help Another Pet</h2>

<form>

    <fieldset class="form-group">
      <legend>Your Info</legend>

      <div class="form-group">
        <label class="form-control-label" for="name">Name</label>
        <input class="form-control" type="text" id="name" placeholder="Your Name">
      </div><!-- form-group -->

      <div class="form-group">
        <label class="form-control-label" for="owneremail">Email</label>
        <input class="form-control" type="text" id="owneremail" placeholder="Address">
      </div><!-- form-group -->

      <div class="form-group">
        <label class="form-control-label" for="donationamt">Donation Amount</label>
        <input type="text" class="form-control" id="donationamt" placeholder="Amount">
      </div><!-- form-group -->

      <button class="btn btn-primary" type="submit">Submit</button>

    </fieldset><!-- fieldset -->
  </form>
</div><!-- content container -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
