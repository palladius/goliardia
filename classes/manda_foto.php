<?php

global $current_user;

// Nel DB vale cosi
/*
URL: http://pma-goliardia.palladi.us/index.php?db=goliardiaprod&table=mandafoto_images&target=tbl_structure.php


#	Name	Type	Collation	Attributes	Null	Default	Comments	Extra	Action
1	id					Primary	int(11)			No	None		AUTO_INCREMENT	
2	name				varchar(200)	latin1_swedish_ci		No	None			
3	image				longtext		latin1_swedish_ci		No	None			
4	image_md5			varchar(40)		utf8_general_ci		Yes	NULL	da implementare ancora e usare per unicita		
5	status				varchar(20)		latin1_swedish_ci		Yes	00-NEW			
6	user_id				int(11)				Yes	NULL			
7	user_name			varchar(255)	latin1_swedish_ci		No	None			
8	description	text	utf8_general_ci		Yes	NULL			
9	admin_user_id		int(11)				Yes	NULL			
10	admin_description	text			utf8_general_ci		Yes	NULL			
11	docker_context		varchar(500)	utf8_general_ci		Yes	NULL	Contesto di esecuzione tipo hostname e qualche va ENV che mi aiuti a capire dove sono i files	
12	lastUpdated			timestamp			on update CURRENT_TIMESTAMP	No	CURRENT_TIMESTAMP		ON UPDATE CURRENT_TIMESTAMP	

*/

log2("TOGLI STA MERDA sto testando log2") ;


// ispirato da https://www.php.net/manual/en/language.oop5.basic.php
class MandaFoto
{
	// scopiazzato da https://www.php.net/manual/en/language.oop5.basic.php
    // property declaration
    //ublic $var = 'a default value';
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

// server per docker_context
function server_info() {
#	GOLIARDIA_DOVESONO	docker-locale
#GOLIARDIA_GMAIL_USER	goliardia.it.daemon@gmail.com
#GOLIARDIA_DOCKER_VER	2.0_alpha
#HTTP_HOST	localhost:8090
	return "HTTP_HOST=". $_SERVER["HTTP_HOST"];
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

	flash_notice("error", "SENZA ECHO non dovresti vedermi.."); 
	echo flash_notice("notice", "Clicca sul <A href='mandafoto.php' >vecchio mandafoto</a>!");
	#$PAZ_UPLOAD = get_paz_upload();
	#visualizzaThumbPaz("*",false,"$PAZ_UPLOAD/thumb/",TRUE,40,7);
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
		echo "</tr><tr colspan='100' >"; # si combina con le colonne di dopo.
		echo h3("<a href='https://www.youtube.com/watch?v=nxwuBymFRjA' >Carrica</a> una tua foto (come tua foto personale)");
		echo "<i>Attenzione, &egrave; importante che tu capisca i vincoli su questa foto, che sono: <br/>(1) non deve essere + grossa di tot KB; <br/>(2) dev'essere <u>portrait</u> ( ovvero pi&ugrave; alta che larga, come nelle fototessere), indicativamente 100x150 tanto x dare un'idea; <br/>(3) non dev'essere scema (tipo la tua foto a 3 anni, la foto di un maiale o lo stemma del tuo ordine): vista la connotazione 'rosa' del sito, &egrave; importante che chi veda la tua foto possa farsi un'idea di come sei fatto 'de fora';<br/>";
		echo "(4) dev'essere di tipo jpg;<br/> (5) dev'essere tua omonima: <b>se ti chiami pippo si deve chiamare <u>pippo.jpg</u> con le maiuscole GIUSTE</b> x favore, cosi' mi eviti di entrare in telnet nel sito x cambiare uno stupido nome. grazie!</i><br>";
		echo "<br><b>Un'altra cosa: le foto messe qui sono IN UN POSTO DIVERSO per motivi di sicurezza, quindi c'e' bisogno che un amministratore ci metta mano, potete buttare su 600 foto ma non vi comparir&agrave; dove deve. Insomma, consideratelo un parcheggio che ogni tanto viene spostato da me nel posto giusto. Ok? Grazie per la vostra pazienza - se non ne avete posso consigliarvi una musica Funky - molto Cool!<b><br>";
	}

	?>

