<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php $admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ''; ?>
<?php $company_set = find_all_user_company($admin); ?>
<?php $page_title = "Companies"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Leads</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <a href="<?php echo url_for('/staff/company/new.php'); ?>" class="btn btn-outline-info mb-2" role="button">Add new company</a>
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Companies</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Company</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Zip</th>
                  <th>URL</th>
                  <th>Phone</th>
                </tr>
              </thead>
              <tbody>

              <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <tr class='clickable-row' data-href="<?php echo url_for('/staff/company/show.php?id=' . h(u($company['id']))); ?>">
                  <td><?php echo h($company['id']); ?></td>
                  <td><?php echo h($company['company_name']); ?></td>
                  <td><?php echo h($company['company_address']); ?></td>
                  <td><?php echo h($company['company_city']); ?></td>
                  <td><?php echo h($company['company_state']); ?></td>
                  <td><?php echo h($company['company_zip']); ?></td>
                  <td><?php echo h($company['company_url']); ?></td>
                  <td><?php echo h($company['company_url']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>
            <?php
              mysqli_free_result($company_set);
             ?>
          </div><!-- .table-responsive -->
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
