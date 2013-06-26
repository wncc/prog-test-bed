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
		include('header.php');
		connectdb();
?>

<div class="container">
		<?php include('menu.php'); ?>
		<div class="row-fluid span12">
			<ul class="nav nav-tabs">
			    <li><a href="problems.php">Problem List</a></li>
			    <li class="active"><a href="#">Add Problem</a></li>
			    <li><a href="addtest.php">Add Testcases</a></li>
	      	</ul>
    	</div>
    	<div class="row-fluid span12">
    		 <form method="post" action="update.php">
         		 <input type="hidden" name="action" value="editproblem" id="action"/>
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
          	<div id="preview"></div>
    	</div>
</div>

<?php include('footer.php') ?>