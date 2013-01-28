<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css">

<?php
/* Connecting the database */
require_once('config.php');
/* Make functions with db queries available */
require_once('queryer.php');

/* Act should be new || remove || edit */
if (isset($_GET['act'])) {
	$act = $_GET['act'];

	/*
	When new button is hitted.
	Display a form for the user to input information about new 3dmodel.
	@action 	insert.php
	@method 	POST
	@input 		(text, model_name)
	@input 		(text, model_description)
	@input 		(file, modelFile
	@input 		(text, marker)
	@return 	_parent = close fancybox
	*/
	if($act=="new"){
		echo '
		
		<h3>New 3d model</h3>

		<form enctype="multipart/form-data" action="insert.php" method="POST" target="_parent"> 
			<label for="model_name">Name*</label> 
			<input name="model_name" id="model_name" type="text"/><br/> 
			
			<label for="model_description">Description*</label> 
			<textarea name="model_description" id="model_description" rows="3" cols="30"></textarea><br/>

			<label for="model_file">File*</label> 
			<input name="modelFile" type="file" id="file"/><br/> 
			
			<label for="marker_file">Marker*</label>
			<input name="markerFile" type="file" id="marker"/><br/>
		<button type="submit">Create</button><button id="cancel">Cancel</button>
		</form>
		<p>* = Mandatory fields</p>
		';
		/*
		Future use when location based. *coordfuture
		<label for="position_lng">Longitude</label> 
		<input name="position_lng" id="position_lng" type="text" maxlength="9" /><br/> 
		
		<label for="position_lat">Latitude</label> 
		<input name="position_lat" id="position_lat" type="text" maxlength="9" /><br/> 	
		*/
	}
}//End if a new-form was requested

if(isset($_GET['id'])){
	$id = $_GET['id'];
	/*
	Remove act
	removes the row, corresponding to the given id, from table
	@param 	id
	@db 	delete
	@return tohomepage
	*/
	if ($act == "remove") {
		/* 
		Alert the user, really remove?
		@ajax 		functions.js
		@param 		String 		confirmation message
		@return 	alert
		*/
		/*
		$confirmMessage = "Do you really want to remove this model?";
		echo '<script type="text/javascript">';
		echo '  var r=confirm("Do you really want to remove this model?");
				r;
				if (r==true){
				  	x="You pressed OK!";
				  	window.location.href = "db/act.php?id=" + id + "&act=remove";
				} else {
				  	x="You pressed Cancel!";
				}';
		echo '</script>';
		*/

		/*
		Remove row and go back to home page if everything is okay.
		@param 	id
		@return Boolean
		*/
		$removeQuery = deleteQuery($id);
		if ($removeQuery) {
			header('Location: ../index.php?msg=Removed successfully');
		} else {
			die("Could not remove object: ".mysql_error() );
			header('Location: ../index.php?msg=Could NOT remove');
		} //End of removing query check

	//end of remove act and continue elseif act is edit
	/*
	Edit- act
	@param 		id
	@db 		update
	@return 	html 	form
	*/
	} elseif ($act == "edit") {
		/*
		function in queryer.php select the row correpsonding to given ID.
		@param 		id
		@return 	array(stdClass Objects)
		*/
		$result = selectWithId($id);
		/*
		Loop an array to display a form with the values from the database
		@param 		$result 	array(stdClass Objects)
		@method 	POST
		@action 	update.php
		@return 	html form
		*/
		foreach ($result as $key => $row) {
		    // Echo form to edit
		    echo '
		    <span class="form">
		    <h1>Edit 3d model</h1>
		    <form enctype="multipart/form-data" action="update.php" method="POST" target="_parent">
		    <label for="model_name">Name</label>
		    	<input name="model_name" id="model_name" type="text" value="'. $row->model_name .'"/><br/>

			<label for="model_description">Description</label>		    	
		    	<textarea name="model_description" id="model_description" rows="3" cols="30">'. $row->model_description.'</textarea><br/>
		    
		    <label for="modelFile">File</label>
		    	<input name="modelFile" type="file" id="file"/><br/>
		    
		    <label for="markerFile">Marker</label>
				<input name="markerFile" type="file" id="marker"/><br/>
		    
		    	<input name="id_num" type="hidden" value="'. $row->id_num .'" />
		    	<button type="submit">Update</button><button id="cancel">Cancel</button>
		    </form>
		    </span>';
		    /*
			Future use when location based. *coordfuture
			<label for="position_lng">Longitude</label> 
			<input name="position_lng" id="position_lng" type="text" maxlength="9" /><br/> 
			
			<label for="position_lat">Latitude</label> 
			<input name="position_lat" id="position_lat" type="text" maxlength="9" /><br/> 	
			*/
		}// End of foreach and displaying form
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	} // End of update-form-displaying
}// End if id was sent
?>