<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ''; ?>
<?php $task_set = find_all_user_tasks($admin); ?>
<?php $page_title = "Tasks"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">tasks</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <a href="<?php echo url_for('/staff/tasks/new.php'); ?>" class="btn btn-outline-info mb-2" role="button">Add new Task</a>
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>tasks</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Task Type</th>
                  <th>Task State</th>
                  <th>Employee</th>
                  <th>Company</th>
                  <th>Due Date</th>

                </tr>
              </thead>
              <tbody>

              <?php while($task = mysqli_fetch_assoc($task_set)){ ?>
                <tr class='clickable-row' data-href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>">
                  <td><?php echo h($task['task_name']); ?></td>
                  <td><?php echo h($task['task_type']); ?></td>
                  <td><?php echo h($task['task_state']); ?></td>
                  <td><?php echo h($task['individual_id']); ?></td>
                  <td><?php echo h($task['company_id']); ?></td>
                  <td><?php echo h($task['due_date']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>
            <?php
              mysqli_free_result($task_set);
             ?>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
