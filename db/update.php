<?php
include_once 'config.php';
$id = $_POST['id_num'];
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
				UPDATE `poi`.`tbl_3d` SET 
				`model_name` = '". $modelName ."',
				`model_description` = '". $modelDescription ."',
				`model_file` = '". $modelFilePath ."',
				`position_lat` = '". $positionLatitude ."',
				`position_lng` = '". $positionLongitud ."',
				`position_alt` = '". $positionAltitude ."'
				WHERE `tbl_3d`.`id_num` =". $id .";";
			$sendQuery = mysql_query($query);

			if(!$sendQuery){
				die('error sending query'. mysql_error());
			} 
			else
			{
				$host  = $_SERVER['HTTP_HOST'];
				header('Location: http://'.$host.'/page/index.php?msg=Updated successfully');	
			}
		} else {
			die("Not uploaded");
			$host  = $_SERVER['HTTP_HOST'];
			header('Location: http://'.$host.'/page/index.php?msg=Could NOT update');
		}	
	}
} else {
	die("Something went wrong! We couldn't upload your file");
}
?>