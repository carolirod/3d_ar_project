<?php
// For db in localhost
$server = "localhost";
$user = "root";
$db = "poi";
$table = "tbl_3d";

//Connect to database
$connect = mysql_connect($server, $user);
// */

if (!$connect)
  {
  die('Could not connect: ' . mysql_error());
  } 
 else 
  {
    // Select database
  	$db_connection = mysql_select_db($db, $connect);
  	if(!$db_connection){
  		die('Database selection error');
  	}
  }
?>
