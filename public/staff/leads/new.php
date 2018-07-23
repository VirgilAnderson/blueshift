<?php require_once('../../../private/initialize.php');

if(is_post_request()) {

  // Handle form values submitted by new.php

  $individual = [];
  $individual['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
  $individual['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
  $individual['phone_direct'] = isset($_POST['phone_direct']) ? $_POST['phone_direct'] : '';
  $individual['email'] = isset($_POST['email']) ? $_POST['email'] : '';
  $individual['role'] = isset($_POST['role']) ? $_POST['role'] : '';
  $individual['lead_source'] = isset($_POST['lead_source']) ? $_POST['lead_source'] : '';

  $result = insert_individual($individual);
  if($result === true){
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The lead was created successfully.';
    redirect_to(url_for('/staff/leads/show.php?id=' . $new_id ));
  } else {
    $errors = $result;
  }
} else {
  // Display the blank form
  $individual = [];
  $individual['first_name'] = '';
  $individual['last_name'] =  '';
  $individual['phone_direct'] = '';
  $individual['email'] = '';
  $individual['role'] = '';
  $individual['lead_source'] = '';
}


?>



<?php $page_title = "New lead"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/leads/index.php'); ?>">Leads</a></li>
    <li class="breadcrumb-item active">New Lead</li>
  </ol>

  <form class="col-sm-6" action="<?php echo url_for('/staff/leads/new.php'); ?>"  method="post">
      <h2>New Lead</h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Fill in the form to create a new record</legend>

        <div class="form-group">
          <label class="form-control-label" for="first_name">First Name</label>
          <input class="form-control" type="text" name="first_name" >
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="last_name">Last Name</label>
          <input class="form-control" type="text" name="last_name" >
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="phone_direct">Phone</label>
          <input class="form-control" type="text" name="phone_direct" >
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="email">Email</label>
          <input class="form-control" type="text" name="email">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="role">Role</label>
          <input class="form-control" type="text" name="role">
        </div><!-- form-group -->

        <div class="form-group">
          <label for="lead_source">Select list:</label>
            <select class="form-control" name="lead_source">
              <option>Web</option>
              <option>Manual Entry</option>
              <option>Lead List</option>
              <option>Call In</option>
            </select>
        </div><!-- form-group -->
        

        <button class="btn btn-outline-info" type="submit">Create New Lead</button>

      </fieldset><!-- fieldset -->
    </form>
</div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
