<?php require_once('../../../private/initialize.php');
require_login();
$admin_set = find_all_admins();
$admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$company_set = find_all_user_company($admin);
$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : NULL;
$company = find_company_by_id($company_id);
$project_set = find_all_user_project($admin);
$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : '';
$next_id = last_id();
if(is_post_request()) {

  // Handle form values submitted by new.php

  $individual = [];
  $individual['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
  $individual['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
  $individual['phone_direct'] = isset($_POST['phone_direct']) ? $_POST['phone_direct'] : '';
  $individual['email'] = isset($_POST['email']) ? $_POST['email'] : '';
  $individual['role'] = isset($_POST['role']) ? $_POST['role'] : '';
  $individual['lead_source'] = isset($_POST['lead_source']) ? $_POST['lead_source'] : '';
  $individual['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';
  $individual['project_id'] = isset($_POST['project_id']) ? $_POST['project_id'] : '';
  $individual['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';


  $result = insert_individual($individual, $next_id);
  if($result === true){
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The lead was created successfully.';
    redirect_to(url_for('/staff/leads/show.php?id=' . $new_id .'&new=1'));
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
  $individual['user_id'] = '';
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

        <div class="form-group">
          <label for="company_id">Company:</label>
              <select class="form-control" name="company_id">
                <option value='none'>none</option>
                <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <option value="<?php echo h($company['id']); ?>" <?php if($company['id'] == $company_id){echo "selected";}?>><?php echo h($company['company_name']); ?></option>
                <?php } ?>
              </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="project_id">Project:</label>
              <select class="form-control" name="project_id">
                <option value='none'>none</option>
                <?php while($project = mysqli_fetch_assoc($project_set)){ ?>
                <option value="<?php echo h($project['id']); ?>" <?php if($project['id'] == $project_id){echo "selected";}?>><?php echo h($project['project_title']); ?></option>
                <?php } ?>
              </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="lead_source">Lead Owner:</label>
            <select class="form-control" name="user_id">
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']); ?>" ><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->



        <button class="btn btn-outline-info" type="submit">Create New Lead</button>

      </fieldset><!-- fieldset -->
    </form>
</div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
