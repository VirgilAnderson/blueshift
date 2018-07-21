<?php require_once('../../private/initialize.php');
$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  // Validations
  if(is_blank($username)){
    $errors[]="Username cannot be blank.";
  }
  if(is_blank($password)){
    $errors[]="Password cannot be blank.";
  }
  // If there were no errors, process the form
  if(empty($errors)){
      $login_failure_msg = "Login was not successful.";
      $admin = find_admin_by_username($username);
      if($admin){
        // Using one variable to set the logic error message


        if(password_verify($password, $admin['hashed_password'])){
          // password matches
          log_in_admin($admin);
          redirect_to(url_for('/staff/index.php'));
        } else {
          // password does not match
          $errors[] = $login_failure_msg;
        }
      } else {
        // no username found
        $errors[] = $login_failure_msg;
      }
    }
  }
?>
<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container" style="margin-top: 90px;">

  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url_for('index.php'); ?>" >Home</a></li>
    <li class="breadcrumb-item active">Login</li>
  </ol>

<form class="col-sm-6" action="login.php" method="post">
    <h2>User Login</h2> 
    <?php echo display_errors($errors); ?>
    <fieldset class="form-group">
      <legend>Your Info</legend>

      <div class="form-group">
        <label class="form-control-label" for="name">Username</label>
        <input class="form-control" type="text" name="username" value="<?php echo h($username); ?>">
      </div><!-- form-group -->

      <div class="form-group">
        <label class="form-control-label" >Password</label>
        <input type="password" name="password" value="" class="form-control">
      </div><!-- form-group -->

      <button class="btn btn-outline-info" type="submit">Login</button>

    </fieldset><!-- fieldset -->
  </form>
</div><!-- content container -->

<?php include(SHARED_PATH. '/public_footer.php'); ?>
