<?php require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/tasks/index.php'));
}
$id = $_GET['id'];
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
  $task['id'] = $id;
  $task['task_name'] = isset($_POST['task_name']) ? $_POST['task_name'] : '';
  $task['task_type'] = isset($_POST['task_type']) ? $_POST['task_type'] : '';
  $task['task_state'] = isset($_POST['task_state']) ? $_POST['task_state'] : '';
  $task['task_description'] = isset($_POST['task_description']) ? $_POST['task_description'] : '';
  $task['due_date'] = isset($_POST['due_date']) ? $_POST['due_date'] : '';
  $task['individual_id'] = isset($_POST['individual_id']) ? $_POST['individual_id'] : '';
  $task['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';
  $task['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';

  $result = update_task($task);
  if($result === true){
    redirect_to(url_for('/staff/tasks/show.php?id=' . $id));
  } else {
    $errors = $result;
    // var_dump($errors);
  }

} else {
  $task = find_task_by_id($id);
}
 ?>
<?php $page_title = "Edit Task"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/index.php'); ?>">Tasks</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>"><?php echo h($task['task_name']);?></a></li>
    <li class="breadcrumb-item"><a>Edit Task</a></li>
  </ol>



  <form class="col-sm-6" action="<?php echo url_for('/staff/tasks/edit.php?id=' . h(u($id))); ?>" method="post">
      <h2>Edit </h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Task Info</legend>

        <div class="form-group">
          <label class="form-control-label" for="task_name">Task Title</label>
          <input class="form-control" type="text" name="task_name" value="<?php echo h($task['task_name']); ?>">
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_type">Task Type</label>
              <select class="form-control" name="task_type">
                <option <?php if($task['task_type'] == "Call"){echo "selected";} ?>>Call</option>
                <option <?php if($task['task_type'] == "Email"){echo "selected";} ?>>Email</option>
                <option <?php if($task['task_type'] == "Follow Up"){echo "selected";} ?>>Follow Up</option>
                <option <?php if($task['task_type'] == "Meeting"){echo "selected";} ?>>Meeting</option>
                <option <?php if($task['task_type'] == "Get Started"){echo "selected";} ?>>Get Started</option>
                <option <?php if($task['task_type'] == "To Do"){echo "selected";} ?>>To Do</option>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_state">Task Type</label>
              <select class="form-control" name="task_state">
                <option <?php if($task['task_state'] == ""){echo "selected";} ?>>Open</option>
                <option <?php if($task['task_state'] == "Closed"){echo "selected";} ?>>Closed</option>
                <option <?php if($task['task_state'] == "In Progress"){echo "selected";} ?>>In Progress</option>
                <option <?php if($task['task_state'] == "Waiting On Someone Else"){echo "selected";} ?>>Waiting On Someone Else</option>
                <option <?php if($task['task_state'] == "Not Started"){echo "selected";} ?>>Not Started</option>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_description">Task Description:</label>
          <textarea class="form-control" rows="5" name="task_description"><?php echo $task['task_description']; ?></textarea>
        </div><!-- form-group -->

        <?php $date = date_create($task['due_date']); ?>
        <div class="form-group">
          <label class="form-control-label" for="due_date">Due Date</label>
          <input class="form-control" name="due_date" type="datetime-local" value="<?php echo date_format($date,'Y-m-d') . 'T' . date_format($date,'H:i:s'); ?>" >
        </div><!-- form-group -->


        <div class="form-group">
          <label for="company_id">Company:</label>
            <select class="form-control" name="company_id">
                <option>none</option>
              <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <option value="<?php echo h($company['id']); ?>" <?php if($company['id'] == $task['company_id']){echo "selected";}?>><?php echo h($company['company_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="individual_id">Employee:</label>
            <select class="form-control" name="individual_id">
                <option>none</option>
              <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                <option value="<?php echo h($individual['id']); ?>" <?php if($individual['id'] == $task['individual_id']){echo "selected";}?>><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="user_id">Task Owner:</label>
            <select class="form-control" name="user_id">
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']); ?>" ><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <button class="btn btn-outline-info" type="submit">Edit</button>

      </fieldset><!-- fieldset -->
    </form>
  </div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
