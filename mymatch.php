<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == 0)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/login.php';
    header('Location: ' . $home_url);
  }
  
  $title = 'My Match';
  require_once('template/HTMLstart.php');  
  
?>
<div class="content">
  <h2>My Match</h2>
  <div id="mymatch" class="info left">

    <?php

      list($status, $data) = match_maker($dbc, $_SESSION['user_id']);
      
      $show_results = false;
      
      if ($status) {
        
        $show_results = true;
        
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        
        if (!empty($data['picture'])) {
          echo '<div class="picture"><img src="' . MATCHR_UPLOADPATH . $data['picture'] . '" alt="xx"></div>';
        } else {
          echo '<div class="picture"><img src="' . MATCHR_ICONPATH . 'user.png" alt="xx"></div>';
        }
        if (!empty($data['first_name']) && !empty($data['last_name'])) {
          echo '<div class="name"><span>Name:</span> ' . $data['first_name'] . ' ' . $data['last_name'] . '</div>';
        }
        if (!empty($data['city']) && !empty($data['state'])) {
          echo '<div class="location"><span>Location:</span> ' . $data['city'] . ', ' . $data['state'] . '</div>';
        }
        echo '<p>View <a href="/viewprofile.php?user_id=' . $data[8] . '">' . $data['first_name'] . '\'s full profile</a></p>';
        
        
      } else {
        $errors = $data;
      }
      // if we have errors, loop through and display them to the user
      if(!empty($errors)) {
        foreach ($errors as $msg) {
          echo '<p class="error">' . $msg . '</p>';
        }
      }      
      
      mysqli_close($dbc);
      
    ?>

  </div>
  <div class="info left">

    <?php
    
      if ($show_results) {
        // Display mismatched topics
        if (count($data[9]) > 0) {
          echo '<div>You have been matched on the following ' . count($data[9]) . ' topics:</div>';
          echo '<p>';
          foreach ($data[9] as $topic) {
            echo $topic . '<br />';
          }
          echo '</p>';
        }
        if (count($data[10]) > 0) {
          echo '<div>You have been partially matched on the following ' . count($data[10]) . ' topics:</div>';
          echo '<p>';
          foreach ($data[10] as $topic) {
            echo $topic . '<br />';
          }
          echo '</p>';
        }
        
      }
      
    ?>

  </div>
  <br class="clear">

</div>

<?php
  require_once('template/HTMLend.php');
?>