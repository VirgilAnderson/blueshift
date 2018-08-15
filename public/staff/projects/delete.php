<?php require_once('../../../private/initialize.php');
  require_login();
  if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/projects/index.php'));
  }
  $id = $_GET['id'];

  if(is_post_request()){
   $result = delete_project($id);
   redirect_to(url_for('/staff/projects/index.php'));
 } else {
   $project = find_project_by_id($id);
 }
?>
<?php $page_title = "Delete Project"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Projects</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Project Tasks</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <p>Are you sure you want to delete?</p>
          <p><?php echo h($project['project_title']); ?> </p>
          <form class="col-sm-6" action="<?php echo url_for('/staff/projects/delete.php?id=' . h(u($project['id'])));?>" method="post">
              <?php echo display_errors($errors); ?>
              <fieldset class="form-group">
                <button class="btn btn-outline-info" type="submit">Delete</button>
              </fieldset><!-- fieldset -->
            </form>
            <a href="<?php echo url_for('/staff/projects/show.php?id=' . h(u($project['id']))); ?>">&laquo; Back to <?php echo h($project['project_title']);?></a>
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