	<form method="post" action="" enctype='multipart/form-data'>
	<!-- 
			Nota che se cambi le colonne da 2 a 3, devi mettere a posto il CSS di sopra e il colspan nel verbose ;)
			Anzi no, messo a 100 (da Centocelle) cosi hai un pensiero in meno. 
			1 2
			3 4
			5 6

		PS Usa rowspan="0" per spannare su piu righe :)
	-->
	<tr>
		<td>
			<b>1. Note addizionali</b><br/>
			perche' vuoi metter us questa foto? Per conto di chi?
			C'e' altro contesto addizionale di cui dovrei essere avvisato? <br/>
		<td><!-- tassello 2 --> 
		<textarea type='textarea' name='description' value='Note sulla foto' cols="30" >Note sulla foto 2</textarea>
	</tr>
	<tr>
		<td><!-- tassello 3 -->
		<b>2. File da buttar su</b><br/>
			Clicca per upload da file locale. Mi raccomando: JPG non troppo grande, portrait, e faccia BEN visibile!
			No mascherina grazie :P 
		<td><!-- tassello 4 --><input type='file' name='file' /> </td>
	</tr>
	<tr>
		<td><!-- tassello 5 -->
			<b>3. Utente per cui mandi foto</b><br/>
			Il 99% della gente manda foto per se stessi. Ma sai mai che tu sia super zelante,
			gentile o semplicmente un bravo leccaculo: ebbene, questo campo e per te.
			Mi raccomando NIENTE typo nel nome utente<br/>
			<!--
			TODO(ricc): non fidarti dell input del popol bue - metti una bella choice con tutti user
			-->
		<td><!-- tassello 6 --> 
		<input type='textfield' name='description' value='<? echo current_user(); ?>' cols="20" />
	
	</tr>
	<tr>
		<td><!-- tassello 7 -->
			<b>4. Controlla 3 volte..</b><br/>
			Quando sei sicuro che le notule siano ben a posto, e che il file sia attacchato (ovvero non vedi la frase "No file chosen")
			direi che ci siamo. <br/>
			Persino una <i>foetentissima matricola</i> dovrebbe riuscirci..

		<td><!-- tassello 8 -->
			<input type='submit' value='Butta Su' name='upload2021' >
	</tr>

	</form>

	<?php
	closetable();

	}

function   manage_upload_foto2021() {

	echo "<h2>Upload in progresso.. </h2>";

	log2("Qualcuno uploada un file di nome ".  $_FILES['file']['name'] );

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
		$image_md5 = # "TODO_TOGLIMI_MANHOUSE" . 
			md5($image_base64 ); // nota che md5o l'encoded... cosi per comodita cosi e piu facile da ricomputare.
		$docker_context = server_info();
	   // Insert record
		$query = "INSERT INTO `mandafoto_images` (
					`name`, `image`, `status`,`description`, 
					`user_name`, `user_id`, `image_md5`, 
				`id`) -- tengo id sempre per ultimo cosi non sbaglio le virgole :P
				VALUES ( 
					'".$name."', '".$image."', '00-NEW', '".$description."',
					'".$_SESSION["_SESS_nickname"]."', '".$_SESSION["_SESS_id_login"]."', '$image_md5',
				NULL) "; # tengo id sempre per ultimo cosi non sbaglio le virgole :P
	  // TODO aggiunti user_id
	   #db_importantlog_slow("mysql", "Query: $query"); // IMAGE e troppo grossa per log..
	   $rs2=mysql_query($query); #  or die(mysql_error());
	   if ($rs2) {
		   #echo "Successo! TODO(ricc): redirect cosi vedi effeto nella tabella. Se no reload. toglimi quando flash funge";
		   echo flash_notice("success", "Successo! TODO(ricc): redirect cosi vedi effetto nella tabella. Se no clicca su <a href='mandafoto2021.php' >mandafoto2021.php</a>.");
		   db_importantlog_slow("mandafoto", "Uploadato foto '$name' (md5: $image_md5, size: TODO)"); # logga
	   } else {
		  debugga("Mi sa che abbiamo cannato..! Non e andata. result2 vale '$rs2'. ". mysql_error());
	   } 
	   scrivib("[result2 vale '$rs2' ]");
  
	   // Upload file
	   $ret = move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name) ? "tutto ok" : "cannato";
	   scrivib("move_uploaded_file -->  $ret");
	}
   

}


?>
