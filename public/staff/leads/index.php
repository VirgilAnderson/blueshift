<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php $individual_set = find_all_individual();?>
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
                  <th></th>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Lead Source</th>
                  <th>Date Added</th>
                </tr>
              </thead>
              <tbody>

              <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                <tr class='clickable-row' data-href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>">
                  <td><?php if($individual['viewed'] == 0){ echo "<span class='badge badge-info'>new</span> ";} ?></td>
                  <td><?php echo h($individual['id']); ?></td>
                  <td><?php echo h($individual['first_name']); ?></td>
                  <td><?php echo h($individual['last_name']); ?></td>
                  <td><?php echo h($individual['phone_direct']); ?></td>
                  <td><?php echo h($individual['email']); ?></td>
                  <td><?php echo h($individual['role']); ?></td>
                  <td><?php echo h($individual['lead_source']); ?></td>
                  <td><?php echo h($individual['lead_birthdate']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>

            <?php
              mysqli_free_result($individual_set);
             ?>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
