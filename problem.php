<?php
/*
 * The problem page lists all problems meant for practice.
 */
use \Michelf\Markdown;
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

			if(isset($_GET['eid']) && isset($_GET['pid'])){
				$query="SELECT eventname,uptime,downtime from events where slno=".$_GET['eid'];
				$result=mysql_query($query);
				$time=mysql_fetch_array($result);
				$today = date("Y-m-d H:i:s");
				if($time['uptime']<= $today){
					
					include('markdown.php');
					$query="SELECT * from problems where probid=".$_GET['pid'];
					$result=mysql_query($query) or die(mysql_error());
					$row=mysql_fetch_assoc($result);


					$sql = "SELECT status FROM solve WHERE (username='".$_SESSION['username']."' AND probid='".$_GET['pid']."')";
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

						echo "<h1 align='center'><small>".$time['eventname']."</small></h1><hr/>";
						echo("<h2><small>".$row['heading']." ".$tag."</small></h2>");
						$des = Markdown::defaultTransform($row['description']);
						$in = Markdown::defaultTransform($row['input1']);
						$out = Markdown::defaultTransform($row['output1']);
						echo("<h3><small>Problem Description </small></h3>");
						echo($des."<h3><small>Sample Input</small> </h3>");
						echo($in."<h3> <small>Sample Output </small></h3> ");
						echo($out."<br/><h4><small>Maximum Time Limit </small></h4>".$row['timelimit']." ms <br/> <h4><small>Maximum Points </small></h4>".$row['points']." <br/> <h4> <small> Languages Supported </small></h4>");
					  $query2="SELECT `c`,`cpp`,`java`,`python` from problempref where probid=".$row['probid'];
                      $result2 = mysql_query($query2) or die(mysql_error());
                      while ($id=mysql_fetch_array($result2)){ 
                      if($id['c']==1) echo " c ";
                      if($id['cpp']==1) echo " cpp ";
                      if($id['java']==1) echo " java ";
                      if($id['python']==1) echo " python ";
                      echo "<br/> <br/>";
                    }
						echo'<form action="solve.php" method="get">
				    	<input type="hidden" name="pid" value="'.$_GET['pid'].'"/>
				    	<input type="hidden" name="eid" value="'.$_GET['eid'].'"/>
				    	';
				      
				        $query = "SELECT * FROM solve WHERE(status=2 AND probid='".$_GET['pid']."')";
				        $result = mysql_query($query);
				        $solve = mysql_num_rows($result);
				        $query = "SELECT * FROM solve WHERE(status=1 AND probid='".$_GET['pid']."')";
				        $result = mysql_query($query);
				        $attempt = mysql_num_rows($result);
				      echo'<input class="btn btn-primary " type="submit" value="Solve"/> <span class="badge badge-info">'.$solve.'</span> have solved the problem and <span class="badge badge-info">'.$attempt.'</span> have attempted the problem.
				      </form>';
					
				}
				else{
					echo "<h1 align='center'><small>".$time['eventname']." </small></h1><hr/>";
					echo "This problem is currently not available for viewing.";
				}
			     
			
			echo'<br/>
			<hr/>
			<p> Following are the other problems from this event:</p>
			<ul class="nav nav-list">';
			
			$query="SELECT * from problems where (eventname='".$time['eventname']."' AND probid!='".$_GET['pid']."')";
			$result = mysql_query($query);

          	if(mysql_num_rows($result)==0)
			      echo("<li>No other prolems are present in this event</li>\n"); // no events are there
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
					}
					else $tag = " <span class=\"label label-warning\">Unsolved</span>";

	       			echo("<li><a href=\"problem.php?eid=".$_GET['eid']."&pid=".$row['probid']."\">".$i." ) ".$row['heading']." ".$tag."</a></li>\n");
			       $i++;
			   }
			}

		
		echo'</ul>
		<br>';
		}
		else{
			echo "<p>The following are some practice problems.</p><p><small>{Event specific problems can be found in the events tab}</small></p>";
			
        	// list all the problems from the database
        	$query="SELECT `slno` from events where eventname='Open Problem Event'";
        	$result=mysql_query($query);
        	$id=mysql_result($result,0);
        	$query = "SELECT * FROM problems where eventname='Open Problem Event'";
          	$result = mysql_query($query);
          	echo '<ul class="nav nav-list">';
          	if(mysql_num_rows($result)==0)
			      echo("<li>None</li>\n"); // no problems are there
		else {
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
         	echo("<li><a href=\"problem.php?eid=".$id."&pid=".$row['probid']."\">".$row['heading']." ".$tag."</a></li>\n");
          }

      }
      echo "</ul>";
	}
	 ?>	
	 	<br/>
		</div>
		<div class="span2"> 
		</div>
		</div>
</div>
<?php
include('footer.php');
?>