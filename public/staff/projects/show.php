<?php require_once('../../../private/initialize.php');
  $id = isset($_GET['id']) ? $_GET['id'] : '1';
  $project = find_project_by_id($id);
  $individual_set = find_all_project_individual($project['id']);
  $company = find_company_by_id($project['company_id']);
  $task_set = find_all_task_project($project);
  $note_set = find_all_project_notes($project);
  $history_set = find_history_by_project_id($id);
  $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
  $admin = find_admin_by_id($admin_id);

 ?>
<?php $page_title = "Show Project"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/projects/index.php'); ?>">Projects</a></li>
    <li class="breadcrumb-item active"><?php echo h($project['project_title']); ?></li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2><?php echo h($project['project_title']);?></h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-sm-5">
              <ul class="list-group list-group-flush">
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Project Title</dt>
                <dd><?php echo h($project['project_title']); ?></dd>
              </dl>

              <dl class="list-group-item d-flex">
                <dt class="mr-4">Project State</dt>
                <dd><?php echo h($project['project_state']); ?></dd>
              </dl>

              <dl class="list-group-item d-flex">
                <dt class="mr-4">Project Description</dt>
                <dd><?php echo h($project['project_description']); ?></dd>
              </dl>

              <dl class="list-group-item d-flex">
                <dt class="mr-4">Company</dt>
                <dd><?php echo h($company['company_name']); ?></dd>
              </dl>

              <dl class="list-group-item d-flex">
                <dt class="mr-4">Project Owner</dt>
                <dd><?php echo h($admin['username']); ?></dd>
              </dl>

          </div><!-- .col-sm-5  -->

            <div class="col-sm-7">
              <div class="card bg-light">
                <div class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#company_pane">Company</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#employee_pane">Employees</a>
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

                    <div id="employee_pane" class="container tab-pane"><br>
                      <ul class="list-group list-group-flush">
                        <dl class="list-group-item d-flex bg-light">
                          <div class="table-responsive">
                            <table class="table table-hover table-sm">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Role</th>
                                </tr>
                              </thead>
                              <tbody>

                              <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                                <tr class='clickable-row' data-href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>">
                                  <td><?php if($individual['viewed'] == 0){ echo "<span class='badge badge-info'>new</span> ";} ?></td>
                                  <td><?php echo h($individual['first_name']); ?></td>
                                  <td><?php echo h($individual['last_name']); ?></td>
                                  <td><?php echo h($individual['role']); ?></td>
                                </tr>
                              <?php } ?>
                            </tbody>
                            </table>
                        <dl class="list-group-item d-flex">
                          <dt class="mr-4">
                            <a <?php if(!$individual){echo 'style="display: none;"';} ?> class="card-link mr-4" href="<?php echo url_for('/staff/leads/delete.php?id=' . h(u($individual['id']))); ?>">Delete Employee</a>
                          </dt>
                          <dt>
                            <a <?php if(!$individual){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/leads/edit.php?id=' . h(u($individual['id']))); ?>">Edit Employee</a>
                          </dt>
                          <dt>
                            <a <?php if($individual){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/leads/new.php?company_id=' . h(u($company['id'])) . "&project_id=" . h(u($project['id']))); ?>">Add Employee</a>
                          </dt>
                        </dl>
                      </ul>
                    </div><!-- #employee_pane -->

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
                          <a class="card-link" href="<?php echo url_for('/staff/tasks/new.php?individual_id=' . h(u($individual['id']))) . '&company_id=' . h(u($company['id'])) . '&project_id=' . h(u($project['id'])); ?>">Add Task</a>
                        </dt>
                      </dl>
                      <?php
                        mysqli_free_result($task_set);
                       ?>
                    </div><!-- #tasks -->

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
                              <td><a class="card-link mr-4" href="<?php echo url_for('/staff/notes/delete.php?id=' . h($note['id'])); ?>">Delete</a></td>
                              <td><a class="card-link" href="<?php echo url_for('/staff/notes/edit.php?id=' . h($note['id'])); ?>">Edit</a></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        <?php
                          mysqli_free_result($note_set);
                        ?>
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
              <a class="card-link mr-4" href="<?php echo url_for('/staff/projects/delete.php?id=' . h(u($project['id']))); ?>">Delete project</a>
            </dt>
            <dt>
              <a class="card-link" href="<?php echo url_for('/staff/projects/edit.php?id=' . h(u($project['id'])) . '&company_id=' . h(u($project['company_id']))); ?>">Edit Project</a>
            </dt>
          </dl>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
