<?php
/*
 * The landing page that lists all the problem
 */
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>
<div class="container containeer-fluid">

<?php
include('menu.php');
?>
	<div class="row-fluid" id="main-content">
		<div class ="span2"> 
			<div class="btn-group btn-group-vertical">
				<button class="btn input-block-level" type="button">Tutorial Links</button>
				<button class="btn input-block-level" type="button">Discussion Forum</button>
				<button class="btn input-block-level" type="button">Interesting Reads</button>
				<button class="btn input-block-level" type="button">Read Blog</button>
				
				
		    </div>
		</div>
		<div class="span8"> 
			<?php
			if(isset($_GET['eid'])) {
				$query="SELECT `eventname` from events where slno=".$_GET['eid'];
				$result=mysql_query($query);
				$name=mysql_result($result, 0);
				$query="SELECT * from problems where eventname='".$name."'";
				$result=mysql_query($query);
				echo '<h1 align="center"><small>'.$name.'</small></h1><br>';
				echo'<ul class="nav nav-list">
	        	<li class="nav-header">Problem List </li>';

	        	if(mysql_num_rows($result)==0)
			      echo("<li>No problems are tagged in this event</li>\n"); // no events are there
				else { 
					$i=1;
					while($row = mysql_fetch_array($result)) {

		       			echo("<li><a href=\"problem.php?eid=".$_GET['eid']."&pid=".$row['probid']."\">".$i." ) ".$row['heading']."</a></li>\n");
				       $i++;
				   }
				}

				echo '</ul> <br> <hr>';

			}
			?>

			<p align="center"> Following is the list of all the events: </p>
			<ul class="nav nav-list">
        	<li class="nav-header">ONGOING EVENTS</li>
			<?php
        	// list all the ongoing events from the database
        	$today = date("Y-m-d H:i:s");
        	$query = "SELECT * FROM events where (downtime >='".$today."' AND uptime <='".$today."'  )";
          	$result = mysql_query($query);
          	if(mysql_num_rows($result)==0)
			      echo("<li>No events are ongoing currently</li>\n"); // no events are there
		else { 
			$i=1;
			while($row = mysql_fetch_array($result)) {

       			echo("<li><a href=\"event.php?eid=".$row['slno']."\">".$i." ) ".$row['eventname']."</a></li>\n");
		       $i++;
		   }
		}
		?>
      	</ul>
      	<br/>
      	<hr>
      	<ul class="nav nav-list">
        	<li class="nav-header">UPCOMING EVENTS</li>
        	<?php

        	$query = "SELECT * FROM events where uptime >'".$today."'";
          	$result = mysql_query($query);
          	if(mysql_num_rows($result)==0)
			      echo("<li>No events are ongoing currently</li>\n"); // no events are there
		else { 
			$i=1;
			while($row = mysql_fetch_array($result)) {

       			echo("<li><a href=\"event.php?eid=".$row['slno']."\">".$i." ) ".$row['eventname']."</a></li>\n");
		       $i++;
		   }
		}

        	?>
        </ul>
        <br/>
      	<hr>
        <ul class="nav nav-list">
        	<li class="nav-header">PAST EVENTS</li>
        	<?php

        	$query = "SELECT * FROM events where downtime < '".$today."'";
          	$result = mysql_query($query);
          	if(mysql_num_rows($result)==0)
			      echo("<li>No events are ongoing currently</li>\n"); // no events are there
		else { 
			$i=1;
			while($row = mysql_fetch_array($result)) {

       			echo("<li><a href=\"event.php?eid=".$row['slno']."\">".$i." ) ".$row['eventname']."</a></li>\n");
		       $i++;
		   }
		}

        	?>
        </ul>
        <br>
        <br>
        
		</div>
		<div class ="span2"> </div>
		</div>
</div>
<?php
include('footer.php');
?>