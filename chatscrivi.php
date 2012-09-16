<?php 



include "chatheader.php";

global $IMMAGINI;
global $QGFDP;
if (!(Session("nickname"))) exit;



if ((Form("operazione"))=="muori")
	{
?>
<body class='bkg_chat'>
<center>
<?php 
	echo ("<table width=$CONSTLARGEZZA600><tr><td>Grazie. Ho notificato agli altri che tu sei uscito e SO che non sei + in chat. ".
			"Un giorno questo pagherà: quando scade una sessione e uno è considerato in chat diminuirò drasticamente i suoi".
			" Goliard Pointz® x punizione. :) </td></tr></table>");
	setSession("chatVergine","diNuovoVergine");
	if ($PUBBL_MSG_ENTRA_ESCI)
		addMessaggio(getMessaggio(Session("nickname"),"__SPECIALE__"," è appena uscito dalla Chat"));
?>
<form name="f1" method="post" action="chatscrivi.php">
  <input type="button" value="MUORI DAVVERO, ORA." onClick="parent.close()">
</form>
</center>
</body>
<?php 
	exit;
	}



if (Session("chatVergine") != "sverginato")
	{
	if ($PUBBL_MSG_ENTRA_ESCI)
		addMessaggio(getMessaggio(Session("nickname"),"__SPECIALE__"," è appena entrato in Chat"));
	setSession("chatVergine","sverginato");
	}


function effettuaSostituzioni($testo)
{
global $icone,$colori,$col;
	// venerdi'! aiuto! rendi + efficiente sta funzione, sicuramente il php ha funzioni x gestire i > e i < ...

//echo "guarda def in(<b>".getdefinizioni($testo,$testo)."</b>)";

  $testo = strip_tags($testo);  // toglie < e >
  $testo = ereg_replace("[\$]","&#36;",strval($testo));

  $testo = stripslashes($testo);
  //$testo=testoToEMAILRIC($testo); // pre chiocciola
  $testo = ereg_replace("@","&#64;",$testo);

//echo "guarda def p4(<b>".getdefinizioni($testo,$testo)."</b>)";


  if (Session("erremoscia")) //sarebbe true
	{
	 $testo = replace($testo,"r","<i>v</i>");
	 $testo = replace($testo,"R","<i>V</i>");
	}

  $testo = replace($testo,":\)","<img src=\"".$icone[1]."\">");
  $testo = replace($testo,":\(","<img src=\"".$icone[2]."\">");
  $testo = replace($testo,";\)","<img src=\"".$icone[3]."\">");
  $testo = replace($testo,":D", "<img src=\"".$icone[4]."\">");
  $testo = replace($testo,":P", "<img src=\"".$icone[5]."\">");
  $testo = replace($testo,"\(C\)","<img src=\"".$icone[6]."\" height=\"20\" align='Center'>");
  $testo = replace($testo,":dit","<img src=\"".$icone[7]."\" height=\"20\" align='Center'>");





  $testo = replace($testo,"scusa","vaffanculo (ma solo xchè scusa non si chiede)");
  $testo = replace($testo,"grazie","ti darò il culo x questo");
//   $testo = replace($testo,"grazie","denghiu");
    $testo = replace($testo,"prego","<i>of nothing, for you this and other®</i>");
  $testo = replace($testo,"cazzo","<b>turbominchia</b>");
  $testo = replace($testo,"merda","<b>Oca</b>");
//  $testo = replace($testo,"goliardia","<b>In questo sito non parleremo che di <i>goGliardia</i>: quella vera - invece - la faremo al bar!!!</b>");
  $testo = replace($testo,"buongiorno","<i>mittttticccccoooooo!!!! ... mabbbaaaaaffanculo!</i>");
  $testo = replace($testo,"palladius","<i>quel maricon de Palladius</i>");
  $testo = replace($testo,"ciao", "Evviva l'Italia evviva la Bulgaria");
  $testo = replace($testo,"a dopo","<i>Palladius è proprio un gran Figo, devo ammettere. Un saluto</i>");
//  $testo = replace($testo,"vado","<i>mi accingo ad andare</i>");

$balbuziente = Session("conf_balbuziente"); // true; //(String(Session("nickname")) == "lapalisse");

if ($balbuziente)	
	{
	$testo= replace($testo,"ba","b-ba");
	$testo= replace($testo,"pe","p-pe");
	$testo= replace($testo,"da","d-da");
	$testo= replace($testo,"ci","c-ci");
	$testo= replace($testo,"come","m-mi c-c-chiamo K-K-K-Ken!");
	}


		// sostituzione del /a
  if (contiene($testo,"/a"))
	{	// emote...
		//echo "contiene un /a!!";
		//$testo=substr($testo,3);
		$destinatario="__SPECIALE__";
	}	
else 

  $testo = "<font color='" .$colori[$col] . "'>" . $testo . "</font>";


//$string = "quest chi  is a FICHISSIMO test!!!";
//echo str_replace(" is", " was", $string);
//echo ereg_replace("( )is", "\\1was", $string);
//echo ereg_replace("(( )is)", "\\2was", $string);

$testo=testoToURL($testo);


return $testo;
}


function testoToURL($text) // copiato paro paro dal sito del php
{return  ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                     "<a href=\"\\0\">\\0</A>", $text);
}
// metto spazi / a se no da conflitti col /a di EMOTE...
function testoToEMAILRIC($text) // fatto da me
{return  ereg_replace("[[:alpha:]]+\@[^<>[:space:]]+[[:alnum:]/]",
                     "<a href=\"mailto:\\0\">\\0</ a>", $text);
}



