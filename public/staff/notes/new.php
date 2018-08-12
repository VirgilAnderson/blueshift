<?php require_once('../../../private/initialize.php');
require_login();
$admin_set = find_all_admins();
$admin = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$company_set = find_all_user_company($admin);
$user_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '';
$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
$individual_set = find_all_user_individual($admin);
$individual_id = isset($_GET['individual_id']) ? $_GET['individual_id'] : '';
$next_id = last_note_id();

if(is_post_request()) {

  // Handle form values submitted by new.php

  $note = [];
  $note['note'] = isset($_POST['note']) ? $_POST['note'] : '';
  $note['individual_id'] = isset($_POST['individual_id']) ? $_POST['individual_id'] : '';
  $note['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';
  $note['company_id'] = isset($_POST['company_id']) ? $_POST['company_id'] : '';



  $result = insert_note($note, $next_id);
  if($result === true){
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The note was created successfully.';
    redirect_to(url_for('/staff/notes/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }
}

?>

<?php $page_title = "New Note"; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>


<div class="container" style="margin-top:90px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/index.php'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url_for('/staff/leads/index.php'); ?>">Leads</a></li>
    <li class="breadcrumb-item active">New Note</li>
  </ol>
  <form class="col-sm-6" action="<?php echo url_for('/staff/notes/new.php'); ?>"  method="post">
      <h2>New Note</h2>
      <?php echo display_errors($errors); ?>
      <fieldset class="form-group">
        <legend>Fill in the form to create a new note</legend>

        <div class="form-group">
          <label for="note">Note Description:</label>
          <textarea class="form-control" rows="5" name="note"></textarea>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="company_id">Company:</label>
            <select class="form-control" name="company_id">
                <option>none</option>
              <?php while($company = mysqli_fetch_assoc($company_set)){ ?>
                <option value="<?php echo h($company['id']); ?>" <?php if($company['id'] == $company_id){echo "selected";}?>><?php echo h($company['company_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="task_source">Employee:</label>
            <select class="form-control" name="individual_id">
                <option>none</option>
              <?php while($individual = mysqli_fetch_assoc($individual_set)){ ?>
                <option value="<?php echo h($individual['id']); ?>" <?php if($individual['id'] == $individual_id){echo "selected";}?>><?php echo h($individual['first_name']) . " " . h($individual['last_name']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->

        <div class="form-group">
          <label for="user_id">Lead Owner:</label>
            <select class="form-control" name="user_id">
              <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
              <option value="<?php echo h($admin['id']); ?>"><?php echo h($admin['username']); ?></option>
              <?php } ?>
            </select>
        </div><!-- form-group -->



        <button class="btn btn-outline-info" type="submit">Create New Note</button>

      </fieldset><!-- fieldset -->
    </form>
</div><!-- .container mt-4 -->
<?php include(SHARED_PATH. '/staff_footer.php'); ?>
