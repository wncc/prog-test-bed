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
  <?php
      if(isset($_GET['test']))
          echo("<div class=\"alert alert-success span12\">\n Test Case Successfully added\n</div>");
        else  if(isset($_GET['edit']))
          echo("<div class=\"alert alert-success span12\">\n You are editing a problem \n</div>");
      else  if(isset($_GET['pid']))
          echo("<div class=\"alert alert-success span12\">\n Your Problem was added! You can update any entries if you wish and resubmit the data.\n Please head over and add testcases \n</div>");
      else if(isset($_GET['uperror']))
          echo("<div class=\"alert alert-success span12\">\n Error while uploading please try again!\n</div>");
       else if(isset($_GET['deleted']))
          echo("<div class=\"alert alert-error span12\">\n The problem is successfully deleted \n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-error span12\">\n You can delete an existing problem only. \n</div>");
      
      ?>
		<?php include('menu.php'); ?>
		<div class="row-fluid span12">
			<ul class="nav nav-tabs">
			    <li><a href="problems.php">Problem List</a></li>
			    <li class="active"><a href="#">Add Problem</a></li>
	      	</ul>
    	</div>
    	<div class="row-fluid span12">
    		 <h1><small><?php if (isset($_GET['pid'])){
               echo "Edit a problem";
             } else { echo "Add a problem";
             } ?></small></h1>
    		 <form method="post" id="addproblem" action="update.php">
         		 <input type="hidden" name="action" 
             <?php if (isset($_GET['pid'])){
               echo "value='editproblem'";
             }
              else{
                echo "value='addproblem'";
              }
             ?> id="action"/>
             <input type="hidden" name="ids" <?php if (isset($_GET['pid'])){
               echo "value='".$_GET['pid']."'";
             } ?>>
         		 <ul class="nav nav-tabs">
		            <li class="active"><a href="#tab1" data-toggle="tab">Problem Statement</a></li>
		            <li><a href="#tab2" data-toggle="tab">Test Cases</a></li>
		         </ul>
		         <div class="tab-content">
            	<div class="tab-pane active" id="tab1">
         		 Problem Title: <input class="span8" type="text" id="title" name="title" 
             <?php 
              if(isset($_GET['pid'])){
                $query="SELECT * from problems where probid=".$_GET['pid'];
                $result=mysql_query($query);
                $problemdata=mysql_fetch_assoc($result, 0);
                echo "value=\"".trim($problemdata['heading'])."\"";
              }
              ?>    
             required/><br/>
          		 Maximum Points: <input class="span2" type="text" id="points" name="points" 
               <?php 
              if(isset($_GET['pid'])){
                $query="SELECT * from problems where probid=".$_GET['pid'];
                $result=mysql_query($query);
                $problemdata=mysql_fetch_assoc($result, 0);
                echo "value=\"".$problemdata['points']."\"";
              }
              ?>
               required/><br/>
          		 <div class="controls">Time Limit: 
		            <div class="input-append">
		              <input class="span8" id="appendedInput" size="8" type="text" name="timelimit" 
  
                  <?php 
              if(isset($_GET['pid'])){
                $query="SELECT * from problems where probid=".$_GET['pid'];
                $result=mysql_query($query);
                $problemdata=mysql_fetch_assoc($result, 0);
                echo "value=\"".$problemdata['timelimit']."\"";
              }
              ?>
                  required><span class="add-on">ms</span>
		            </div>
		         </div><br/>
		         Tag it as an event problem: 
		         <div class="btn-group">
                    <a class="btn dropdown-toggle" id="eventlist" data-toggle="dropdown" href="#">
                    <?php 
              if(isset($_GET['pid'])){
                $query="SELECT * from problems where probid=".$_GET['pid'];
                $result=mysql_query($query);
                $problemdata=mysql_fetch_assoc($result, 0);
                echo $problemdata['eventname'];

            $query2 = "SELECT c, cpp, java, python FROM problempref where probid=".$_GET['pid'];
            $result2 = mysql_query($query2)or die(mysql_error());
            $fields = mysql_fetch_assoc($result2,0);

              }
              else{ echo "Select Event";
            $fields['c']=0;
            $fields['cpp']=0;
            $fields['java']=0;
            $fields['python']=0;
          }
              ?>
                    <span class="caret"></span>
                  </a>
                    <ul class="dropdown-menu eventlist">
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
                    echo("<li><a href=\"#\">".$row['eventname']."</a></li>\n");
                }
              }
            ?>
                    </ul>
                  </div><br/><br/>
                  <input name="eventname" type="hidden" id="formeventinput"/>
				<h1><small>Languages</small></h1>
			      <input name="c" type="checkbox" <?php if($fields['c']==1) echo("checked=\"true\"");?>/> C<br/>
					  <input name="cpp" type="checkbox" <?php if($fields['cpp']==1) echo("checked=\"true\"");?>/> C++<br/>
					  <input name="java" type="checkbox" <?php if($fields['java']==1) echo("checked=\"true\"");?>/> Java<br/>
					  <input name="python" type="checkbox" <?php if($fields['python']==1) echo("checked=\"true\"");?>/> Python<br/><br/>
				Detailed problem: <span class="label label-info">Markdown formatting supported</span></br/><br/>
				 <textarea style="width:785px; height:400px;" name="problem" id="text"
         required><?php
             if(isset($_GET['pid'])){
               $query="SELECT description from problems where probid=".$_GET['pid'] or die(mysql_error());
                $result=mysql_query($query) or die(mysql_errno());
                echo trim(mysql_result($result, 0));
  }
