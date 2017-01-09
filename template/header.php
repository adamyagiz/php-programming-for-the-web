  <header>
    <div class="content">
      <a href="/index.php" class="logo left"><img class="left" src="../img/matchr-logo35.png" width="35" height="35" alt="Matchr Logo">
      <h1 class="left">Matchr</h1></a>
      
      <?php
        if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1)) {
        	echo '
        	<nav>
          	<a href="/index.php">Home</a>
          	<a href="/browse.php">Browse Profiles</a>
          	<a href="/viewprofile.php">View My Profile</a>
          	<a href="/editprofile.php">Edit My Profile</a>
          	<a href="/questionnaire.php">Questionnaire</a>
          	<a href="/mymatch.php">My Match</a>
          	<a href="/logout.php">Log out (' . $_SESSION['first_name'] . ')</a>
          </nav>';
        }
        else {
        	echo '
        	<nav>
        	  <a href="/register.php">Join Matchr</a>
        	  <a href="/login.php">Log In</a>
        	</nav>';
        }
      ?>
      <br class="clear">
    </div>
    <br class="clear">
  </header>