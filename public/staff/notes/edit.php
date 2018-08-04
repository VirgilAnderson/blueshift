<?php require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/notes/index.php'));
}
$id = $_GET['id'];
$admin_set = find_all_admins();
$admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$company_set = find_all_user_company($admin);
$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
$company = find_company_by_id($company_id);
$individual_set = find_all_user_individual($admin);
$individual_id = isset($_GET['individual_id']) ? $_GET['individual_id'] : '';

if(is_post_request()) {

  // Handle form values submitted by new.php
  $note = [];
  $note['id'] = $id;
  $note['note'] = isset($_POST['note']) ? $_POST['note'] : '';
  $note['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';
  $note['individual_id'] = isset($_POST['individual_id']) ? $_POST['individual_id'] : '';
  $note['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';

  $result = update_note($note);
  if($result === true){
    redirect_to(url_for('/staff/notes/show.php?id=' . $id));
  } else {
    $errors = $result;
    // var_dump($errors);
  }

} else {
  $note = find_note_by_id($id);
}
 ?>
<?php $page_title = "Edit Note"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/notes/index.php'); ?>">notes</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/notes/show.php?id=' . h(u($note['id']))); ?>"><?php echo h($note['id']);?></a></li>
    <li class="breadcrumb-item"><a>Edit note</a></li>
  </ol>



  <form class="col-sm-6" action="<?php echo url_for('/staff/notes/edit.php?id=' . h(u($id))); ?>" method="post">
      <h2>Edit Note</h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Note Info</legend>

        <div class="form-group">
          <label for="note">Note Description:</label>
          <textarea class="form-control" rows="5" name="note"><?php echo $note['note']; ?></textarea>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="company_id">Company:</label>
            <select class="form-control" name="company_id">
                <option>none</option>
              <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <option value="<?php echo h($company['id']); ?>" <?php if($company['id'] == $note['company_id']){echo "selected";}?>><?php echo h($company['company_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="individual_id">Employee:</label>
            <select class="form-control" name="individual_id">
                <option>none</option>
              <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                <option value="<?php echo h($individual['id']); ?>" <?php if($individual['id'] == $note['individual_id']){echo "selected";}?>><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="user_id">note Owner:</label>
            <select class="form-control" name="user_id">
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']); ?>" ><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <button class="btn btn-outline-info" type="submit">Edit</button>

      </fieldset><!-- fieldset -->
    </form>
  </div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
