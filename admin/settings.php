<?php
/*
 * Admin Settings
 */
	require_once('../functions.php');
	if(!loggedin())
		header("Location: login.php");
	else if($_SESSION['username'] !== 'admin')
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>
 	<div class="container">
 		<?php include('menu.php'); ?>
		<form method="post" action="update.php">
          <input type="hidden" name="action" value="password"/>
	          <h1><small>Change Password</small></h1>
	          Old password: <input type="password" name="oldpass"/><br/>
	          New password: <input type="password" name="newpass"/><br/><br/>
	      <input class="btn" type="submit" name="submit" value="Change Password"/>
        </form>
        <hr/>
          
      <form method="post" action="update.php">
     	 <input type="hidden" name="action" value="email"/>
        	  <h1><small>Change Email</small></h1>
          <?php
          	$query = "SELECT email FROM users WHERE username='admin'";
          	$result = mysql_query($query);
          	$fields = mysql_fetch_array($result);
          ?>
          Email: <input type="email" name="email" value="<?php echo $fields['email'];?>"/><br/><br/>
          <input class="btn" type="submit" name="submit" value="Change Email"/>
      </form>
 	</div>

 <?php
	include('../footer.php');
?>