<?php require_once('../../../private/initialize.php'); ?>
<?php include(SHARED_PATH . '/staff_header.php');

if(is_post_request()) {

  // Handle form values submitted by new.php

  $admin = [];
  $admin['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
  $admin['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
  $admin['email'] = isset($_POST['email']) ? $_POST['email'] : '';
  $admin['username'] = isset($_POST['username']) ? $_POST['username'] : '';
  $admin['password'] = isset($_POST['password']) ? $_POST['password'] : '';
  $admin['confirm_password'] = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

  $result = insert_admin($admin);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    redirect_to(url_for('/staff/admins/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $admin = [];
  $admin["first_name"] = '';
  $admin["last_name"] = '';
  $admin["email"] = '';
  $admin["username"] = '';
  $admin['password'] = '';
  $admin['confirm_password'] = '';
}


?>

<?php $page_title = "New Admin"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/admins/index.php'); ?>">Admins</a></li>
    <li class="breadcrumb-item active">New Lead</li>
  </ol>

  <form class="col-sm-6" action="<?php echo url_for('/staff/admins/new.php'); ?>"  method="post">
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
          <label class="form-control-label" for="email">Email</label>
          <input class="form-control" type="text" name="email" >
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="username">Username</label>
          <input class="form-control" type="text" name="username">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="password">Password</label>
          <input class="form-control" type="password" name="password">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="confirm_password">Confirm Password</label>
          <input class="form-control" type="password" name="confirm_password">
        </div><!-- form-group -->


        <button class="btn btn-outline-info" type="submit">Create New User</button>

      </fieldset><!-- fieldset -->
    </form>
</div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
