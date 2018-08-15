<?php require_once('../../../private/initialize.php');
  require_login();
  $id = isset($_GET['id']) ? $_GET['id'] : '1';
  $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
  $new = isset($_GET['new']) ? $_GET['new'] : '0';
  $individual = find_individual_by_id($id);
  $company = find_company_by_id($individual['company_id']);
  $company_set = find_all_user_company($admin);
  $task_set = find_all_task_individual($individual['id']);
  if($new == 0){individual_visited($individual);}
  $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
  $user = find_admin_by_id($individual['user_id']);
  $note_set = find_all_user_notes($individual);
  $history_set = find_history_by_individual_id($id);
  $project = find_project_by_id($individual['project_id']);
  $project_set = find_all_user_project($admin);

  if(is_post_request()) {

    // Submit insert project form
    if(isset($_POST['insert_project'])){
      $individual = [];
      $individual['project_id'] = isset($_POST['project_id']) ? $_POST['project_id'] : '';

      $result = insert_project_into_individual($individual, $id);
      if($result === true){
        redirect_to(url_for('/staff/leads/show.php?id=' . $id));
      } else {
        $errors = $result;

        // var_dump($errors);
      }
    }

    // Submit insert company form
    if(isset($_POST['insert_company'])){
      $individual = [];
      $individual['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';

      $result = insert_company_into_individual($individual, $id);
      if($result === true){
        redirect_to(url_for('/staff/leads/show.php?id=' . $id));
      } else {
        $errors = $result;

        // var_dump($errors);
      }
    }


  } else {
    $individual = find_individual_by_id($id);
  }
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
                <dd><?php echo h($user['username']); ?></dd>
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
                    <a class="nav-link" data-toggle="tab" href="#project_pane">Project</a>
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
                      <ul class="list-group list-group-flush" <?php if(!$company){echo "style='display: none;'";} ?>>
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


                      <dl class="list-group-item d-flex bg-light">
                        <dt class="mr-4">
                          <a <?php if(!$company){echo 'style="display: none;"';} ?> class="card-link mr-4" href="<?php echo url_for('/staff/company/delete.php?id=' . h(u($company['id']))); ?>">Delete Company</a>
                        </dt>
                        <dt class="mr-4">
                          <a <?php if(!$company){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/company/edit.php?id=' . h(u($company['id']))); ?>">Edit Company</a>
                        </dt>
                      </dl>
                      </ul>

                      <!-- link to company -->
                      <form class="col-sm-12" action="<?php echo url_for('staff/leads/show.php?id=' . h(u($id))); ?>" method="post" <?php if($company){echo "style='display: none;'";} ?>>
                        <fieldset class="form-group">
                        <legend>Link to company</legend>

                        <div class="form-group">
                          <label for="company_id">Select list:</label>
                              <select class="form-control" name="company_id">
                                <option value="none">none</option>
                            <?php while($company_link = mysqli_fetch_assoc($company_set)){ ?>
                                <option value="<?php echo h($company_link['id']); ?>" <?php if($company_link['id'] == $company['id']){echo "selected";} ?>><?php echo h($company_link['company_name']); ?></option>
                            <?php } ?>
                            </select>
                        </div><!-- form-group -->

                        <button class="btn btn-outline-info" type="submit" name="insert_company">Add <?php echo h($individual['first_name']) . " " . h($individual['last_name']);?> to company</button>
                        </fieldset><!-- fieldset -->
                      </form>


                    </div><!-- #company_pane -->

                    <div id="project_pane" class="container tab-pane"><br>
                      <ul class="list-group list-group-flush" <?php if(!$project){echo "style='display: none;'";} ?>>
                        <dl class="list-group-item d-flex bg-light" >

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
                          <dd><?php echo h($user['username']); ?></dd>
                        </dl>

                        <dl class="list-group-item d-flex">
                          <dt class="mr-4">
                            <a <?php if(!$project){echo 'style="display: none;"';} ?> class="card-link mr-4" href="<?php echo url_for('/staff/projects/delete.php?id=' . h(u($project['id']))); ?>">Delete Project</a>
                          </dt>
                          <dt>
                            <a <?php if(!$project){echo 'style="display: none;"';} ?> class="card-link" href="<?php echo url_for('/staff/projects/edit.php?id=' . h(u($project['id']))); ?>">Edit Project</a>
                          </dt>
                        </dl>
                      </ul>

                      <!-- link to project -->
                      <form class="col-sm-12" action="<?php echo url_for('staff/leads/show.php?id=' . h(u($id))); ?>" method="post" <?php if($project){echo "style='display: none;'";} ?>>
                        <fieldset class="form-group">
                        <legend>Add to project</legend>

                        <div class="form-group">
                          <label for="project_id">Select list:</label>
                              <select class="form-control" name="project_id">
                                <option value="none">none</option>
                            <?php while($project_link = mysqli_fetch_assoc($project_set)){ ?>
                                <option value="<?php echo h($project_link['id']); ?>" <?php if($project_link['id'] == $project['id']) {echo "selected"; } ?>><?php echo h($project_link['project_title']); ?></option>
                            <?php } ?>
                            </select>
                        </div><!-- form-group -->

                        <button class="btn btn-outline-info" type="submit" name="insert_project">Add <?php echo h($individual['first_name']) . " " . h($individual['last_name']);?> to project</button>
                        </fieldset><!-- fieldset -->
                      </form>

                    </div><!-- #project_pane -->

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
