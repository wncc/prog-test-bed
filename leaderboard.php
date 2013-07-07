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
				echo "<h1 align='center'><small>Leaderboard</small></h1> <br/>";
				$sql = "SELECT username,score FROM users WHERE username!='admin' ORDER BY score DESC";
				$res = mysql_query($sql);
				if(mysql_num_rows($res)==0)
		          	    	echo("<p>No Users are currently registered </p>\n");
          	  	else {
					echo '<table class="table table-hover">
						<thead><tr> <th>#</th> <th> Username </th> <th>Score </th></tr></thead>
						<tbody>';
					$i=1;		
					while($row = mysql_fetch_array($res)) {
						echo "<tr><td>".$i."</td><td>".$row['username']."</td><td>".$row['score']."</tr>";
						$i++;
					}
					echo "</tbody></table>";
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
