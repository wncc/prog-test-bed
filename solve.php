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
    <link href="css/bootstrap-fileupload.min.css" rel="stylesheet">
    <style type="text/css">
      .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}
      .CodeMirror-activeline-background {background: #e8f2ff !important;}
      .CodeMirror-fullscreen {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        height: auto;
        z-index: 9;
      }

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
      if(isset($_GET['success']))
          echo("<div class=\"alert alert-success span12\">\n Your problem has been successfully added to compiler queue\n</div>");
        else  if(isset($_GET['edit']))
          echo("<div class=\"alert alert-success span12\">\n You are editing a problem \n</div>");
      else if(isset($_GET['uperror']))
          echo("<div class=\"alert alert-success span12\">\n Error while uploading please try again!\n</div>");
       else if(isset($_GET['ferror']))
          echo("<div class=\"alert alert-error span12\">\n Error Uploading file. Please try again \n</div>");
        else if(isset($_GET['serror']))
          echo("<div class=\"alert alert-error span12\">\n Your code should be less than 1 MB \n</div>");
      
?>
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
                    
                    echo '<form method="post" id="submitcode" enctype="multipart/form-data" action="update.php"><br/> <br/>
                    <input name="lang" type="hidden" id="formlanginput">
                    <input name="probid" type="hidden" value="'.$_GET['pid'].'"/>
                    <input name="eventid" type="hidden" value="'.$_GET['eid'].'"/>
                    <input type="hidden" name="action" value="addsolution" id="action"/><h3><small>Write code or upload a file</small></h3><p>While uploading file make sure you choose a language, to avoid discrepancies</p>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
  <div class="input-append">
    <div class="uneditable-input span3">
    <i class="icon-file fileupload-exists"></i> 
    <span class="fileupload-preview"></span>
    </div>
    <span class="btn btn-file">
    <span class="fileupload-new">Select file</span>
    <span class="fileupload-exists">Change</span>
    <input type="file" id="uploadsoln" name="solution" />
    </span>
    <a href="#" id="remove" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
  </div>
</div><textarea id="code" name="code">
            		/*Enter your code here.
While using python make sure you comment these lines using "#" 
You can aswell upload a file for your submission 

Use F11 to enter fullscreen editing mode! 
(Make sure the cursor is in present in the editing zone
 else you will enter browser fullscreen mode)
Use F11 again to toggle fullscreen editing mode
*/</textarea> <br/>
</form>
<input class="btn btn-primary" type="button" value="Update Solution" onclick="submit()"/>

';
                    echo "<p><small><strong>Note:</strong>&nbsp; On submitting a file as well as an edited code, by default submissions of only the file will be considered and not the edited code <br> So make sure you submit the appropriate code only.</small></p></div>";
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
    <script src="js/bootstrap-fileupload.min.js"></script>
    <script src="js/fullscreen.js"></script>
    <script src="js/xml.js"></script>
    <script>

    function submit(){
      var lang=$("#formlanginput").val();

      if (lang == "C" || lang == "C++" || lang =="Java" || lang =="Python"){
        document.getElementById("submitcode").submit();
        
      }
      else{
        alert("Please select a language");
       
      }
    };
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
         mode: "text/x-csrc",
        extraKeys: {
        "F11": function(cm) {
          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        },
        "Esc": function(cm) {
          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        }
      }
       
      });

      

      editor.on("change", function(cm) {
      clearTimeout(pending);
      setTimeout(update, 400);
      document.getElementById("code").value=cm.getValue();
      
      
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

      $('#uploadsoln').change(function(){// above check
        
        var ext = $('#uploadsoln').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['cpp','c','java','py','']) == -1) {
            $('#remove').click();
            alert('invalid extension!');
        }
      });

      
  


      
    </script>
</body></html>