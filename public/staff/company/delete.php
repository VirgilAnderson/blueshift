<?php require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/company/index.php'));
}
$id = $_GET['id'];
$company = find_company_by_id($id);
$individual = find_individual_by_company_id($id);

if(is_post_request()){
  $result = delete_company($id, $individual);
  redirect_to(url_for('/staff/company/index.php'));
}
 ?>
<?php $page_title = "Delete company"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/company/index.php'); ?>">Company</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/company/show.php?id=' . h(u($company['id']))); ?>"><?php echo h($company['company_name']);?></a></li>
    <li class="breadcrumb-item active">Delete</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Delete Company</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <p>Are you sure you want to delete?</p>

          <p><?php echo h($company['company_name']); ?> </p>
          <form class="col-sm-6" action="<?php echo url_for('/staff/company/delete.php?id=' . h(u($company['id'])));?>" method="post">

              <?php echo display_errors($errors); ?>

              <fieldset class="form-group">
                <button class="btn btn-outline-info" type="submit">Delete</button>
              </fieldset><!-- fieldset -->
            </form>
            <a href="<?php echo url_for('/staff/company/show.php?id=' . h(u($company['id']))); ?>">&laquo; Back to <?php echo h($company['company_name']);?></a>
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
