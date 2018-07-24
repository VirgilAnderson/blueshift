<?php require_once('../../../private/initialize.php'); ?>


<?php
  $id = isset($_GET['id']) ? $_GET['id'] : '1';
  $new = isset($_GET['new']) ? $_GET['new'] : '0';
  $admin = find_admin_by_id($id);
?>
<?php $page_title = "Show Admins"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>t>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/Admins/index.php'); ?>">Users</a></li>
    <li class="breadcrumb-item active"><?php echo h($admin['first_name']) . " " . h($admin['last_name']);?></li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2><?php echo h($admin['first_name']) . " " . h($admin['last_name']);?></h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <ul class="list-group">
          <dl class="list-group-item d-flex">
            <dt class="mr-4">First Name</dt>
            <dd><?php echo h($admin['first_name']); ?></dd>
          </dl>
          <dl class="list-group-item d-flex">
            <dt class="mr-4">Last Name</dt>
            <dd><?php echo h($admin['last_name']); ?></dd>
          </dl>
          <dl class="list-group-item d-flex">
            <dt class="mr-4">Email</dt>
            <dd><?php echo h($admin['email']); ?></dd>
          </dl>
          <dl class="list-group-item d-flex">
            <dt class="mr-4">Username</dt>
            <dd><?php echo h($admin['username']); ?></dd>
          </dl>

        </div><!-- .card-body -->
        <div class="card-footer">
          <dl class="list-group-item d-flex">
            <dt class="mr-4"><a class="card-link mr-4" href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>">Delete</a></dt>
            <dt><a class="card-link" href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($admin['id']))); ?>">Edit</a></dt>
          </dl>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
