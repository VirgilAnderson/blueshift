<?php require_once('../../../private/initialize.php'); ?>

<?php require_login(); ?>
<?php
  $id = isset($_GET['id']) ? $_GET['id'] : '1';
  $new = isset($_GET['new']) ? $_GET['new'] : '0';
  $task = find_task_by_id($id);
  $individual = find_individual_by_id($task['individual_id']);
  $company = find_company_by_id($task['company_id']);
  $note_set = find_all_user_notes($individual);
  $history_set = find_history_by_task_id($id);
  $project = find_project_by_task_id($id);
  $admin = find_admin_by_id($task['user_id']);
?>
<?php $page_title = "Show lead"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>t>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/tasks/index.php'); ?>">Tasks</a></li>
    <li class="breadcrumb-item active"><?php echo h($task['task_name']);?></li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2><?php echo h($task['task_name']);?></h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-sm-5">
              <ul class="list-group list-group-flush">
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Title</dt>
                <dd><?php echo h($task['task_name']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Type</dt>
                <dd><?php echo h($task['task_type']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">State</dt>
                <dd><?php echo h($task['task_state']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Description</dt>
                <dd><?php echo h($task['task_description']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Due Date</dt>
                <dd><?php echo h($task['due_date']); ?></dd>
              </dl>
            </ul>
          </div><!-- .col-sm-5  -->

            <div class="col-sm-7">
              <div class="card bg-light">
                <div class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#employee_pane">Employee</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#company_pane">Company</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#project_pane">Project</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#history_pane">History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#note_pane">Notes</a>
                  </li>
                </ul><!-- .nav nav-tabs -->
                </div><!-- .card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div id="employee_pane" class="container tab-pane active"><br>
                      <ul class="list-group list-group-flush">
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Employee Name</dt>
                          <dd><a href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>"><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></a></dd>
                        </dl>
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Phone</dt>
                          <dd><?php echo h($individual['phone_direct']); ?></dd>
                        </dl>
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Email</dt>
                          <dd><?php echo h($individual['email']); ?></dd>
                        </dl>
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Role</dt>
                          <dd><?php echo h($individual['role']); ?></dd>
                        </dl>
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Lead source</dt>
                          <dd><?php echo h($individual['lead_source']); ?></dd>
                        </dl>
                      </ul>
                      <dl class="list-group-item d-flex bg-light">
                        <dt class="mr-4">
                          <a <?php if(!$individual){echo 'style="display: none;"';} ?> class="card-link mr-4" href="<?php echo url_for('/staff/leads/delete.php?id=' . h(u($individual['id']))); ?>">Delete Employee</a>
                        </dt>
                        <dt class="mr-4">
                          <a <?php if(!$individual){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/leads/edit.php?id=' . h(u($individual['id']))); ?>">Edit Employee</a>
                        </dt>
                        <dt class="mr-4">
                          <a <?php if($individual){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/tasks/individual_link.php?id=' . h(u($task['id']))); ?>">Link To Employee</a>
                        </dt>
                      </dl>
                    </div><!-- #employee_pane -->

                    <div id="company_pane" class="container tab-pane"><br>
                      <ul class="list-group list-group-flush">
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Company Name</dt>
                          <dd><a href="<?php echo url_for('/staff/company/show.php?id=' . h(u($company['id']))); ?>"><?php echo h($company['company_name']); ?></a></dd>
                        </dl>
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Address</dt>
                          <dd><?php echo h($company['company_address']) . " " . h($company['company_city']) . " " . h($company['company_state']) . " " . h($company['company_zip']); ?></dd>
                        </dl>
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">URL</dt>
                          <dd><a href='http://<?php echo $company['company_url']; ?>' target="_blank"><?php echo h($company['company_url']); ?></a></dd>
                        </dl>
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Phone</dt>
                          <dd><?php echo h($company['company_phone']); ?></dd>
                        </dl>
                      </ul>

                      <dl class="list-group-item d-flex bg-light">
                        <dt class="mr-4">
                          <a <?php if($company){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/tasks/link.php?id=' . h(u($task['id']))); ?>">Link To Company</a>
                        </dt>
                        <dt class="mr-4">
                          <a <?php if(!$company){echo 'style="display: none;"';} ?> class="card-link mr-4" href="<?php echo url_for('/staff/company/delete.php?id=' . h(u($company['id']))); ?>">Delete Company</a>
                        </dt>
                        <dt class="mr-4">
                          <a <?php if(!$company){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/company/edit.php?id=' . h(u($company['id']))); ?>">Edit Company</a>
                        </dt>
                      </dl>
                    </div><!-- #company_pane -->

                    <div id="project_pane" class="container tab-pane"><br>
                      <ul class="list-group list-group-flush">
                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Project Title</dt>
                          <dd><a href="<?php echo url_for('/staff/projects/show.php?id=' . h(u($project['id']))); ?>"><?php echo h($project['project_title']); ?></a></dd>
                        </dl>

                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Project State</dt>
                          <dd><?php echo h($project['project_state']); ?></dd>
                        </dl>

                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Project Description</dt>
                          <dd><?php echo h($project['project_description']); ?></dd>
                        </dl>

                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Company</dt>
                          <dd><?php echo h($company['company_name']); ?></dd>
                        </dl>

                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Employee</dt>
                          <dd><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></dd>
                        </dl>

                        <dl class="list-group-item d-flex bg-light">
                          <dt class="mr-4">Project Owner</dt>
                          <dd><?php echo h($admin['username']); ?></dd>
                        </dl>

                        <dl class="list-group-item d-flex">
                          <dt class="mr-4">
                            <a <?php if(!$project){echo 'style="display: none;"';} ?> class="card-link mr-4" href="<?php echo url_for('/staff/projects/delete.php?id=' . h(u($project['id']))); ?>">Delete Project</a>
                          </dt>
                          <dt>
                            <a <?php if(!$project){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/projects/edit.php?id=' . h(u($project['id']))); ?>">Edit Project</a>
                          </dt>
                          <dt>
                            <a <?php if($project){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/projects/new.php?company_id=' . $id); ?>">Add Project</a>
                          </dt>
                        </dl>
                      </ul>
                    </div><!-- #project_pane -->

                    <div id="history_pane" class="container tab-pane"><br>
                      <div class="table-responsive">
                        <table class="table table-striped table-sm">
                          <thead>
                            <tr>
                              <th>Time</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php while($history = mysqli_fetch_assoc($history_set)){ ?>
                            <tr>
                              <td><?php echo h($history['time']); ?></td>
                              <td><?php echo h($history['action']); ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        </table>

                      </div><!-- .table-responsive -->

                    </div><!-- #history -->

                   <div id="note_pane" class="container tab-pane fade"><br>
                      <div class="table-responsive">
                        <table class="table table-hover table-sm">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Note</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php while($note = mysqli_fetch_assoc($note_set)){ ?>
                            <tr  class='clickable-row' data-href="<?php echo url_for('/staff/notes/show.php?id=' . h(u($note['id']))); ?>">
                              <td><?php echo h($note['id']); ?></td>
                              <td><?php echo h($note['note']); ?></td>
                              <td><a class="card-link mr-4" href="<?php echo url_for('/staff/notes/delete.php?id=' . h(u($note['id']))); ?>">Delete</a></td>
                              <td><a class="card-link" href="<?php echo url_for('/staff/notes/edit.php?id=' . h(u($note['id']))); ?>">Edit</a></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        </table>

                      </div><!-- .table-responsive -->

                      <dt class="mr-4">
                        <a class="card-link" href="<?php echo url_for('/staff/notes/new.php?individual_id=' .  h(u($individual['id'])) . '&company_id=' . h(u($company['id']))); ?>">Add Note</a>
                      </dt>
                    </dl>
                   </div><!-- #notes -->
                 </div><!-- .tab-content -->
                </div><!-- .card-body -->
              </div><!-- .card -->
            </div><!-- .col-7 -->
          </div><!-- .row -->
        </div><!-- .card-body -->
        <div class="card-footer">
          <dl class="list-group-item d-flex">
            <dt class="mr-4">
              <a class="card-link mr-4" href="<?php echo url_for('/staff/tasks/delete.php?id=' . h(u($task['id']))); ?>">Delete Task</a>
            </dt>
            <dt>
              <a class="card-link" href="<?php echo url_for('/staff/tasks/edit.php?id=' . h(u($task['id']))); ?>">Edit Task</a>
            </dt>
          </dl>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
