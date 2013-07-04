<?php
/*
 * Prog Test Bed Login page
 */
	require_once('functions.php');
	if(loggedin())
		header("Location: index.php");
	else if(isset($_POST['action'])) {
		$username = mysql_real_escape_string($_POST['username']);
		if($_POST['action']=='register') {
			// register the user
			$email = mysql_real_escape_string($_POST['email']);
			if(trim($username) == "" or trim($_POST['password']) == "" or trim($email) == "")
				header("Location: register.php?nerror=1"); // empty entry
			else {
				// create the entry in the users table
				connectdb();
				$query = "SELECT random,hash FROM users WHERE username='".$username."'";
				$result = mysql_query($query);
				if(mysql_num_rows($result)!=0)
					header("Location: register.php?exists=1");
				else {
					$random = randomNum(5);
					$hash = crypt($_POST['password'], $random);
					$sql="INSERT INTO `users` ( `username` , `random` , `hash` , `email` ) VALUES ('".$username."', '$random', '$hash', '".$email."')";
					mysql_query($sql);
					header("Location: login.php?registered=1");
				}
			}
		}
	}
?>


<?php
include("header.php");
?>

 <div class="container">
<?php
        if(isset($_GET['logout']))
          echo("<div class=\"alert alert-info\">\nYou have logged out successfully!\n</div>");
        else if(isset($_GET['error']))
          echo("<div class=\"alert alert-error\">\nIncorrect username or password!\n</div>");
      else if(isset($_GET['ldaperr']))
          echo("<div class=\"alert alert-error\">\nIncorrect LDAP username or LDAP password!\n</div>");
        else if(isset($_GET['registered']))
          echo("<div class=\"alert alert-success\">\nYou have been registered successfully! Login to continue.\n</div>");
        else if(isset($_GET['exists']))
          echo("<div class=\"alert alert-error\">\nUser already exists! Please select a different username.\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>
      <form method="post" action="register.php">
        <input type="hidden" name="action" value="register"/>
        <h1><small>Register now</small></h1>
        Username: <input type="text" name="username" required/><br/>
        Password: <input type="password" name="password" required/><br/>
        Email: <input type="email" name="email" required/><br/><br/>
        <input class="btn btn-primary" type="submit" name="submit" value="Register"/>
    </div> <!-- /container -->

<?php
	include('footer.php');
?>

