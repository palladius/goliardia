<?php

// costanti
#$PAZ_UPLOAD="uploads";  -> messa in costanti

// $MANDAFOTO_UN_SOLO_RECORD_BY_ID_SQL = "SELECT 
// 			id as _mandafoto_id,
// 			name as filename, 
// 			status, 
// 			user_id , 
// 			user_name as utente, 
// 			user_name as _fotoutente,
// 			image as encoded_image, # the blob, you dont wanna visualize this! :) 
// 			FLOOR(LENGTH(image)/1024) AS image_size_kb,
// 			description 
// 		FROM mandafoto_images 
// 		WHERE id = ___ID___";

// ispirato da https://www.php.net/manual/en/language.oop5.basic.php
class MandaFoto
{
    // property declaration
    public $var = 'a default value';
	public $md5 = 'class_todo'; 
	public $id  = -1;
	
	// construct by id
	function __construct($param) {
        $this->id = $param;
    }

    // method declaration
    public function displayVar() {
        echo $this->var;
    }

    public function to_s($verbose=null) {
		if (null === $verbose) { $verbose = true; } // default
		
		$ret = get_class($this) ;
		$ret = $ret .   "::id=" . $this->id ;
		if ($verbose) {
			$ret = $ret . varDumpToString($this);
		}
		return $ret;
    }
} // /Classe Mandafoto


// i HATE php! https://www.tutorialspoint.com/how-to-capture-the-result-of-var-dump-to-a-string-in-php#:~:text=php%20function%20varDumpToString(%24var),it%20to%20a%20string%20variable.
function varDumpToString($var) {
	ob_start();
	var_dump($var);
	$result = ob_get_clean();
	return $result;
}

function MANDAFOTO_UN_SOLO_RECORD_BY_ID_sql($id) {
	#--  as _foto_status, 
	
	return  "SELECT 
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
		WHERE id = $id";
}
// /////////////////////////////////////////
// MandaFoto2021 funzioni a cazzo di cane
// /////////////////////////////////////////
function visualizza_foto_uploadate($is_admin) {
	$user_id = $_SESSION["_SESS_id_login"];

	echo h1($is_admin ? 
		"[ADMINVIP] Thumbs buttate su fin oggi su DB" :
		"Le TUE foto buttate su"
	);

	$where_addon = $is_admin ? "" : "	WHERE user_id = '$user_id' ";

	#		--name as filename, 

	$customized_query = "SELECT 
		id as _mandafoto_id,
		id AS _mandafoto_action,
		status AS _foto_status, 
		user_id , 
		user_name as utente, 
		user_name as _fotoutente,
		image AS _base64image ,
		FLOOR(LENGTH(image)/1024) AS image_size_kb,
		image_md5,
		description 
	FROM mandafoto_images 
	$where_addon
	ORDER BY _foto_status ASC, lastUpdated DESC
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


function showInfoToAdminvipReMandafotoById($foto_id) {
	echo h2("Info su foto $foto_id ");

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
		WHERE id = $foto_id"
	);

	$row = mysql_fetch_array($rs2);
	$filename = $row['filename'];
	$user_name = $row['utente'];
	$encoded_image = $row['encoded_image'];
	$image_src = "uploads/thumb/".$filename;
	$inline_image = '<img src="' . $encoded_image . '"  height="100" />';


	$visualizza_hash = array(
		"filename" => $row['filename'],
		'user_name' => $row['utente'],
		'linked_path_image' => "<a href='' >magic link</a>",
		'status' => $row['status'],
		'inline_image' => $inline_image ,
	);

	#echo "1. Path/filename: $filename <br/>\n";
	#echo "1. Path/image_src: $image_src <br/>\n";


	foreach($visualizza_hash as $k => $v) {
		echo "* " . $k . ": <b>$v</b>";
		echo "<br>";
	}
}



function mandafotoUploadForm($verbose=null) {
	if (null === $verbose) { $verbose = true; } // default


	opentable();
	if ($verbose) {
		echo h3("<a href='https://www.youtube.com/watch?v=nxwuBymFRjA' >Carrica</a> una tua foto (come tua foto personale)");
		echo "<i>Attenzione, &egrave; importante che tu capisca i vincoli su questa foto, che sono: <br/>(1) non deve essere + grossa di tot KB; <br/>(2) dev'essere <u>portrait</u> ( ovvero pi&ugrave; alta che larga, come nelle fototessere), indicativamente 100x150 tanto x dare un'idea; <br/>(3) non dev'essere scema (tipo la tua foto a 3 anni, la foto di un maiale o lo stemma del tuo ordine): vista la connotazione 'rosa' del sito, &egrave; importante che chi veda la tua foto possa farsi un'idea di come sei fatto 'de fora';<br/>";
		echo "(4) dev'essere di tipo jpg;<br/> (5) dev'essere tua omonima: <b>se ti chiami pippo si deve chiamare <u>pippo.jpg</u> con le maiuscole GIUSTE</b> x favore, cosi' mi eviti di entrare in telnet nel sito x cambiare uno stupido nome. grazie!</i><br>";
		echo "<br><b>Un'altra cosa: le foto messe qui sono IN UN POSTO DIVERSO per motivi di sicurezza, quindi c'e' bisogno che un amministratore ci metta mano, potete buttare su 600 foto ma non vi comparir&agrave; dove deve. Insomma, consideratelo un parcheggio che ogni tanto viene spostato da me nel posto giusto. Ok? Grazie per la vostra pazienza - se non ne avete posso consigliarvi una musica Funky - molto Cool!<b><br>";
	}

	?>

	<!-- -->
	<style>
		.equalDivide tr td { width:33%; }
	</style>

	<form method="post" action="" enctype='multipart/form-data'>
	<tr>
		<td rowspan="0"><textarea type='textarea' name='description' value='Note sulla foto' cols="30" />Note sulla foto 2</textarea>
		<td>2 File da buttar su</td>
		<td>3 <input type='file' name='file' /> </td>
	</tr>
	<tr>
	<td>5
		<td>6 <input type='submit' value='Butta Su' name='upload2021'>
	</tr>

	</form>

	<?php
	closetable();

	}

function   manage_upload_foto2021() {

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
		$image_md5 = "TODO_TOGLIMI_MANHOUSE" . md5($image_base64 ); // nota che md5o l'encoded... cosi per comodita cosi e piu facile da ricomputare.

	   // Insert record
		$query = "INSERT INTO `mandafoto_images` (
					`id`, `name`, `image`, `status`,`description`, # riga1
					`user_name`, `user_id`, `image_md5`) # riga2
				VALUES ( 
					NULL, '".$name."', '".$image."', '00-NEW', '".$description."',
					'".$_SESSION["_SESS_nickname"]."', '".$_SESSION["_SESS_id_login"]."', '$image_md5'
				) "; 
	  // TODO aggiunti user_id
	   $rs2=mysql_query($query);
	   if ($rs2) {
		   echo "Successo! TODO(ricc): redirect cosi vedi effeto nella tabella. Se no reload.";
	   } else {
		  echo "Mi sa che abbiamo cannato..!";
	   } 
	   scrivib("[result2 vale '$rs2' ]");
  
	   // Upload file
	   $ret = move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name) ? "tutto ok" : "cannato";
	   scrivib("move_uploaded_file -->  $ret");
	}
   

}


?>
