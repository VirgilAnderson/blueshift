<?php require_once('../../../private/initialize.php');
require_login();
$admin_set = find_all_admins();
if(is_post_request()) {

  // Handle form values submitted by new.php

  $company = [];
  $company['company_name'] = isset($_POST['company_name']) ? $_POST['company_name'] : '';
  $company['company_address'] = isset($_POST['company_address']) ? $_POST['company_address'] : '';
  $company['company_city'] = isset($_POST['company_city']) ? $_POST['company_city'] : '';
  $company['company_state'] = isset($_POST['company_state']) ? $_POST['company_state'] : '';
  $company['company_zip'] = isset($_POST['company_zip']) ? $_POST['company_zip'] : '';
  $company['company_url'] = isset($_POST['company_url']) ? $_POST['company_url'] : '';
  $company['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';

  $result = insert_company($company);
  if($result === true){
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The company was created successfully.';
    redirect_to(url_for('/staff/company/show.php?id=' . $new_id .'&new=1'));
  } else {
    $errors = $result;
  }
} else {
  // Display the blank form
  $company = [];
  $company['company_name'] = '';
  $company['company_address'] =  '';
  $company['company_city'] = '';
  $company['company_state'] = '';
  $company['company_zip'] = '';
  $company['company_url'] = '';
  $company['user_id'] = '';
}

?>

<?php $page_title = "New Company"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>


<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/company/index.php'); ?>">Companies</a></li>
    <li class="breadcrumb-item active">New Company</li>
  </ol>
  <form class="col-sm-6" action="<?php echo url_for('/staff/company/new.php'); ?>"  method="post">
      <h2>New Company</h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Fill in the form to create a new record</legend>

        <div class="form-group">
          <label class="form-control-label" for="company_name">Company Name</label>
          <input class="form-control" type="text" name="company_name" >
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_address">Company Address</label>
          <input class="form-control" type="text" name="company_address" >
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_city">Company City</label>
          <input class="form-control" type="text" name="company_city" >
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_state">Company State</label>
          <input class="form-control" type="text" name="company_state">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_zip">Company Zip</label>
          <input class="form-control" type="text" name="company_zip">
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="company_url">Company url</label>
          <input class="form-control" type="text" name="company_url">
        </div><!-- form-group -->

        <div class="form-group">
          <label for="lead_source">Lead Owner:</label>
            <select class="form-control" name="user_id">
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']); ?>"><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->



        <button class="btn btn-outline-info" type="submit">Create New Lead</button>

      </fieldset><!-- fieldset -->
    </form>
</div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
