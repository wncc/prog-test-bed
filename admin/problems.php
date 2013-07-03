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
                          <th>Languages</th>
                        </tr>
                        </thead>
                        <tbody>');
                    while($row = mysql_fetch_array($result)) {
                      echo '<tr><td>'.$row['probid'].'</td><td>'.$row['heading'].'</td><td>'.$row['eventname'].'</td><td>';
                      $query2="SELECT `c`,`cpp`,`java`,`python` from problempref where probid=".$row['probid'];
                      $result2 = mysql_query($query2) or die(mysql_error());
                      while ($id=mysql_fetch_array($result2)){ 
                      if($id['c']==1) echo " c ";
                      if($id['cpp']==1) echo " cpp ";
                      if($id['java']==1) echo " java ";
                      if($id['python']==1) echo " python ";
                    }
                      echo "</td>";
                    }
                echo'</tbody>
                    </table>';
                }
                  
             
      ?>
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
<script>
    $('#problemlist').find('tr').click( function(){
  var row = $(this).find('td:first').text();
  window.location.href = "addproblem.php?edit=1&pid="+row;
});
</script>
</body>
</html>