<?php 

# Qui voglio invece uploadare foto sul DB direttamente cosi
# tremoli tu me lo sleghi 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$PAZ_UPLOAD="uploads"; // va post slashato
?>

<h2>Mandafoto 2021 (🙆 upload foto)</h2>

L'idea qui (un po prototipale) e di fare upload NON su file siccome ormai e' tutto dockerizzato
ma diretamente nel DB cosi da ovunque tu uploadi, funge e synca.
POi mi porro' il problema di SCARRICARe e uploadare ma li non e' un <problema class="">cominciamo dalla tabella

Secondo il tizio in https://makitweb.com/upload-and-store-an-image-in-the-database-with-php/ 

<? if(String(QueryString("image_id"))) { ?>
	<h2>Habemus imaginem! Provemus id renderlam</h2>
	Image id: <?= String(QueryString("image_id")) ?><br/>
<?
	$id = String(QueryString("image_id"));
	#--  as _foto_status, 
	$rs2=mysql_query(
		"SELECT 
			id as _mandafoto_id,
			name as filename, 
			status, 
			user_id , 
			user_name as utente, 
			user_name as _fotoutente,
			image as encoded_image, # the blob, you dont wanna visualize this! :) 
			FLOOR(LENGTH(image)/1024) AS image_size_kb,
			description 
		FROM mandafoto_images 
		WHERE id = $id"
	);
	#scriviRecordSetConTimeout($rs2,1729,
	#"Ecco la tua foto",
	#" (TODO ricc veridica che utente possa vederla tipo AdminVip o Proprietario..)");
	$row = mysql_fetch_array($rs2);
	$filename = $row['filename'];
	$user_name = $row['utente'];
	$encoded_image = $row['encoded_image'];
	$image_src = "uploads/thumb/".$filename;

	echo "1. Path/filename: $filename <br/>\n";
	echo "1. Path/image_src: $image_src <br/>\n";
	
	#print_r($row);
?>
<br/>
2. TODO also RENDER it!
<h3>Modo facile da locale</h3>

Se ho foto in locale e facile:

<img src='<?php echo $image_src;  ?>' height="100" 
	 alt="Foto di '$user_name' con filename '$filename'"
	 style="vertical-align:middle" />


<h3>Modo difficile decodifico base64 da DB</h3>

<!-- 
Mannaggia manca... ecco che SO aiuta: https://stackoverflow.com/questions/4110907/how-to-decode-a-base64-string-gif-into-image-in-php-html
Note this case is bad (not cached): https://stackoverflow.com/questions/16262098/displaying-a-base64-images-from-a-database-via-php/16262187
Ma chissene?
-->
<?
#echo '<img src="data:image/gif;base64,' . $encoded_image . '"  height="200" />';
echo '<img src="' . $encoded_image . '"  height="200" />';
?>


<? } ?>

<!--
<h3>Spiegone</h3>
Per me stesso.. -> coimmentato.

Dovrei fare tipo 

<pre>CREATE TABLE `mandafoto_images` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `image` longtext NOT NULL,
  `status` varchar(20) DEFAULT '00-NEW',
  `user_id` INT ,
  `user_name` varchar(255) NOT NULL ,
  `description` TEXT,
  `admin_description` TEXT  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

Fatto! Ora mo vediamo. Oh aspe:

