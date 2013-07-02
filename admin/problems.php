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
      	<?php
      	$query="SELECT * from problems";
              $result = mysql_query($query);

              if(mysql_num_rows($result)==0)
                  echo("<p>No problems are added currently</p>\n");
                  else {
                    echo('<table id="problemlist" class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Problem Desc.</th>
                          <th>Event Associated</th>
                        </tr>
                        </thead>
                        <tbody>');
                    while($row = mysql_fetch_array($result)) {
                      echo '<tr><td>'.$row['probid'].'</td><td>'.$row['heading'].'</td><td>'.$row['eventname'].'</td></tr>';

                    }
                echo'</tbody>
                    </table>';
                }
                  
             
      ?>
    </div>
</div>

<?php include('footer.php') ?>