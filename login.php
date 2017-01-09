<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php';
    header('Location: ' . $home_url);
  }
  
  if (isset($_POST['login'])) {

    // set user input variables
    $email = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['email'])));
    $password = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['password_login'])));

    // grab the result of the login() function
    list($status, $data) = login($dbc, $email, $password);

    if ($status) {
      // if result is good, redirect them to the home page
      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php';
      header('Location: ' . $home_url);
    } else {
      // if user couldn't be logged in, collect the errors here
      $errors = $data;
    }    
    mysqli_close($dbc);
  }
  
  $title = 'Login';
  require_once('template/HTMLstart.php');
  

?>
<div class="content login">
  <h2>Login</h2>
  <div class="info left">
    <p>Matchr members can log in here.</p>
    <p>If you haven't signed up yet, <a href="register.php">click here</a> to start creating your own profile and meet your match.</p>
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
      <label for="email">Email Address: </label><input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>"><br>
      <label for="password_login">Password: </label><input type="password" name="password_login" id="password_login"><br>
      <input type="hidden" name="login" value="1">
      <input type="submit" value="Log In">
    </form>
  </div>
  <br class="clear">
</div>
<?php
  require_once('template/HTMLend.php');
?>