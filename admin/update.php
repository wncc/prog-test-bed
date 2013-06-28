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

		else if($_POST['action']=='createevent') {
			// update the event settings
			if(trim($_POST['name']) == "")
				header("Location: createevent.php?nerror=1");
			else {
				if($_POST['uptime']=="") $today = date("Y-m-d H:i:s"); else $today=$_POST['uptime'];
				if($_POST['downtime']=="") $later = "2020-10-10 17:16:18"; else $later=$_POST['downtime'];
				mysql_query("INSERT into `events` (`eventname`,`uptime`,`downtime`) VALUES ('".mysql_real_escape_string($_POST['name'])."','".$today ."','".$later."')") or die($today."   ".mysql_error());
				header("Location: event.php?created=1");
			}
		}
		else if($_POST['action']=='updateevent') {
			// update the event settings
			if(trim($_POST['name']) == "")
				header("Location: updateevent.php?nerror=1");
			else {
				$name=trim($_POST['name']);
				if($_POST['uptime']=="") $today = date("Y-m-d H:i:s"); else $today=$_POST['uptime'];
				if($_POST['downtime']=="") $later = "2020-10-10 17:16:18"; else $later=$_POST['downtime'];
				mysql_query("UPDATE events SET eventname='$name', uptime='$today', downtime='$later' WHERE slno='".$_POST['id']."'") or die($today."   ".mysql_error());
				header("Location: event.php?updated=1");
			}
		}

		else if($_POST['action']=='deleteevent') {
			// update the event settings
			if(trim($_POST['id']) == "")
				header("Location: updateevent.php?derror=1");
			else {
				mysql_query("DELETE from events WHERE slno='".$_POST['id']."'") or die($today."   ".mysql_error());
				header("Location: event.php?deleted=1");
			}
		}
	}
?>
