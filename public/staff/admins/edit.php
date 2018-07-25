<?php require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];
$first_name = '';
$last_name = '';
$email = '';
$username = '';
$password = '';
$confirm_password = '';


if(is_post_request()) {

  // Handle form values submitted by new.php

  $admin = [];
  $admin['id'] = $id;
  $admin['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
  $admin['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
  $admin['email'] = isset($_POST['email']) ? $_POST['email'] : '';
  $admin['username'] = isset($_POST['username']) ? $_POST['username'] : '';
  $admin['password'] = isset($_POST['password']) ? $_POST['password'] : '';
  $admin['confirm_password'] = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';


  $result = update_admin($admin);
  if($result === true){
    redirect_to(url_for('/staff/admins/show.php?id=' . $id));
  } else {
    $errors = $result;
    // var_dump($errors);
  }

} else {
  $admin = find_admin_by_id($id);
}

 ?>
<?php $page_title = "Edit Admin"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/admins/index.php'); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/admins/show.php?id=' . h(u($admin['id']))); ?>"><?php echo h($admin['first_name']) . " " . h($admin['last_name']);?></a></li>
    <li class="breadcrumb-item"><a>Edit Lead</a></li>
  </ol>



  <form class="col-sm-6" action="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($id))); ?>" method="post">
      <h2>Edit </h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Your Info</legend>

        <div class="form-group">
          <label class="form-control-label" for="first_name">First Name</label>
          <input class="form-control" type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="last_name">Last Name</label>
          <input class="form-control" type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="email">email</label>
          <input class="form-control" type="text" name="email" value="<?php echo h($admin['email']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="username">username</label>
          <input class="form-control" type="text" name="username" value="<?php echo h($admin['username']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="password">password</label>
          <input class="form-control" type="password" name="password" value="<?php echo h($admin['password']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="confirm_password">confirm_password</label>
          <input class="form-control" type="password" name="confirm_password" value="<?php echo h($admin['confirm_password']); ?>">
        </div><!-- form-group -->

        <button class="btn btn-outline-info" type="submit">Edit</button>

      </fieldset><!-- fieldset -->
    </form>
  </div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
