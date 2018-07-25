<?php require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];

if(is_post_request()){
  $result = delete_admin($id);
  redirect_to(url_for('/staff/admins/index.php'));
} else {
  $admin = find_admin_by_id($id);
}
 ?>
<?php $page_title = "Delete lead"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/admins/index.php'); ?>">Admins</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/admins/show.php?id=' . h(u($admin['id']))); ?>"><?php echo h($admin['first_name']) . " " . h($admin['last_name']);?></a></li>
    <li class="breadcrumb-item active">Delete</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Delete Lead</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <p>Are you sure you want to delete?</p>
          <p><?php echo h($admin['first_name']) . " " . h($admin['last_name']); ?> </p>
          <form class="col-sm-6" action="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id'])));?>" method="post">
              <?php echo display_errors($errors); ?>
              <fieldset class="form-group">
                <button class="btn btn-outline-info" type="submit">Delete</button>
              </fieldset><!-- fieldset -->
            </form>
            <a href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($admin['id']))); ?>">&laquo; Back to <?php echo h($admin['first_name']) . " " . h($admin['last_name']);?></a>
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
