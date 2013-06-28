<?php
/*
 * Update Event Page
 */
	require_once('../functions.php');
	if(!loggedin())
		header("Location: login.php");
	else if($_SESSION['username'] !== 'admin')
		header("Location: login.php");

	connectdb();
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>WnCC Admin Panel </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- styles -->
    <link href="../css/common.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
  
<!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="container-fluid">
        <header class="row-fluid">
          
          <div class="span2">
            <img src="../img/logo.png" width="88" height="100" class="img-polaroid">
          </div>
          
          <div class="span10">
              <div class="row-fluid">
                <div class="span10">
                  <h3 align="center">Programming Test Bed</h3>
                </div>
                <div class="span2">
                    <a class="btn btn-info" href="http://wncc-iitb.org" role="button">WnCC Home</a>
                </div>
              </div>
        </div>  
      </div> 

	<div class="container">
    <?php
        if(isset($_GET['id']))
          echo("<div class=\"alert alert-success span12\">\n You are updating an event\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error span12\">\nPlease enter all the details asked before you can continue!\n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-error span12\">\nYou cannot delete unexisting event\n</div>");

      ?>
		<?php include('menu.php'); ?>

		<div class="row-fluid span12">
			<ul class="nav nav-tabs">
			    <li><a href="event.php">Events List</a></li>
			    <li ><a href="createevent.php">Create Event</a></li>
			    <li class="active"><a href="#">Update Existing Event</a></li>
	      	</ul>
	      	<div class="span12">
	      		<form method="post" action="update.php">
                  <div class="btn-group">
                    <button class="btn" id="dropevent" /></button>
                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                    <!-- dropdown menu links -->
                    <?php
                // list all the problems
                $query = "SELECT * FROM events";
              $result = mysql_query($query);
              if(mysql_num_rows($result)==0)
                echo("<li>None</li>\n");
              else {
                while($row = mysql_fetch_array($result)) {
                  if(isset($_GET['id']) and $_GET['id']==$row['slno']) {
                    $selected = $row;
                    echo("<li class=\"active\"><a href=\"updateevent.php?id=".$_GET['id']."\">".$row['eventname']."</a></li>\n");
                  } else
                    echo("<li><a href=\"updateevent.php?id=".$row['slno']."\">".$row['eventname']."</a></li>\n");
                }
              }
            ?>
                    </ul>
                  </div>
                  <br/>
                  <br/>
	      			<input type="hidden" name="action" value="updateevent"/>
              <input type="hidden" name="id" <?php 
              if(isset($_GET['id'])){
                echo "value=".$_GET['id'];
              }
                ?>/>Name of event: 
	      			<input name="name" type="text" <?php 
              if(isset($_GET['id'])){
                $query="SELECT eventname from events where slno=".$_GET['id'];
                $result = mysql_query($query);
                echo "value='".mysql_result($result, 0)."'";
              }
                ?>/><br/>
	      			<input type="hidden"/>Uptime of event:
	      			<div id="uptimepicker" class="input-append date">
				      <input type="text"  name="uptime" <?php 
              if(isset($_GET['id'])){
                $query="SELECT uptime from events where slno=".$_GET['id'];
                $result = mysql_query($query);
                echo "value='".mysql_result($result, 0)."'";
              }
                ?>/>></input>
				      <span class="add-on">
				        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				      </span>
				    </div>
            <input type="hidden"/>Downtime of event:
              <div id="downtimepicker" class="input-append date">
              <input type="text"  name="downtime"<?php 
              if(isset($_GET['id'])){
                $query="SELECT downtime from events where slno=".$_GET['id'];
                $result = mysql_query($query);
                echo "value='".mysql_result($result, 0)."'";
              }
                ?>/>></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
            <p>(Time is configured as hh:mm:ss)</p>
				    <input class="btn btn-success" type="submit" name="submit" value="Update Event"/>
	      		</form>
            <form method="post" action="update.php">
              <input type="hidden" name="id" <?php 
              if(isset($_GET['id'])){
                echo "value=".$_GET['id'];
              }
                ?>/>
              <input type="hidden" name="action" value="deleteevent"/>
              <input class="btn btn-danger" type="submit" name="submit" value="Delete Event"/>
            </form>
	      	</div>
	    </div>
    </div>
  </div>
    <div id="push"></div>
   </div>
   <div id="footer">
      <div class="container">
        <p class="muted credit">Built with love by <a href="about.php">WnCC.</p>
      </div>
    </div>
   	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript"src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
      $('#uptimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
      });
      $('#downtimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
      });
    </script>
    <?php 
              if(isset($_GET['id'])){
                $query="SELECT eventname from events where slno=".$_GET['id'];
                $result = mysql_query($query);
              echo '<script type="text/javascript">
                $("#dropevent").html("'.mysql_result($result, 0).'");</script>';
              }
              else{
                echo '<script type="text/javascript">
                $("#dropevent").html("Choose Event");</script>';
              }
                ?>
  </body>
  </html>


