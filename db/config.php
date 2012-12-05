<?php
///*
//For database in amazon
$db = "poi";
$server = "localhost";
$user = "3duser";
$pwd = "3duserpwd";
$table = "tbl_3d";
$connect = mysql_connect($server, $user, $pwd);
// */
/*
// For db in localhost
$server = "localhost";
$user = "root";
$db = "poi";
$table = "tbl_3d";
$connect = mysql_connect($server, $user);
// */
if (!$connect)
  {
  die('Could not connect: ' . mysql_error());
  } 
 else 
  {
  	$db_connection = mysql_select_db($db, $connect);
  	if(!$db_connection){
  		die('Database selection error');
  	}
  }
?>