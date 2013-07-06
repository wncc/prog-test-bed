<?php
/*
 * Admin Settings
 */
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>
 	<div class="container">
 		<?php
        if(isset($_GET['logout']))
          echo("<div class=\"alert alert-info\">\nYou have logged out successfully!\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      else if(isset($_GET['passerror']))
          echo("<div class=\"alert alert-error\">\nIncorrect old password\n</div>");
      ?>
 		<?php include('menu.php'); ?>
		<form method="post" action="update.php">
          <input type="hidden" name="action" value="password"/>
	          <h1><small>Change Password</small></h1>
	          Old password: <input type="password" name="oldpass" required/><br/>
	          New password: <input type="password" name="newpass" required/><br/><br/>
	      <input class="btn" type="submit" name="submit" value="Change Password"/>
        </form>
        <hr/>
          
      <form method="post" action="update.php">
     	 <input type="hidden" name="action" value="email"/>
        	  <h1><small>Change Email</small></h1>
          <?php
          	$query = "SELECT email FROM users WHERE username='".$_SESSION['username']."'";
          	$result = mysql_query($query);
          	$fields = mysql_fetch_array($result);
          ?>
          Email: <input type="email" name="email" value="<?php echo $fields['email'];?>" required/><br/><br/>
          <input class="btn" type="submit" name="submit" value="Change Email"/>
      </form>
 	</div>

 <?php
	include('footer.php');
?>