<?php
  session_start();
  require_once('includes/appvars.php');
  require_once('includes/functions.php');
  
  if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == 0)) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/login.php';
    header('Location: ' . $home_url);
  }
  
  $title = 'Questionnaire';
  require_once('template/HTMLstart.php');  
  
?>
<div class="content">
  <h2>Questionnaire</h2>
  <div id="questionnaire" class="info left">

    <?php
    
      if (isset($_POST['save_questionnaire'])) {
        
        if (save_questionnaire($dbc, $_SESSION['user_id'], $_POST)) {
          echo '<p class="success">Your answers have been saved!</p>';
        }
      }
      
      list($status, $data) = load_questionnaire($dbc, $_SESSION['user_id']);
      
      if ($status) {

        echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" accept-charset="utf-8" enctype="multipart/form-data">';
        echo '<p>How do you feel about each topic?</p>';
        $category = $data[0]['category_name'];
        echo '<fieldset><span class="legend">' . $data[0]['category_name'] . '</span>';
        foreach ($data as $response) {
          // Only start a new fieldset if the category has changed
          if ($category != $response['category_name']) {
            $category = $response['category_name'];
            echo '</fieldset><fieldset><span class="legend">' . $response['category_name'] . '</span>';
          }

          // Display the topic form field
          echo '<label ' . ($response['response'] == NULL ? 'class=""' : '') . ' for="' . $response['response_id'] . '">' . $response['topic_name'] . ':</label>';
          echo '<input type="radio" name="' . $response['response_id'] . '" value="10" ' . ($response['response'] == 10 ? 'checked="checked"' : '') . ' />Like ';
          echo '<input type="radio" name="' . $response['response_id'] . '" value="1" ' . ($response['response'] == 1 ? 'checked="checked"' : '') . ' />Don\'t Like ';
          echo '<input type="radio" name="' . $response['response_id'] . '" value="3" ' . ($response['response'] == 3 ? 'checked="checked"' : '') . ' />Don\'t Care<br />';
        }
        echo '</fieldset>
        <input type="hidden" name="save_questionnaire" value="1">
        <input type="submit" value="Save Questionnaire" name="submit" />
        </form>';
        
        
        
      } else {
        echo 'oops';
      }

      mysqli_close($dbc);
      
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