ALTER TABLE `mandafoto_images` ADD `lastUpdated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;


Stati che mi vengono in mente:

* '00-NEW': Appena creata.
* '01-ACCEPTED': Accepted. Stil unprocessed - requires a script or a human to move to proper location.
  and move to state 03.
* '02-DENIED': Not accepted. `Description` should contain the reason. Done.
* '03-ARCHIVED': Accepted -> moved to proper place. Should disappear from viisble but still remain in archive.
 
</pre>



<h3>TMP DEBUG</h3>
--> 

<?php 

# Nota: $_ENV on va a dflt in prod: 88
# DEbvi abilitare esplicitamente in <php class="ini"># Siccome ho pwd
# Ques ques eviterei...
// echo "<pre>== DEBUG_INFO ==\n";
// if($DEBUG) {
// 	echo "DEB#UG: $DEBUG ";
// } else {
// 	echo "NODEBUG, prod!\n";
// 	echo "getenv DEB: ". getenv("DEBUG") ."\n";
// 	echo "getenv DON: ". getenv("DEBUG_ON") ."\n";
// }
// echo "ENV[debug] = " . $_ENV['DEBUG'] ."\n" ;
// echo "ENV[debug_on] = " . $_ENV['DEBUG_ON'] ."\n" ;
// echo "</pre>";


#$PAZ_UPLOAD="moduli/fileupload/uploads";

function visualizza_foto_uploadate($is_admin) {
	$user_id = $_SESSION["_SESS_id_login"];

	echo h1($is_admin ? 
		"[ADMINVIP] Thumbs buttate su fin oggi su DB" :
		"Le TUE foto buttate su"
	);

	$where_addon = $is_admin ? "" : "	WHERE user_id = '$user_id' ";

	$customized_query = "SELECT 
		id as _mandafoto_id,
		name as filename, 
		status AS _foto_status, 
		user_id , 
		user_name as utente, 
		user_name as _fotoutente,
		image AS _base64image ,
		FLOOR(LENGTH(image)/1024) AS image_size_kb,
		description 
	FROM mandafoto_images 
	$where_addon
	ORDER BY lastUpdated DESC
	LIMIT 10
	";

	// LEFT(image, 50) AS cropped_image,
			
	$rs2=mysql_query($customized_query);
	scriviRecordSetConTimeout($rs2,1000,
	"Foto uploadate via mandafoto su DB",
	"Queste foto esistono sia su FS (ephemeral) che DB (piuttosto stabile - si spera)");

	# cambiatio il 26ago05
	echo h2("Sempre per te admin guarda anche le foto uploadate nel FS locale..");
	visualizzaThumbPaz("*",false,"$PAZ_UPLOAD/thumb/",TRUE,40,7);
} // end admin


mandafotoUploadForm() ;

?>

<!-- preso da https://makitweb.com/upload-and-store-an-image-in-the-database-with-php/ --> 
Con questo, potrai aggiungere una foto direttasmente nel DB e poco conta dove risiede (o quanto sia shardato) il sito.
Woohoo! Docker FTW!
<?php

#include("config.php");

if(isset($_POST['upload2021'])){
  echo "<h2>Upload in progresso.. </h2>";
  $name = $_FILES['file']['name'];
  #$target_dir = "upload/";
  $target_dir = "uploads/thumb/" ;
  $file_basename = "TODO_U_SESS_nickname-" . basename($_FILES["file"]["name"]);
  $target_file = $target_dir .  $file_basename ;

  // Select file type
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg","jpeg","png","gif");

  // Check extension
  if( in_array($imageFileType,$extensions_arr) ){
	  // Convert to base64 
	  $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
	  $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
	  $description = $_POST['description']; # todo escapa quotes
 
     // Insert record
     $query = "INSERT INTO `mandafoto_images`
	 			(`id`, `name`, `image`, `status`,`description`,`user_name`, `user_id`) 
				VALUES ( 
				NULL, '".$name."', '".$image."', '00-NEW', '".$description."',
				'".$_SESSION["_SESS_nickname"]."', '".$_SESSION["_SESS_id_login"]."'
				) "; 
	// TODO aggiunti user_id
	 #mysqli_query($connessione, $query);
	 $rs2=mysql_query($query);
	 if ($rs2) {
		 echo "Successo!";
	 } else {
		echo "Mi sa che abbiamo cannato..!";

	 } 

	 scrivib("[rs2 vale '$rs2' ]");
  
     // Upload file
	 $ret = move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name) ? "tutto ok" : "cannato";
	 scrivib("move_uploaded_file -->  $ret");
  }
 
}
 else {

	echo "<h2>No upload click to see magic! TODO retrieve code</h2>";
}

visualizza_foto_uploadate(isadminvip());

function mandafotoUploadForm() {


opentable();
echo h3("<a href='https://www.youtube.com/watch?v=nxwuBymFRjA' >Carrica</a> una tua foto (come tua foto personale)");
echo "<i>Attenzione, &egrave; importante che tu capisca i vincoli su questa foto, che sono: <br/>(1) non deve essere + grossa di tot KB; <br/>(2) dev'essere <u>portrait</u> ( ovvero pi&ugrave; alta che larga, come nelle fototessere), indicativamente 100x150 tanto x dare un'idea; <br/>(3) non dev'essere scema (tipo la tua foto a 3 anni, la foto di un maiale o lo stemma del tuo ordine): vista la connotazione 'rosa' del sito, &egrave; importante che chi veda la tua foto possa farsi un'idea di come sei fatto 'de fora';<br/>";
echo "(4) dev'essere di tipo jpg;<br/> (5) dev'essere tua omonima: <b>se ti chiami pippo si deve chiamare <u>pippo.jpg</u> con le maiuscole GIUSTE</b> x favore, cosi' mi eviti di entrare in telnet nel sito x cambiare uno stupido nome. grazie!</i><br>";
echo "<br><b>Un'altra cosa: le foto messe qui sono IN UN POSTO DIVERSO per motivi di sicurezza, quindi c'e' bisogno che un amministratore ci metta mano, potete buttare su 600 foto ma non vi comparir&agrave; dove deve. Insomma, consideratelo un parcheggio che ogni tanto viene spostato da me nel posto giusto. Ok? Grazie per la vostra pazienza - se non ne avete posso consigliarvi una musica Funky - molto Cool!<b><br>";
closetable();

?>

<form method="post" action="" enctype='multipart/form-data'>
  <input type='file' name='file' />
  <input type='text' name='description' value='Note sulla foto' />
  <input type='submit' value='Butta Su' name='upload2021'>
</form>

<?php
}
include "footer.php";
?>
