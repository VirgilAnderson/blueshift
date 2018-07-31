<?php require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/tasks/index.php'));
}
$id = $_GET['id'];

if(is_post_request()){
  $result = delete_task($id);
  if($result === true){
    $_SESSION['message'] = 'The task was deleted successfully.';
    redirect_to(url_for('/staff/tasks/index.php'));
  } else {
    $errors = $result;
  }
} else {
  $task = find_task_by_id($id);
}
 ?>
<?php $page_title = "Delete Task"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/index.php'); ?>">Tasks</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>"><?php echo h($task['task_name']);?></a></li>
    <li class="breadcrumb-item active">Delete</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Delete Task</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <p>Are you sure you want to delete?</p>
          <p><?php echo h($task['task_name']); ?> </p>
          <form class="col-sm-6" action="<?php echo url_for('/staff/tasks/delete.php?id=' . h(u($task['id'])));?>" method="post">
              <?php echo display_errors($errors); ?>
              <fieldset class="form-group">
                <button class="btn btn-outline-info" type="submit">Delete</button>
              </fieldset><!-- fieldset -->
            </form>
            <a href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>">&laquo; Back to <?php echo h($task['task_name']);?></a>
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
