<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<?php
include_once 'config.php';

$id = $_POST['id_num'];
$modelName = $_POST['model_name'];
$modelDescription = $_POST['model_description'];
$positionLatitude = $_POST['position_lat'];
$positionLongitud = $_POST['position_lng'];
$positionAltitude = 0;

if(isset($_FILES)){
	/*
	Set server path to 	$modelFilePath
	Set model file name $modelFileName
	Add filename to path$modelFilePath
	*/
	$modelFilePath = 'http://'.$_SERVER['HTTP_HOST'].'/page/objects/';
	//$modelFilePath = $_SERVER['HTTP_HOST'].'/junaio/page/objects/';
	$modelFileName = $_FILES['myFile']['name'];
	$modelFilePath .=  $modelFileName;
	/*
	Set marker	$marker
	*/
	$markerFileName = $_FILES['marker']['name'];

	/*
	Start to handle the modelfile
	*/
	$errors = array();
	$allowed_ext_model = array('zip');
	$allowed_ext_marker = array('jpg', 'png');

	/* Set the model variables*/
	$file_name_model = $modelFileName;	
	$file_size_model = $_FILES['myFile']['size']; 
	$file_tmp_model = $_FILES['myFile']['tmp_name'];
	$file_ext_model = strtolower(end(explode('.', $file_name_model)));
	
	/* Set the marker variables*/
	$file_name_marker = $markerFileName;	
	$file_size_marker = $_FILES['marker']['size']; 
	$file_tmp_marker = $_FILES['marker']['tmp_name'];
	$file_ext_marker = strtolower(end(explode('.', $file_name_marker)));

	/*Handle the model extension, size... triggering errors */
	if(in_array($file_ext_model, $allowed_ext_model) === false){
		$errors[] = "Extension not allowed for model zipped file. It should be a .zip";
	}

	if($file_size_model > 20971520){
		$errors[] = "Model file cannot be bigger than 750 kb";
	}

	/*Handle the marker extension, size... triggering errors */
	if(in_array($file_ext_marker, $allowed_ext_marker) === false){
		$errors[] = "Extension not allowed for marker file. It should be either .jpg or .png";
	}

	if($file_size_marker > 3145728){
		$errors[] = "Marker file cannot be bigger than 750 kb";
	}
	/* Check if there is any errors and die if there are... */
	if(!empty($errors)){
		$all_errors.= '<span style="color:red;">';
		foreach ($errors as $error) {
			$all_errors .= $error. '<br/>';
		}
		$all_errors .= '</span><br/>Go back and choose another file please.';
		die($all_errors);
	} else {
		/* Move model and marker file to corresponding folders */
		if(move_uploaded_file($file_tmp_model, '../objects/'.$file_name_model) && move_uploaded_file($file_tmp_marker, '../markers/'.$file_name_marker)){
			$query = "
				UPDATE `poi`.`tbl_3d` SET 
				`model_name` = '". $modelName ."',
				`model_description` = '". $modelDescription ."',
				`model_file` = '". $modelFilePath ."',
				`marker_file_name` = '". $markerFileName ."',
				`position_lat` = '". $positionLatitude ."',
				`position_lng` = '". $positionLongitud ."',
				`position_alt` = '". $positionAltitude ."'
				WHERE 
				`tbl_3d`.`id_num` =". $id .";";
			$sendQuery = mysql_query($query);

			if(!$sendQuery){
				die('error sending query'. mysql_error());
			} 
			else
			{
				$host  = $_SERVER['HTTP_HOST'];
				header('Location: http://'.$host.'/junaio/page/index.php?msg=Updated successfully');	
				//header('Location: http://'.$host.'/page/index.php?msg=Updated successfully');	
			}
		} else {
			die("Not uploaded");
			$host  = $_SERVER['HTTP_HOST'];
			header('Location: http://'.$host.'/page/index.php?msg=Could NOT update');
		}	
	}
} else {
	$query = "
				UPDATE `poi`.`tbl_3d` SET 
				`model_name` = '". $modelName ."',
				`model_description` = '". $modelDescription ."',
				`position_lat` = '". $positionLatitude ."',
				`position_lng` = '". $positionLongitud ."',
				`position_alt` = '". $positionAltitude ."'
				WHERE 
				`tbl_3d`.`id_num` =". $id .";";
	$sendQuery = mysql_query($query);

	if(!$sendQuery){
		die('error sending query'. mysql_error());
	} else {
		$host  = $_SERVER['HTTP_HOST'];
		header('Location: http://'.$host.'/junaio/page/index.php?msg=Updated successfully');	
		//header('Location: http://'.$host.'/page/index.php?msg=Updated successfully');	
	}
}
?>