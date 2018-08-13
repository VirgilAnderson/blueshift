<?php require_once('../../../private/initialize.php');
  require_login();
  $admin_set = find_all_admins();
  $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
  $company_set = find_all_user_company($admin);
  $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
  $company = find_company_by_id($company_id);
  $individual_set = find_all_user_individual($admin);
  $individual_id = isset($_GET['individual_id']) ? $_GET['individual_id'] : '';
  $next_id = last_project_id();

  if(is_post_request()) {

    // Handle form values submitted by new.php

    $project = [];
    $project['project_title'] = isset($_POST['project_title']) ? $_POST['project_title'] : '';
    $project['project_status'] = isset($_POST['project_status']) ? $_POST['project_status'] : '';
    $project['project_description'] = isset($_POST['project_description']) ? $_POST[''] : 'project_description';
    $project['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';
    $project['individual_id'] = isset($_POST['individual_id']) ? $_POST['individual_id'] : '';
    $project['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';



    $result = insert_project($project, $next_id);
    if($result === true){
      $new_id = mysqli_insert_id($db);
      $_SESSION['message'] = 'The project was created successfully.';
      redirect_to(url_for('/staff/projects/show.php?id=' . $new_id));
    } else {
      $errors = $result;
    }
  } else {
    // Display the blank form
    $project = [];
  }
 ?>

<?php $page_title = "New Project"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/projects/index.php'); ?>">Projects</a></li>
    <li class="breadcrumb-item active">New Project</li>
  </ol>

  <form class="col-sm-6" action="<?php echo url_for('/staff/projects/new.php'); ?>"  method="post">
    <h2>New Project</h2>
    <?php echo display_errors($errors); ?>
    <fieldset class="form-group">
      <legend>Fill in the form to create a new project</legend>

      <div class="form-group">
        <label class="form-control-label" for="project_title">Project Title</label>
        <input class="form-control" type="text" name="project_title" >
      </div><!-- .form-group -->

      <div class="form-group">
        <label for="project_state">Project State</label>
            <select class="form-control" name="project_state">
              <option>Not Started</option>
              <option>In Progress</option>
              <option>Complete</option>
              <option>Postponed</option>
              <option>Cancelled</option>
          </select>
      </div><!-- form-group -->

      <div class="form-group">
        <label for="project_description">Project Description</label>
        <textarea class="form-control" rows="5" name="project_description"></textarea>
      </div><!-- .form-group -->

      <div class="form-group">
        <label for="project_source">Company:</label>
          <select class="form-control" name="company_id">
              <option value='none'>none</option>
            <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
              <option value="<?php echo h($company['id']); ?>" <?php if($company['id'] == $company_id){echo "selected";}?>><?php echo h($company['company_name']); ?></option>
            <?php } ?>
          </select>
      </div><!-- form-group -->

      <div class="form-group">
        <label for="project_source">Employee:</label>
          <select class="form-control" name="individual_id">
              <option value='none'>none</option>
            <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
              <option value="<?php echo h($individual['id']); ?>" <?php if($individual['id'] == $individual_id){echo "selected";}?>><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></option>
            <?php } ?>
          </select>
      </div><!-- form-group -->

      <div class="form-group">
        <label for="project_source">project Owner:</label>
          <select class="form-control" name="user_id">
            <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
            <option value="<?php echo h($admin['id']); ?>" ><?php echo h($admin['username']); ?></option>
            <?php } ?>
          </select>
      </div><!-- form-group -->


      <button class="btn btn-outline-info" type="submit">Create New Lead</button>
    </fieldset><!-- fieldset -->
  </form>
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
