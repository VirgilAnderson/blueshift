<?php require_once('../../../private/initialize.php'); ?>

<?php require_login(); ?>
<?php
  $id = isset($_GET['id']) ? $_GET['id'] : '1';
  $new = isset($_GET['new']) ? $_GET['new'] : '0';
  $individual = find_individual_by_id($id);
  if($new == 0){individual_visited($individual);}
  $admin = find_admin_by_id($individual['user_id']);
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
            <div class="col-sm-6">
              <ul class="list-group">
              <dl class="list-group-item d-flex">
                <dt class="mr-4">First Name</dt>
                <dd><?php echo h($individual['first_name']); ?></dd>
              </dl>
              <dl class="list-group-item d-flex">
                <dt class="mr-4">Last Name</dt>
                <dd><?php echo h($individual['last_name']); ?></dd>
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
          </div><!-- .col-sm-6 -->
            <div class="col-sm-6">
              <div class="card">
                <div class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#company_pane">Company</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#history_pane">History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#note_pane">Notes</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#task_pane">Tasks</a>
                  </li>
                </ul>
                </div><!-- .card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div id="company_pane" class="container tab-pane active"><br>
                      <h3>Company</h3>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div><!-- #company_pane -->
                   <div id="history_pane" class="container tab-pane active"><br>
                     <h3>History</h3>
                     <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                   </div><!-- #history -->
                   
                   <div id="note_pane" class="container tab-pane fade"><br>
                     <h3>Notes</h3>
                     <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                   </div><!-- #notes -->
                   <div id="task_pane" class="container tab-pane fade"><br>
                     <h3>Tasks</h3>
                     <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                   </div><!-- #tasks -->
                 </div><!-- .tab-content -->
                </div><!-- .card-body -->
              </div><!-- .card -->
            </div><!-- .col-5 -->
          </div><!-- .row -->
        </div><!-- .card-body -->
        <div class="card-footer">
          <dl class="list-group-item d-flex">
            <dt class="mr-4"><a class="card-link mr-4" href="<?php echo url_for('/staff/leads/delete.php?id=' . h(u($individual['id']))); ?>">Delete</a></dt>
            <dt><a class="card-link" href="<?php echo url_for('/staff/leads/edit.php?id=' . h(u($individual['id']))); ?>">Edit</a></dt>
          </dl>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->
<script src="../../js/tabs.js"></script>
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
