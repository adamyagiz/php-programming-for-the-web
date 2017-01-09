<?php
  
  // Define application constants
  define('MATCHR_ICONPATH', 'img/icons/');
  define('MATCHR_UPLOADPATH', 'img/users/');
  define('MATCHR_MAXFILESIZE', 51200);      // 50 KB
  define('MATCHR_MAXIMGWIDTH', 120);        // 120 pixels
  define('MATCHR_MAXIMGHEIGHT', 120);       // 120 pixels

  // Define database connection constants
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASSWORD', 'root');
  define('DB_NAME', 'matchr');
  
  $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Could not connect to the database: ' . mysqli_connect_error());
  
?>