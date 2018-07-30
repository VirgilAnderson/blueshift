<?php require_once('../../../private/initialize.php');
require_login();
$admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$company_set = find_all_user_company($admin);
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/tasks/index.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

  // Handle form values submitted by new.php

  $company = [];
  $company['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';

  $result = insert_company_into_task($company, $id);
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
<?php $page_title = "Add company to task"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/index.php'); ?>">Leads</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>"><?php echo h($task['task_name']);?></a></li>
    <li class="breadcrumb-item"><a>Edit Lead</a></li>
  </ol>



  <form class="col-sm-6" action="<?php echo url_for('/staff/tasks/link.php?id=' . h(u($id))); ?>" method="post">
      <h2><?php echo h($task['task_name']);?></h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Add contact to business</legend>

        <div class="form-group">

          <label for="company_id">Select list:</label>

              <select class="form-control" name="company_id">
            <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <option value="<?php echo h($company['id']); ?>"><?php echo h($company['company_name']); ?></option>
            <?php } ?>
            </select>

        </div><!-- form-group -->

        <button class="btn btn-outline-info" type="submit">Add <?php echo h($task['task_name']);?> to company</button>

      </fieldset><!-- fieldset -->
    </form>
  </div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
