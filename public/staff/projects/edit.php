<?php require_once('../../../private/initialize.php');
  $id = isset($_GET['id']) ? $_GET['id'] : '';
  $admin_set = find_all_admins();
  $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
  $project = find_project_by_id($id);
  $company_set = find_all_user_company($admin);
  $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
  $company = find_company_by_id($company_id);
  $individual_set = find_all_user_individual($admin);
  $individual_id = isset($_GET['individual_id']) ? $_GET['individual_id'] : '';
  if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/projects/index.php'));
  }

  if(is_post_request()) {

    // Handle form values submitted by new.php

    $project = [];
    $project['id'] = $id;
    $project['project_title'] = isset($_POST['project_title']) ? $_POST['project_title'] : '';
    $project['project_state'] = isset($_POST['project_state']) ? $_POST['project_state'] : '';
    $project['project_description'] = isset($_POST['project_description']) ? $_POST['project_description'] : '';
    $project['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';
    $project['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    $result = update_project($project);
    if($result === true){
      $_SESSION['message'] = 'The project was updated successfully.';
      redirect_to(url_for('/staff/projects/show.php?id=' . $id));
    } else {
      $errors = $result;
    }
  }
 ?>
<?php $page_title = "Edit Project"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/projects/index.php'); ?>">Projects</a></li>
    <li class="breadcrumb-item active">Edit Project</li>
  </ol>

  <form class="col-sm-6" action="<?php echo url_for('/staff/projects/edit.php?id=' . h(u($id))); ?>" method="post">
      <h2>Edit Project</h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Fill in the form to edit your project</legend>

        <div class="form-group">
          <label class="form-control-label" for="project_title">Project Title</label>
          <input class="form-control" type="text" name="project_title" value="<?php echo h($project['project_title']); ?>">
        </div><!-- .form-group -->

        <div class="form-group">
          <label for="project_state">Project State</label>
              <select class="form-control" name="project_state">
                <option value="Not Started" <?php if($project['project_state']=="Not Started"){echo "selected";}?>>Not Started</option>
                <option value="In Progress" <?php if($project['project_state']=="In Progress"){echo "selected";}?>>In Progress</option>
                <option value="Complete" <?php if($project['project_state']=="Complete"){echo "selected";}?>>Complete</option>
                <option value="Postponed" <?php if($project['project_state']=="Postponed"){echo "selected";}?>>Postponed</option>
                <option value="Cancelled" <?php if($project['project_state']=="Cancelled"){echo "selected";}?>>Cancelled</option>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="project_description">Project Description</label>
          <textarea class="form-control" rows="5" name="project_description"><?php echo $project['project_description']; ?></textarea>
        </div><!-- .form-group -->

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
          <label for="user_id">project Owner:</label>
            <select class="form-control" name="user_id">
              <option value='none'>none</option>
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']) . '" '; if($admin['id'] == $project['user_id']){echo "selected";} ?> ><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->


        <button class="btn btn-outline-info" type="submit">Edit</button>

      </fieldset><!-- fieldset -->
    </form>
  </div><!-- .container mt-4 -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
