<?php require_once('../../../private/initialize.php');
require_login();
$admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$individual_set = find_all_user_individual($admin);
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/tasks/index.php'));
}
$id = $_GET['id'];



if(is_post_request()) {

  // Handle form values submitted by new.php

  $individual = [];
  $individual['individual_id'] = isset($_POST['individual_id']) ? $_POST['individual_id'] : '';

  $result = insert_individual_into_task($individual, $id);
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
<?php $page_title = "Add employee to task"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/index.php'); ?>">Leads</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>"><?php echo h($task['task_name']);?></a></li>
    <li class="breadcrumb-item"><a>Link Employee To Task</a></li>
  </ol>



  <form class="col-sm-6" action="<?php echo url_for('/staff/tasks/individual_link.php?id=' . h(u($id))); ?>" method="post">
      <h2><?php echo h($task['task_name']);?></h2>
      <?php echo display_errors($errors); ?>

      <fieldset class="form-group">
        <legend>Add Task To Employee</legend>

        <div class="form-group">
          <label for="id">Select list:</label>
              <select class="form-control" name="individual_id">
                <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                <option value="<?php echo h($individual['id']); ?>"><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></option>
                <?php } ?>
              </select>
          </div><!-- form-group -->


        <button class="btn btn-outline-info" type="submit">Add <?php echo h($task['task_name']);?> to Employee</button>

      </fieldset><!-- fieldset -->
    </form>
  </div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
