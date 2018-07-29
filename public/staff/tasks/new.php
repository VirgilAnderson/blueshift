<?php require_once('../../../private/initialize.php');
require_login();
$admin_set = find_all_admins();
$admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$company_set = find_all_user_company($admin);
$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
$company = find_company_by_id($company_id);
$individual_set = find_all_user_individual($admin);
$individual_id = isset($_GET['individual_id']) ? $_GET['individual_id'] : '';
if(is_post_request()) {

  // Handle form values submitted by new.php

  $task = [];
  $task['task_name'] = isset($_POST['task_name']) ? $_POST['task_name'] : '';
  $task['task_type'] = isset($_POST['task_type']) ? $_POST['task_type'] : '';
  $task['task_state'] = isset($_POST['task_state']) ? $_POST['task_state'] : '';
  $task['task_description'] = isset($_POST['task_description']) ? $_POST['task_description'] : '';
  $task['due_date'] = isset($_POST['due_date']) ? $_POST['due_date'] : '';
  $task['individual_id'] = isset($_POST['individual_id']) ? $_POST['individual_id'] : '';
  $task['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';
  $task['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';

  $result = insert_task($task);
  if($result === true){
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The task was created successfully.';
    redirect_to(url_for('/staff/tasks/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }
} else {
  // Display the blank form
  $task = [];
}

?>

<?php $page_title = "New task"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>


<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/index.php'); ?>">tasks</a></li>
    <li class="breadcrumb-item active">New task</li>
  </ol>
  <form class="col-sm-6" action="<?php echo url_for('/staff/tasks/new.php'); ?>"  method="post">
      <h2>New task</h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Fill in the form to create a new task</legend>

        <div class="form-group">
          <label class="form-control-label" for="task_name">Task Name</label>
          <input class="form-control" type="text" name="task_name" >
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_type">Task Type</label>
              <select class="form-control" name="task_type">
                <option>Call</option>
                <option>Email</option>
                <option>Follow Up</option>
                <option>Meeting</option>
                <option>Get Started</option>
                <option>To Do</option>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_state">Task Type</label>
              <select class="form-control" name="task_state">
                <option>Open</option>
                <option>Closed</option>
                <option>In Progress</option>
                <option>Waiting On Someone Else</option>
                <option>Not Started</option>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_description">Task Description:</label>
          <textarea class="form-control" rows="5" name="task_description"></textarea>
        </div><!-- form-group -->

        <div class="form-group">
          <label class="form-control-label" for="due_date">Due Date</label>
          <input class="form-control" type="text" name="due_date">
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_source">Company:</label>
            <select class="form-control" name="company_id">
                <option>none</option>
              <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <option value="<?php echo h($company['id']); ?>"><?php echo h($company['company_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_source">Employee:</label>
            <select class="form-control" name="individual_id">
                <option>none</option>
              <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                <option value="<?php echo h($individual['id']); ?>"><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_source">Task Owner:</label>
            <select class="form-control" name="user_id">
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']); ?>" ><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->



        <button class="btn btn-outline-info" type="submit">Create New task</button>

      </fieldset><!-- fieldset -->
    </form>
</div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
