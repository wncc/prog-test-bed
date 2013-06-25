<?php
/*
 * Event List Page
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
			    <li class="active"><a href="#">Events List</a></li>
			    <li><a href="createevent.php">Create Event</a></li>
			    <li><a href="updateevent.php">Update Existing Event</a></li>
	      	</ul>
	      	<div class="span12">
	      		<p text-align="center"> The following are the upcoming events:</p>
	      	</div>
	    </div>
    </div>

<?php include('footer.php') ?>


