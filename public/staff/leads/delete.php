<?php require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/leads/index.php'));
}
$id = $_GET['id'];

if(is_post_request()){
  $result = delete_individual($id);
  redirect_to(url_for('/staff/leads/index.php'));
} else {
  $individual = find_individual_by_id($id);
}
 ?>
<?php $page_title = "Delete lead"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/leads/index.php'); ?>">Leads</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>"><?php echo h($individual['first_name']) . " " . h($individual['last_name']);?></a></li>
    <li class="breadcrumb-item active">Delete</li>
  </ol>
</div><!-- .container mt-4 -->

<div class="container">
  <div class="row">
    <div class="container col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h2>Delete Lead</h2>
        </div><!-- .card-header -->
        <div class="card-body">
          <p>Are you sure you want to delete?</p>
          <p><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?> </p>
          <form class="col-sm-6" action="<?php echo url_for('/staff/leads/delete.php?id=' . h(u($individual['id'])));?>" method="post">
              <?php echo display_errors($errors); ?>
              <fieldset class="form-group">
                <button class="btn btn-outline-info" type="submit">Delete</button>
              </fieldset><!-- fieldset -->
            </form>
            <a href="<?php echo url_for('/staff/leads/show.php?id=' . h(u($individual['id']))); ?>">&laquo; Back to <?php echo h($individual['first_name']) . " " . h($individual['last_name']);?></a>
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div><!-- .container col-sm-12 -->
  </div><!-- . row -->
</div><!-- .container -->

<?php include(SHARED_PATH. '/staff_footer.php'); ?>
