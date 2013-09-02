<?php
/*
 * Common functions used throughout Codejudge
 */
session_start();

// connects to the database
function connectdb() {
  include('dbinfo.php');
  $con=mysql_connect($host,$user,$password);
  if (!$con) {
		die('Could not connect to mysql: ' . mysql_error());
	}
  mysql_select_db($database) or die('Error connecting to database. '. mysql_error());
}

// generates a random number.
function randomNum($length){
  $rangeMin = pow(36, $length-1);
  $rangeMax = pow(36, $length)-1;
  $base10Rand = mt_rand($rangeMin, $rangeMax);
  $newRand = base_convert($base10Rand, 10, 36);
  return $newRand;
}

// checks if any user is logged in
function loggedin() {
  return isset($_SESSION['username']);
}

// converts text to an uniform only '\n' newline break
function treat($text) {
  $s1 = str_replace("\n\r", "\n", $text);
  return str_replace("\r", "", $s1);
}


//compile problem and gets its answer

function compile($probid,$solname,$compilerhost,$compilerport,$time,$input,$lang){
   // connect to the java compiler server to compile the file and fetch the results
  $socket = fsockopen($compilerhost, $compilerport);

   if($socket) {
        fwrite($socket, 'Solution.'.$ext."\n");
        fwrite($socket, $time."\n");
        $soln=file_get_contents($solname,FILE_USE_INCLUDE_PATH);
        $soln = str_replace("\n", '$_n_$', treat($soln));
        fwrite($socket, $soln."\n");
        $input = str_replace("\n", '$_n_$', treat($input));
        fwrite($socket, $input."\n");
        fwrite($socket, $lang."\n");
        $status = fgets($socket);
        $contents = "";
                while(!feof($socket))
                    $contents = $contents.fgets($socket);
                if($status == 0) {
                  echo "Oops error occured <br/>";
                  echo $contents;
                }
                else if($status == 1) {
                  echo "Compiled correctly <br/>";
                  echo $contents;
                }
                else if($status == 2) {
                  echo "Timed out <br/>";
                  echo $contents;
                }




}
?>