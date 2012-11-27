<?php
/*
 * XML Generator. When the phone connects to the server it, it send its Bluetooth id as
 * a GET parameter. This script check based on the bluetooth id the following things:
 * 
 * 1. If there is a respondent connected to the research: the getSubjectByBT returns
 * the user id which is connected the currently ongoing research.
 * 
 * 2. After that the script is checking  
 */
header("Content-type:application/xml");
include_once '../db/config.php';
require_once '../library/junaiopoibuilder.class.php';
require_once '../library/poitools.php';
require_once '../library/arel_xmlhelper.class.php';

define('WWW_ROOT', "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])); //path to online location
define('MAX_DISTANCE', 5000);

$query = "SELECT * FROM tbl_3d;";
//$jPoiBuilder = new JunaioBuilder($position, MAX_DISTANCE);

$result = mysql_query($query);

/*
try
{
	$result = mysql_query($query) or die(mysql_error());
}
catch(Exception $e)
{
	Response::send(Response::SQL, mysql_error());
}
*/
if ( mysql_num_rows($result) > 0) {
	//add all found poiis to an array and return
	$data = array();
	while($row = mysql_fetch_array($result)){
		$data[] = $row;
	}	    	
}

ArelXMLHelper::start(NULL, WWW_ROOT . "/arel/index.php");

//foreach($databaseOutput as $count => $entry) { 			
foreach($data as $poi) { 			
		$id = $poi['id_num'];
		$name = $poi['model_name'];
		$description = $poi['model_description'];
		$modelFile = $poi['model_file'];
		$position = array($poi['position_lat'], $poi['position_lng'],$poi['position_alt']);
		$scale = array(1,1,1);

		$oObject = ArelXMLHelper::createLocationBasedModel3D(
				$id,
				$name,
				$modelFile,
				"", //texture (md2 only)
				$position,
				$scale, //scale
				new ArelRotation(ArelRotation::ROTATION_EULERDEG, array(0,0,0))
			);
		$oObject->addParameter('o','1.57,0,0');
		$oObject->setMaxDistance(5000);
		//output one object
		ArelXMLHelper::outputObject($oObject);
};

ArelXMLHelper::end();

?>