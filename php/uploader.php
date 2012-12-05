<?php
if(isset($_FILES['file'])){
	$fileDB = $_POST['fileDB'];
	$errors = array();
	$allowed_ext = array('obj', 'zip', 'mtl');

	$file_name = $_FILES['file']['name'];
	$file_ext = strtolower(end(explode('.', $file_name)));
	$file_size = $_FILES['file']['size']; 
	$file_tmp = $_FILES['file']['tmp_name'];

	if(in_array($file_ext, $allowed_ext) === false){
		$errors[] = "Extension not allowed";
	}

	if($file_size > 768000){
		$errors[] = "File cannot be bigger than 750 kb";
	}

	if($file_name != $fileDB){
		$errors[] = "File should be the same as stated previously";
		if(!empty($errors)){
			foreach ($errors as $error) {
				echo $error, '<br/>';
			}
		}
	} else {
		$path = dirname(__FILE__)."/page/objects/";
		if(move_uploaded_file($file_tmp, 'page/objects/'.$file_name == true)){
			$host  = $_SERVER['HTTP_HOST'];
			header('Location: http://'.$host.'/page/index.php?msg=File uploaded successfully');	
		} else {
			$host  = $_SERVER['HTTP_HOST'];
			header('Location: http://'.$host.'/page/index.php?msg=Could NOT upload file');
		}
		
	}
}
/*
	

	if(empty($errors)){
		if(move_uploaded_file($file_tmp, '../objects/'. $file_name)){
			$host  = $_SERVER['HTTP_HOST'];
			header('Location: http://'.$host.'/junaio/page/index.php?msg=File uploaded successfully');
		}
	} else {
		foreach ($errors as $error) {
			echo $error, '<br/>';
		}
	}
}
*/
?>
