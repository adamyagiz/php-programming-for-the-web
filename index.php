<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  $title = 'Home';
  require_once('template/HTMLstart.php');
  
?>
<div class="content">
  <h2>
    <?php 
      if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1)) {
        echo 'Hi, ' . $_SESSION['first_name'] . '!';
      } else {
        echo 'Welcome to Matchr!';
      }
    ?>
  </h2>
  <div class="info left">
    <p>Based on the tried-and-true method of match making&mdash;do you like this or not&mdash;Matchr can connect you with your soul mate.</p>
    <p>To get started on your path to happiness, follow these simple steps:</p>
    <ol>
      <li>Join Matchr and create your profile</li>
      <li>Fill out our psychologist-created, scientifically-proven questionnaire</li>
      <li>Find your match!</li>
    </ol>
    <p>If you're not completely satisfied with your match, click Browse Profiles to learn about other members of Matchr.</p>
  </div>
  <div id="members" class="info left">

  <?php

    list($status, $data) = list_users($dbc, 5);
    
    if ($status) {
      echo '<h3>Newest Members:</h3>';
      foreach ($data as $user) {
        if (is_file(MATCHR_UPLOADPATH . $user['picture']) && filesize(MATCHR_UPLOADPATH . $user['picture']) > 0) {
          echo '<div class="member"><img src="' . MATCHR_UPLOADPATH . $user['picture'] . '" alt="' . $user['first_name'] . '" /><br />';
        } else {
          echo '<div class="member"><img src="' . MATCHR_ICONPATH . 'user.png' . '" alt="' . $user['first_name'] . '" /><br />';
        }
        if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1)) {
          echo '<a href="/viewprofile.php?user_id=' . $user['user_id'] . '">' . $user['first_name'] . ' ' . substr($user['last_name'],0,1) .  '.</a></div>';
        } else {
          echo $user['first_name'] . ' ' . substr($user['last_name'],0,1) . '.</div>';
        }
      }
      if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1)) {
        echo '<br class="clear" /><p><a href="/browse.php" class="view_all">View All</a></p>';
      } else {
        echo '<br class="clear" /><p><a href="/login.php">Log in</a> or <a href="/register.php">sign up</a> to view profiles.</p>';
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

  </div>
  <br class="clear">

</div>

<?php
  require_once('template/HTMLend.php');
?>