function getMessaggio($nickname, $destinatario, $testo)
{
 $orariuz = date("H:i"); 
// echo "testo vale ($testo)";

 return  $orariuz ."@" . $nickname . "@" . $destinatario. "@" . $testo;
}

function addMessaggio($msg)
{
 global $MAXMESSAGGI;

  $messaggi = getApplication("messaggi");

  $frase = explode("\$",$messaggi);

// echo "aggiungo a messaggi il valore di msg: <b>($msg)</b>";

  for ($i=0;$i<sizeof($frase) && $i<$MAXMESSAGGI-1;$i++)
	{
    $msg .= "\$" . $frase[$i];
	}

 
  setApplication("messaggi",$msg);
//  echo "messaggi post setApp vale: ($messaggi)";
}

$isPalladius=((Session("nickname"))=="palladius");

$colori = array (



 	$isPalladius ?  "#000077" // blu scurito un pelo
			:  "#333333", // grigione
	"#FF0000", // rosso
	"#000000", // nero
	"#FF1493", // viola
	"#008800"  // verde


			);

$icone = array  (
		"$IMMAGINI/persone/palladius4.jpg",
		"$IMMAGINI/1.gif",
		"$IMMAGINI/2.gif",
		"$IMMAGINI/3.gif",
		"$IMMAGINI/4.gif",
		"$IMMAGINI/5.gif",
		"$IMMAGINI/cuorechepulsa.gif",
		"$IMMAGINI/ditone.gif",
		"$IMMAGINI/cesso.gif"
			);

$nickname = (Session("nickname"));
$testo = (Form("testo"));
$destinatario = (Form("destinatario"));
//if (destinatario=="undefined") destinatario = "";
$col = intval(Form("colore"));
//if (isNaN(col) || col<0 || col>=colori.length) col = 0;

//echo "sto x scrivere il testo $testo...";

if (!empty($testo))	//($testo!="undefined" && $testo!="")
 {
  $testo=effettuaSostituzioni($testo);
  $nuova = getMessaggio($nickname,$destinatario,$testo);
  addMessaggio($nuova);
 } 

$per = (querystring("per"));
	//if (per=="undefined") per = "";

// gestione degli speciali...

$specialfrase = (querystring("speciale"));
if ($specialfrase == "svuotachat")
	if (isAdminVip())
		{scrivi("azzero le frasi scritte. Potere di zio Pal...");
		 setApplication("messaggi", "");
		}


// GESTIONE DELLE BRAGHE


// palladius$numpx$M @ <utente$px$sex> @ e così via


bragheInit();

$bragheqs = (querystring("braghe"));

if (! empty($bragheqs))
	 	{bragheAdd($bragheqs);
		 echo ("<center><i>mandato in braghe quel turbominchione® di <b>$bragheqs</b></i></center>");
		}
$bragheqs = (querystring("surge"));
if (! empty($bragheqs))
		{bragheRemove($bragheqs);
		 echo("<center><i>fatto surgere quel mammalucco di <b>$bragheqs</b></i></center>");
		}





?>


<html>
<head>
  <title><?php  echo $QGFDP?> Prodaxions</title>
</head>
<body onLoad="document.f1.testo.focus()" class='bkg_chat_cosinonva'>


<center><table cellspacing="0" cellpadding="0" width="<?php  echo $CONSTLARGEZZA600?>" height="20" border="0"><tbody><tr><td>

<form name="f1" method="post" action="chatscrivi.php">
	<center>
  <input type="text" name="testo" size="40">
  <select name="colore">
    <option value="0"<?php  echo ($col==0) ? " selected" : ""?>><?php  echo ($isPalladius? "blu Pal" : "grigino" )?></option>
    <option value="1"<?php  echo ($col==1) ? " selected" : ""?>>rosso</option>
    <option value="2"<?php  echo ($col==2) ? " selected" : ""?>>nero</option>
    <option value="3"<?php  echo ($col==3) ? " selected" : ""?>>viola</option>
    <option value="4"<?php  echo ($col==4) ? " selected" : ""?>>verde</option>
  </select>
  <?php  if ($per!="") { ?>
  <input type="hidden" name="destinatario" value="<?php  echo $per?>">
  <input type="submit" value="Invia a <?php  echo strtoupper($per)?>">
  <?php  } else { ?>
  <input type="submit" value="Invia">
  <?php  } ?>
  <input type="button" value="Aggiorna" onClick="parent.leggi.location.reload();parent.footer.location.reload();">
<?php  //=(" ...    <i>(<b>".Session("nickname")."</b>)</i>")
?>
</form>
<form name="f2" method="post" action="chatscrivi.php">
  <input type="hidden" name="operazione" value="muori">
  <input type="hidden" name="nome" value="<?php  echo Session("nickname")?>">
<!---
  <input type="submit" value="Esci dolcemente">
--->
</form>

</td></tr></table>



<table width=<?php  echo $CONSTLARGEZZA600 ?>><tr><td>
<font size="-1">
<b>N.B.</b> Attenzione a quel che scrivete. Siete osservati.
<?php   definizioni("[<b><u>MORE INFO</u></b>]","Questa è la chat di $QGFDP. Ora c'è anche l'autofocus, se notate.\n" 
	."Attenzione, se siete nuovi: molte parole vengono trasformate in altre per il vostro "
	."ma soprattutto MIO divertimento. A voi scoprire quali cambiamenti...");
?>
</font>
</tr></td></table>

<script>
document.f1.testo.focus();
</script>


<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top" colspan="2" bgcolor="#663399">
 <img src="<?php  echo $IMMAGINI?>/pixel.gif" width="<?php  echo $CONSTLARGEZZA600?>" height="1" alt="" border="0">
</td>
</tr>
</tbody></table>



</body>
</html>
