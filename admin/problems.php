<?php
/*
 * Problem Settings
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
		<div class="row-fluid span12">
			<ul class="nav nav-tabs">
			    <li class="active"><a href="#">Problem List</a></li>
			    <li><a href="addproblem.php">Add Problem</a></li>
	      	</ul>
      	<div class="span12">
      		<p text-align="center"> The following are the problems added:</p>
      	</div>
    </div>
</div>

<?php include('footer.php') ?>