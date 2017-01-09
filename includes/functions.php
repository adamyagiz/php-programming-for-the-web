<?php
  
  // register a new user
  function register_user($dbc, $first_name, $last_name, $email, $password, $password_conf) {
    // Set the errors array to collect any errors that may occur
    $errors = array();
    $email_format = "/^([0-9a-zA-Z]+)([0-9a-zA-Z\.-_]+)@([0-9a-zA-Z\.-_]+)\.([0-9a-zA-Z]+)/";
    
    if (empty($first_name)) { $errors[] = 'Please enter your First Name'; }
    if (empty($last_name)) { $errors[] = 'Please enter your Last Name'; }
    if (empty($email)) { $errors[] = 'Please enter your Email Address'; } else if (!preg_match($email_format,$email)) { $errors[] = 'Please enter a valid email address'; }
    if (empty($password)) { $errors[] = 'Please enter your Password'; }
    if (empty($password_conf)) { $errors[] = 'Please confirm your Password'; }
    if ($password != $password_conf) { $errors[] = 'Passwords do not match'; }
    
    
    if (empty($errors)) {
      // Connect to the database        
      $query = "SELECT * FROM users WHERE email = '$email'";
      $data = mysqli_query($dbc, $query);
      // make sure the username is not already taken
      if (mysqli_num_rows($data) == 0) {
        $query = "INSERT INTO users (first_name, last_name, email, pass, join_date) VALUES ('$first_name', '$last_name', '$email', SHA1('$password'), NOW())";
        $data = mysqli_query($dbc, $query) or die('error: ' . mysqli_error($dbc));
        
        // send_mail($first_name, $username, $email);
        
        return array(true, $data);
        
      } else {
        $errors[] = 'Email address is already registered';
      }
    }
    return array(false, $errors);
  }

  // login() function checks username and password credentials
  function login($dbc, $email = '', $password = '') {
    // Set the errors array to collect any errors that may occur
    $errors = array();
    
    if (empty($email)) { $errors[] = 'Please enter your Email Address'; }
    if (empty($password)) { $errors[] = 'Please enter your Password'; }
    
    if (empty($errors)) {
      // Look up the username and password in the database
      $query = "SELECT user_id, first_name, last_name, email FROM users WHERE email = '$email' AND pass = SHA1('$password')";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 1) {
        // The log-in is OK so set the session vars...
        $row = mysqli_fetch_array($data);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['logged_in'] = 1;

        load_questionnaire($dbc, $row['user_id']);
        // return the data to the login script
        return array(true, $row);
      } else {
        // The username/password are incorrect so set an error message
        $errors[] = 'Incorrect Email Address and/or Password';
      }
    }    
    return array(false, $errors);
  }
  
  function logout($email) {
    // If the user is logged in, delete the session vars to log them out  
    if (isset($_SESSION['user_id'])) {
    	// Delete session vars by clearing $_SESSION array
    	$_SESSION = array();
      // Destroy the session
      session_destroy();
    }
    return true;
  }
  
  function list_users($dbc, $limit = null, $order_by = 'join_date', $order = 'DESC') {
    // Set the errors array to collect any errors that may occur
    $errors = array();
    if ($limit !== null) {
      $max = "LIMIT $limit";
    } else {
      $max = null;
    }
    // Retrieve the user data from MySQL
    $query = "SELECT user_id, first_name, last_name, gender, birthdate, picture FROM users WHERE first_name IS NOT NULL ORDER BY $order_by $order $max";
    $data = mysqli_query($dbc, $query);
  
    if (mysqli_num_rows($data) > 0) {
      // create users array to collect all users
      $users = array();
      // Users have been found, so return the data
      while ($row = mysqli_fetch_array($data)) {
        $users[] = $row;
      }
      return array(true, $users);

    } else {
      $errors[] = 'Impress your friends and be the first to register!';
    }
    return array(false, $errors); 
  }
  
  function view_profile($dbc, $user_id) {
    // Set the errors array to collect any errors that may occur
    $errors = array();

    // Grab the profile data from the database
    if (empty($user_id)) {
      $query = "SELECT user_id, first_name, last_name, gender, birthdate, city, state, here_for, picture, bio FROM users WHERE user_id = '" . $_SESSION['user_id'] . "'";
    } else {
      $query = "SELECT user_id, first_name, last_name, gender, birthdate, city, state, here_for, picture, bio FROM users WHERE user_id = '" . $user_id . "'";
    }
    
    $data = mysqli_query($dbc, $query);

    if (mysqli_num_rows($data) == 1) {
      // The user row was found so display the user data
      $row = mysqli_fetch_array($data);
      return array(true, $row);
    } else {
      $errors[] = 'There was a problem accessing this profile';
    }
    return array(false, $errors);      
  }
  
  function load_user_data($dbc, $user_id) {
    // Set the errors array to collect any errors that may occur
    $errors = array();
    
    if (empty($user_id)) { $errors[] = 'Missing required user data'; }
    
    if (empty($errors)) {
      $query = "SELECT first_name, last_name, gender, here_for, birthdate, city, state, bio, picture FROM users WHERE user_id = $user_id";
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
      return array(true, $row);
    }
    
    return array(false, $errors);
  }

  function update_profile($dbc, $first_name, $last_name, $gender, $here_for, $birthdate, $city, $state, $bio, $picture) {
    // Set the errors array to collect any errors that may occur
    $errors = array();

    if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate) && !empty($city) && !empty($state) && !empty($here_for)) {
      if ($gender == 'M' && $here_for == 'M') { $same_sex = 1; }
      else if ($gender == 'F' && $here_for == 'F') { $same_sex = 2; }
      else { $same_sex = 0; }
      
      // Only set the picture column if there is a new picture
      if (!empty($picture)) {
        $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', here_for = '$here_for', birthdate = '$birthdate', city = '$city', state = '$state', bio = '$bio', same_sex = '$same_sex', picture = '$picture' WHERE user_id = '" . $_SESSION['user_id'] . "'";
      }
      else {
        $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', here_for = '$here_for', birthdate = '$birthdate', city = '$city', state = '$state', bio = '$bio', same_sex = '$same_sex' WHERE user_id = '" . $_SESSION['user_id'] . "'";
      }
      $data = mysqli_query($dbc, $query);

      // Confirm success with the user
      return array(true, $data);

    }
    else {
      $errors[] = 'You must enter all of the profile data (the picture is optional)';
    }
    
    return array(false, $errors);
  }
  
  
  function load_questionnaire($dbc, $user_id) {
    // Set the errors array to collect any errors that may occur
    $errors = array();
    
    $query = "SELECT * FROM responses WHERE user_id = $user_id";
    $data = mysqli_query($dbc, $query);
    if (mysqli_num_rows($data) == 0) {
      // First grab the list of topic IDs from the topic table
      $query = "SELECT topic_id FROM topics ORDER BY category_id, topic_id";
      $data = mysqli_query($dbc, $query);
      $topicIDs = array();
      while ($row = mysqli_fetch_array($data)) {
        array_push($topicIDs, $row['topic_id']);
      }

      // Insert empty response rows into the response table, one per topic
      foreach ($topicIDs as $topic_id) {
        $query = "INSERT INTO responses (user_id, topic_id) VALUES ($user_id, $topic_id)";
        mysqli_query($dbc, $query);
      }
    }    

    if (empty($errors)) {
      $query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name, mc.name AS category_name FROM responses AS mr INNER JOIN topics AS mt USING (topic_id) INNER JOIN categories AS mc USING (category_id) WHERE mr.user_id = $user_id";
      $data = mysqli_query($dbc, $query);
      $responses = array();
      while ($row = mysqli_fetch_array($data)) {
        array_push($responses, $row);
      }
      
      return array(true, $responses);
    }
        
    return array (false, $errors);    
  }
  
  function save_questionnaire($dbc, $user_id, $data) {
    
    foreach ($data as $response_id => $response) {
      $query = "UPDATE responses SET response = '$response' WHERE response_id = '$response_id'";
      $data = mysqli_query($dbc, $query);
    }

    return true; 
  }
  
  function match_maker($dbc, $user_id) {
    
    // Find out who the user is here to be matched with (M or F)
    $query = "SELECT same_sex, gender, here_for FROM users WHERE user_id = '$user_id'";
    $data = mysqli_query($dbc, $query);
    if (mysqli_num_rows($data) > 0) {
      while ($row = mysqli_fetch_array($data)) {
        $same_sex = $row['same_sex'];
        $gender = $row['gender'];
        $here_for = $row['here_for'];
      }
    } else { $same_sex = '?'; }
    
    // echo $same_sex;
        
    // Only look for matches where the user has anwserd questions
    $query = "SELECT * FROM responses WHERE user_id = '$user_id' AND response != ''";
    $data = mysqli_query($dbc, $query);
        
    if (mysqli_num_rows($data) != 0) {
            
      // Grab the user's responses from the response table
      $query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name FROM responses AS mr INNER JOIN topics AS mt USING (topic_id) WHERE mr.user_id = $user_id";
      $data = mysqli_query($dbc, $query);      
      $user_responses = array();
      while ($row = mysqli_fetch_array($data)) {
        array_push($user_responses, $row);
      }
      
      // echo '<pre>';
      // print_r($user_responses);
      // echo '</pre>';      

      // Initialize the matchr search results
      $matchr_score = 0;
      $matchr_user_id = -1;
      $matchr_topics = array();

      // Loop through the user table comparing other people's responses to the user's response
      if ($same_sex == 0) {
        $query = "SELECT user_id FROM users WHERE user_id != '$user_id' AND same_sex = '$same_sex' AND gender = '$here_for'";
      } else {
        $query = "SELECT user_id FROM users WHERE user_id != '$user_id' AND same_sex = '$same_sex'";
      }
      $data = mysqli_query($dbc, $query);

      if (mysqli_num_rows($data) > 0) {
        while ($row = mysqli_fetch_array($data)) {
          // Grab the response data for the user
          $query2 = "SELECT response_id, topic_id, response FROM responses WHERE user_id = '" . $row['user_id'] . "'";
          $data2 = mysqli_query($dbc, $query2);
          $matchr_responses = array();
          while ($row2 = mysqli_fetch_array($data2)) {
            array_push($matchr_responses, $row2);
          }
          
          // echo '<pre>';
          // print_r($matchr_responses);
          // echo '</pre>';
          
          // Compare each response and calculate a match total
          $score = 0;
          $topics_full = array();
          $topics_partial = array();
          for ($i = 0; $i < count($user_responses); $i++) {
            if ($user_responses[$i]['response'] + $matchr_responses[$i]['response'] == 20 || $user_responses[$i]['response'] +  $matchr_responses[$i]['response'] == 6 || $user_responses[$i]['response'] +  $matchr_responses[$i]['response'] == 2) {
              $score += 1;
              array_push($topics_full, $user_responses[$i]['topic_name']);
            }
          }
          for ($i = 0; $i < count($user_responses); $i++) {
            if ($user_responses[$i]['response'] + $matchr_responses[$i]['response'] == 13) {
              $score += 1;
              array_push($topics_partial, $user_responses[$i]['topic_name']);
            }
          }

          // Check to see if this person is better than the best match so far
          if ($score > $matchr_score) {
            // We found a better match, so update the search results
            $matchr_score = $score;
            $matchr_user_id = $row['user_id'];
            $matchr_topics_full = array_slice($topics_full, 0);
            $matchr_topics_partial = array_slice($topics_partial, 0);
          }
        }
      }

      // Make sure a match was found
      if ($matchr_user_id != -1) {
        $query = "SELECT first_name, last_name, city, state, gender, here_for, bio, picture FROM users WHERE user_id = '$matchr_user_id'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 1) {
          // The user row for the match was found, so display the user data
          $row = mysqli_fetch_array($data);
                    
          array_push($row, $matchr_user_id, $matchr_topics_full, $matchr_topics_partial);

          return array(true, $row);
        }
      } else {
        $errors[] = 'Sorry... No matches made. Don\'t worry, these things take time.';
      }
      return array(false, $errors);
    } else {
      $errors[] = 'Please fill out the <a href="/questionnaire.php">questionnaire</a> so that we know how to find your match';
    }

    return array(false, $errors);    
    
  }


?>