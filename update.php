<?php
/*
 * script that performs some database operations
 */
	include('functions.php');
	connectdb(); //connect to the database
	if(isset($_POST['action'])){
		if($_POST['action']=='email') {
			// update the admin email
			if(trim($_POST['email']) == "")
				header("Location: index.php?nerror=1");
			else {
				mysql_query("UPDATE users SET email='".mysql_real_escape_string($_POST['email'])."' WHERE username='".$_SESSION['username']."'");
				header("Location: index.php?changed=1");
			}
		} else if($_POST['action']=='password') {
			// update the admin password
			if(trim($_POST['oldpass']) == "" or trim($_POST['newpass']) == "")
				header("Location: settings.php?nerror=1");
			else {
				$query = "SELECT random,hash FROM users WHERE username='".$_SESSION['username']."'";
				$result = mysql_query($query);
				$fields = mysql_fetch_array($result);
				$currhash = crypt($_POST['oldpass'], $fields['random']);
				if($currhash == $fields['hash']) {
					$random = randomNum(5);
					$newhash = crypt($_POST['newpass'], $random);
					mysql_query("UPDATE users SET hash='$newhash', random='$random' WHERE username='".$_SESSION['username']."'");
					header("Location: index.php?changed=1");
				} else
					header("Location: settings.php?passerror=1");
					
			}
		}

		else if($_POST['action']=='addsolution'){
			 $code=$_POST['code'];
			 $lang=$_POST['lang'];
			 $username=$_SESSION['username'];
			 $probid=$_POST['probid'];
			 $eid=$_POST['eventid'];
			 if($lang=="C"){
			 	$ext=".c";
			 }
			 else if ($lang=="C++") {
			 	$ext=".cpp";
			 }
			 else if ($lang=="Java") {
			 	$ext=".java";
			 }
			 else if ($lang=="Python") {
			 	$ext=".py";
			 }
			 $query="SELECT * from solve WHERE ( probid=".$probid." AND username='".$username."')";
			 $result=mysql_query($query);
			 $attemptno=mysql_num_rows($result);
			 $attemptno=$attemptno+1;
			 echo "  ".$lang." ".$username." ".$probid." ".$attemptno;
			 if($_FILES['solution']['name']){
			 	//if no errors...
				if(!$_FILES['solution']['error'])
				{
					if($_FILES['solution']['size'] > (1024000)) //can't be larger than 1 MB
					{
						
						header("Location: solve.php?serror=1&pid=".$probid."&eid=".$eid);
					}
					else{
						$target_path = "submissions/";
						$target_path = $target_path . $username."-".$probid."-".$attemptno."".$ext; 
						if(move_uploaded_file($_FILES['solution']['tmp_name'], $target_path)) {
							mysql_query("INSERT into `solve` (`username`,`probid`,`attemptno` ,`lang`,`soln-filename`) VALUES ('".$username."',".$probid .",".$attemptno.",'".$lang."','".$target_path."')") or die(mysql_error());
							header("Location: solve.php?success=1&pid=".$probid."&eid=".$eid);
						    
						} else{
						    header("Location: solve.php?ferror=1&pid=".$probid."&eid=".$eid);
						}
					}
			 }
			 else{
			 	header("Location: solve.php?ferror=1&pid=".$probid."&eid=".$eid);
			 }
		}
		else{
			$target_path = "submissions/";
			$target_path = $target_path . $username."-".$probid."-".$attemptno."".$ext;
			$fp = file_put_contents($username."-".$probid."-".$attemptno."".$ext,$code);
			rename($username."-".$probid."-".$attemptno."".$ext,$target_path);
			mysql_query("INSERT into `solve` (`username`,`probid`,`attemptno` ,`lang`,`soln-filename`) VALUES ('".$username."',".$probid .",".$attemptno.",'".$lang."','".$target_path."')") or die(mysql_error());
			header("Location: solve.php?success=1&pid=".$probid."&eid=".$eid);
			
		}
	}
}

	?>