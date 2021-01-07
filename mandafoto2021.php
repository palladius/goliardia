<?php 

# Qui voglio invece uploadare foto sul DB direttamente cosi
# tremoli tu me lo sleghi :)

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "classes/manda_foto.php";
include "header.php";

$troubleshoot_rails_flash_notices_figata = false;

?>


<h1>Mandafoto 2021 (🙆 upload foto)</h1>

<h2>Foto putativa</h2>

Ideona: <pre>SE sei un utente guest 
	E non hai una foto in immagini/persone/ (nota questo non so come verificarlo) 
	E hai almeno una foto validata

	allora... 

	posso visualizzarla direttamente dal DB anche se non e stata ancora validata! :)

	Come dire: sbrigati zio pal che la gente qui freme! Posso anche associare tale foto come foto_id in loginz
	Cosi utente si sceglie la SUA foto.
</pre>

<? if ($troubleshoot_rails_flash_notices_figata) { ?>
<?= flash_notice("success", "Testing success") ?>
<?= flash_notice("error",   "Testing error") ?>
<?= flash_notice("alert",   "Testing alert") ?>
<?= flash_notice("warning", "Testing warning") ?>
<?= flash_notice("warn", "Testing warn") ?>
<?= flash_notice("NONESISTE", "Testing NONESISTE (vanilla insomma o typo o DEFAULT)") ?>
<?= flash_notice("notice",  "Testing notice (dovrebbe mappare su secondary)") ?>
<?= flash_notice("info",    "Testing info") ?>

<? log2("Nel bel mezzo cosi sessione funge") ?>

<div class="alert alert-primary" role="alert">
  This is a primary alert—check it out!
</div>
<div class="alert alert-secondary" role="alert">
  This is a secondary alert—check it out!
</div>
<div class="alert alert-success" role="alert">
  This is a success alert—check it out!
</div>
<div class="alert alert-danger" role="alert">
  This is a danger alert—check it out!
</div>
<div class="alert alert-warning" role="alert">
  This is a warning alert—check it out!
</div>
<div class="alert alert-info" role="alert">
  This is a info alert—check it out!
</div>
<div class="alert alert-light" role="alert">
  This is a light alert—check it out!
</div>
<div class="alert alert-dark" role="alert">
  This is a dark alert—check it out!
</div>
<? } ?>
<!--
<h3>Spiegone</h3>

#UPDATE mandafoto_images SET image_md5 = MD5(image) -- WHERE image_md5 IS NULL
#https://stackoverflow.com/questions/8196529/mysql-update-a-full-table-inserting-a-md5-hash-for-each-row-a-specific-one
TODO ricc aggiungi md5 programmatico cosi poi mettiamo un bel filtro a livello di DB


Hey 
L'idea qui (un po prototipale) e di fare upload NON su file siccome ormai e' tutto dockerizzato
ma diretamente nel DB cosi da ovunque tu uploadi, funge e synca.
POi mi porro' il problema di SCARRICARe e uploadare ma li non e' un <problema class="">cominciamo dalla tabella

Secondo il tizio in https://makitweb.com/upload-and-store-an-image-in-the-database-with-php/ 
-->
<? if(String(QueryString("image_id"))) { ?>
	<h2>Habemus imaginem! Provemus id renderlam</h2>
	Image id: <?= String(QueryString("image_id")) ?><br/>
<?
	$id = String(QueryString("image_id"));
	$rs2=mysql_query(MANDAFOTO_UN_SOLO_RECORD_BY_ID_sql($id));

	#" (TODO ricc veridica che utente possa vederla tipo AdminVip o Proprietario..)");
	$row = mysql_fetch_array($rs2);
	$filename = $row['filename'];
	$user_name = $row['utente'];
	$encoded_image = $row['encoded_image'];
	$image_src = "uploads/thumb/".$filename;

//	$mandafoto_myfirstobject = MandaFoto.construct_by_id($id) ;
	$mandafoto_myfirstobject = new MandaFoto($id) ;

	echo "1. Path/filename: $filename <br/>\n";
	echo "1. Path/image_src: $image_src <br/>\n";

	echo h1("Il mio primo oggetto:");
	echo $mandafoto_myfirstobject->to_s();
	
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

--> 

<?php 



#$PAZ_UPLOAD="moduli/fileupload/uploads";


?>

<!-- preso da https://makitweb.com/upload-and-store-an-image-in-the-database-with-php/ --> 
Con questo, potrai aggiungere una foto direttasmente nel DB e poco conta dove risiede (o quanto sia shardato) il sito.
Woohoo! Docker FTW!
<?php

//////////////////////////////////////
// UPLOAD LOGIC
//////////////////////////////////////
if(isset($_POST['upload2021'])){
	// qualcuno ha buttato su una foto via POST. Dobbiamo gestirla.
  manage_upload_foto2021();
  mandafotoUploadForm() ; // in fondo
}
 else {
	echo flash_notice("notice", "No upload photo. Ricc qui visualizzi la pagina NORMALE");

	visualizza_foto_uploadate(isadminvip());
	mandafotoUploadForm() ; // di sotto

}

include "footer.php";
?>
