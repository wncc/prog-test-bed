<?php
/*
 * The scorecard of the user
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
			<?php 
			echo "<h1 align='center'><small>Scorecard</small></h1> <br/>";
			$sql = "SELECT * FROM solve WHERE  (username='".$_SESSION['username']."'AND status=2 )";
			$res = mysql_query($sql);
			if(mysql_num_rows($res) !== 0) {
				echo('<table class="table table-hover">
				       	 	  	<thead>
				                <tr>
				                  <th>Problem Name</th>
				                  <th>Score</th>
				                  <th>Time</th>
				                  <th>Language</th>
				                </tr>
				              	</thead>
				              	<tbody>');
				while($r = mysql_fetch_array($res)){
					$probid=$r['probid'];
					$query="SELECT * from problems where probid=".$probid;
					$result=mysql_query($query);
					$name=mysql_fetch_array($result);
					$heading=$name['heading'];
					echo "<tr><td>".$heading."</td><td>".$r['score']."</td><td>".$r['time']."</td><td>".$r['lang']."</tr>";
				}
				echo"</tbody></table>";
			}
			else{
				echo "<p> There are no successful attempts recorded yet for this user. Try more problems to get your scorecard ticking! <br></p>";
				$sql = "SELECT * FROM solve WHERE  (username='".$_SESSION['username']."'AND status=1 )";
				$res = mysql_query($sql);
				if(mysql_num_rows($res) !== 0) {
				echo "<p> Below is a list of problems you attempted recently but couldn't solve them: </p>";
				echo "<ul class='nav nav-list'>";
					while($row=mysql_fetch_array($res)){
						$probid=$row['probid'];
						$query="SELECT * from problems where probid=".$probid;
						$result=mysql_query($query);
						$name=mysql_fetch_array($result);
						$ename=$name['eventname'];
						$query="SELECT slno from events where eventname='".$ename."'";
						$result=mysql_query($query);
						$eid=mysql_fetch_array($result);
						$eventid=$eid['slno'];
						echo "<li><a href=\"problem.php?eid=".$eventid."&pid=".$probid."\">".$name['heading']."</a></li>";
					}
					echo"</ul>	";
				}
				else{
					echo "Hey there! <br>You seem to haven't attempted a single question yet. Check out the tutorials or our sample problem to get a start. Hope to see you shining on the leaderboard soon! </p>";
				}
			} 

			?>
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
