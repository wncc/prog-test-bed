<?php
/*
 * Codejudge
 * Copyright 2012, Sankha Narayan Guria (sankha93@gmail.com)
 * Licensed under MIT License.
 *
 * script that performs some database operations
 */
	include('../functions.php');
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
				header("Location: index.php?nerror=1");
			else {
				$query = "SELECT random,hash FROM users WHERE username='admin'";
				$result = mysql_query($query);
				$fields = mysql_fetch_array($result);
				$currhash = crypt($_POST['oldpass'], $fields['random']);
				if($currhash == $fields['hash']) {
					$random = randomNum(5);
					$newhash = crypt($_POST['newpass'], $random);
					mysql_query("UPDATE users SET hash='$newhash', random='$random' WHERE username='".$_SESSION['username']."'");
					header("Location: index.php?changed=1");
				} else
					header("Location: index.php?passerror=1");
			}
		}
	}
?>
