<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<?php
$fileDB = $_GET['filename'];
?>
	<form enctype="multipart/form-data" action="uploader.php" method="POST">
			Browse for <?php echo $fileDB ?><br/>
			<input name="file" type="file" id="file" /><br/>
			<input type="submit" id="u_button" name="u_button" value="Upload the file" />
			<input type="hidden" name="fileDB" value="<?php echo $fileDB; ?>" />
	</form>
	<button id="cancel">Cancel</button>
