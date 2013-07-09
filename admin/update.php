<?php
/*
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
		else if($_POST['action']=='addproblem') {
			// update the event settings
			if(trim($_POST['title']) == "" || trim($_POST['problem']) == "" || trim($_POST['timelimit']) == "")
				header("Location: addproblem.php?nerror=1");
			else {
       
				mysql_query("INSERT into `problems` (`eventname`,`heading`,`description`,`points`,`timelimit`,`input1`,`output1`) VALUES ('".mysql_real_escape_string($_POST['eventname'])."','".mysql_real_escape_string($_POST['title'])."','".trim(mysql_real_escape_string($_POST['problem']))."','"
					.mysql_real_escape_string($_POST['points'])."','".mysql_real_escape_string($_POST['timelimit'])."','".trim(mysql_real_escape_string($_POST['samplei']))."','".trim(mysql_real_escape_string($_POST['sampleo']))."')") or die(mysql_error());
				$query = "SELECT probid from problems where heading='".mysql_real_escape_string($_POST['title'])."'";
				$result = mysql_query($query);
				$id=mysql_result($result, 0);
				
				if($_POST['c']=='on') $c=1; else $c=0;
				if($_POST['cpp']=='on') $cpp=1; else $cpp=0;
				if($_POST['java']=='on') $java=1; else $java=0;
				if($_POST['python']=='on') $python=1; else $python=0;

				mysql_query("INSERT into `problempref` (`probid`,`c`,`cpp`,`java`,`python`) values ('".$id."','".$c."','".$cpp."','".$java."','".$python."')") or die(mysql_error());
				header("Location: addproblem.php?pid=".$id);
			}
		}
		else if($_POST['action']=='editproblem') {
			$timelimit=mysql_real_escape_string($_POST['timelimit']);
			$eventname=mysql_real_escape_string($_POST['eventname']);
			$heading=mysql_real_escape_string($_POST['title']);
			$description=trim(mysql_real_escape_string($_POST['problem']));
			$points=mysql_real_escape_string($_POST['points']);
			$input1=trim(mysql_real_escape_string($_POST['samplei']));
			$output1=trim(mysql_real_escape_string($_POST['sampleo']));
			if($_POST['c']=='on') $c=1; else $c=0;
			if($_POST['cpp']=='on') $cpp=1; else $cpp=0;
			if($_POST['java']=='on') $java=1; else $java=0;
			if($_POST['python']=='on') $python=1; else $python=0;
			if($eventname==""){
					mysql_query("UPDATE problems SET heading='$heading', description='$description', points='$points', timelimit='$timelimit', input1='$input1',output1='$output1' where probid='".$_POST['ids']."'") or die(mysql_error());
					mysql_query("UPDATE problempref SET c='$c' , cpp='$cpp', java='$java',python='$python' where probid='".$_POST['ids']."'")or die(mysql_error());
			}
			else {
				mysql_query("UPDATE problems SET eventname='$eventname' , heading='$heading', description='$description', points='$points', timelimit='$timelimit', input1='$input1',output1='$output1' where probid='".$_POST['ids']."'") or die(mysql_error());
				mysql_query("UPDATE problempref SET c='$c' , cpp='$cpp', java='$java',python='$python' where probid='".$_POST['ids']."'")or die(mysql_error());
			}
			header("Location: addproblem.php?pid=".$_POST['ids']);
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
		else if($_POST['action']=='deleteproblem') {
			// update the event settings
			if(trim($_POST['id']) == "")
				header("Location: addproblem.php?derror=1");
			else {
				mysql_query("DELETE from problems WHERE probid='".$_POST['id']."'") or die(mysql_error());
				mysql_query("DELETE from problempref WHERE probid='".$_POST['id']."'") or die(mysql_error());
				header("Location: addproblem.php?deleted=1");
			}
		}
		else if($_POST['action']=='addtest') {
			$input;
			$output;

			// update the event settings
			if(trim($_POST['pid']) == "")
				header("Location: addproblem.php?iderror=1");
			else {
				$result=mysql_query("SELECT t.caseid FROM testcases t WHERE t.caseid = (select max(t2.caseid) from testcases t2 where t2.probid = '".$_POST['pid']."')");
				$data=mysql_result($result,0);
				$data+=1;
				//if they DID upload a file...
			if($_FILES['input']['name'])
			{
				//if no errors...
				if(!$_FILES['input']['error'])
				{
					//now is the time to modify the future file name and validate the file
					$new_file_name = strtolower($_FILES['input']['tmp_name']); //rename file
					$valid_file=true;
					if($_FILES['input']['size'] > (1024000)) //can't be larger than 1 MB
					{
						$valid_file = false;
						$message = 'Oops!  Your file\'s size is to large.';
					}
					
					//if the file has passed the test
					if($valid_file)
					{
						//move it to where we want it to be
						$target_path = "upload/";

						$target_path = $target_path . "input-pid-".$_POST['pid']."-caseid-".$data; 

						if(move_uploaded_file($_FILES['input']['tmp_name'], $target_path)) {
							$input=$_FILES['input']['size'];
						    
						} else{
						    header("Location: addproblem.php?uperror=1");
						}
					}
				
				}

			
			}


			if($_FILES['output']['name'])
			{
				//if no errors...
				if(!$_FILES['output']['error'])
				{
					//now is the time to modify the future file name and validate the file
					$new_file_name = strtolower($_FILES['output']['tmp_name']); //rename file
					$valid_file=true;
					if($_FILES['output']['size'] > (1024000)) //can't be larger than 1 MB
					{
						$valid_file = false;
						$message = 'Oops! Your file\'s size is to large.';
					}
					
					//if the file has passed the test
					if($valid_file)
					{
						//move it to where we want it to be
						$target_path = "upload/";

						$target_path = $target_path . "output-pid-".$_POST['pid']."-caseid-".$data; 

						if(move_uploaded_file($_FILES['output']['tmp_name'], $target_path)){
							$output=$_FILES['output']['size'];
						} else{
						    header("Location: addproblem.php?uperror=1");
						}
					}
				
				}
			}

			mysql_query("INSERT into `testcases` (`input`,`output`,`judge`,`probid`) VALUES ('".$input."','".$output."','".$_POST['judgename']."','".$_POST['pid']."')") or die(mysql_error());
			header("Location: addproblem.php?pid=".$_POST['pid']."&test=1");
		}
	}
}
?>
