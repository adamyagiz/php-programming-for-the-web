<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == 0)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/login.php';
    header('Location: ' . $home_url);
  }
  
  $title = 'Edit Profile';
  require_once('template/HTMLstart.php');
  
  $save_success = false;
  
  if (isset($_POST['save_profile'])) {
    $first_name = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['first_name'])));
    $last_name = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['last_name'])));
    $gender = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['gender'])));
    $here_for = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['here_for'])));
    $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birth_year'])) . '-' . mysqli_real_escape_string($dbc, trim($_POST['birth_month'])) . '-' . mysqli_real_escape_string($dbc, trim($_POST['birth_day'])) ;
    $city = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['city'])));
    $state = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['state'])));
    $bio = mysqli_real_escape_string($dbc, strip_tags(trim($_POST['bio'])));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
    if (!empty($_FILES['new_picture']['name'])) {
      $new_picture = $_SESSION['user_id'].'_'.mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
      $new_picture_type = $_FILES['new_picture']['type'];
      $new_picture_size = $_FILES['new_picture']['size'];       
    } else {
      $new_picture = '';
    }

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {

      list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);

      if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') || ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MATCHR_MAXFILESIZE) && ($new_picture_width <= MATCHR_MAXIMGWIDTH) && ($new_picture_height <= MATCHR_MAXIMGHEIGHT)) {
        if ($_FILES['new_picture']['error'] == 0) {
          // Move the file to the target upload folder
          $target = MATCHR_UPLOADPATH . basename($new_picture);
          if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
            // The new picture file move was successful, now make sure any old picture is deleted
            if (!empty($old_picture) && ($old_picture != $new_picture)) {
              @unlink(MATCHR_UPLOADPATH . $old_picture);
            }
          }
          else {
            // The new picture file move failed, so delete the temporary file and set the error flag
            @unlink($_FILES['new_picture']['tmp_name']);
            $error = true;
            echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
          }
        }
      }
      else {
        // The new picture file is not valid, so delete the temporary file and set the error flag
        @unlink($_FILES['new_picture']['tmp_name']);
        $error = true;
        echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MATCHR_MAXFILESIZE / 1024) .
          ' KB and ' . MATCHR_MAXIMGWIDTH . 'x' . MATCHR_MAXIMGHEIGHT . ' pixels in size.</p>';
      }
    }

    list($status, $data) = update_profile($dbc, $first_name, $last_name, $gender, $here_for, $birthdate, $city, $state, $bio, $new_picture);

    if ($status) {
      $save_success = true;
    } else {
      $errors = $data;
    }
    
    $birthdate = explode('-',$birthdate);
    
    mysqli_close($dbc);
  
  } else {
    list($status, $data) = load_user_data($dbc, $_SESSION['user_id']);
    if ($status) {
      $first_name = $data['first_name'];
      $last_name = $data['last_name'];
      $gender = $data['gender'];
      $here_for = $data['here_for'];
      $birthdate = explode('-',$data['birthdate']);
      $city = $data['city'];
      $state = $data['state'];
      $bio = $data['bio'];
      $old_picture = $data['picture'];
    }
  }
  $state_list = array(
    'AL'=>"Alabama",  
  	'AK'=>"Alaska",  
		'AZ'=>"Arizona",  
		'AR'=>"Arkansas",  
		'CA'=>"California",  
		'CO'=>"Colorado",  
		'CT'=>"Connecticut",  
		'DE'=>"Delaware",  
		'DC'=>"District Of Columbia",  
		'FL'=>"Florida",  
		'GA'=>"Georgia",  
		'HI'=>"Hawaii",  
		'ID'=>"Idaho",  
		'IL'=>"Illinois",  
		'IN'=>"Indiana",  
		'IA'=>"Iowa",  
		'KS'=>"Kansas",  
		'KY'=>"Kentucky",  
		'LA'=>"Louisiana",  
		'ME'=>"Maine",  
		'MD'=>"Maryland",  
		'MA'=>"Massachusetts",  
		'MI'=>"Michigan",  
		'MN'=>"Minnesota",  
		'MS'=>"Mississippi",  
		'MO'=>"Missouri",  
		'MT'=>"Montana",
		'NE'=>"Nebraska",
		'NV'=>"Nevada",
		'NH'=>"New Hampshire",
		'NJ'=>"New Jersey",
		'NM'=>"New Mexico",
		'NY'=>"New York",
		'NC'=>"North Carolina",
		'ND'=>"North Dakota",
		'OH'=>"Ohio",  
		'OK'=>"Oklahoma",  
		'OR'=>"Oregon",  
		'PA'=>"Pennsylvania",  
		'RI'=>"Rhode Island",  
		'SC'=>"South Carolina",  
		'SD'=>"South Dakota",
		'TN'=>"Tennessee",  
		'TX'=>"Texas",  
		'UT'=>"Utah",  
		'VT'=>"Vermont",  
		'VA'=>"Virginia",  
		'WA'=>"Washington",  
		'WV'=>"West Virginia",  
		'WI'=>"Wisconsin",  
		'WY'=>"Wyoming"
	);
  $months = array (
    '1' => 'Jan',
    '2' => 'Feb',
    '3' => 'Mar',
    '4' => 'Apr',
    '5' => 'May',
    '6' => 'Jun',
    '7' => 'Jul',
    '8' => 'Aug',
    '9' => 'Sep',
    '10' => 'Oct',
    '11' => 'Nov',
    '12' => 'Dec'
  );
  $days = range (1, 31);
  $current_year = date('Y');
  $min_year = 18;
  $max_year = 99;
  
