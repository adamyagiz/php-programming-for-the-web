<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');

  if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php';
    header('Location: ' . $home_url);
  }

  if (isset($_POST['register_user'])) {

    // set user input variables
    $first_name = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['first_name'])));
    $last_name = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['last_name'])));
    $email = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['email'])));
    $password = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['password_reg'])));
    $password_conf = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['password_conf'])));
    
    // grab the result of the register_user() function
    list($status, $data) = register_user($dbc, $first_name, $last_name, $email, $password, $password_conf);
    
    if ($status) {
      // if result is good, try to log the new user in
      list($login, $data) = login($dbc, $email, $password);
      
      if ($login) {
        // if the new user could be logged in, redirect to the edit profile page
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/editprofile.php';
        header('Location: ' . $home_url);
      } else {
        // if user couldn't be logged in, collect the errors here
        $errors = $data;
      }
    } else {
      // if the user couldn't be registered, collect the errors here
      $errors = $data;
    }
    mysqli_close($dbc);
  }  
    
  $title = 'Join';
  require_once('template/HTMLstart.php');
  
  
?>

<div class="content register">
  <h2>Join Matchr Today!</h2>
  
  <div class="info left">
    <p>Welcome to Matchr, the best place to meet your match! Sign up for free and find love today.</p>
    <p>To get started, simply enter your name and email address. You can set up your complete your profile later.</p>
    <p>Already have an account? <a href="login.php">Click here</a> to log in.</p>
  </div>
  
  <div class="info left">
    
    <?php
      // if we have errors, loop through and display them to the user
      if(!empty($errors)) {
        foreach ($errors as $msg) {
          echo '<p class="error">' . $msg . '</p>';
        }
      }
    ?>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">        
      <label for="first_name">First Name: </label><input type="text" name="first_name" id="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name']; } ?>"><br>
      <label for="last_name">Last Name: </label><input type="text" name="last_name" id="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name']; } ?>"><br>
      <label for="email">Email Address: </label><input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>"><br>
      <label for="password_reg">Password: </label><input type="password" name="password_reg" id="password_reg"><br>
      <label for="password_conf">Confirm Password: </label><input type="password" name="password_conf" id="password_conf"><br>
      <input type="hidden" name="register_user" value="1">
      <input type="submit" value="Join Matchr">
    </form>
  </div>  
  <br class="clear">
  
</div>

<?php
  require_once('template/HTMLend.php');
?>