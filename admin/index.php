<?php
/*
 * Admin Panel Home
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
    
      <?php
        if(isset($_GET['changed']))  //correct settings saved
          echo("<div class=\"alert alert-success\">\nSettings Saved!\n</div>");
        else if(isset($_GET['passerror']))  //incorrect entry error
          echo("<div class=\"alert alert-error\">\nThe old password is incorrect!\n</div>");
        else if(isset($_GET['nerror']))  //null error
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");

      	include('menu.php');
      ?>
      <div class="row-fluid">
        <div class="span2">
        </div>
        <div class="span8">
            <p text-align="center"> <h5>Welcome admin, </h5><br/> Go through the links in the nav-bar to create problems/event. You can as well look into user standings! <br/> You can update Mail-Id or change password in the Account Settings Option.
			</p>
        </div>
        <div class="span2">
        </div>
      </div>
      	

    </div> <!-- /container -->

<?php
	include('../footer.php');
?>