<?php require_once('../../../private/initialize.php'); ?>
<?php $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ''; ?>
<?php $project_set = find_all_user_project($admin); ?>
<?php $page_title = "Projects"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Projects</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <a href="<?php echo url_for('/staff/projects/new.php'); ?>" class="btn btn-outline-info mb-2" role="button">Add new project</a>
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Leads</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th>Project Title</th>
                  <th>Project State</th>
                  <th>Company</th>
                  <th>Employee</th>
                  <th>Project Owner</th>

                </tr>
              </thead>
              <tbody>

              <?php while($project = mysqli_fetch_assoc($project_set)){ ?>
                <tr class='clickable-row' data-href="<?php echo url_for('/staff/projects/show.php?id=' . h(u($project['id']))); ?>">
                  <td><?php echo h($project['project_title']); ?></td>
                  <td><?php echo h($project['project_state']); ?></td>
                  <td><?php echo h($project['company_id']); ?></td>
                  <td><?php echo h($project['individual_id']); ?></td>
                  <td><?php echo h($project['user_id']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>
            <?php
              mysqli_free_result($project_set);
             ?>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
