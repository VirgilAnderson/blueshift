<?php require_once('../../../private/initialize.php'); ?>
<?php $subject_set = find_all_individual();?>
<?php $page_title = "leads"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Leads</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <a href="<?php echo url_for('/staff/leads/new.php'); ?>" class="btn btn-outline-info mb-2" role="button">Add new lead</a>
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Leads</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Lead Source</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>John</td>
                  <td>Doe</td>
                  <td>john@example.com</td>
                </tr>

              </tbody>
            </table>

            <?php
              mysqli_free_result($subject_set);
             ?>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
