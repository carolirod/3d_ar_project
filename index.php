<!DOCTYPE html>
<html>
	<head>
		<title>Arabian ranta in 3D</title>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
	</head>
	<body>
		<h1>Arabian ranta in 3D - administrator site</h1>
		<h2>3D models</h2>
		<button name="new" id="newID">Add new model</button>
			<table>
			<?php				
				require_once("db/config.php");

				if(isset($_GET['msg'])){
						echo "<p style=\"font-weight:bold;color:green\">".$_GET['msg']."</p>";
				};

				$result = mysql_query("SELECT * FROM $table;", $connect);

				if(!$result){
					die('Could not SELECT ' . mysql_error());
				}
				else
				{
					//echo "Success!";
				};
				
				$result_table = mysql_query("SELECT * FROM $table; ", $connect);
				if (!$result) {
				    echo 'Could not run query: ' . mysql_error();
				    exit;
				};

				$num_rows = mysql_num_rows($result);
				echo "<tr>
						<th>NAME</th> <th>DESCRIPTION</th> <!--<th>LOCATION</th>--> <th>FILE</th> <th>MARKER</th> <th>OPTIONS</th>
					  </tr>";
					for ($i=0; $i <= $num_rows-1 ; $i++) { 
						while ($row = mysql_fetch_object($result_table)) {
					
						echo '<tr>
								<td><p>'.$row->model_name.'</p></td>
								<td width="30%"><p>'.$row->model_description.'</p></td>
								<!--<td><p>Longitude: '.$row->position_lng.' , Latitude: '.$row->position_lat.'</td>-->
								<td><p>'.$row->model_file.'</p></td>
								<td><img src="markers/'.$row->marker_file_name.'" width="150" height="100" /></td>
								<td><button name="remove" id="'.$row->id_num.'">Remove</button> 
								<button name="edit" id="'.$row->id_num.'">Edit</button></td>
							</tr>';
						}
					}
			?>
			</table>

	</body>	
</html>