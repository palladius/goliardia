<html>
	<head><title>Upload</title></head>
<body>



<?php

#require "tmp_funzioncine.php";

require("fileupload-class.php");



#--------------------------------#
# Variables
#--------------------------------#

// The path to the directory where you want the 
// uploaded files to be saved. This MUST end with a 
// trailing slash unless you use $path = ""; to 
// upload to the current directory. Whatever directory
// you choose, please chmod 777 that directory.

	$path = "uploads/thumb/";

// The name of the file field in your form.

	$upload_file_name = "userfile";

// ACCEPT mode - if you only want to accept
// a certain type of file.
// possible file types that PHP recognizes includes:
//
// OPTIONS INCLUDE:
//  text/plain
//  image/gif
//  image/jpeg
//  image/png
	
	// Accept ONLY gifs's
	#$acceptable_file_types = "image/gifs";
	
	// Accept GIF and JPEG files
	$acceptable_file_types = "image/gif|image/jpeg|image/pjpeg|image/png";
	
	// Accept ALL files
	#$acceptable_file_types = "";

// If no extension is supplied, and the browser or PHP
// can not figure out what type of file it is, you can
// add a default extension - like ".jpg" or ".txt"

	$default_extension = "";

// MODE: if your are attempting to upload
// a file with the same name as another file in the
// $path directory
//
// OPTIONS:
//   1 = overwrite mode
//   2 = create new with incremental extention
//   3 = do nothing if exists, highest protection

	$mode = 2;
	
	
#--------------------------------#
# PHP
#--------------------------------#
	if (isset($_REQUEST['submitted'])) {
		/* 
			A simpler way of handling the submitted upload form
			might look like this:
			
			$my_uploader = new uploader('en'); // errors in English
	
			$my_uploader->max_filesize(30000);
			$my_uploader->max_image_size(800, 800);
			$my_uploader->upload('userfile', 'image/gif', '.gif');
			$my_uploader->save_file('uploads/', 2);
			
			if ($my_uploader->error) {
				print($my_uploader->error . "<br><br>\n");
			} else {
				print("Thanks for uploading " . $my_uploader->file['name'] . "<br><br>\n");
			}
		*/
			
		// Create a new instance of the class
		$my_uploader = new uploader($_POST['language']); // for error messages in french, try: uploader('fr');
		
		// OPTIONAL: set the max filesize of uploadable files in bytes
		$my_uploader->max_filesize(47000);
		
		// OPTIONAL: if you're uploading images, you can set the max pixel dimensions 
		$my_uploader->max_image_size(600, 400); // max_image_size($width, $height)
		
		// UPLOAD the file
		if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
			$my_uploader->save_file($path, $mode);
		}
		
		if ($my_uploader->error) {
			echo "<font color='blue'>".$my_uploader->error . "</font><br><br>\n";
		
		} else {
			// Successful upload!
			print($my_uploader->file['name'] . " was successfully uploaded! <a href=\"" . $_SERVER['PHP_SELF'] . "\">Try Again</a><br>");
		 	log2("utente $nick ha uploadato la foto: ".($my_uploader->file['name']),".uploadfoto.log");
		 	#log2("utente $nick ha uploadato la foto: ".($my_uploader->file['name']));
			// Print all the array details...
			//print_r($my_uploader->file);
			
			// ...or print the file
			if(stristr($my_uploader->file['type'], "image")) {
				echo "<img src=\"" . $path . $my_uploader->file['name'] . "\" border=\"0\" alt=\"\">";
			} else {
				$fp = fopen($path . $my_uploader->file['name'], "r");
				while(!feof($fp)) {
					$line = fgets($fp, 255);
					echo $line;
				}
				if ($fp) { fclose($fp); }
			}
 		}
 	}




#--------------------------------#
# HTML FORM
#--------------------------------#
?>
	<form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
	<input type="hidden" name="submitted" value="true">
		
		Butta su sto file qua, mo':<br>
		<input name="<?= $upload_file_name; ?>" type="file">
	
		
	<input type="hidden" name="language" value="it">

<!---
		Error Messages:<br>
		<select name="language">
			<option value="en">English</option>
			<option value="fr">French</option>
			<option value="de">German</option>
			<option value="nl">Dutch</option>
			<option value="it">Italian</option>
			<option value="fi">Finnish</option>
		</select>
--->

		
		<input type="submit" value="butta su!">
	</form>
	<hr>

<?php
	if (isset($acceptable_file_types) && trim($acceptable_file_types)) {
		print("Questa form accetta solo file <b>" . str_replace("|", " or ", $acceptable_file_types) . "</b>\n");
	}
?>



</body>
</html>
