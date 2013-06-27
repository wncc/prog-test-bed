<?php
/*
 * Add Problem
 */
namespace Michelf;
	require_once('../functions.php');
	if(!loggedin())
		header("Location: login.php");
	else if($_SESSION['username'] !== 'admin')
		header("Location: login.php");
	else
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/common.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

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

      <!-- Begin page content -->
<div class="container">
		<?php include('menu.php'); ?>
		<div class="row-fluid span12">
			<ul class="nav nav-tabs">
			    <li><a href="problems.php">Problem List</a></li>
			    <li class="active"><a href="#">Add Problem</a></li>
	      	</ul>
    	</div>
    	<div class="row-fluid span12">
    		 <h1><small>Edit a Problem</small></h1>
    		 <form method="post" action="update.php">
         		 <input type="hidden" name="action" value="editproblem" id="action"/>
         		 <input type="hidden" name="id" id="id" value=""/>
         		 <ul class="nav nav-tabs">
		            <li class="active"><a href="#tab1" data-toggle="tab">Problem Statement</a></li>
		            <li><a href="#tab2" data-toggle="tab">Test Cases</a></li>
		         </ul>
		         <div class="tab-content">
            	<div class="tab-pane active" id="tab1">
         		 Problem Title: <input class="span8" type="text" id="title" name="title" value=""/><br/>
          		 Maximum Points: <input class="span2" type="text" id="points" name="points" value=""/><br/>
          		 <div class="controls">Time Limit: 
		            <div class="input-append">
		              <input class="span8" id="appendedInput" size="8" type="text" name="time" value=""><span class="add-on">ms</span>
		            </div>
		         </div><br/>
		         Tag it as an event problem: 
		         <div class="btn-group">
				  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    Select Event
				    <span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu">
				    <!-- dropdown menu links -->
				  </ul>
				</div> <br/><br/>
				<h1><small>Languages</small></h1>
			          <input name="c" type="checkbox" /> C<br/>
					  <input name="cpp" type="checkbox" /> C++<br/>
					  <input name="java" type="checkbox" /> Java<br/>
					  <input name="python" type="checkbox"/> Python<br/><br/>
				Detailed problem: <span class="label label-info">Markdown formatting supported</span></br/><br/>
				 <textarea style="width:785px; height:400px;" name="problem" id="text"></textarea><br/>
				 <div id="sample">
				 	Sample Input cum brief explanation:<br/>
				 	<textarea style="width:785px; height:100px;" name="problem" id="samplei"></textarea><br/>
				 	Sample Output cum brief explanation:<br/>
				 	<textarea style="width:785px; height:100px;" name="problem" id="sampleo"></textarea><br/>
				 </div>
				 <input class="btn btn-primary btn-large" type="submit" value="Update Problem"/>
         		 <input class="btn btn-large" type="button" value="Preview" onclick="$('#preview').load('markdown-preview.php', {action: 'preview', title: $('#title').val(), text: $('#text').val()});"/>
         		 <input class="btn btn-danger btn-large" type="button" value="Delete Problem" onclick="window.location='update.php?action=delete&id='+$('#id').val();"/>
          	</form>
				</div>
			
			<div class="tab-pane" id="tab2">
       	 	  <table class="table table-hover">
       	 	  	<thead>
                <tr>
                  <th>#</th>
                  <th>Test Input</th>
                  <th>Test Output</th>
                  <th>Judge Type</th>
                </tr>
              </thead>
       	 	  </table>
       	 	  <br>
       	 	  <br>
       	 	  <br>
       	 	  <form method="post" action="update.php">
       	 	  Test Case Input: &nbsp<input type="file"/><br/><br/>
       	 	  Test Case Output:&nbsp<input type="file"/><br/><br/>
       	 	      <div class="btn-group">
				    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    Judge Type
				    <span class="caret"></span>
				    </a>
				    <ul class="dropdown-menu">
				    <!-- dropdown menu links -->
				  <li><a href="#">Strict</a></li>
                  <li><a href="#">Neglect Whitespace</a></li>
                  <li><a href="#">Floating point 10^-6</a></li>
                  
				  </div>
				  <br><br/>
				  <input class="btn btn-primary" type="submit" value="Update Test Cases"/>
			  </form>
       	 	  <br/>
       	 	  <br/>
       	 	  <br/>
       	 	  <br/>
           </div>
				 
          	<div id="preview"></div>
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
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
</body>
</html>