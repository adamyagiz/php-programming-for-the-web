<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == 0)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/login.php';
    header('Location: ' . $home_url);
  }
  
  $title = 'View Profile';
  require_once('template/HTMLstart.php');  
  
?>
<div class="content">
  <h2>User Profile</h2>
  <div id="profile" class="info left profile">

    <?php

      if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
      } else {
        $user_id = $_SESSION['user_id'];
      }

      list($status, $data) = view_profile($dbc, $user_id);
      
      if ($status) {
        if (!empty($data['picture'])) {
          echo '<div class="picture"><img src="' . MATCHR_UPLOADPATH . $data['picture'] . '" alt="xx"></div>';
        } else {
          echo '<div class="picture"><img src="' . MATCHR_ICONPATH . 'user.png" alt="xx"></div>';
        }
        if ($_SESSION['user_id'] == $data['user_id']) {
          // Show full name for logged in user only...
          echo '<div class="name"><span>Name:</span> ' . $data['first_name'] . ' ' . $data['last_name'] . '</div>';
          if ($data['birthdate'] == '0000-00-00') {
            echo '<div class="birthday"><span>Birthday:</span> <a href="/editprofile.php">Complete Your Profile</a></div>';
          } else {
            echo '<div class="birthday"><span>Birthday:</span> ' . date('F jS, Y',strtotime($data['birthdate'])) . '</div>';
          }
        } else {
          // otherwise, just show last initial
          echo '<div class="name"><span>Name:</span> ' . $data['first_name'] . ' ' . substr($data['last_name'],0,1) . '.</div>';
          if ($data['birthdate'] == '0000-00-00') {
            echo '<div class="birthday"><span>Birthday:</span> Profile Not Complete</div>';
          } else {
            echo '<div class="birthday"><span>Birthday:</span> ' . date('Y',strtotime($data['birthdate'])) . '</div>';            
          }
        }
        if (empty($data['gender']) && ($_SESSION['user_id'] == $data['user_id'])) {
          echo '<div class="gender"><span>Gender:</span> <a href="/editprofile.php">Complete Your Profile</a></div>';
        } else if (empty($data['gender'])) {
          echo '<div class="gender"><span>Gender:</span> Profile Not Complete</div>';
        } else {
          if ($data['gender'] == 'F') { $gender = 'Female'; }
          else if ($data['gender'] == 'M') { $gender = 'Male'; }
          else { $gender = 'Uhh...'; }
          echo '<div class="gender"><span>Gender:</span> ' . $gender . '</div>';
        }
        if (empty($data['here_for']) && ($_SESSION['user_id'] == $data['user_id'])) {
          echo '<div class="here_for"><span>Here For:</span> <a href="/editprofile.php">Complete Your Profile</a></div>';
        } else if (empty($data['here_for'])) {
          echo '<div class="here_for"><span>Here For:</span> Profile Not Complete</div>';
        } else {
          if ($data['here_for'] == 'F') { $here_for = 'Women'; }
          else if ($data['here_for'] == 'M') { $here_for = 'Men'; }
          else { $here_for = 'Uhh...'; }
          echo '<div class="here_for"><span>Here For:</span> ' . $here_for . '</div>';
        }

        if ((empty($data['city']) || empty($data['state'])) && ($_SESSION['user_id'] == $data['user_id'])) {
          echo '<div class="location"><span>Location:</span> <a href="/editprofile.php">Complete Your Profile</a></div>';
        } else if (empty($data['city']) || empty($data['state'])) {
          echo '<div class="location"><span>Location:</span> Profile Not Complete</div>';
        } else {
          echo '<div class="location"><span>Location:</span> ' . $data['city'] . ', ' . $data['state'] . '</div>';
        }
        
        echo '<div class="bio"><span>Bio:</span> ' . $data['bio'] .'</div>';
        
        // print_r($data);

      } else {
        // if user couldn't be logged in, collect the errors here
        $errors = $data;
      }
      
      mysqli_close($dbc);

      // if we have errors, loop through and display them to the user
      if(!empty($errors)) {
        foreach ($errors as $msg) {
          echo '<p class="error">' . $msg . '</p>';
        }
      }
      
    ?>

  </div>
  <div class="info left">

    <p></p>

  </div>
  <br class="clear">

</div>

<?php
  require_once('template/HTMLend.php');
?>