<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == 0)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/login.php';
    header('Location: ' . $home_url);

  } else if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1)) {
    $errors = array();

    $email = $_SESSION['email'];
    $status = logout($email);

    if ($status) {
      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php';
      header('Location: ' . $home_url);
    }
  }
  
  $title = 'Logout';
  require_once('template/HTMLstart.php');

  require_once('template/HTMLend.php');
?>