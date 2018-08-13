<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id']: ''; ?>
<?php $individual_set = find_five_user_individual($admin);?>
<?php $task_set = find_five_task_user($admin); ?>
<?php $project_set = find_all_user_project($admin); ?>
<?php $page_title = "Dashboard"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-sm-6 mb-4">
      <div class="card">
        <div class="card-header">
          <a href="<?php echo url_for('staff/tasks/index.php'); ?>" class="text-info"><h2>Upcoming Tasks</h2></a>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-sm">
              <thead>
                <tr class='clickable-row' data-href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>">
                  <th>Title</th>
                  <th>Due Date</th>
                  <th>Status</th>
                  <th>Task Type</th>
                </tr>
              </thead>
              <tbody>
                <?php while($task = mysqli_fetch_assoc($task_set)){ ?>
                  <tr class='clickable-row' data-href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>">
                    <?php $date = date_create($task['due_date']); ?>
                    <td><?php echo h($task['task_name']); ?></td>
                    <td><?php echo date_format($date,'Y/m/d'); ?></td>
                    <td><?php echo h($task['task_state']); ?></td>
                    <td><?php echo h($task['task_type']); ?></td>

                  </tr>

                <?php } ?>
              </tbody>
            </table>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
        <div class="card-footer">
          <a href="<?php echo url_for('/staff/tasks/new.php'); ?>" class="btn btn-outline-info mb-2" role="button">Add new task</a>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- .container col-sm-6 -->
    <div class="container col-sm-6 mb-4">

      <div class="card">
        <div class="card-header">
          <a href="<?php echo url_for('staff/leads/index.php'); ?>" class="text-info"><h2>Leads</h2></a>
        </div><!-- .card-header -->

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-sm">
              <thead>
                <tr class='clickable-row' data-href="<?php echo url_for('staff/tasks/show.php'); ?>">
                  <th></th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Lead Source</th>
                </tr>
              </thead>
              <tbody>
                <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                  <tr class='clickable-row' data-href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>">

                    <td><?php if($individual['viewed'] == 0){ echo "<span class='badge badge-info'>new</span> ";} ?></td>
                    <td><?php echo h($individual['first_name']); ?></td>
                    <td><?php echo h($individual['last_name']); ?></td>
                    <td><?php echo h($individual['lead_source']); ?></td>
                  </tr>

                <?php } ?>
              </tbody>
            </table>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
        <div class="card-footer">
          <a href="<?php echo url_for('/staff/leads/new.php'); ?>" class="btn btn-outline-info mb-2" role="button">Add new lead</a>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- .container col-sm-6 -->
  </div><!-- . row -->

  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2><a href='<?php echo url_for('staff/projects/index.php'); ?>' class="text-info">Projects</a></h2>
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
