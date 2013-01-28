<?php
/* Connecting the database */
require_once('config.php');
/* Make functions with db queries available */
require_once('queryer.php');

/*
Retrieve information from new-model form
@method 	POST
*/
$modelName = $_POST['model_name'];
$modelDescription = $_POST['model_description'];
//$positionLatitude = $_POST['position_lat'];
//$positionLongitud = $_POST['position_lng'];

/*
Set the altitude
@constant 	0 and default in database will convert it to 0.000000
*/
$positionAltitude = 0;

/*
files have to be included in the form to be uploaded.
*/
if($_FILES['modelFile']['size'] > 0 && $_FILES['markerFile']['size'] > 0){
	/*
	Set server path to 		$modelFilePath
	Set model file name 	$modelFileName
	Add filename to path 	$modelFilePath
	*/
	$modelFilePath = 'http://'.$_SERVER['HTTP_HOST'].'/page/objects/';
	//$modelFilePath = $_SERVER['HTTP_HOST'].'/junaio/page/objects/';
	$modelFileName = $_FILES['modelFile']['name'];
	$modelFilePath .=  $modelFileName;
	/*
	Set marker	$marker
	*/
	$markerFileName = $_FILES['markerFile']['name'];

	/*
	Start to handle the modelfile
	*/
	$errors = array();
	$allowed_ext_model = array('zip');
	$allowed_ext_marker = array('jpg', 'png');

	/* Set the model variables*/
	$file_name_model = $modelFileName;	
	$file_size_model = $_FILES['modelFile']['size']; 
	$file_tmp_model = $_FILES['modelFile']['tmp_name'];
	$file_ext_model = strtolower(end(explode('.', $file_name_model)));
	
	/* Set the marker variables*/
	$file_name_marker = $markerFileName;	
	$file_size_marker = $_FILES['markerFile']['size']; 
	$file_tmp_marker = $_FILES['markerFile']['tmp_name'];
	$file_ext_marker = strtolower(end(explode('.', $file_name_marker)));

	/*
	Handle the model extension 
	@typeOFmodelFile 	ZIP
	*/
	if(in_array($file_ext_model, $allowed_ext_model) === false){
		$errors[] = "Extension not allowed for model zipped file. It should be a .zip";
	}
	/*
	Model size 
	@max 	20MB
	@min 	1byte
	*/
	if($file_size_model > 20971520){
		$errors[] = "Model file cannot be bigger than 750 kb";
	}

	/*
	Handle the marker extension
	@typeOFmarker 		jpg || png
	*/
	if(in_array($file_ext_marker, $allowed_ext_marker) === false){
		$errors[] = "Extension not allowed for marker file. It should be either .jpg or .png";
	}
	/*
	Marker size 
	@max 	3145728 bytes
	@min 	1byte
	*/
	if($file_size_marker > 3145728){
		$errors[] = "Marker file cannot be bigger than 750 kb";
	}

	/* 
	If any error regarding the files
	@return 	string 	errors
	*/
	if(!empty($errors)){
		$all_errors.= '<span style="color:red;">';
		/*
		Loop errors array
		@param 		array(errors)
		@return 	string "error regarding size or extension"
		*/
		foreach ($errors as $error) {
			$all_errors .= $error. '<br/>';
		}
		//Suggestion message
		$all_errors .= '</span><br/>Go back and choose another file please.';

		// exit function and process
		die('<p>'.$all_errors.'</p>');

	} else {
		/* 
		If no errors regarding files:
		Move model and marker file 
		@from  		temporary folders
		@to 		corresponding folders 
		*/
		if(move_uploaded_file($file_tmp_model, '../objects/'.$file_name_model) && move_uploaded_file($file_tmp_marker, '../markers/'.$file_name_marker)){
			/*
			insert() in queryer.php
			If upload of files was successful, insert to database
			@param 		$modelName, $modelDescription, $modelFilePath, $markerFileName
			@return 	Boolean
			*/
			$resultQuery = insert($modelName, $modelDescription, $modelFilePath, $markerFileName);
			//Check if the insert-query worked.
			if($resultQuery){
				header('Location: ../index.php?msg=Creation was successful');				
			} else {
				die('Model and marker were uploaded but the insert-query didnt work');
			}

		} else {
			header('Location: ../index.php?msg=Could NOT upload new model');

		
		}//End of move of model and marker file and inserting in database	

	}// End of handling if(!empty($errors))

} else {
	// If either field marker or model are empty, error
	die("Something went wrong! We couldn't upload your files. <br/>
		Marker file and Object zipped file are obligatory fields. <br/>
		Go back and try again.");
} // End of if(!empty $_FILES[marker&&model])



?>