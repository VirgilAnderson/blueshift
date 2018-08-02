<?php require_once('../../../private/initialize.php'); ?>

<?php require_login(); ?>
<?php
  $id = isset($_GET['id']) ? $_GET['id'] : '1';
  $new = isset($_GET['new']) ? $_GET['new'] : '0';
  $individual = find_individual_by_id($id);
  $company = find_company_by_id($individual['company_id']);
  $task_set = find_all_task_individual($individual);
  if($new == 0){individual_visited($individual);}
  $admin = find_admin_by_id($individual['user_id']);
  $note_set = find_all_user_notes($individual);
?>
<?php $page_title = "Show lead"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>t>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/leads/index.php'); ?>">Leads</a></li>
    <li class="breadcrumb-item active"><?php echo h($individual['first_name']) . " " . h($individual['last_name']);?></li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2><?php echo h($individual['first_name']) . " " . h($individual['last_name']);?></h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-sm-5">
              <ul class="list-group list-group-flush">
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Name</dt>
                <dd><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Phone</dt>
                <dd><?php echo h($individual['phone_direct']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Email</dt>
                <dd><?php echo h($individual['email']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Role</dt>
                <dd><?php echo h($individual['role']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Lead source</dt>
                <dd><?php echo h($individual['lead_source']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Date Created</dt>
                <dd><?php echo h($individual['lead_birthdate']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Lead Owner</dt>
                <dd><?php echo h($admin['username']); ?></dd>
              </dl>
            </ul>
          </div><!-- .col-sm-5  -->

            <div class="col-sm-7">
              <div class="card bg-light">
                <div class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#company_pane">Company</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#task_pane">Tasks</a>
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
                    <div id="company_pane" class="container tab-pane active"><br>
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
                          <a <?php if($company){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/leads/link.php?id=' . h(u($individual['id']))); ?>">Set As Company Contact</a>
                        </dt>
                        <dt class="mr-4">
                          <a <?php if(!$company){echo 'style="display: none;"';} ?> class="card-link mr-4" href="<?php echo url_for('/staff/company/delete.php?id=' . h(u($company['id']))); ?>">Delete Company</a>
                        </dt>
                        <dt class="mr-4">
                          <a <?php if(!$company){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/company/edit.php?id=' . h(u($company['id']))); ?>">Edit Company</a>
                        </dt>
                      </dl>
                    </div><!-- #company_pane -->

                    <div id="task_pane" class="container tab-pane fade"><br>
                      <div class="table-responsive">
                        <table class="table table-hover table-sm">
                          <thead>
                            <tr>
                              <th>Title</th>
                              <th>Task Type</th>
                              <th>Task State</th>
                              <th>Due Date</th>
                              <th></th>
                              <th></th>

                            </tr>
                          </thead>
                          <tbody>

                          <?php while($task = mysqli_fetch_assoc($task_set)){ ?>
                            <tr class='clickable-row' data-href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>">
                              <td><a href="<?php echo url_for('/staff/tasks/show.php?id=' . h(u($task['id']))); ?>"><?php echo h($task['task_name']); ?></a></td>
                              <td><?php echo h($task['task_type']); ?></td>
                              <td><?php echo h($task['task_state']); ?></td>
                              <td><?php echo h($task['due_date']); ?></td>
                              <td><a class="card-link mr-4" href="<?php echo url_for('/staff/tasks/delete.php?id=' . h(u($task['id']))); ?>">Delete</a></td>
                              <td><a class="card-link" href="<?php echo url_for('/staff/tasks/edit.php?id=' . h(u($task['id']))); ?>">Edit</a></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        </table>

                      </div><!-- .table-responsive -->

                      <dl class="list-group-item d-flex bg-light">
                        <dt class="mr-4">
                          <a class="card-link" href="<?php echo url_for('/staff/tasks/new.php?individual_id=' . h(u($individual['id']))) . '&company_id=' . h(u($company['id'])); ?>">Add Task</a>
                        </dt>
                      </dl>
                      <?php
                        mysqli_free_result($task_set);
                       ?>
                    </div><!-- #tasks -->

                   <div id="history_pane" class="container tab-pane"><br>
                     <h3>History</h3>
                     <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
                            <tr>
                              <td><?php echo h($note['id']); ?></td>
                              <td><?php echo h($note['note']); ?></td>
                              <td><a class="card-link mr-4" href="<?php echo url_for('/staff/tasks/delete.php?id=' . h(u($task['id']))); ?>">Delete</a></td>
                              <td><a class="card-link" href="<?php echo url_for('/staff/tasks/edit.php?id=' . h(u($task['id']))); ?>">Edit</a></td>
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
              <a class="card-link mr-4" href="<?php echo url_for('/staff/leads/delete.php?id=' . h(u($individual['id']))); ?>">Delete Employee</a>
            </dt>
            <dt>
              <a class="card-link" href="<?php echo url_for('/staff/leads/edit.php?id=' . h(u($individual['id'])) . '&company_id=' . h(u($company['id']))); ?>">Edit Employee</a>
            </dt>
          </dl>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
