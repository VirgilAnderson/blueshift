<?php require_once('../../../private/initialize.php'); ?>
<?php $admin_set = find_all_admins(); ?>
<?php $page_title = "admins"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Users</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <a href="<?php echo url_for('/staff/admins/new.php'); ?>" class="btn btn-outline-info mb-2" role="button">Add new user</a>
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Users</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>

              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
                <tr class='clickable-row' data-href="<?php echo url_for('/staff/admins/show.php?id=' . h(u($admin['id']))); ?>">
                  <td><?php echo h($admin['id']); ?></td>
                  <td><?php echo h($admin['first_name']); ?></td>
                  <td><?php echo h($admin['last_name']); ?></td>
                  <td><?php echo h($admin['email']); ?></td>
                  <td><?php echo h($admin['username']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>

            <?php
              mysqli_free_result($admin_set);
             ?>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
