<?php
/*
 * The Event page that lists all the events categorised as Upcoming, Ongoing, Archived
 */
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>
<div class="container container-fluid">

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
				$query="SELECT * from events where slno=".$_GET['eid'];
				$result=mysql_query($query);
				$event=mysql_fetch_assoc($result);
				$query="SELECT * from problems where eventname='".$event['eventname']."'";
				$result=mysql_query($query);
				$today = date("Y-m-d H:i:s");
				$uptime=$event['uptime'];
				$downtime=$event['downtime'];
				echo '<h1 align="center"><small>'.$event['eventname'].'</small></h1><br>';
				echo '<p class="lead text-center"><small>The event starts on <strong>'.$event['uptime'].'</strong> and closes on <strong>'.$event['downtime']."</strong></small></p> <br>";
					if($uptime<=$today){	
						if($today > $downtime){
							echo '<p class="text-center"> This event is now archived, you can still view the problems but submissions are closed </p> <br/>';
						}	
						echo'<ul class="nav nav-list">
			        	<li class="nav-header">Problem List </li>';

			        	if(mysql_num_rows($result)==0)
					      echo("<li>No problems are tagged in this event</li>\n"); // no events are there
						else { 
							$i=1;
							while($row = mysql_fetch_array($result)) {
								$sql = "SELECT status FROM solve WHERE (username='".$_SESSION['username']."' AND probid='".$row['probid']."')";
								$res = mysql_query($sql);
								$tag = "";
								// decide the attempted or solve tag
								if(mysql_num_rows($res) !== 0) {
									$r = mysql_fetch_array($res);
									if($r['status'] == 1)
										$tag = " <span class=\"label label-warning\">Attempted</span>";
									else if($r['status'] == 2)
										$tag = " <span class=\"label label-success\">Solved</span>";
									else if($r['status'] == 0)
										$tag = " <span class=\"label label-info\">Queued for Correction</span>";
								}
								else $tag = " <span class=\"label label-important\">Unsolved</span>";
				       			echo("<li><a href=\"problem.php?eid=".$_GET['eid']."&pid=".$row['probid']."\">".$i." ) ".$row['heading']." ".$tag."</a></li>\n");
						       $i++;
						   }
						}

						echo '</ul> <br> <hr>';
					}
					else{
						echo "<p class='text-center'>This event is not yet live, you can check back this region later for its problems </p> <br/>"; 
					}

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
			      echo("<li>No upcoming events scheduled currently</li>\n"); // no events are there
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
			      echo("<li>No events are present in the archive</li>\n"); // no events are there
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