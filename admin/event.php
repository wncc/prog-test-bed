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
		
		<?php
        if(isset($_GET['created']))
          echo("<div class=\"alert alert-success span12\">\n New Event Created!\n</div>");
      else if(isset($_GET['updated']))
          echo("<div class=\"alert alert-success span12\">\n Event Updated!\n</div>");
      else if(isset($_GET['deleted']))
          echo("<div class=\"alert alert-error span12\">\n An event is deleted \n</div>");
        else if(isset($_GET['passerror']))
          echo("<div class=\"alert alert-error span12\">\nThe old password is incorrect!\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error span12\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>
      <?php include('menu.php'); ?>
		<div class="row-fluid span12">
			<ul class="nav nav-tabs">
			    <li class="active"><a href="#">Events List</a></li>
			    <li><a href="createevent.php">Create Event</a></li>
			    <li><a href="updateevent.php">Update Existing Event</a></li>
	      	</ul>
	      	<div class="span12">
	      		<p text-align="center"> The following are the upcoming events:</p>
	      		<?php
		      		$query="SELECT * from events";
		      		$result = mysql_query($query);

		      		if(mysql_num_rows($result)==0)
	          	    echo("<p>No events are added currently</p>\n");
	          	  	else {
	          	  		echo('<table id="eventlist" class="table table-hover">
				       	 	  	<thead>
				                <tr>
				                  <th>#</th>
				                  <th>Event Name</th>
				                  <th>Event Uptime</th>
				                  <th>Event Downtime</th>
				                </tr>
				              	</thead>
				              	<tbody>');
	          	  		while($row = mysql_fetch_array($result)) {
	          	  			echo '<tr><td>'.$row['slno'].'</td><td>'.$row['eventname'].'</td><td>'.$row['uptime'].'</td><td>'.$row['downtime'].'</td></tr>';

	          	  		}
				        echo ('</tbody>
				       	 	  </table>');
	          	  	}
	      		?>
	      	</div>
	    </div>
    </div>

<div id="push"></div>
    </div> <!-- /wrap -->
    <div id="footer">
      <div class="container">
        <p class="muted credit">Built with love by <a href="about.php">WnCC.</p>
      </div>
    </div>

    <!-- javascript files
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script>
    $('#eventlist').find('tr').click( function(){
  var row = $(this).find('td:first').text();
  window.location.href = "updateevent.php?id="+row;
});
</script>
</body>
</html>


