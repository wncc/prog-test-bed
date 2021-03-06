<?php
/*
 * The landing page that lists all the problem
 */
use \Michelf\Markdown;
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>
<div class="container">
	<?php
        if(isset($_GET['changed']))
          echo("<div class=\"alert alert-info\">\nAccount details changed successfully!\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>

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
		<div class="span7"> 
			<br/>
			<br/>
			<p align="center"> Following are the ongoing events. You can enter them to solve the problems: </p>
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
			<p align="center"> Following are the problems which are available to solve: </p>
			<ul class="nav nav-list">
        <li class="nav-header">AVAILABLE PROBLEMS</li>
        <?php
        	// list all the practice problems from the database
        	$query="SELECT `slno` from events where eventname='Open Problem Event'";
        	$result=mysql_query($query);
        	$id=mysql_result($result,0);

        	$query = "SELECT * FROM problems where eventname='Open Problem Event'";
          	$result = mysql_query($query);
          	if(mysql_num_rows($result)==0)
			      echo("<li>No problems available currently</li>\n"); // no problems are there
		else {  $i=1;
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
				}
				else $tag = " <span class=\"label label-warning\">Unsolved</span>";
				
          		echo("<li><a href=\"problem.php?eid=".$id."&pid=".$row['probid']."\">".$i." ) ".$row['heading']." ".$tag."</a></li>\n");
      			$i++;
      		}
		}
	?>
      </ul>
      <br/>
		</div>
		<div class="span3">
			<h2 align="center"><small>Upcoming Events </small></h2>
			<?php
						$today = date("Y-m-d H:i:s");
						$query="SELECT `eventname` , `uptime` from events where uptime > '".$today."'";
						$result = mysql_query($query);
						if(mysql_num_rows($result)==0)
		          	    	echo("<p>No Upcoming events scheduled currently </p>\n");
		          	  	else {
							echo '<table id="upcominglist" class="table table-hover">
								<thead><tr> <th>Event Name</th> <th> Uptime </th> </tr></thead>
								<tbody>';
									
							while($row = mysql_fetch_array($result)) {
								echo "<tr><td>".$row['eventname']."</td><td>".$row['uptime']."</td></tr>";
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
include('footer.php');
?>