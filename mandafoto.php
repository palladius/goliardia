<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

# Ricc: i parametri sono in "moduli/fileupload/upload_ric_thumb.php"


/*
	dice kash: x cambiare il problema delle foto, occorre fare cosi':
	 chmod("$uploaddir/$filename", 0644); // octal, correct value of mode

*/


$PAZ_UPLOAD="uploads"; // va post slashato

echo rosso(h2("Pagina prototipale (per mandare foto)"));

echo "(per ora, l'upload funziona, ma non c'&egrave; ancora l'informativa automatica che vi dice se la foto va bene o no nel trasferitore automatico di foto da qua alla directory con tutte le persone effettive :) ) Dio solo sa che cosa succeder&agrave; con la dockerizzazione. Tocca scrivere una GCF apposta.";

#if ($ISGUEST || isadminvip())
if (1)
{
opentable();
	#$LNKJUMLAFOTO="http://www.goliardia.it/joomla/index.php?option=com_content&task=view&id=71&Itemid=26";
	echo h3("invia una tua foto (come tua foto personale)");
	#echo "<a href='$LNKJUMLAFOTO'><img src='immagini/contenuti/consigli-mandafoto.jpg' align=right></a>";
	echo "<i>Attenzione, &egrave; importante che tu capisca i vincoli su questa foto, che sono: <br/>(1) non deve essere + grossa di tot KB; <br/>(2) dev'essere <u>portrait</u> ( ovvero pi&ugrave; alta che larga, come nelle fototessere), indicativamente 100x150 tanto x dare un'idea; <br/>(3) non dev'essere scema (tipo la tua foto a 3 anni, la foto di un maiale o lo stemma del tuo ordine): vista la connotazione 'rosa' del sito, &egrave; importante che chi veda la tua foto possa farsi un'idea di come sei fatto 'de fora';<br/>(4) dev'essere di tipo jpg; (5) dev'essere tua omonima: <b>se ti chiami pippo si deve chiamare <u>pippo.jpg</u> con le maiuscole GIUSTE</b> x favore, cosi' mi eviti di entrare in telnet nel sito x cambiare uno stupido nome. grazie!</i><br>";
     echo "<br><b>Un'altra cosa: le foto messe qui sono IN UN POSTO DIVERSO rispetto alle altre, quindi finche' un  amministratore (per ora solo io) non ci mette mano, potete buttare su 600 foto ma non vi comparir&agrave; dove deve. Insomma, consideratelo un parcheggio che ogni tanto viene spostato da me nel posto giusto. Ok?<b><br>";
	#echo h4("<a href='http://www.goliardia.it/joomla/index.php?option=com_content&task=view&id=71&Itemid=26'>Se sei indeciso, leggi qui per ulteriori informazioni!</a>");
  if (isadminvip())
		echo ("caro admin vip, non dovresti vederlo. ma guardalo e ciappinaci, solo x prova!");
	include "moduli/fileupload/upload_ric_thumb.php";
closetable();
}

#$PAZ_UPLOAD="moduli/fileupload/uploads";

if (isadminvip())	{
	echo h1("Thumbs buttate su fin oggi");
		# cambiatio il 26ago05
	visualizzaThumbPaz("*",false,"$PAZ_UPLOAD/thumb/",TRUE,40,7);
	if (isDevelop() || $ISPAL) {
		scrivi("<h3>PAL, modifica visualizzaThumbPaz per metterci il postante!!!</h3>");
	}
	if (isDevelop()) {
		echo "paz vale: '$PAZ_UPLOAD/thumb/*'";
	}
}

include "footer.php";

?>
