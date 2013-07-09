<?php
/*
 * Solution submission page
 */
	use \Michelf\Markdown;
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		connectdb();
?>
<?php
/*
 * Header for user pages
 */
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>WnCC Prog Test Bed </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="css/codemirror.css" rel="stylesheet">
    <style type="text/css">
      .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}
      .CodeMirror-activeline-background {background: #e8f2ff !important;}
    </style>
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
            <img src="img/logo.png" width="88" height="100" class="img-polaroid">
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

<div class="container container-fluid">

<?php
include('menu.php');
?>
	<div class="row-fluid" id="main-content">
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

					echo "<h1 align='center'><small>".$time['eventname']."</small></h1><hr/> <br/>";
					echo "<div class=\"span5\" id=\"problem\">";
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
                    echo "</div>";
                    echo "<div id=\"codezone\" class=\"span6\">";
                    echo "<h2><small>Coding Zone </small></h2>";
                    echo'<button class="btn btn-info" id="toggles">Toggle Problem </button><br/><br/>';
                    
                    echo '<div class="btn-group">
                    <a class="btn dropdown-toggle" id="langlist" data-toggle="dropdown" href="#">Select Language
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu langlist">
                    <li><a href="#">C</a></li>
                    <li><a href="#">C++</a></li>
                    <li><a href="#">Java</a></li>
                    <li><a href="#">Python</a></li> </ul></div><br/>';
                    
                    echo '<form><br/> <br/>
                    <input name="language" type="hidden" id="formlanginput"/><textarea id="code" name="code">
            		/*Enter your code here.
If you are using python make sure you comment these lines using "#" */</textarea></form>';
                    echo "</div>";
                }
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
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/codemirror.js"></script>
    <script>
    $(document).ready(function(){
    $('#toggles').on('click',function(event){
      	if($('#problem').css('display') == 'none'){
      		$('#codezone').removeClass('span12');
      		$('#codezone').addClass('span6');
      		$('#problem').show();
      	}
      	else{
      		$('#problem').hide();
      		$('#codezone').removeClass('span6');
      		$('#codezone').addClass('span12');
      		

      	}

      });

      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        styleActiveLine: true,
        mode: "text/x-csrc"
      });


      editor.on("change", function() {
      clearTimeout(pending);
      setTimeout(update, 400);
    });
    var pending;
    function update(){
              if($("#formlanginput").val()=="C"){
                editor.setOption("mode", "text/x-csrc");
              }
              else if($("#formlanginput").val()=="C++"){
               editor.setOption("mode", "text/x-c++src"); 
              }
              else if($("#formlanginput").val()=="Java"){
               editor.setOption("mode", "text/x-java"); 
              }
              else if($("#formlanginput").val()=="Python"){
               editor.setOption("mode", "text/x-python"); 
              }
              else{
                editor.setOption("mode", "text/html"); 
              }
    }
      $(".langlist li a").click(function(){

              $("#langlist").html($(this).text()+"&nbsp<span class='caret'></span>");
              $("#formlanginput").val($(this).text());

              
              


           });
  });
      
    </script>
</body></html>