?>
<div class="content">
  <h2>Edit Profile</h2>
  <div id="profile" class="info left profile">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">        
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MATCHR_MAXFILESIZE; ?>" />

      <label for="first_name">First name:</label>
      <input type="text" id="first_name" name="first_name" value="<?php if (!empty($first_name)) echo $first_name; ?>" />
      <label for="last_name">Last name:</label>
      <input type="text" id="last_name" name="last_name" value="<?php if (!empty($last_name)) echo $last_name; ?>" />
      <label for="gender">Gender:</label>
      <select id="gender" name="gender">
        <option value="">Select</option>
        <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected="selected"'; ?>>Male</option>
        <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected="selected"'; ?>>Female</option>
      </select>
      <label for="here_for">Here For:</label>
      <select id="here_for" name="here_for">
        <option value="">Select</option>
        <option value="M" <?php if (!empty($here_for) && $here_for == 'M') echo 'selected="selected"'; ?>>Men</option>
        <option value="F" <?php if (!empty($here_for) && $here_for == 'F') echo 'selected="selected"'; ?>>Women</option>
      </select>
      <label for="birthdate">Birthday:</label>
      <select name="birth_month" id="birth_month" class="birthdate">
        <option value="">Month</option>
        <?php
          foreach ($months as $mm => $MM) {
            echo '<option value="'.$mm;
            if ($mm == $birthdate[1]) {
              echo '" selected="selected';
            }
            echo '">'.$MM.'</option>'."\n";
          }
        ?>
      </select>
      <select name="birth_day" id="birth_day" class="birthdate">
        <option value="">Day</option>
        <?php
          for ($day = 1; $day <= 31; $day++) {
            echo '<option value="'.$day;
            if ($day == $birthdate[2]) {
              echo '" selected="selected';
            }
            echo '">'.$day.'</option>'."\n";
          }
        ?>
      </select>
      <select name="birth_year" id="birth_year" class="birthdate">
        <option value="">Year</option>
        <?php
          for ($year = ($current_year - $min_year); $year >= ($current_year - $max_year); $year--) {
            echo '<option value="'.$year;
            if ($year == $birthdate[0]) {
              echo '" selected="selected';
            }
            echo '">'.$year.'</option>'."\n";
          }
        ?>        
      </select>      
      
      <!-- <input type="text" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>"> -->
      <label for="city">City:</label>
      <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>">
      <label for="state">State:</label>
      <select name="state" id="state" class="state">
        <option value="">State</option>
        <?php
          foreach ($state_list as $st => $state_name) {
            echo '<option value="'.$st;
            if ($st == $state) {
              echo '" selected="selected';
            }
            echo '">'.$state_name.'</option>'."\n";
          }
        ?>        
      </select>      
      
      <label for="bio">Bio:</label>
      <textarea name="bio" rows="8" cols="40"><?php if (!empty($bio)) echo $bio; ?></textarea>
      
      <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>">
      
      <label for="new_picture">Picture:</label>
      <input type="file" id="new_picture" name="new_picture">
      
      <input type="hidden" name="save_profile" value="1">
      <input type="submit" value="Save Profile" name="submit">
    </form>

  </div>
  <div class="info left">

    <?php
    
      if ($save_success) {
        echo '<p class="success">Your profile has been saved</p>';
      } 
      
      // if we have errors, loop through and display them to the user
      if(!empty($errors)) {
        foreach ($errors as $msg) {
          echo '<p class="error">' . $msg . '</p>';
        }
      }
      
      if (!empty($old_picture)) {
        echo '<img class="profile" src="' . MATCHR_UPLOADPATH . $old_picture . '" alt="Profile Picture">';
      }
    ?>
    
  </div>
  <br class="clear">

</div>

<?php
  require_once('template/HTMLend.php');
?>