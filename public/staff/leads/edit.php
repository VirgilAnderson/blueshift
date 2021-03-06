<?php require_once('../../../private/initialize.php');
require_login();
$admin_set = find_all_admins();
$admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$company_set = find_all_user_company($admin);
$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
$company = find_company_by_id($company_id);
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/leads/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values submitted by new.php

  $individual = [];
  $individual['id'] = $id;
  $individual['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
  $individual['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
  $individual['phone_direct'] = isset($_POST['phone_direct']) ? $_POST['phone_direct'] : '';
  $individual['email'] = isset($_POST['email']) ? $_POST['email'] : '';
  $individual['role'] = isset($_POST['role']) ? $_POST['role'] : '';
  $individual['lead_source'] = isset($_POST['lead_source']) ? $_POST['lead_source'] : '';
  $individual['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';
  $individual['lead_birthdate'] = isset($_POST['lead_birthdate']) ? $_POST['lead_birthdate'] : '';
  $individual['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';

  $result = update_individual($individual);
  if($result === true){
    redirect_to(url_for('/staff/leads/show.php?id=' . $id));
  } else {
    $errors = $result;
    // var_dump($errors);
  }

} else {
  $individual = find_individual_by_id($id);
}

 ?>
<?php $page_title = "Edit lead"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/leads/index.php'); ?>">Leads</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>"><?php echo h($individual['first_name']) . " " . h($individual['last_name']);?></a></li>
    <li class="breadcrumb-item"><a>Edit Lead</a></li>
  </ol>



  <form class="col-sm-6" action="<?php echo url_for('/staff/leads/edit.php?id=' . h(u($id))); ?>" method="post">
      <h2>Edit </h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Your Info</legend>

        <div class="form-group">
          <label class="form-control-label" for="first_name">First Name</label>
          <input class="form-control" type="text" name="first_name" value="<?php echo h($individual['first_name']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="last_name">Last Name</label>
          <input class="form-control" type="text" name="last_name" value="<?php echo h($individual['last_name']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="phone_direct">Phone</label>
          <input class="form-control" type="text" name="phone_direct" value="<?php echo h($individual['phone_direct']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="email">Email</label>
          <input class="form-control" type="text" name="email" value="<?php echo h($individual['email']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="role">Role</label>
          <input class="form-control" type="text" name="role" value="<?php echo h($individual['role']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label for="lead_source">Select list:</label>
            <select class="form-control" name="lead_source">
              <option <?php if($individual['lead_source'] == "Web"){
                echo 'selected="selected"';
              }?>>Web</option>
              <option <?php if($individual['lead_source'] == "Manual Entry"){
                echo 'selected="selected"';
              }?>>Manual Entry</option>
              <option <?php if($individual['lead_source'] == "Lead List"){
                echo 'selected="selected"';
              }?>>Lead List</option>
              <option <?php if($individual['lead_source'] == "Call In"){
                echo 'selected="selected"';
              }?>>Call In</option>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="lead_birthdate">Lead Origination</label>
          <input class="form-control" type="text" name="lead_birthdate" value="<?php echo h($individual['lead_birthdate']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label for="company_id">Company:</label>
            <select class="form-control" name="company_id">
                <option>none</option>
              <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <option value="<?php echo h($company['id']); ?>" <?php if($company['id'] == $individual['company_id']){echo "selected";}?>><?php echo h($company['company_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="lead_source">Lead Owner:</label>
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
