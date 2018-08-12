<?php require_once('../../../private/initialize.php');
require_login();
$admin_set = find_all_admins();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/company/index.php'));
}
$id = $_GET['id'];
$company_name = '';
$company_address = '';
$company_city = '';
$company_state = '';
$company_zip = '';
$company_url = '';
$company_phone = '';


if(is_post_request()) {

  // Handle form values submitted by new.php

  $company = [];
  $company['id'] = $id;
  $company['company_name'] = isset($_POST['company_name']) ? $_POST['company_name'] : '';
  $company['company_address'] = isset($_POST['company_address']) ? $_POST['company_address'] : '';
  $company['company_city'] = isset($_POST['company_city']) ? $_POST['company_city'] : '';
  $company['company_state'] = isset($_POST['company_state']) ? $_POST['company_state'] : '';
  $company['company_zip'] = isset($_POST['company_zip']) ? $_POST['company_zip'] : '';
  $company['company_url'] = isset($_POST['company_url']) ? $_POST['company_url'] : '';
  $company['company_phone'] = isset($_POST['company_phone']) ? $_POST['company_phone'] : '';
  $company['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';

  $result = update_company($company);
  if($result === true){
    redirect_to(url_for('/staff/company/show.php?id=' . $id));
  } else {
    $errors = $result;
    // var_dump($errors);
  }

} else {
  $company = find_company_by_id($id);
}

 ?>
<?php $page_title = "Edit Company"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/company/index.php'); ?>">Company</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/company/show.php?id=' . h(u($company['id']))); ?>"><?php echo h($company['company_name']);?></a></li>
    <li class="breadcrumb-item"><a>Edit company</a></li>
  </ol>



  <form class="col-sm-6" action="<?php echo url_for('/staff/company/edit.php?id=' . h(u($id))); ?>" method="post">
      <h2>Edit <?php echo h($company['company_name']); ?></h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Your Info</legend>

        <div class="form-group">
          <label class="form-control-label" for="company_name">Company Name</label>
          <input class="form-control" type="text" name="company_name" value="<?php echo h($company['company_name']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_address">Company Address</label>
          <input class="form-control" type="text" name="company_address" value="<?php echo h($company['company_address']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_city">Company City</label>
          <input class="form-control" type="text" name="company_city" value="<?php echo h($company['company_city']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_state">Company State</label>
          <input class="form-control" type="text" name="company_state" value="<?php echo h($company['company_state']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_zip">Company Zip</label>
          <input class="form-control" type="text" name="company_zip" value="<?php echo h($company['company_zip']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_url">Company URL</label>
          <input class="form-control" type="text" name="company_url" value="<?php echo h($company['company_url']); ?>">
        </div><!-- form-group -->


        <div class="form-group">
          <label class="form-control-label" for="company_phone">Company Phone</label>
          <input class="form-control" type="text" name="company_phone" value="<?php echo h($company['company_phone']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label for="user_id">company Owner:</label>
            <select class="form-control" name="user_id">
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']); ?>"><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <button class="btn btn-outline-info" type="submit">Edit</button>

      </fieldset><!-- fieldset -->
    </form>
  </div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
