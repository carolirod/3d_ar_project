<?php
/* Queryer */
function insert($modelName, $modelDescription, $modelFilePath, $markerFileName){
	$query = "
		INSERT INTO `poi`.`tbl_3d` (
			`id_num` , `model_name` , `model_description` , `model_file` , `marker_file_name`)
		VALUES (
			NULL , '". $modelName ."', '". $modelDescription ."', '". $modelFilePath ."', '". $markerFileName ."'); ";

	$sendQuery = mysql_query($query);

	if(!$sendQuery){
		die('error sending query'. mysql_error());
	} else {
		return true;
	}
}

function selectAll(){
	$query = "SELECT * FROM tbl_3d;";
	$result = mysql_query($query);

	if(!$result){
		// error
		echo 'Could not run query: ' . mysql_error();
		exit;
	} elseif (mysql_num_rows($result) > 0) {
		//add all found poiis to an array and return
		$data = array();
		while($row = mysql_fetch_object($result)){
			$data[] = $row;			
		} // End of while

	}// End of if more results
	return $data;

} //End of selectAll function

function selectWithId($id){
	$result = mysql_query("SELECT * FROM tbl_3d WHERE id_num='". $id ."'");
	if(!$result){
		//error
		echo "Could not rung update query:" . mysql_error();
	} elseif (mysql_num_rows($result) > 0) {
		$data = array();
		while ($row = mysql_fetch_object($result)) {
			$data[] = $row;
		} // End of while
	}// End of if more results
	return $data;
}

function updateModelQuery($id, $path){
	$query = "		UPDATE `poi`.`tbl_3d` SET 
					`model_file` = '". $path ."'
					WHERE 
					`tbl_3d`.`id_num` =". $id .";";
	$sendQuery = mysql_query($query);
	
	if(!$sendQuery){
		die('Error sending query'. mysql_error());
	}
	return true;
}

function updateMarkerQuery($id, $path){
	$query = "		UPDATE `poi`.`tbl_3d` SET 
					`model_file` = '". $path ."'
					WHERE 
					`tbl_3d`.`id_num` =". $id .";";
	$sendQuery = mysql_query($query);
	
	if(!$sendQuery){
		die('Error sending query'. mysql_error());
	}
	return true;
}

function deleteQuery($id){
	$result = mysql_query("DELETE FROM `poi`.`tbl_3d` WHERE `tbl_3d`.`id_num` =". $id ."");
	if(!$result){
		return false;
	} else {
		return true;
	}
}
/*
function numRows(){
	$query = "SELECT * FROM tbl_3d;";
	$result = mysql_query($query);	
	$num = mysql_num_rows($result);
	return $num;
};
*/

/*
When position parameters are back in use
for locationBased 3d models position
-when inserting a new row.

			$query = "
				INSERT INTO `poi`.`tbl_3d` (
					`id_num` , `model_name` , `model_description` , `model_file` , `marker_file_name` , `position_lat` , `position_lng` , `position_alt` )
				VALUES (
					NULL , '". $modelName ."', '". $modelDescription ."', '". $modelFilePath ."', '". $markerFileName ."' , '". $positionLatitude ."', '". $positionLongitud ."',
					 '". $positionAltitude ."'); ";


*/
?>