?></textarea><br/>
				 <div id="sample">
				 	Sample Input cum brief explanation:<br/>
				 	<textarea style="width:785px; height:100px;" name="samplei" id="samplei"><?php
             if(isset($_GET['pid'])){
               $query="SELECT input1 from problems where probid=".$_GET['pid'] or die(mysql_error());
                $result=mysql_query($query) or die(mysql_errno());
                echo trim(mysql_real_escape_string(mysql_result($result, 0)));
  }
?></textarea><br/>
				 	Sample Output cum brief explanation:<br/>
				 	<textarea style="width:785px; height:100px;" name="sampleo" id="sampleo"><?php
             if(isset($_GET['pid'])){
               $query="SELECT output1 from problems where probid=".$_GET['pid'] or die(mysql_error());
                $result=mysql_query($query) or die(mysql_errno());
                echo trim(mysql_result($result, 0));
  }
?></textarea><br/>
				 </div>
				 <input class="btn btn-primary btn-large" type="submit" value="<?php if(isset($_GET['pid'])){echo "Update Problem";} else echo "Save Problem"; ?>"/>
         		 <input class="btn btn-large" type="button" value="Preview" onclick="$('#preview').load('markdown-preview.php', {action: 'preview', title: $('#title').val(), text: $('#text').val()});"/>
         		</form> 
            <br/> <br/>
            <form method="post" action="update.php">
            <input type="hidden" name="id" <?php 
              if(isset($_GET['pid'])){
                echo "value=".$_GET['pid'];
              }
                ?>/>
              <input type="hidden" name="action" value="deleteproblem"/>
              <input class="btn btn-danger btn-large" type="submit" name="submit" value="Delete Problem"/>
            </form>
             
          	
				</div>
			<div class="tab-pane" id="tab2">
        <?php
        if(!isset($_GET['pid']))
          echo("<div class=\"alert alert-error span12\">\nPlease update the problem in previous tab before adding testcases!\n</div><br/>");
        ?>
            <?php
            if(!isset($_GET['pid'])){
              echo("<p>No testcases are added currently</p>\n");
            }
            else{  $query="SELECT * from testcases where probid='".$_GET['pid']."'";
              $result = mysql_query($query);

              if(mysql_num_rows($result)==0)
                  echo("<p>No testcases are added currently</p>\n");
                  else {
                    echo('<table id="eventlist" class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Test Input Size</th>
                          <th>Test Output Size</th>
                          <th>Judge Type</th>
                        </tr>
                        </thead>
                        <tbody>');
                    while($row = mysql_fetch_array($result)) {
                      echo '<tr><td>'.$row['caseid'].'</td><td>'.$row['input'].'</td><td>'.$row['output'].'</td><td>'.$row['judge'].'</td></tr>';

                    }
                echo ('</tbody>
                    </table>');
                  }
                }
            ?>
       	 	  <br>
       	 	  <br>
       	 	  <br>
       	 	  <form method="post" enctype="multipart/form-data" action="update.php">
            <input type="hidden" name="action" value="addtest" id="action"/>
            <input type="hidden" name="id" 
            <?php
        if(isset($_GET['id']))
          echo("value=".$_GET['id']);
      ?> />
       	 	  Test Case Input: &nbsp <input type="file" name="input"/><br/><br/>
       	 	  Test Case Output:&nbsp<input type="file" name="output"/><br/><br/>
       	 	      <div class="btn-group" id="dropevent">
				    <a class="btn dropdown-toggle" id="judgelist" data-toggle="dropdown" href="#">
				    Judge Type
				    <span class="caret"></span>
				    </a>
				    <ul class="dropdown-menu judge">
				    <!-- dropdown menu links -->
				  <li><a href="#">Strict</a></li>
          <li><a href="#">Neglect Whitespace</a></li>
          <li><a href="#">Floating point 10^-6</a></li>
            </ul>      
				  </div>
				  <br/><br/>
          <input type="hidden" name="pid" <?php if (isset($_GET['pid'])){
               echo "value='".$_GET['pid']."'";
             } ?>>
          <input name="judgename" type="hidden" id="formjudgeinput"/>
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
  </div>
    <!-- javascript files
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
     
    <script type="text/javascript">
            $(function(){

            $(".eventlist li a").click(function(){

              $("#eventlist").html($(this).text()+"&nbsp<span class='caret'></span>");
              $("#formeventinput").val($(this).text());


           });

            $(".judge li a").click(function(){

              $("#judgelist").html($(this).text()+"&nbsp<span class='caret'></span>");
              $("#formjudgeinput").val($(this).text());


           });

        $("#addproblem").submit(function(){
    var checked = $("#addproblem input:checked").length > 0;
    if (!checked){
        alert("Please select atleast one Programming Language");
        return false;
    }
});

      }); </script>
</body>
</html>
