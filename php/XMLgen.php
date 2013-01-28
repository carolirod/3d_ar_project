<?php
/*
 XML Generator. When the mobile client connects to the server,
 an XML will be generated from the available objects in the database.
 */
header("Content-type:application/xml");
/* Connect to the database and queries available */
require_once '../db/config.php';
require_once '../db/queryer.php';

require_once '../library/junaiopoibuilder.class.php';
require_once '../library/poitools.php';
/* Needed for generating the xml */
require_once '../library/arel_xmlhelper.class.php';
/*
Define parameters
WWW_ROOT	server
*/
define('WWW_ROOT', "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])); //path to online location

/*
Select all rows in database
@action 	queryer.php
@return 	array(stdClass Objects)
*/
$data = selectAll();
/* 
Start an xml using XMLHelper class
@param 		$resourcesPath = NULL, 
@param 		$arelPath = arelindex
@return 	String 		"<arel><![CDATA[$arelPath]]></arel>";
*/
ArelXMLHelper::start(NULL, WWW_ROOT . "/arel/index.php");

/*
Loop result from database to get the nodes and childs in XML
@param 		$data, array()
@return 	XML POIs nodes for each stdClassObject in datbase.
*/
foreach($data as $poi) { 			
		/*
		Store variables with the result of $data from database
		@param 		$id, $$name, $description, $modelFile, $marker,
					$position(array())
		@array 		id_num, model_name, model_description, model_file, marker_file_name, 
					position_lat, position_lng, position_alt
		*/
		$id = $poi['id_num'];
		$name = $poi['model_name'];
		$description = $poi['model_description'];
		$modelFile = $poi['model_file'];
		$position = array($poi['position_lat'], $poi['position_lng'],$poi['position_alt']);
		$marker = $poi['marker_file_name'];
		
		/*
		Scale of the model, constant
		(it can be changed in mobile client also)
		@return 	array()
		*/
		$scale = array(1,1,1);
		
		/*
		use function createLocationBasedModel3D from XMLhelper class
		@param 		$id, $name, $modelFile, $texture, $position, $scale, $rotation
		@return 	String XML
		*/
		$oObject = ArelXMLHelper::createLocationBasedModel3D(
				$id,
				$name,
				$modelFile,
				"", //texture (md2 only)
				$position, //even though is not currently in use -position will be 0.000, 0.000, 0.000
				$scale, //scale = constant
				new ArelRotation(ArelRotation::ROTATION_EULERDEG, array(0,0,0))
			);
		/* 
		Max distance that the object will be seen from
		@param 		5000 meters
		*/
		$oObject->setMaxDistance(5000);
		/* there should be no need of orientating rightly the object -set when exporting 3dmodel
		$oObject->addParameter('o','1.57,0,0');
			but, this should be the way, check in helpdesk.metaio
		$oObject->setRotation($rotation);		
		*/
		
		$oObject->addParameter('marker', $marker);
		
		/*
		Create a popup using arel -works in juanio app- 
		*/
		$popup = new ArelPopup();
			/* popup --> to show the description of model */
		$popup->setDescription($description);
			/* attach the popup to the POI object */
		$oObject->setPopup($popup);

		/*
		Output one object
		@param 		$oObject with all parameters
		@return 	XML node POI object ready
		*/
		ArelXMLHelper::outputObject($oObject);

}; // end of foreach row of database loop

/*
End of constructing XML
@return 	XML
*/
ArelXMLHelper::end();

?>