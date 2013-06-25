<?php
/*
 * Create Event Page
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
		<?php include('menu.php'); ?>
		<div class="row-fluid span12">
			<ul class="nav nav-tabs">
			    <li><a href="event.php">Events List</a></li>
			    <li class="active"><a href="#">Create Event</a></li>
			    <li><a href="updateevent.php">Update Existing Event</a></li>
	      	</ul>
	      	<div class="span12">
	      		<form method="post" action="update.php">
	      			<input type="hidden" name="action" value="settings"/>Name of event: 
	      			<input name="name" type="text"/><br/>
	      			<input type="hidden" name="action" value="settings"/>Date and time of event:
	      			<div id="datetimepicker" class="input-append date">
				      <input type="text" ></input>
				      <span class="add-on">
				        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				      </span>
				    </div>
		          <h1><small>Languages</small></h1>
			          <input name="c" type="checkbox" /> C<br/>
					  <input name="cpp" type="checkbox" /> C++<br/>
					  <input name="java" type="checkbox" /> Java<br/>
					  <input name="python" type="checkbox"/> Python<br/><br/>
				    <input class="btn" type="submit" name="submit" value="Save Settings"/>
	      		</form>
	      		<p text-align="center"> You can add problems from the add problem category and tag it for this particular event</p>
	      	</div>
	    </div>
    </div>
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
      $('#datetimepicker').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
      });
    </script>
  </body>
  </html>


