<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<?php
/* In order to connect to database */
include_once 'config.php';
$db_connection = mysql_select_db($db, $connect);

/* Check that database connection is working. */
if(!$db_connection){
	die('Error connecting to database');
}

/* Act should be new || remove || edit */
if (isset($_GET['act'])) {
	$act = $_GET['act'];

	// Echo a form
	/*
	@action insert.php
	@method POST
	@filter (text, model_name)
	@input 	(text, model_description)
	@input 	(file, myFile)
	@input 	(text, marker)
	*/
	if($act=="new"){
		echo '
		<form enctype="multipart/form-data" action="insert.php" method="POST"> 
			<label for="model_name">Name</label> 
			<input name="model_name" id="model_name" type="text"/><br/> 
			
			<label for="model_description">Description</label> 
			<input name="model_description" id="model_description" type="text" /><br/> 
			
			<label for="model_file">File</label> 
			<input name="myFile" type="file" id="file"/><br/> 
			
			<label for="position_lng">Longitude</label> 
			<input name="position_lng" id="position_lng" type="text" maxlength="9" /><br/> 
			
			<label for="position_lat">Latitude</label> 
			<input name="position_lat" id="position_lat" type="text" maxlength="9" /><br/> 
			
		<button type="submit">Create</button><button id="cancel">Cancel</button>
		</form>

		';
		/*
		<label for="texture_file">Texture file</label> <input name="texture_file" id="texture_file" type="text" /><br/> 
		*/
	}
}

if(isset($_GET['id'])){
	$id = $_GET['id'];

	if ($act == "remove") {
		//remove the row
		$result = mysql_query("DELETE FROM `poi`.`tbl_3d` WHERE `tbl_3d`.`id_num` =". $id ."");
		$host  = $_SERVER['HTTP_HOST'];
		header('Location: http://'.$host.'/page/index.php?msg=Removed successfully');
		//header('Location: http://'.$host.'/junaio/page/index.php');
		//redirect to index.php
	
	} elseif ($act == "edit") {
		//go to function that create editForm
		// SELECT from tbl_3d all the content.
		$result = mysql_query("SELECT * FROM $table WHERE id_num='". $id ."'" , $connect);
			
			while ($row = mysql_fetch_object($result)) {
			    // Echo form to edit
			    echo '<form enctype="multipart/form-data" action="update.php" method="POST">
			    <label for="model_name">Name</label>
			    	<input name="model_name" id="model_name" type="text" value="'. $row->model_name .'"/><br/>
				<label for="model_description">Description</label>		    	
			    	<input name="model_description" id="model_description" type="text" value="'. $row->model_description.'" /><br/>
			    <label for="model_file">File</label>
			    	<input name="myFile" type="file" id="file"/><br/>
			    <label for="position_lng">Longitude</label>
			    	<input name="position_lng" id="position_lng" type="text" value="'. $row->position_lng .'" maxlength="9" /><br/>
			    <label for="position_lat">Latitude</label>
			    	<input name="position_lat" id="position_lat" type="text" value="'. $row->position_lat .'" maxlength="9" /><br/>
			    
			    
			    	<input name="id_num" type="hidden" value="'. $row->id_num .'" />
			    	<button type="submit">Update</button><button id="cancel">Cancel</button>
			    </form>';
			    /*
			    <!--<label for="texture_file">Texture file</label>
			    	<input name="texture_file" id="texture_file" type="text" value="'. $row->texture_file .'" /><br/>-->
			    */
			}

	} else {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
}
?>