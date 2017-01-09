<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == 0)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/login.php';
    header('Location: ' . $home_url);
  }
  
  $title = 'Browse Users';
  require_once('template/HTMLstart.php');  
  
?>
<div class="content">
  <h2>Browse Users</h2>
  <div id="browse">

    <?php

      list($status, $data) = list_users($dbc, null, 'first_name', 'ASC');

      if ($status) {
        foreach ($data as $user) {
          if (is_file(MATCHR_UPLOADPATH . $user['picture']) && filesize(MATCHR_UPLOADPATH . $user['picture']) > 0) {
            echo '<div class="member"><img class="left" src="' . MATCHR_UPLOADPATH . $user['picture'] . '" alt="' . $user['first_name'] . '">';
          } else {
            echo '<div class="member"><img class="left" src="' . MATCHR_ICONPATH . 'user.png' . '" alt="' . $user['first_name'] . '">';
          }
          echo 'Name: ' . $user['first_name'] . ' ' . substr($user['last_name'],0,1) .  '.<br>';
          
          if ($user['gender'] == 'F') { $gender = 'Female'; }
          else if ($user['gender'] == 'M') { $gender = 'Male'; }
          else { $gender = 'Uhh...'; }
          
          echo 'Gender: ' . $gender . '<br>';
          echo 'Birthdate: ' . date('Y',strtotime($user['birthdate'])) . '<br>';
          echo '<a href="/viewprofile.php?user_id=' . $user['user_id'] . '">View Profile</a>';
          
          echo '<br class="clear"></div>';
        }
      } else {
        $errors = $data;
      }
      
      mysqli_close($dbc);

      // if we have errors, loop through and display them to the user
      if(!empty($errors)) {
        foreach ($errors as $msg) {
          echo '<h3 class="">' . $msg . '</h3>';
        }
      }

      
    ?>
    <br class="clear">
  </div>

</div>

<?php
  require_once('template/HTMLend.php');
?>