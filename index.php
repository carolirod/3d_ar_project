<!DOCTYPE html>
<html>
	<head>
		<title>Arabia in 3D - Augmented Reality project</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>

		<!-- Fancybox, UI functionality -->
		<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<script type="text/javascript">
		$(document).ready(function() {
			$("#various3").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		});
		</script>
		<!-- End of Fancybox UI functionality -->

	</head>
	<body>
		<header>
			<h1>Arabia in 3D - Augmented Reality project</h1>
			<button name="new" id="various3" href="db/act.php?act=new">Add new model</button>
			<a href="docs/ArabianrantaProject-adminGuide.pdf" target="_blank" >Download Administrator Guide</a>
			<?php
			/* function that echoes a message if present
				@method GET
				@isset 	msg variable
				@echo 	string HTML
				 */

				if(isset($_GET['msg'])){
						$sms = "<span class=\"message\">".$_GET['msg']."</span>";
						echo $sms;
				};
			?>
		</header>
			
			<?php				
				/* Connecting the database */
				require_once('db/config.php');
				/* Available functions with db queries */
				require_once('db/queryer.php');

				/*
				queryer.php 
				@function 	selectAll
				@sql 		SELECT * FROM tbl_3d;
				@return 	array(stdClass Objects)
				*/
				$result_table = selectAll();

				/*
				Show all results from database in table
				@headers 	NAME DESCRIPTION FILENAME MARKER OPTIONS
				@echo 		html
				*/
				echo "<table>
					  <caption>3D models available</caption>
					  <thead>
						  <tr>
							<th>NAME</th> <th>DESCRIPTION</th> <!--<th>LOCATION</th>--> <th>FILE</th> <th>MARKER</th> <th>OPTIONS</th>
						  </tr>
					  </thead>
					  <tbody>";
					/*
					Function that shows all the results 
					-model_information- available in database
					@loop 	array
					@return html
					@commented out, position_lng, _lat, _alt 	
					*/				
					foreach ($result_table as $key => $row) {
	
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
				echo "</tbody></table>";

			?>
	<footer>
		<p>Prototype provided by Metropolia University of Applied Sciences</p>
	</footer>

	</body>	
</html>