<?php
include_once 'config.php';

$modelName = $_POST['model_name'];
$modelDescription = $_POST['model_description'];

$modelFilePath = 'http://'.$_SERVER['HTTP_HOST'].'/page/objects/';
//$modelFilePath = $_SERVER['HTTP_HOST'].'/junaio/page/objects/';
$modelFileName = $_FILES['myFile']['name'];
$modelFilePath .=  $modelFileName;

$positionLatitude = $_POST['position_lat'];
$positionLongitud = $_POST['position_lng'];
$positionAltitude = 0;

if(isset($_FILES['myFile'])){
	$errors = array();
	$allowed_ext = array('obj', 'zip', 'mtl');

	$file_name = $modelFileName;
	$file_ext = strtolower(end(explode('.', $file_name)));
	$file_size = $_FILES['myFile']['size']; 
	$file_tmp = $_FILES['myFile']['tmp_name'];

	if(in_array($file_ext, $allowed_ext) === false){
		$errors[] = "Extension not allowed";
	}

	if($file_size > 768000){
		$errors[] = "File cannot be bigger than 750 kb";
	}
	
	if(!empty($errors)){
		$all_errors.= '<span style="color:red;">';
		foreach ($errors as $error) {
			$all_errors .= $error. '<br/>';
		}
		$all_errors .= '</span><br/>Go back and choose another file please.';
		die($all_errors);
	} else {
		if(move_uploaded_file($file_tmp, '../objects/'.$file_name)){
		
			$query = "
				INSERT INTO `poi`.`tbl_3d` (
					`id_num` , `model_name` , `model_description` , `model_file` , `position_lat` , `position_lng` , `position_alt` )
				VALUES (
					NULL , '". $modelName ."', '". $modelDescription ."', '". $modelFilePath ."', '". $positionLatitude ."', '". $positionLongitud ."',
					 '". $positionAltitude ."'); ";

			$sendQuery = mysql_query($query);

			if(!$sendQuery){
				die('error sending query'. mysql_error());
			} 
			else
			{
				$host  = $_SERVER['HTTP_HOST'];
				header('Location: http://'.$host.'/page/index.php?msg=Creation was successful');
				//header('Location: http://'.$host.'/junaio/page/index.php?msg=Creation was successful');
			};				
		} else {
			$host  = $_SERVER['HTTP_HOST'];
			header('Location: http://'.$host.'/page/index.php?msg=Could NOT upload new model');
		}	
	}
} else {
	die("Something went wrong! We couldn't upload your file");
}



?>