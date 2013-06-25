<?php
/*
 * Admin Login page
 */
	require_once('../functions.php');
	if(loggedin() and $_SESSION['username'] == 'admin')
		header("Location: index.php");
	else if(isset($_POST['password'])) {
		if(trim($_POST['password']) == "")
			header("Location: login.php?nerror=1"); // empty entry
		else {
			// code to login the user and start a session
			connectdb();
      $query = "SELECT random,hash FROM users WHERE username='admin'";
			$result = mysql_query($query);
			$fields = mysql_fetch_array($result);
			$currhash = crypt($_POST['password'], $fields['random']);
			if($currhash == $fields['hash']) {
				$_SESSION['username'] = "admin";
				header("Location: index.php");
			} else{
				header("Location: login.php?error=1");
      }
		}
	}
?>
<?php
  include('header.php');
?>

      <div class="container">
<?php
        if(isset($_GET['logout']))
          echo("<div class=\"alert alert-info\">\nYou have logged out successfully!\n</div>");
        else if(isset($_GET['error'])){
          echo("<div class=\"alert alert-error\">\nIncorrect Password!\n</div>");
        }
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
?>
      <h1><small>Login</small></h1>
      <p>Please login to use the admin panel.</p><br/>
      <form method="post" action="login.php">
        Password: <input type="password" name="password"/><br/><br/>
        <input class="btn" type="submit" name="submit" value="Login"/>
      </form>

      </div>

      <div id="push"></div>
      </div>

<?php
	include('footer.php');
?>
