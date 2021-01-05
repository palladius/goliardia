<?php 
	include "constants.php";

		# $Id: funzioni.php 60 2009-09-27 09:45:55Z riccardo $
	# versione 2.0a...

#	Qua metteremo le funzioni che son state fatte ex novo e non vengono dalla precedente versione
#	quindi tutte le cose php-dependant (nuove bazze x date, post, immagini, eccetera...)


	## NON SERVE A UNA SEGA! devi andare in function isAdminVip e cambiarlo a manaza!!!
$arrAdminVip = array (
				"palladius"
				,"cavedano"
				,"manolus"
				,"gimmygod"
				,"ophelia"
				,"palo"
				,"pariettus"
				,"pal-bot"
				,"vipera"
				);

$arrDevelop = array (
				#"palladius",
				"venerdi",
				"badello",
				"cavedano",
				"persevero",
				"titanicus",
				"pal-bot"
				);

$IMMAGINI="immagini"; // che POI va tabbato...
$globMenuItemz = "";

$week = array ("domenica","lunedì","martedì","mercoldì","giovedì","venerdì","sabato");
$weekkina = array ("dom","lun","mart","merc","giov","ven","sab");
$mesini = array ("gen","feb","mar","apr","mag","giu","lug","ago","set","ott","nov","dic");

$icona_capoordine="corona30.png"; //"capoordine.gif"
$icona_manto="manto.gif";         // "mantello30.jpg"  //"nobile.jpg"
$icona_saio="saio.gif";           // "cacca34.png"   


/*
HINT 
array file ( string filename [, int use_include_path [, resource context]])

Identica a readfile(), eccetto per il fatto che file() restituisce il file in un vettore.
Ogni elemento del vettore corrisponde ad una riga del file, con il carattere di newline 
ancora inserito. Se la funzione non riesce restituisce FALSE. 

ci puoi fare una bella implementazione di chat!
*/


/* 
	postcede("ciao@da@me","@") d� fuiori "da"
*/
function ciochepostcede($frase,$sep)
{//cerca ciì che in frase precede il separatore
if (empty($frase)) return array();

$tmparr=explode($sep,$frase);
$ret="";
if (sizeof($tmparr)>1) // almeno 2
	$ret=$tmparr[1]; // il secondo
//echo "[ciochepostcede($frase,$sep): ($ret)]";
return $ret; // inefficiente ma pulitissimo
}

/*
	venerdì!!! si puì sicuramente ottimizzare con una regex UNICA (usando i upper/lowercase), mal che vada con una PCRE
*/
function rimpiazzaErreMoscia($frase) {
	$frase = replace($frase,"r","v");
	return replace($frase,"R","V");
}

function mq($sql) {
	$tmp=mysql_query($sql)
		or sqlerror($sql);
	return $tmp;
}


function formtextBr($label,$valore_iniziale) {
	if ($valore_iniziale=="null")	$valore_iniziale="";
	$valore_iniziale=trim($valore_iniziale);
	scrivi($label."<br>\n<input type='text' name=\"".$label."\"  value=\"".$valore_iniziale."\">\n");
}



function sqlerror($sql)
{
global $ISPAL;
if ($ISPAL) die ("erore nella query [<b>$sql</b>]: ".mysql_error());
die("erore sql, altro dirti non vo'<br/>");
}
function formSceltaTRUEFALSE($label,$msg,$seleziona_TRUE) {
	scrivi($msg);
	formScelta2($label,TRUE,FALSE,"sì","no",$seleziona_TRUE ? 1 : 2);
}

function scriviReport_LinkMini($rs) { 
	?> <a href="<?php  echo $rs["URLlink"]?>"><b><?php  echo $rs["titolo"]?></b></a> (<?php  echo stripslashes($rs["Descrizione"])?>) <br/> <?php   
}




function scriviReport_Utente($rs,$linkami,$ii) {
  global $paz_foto_persone,$ISPAL;
  $simbolo=$rs["m_sNome"].".jpg"; 
  $sesso=$rs["m_bIsMaschio"] ? "maschio" : "femmina";

  echo "<tr class='$sesso'>";

  scrivi("<td width='20%'>".getFotoUtenteDimensionata($rs["m_sNome"],80)); // ottimizzabile...
  scrivi("<br><center><b class='utente'>".$rs["m_sNome"]."</b></center>");

 if ($ISPAL) { // solo admin vip leggono la mail.
	scrivi("<br><i>".$rs["m_sPwd"]."</i>");
	tdtd();

#	formBegin("pag_messaggi.php");
#	formhidden("my_hidden_id","id_login");
#	formhidden("id_login",$rs["ID_LOGIN"]);
#	formhidden("OPERAZIONE","CANCELLA_LOGIN");
#	$ospitechar= ($rs["m_bGuest"] == "TRUE") ? "XX" : "XX (U)";
#	formbottoneinvia($ospitechar);
#	formEnd();



//	if ($rs["m_bguest"] == 1)
//	{ // guest
//	formBegin("pag_messaggi.php");
//	formhidden("id_login",rs["ID_LOGIN"]);
//	formhidden("OPERAZIONE","RENDIUSER");
//	$ospitechar= ($rs["m_bGuest"] == 1) ? "RENDIUSER (RIC)" : "ERRORISSIMO dillo al webmaster mi raccomando!!!";
//	formbottoneinvia($ospitechar);
//	formEnd();
//	}

#	formBegin("pag_messaggi.php");
#	formhidden("my_hidden_id","ID_LOGIN");
#	formhidden("id_login",$rs["id_login"]);
#	formhidden("OPERAZIONE","MODIFY tbds");
#	formbottoneinvia("MODIFY");
#	formEnd();

}
else
if (isAdmin() && $rs["m_bGuest"] == 1)
	{ // guest
	//$stessaprovincia = (strtolower($rs["provincia"]) == strtolower($_SESSION["provincia"]));
	$stessaprovincia = (strtolower($rs["provincia"]) == strtolower(Session("provincia")));
	if ($stessaprovincia)
	{
	formBegin("pag_messaggi.php");
	formhidden("id_login",$rs["ID_LOGIN"]); //so che �porco, ma x minimizzare � modifiche
		// qui son maiuscolo di la' invece minuscolo!!!
	formhidden("OPERAZIONE","RENDIUSER");
	$ospitechar= $stessaprovincia ?
			 "RENDIUSER (idl=".$rs["ID_LOGIN"]."; tuo compaesano di ".$rs["provincia"].") \n ma SOLO se vedi una foto qui a fianco"
			: "RENDIUSER (anche se � di '".$rs["provincia"]."')";

	formbottoneinvia($ospitechar);
	formEnd();
	}
	else {scrivib("province diverse, admin caro...");}
	}


 echo"</td><td width='50%'>";



scriviTRUEFALSE($rs["m_bAttivo"],	"Attivo",		"Inattivo");
scriviTRUEFALSE($rs["m_bGuest"],	"Ospite",		"Utente registrato");
scriviTRUEFALSE($rs["m_bIsGoliard"],	"Goliarda",		"Filisteo");
scriviTRUEFALSE($rs["m_bErreMoscia"],"Ha la <i>evve moscia</i>","");
scriviCoppia("Note",$rs["m_sNote"]);


 tdtd();

 if (isAdminVip()) // solo admin vip leggono la mail.
   scrivi("<a href='mailto:".$rs["m_hEmail"]."'>".$rs["m_hEmail"]."</a><br>");


 scriviCoppia("iscritto", datasbura(($rs["m_dataIscrizione"])));
if (isAdminVip())
	scriviCoppia("Nato",(datasburaw2k($rs["datanascita"])));    //     +" (<i>Ariete</i>)");
scriviCoppia("Nome Cognome",$rs["m_thumbnail"]);
scriviCoppia("GP�",$rs["m_nPX"]);
scriviCoppia("finger",(datasburaw2k($rs["m_dataLastCollegato"])));    //     +" (<i>Ariete</i>)");
scriviCoppia("Citt�",$rs["provincia"]);

 scrivi("</td></tr>");

}





function getFotoIcona($paz,$h,$alt)
{

 if (Session("antiprof"))
         return "PHPUF�";

	  $temp = "<img src='$paz' alt='$alt' align='Center' ";
	   if ($h>0)
	           $temp.="height=$h";

		   return $temp.">";
		   }


function scriviTabellaInscatolataBellaBeginVarianteConIcona($titolo="NESSUN TITOLO, ERRORE!!!",$variante,$pazicona,$haltezza=35) {
global $SKIN,$NOMESKIN,$IMMAGINI;
        openTable();
	?>
        <table class='scatolabella' >
	 <tr>
	  <td >
           <b><?php  echo $titolo?></b>
	  </td>
	  <td align="right">
	   <?php  echo getFotoIcona("$IMMAGINI/".$pazicona,$haltezza,$variante);?>
	  </td>
	 </tr>
	</table> 
<?php 
}

															



function formScelta3($label,$chiave1,$chiave2,$c3,$scritta1,$scritta2,$s3,$n_selez_iniziale) {
 scrivi("\n  <input type='radio' ");
 	if ($n_selez_iniziale==1)
		scrivi("checked"); // checka la checkbox
 scrivi(" name=\"".$label."\" value='".$chiave1."'>".$scritta1."\n");

 scrivi("\n  <input type='radio' ");
 	if ($n_selez_iniziale==2)
		scrivi("checked"); // checka la checkbox
 scrivi(" name=\"".$label."\" value='".$chiave2."'>".$scritta2."\n");

 scrivi("\n  <input type='radio' ");
 	if ($n_selez_iniziale==3)
		scrivi("checked"); // checka la checkbox
 scrivi(" name=\"".$label."\" value='".$c3."'>".$s3."\n");
}



// se rs � TRUE scirvo TRU, se no scrivo FOLS
function scriviTRUEFALSE($rs,$tru,$fols)
{
if ($rs=="TRUE" || $rs==1)
	{	if ($tru != "")
			scrivi("<b>".$tru."</b><br/>");
	}
else
if ($rs=="FALSE" || $rs==0)
	{	if ($fols != "")
			scrivi("<b>".$fols."</b><br/>");
	}
else 
	scrivi(rosso("errore di valutazione: ".$rs."!!!"));

}


function permutaDataOhYeah($str,$ancheOra=FALSE)
{
global $ISPAL;
# prende una data in formato stringa del tipo:
# 1977-11-21 00:00:00
# e la commuta in:
# 21 Nov 1977.
# usando l'array $mesini[0..11]
# proviamo:

if ($ISPAL) echo rosso("permutaDataOhYeah: pruvegn");
$tmp=strtotime($str);
return $tmp;

}


function datasburaw2k($rs)
{
global $ISPAL;
#if ($ISPAL) echo("<i>pal, datasburaw2k va migliorata x sostenere ate inferiori al 1970...</i>");
#if ($ISPAL)
#	{
#	print (strftime ("%A, in Francese "));
#	setlocale (LC_TIME, "fr_FR");
#	print (strftime ("%A e in Italiano "));
#	setlocale (LC_TIME, "it_IT");
#	print (strftime ("%A.\n")); 
#	}
if (phpdata($rs)==-1)
	return $rs;
return toDataSbura(phpdata($rs));
}

function datasbura($rs)
	{return toDataSbura(phpdata($rs));}


function toDataSbura($d)
{
global $weekkina,$mesini;
// venerd� puoi (1) capire xch� va ottimizzata; (2) ottimizzarla. il passo 1 � + difficile ;-) scherzo.
//echo rosso("data[$d]");
if ($d == -1)
	return "01-01-70 <small><i>(cercate di cambiare sta data, se possibile. se no segnalate il BUG mandando un gms a @BUGS x favore dicendo a cosa � riferita)</i></small>";
$mese=$mesini[date("n",$d)-1]; // mese senza zeri
$giorno = $weekkina[date("w",$d)];
$format = date("\%\s\ j \%\s y",$d); // j � come d ma 1..31 non 01..31
//echo "[sprintf($format,$giorno,$mese);]";
//printf($format,$giorno,$mese);
return sprintf($format,$giorno,$mese);
//return $format;
}


/** 
	trovato in inet 							FILESYSTEM
*/
function showDir($dir="./") {
     echo "dir: " . $dir."<br>\n";
     $handle = opendir($dir);
     while ($file = readdir ($handle)) {
        if (eregi("^\.{1,2}$",$file)) { // salta . e ..
          continue;
     }
     if(is_dir($dir.$file)) {
          showDir($dir.$file."/");
        }
        else {
          echo "file: " . $file."<BR>\n";
        }
     }
     closedir($handle);
}


function getArrayDiFileFromDir($dir)
{
$arr = array();
$i=0;
$handle=opendir($dir);
while($file=readdir($handle))
   if (! eregi("^\.{1,2}$",$file))
	$arr[$i++]=$file;
return $arr;
}


function linkaCumulativoBasatoSuStringa($querystrPaz,$tagliaUltimo,$conTitolo) {
if ($querystrPaz!="")
	{
	if ($conTitolo)
		echo ("<h2>Directoriez precedenti (son o non sono un glande?)</h2>");
	$pazArr=unescape(querystrPaz).split("/");
	$accum="";
	$lung=$pazArr.length;
	if ($tagliaUltimo)
		$lung--;
	for ($iii=0;$iii<$lung;$iii++)
		{if ($accum=="") 
				$accum = $pazArr[$iii];
			else 
				$accum .= "/".$pazArr[$iii];
		echo("<a href='guardafoto_tn.asp?pathbreve=".escape($accum)."'>".$pazArr[$iii]."</a> ");
		if ($iii<$lung-1) scrivi(HTMLEncode(" >>> "));
		}
	}
}

function HTMLEncode($s)
	{return htmlspecialchars($s);}

function scriviln($str)
	{echo "$str\n";}	

function visualizzaThumbPaz($nomepersona,$TRASFERISCI_FILE_OPT=FALSE,$dir="immagini/persone/",$visualizzatutto=false,$MAXFILE=30,$numcolonne=3) {
	global $GETUTENTE,$ISPAL;
	#$dir = "immagini/persone/";
	$handle = opendir($dir);
	$i=0;
	#$numcolonne=5;

	echo "<table width=500><tr>";
	while ($file = readdir ($handle)) 
		if ($i <$MAXFILE ) 	{
			$dim=42;//filesize($file) ;
			if (eregi("^\.{1,2}$",$file)) {  // salta . e ..
				continue;
			}
		if (iniziaPer(strtolower($file),$nomepersona) || $visualizzatutto) { // foto interessante
			$i++;
			thumbino($dir.$file);
			if ($TRASFERISCI_FILE_OPT)
				if (isdevelop())
					echo rosso("trasferisci file (mette sto file al posto della tua foto e la foto nel "
						."nuovo posto: 2 operazioni in una funzione).");
			if ($i % $numcolonne == 0) echo "</tr><tr>";
		}
	}
	echo "</tr>";
	tableEnd();
	closedir($handle);
}


function thumbino($paz,$dim=0,$h=100)
{
echo "<td align='center'><img src='$paz' height='$h'><br/>".basename($paz)."<br/>";
if ($dim>0)
	echo "(".fsize($dim).")";
echo "</td>";
}




function bug($spiegazione)
{global $AUTOPAGINA;
echo rosso("Hai trovato un <b>bug</b>. X FAVORE contatta l'amministratore con la spiegazione '<b>$spiegazione</b>'."
	." X farlo, manda un GMS al gruppo @BUG (sotto <a href='gms.php'>GMS</a>) segnalando le circostanze in cui "
	."la cosa � successa (dati che hai mandato, pagina da cui venivi, ...).Grazie del contributo. intanto loggo la cosa.");
log2("bug: [$spiegazione] in pag[$AUTOPAGINA]","log_bugz.php");
}

function diesql($sql,$motivo="cacchioNeSacciuIo")
{
global $ISPAL;
if ($ISPAL)
	die("SQL diesel andata a male (<i>$motivo</i>): <b>$sql</b>.");
else 
	die("SQL andata a male (<i>$motivo</i>), mi spiace...");
}






function scrivireportcoppia($rs)
{
//echo "coppia"; return;
global $ISPAL,$GETUTENTE,$AUTOPAGINA,$QUERY_STRING;

trtd();
scrivi(getFotoUtenteDimensionata($rs["nome1"],70));
tdtd();
scrivi(getFotoUtenteDimensionata($rs["nome2"],70));
tdtd();
$v1=$rs["voto1"];
$v2=$rs["voto2"];
if ($v1>10) $v1 = $v1/10;
if ($v2>10) $v2 = $v2/10;

$scop1=($rs["scop1"]);
$scop2=($rs["scop2"]);
$bac1=($rs["bac1"]);
$bac2=($rs["bac2"]);

$scop=($scop1 && $scop2);
$bac=($bac1 && $bac2);

scriviCoppia("","<b class=inizialemaiuscola>".$rs["nome1"]."</b> </b>e<b class=inizialemaiuscola> ".$rs["nome2"]);
#if ($v2>100) 	$v2="?!?!?";
$media=($v1+$v2)/2;
if ($media > 10)
	$media="boh! Vedi GdC";

#if ($ISPAL)  		//(IOOO=="palladius") //(IOOO=="mutanga" || IOOO=="palladius")
#	scriviCoppia("Voti",$v1." , ".$v2);
#else

	scriviCoppia("Voto medio",$media);

if ($bac)
	img("bacio2.gif",40);
if ($scop)
	img("scopare3.gif",40);

if ($rs["nome1"]==$GETUTENTE || $rs["nome2"]==$GETUTENTE )
{
tdtd();
formBegin("giocodellecoppie.php");
formhidden("hiddenOPERAZIONE","svota");
$pagIndria=$AUTOPAGINA;
if (querystring("nomeutente") != "") 
	$pagIndria .= "?nomeutente=".querystring("nomeutente");
	// vengo da utente?nomeutente=pippo
	// ps venerdi'! come si fa a mettere in automatico TUTTA la querystring?!?

formhidden("hidden_tornaindietroapagina",$pagIndria);
$isuomo = ($rs["nome1"]==$GETUTENTE);
$votante = $isuomo  ? $rs["idutentevotante"] : $rs["idutentevotato"];
$votato =  $isuomo  ? $rs["idutentevotato"] : $rs["idutentevotante"];
	// se � donna devo invertire perch� il voto su cui checka ha i parametri invertiti (credo)..
formhidden("idutentevotante",$votante);
formhidden("idutentevotato",$votato);
formhidden("nome1",$rs["nome1"]); // inutili!
formhidden("nome2",$rs["nome2"]); // inutili!!!
//formbottoneinvia("svota" . ($isuomo ? "la":"lo") ); // TRUE - - > UOMO
formbottoneinvia("x"); // TRUE - - > UOMO
formEnd();
}
//scriviCoppia("Discrepanza di voto",Math.abs(v1-v2));
//scrivi("copulabilit�: "+rs("scop1"));
trtdEnd();
}










function campo0($sql)
{
$res=mysql_query($sql)

	or diesql($sql,"campo0(): errore query");
$row=mysql_fetch_row($res)
	or diesql($sql,"campo0(): errore fetch_row");
return $row[0];
}
function popolaComboOrdini($ID,$ID_DFLT="Montecristo") // montecristo ovviamente
{
$sql = "select id_ord,nome_veloce,citt� from ordini ORDER BY nome_veloce";
popolaComboBySqlDoppia_Key_Valore($ID,$sql,$ID_DFLT);
}


function approssima2($stringanumerica)
{
return intval(($stringanumerica)*100)/100;
}


function getSex()
	{return Session("SEX");}

function approssima3($stringanumerica)

{
return intval(($stringanumerica)*1000)/1000;
}

function popolaComboUtenti($ID) {
  global $GODNAME;
  $sql="select id_login,m_snome from loginz order by m_snome";
  popolaComboBySqlDoppia_Key_Valore($ID,$sql,$GODNAME);
}

function popolaComboUtentiRegistrati($ID) {
  global $GODNAME;
  $sql="select id_login,m_snome from loginz where m_bguest=0 order by m_snome";
  popolaComboBySqlDoppia_Key_Valore($ID,$sql,$GODNAME);
}



function accertaAdministratorAltrimentiBona()
{global $GETUTENTE,$GODNAME;

	scrivi("<br><i>Attenzione, accerto che tu sia il mio Maestro...</i> \n");

	$chisei=$GETUTENTE;
	if ($chisei==$GODNAME)
		{scrivi("<i>ciuccio ok sei tu, <b>GOD</b>...<br></i>\n");}
	else

		{scrivi(rossone("Mi spiace ma lo sforzo non � abbastanza possente in te per andare"
			." oltre...<br> da questo momento in poi abbasser� l'altezza dei font da 12 pixel<br>"
			."a 12 Angstrom. Perdoneraimi, spero, <u>".$chisei."</u>..."));
		 bona();
		}
}
















function scriviReport_FAQ($rs,$breveFacoltativo="")
{
if ($breveFacoltativo=="breve")
	{// se chiedo breve... x il CERCA
	 scrivi("<td><a href='faq.php?id=".
		$rs["idfaq"]."'>LEGGI</a></td><td>"
		.$rs["domanda"]);
	 return;
	}
scrivi("<b><font size='+1'>".$rs["domanda"]."?!?</font></b><br>");
scrivi(ripulisciMessaggio(stripslashes($rs["risposta"]),TRUE));
scrivi("<br>");
if (isadminvip())
	{
	 formbegin("faq.php");
	 formhidden("hidden_operazione","cancellafaq");
	 formhidden("my_hidden_id",$rs["idfaq"]);
	 formbottoneinvia("cancella faq");
	 formend();
	}
hline(50);
}


function getNomeByTipoAndId($tipo,$id)
{

 if ($tipo=="utenti")
	$sql="select m_snome from loginz where id_login=".$id;
 else
 if ($tipo=="goliardi")
	$sql="select nomegoliardico from goliardi where ID_GOL=".$id;
 else
 if ($tipo=="ordini")
	$sql="select nome_veloce from ordini where id_ord=".$id;
 else
 if ($tipo=="citta")
	$sql="select nomecitta from regioni where id_pseudoid=".$id;
 else
	return "ERR_TIPO_SCONOCIUTO";


// da mettere in un futuro prossimo
// a[i++]="appuntamenti"
// a[i++]="messaggi"
// a[i++]="link"

$result = mysql_query($sql);
$row    = mysql_fetch_row($result);
//scriviContenutoPalnews($row[0],$row[1]);
return $row[0];
}


function popolaComboMandafotoStati($ID) {
	scrivi("\n<select name='".$ID."'>\n");

	#* '00-NEW': Appena creata.
#* '01-ACCEPTED': Accepted. Stil unprocessed - requires a script or a human to move to proper location.
#and move to state 03.
#* '02-DENIED': Not accepted. `Description` should contain the reason. Done.
#* '03-ARCHIVED': Accepted -> moved to proper place. Should disappear from viisble but still remain in archive.

	$a= array(
		"00-NEW",
		"01-ACCEPTED",
		"02-DENIED",
#		"03-ARCHIVED (SOLO PAL!)",
	);
		
	$max=sizeof($a);

	for($i=0;$i<$max;$i++) {
		scrivi(" <option ");
		scrivi(" value='".$a[$i]."'>".$a[$i]);
		scrivi("</option>\n");
	}
	scrivi("</select>");
}



function popolaComboTipoLink($ID)
{
 scrivi("\n<select name='".$ID."'>\n");

 $a= array(
	"NESSUNO",
	"utenti",
 	"goliardi",
 	"ordini",
	"citta"
		);

$max=sizeof($a);
	// DA METTERE IN FUTURO
// "link"
// "messaggi"
//"appuntamenti"
	// MOLTO IN FUTURO
// "pagine sito"
// "foto"
// downloadz...

for($i=0;$i<$max;$i++)
{
	scrivi(" <option ");
	scrivi(" value='".$a[$i]."'>".$a[$i]);
	scrivi("</option>\n");
}
scrivi("</select>");
}

function popolaComboArrayConDefault($ID,$keyz,$valori,$keydefault)
{
#visualizzaarray($keyz);
#echo "OFF";
#visualizzaarray($valori);

scrivi("\n<select name='$ID'>\n");

#while(! ek.atEnd() && ! ev.atEnd())
while(list($i,$chiave)=each($keyz))
  if(list($j,$valore)=each($valori))
	{
	#echo "$i-$j-$chiave-$valore<br/>";
	scrivi("<b>".strval($chiave)."</b>: ".Form(strval($chiave))."<br>");
	scrivi("  <option ");
	if (strval($keydefault)==strval($chiave) || strval($keydefault)==strval($valore))
		scrivi("selected");
	scrivi(" value='$chiave'>$valore</option>\n");
	}
scrivi("\n</select>\n");
}




function popolaComboDignita($ID,$dflt="nobile")
{
 $arr = Array("capocitt�","capoordine","nobile","saio");
 popolaComboArrayConDefault($ID,$arr,$arr,$dflt);
}

function scriviRiga($res,$recSet)
{
$numcampi=mysql_num_fields($res);
scrivi("<table  border=3><center>\n");
scrivi("<tr><td>");





//$numcampi=mysql_num_fields($res);
for ($i=0;$i<$numcampi;$i++)
	{$dato_i= strval($recSet[$i]);
	 if (String($dato_i)=="null")
		 $dato_i= nullToString();
       else if (contiene($dato_i,"UTC")) //data
		{
		 $dato_i="data_scorreggi_ric: ".(($recSet[$i]));
		}
	scrivi(mysql_field_name($res,$i) . "</td><td>" .$dato_i."</td></tr>\n<tr><td>");
	}
scrivi("</td>\n</tr>\n");
scrivi("</center></table>");
}



function scriviReport_Link($rs) {
	global $ISPAL;

	if (! $rs) return;
	#openTable();
	echo "<table border='0' width='100%'><tr><td>";

	$fotolink = $rs["URLlinkFoto"];
	$visualizzafoto =  $rs["m_bfotoattiva"];
	if (strlen($fotolink) > 8 && ($visualizzafoto)) {
		scrivi("<img src='$fotolink' height='30'>");
	}
	scrivi(("<center><b>".bigg($rs["titolo"])."</b></center>"));
	scrivi(getFotoUtenteDimensionataRight($rs["m_sNome"],70));
	scrivi("<table width='100%' border=0 valign=top>");
	scrivi("<tr><td valign=top >");

		# la visualizzao cmq fregandomene del buleano!!!!
	if (strlen($rs["URLlinkFoto"]) > 5) {
		$heightfoto = 70;
		echo "<img src='".$rs["URLlinkFoto"]."' height='70' />";
		echo "<br/> (<a href='". $rs["URLlinkFoto"] ."'>Fotina</a>)\n";
		echo '</td><td valign=top >';

	}
	scriviCoppia('Segnalante', 	$rs["m_sNome"] );
	scriviCoppia('Data', 		dammidatamysql($rs["Data_creazione"]) );

	#scrivi("<div align='left'><i>(buttato su  da <b class=inizialemaiuscola>".$rs["m_sNome"]."</b>, " .(dammidatamysql($rs["Data_creazione"])).")</i></div>");

	$nomeveloce=getNomeByTipoAndId($rs["tipo"],$rs["id_oggettoPuntato"]);
	if ($rs["tipo"]=="NESSUNO")
		$attinenza=("<i><b>Attinenza:</b></i> <b class=inizialemaiuscola>nessuna (link generico)</b>");
	else {
		if ($rs["tipo"] == "goliardi")
			$attinenza=("<a href='pag_goliarda.php?idgol=".$rs["id_oggettoPuntato"]
				."'><b class='goliarda'>$nomeveloce</b></a>, (<b>".$rs["tipo"]."</b>)");
		else if ($rs["tipo"] == "utenti")
			$attinenza=("<a href='utente.php?nomeutente=$nomeveloce'><b class='utente'>$nomeveloce</b></a>, (<b>"
				.$rs["tipo"]."</b>)");
		else if ($rs["tipo"] == "ordini")
			$attinenza=("<b class='inizialemaiuscola' class='goliarda'>$nomeveloce</b>, (<b>"
				.$rs["tipo"]."</b>)");
		else if ($rs["tipo"] == "citta")
			$attinenza=("<b class='inizialemaiuscola' class='citta'>$nomeveloce</b>, (<b>"
				.$rs["tipo"]."</b>)");
		else // dflt:
			$attinenza=("<b class='inizialemaiuscola'>$nomeveloce</b>, (<b>".$rs["tipo"].", ignoto</b>)");
		}
	#scrivi("<i><b>Attinenza:</b></i> $attinenza");
	scriviCoppia("Attinenza",  $attinenza); 
	scriviCoppia("Descrizione",  nl2br(stripslashes($rs["Descrizione"])) ); 
	scriviCoppia("URL",  "<a href='".$rs["URLlink"] ."'>".$rs["URLlink"]."</a>" );
	#scrivi("<b><i>Descrizione:</i></b><br/>");
	#scrivi("<br><div class='fontlink'><font size='-1'>" . nl2br(stripslashes($rs["Descrizione"])) . "</font></div>");
	#scrivi("<br><big><a href='".$rs["URLlink"] ."'>".$rs["URLlink"]."</a></big>");
	if ((getIdLogin() == $rs["id_login"]) || isAdminVip()) {
		 #scrivi("<br><br><h2><a href='linkz.php?cancellaidprofano=".$rs["ID_link"] ."'>[CANC]</a></h2>");
		scriviCoppia ( "Cancella Link (admin Only)" ,  "<a href='linkz.php?cancellaidprofano=".$rs["ID_link"]."'>"
			. getIconcina("Cancella Link (admin only)",'delete.gif',20)
			. "</a>" );
		}
	trtdEnd();
	tableEnd();
	echo "</td></tr></table>";
	}

function getIconcina($alt,$img,$height=25) {
	return "<img src='immagini/iconcine/$img' border='0' alt='$alt' title='$alt' height='$height' />";
}

function popolaComboCittaId($ID,$dflt="") {
	$sql = "select id_pseudoid, nomecitta from regioni ORDER BY nomecitta";
	if ($dflt=="")
		popolaComboBySqlDoppia_Key_Valore($ID,$sql,"Argenta"); // 27 � argenta... :-)
	else
		popolaComboBySqlDoppia_Key_Valore($ID,$sql,$dflt);
}

function popolaComboTipo($tipo,$nomeid)
{
 if ($tipo=="utenti")
	popolaComboUtentiRegistrati($nomeid);
 else
 if ($tipo=="goliardi")
	popolaComboGoliardiConUtente($nomeid);
 else
 if ($tipo=="ordini")
	popolaComboOrdini($nomeid);
 else
 if ($tipo=="citta")
	popolaComboCittaId($nomeid);
 else
 scrivi(rossone("ERRORE, tipo '".$tipo."' non riconosciuto..."));

// da mettere in un futuro prossimo

// a[i++]="appuntamenti"
// a[i++]="messaggi"

// a[i++]="link"

}




function ridirigerai($pagina="")
{
tornaindietro("quando sar� sicuro della mossa, ridiriger� il tutto con RIDIRIGI. X ora ti dico questo cos� ric pu� vedere tutti i cambiamenti x benino. Abbi pazienza",$pagina);
}

function popolaComboTipoAppuntamento($ID)
{
 scrivi("\n<select name='".$ID."'>\n");

















 $a = array (
		"Festa delle Matricole",
	 	"Cena di Apertura",
	 	"Cena di Chiusura",
		"Cena di Compleaano",
		"Altra Festa",
		"Altra cena",
		"Altro"
		 );

for($i=0;$i<sizeof($a);$i++)
{
	scrivi(" <option ");
	scrivi(" value='".$a[$i]."'>".$a[$i]);
	scrivi("</option>\n");
}
scrivi("</select>");
}


function linkancora($str)
{
return "<a href='#$str'>$str</a>";
}


function scriviRecordSetConVirgoleGestori($res)
{
$str="";

if (!$res)
	die("getRecordSetConVirgole su RES nullo...");
/*
	vorrei mA VIENE formattato a uno schifo di roba, con queste x che spezzano la bellezza del libercolo..

if (isadminvip())
	{tabled();
	while ($rs=mysql_fetch_row($res))
		{
		echo "<tr><td>".$rs[1]." </td><td>";
	formBegin("modifica_ordine.php");
	formhidden("my_hidden_id","ID_gest_ordini");
	formhidden("id_gest_ordini",$rs[0]);
	formhidden("OPERAZIONE","CANCELLA");


	formbottoneinvia("X");
	formEnd();
		echo "</td></tr>";
		}
	 tableend();
	}
 else
*/
	{
	while ($rs=mysql_fetch_row($res))
		$str .= $rs[1].", ";
	}	
$str=substr($str,0,strlen($str)-2); // spazio e virgola tolte...
echo  $str;
}


function getRecordSetConVirgole($res)
{
$str="";
//if ($res=="") {return("vuoto");}
if (!$res)
	die("getRecordSetConVirgole su RES nullo...");
while ($rs=mysql_fetch_row($res))
	$str .= $rs[0].", ";
	
$str=substr($str,0,strlen($str)-2); // spazio e virgola tolte...
return $str;
}

function ciocheprecede($frase,$sep)
{//cerca ci� che in frase precede il separatore
if (empty($frase)) return array();


$tmparr=explode($sep,$frase);
$ret="";
if (sizeof($tmparr)>0)
	$ret=$tmparr[0];
//echo "[ciocheprecede($frase,$sep): ($ret)]";
return $ret; // inefficiente ma pulitissimo
}

	// di dflt � mandata da PAL-BOT :-DDD
function sendGms($to,$text,$from=1,$silent=TRUE) {
$datainvio=dammiDatamySqL();
$from=intval($from);
$to=intval($to);

#$msg=addslashes("_by($from)_".$text);
$msg=addslashes($text);
mq	(
	"INSERT INTO gms (data_invio,m_bNuovo,idutentescrivente,idutentericevente,messaggio)"
	." VALUES ('$datainvio',1,'$from','$to','$msg')"
	);
#if (!$silent) echo rosso("msg mandato correttamente direi all'utente numero $to (tbds: gestisci anche nome in stringa)");
}


function scriviAppuntamentiMese($versione,$nmesiavanti) {
$MAX_APPUNTAMENTI=15;
$sql  = "select * from appuntamenti "
	. "WHERE  data_inizio >= curdate() "
	. "AND data_inizio <= DATE_ADD(CURDATE(), INTERVAL ".$nmesiavanti." MONTH) "
	. "ORDER BY data_inizio";

echo "<table border='0'>";
$res=mysql_query($sql)
 or scrivi(rosso("erroreeeeeee ".mysql_error()));

trtd();
scrivi("<div align=right>"); 
$i=0;
$puoCancellare = isAdminVip();		// admin o appuntamento MIO
while ($rs=mysql_fetch_array($res))
  if (($MAX_APPUNTAMENTI--)>0) { // cos� prima o poi muore :D
	$puoCancellareStoEvento = $puoCancellare || $rs["id_login"] == getIdLogin(); // admin o mio 
	$i=1-$i;
	if ($puoCancellareStoEvento) {
		scrivi("<table border=0 width='100%'>");
		tri($i);
		scrivi("<td width='20%'>"); 
		formBegin("modifica_appuntamenti.php");
		formhidden("my_hidden_id",("ID_appuntamento"));
		formhidden("id_appuntamento",$rs["ID_appuntamento"]);
		formhidden("OPERAZIONE","CANCELLA");
		formbottoneinvia("X");
		formEnd();
		tdtd();
	} 
	if ($versione=="mini") {
	  scrivi(htmlSinistra("<a href='modifica_appuntamenti.php?id=".$rs["ID_appuntamento"]."'>".$rs["Nome"]."</a><br>\n"));
	  $cit=($rs["citt�"]);
  	  $cit=! empty($cit);
	  $dat=String($rs["data_inizio"]);
  	  $dat=! empty($dat); 
	  if ($cit || $dat) {
		if ($cit && ! $dat)
		  scrivi(" <div align=right><i>(".$rs["citt�"].")</i><br>\n");
	  	else
	  	    if (!$cit && $dat)
			scrivi(" <div align=right><i>(".toHumanDate(phpdata($rs["data_inizio"])).")</i><br>\n");
	  	    else // ho tutti e due
	  		scrivi(" <div align=right><i>(".$rs["citt�"].", ".toHumanDateGGMM(phpdata($rs["data_inizio"])).")</i><br>\n");
	  }
	  echo " </div>\n";
	}
	if ($puoCancellareStoEvento) {
		scrivi("</td></tr></table>");
	}
  }
tableEnd();
}





function debvar($var)
{
return;
echo "<br/>[DEBPHP: dbagghiamo la $<b>$var</b> che vale '".$$var."'\n";
echo "Mentre ANONIMO vale '$ANONIMO'\n";
echo "Mentre ISANONIMO vale '$ISANONIMO'\n";
echo "Mentre provaric vale '$provaric'\n";
}

function Form($str)
{
return Post($str);

}


function splitta($sep,$frasona)
{
global $DEBUG;
if ($DEBUG)
	echo "[splitto <b>$frasona</b> con <b>$sep</b>";

$tmp= explode($sep,$frasona);
if ($DEBUG)
	echo " vien fuori arr[<b>".sizeof($tmp)."</b>]]";
return $tmp;
}

function nullToString()
	{return "<font class='null'><i>null</i></font>";}


function formtextln($label,$valore_iniziale) {
	if ($valore_iniziale=="null")
		$valore_iniziale="";
	$valore_iniziale = trim ($valore_iniziale);
	scrivi($label.": <input type='text' name='".$label."' size='25' value='".$valore_iniziale."'><br>\n");
}


function scriviCoppia($titolo,$frase,$TRATTAVUOTOCOMENULL=FALSE) { 
if (empty($frase)) 
	if ($TRATTAVUOTOCOMENULL)
		$frase = nullToString();
	else 
		return;
if ($frase=="TRUE")
	$frase= "si'";
if ($frase=="FALSE")
	$frase= "<a font color='red'>no</a>";
if ($frase=="null")
	$frase= nullToString(); //"<i>null</i> (raro oramai <img src='immagini/2.gif'>)";
if ($titolo=="")
	scrivi("<b>$frase</b><br>");
else
	scrivi($titolo.": <b>$frase</b><br>");
}


function Post($str)
{
if (empty($_POST[$str])) return "";
return $_POST[$str];
}

function getMemozByChiave($str)
{

$rs=mysql_query("select valore from xxx_memoz where chiave like '$str'");
if ($row = mysql_fetch_row($rs))

	if (isset($row[0]))
		return $row[0];

return "ERRORE";
}


function sqlCercaLoginNameById($id)
{
	obsoleta("sqlCercaLoginNameById � una funzioen TRPPO IDIOTA...");
	return "select m_snome  from loginz where id_login=".$id;
}



/** in futuro qui mi dar� facilit� di debug e toglita di NOTICEs... */
function getRiga($result)
{
$riga=mysql_fetch_row($result);
return $riga;
}





function esisteFile($paz)

{

/*
$esiste=TRUE;
$fp =fopen("$paz","r")
	 or $esiste= FALSE;
if ($esiste)
	fclose ($fp); 
return $esiste;
*/
return is_readable($paz);
}

function isArray($arr)
{return gettype($arr)=="array";}

function scriviRecordSetConDelete($res,$sql,$DISABILITA_CANC=FALSE,$arrIntoccabili="nisba")
{
 global $ISPAL;
# scrivid(rosso("Metti un link su ogni cella con select * from TABELLA where NOMECOLONNA=NOMECE"
#	."LLA... serve x i doppioni..."));

$COLORE1 = "CCFFCC"; // "EBFEFE" 
$COLORE2 = "AAFFAA"; // "FFFFD9"

if (isarray($arrIntoccabili))
	echo rossone("SI!!! mi hai passato un array di attributi intoccabili! realizziamolo!!!");

	// calcolo il nome della tabella dato l'sql (banalmente cerco la prima 
	// parola dopo il FROM sperando sia giusto cos�!

$sqlStr=strtolower($sql);

if (empty($sqlStr))
	{echo ("ATTENZIONE: la stringa SQL � nulla: Mi attendo che <i>scriviRecord"
		."SetConDelete</i> non funzioni bene coi modifica e cancella<br>");
	}
if ($ISPAL)
	{scrivib("sql vale: '".$sqlStr."'");}

$taglio=strpos($sqlStr,"from")+5; // autoinferisco la tabella: "blah blah blah FROM <TABLE> ..."
$posInvio=intval(strpos($sqlStr,"\n",$taglio));
$posSpazio=intval(strpos($sqlStr," ",$taglio));
$spazio=min($posSpazio,$posInvio); // argh, non funziona +!!! argh!!!!
if ($posInvio==0  && $posSpazio>0)
	$spazio = $posSpazio;
if ($ISPAL)
	echo "taglio,spazio: $taglio,$spazio (min tra $posSpazio e $posInvio).";
//if ($spazio == -1)  versione java
if ($spazio == 0)
	$spazio=strlen($sqlStr);
#$tabella=substr($sqlStr,$taglio,$spazio);
$tabella=substr($sqlStr,$taglio,$spazio-$taglio);

	// se termina con invio devo togliere invio... (13 e 10)
 if (($pos=strpos($tabella,'\n')) !== FALSE) // da esempio php sul manualozzoo..
	{$tabella = substring($tabella,0,$pos-1);}
// se contiene spazi devo toglierglieli.... tipo "NOMETABELLA AS N, TAB2 AS T WHERE..." ----> "NOMETABELLA"
 if (strpos($pos,' ') !== FALSE)
	{$tabella = substring($tabella,0,$pos);}
if ($ISPAL)
	echo ("tabella vale: '$tabella'");

/*
try{
scrivid(rosso("<br>stato: <b>"+rs.State+"</b>"));
}catch (e){scrivi(rosso("probl con STATE: esco"));return;}
if (rs.State==0)
{
scrivi(rosso("[lo stato � <i>closed</i>,tabella vuota, magari era una insert/update?!? Speriamo!!!]"));
return;
}
*/
if (isdevelop())
	echo rosso("metti qualcosa x dedurre se lo stato della query � closed (tipo insert o update o delete) "
		."o di select: in prima appreossimazione � mysql_num_rows, ma non � esatto, poich� una select po"
		."trebbe dare come risultato una cosa vuota...");
tabled();
scrivi("<tr class='tabhomeintestazione'><td><b>Canc/Edit</b></td>\n");
scriviRsIntestazione($res,FALSE);
$i=0;
while ($rs=mysql_fetch_array($res))
	{$i++;
	 $name=mysql_field_name($res,0);
	 scrivi("\n<tr class='tabhome".(($i%2 ? "pari" : "dispari"))."'>\n <td>");
	 if ($DISABILITA_CANC)
		echo "NO CANC!";

	 else 
		{
		 scrivi("<form name='cancella_".$rs[0]."' action='powerquerysql.php' method='POST'>");
		 formhidden("my_hidden_id",$name);
		 formhidden("my_hidden_val",$rs[0]);
		 formhidden("hidden_1",44);
		 formhidden("tabella",$tabella);
		 formbottoneinvia("Cancella ".$rs[0]);
		 scrivi("</form>\n");
		}

	 scrivi("<form name='modifica_".$rs[0]."' action='powerquerysql.php' method='POST'>");
	 formhidden("my_hidden_id",$name);
	 formhidden("my_hidden_val",$rs[0]);
	 formhidden("hidden_1",45);	// modifica
	 formhidden("tabella",$tabella);
	 formbottoneinvia("modifica ".$rs[0]);
	 scrivi("</form></td>\n");
	 scriviRsRecordSingolo($res,$rs,FALSE);
	 scrivi("\n</tr>\n");
	}
tableEnd();
}



function scriviRsRecordSingolo($res,$rs,$tuttoTraTR)
{
global $ISPAL,$IMMAGINI;
$campo="sticazzi";

if ($ISPAL && 0) 
	{
	 echo rosso("res vale: '$res' [tipo: ".gettype($res)."]");
	 if (gettype($res) == "array")
		visualizzaarray($res);
	}
$numCampi=mysql_num_fields($res);
#$encoded = Array($numCampi);
#$rs=mysql_fetch_row($res);

#echo rosso("tbds");
#return;

if ($tuttoTraTR)
	scrivi("<tr>");
for ($i=0;$i<$numCampi;$i++) {
	$campo=$rs[$i]; 
	echo "<td>";
	$nome=mysql_field_name($res,$i); 
	if (contiene($nome ,"media_")) {
		 $fl=intval($campo*100)/100;
		 echo $fl;
		}
	else
	if (contiene($nome,"_foto"))
		 echo("<img src='$IMMAGINI/persone/$campo.jpg' height='50'>");
	else	// default
		echo $campo;

#	if ($encoded[$i]) 	// aggiungi!!
#		scrivi("<br>".corsivoBluHtml(unescape($campo)));
	scrivi("</td>");
	}

if ($tuttoTraTR)
	scrivi("</tr>\n");
}



function EOF($result,$arr="")
{
//$vuot= empty($arr[0]);
//$vuot =  (mysql_num_rows($result) < 1);
if((mysql_num_rows($result)))
	$vuot =  (mysql_num_rows($result) < 1);
else	
	$vuot= FALSE;
//echo $vuot ? "{e[".mysql_num_rows($result)."]}" : "{full}";
if ($vuot) echo "{e[".mysql_num_rows($result)."]}";
return $vuot;
}

function scrivie($str)
{
echo("<br><br><big class='erore'>[erore:] ".$str."</big><br>");
}


function random($max)
{
$ret=rand(1,$max);
return $ret;
}


	/*
		Le 3 funzioni sull'applicazione. x ora serializzano, ma mi sembra inutile x il futuro... RIC
	*/
$pazApplication="application/_pvt_";
$pazApplication="var/state/app_";
$APPSERIALIZZA = FALSE;

function appendApplication($key,$valApp)
{
global $pazApplication,$APPSERIALIZZA ;

$fp =fopen($pazApplication."$key.txt","a")
	 or die("No c'� il file in appenditura relativo all'App($key)!!!\n");








if ($APPSERIALIZZA)
 	die(rosso("non posso appendere se c'� serializzazione (a meno che non leggo, deserializzo, sommo e serializzo. alla faccia dell'efficienza! Non che me ne freghi, ma quando si parla di leggere FILE cio penso pure (z)io"));

 fputs( $fp, $valApp);

fclose ($fp); 
}





function setApplication($key,$val)
{ 
global $pazApplication,$APPSERIALIZZA ;

setApplicationEnv($key,$val);

$fp =fopen($pazApplication."$key.txt","w")
	 or die("No c'� il file in writtura relativo all'App -$key-!!!\n");

if ($APPSERIALIZZA)
	 $val=serialize($val);

 fputs( $fp, $val);
fclose ($fp); 
}


function scriviReport_GoliardAlboDoro($recSet)
{// vengono usati dati (in RS) su goliardi e ordini...

 $foto="";
 $strFoto="";
 scrivi("<tr>\n");
	 $NomeGolDoppio=snulla($recSet["titolo"])." "	 // titolo tipo S.Ecc.
		.snulla($recSet["Nomegoliardico"])." ".snulla($recSet["Nomenobiliare"]);
	 scrivi("  <td><b>".big($NomeGolDoppio)."</b><br>\n");
	 scrivi("<i>(".snulla($recSet["Nome"])." ".snulla($recSet["Cognome"]).")</i></td>\n  <td>");
		/////////////////////////// 
		// FOTO personale
	 $foto=($recSet["foto"]);
	 scrivi("<a href=\"pag_goliarda.php?idgol=".$recSet["ID_GOL"]."\">");
	 scrivi("<center>" . getTagFotoPersonaGestisceNullfast($foto,80)."</a></td>\n  <td></center>");
	scrivi(bigg(getRomano(intval($recSet["eventuale_numero_progressivo"]))));
	scrivi("</td>\n</tr>\n"); //<tr>\n  <td>");
}



function getApplication($key="eroreKeyNulla")
{
global $pazApplication,$APPSERIALIZZA ;
$erore=FALSE;
if ($key=="utentiattivi")
	obsoleta("getApplication","la funzione � obsoleta sul campo 'utentiattivi': non "
		."funziona come in asp, anzi diciamo che non funziona proprio!");
	// dice in INET che in winzoz ci vuole la B x leggere file binary, bah!
$fp =fopen($pazApplication."$key.txt","rb") 
	 or $erore=TRUE;
if ( $erore) {
	echo(rosso("Non c'era il file relativo alla variabile di applicazione <b>$key</b>, lo creo!!!\n"));
	$fp =fopen($pazApplication."$key.txt","w")
 		or die("non riesco a touchare il file $key.txt; non e' che magari manca la directory '$pazApplication'?!?");
	$fp =fopen($pazApplication."$key.txt","r")
		or die("socmel non si vuol lasciar proprio creare sto cazzo di file...");
}	
$b = fgets( $fp, 100000 )
	or $b="";
if (!feof ($fp)) 
	scrivi(rosso("Attenzione, admin! nel file ce n'� ancora di roba!!!"));
fclose ($fp); 
if ($APPSERIALIZZA)
	 $b=unserialize($b);
return $b;
}



/*
Esempio 19-1. Leggere il titolo di una pagina web remota
$file = fopen ("http://www.example.com/", "r");
if (!$file) {
   echo "<p>Impossibile aprire il file remoto.\n";
   exit;
}
while (!feof ($file)) {
   $linea = fgets ($file, 1024);
   // Funziona solo se title e i relativi tag sono sulla medesima riga 





   if (eregi ("<title>(.*)</title>", $linea, $out)) {

       $title = $out[1];
       break;
   }
}

fclose($file);


ESEMPIO BIS che fa chat su file:

$numLines = 20; $filename = "text.php"; 
//read whole file 
$fileArr = file($filename); 
//open file and truncate to zero 
$fp = fopen($filename,"w+");
 //write 20 lines of old file to new file 
fputs($fp,array_slice($fileArr,0,$numLines);
 //format $message 
//write message to file 

fputs($fp,$message); 
//close file 
fclose($fp); 
*/


function getFotoUtenteDimensionataRightNuovoFrame($utente,$dim,$togliestensione=FALSE)
{
global $paz_foto_persone;
if($togliestensione) // comportamento anomalo
	$foto=$utente;
  else
	$foto=$utente.".jpg";
$temp = "\n<img src='".$paz_foto_persone.$foto."' alt='".$foto."' align='right' border=0 ";
 if ($dim>0)
	$temp.="height=".$dim;
return    "<a href='utente.php?nomeutente=".$utente."' target='_blank'>".$temp.">\n</a>\n";
}



function getFotoUtenteDimensionataRight($utente,$dim,$togliestensione=FALSE)
{
global $paz_foto_persone;

if($togliestensione) // comportamento anomalo
	$foto=$utente;
  else
	$foto=$utente.".jpg";
$temp = "\n<img src='".$paz_foto_persone.$foto."' alt='".$foto."' align='right' border=0 ";
 if ($dim>0)

	$temp.="height=".$dim;
return    "<a href='utente.php?nomeutente=".$utente."'>".$temp.">\n</a>\n";
}



function formSondaggi($veloce)
{
$result=mq("select id_poll,titolo from polls_titoli WHERE datafine>=now() order by datacreazione desc");
if  ($rs = mysql_fetch_array($result))
	{
	 #scriviTabellaInscatolataBellaBeginVariante("Sondaggio del Giorno: <i>".$rs["titolo"]."</i>.");
	 scriviTabellaInscatolataBellaBeginVarianteConIcona("Sondaggio del Giorno: <i>".$rs["titolo"]."</i>.","sondaggi","icone/sondaggi.gif");
	 tabled();
	  scrivi("<tr><td>");
	   visualizzaReport_PollTitolo($rs["id_poll"],$veloce);
	   visualizzaReport_PollCorpo($rs["id_poll"],$veloce);
	  scrivi("</td></tr>");
	 tableEnd();
	 scriviTabellaInscatolataBellaEnd();
	}
}




function escape($x)
{return urlencode($x);}

function visualizzaArray($arr)
{
if (is_array($arr))
{
while(list($k,$v)=each($arr))
	{echo "<b>$k</b>: $v<br/>";}
}
else	{echo "<b>$arr</b>: non � un array.<br/>";}
}

function visualizzaArrayMini($arr)
{
obsoleta("chiama la visualizzaArray e basta, � + veloce da digitare!!!");
if (is_array($arr))
{
while(list($k,$v)=each($arr))
	{echo "<b>$k</b>: $v<br/>";}
}
else	{echo "<b>$arr</b>: non � un array.<br/>";}
}




function isAdmin($who="")
{if ($who=="")
	return Session("ADMIN");
// se no ha un nome
$sql="select m_bAdmin from loginz where m_snome='$who'";
 //echo "sql vale: '$sql'";
 $res=mysql_query($sql);
 $row=mysql_fetch_row($res)
	or die("utente $who non trovato nel db!");
 return $row[0];

}

function isGod(){
global $ISPAL;
	return $ISPAL;
}









function isAdminVip($who="") {
 global $arrAdminVip;
 if ($who != "") { // meno protezione, non su di me ma su un altro...
	 return in_array($who,$arrAdminVip);
 }
 if (! Session("powermode")) return FALSE;
 if (! isAdmin())return FALSE;
 if (isGod()) 
	return TRUE; 
 $user= Session("nickname") ;
	 # prova anche return in_array($who,$arrAdminVip);
 return $user == "cavedano" || $user == "pariettus" || $user == "manolus" || $user == "gimmigod" || $user=="vipera" || $user=="ophelia" || user== "palo" || user== "pal-bot" ;
}




function isdevelop($who="") {
 if ($who=="")
	$who=Session("nickname"); // io
 global $arrDevelop ;
 return in_array($who,$arrDevelop );
}

function debugTipiutenti()
{
scrivib("ora faccio una query su TUTTI gli utenti del sito e ti dico se sono admin, e cos� via! � lunga ma ogni tanto � utile! x chi conosce AI � di tipo generate and test..");



//$res=mysql_query("select * from loginz where m_bGuest=0 order by m_sNome ");
$res=mysql_query("select * from loginz  order by m_sNome ");


tabled();
while($row=mysql_fetch_array($res))
	{$user=$row["m_sNome"];
	 trtd();
	 echo $user;

	 tdtd();
	 echo intval(isadmin($user));
	 tdtd();
	 echo intval(isguest($user));
	 tdtd();
	 echo intval(isdevelop($user));
	 tdtd();
	 echo intval(isadminvip($user));
	trtdEnd();

	}
tableEnd();

}




function debRiga($result,$row)
{
$lung=mysql_num_fields($result);


echo "<table>";

for ($i=0; $i<$lung; $i++)
	{
	echo "<tr><td>";
	$fieldname=mysql_field_name($result,$i);
	echo "$fieldname</td><td>".$row[$i];	
	echo "</td></tr>";
	}
echo "<table>";
}

function miamail($str){
global $WEBMASTERMAIL;

return "<a href='mailto:".$WEBMASTERMAIL."'>".$str."</a>";	
}




function visualizzaFormz()
{
 global $ISPAL; 
 if ($ISPAL) visualizzaArrayTitolo($_POST,"FORMZ"); 
}

function QueryString($str)
{
if (empty($_GET[$str])) return "";
return $_GET[$str];
}


function log2($str,$fname="log_ingressi.php") {
	global $GETUTENTE,$REMOTE_ADDR,$CONFSITO;
	$paz 		= "var/log/";
	$pazcompleto 	= $paz.$fname;

	$now=dammiDataByJavaDate(time());

	$fp =fopen($pazcompleto,"a"); 
	if (empty($fp))
		{echo "errore di logging... :("; 
		 return;
		}
	# senza data
	$frase_da_loggare = "[$GETUTENTE@".$_SERVER["REMOTE_ADDR"]."] $str";
	fputs($fp,"$now\t".str_pad($_SERVER["REMOTE_ADDR"],17," ").str_pad($GETUTENTE,30," ")."[$CONFSITO] $str\n"); 
	error_log("[log2] $frase_da_loggare" );
	fclose ($fp); 
}





function reportRicorsivoCariche($idord,$result,$hoDiritti)
{
scrivi("\n<table>\n");
while ($row = mysql_fetch_array($result))
{
scrivi("<tr valign=top>\n <td witdh=30>".getFotoReport_Carica($row,$hoDiritti)."</td>\n <td>");
scriviReport_Carica($row,$hoDiritti);
scrivi("\n </td>\n</tr>\n");
scrivi("\n<tr valign=top>\n <td witdh=30></td><td>\n");
ricors_figli_cariche($idord,$row,$hoDiritti);
scrivi("\n </td>\n</tr>\n");
}

scrivi("</table>\n");
}



function scriviReport_Carica($rs,$linkato)
{
/*******************************************
	NATO ORIGINARIAMENTE X ATTIVE HC EW VECCHIE
	var simbolo=(String(rs("HC"))=="TRUE"
				? rosso(getFoto(paz_foto+icona_capoordine,simbolo,-5))
				: (String(rs("attiva"))=="TRUE"

					? rosso("AT")
					: rosso("WC")
				  )
			)
*/		// guarda qua che figata
	$simbolo="";
	scrivi(" <b>");
	if ($linkato)
		scrivi("<a href='modifica_carica.php?id=".$rs["ID_CARICA"]."'>");
	scrivi($rs["nomecarica"]);
	if ($linkato)
		scrivi("</a>");
	scrivi("</b> ".$simbolo." ");
	$note=$rs["note"];

	if ($note!="null" && $note!="")
		scrivi(" (<i>".$note."</i>)<br>");
}



function ricors_figli_cariche($idord,$rs2,$linkato)
{
//$rs2=mysql_fetch_array($res2);
$idcarica=$rs2["ID_CARICA"];
//if (empty($carica)) return "jkl";

scrivi("\n<table>\n");
$sql="SELECT * from cariche WHERE id_ordine=".$idord." AND id_car_STASOTTOA=".$idcarica;
$result=mq($sql); // la sottopostanza
while ($row = mysql_fetch_array($result))
	{
	 scrivi("<tr valign=top>\n <td witdh=30>".getFotoReport_Carica($row,$linkato)."</td>\n <td>");

	  scriviReport_Carica($row,$linkato);
	 scrivi("\n </td>\n</tr>\n");
	 scrivi("\n<tr valign=top>\n <td witdh=30></td><td>\n");
	  ricors_figli_cariche($idord,$row,$linkato);
	 scrivi("\n </td>\n</tr>\n");
	}
scrivi("</table>\n");
}




function getFotoReport_Carica($rs,$linkato)
{global $paz_foto,$icona_capoordine,$icona_manto,$icona_saio;
// echo rosso("rs vale $rs");
// visualizzaarray($rs);

	$dign=$rs["Dignit�"];

	$simbolo="BOH (".$dign.")";

	if ($dign=="capocitt�")
		$simbolo=$icona_capoordine;
	else
	if ($dign=="capoordine")
		$simbolo=$icona_capoordine;
	else

	if ($dign=="nobile")

		$simbolo=$icona_manto;
	else
	if ($dign=="saio")
		$simbolo=$icona_saio;
	else // DEBUG 
		visualizzaarray($rs); //echo rosso("dign vale $dign!!!!!!");
// guarda qua che figata
	$simbolo=getFoto($paz_foto.$simbolo,$simbolo,30);
	return $simbolo;

}





function getTagFotoOrdineGestisceNull($foto)
{
 global $FOTO_NONDISPONIBILE,$paz_foto_ordini;
 $thumb=$foto;
	 if ($thumb=="null")
		$thumb=$FOTO_NONDISPONIBILE;
	 return getFoto($paz_foto_ordini.$thumb,$foto,150);
}
function getdefinizioni($tit,$spiegazione="cazzo guardi stronzo?")
	{ return "<dfn title=\"$spiegazione\">$tit</dfn>"; }

function definizioni($tit,$spiegazione="cazzo guardi stronzo?")
	{ echo getdefinizioni($tit,$spiegazione); }

function ancora($str)
	{return "<a name='$str'>$str</a>";}

function dammiDataByJavaDate($time)
{
return date("Y-m-d H:i:s",$time); // cos� piace a mysql


}

function getmysqldata($time=0)
{
if ($time==0) $time=time(); // a dflt, metto NOW!!!
return date("Y-m-d H:i:s",$time); // cos� piace a mysql
}

function visualizzaArrayTitolo($arr,$tit)
{
scrivib(rosso("<u>$tit</u><br>"));

echo"<table>";
while(list($k,$v)=each($arr))
	{
//	$chiave=$i;
	scrivi("<tr><td><b>".$k."</b></td><td>$v</td></tr>\n");
	}
echo"</table>";

//hline(20);


}

function setSession($str,$val)
{
$_SESSION["_SESS_$str"]=$val;

}


function issetSession($str)
{
return isset($_SESSION["_SESS_$str"]);
}

function setApplicationEnv($key,$val)

{
global $ISPAL,$DEBUG;
if ($ISPAL && $DEBUG) 	echo "setApplicationEnv($key): provalo!";

//apache_setenv("GOLIARDIA_".$key,$val);

//echo "setApplicationEnv DOPO";
}

function appendApplicationEnv($key,$val)
{
apache_setenv("GOLIARDIA_".$key,$_SERVER["_PALL_".$key].$val);
}


function getApplicationEnv($key,$val)
{
return $_SERVER["GOLIARDIA_".$key];
}


function replace($frase,$da,$a) { return ereg_replace($da,$a,$frase); }

/*
function contiene($src,$substr)
{if (strpos($src,$substr)!=FALSE)
 	return TRUE;
 return FALSE;
}
*/

function contiene($str,$substr)
{
$tmp= ereg($substr,$str);
//$tmp= (eregi(strval($str),strval($substr)));
//$tmp= (strpos($str,$substr)>=0) ? 1 : 0;
//if ($tmp)	scrivi("returno la {contiene($str,$substr)}; il risultato � '$tmp'.<br>");
return $tmp;
}
function Session($str)
{
if (empty($_SESSION["_SESS_$str"])) return "";
return $_SESSION["_SESS_$str"];
}


function visualizzaDebug() {
	deltat("visualizzaDebugStart");
	if (! isadminvip())
	{
	 echo rosso("mi spiace, non ti faccio visualizzare il visualizzaDebug()!!!");
	 return;
	}
 $_SERVER["riccardo"]="prova ciao da ric2 interno alla funzione, x forza funziona!!! ehehehe";
 echo (h1("visualizzaDebug()"));

 echo "<table><tr><td valign='top'>";
	 visualizzaArrayTitolo($_POST,"POSTZ"); 
	 visualizzaArrayTitolo($_GET,"GETZ"); 
	 visualizzaArrayTitolo($_ENV,"_ENV"); 
	 visualizzaArrayTitolo($_SESSION,"SESS"); 
 echo "</td><td valign='top'>";
	 visualizzaArrayTitolo($_SERVER,"SERVER"); 
 echo "</td></tR></table>";
 deltat("visualizzaDebugEnd");

}

// icona bug: https://www.utf8icons.com/character/128027/bug
function debugga($s) { global $DEBUG; if ($DEBUG) scrivi("<span class='debug'>🐛 $s</span>\n"); }

function FANCYBEGIN($title) {
	#debugga("FANCYBEGIN");
	echo "<fieldset><legend class='titolothread'>$title</legend>";
	#scrivi("\n<table class='fancy'>\n <tr><td colspan=5>\n  <p class='titolothread'>$title</p></td></tr>");
	scrivi("\n<table class='fancy'>\n ");
}
function FANCYMIDDLE($tit="no_title_tbds") {
	#debugga("FANCYMIDDLE");
	#echo "</td></tr></table><table class='fancyfiglio'><tr><td><p class='titolo'>$tit</p>";
	#echo "</td></tr></table><table class='fancyfiglio'><tr><td>";
	echo "\n\n        <!--- fancy middle: inframmezzo --->\n\n";
}

function FANCYEND() {
	#debugga("FANCYEND");
	#echo "</td></tr></table>"; 
	echo "</table>\n"; 
	echo "</fieldset>\n";
}


function FANCYPROVA1() { echo "PROVA 1<br>"; }

function FANCYBEGINOLD($title) {
global $IMMAGINI; 
$dir= "$IMMAGINI/fancyric/"; 
?>
<div align=left> 
   <TABLE cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD vAlign=top width=2 bgColor=#339999><IMG alt="" 
            src="<?php  echo $dir?>tealtab_topleft1.gif" 
            border=0><BR></TD>
          <TD vAlign=top width=18 bgColor=#339999><IMG alt="" 
            src="<?php  echo $dir?>tealtab_topleft2.gif" 
            border=0><BR></TD>
          <TD vAlign=center align=left bgColor=#339999 height=20><FONT 
            face=Helvetica color=#ffffff size=+1>
	
			<B><?php  echo $title?></B>

		</FONT></TD>
          <TD vAlign=top align=left width=14 bgColor=#339999><IMG alt="" 
            src="<?php  echo $dir?>tealtab_topright.gif" 
            border=0><BR></TD></TR></TBODY>
	</TABLE><!-- End Title Tab --><!-- Main Page -->





    <TABLE cellSpacing=0 cellPadding=0 border=0>




        <TBODY>
        <TR vAlign=top>
          <TD colSpan=6><IMG height=2 alt="" 
            src="<?php  echo $dir?>gradient-teal.gif"></TD></TR>

        <TR>
          <TD bgColor=#339999><IMG height=10 alt="" 
            src="<?php  echo $dir?>spacer.gif" width=2></TD></TR>
        <TR>
          <TD bgColor=#339999><IMG alt="" 
            src="<?php  echo $dir?>spacer.gif" width=2></TD>



          <TD colSpan=3>&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD>

	  <table border="0" width="500"><tr><td>

<?php 
}
function FANCYMIDDLEOLD($tit="no_title_tbds")
{ 
global $IMMAGINI;

$dir= "$IMMAGINI/fancyric/";
?>
	</td></tr></table>

           <IMG height=2 
            src="<?php  echo $dir?>fade-teal.gif" align=bottom 
            border=0> 

	  
	
	<table border="0" width="500"><tr><td>
<?php 
}
function FANCYENDOLD()
{
global $IMMAGINI;


$dir= "$IMMAGINI/fancyric/";
?>

	</td></tr></table>




</TD></TR>



        <TR>



          <TD colSpan=6><IMG height=2 alt="" 
            src="<?php  echo $dir?>gradient-teal.gif"></TD></TR>

        <TR>



          <TD colSpan=6>
            
	  </TD></TR>
	</TBODY></TABLE></P>

<?php 

}





function h1($x) {return "<h1>$x</h1>";}


function h2($x) {return "<h2>$x</h2>";}

function h3($x) {return "<h3>$x</h3>";}

function h4($x) {return "<h4>$x</h4>";}

function h5($x) {return "<h5>$x</h5>";}

function PRE($x) {return "<PRE>$x</PRE>";}

function formBegin($pagina="cuccuruccuccu",$nome="") {
	global $AUTOPAGINA; 
	if ($pagina=="cuccuruccuccu")
		$pagina=$AUTOPAGINA;
	echo "<form method='post' action='$pagina' name='$nome'>\n";
	formhidden("hidden_tornaindietroAUTOMATICOFORM",$AUTOPAGINA);
}




function lineaViola($larg=200) {
?>
	<table border="0" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
	<td valign="top" colspan="2" class="bkg_viola">
		<!--
			<iMg src="immagini/pixel.gif" width="<?php  echo $larg?>" height="2" border="0"></td>
		-->
	</tr>
	</tbody></table>
<?php 
	return 42;
}

function setMessaggioSuccessivo($s)
{
scrivi("\n<input type=hidden name='QWERTY_MSG_PRECEDENTE' value='".$s."'>\n");
}







function invio(){echo "<br/>\n";}

function String($x) {return strval($x);}

function bona() {
$disabilitaIlBona = 0;
invio();
scrivi("\n<br>".
	getdefinizioni(
		"<b>bona l&eacute;()</b>: qualche errore era trovato ;)",
		"That for inchais always resolves it all!For a second inchais it uos inizialli progected in order tu cop uiz disorder "
		."(don nou if iu ghet ze dabbolsens!!!) bat rait nau it bicams an integrant partof ze control flou (zet "
		."dasent min iu'v gat tu control iour eiaculescion, its giast a 'uei of seing' betuin as informatix)"
			  ).
	"...");
if ($disabilitaIlBona)
	{echo "<h2>E il terzo giorno lo script � resuscitato e va avanti a eseguire. Pi� graceful di cos�!</h2>"; return;}
include "footer.php";
exit();
}

function scriviTabellaInscatolataBellaEnd()
{
global $SKIN;

if ($SKIN) {
	closeTable(); 
	return;
}
scrivi("</td></tr></table>"); 
scrivi("</td>\n </tr>\n</table>");
}


	# se abiliti SOLOCAPOSTIPITE, viene una ricerca sui soli 'capi thread'
	# se no va anche sui figli... quindi stampa gli N msg + recenti
function stampaMessaggi($n, $grand,$INSICURO,$SOLOCAPOSTIPITE=1) { 
$sql="SELECT * FROM messaggi m,loginz l"
 ." WHERE m.id_login = l.id_login"
 . ($SOLOCAPOSTIPITE ? " AND m.id_figliodi_msg = 0" : "")
 ." ORDER BY data_creazione DESC LIMIT $n";

$res=mysql_query($sql); 
for ($i=0; $i<$n;$i++)
 if ($rs=mysql_fetch_array($res)) {
   $msgprivato =  ($rs["pubblico"]);
   $linkami= (!$msgprivato);
   #scriviReport_Messaggio($rs,1,0,$i%2+1);
   scriviReport_Messaggio($rs,1,0,$i%2+1);
  }
} 

function scrivirecordset($sql) {
	obsoleta("scrivirecordset � OBSOLETA, usa <b>scrivirecordsetcontimeout</b> con 2 righe in piu' invece...");
	$res=mysql_query($sql);
	if (mysql_num_rows($res)==0) {
		echo "Tabella vuota, non la visualizzo";
	} else
		scrivirecordsetcontimeout($res,20);
}

function scrivirecordset2($sql) {
	obsoleta("scrivirecordset2 � OBSOLETA, vedi codice di <b>scrivirecordset()</b> invece...");
	scrivirecordset($sql);
}


function scriviIntestazioneConTimeout($rs,$righemax=10,$tit="warning: manca titolo2",$desc="nisba2") {
global $IMMAGINI;
scrivi("<table class='recordset' >\n <th colspan='12'>$tit");
$heightFotoPersone = 28;
$EOF = ! $rs;
if ($desc != "")
        scrivi("<br/><span class='descrizione'>$desc</span>");
scrivi("</th>");
if ($EOF) {
        scrivib("<tr><td class='notefinetabella'>La query non ha prodotto risultati (o c'era un errore)</td></tr></table>");
        return;
}
$row = mysql_fetch_row($rs);
if (! isset ($row)) {
         scrivib("Errore in scriviRecordSetConTimeout, secondo me la query non � di select");
         return 0;
}
$ncolonne=mysql_num_fields($rs);
$encoded= array($ncolonne);
scrivi(" <tr class='intestazione'>\n");
                // TITOLI
 for ($i=0; $i<$ncolonne; $i++)
        {$nome=String(mysql_field_name($rs,$i));
         if (contiene($nome,"encoded"))
                {$nome.=corsivoBluHtml(" (decodificato)");
                 $encoded[$i]=TRUE;
                }
         else
                 $encoded[$i]=FALSE;
                 #if (isNull($nome)) $nome="<i>nisba</i>";
                 scrivi("  <td><b><small>".$nome." </small></b></td>\n");
        }

                // CORPO
scrivi(" </tr>\n");
}


function scriviRecordSetConTimeout($rs,$righemax=10,$tit="warning: manca titolo",$desc="") {
global $IMMAGINI, $AUTOPAGINA ;
if (contiene($tit,"warning") && $desc=="") { $desc="Attenzione, Pal ha dimenticato di fare l'upgrade di questa tabella alla nuova versione. Se ne vedi 50 con sto difetto, non dirglielo. Quando invece non ce n'e' quasi piu', allora vuol dire che Pal crede di aver finito. In tal caso, se vedi sto msg MANDAGLI UNA MAIALA. Grazie"; }
$heightFotoPersone = 28;
$EOF = ! $rs;
	# titolo e intestazione
scrivi("<table class='recordset' >\n <th colspan='12'>$tit"); 
if ($desc != "")  
	scrivi("<br/><span class='descrizione'>$desc</span>"); 
scrivi("</th>");
	# se vuoto, lo dico...
if ($EOF) {
	scrivib("<tr><td class='notefinetabella'>La query non ha prodotto risultati (o c'era un errore)</td></tr></table>");
	return;
}
$row = mysql_fetch_row($rs);
if (! isset ($row)) {
	scrivib("Errore in scriviRecordSetConTimeout, secondo me la query non � di select");
	return 0;
} 
$ncolonne=mysql_num_fields($rs);
$encoded= array($ncolonne);
scrivi(" <tr class='intestazione'>\n");
		// TITOLI
 for ($i=0; $i<$ncolonne; $i++)
    	{$nome=String(mysql_field_name($rs,$i));
	 if (contiene($nome,"encoded"))
		{$nome.=corsivoBluHtml(" (decodificato)");
		 $encoded[$i]=TRUE;
		}
	 else
		 $encoded[$i]=FALSE;
		 #if (isNull($nome)) $nome="<i>nisba</i>";
		 scrivi("  <td><b><small>".$nome." </small></b></td>\n");
	}

		// CORPO
scrivi(" </tr>\n");
$j=0;
while (($row)  && $j != $righemax ) {
 $j++; 
 $EOF = ! $row; 
 scrivi(" <tr class='".($j%2 ? "rigapari" : "rigadispari") ."'>\n");  // da 0 1 a 1 2
 for ($i=0;$i<$ncolonne;$i++)  {
   	$campo=String($row[$i]);
 	$fieldname_i = String(mysql_field_name($rs,$i));
	scrivi("  <td>");
		// foto
	 if (contiene($fieldname_i,"_fotoutente"))
		scrivi("<center><a href='utente.php?nomeutente=".$campo."' border='0'><img src='$IMMAGINI/persone/".$campo.".jpg' height='$heightFotoPersone' border='0'></a></center>");

	 else
	 if (contiene($fieldname_i,"_fotogoliarda"))
		scrivi("<center><img src='$IMMAGINI/persone/".$campo."' height='$heightFotoPersone' border='0'></center>");

	 else
	 if (contiene($fieldname_i,"_email"))
		scrivi("<a href='mailto:".$campo."' border='0'>".$campo."</a>");
	 else
	 if (contiene($fieldname_i,"_fotoordine"))
		scrivi("<center><img src='$IMMAGINI/ordini/".$campo."' height='$heightFotoPersone' border='0'></center>");
	 else
	 if (contiene($fieldname_i,"_guest")) {
		if ($campo=="1")
			scrivi("<center><img src='$IMMAGINI/userombrososembraguest.gif' height='$heightFotoPersone'></center>");
		}
	 else
	 if (contiene($fieldname_i,"_data"))
		scrivi("<span class='data'>".$campo."</span>");
	 else	// SONNO
	 if (contiene($fieldname_i ,"_inSonno"))
		{if ($campo==1) 
                        scrivi("<center><img src='$IMMAGINI/icone/sonno.gif' height='$heightFotoPersone'></center>");
		}	
	 else	// SOVRANO
	 if (contiene($fieldname_i ,"_sovrano"))
		{if ($campo==1) 
			 scrivi("<img src='$IMMAGINI/corona30.png' height='$heightFotoPersone '>");
		}	
	 else	// SINGLENESS
	 if (contiene($fieldname_i ,"_single"))
		{if ($campo==1) 
			 scrivi("<img src='$IMMAGINI/semaforoverde.gif' height='$heightFotoPersone '>");
		 else
			 scrivi("<img src='$IMMAGINI/semafororosso.gif' height='$heightFotoPersone '>");
		}	
         else   // NOME ORDINE 
         if (contiene($fieldname_i,"_AAAnomeOrdine")) {
                      scrivi("<a href='modifica_ordine.php?idord=$campo'>$campo</a>: "
			#.$row["id_ord"]
			#." - ".$row[0]
			.".");
                }
         else   // LINKORDINE
         if (contiene($fieldname_i,"_linkOrd")) {
                    scrivi("<a href='modifica_ordine.php?idord=$campo'>link</a>");
         }
         else   // UTENTE (lo loinka e lo colora)
         if (contiene($fieldname_i,"utente")) {
                      scrivi("<a class='utente' href='utente.php?nomeutente=$campo'> $campo</a>");
                }
	 else	// SERIO FACETO
	 if (contiene($fieldname_i,"_serio")) {
		if ($campo==1) // e' serio
			 scrivi("<img src='$IMMAGINI/serio.gif' height='$heightFotoPersone '>");
		 else
			 #scrivi("<img src='$IMMAGINI/faceto.gif' height='$heightFotoPersone '>");
			 echo "<!-- niente immagine -->"; #scrivi("-");
	} else if (contiene($fieldname_i, "_mandafoto_id")) {
		scrivi("<a href='mandafoto2021.php?image_id=$campo'>Foto #$campo</a>");
	} else if (contiene($fieldname_i, "_mandafoto_action")) {
		if (isAdminVip()) {
		scrivi("<a href='pannello.php?opvip=AV2%29+Accetta%2Frifiuta+foto+mandafoto&image_id=$campo'>Prendi decisioni su sta foto nel Pannello #$campo</a>");
		} else {
			echo "non 6 admin"; // non sei admin
		}
	} else if (contiene($fieldname_i, "_base64image")) {
		// https://www.w3schools.com/howto/howto_css_image_center.asp :)
		scrivi(" <img src='$campo' height='80' style='display: block;margin-left: auto;margin-right: auto' />");
	} else if (contiene($fieldname_i, "_foto_status")) { // mandafoto2021
		switch ($campo) {
			case "00-NEW":      img("waiting.png", 40) ; echo "Fase 1. Nessun amministratore ha ancora gestito la tua foto. Chiedi aiuto in chat!"; break;
			case '01-ACCEPTED': img("semaforoverde.gif", 40) ; echo "Fase 2. La foto e stata approvata, ora abbi solo un po di pazienza.."; break;
			case '02-DENIED': img("semafororosso.gif", 40) ; echo "Icona X rossa, e aggiungi CHeck on Description for more" ; break;
			case '03-ARCHIVED': echo "All good. Picture has been succesffuly uploaded. This shouldnt bother you anymore (and probably we should filter this out"; break;
		}
	}
	else {	// DEFAULT!!!
		scrivi(trasformaGenericoCampo($campo));
	}
	if ($encoded[$i]) scrivi("<br>".corsivoBluHtml(unescape(String($campo)))); 
	scrivi("</td>\n");
	}
scrivi(" </tr>\n");
$row=mysql_fetch_row($rs);
}
$numrigheEffettive = mysql_num_rows($rs);
echo("<tr class='notefinetabella'><td colspan=99>Totale: <b>".$j."</b> righe su <b>$numrigheEffettive</b> totali</td></tr>");
echo("</table>\n\n\n");
if ($i>0 && $i<$numrigheEffettive )
	scrividevelop("Hint 4 da Futa: <a href='$AUTOPAGINA?next=$j&tabella=TITOLO'>NEXT $j</a>: 'QUERY che passo x argomento ... LIMIT $j,$j'<br/>");
echo "<br/>\n";
}

function trasformaGenericoCampo($s) {
	if ($s == "null") 
		return "<span class='null'>non disponibile</span>";
	if ($s == "")
		return "<span class='null'>campo vuoto</span>";
	if ($s == "-")
		return "<span class='null'>?</span>";
	return $s;
}

function scrividevelop($body="BODY ASSDENTE ERRORE!!!") {
	if (isdevelop() && development() )
		echo "<div class='develop'>TOGLIMI $body</div>\n";
}




function ridirigi($pag)
{
global $DEBUG;
if (! $DEBUG)
	header("Location: $pag");
else


	echo "<h1>In debug ti fo vedere l porcherie, POI ti ridirigi da solo a <a href='$pag'>$pag</a>...</h1><br/>";
?>

finch� qualcuno non mi insegna come CAZZO si fa un redirect in PHP a met� pagina, che non � banalmente l'uso di hedaer("location.."); 



o si fa cos� bufferizzando l'output  e rimangiandosi tuttol'output prima di header(...) o altrimenti esister� pure un altro modo... AIUTATEMI!
<?php 
 // come cacchio si fa a ridirigere la gente?!? in asp � banale... fare un GOTO a un'altra pagina...
bona(); // mi sembra d'uopo! dopo posson esserci cagate.
}



function gestisciGoliardPointz($id,$n,$USO)
{
global $ISPAL;
$attuali = getGPdaDB($id);
$SCRIVENDO = -4242;
//if ($ISPAL)	 echo rosso("dovrei gestire i GP dell'utente <b>$id</b> (x ora ne ha $attuali), con numero $n, e uso '$USO'. Ma non lo faccio.<br>\n");	 	

		// inizia codice originale
if ($USO== "incrementa")
	 $SCRIVENDO=$attuali+$n;
else
if ($USO== "decrementa")
		 $SCRIVENDO=$attuali-$n;
else
if ($USO== "setta")
	$SCRIVENDO=$NUM;
else 
	{echo rosso("uso $USO non riconocsciuto..ATTENZIONE � UN BUG, segnalamelo!!!"); return; }// non faccion nulla..


// scrivid("valeva $attuali; ora varr�: $SCRIVENDO");

 $rs=mysql_query("update loginz set m_nPX='$SCRIVENDO' where id_login='$id'")
	or die("<h1>Attenzione, non son riuscito ad aggiornarti i PX. Non muore nessuno.<br> Riprova a fare il <a href='login.php'>login</a></h1>");

//$finali = getGPdaDB($id);
//if ($ISPAL)	 echo rosso("ecco. ora ne ha (x ora ne ha $finali), con numero $n, e frase $USO.<br>.\n");	 
}



























function getGPdaDB($idutente)
{
$row=query1("select m_nPX from loginz where id_login='$idutente'")
	or die("utente $idutente non trovato");
return $row[0];
}

function spapla($msg) {
	global $IMMAGINI;
?>
<table bgcolor="#ddddff" width=400>
<tr>
 <td>DEBUG(<?php  echo $IMMAGINI; ?>) <img src="<?php  echo $IMMAGINI; ?>/ricarrabbiato.jpg" height="80"></td>
 <td><center><?php  echo $msg?></center></td>
</tr>
</table>
<?php 
}

function scriviErroreSpapla($msg,$tornaa)
{
global $IMMAGINI;

?>
<table bgcolor="#ddddff">

<tr>
 <td><img src="<?php  echo $IMMAGINI; ?>/ricarrabbiato.jpg" height="100"></td>
 <td><center><?php  echo $msg?><br>torna <a href='<?php  echo $tornaa?>'>indietro</a></center></td>
</tr>
</table>
<?php 

}


function scrivi($a) {echo $a;}
function scrivib($a) {echo "<b>$a</b>";}

function getmicrotime() { 
    $temparray = split(" ",microtime()); 
    $returntime = $temparray[0] + $temparray[1]; 
    return $returntime; 
} 

#function millesimi($n) { return parseInt($n * 10000) / 10000; }
function millesimi($n) { return parseInt($n * 1000000)  ; }

function deltat($titoloEventuale="") {
 global $tInizioPagina,$tIntermedio;
 global $DISABLE_DELTAT_LOGGING; //  = true;
 if ($DISABLE_DELTAT_LOGGING) return; // :)
 $ora=getmicrotime();
 debugga("(dt:$titoloEventuale:".millesimi($ora-$tInizioPagina).")<br>\n");

//echo "/\\";
//return;
}





function unescape($x) {return urldecode($x);}



// $idutentegiaselezionato se non vale zero ha gi� deciso chi scelgiere, quindi non deve tirare un dado...
// non � indispensabile che ci sia...
function formGiocoCoppie($verboso,$eventualeIdUtente=0,$eventualeSesso="F",$votorandom=FALSE)
	{return formGiocoCoppiePersonale($verboso,$eventualeIdUtente,$eventualeSesso,$votorandom);}




function scriviCouplez($sql,$MAXCOPPIEVISUALIZZATE=10)
{
$res=mysql_query($sql) 
	or sqlerror($sql);

scrivi("<center><table>");
$i=0;
while ($rs=mysql_fetch_array($res))
  if ($i < $MAXCOPPIEVISUALIZZATE) // non ottimizzato se guardi: cicla � pi� del dovuto ;)
	{
	scrivireportcoppia($rs);
	$i++;  //postincremento
	}
   else
	{echo "dati eccedenti ($i/$MAXCOPPIEVISUALIZZATE)! Mi fermo..."; break;}


tableEnd();
}



function getLoginRecordSetBySex($sex)
{
obsoleta("inutile, bastya copiarla dove la chiami...");
//qweguest ho aggiunto non-guest: era: sql11 += " where m_bIsMaschio="+($sex=="M");
$sql11="select * from loginz where m_bIsMaschio=".intval($sex=="M")." AND m_bGuest=0";
$res=mq($sql11);
$rs=mysql_fetch_array($res);
return $rs;
}

function getOppositeSex($sex)
{
if ($sex=="F") return "M";
return "F";
}


function randomizzaGiocoCoppie()
{
global $ISPAL;
echo rosso("VOTO A CASO BIS<br/>");
$ismaschio= intval(Session("SEX") != "M"); // � il contrario, ma devi pur votare persone di sesso OPPOSTO!!! ;)
$res=mq("select id_login from loginz where m_bismaschio=$ismaschio AND m_bguest=0");
$n=mysql_num_rows($res);
$rnd=random($n);
// versione ingenua

if (isdevelop()) 
	echo rosso("DEV: attento versione time consuming di posizionamento cursore!!! metti anche che cerchi tra "
			."le sole NON votate... studia mysql...");

for ($i=0;$i<$rnd;$i++)
	$rs=mysql_fetch_row($res);

if ($rs)
	{
	if ($ISPAL)
		echo "<br>PAL: id: ".$rs[0]."; rnd: ($rnd/$n)";
	formGiocoCoppiePersonale(TRUE,$rs[0],FALSE,FALSE);
	}
else
	bug("attenzione, baco in function randomizzaGiocoCoppie()");
}






function formGiocoCoppiePersonale($verboso,$eventualeIdUtente=0,$votorandom=FALSE,$seGiaVotatoScriviCoppia=TRUE) {
	global $ISGUEST,$ISPAL,$CONSTLARGEZZA600,$GETUTENTE,$AUTOPAGINA;
	$sex=getSex();

	if ($ISGUEST) {return; }


	$resStat=mq("select count(*) from giococoppie where idutentevotante=".session("SESS_id_utente"));
	$rsStat = mysql_fetch_array($resStat);
	$sql11="select * from loginz where m_bIsMaschio=".intval($sex=="F")." AND m_bGuest=0"; 
			// scambio F con M e ottengo il getoppositesex()!!!

	$res=mq($sql11);
	$rs=mysql_fetch_array($res); 
	$altri = ($sex=="M") ? "sfitinzie" : "manzi";
	$desinenza= ($sex=="M") ? "a" : "o";
	if ($verboso)
		scrivi("Tu hai votato in tutto: <b>".$rsStat[0]."</b>/<b>".mysql_num_rows($res)."</b> $altri<br>");
	$res=mq("select * from loginz where ID_LOGIN=$eventualeIdUtente AND m_bIsMaschio=".intval($sex!="M")
			." AND m_bGuest=0");
	$rs=mysql_fetch_array($res);
	$lasciaPerdere=FALSE;
	if (! $rs)
		{return ; 
		 scrivi("FINE FILEEEEEEEE!<br>");
		 $lasciaPerdere=TRUE;
		} 
	// guardo se sta persona va bene o � nuova...
	if (! $lasciaPerdere)
	{
	$resEsisteGia=mq("select count(*) from giococoppie where idUtenteVotante=".session("SESS_id_utente")
				." AND idutentevotato=".$rs["ID_LOGIN"]);
	$rsEsisteGia=mysql_fetch_array($resEsisteGia);

	if ($rsEsisteGia[0]>0)
		{//echo "lascio xdere xch� esistegia[0] vale ".$rsEsisteGia[0];
	//	 echo "coppia esiste gia?!?<br>";
		 $VOTOMINIMOXDIECI=10;
		 $VOTOMINIMO=1;
		 $MAXCOPPIEVISUALIZZATE=2;
		 $MYID=session("SESS_id_utente");
		 $SUOID=$eventualeIdUtente;
		 $lasciaPerdere=TRUE;

		 $sql= "select l.m_snome as nome2,\"$GETUTENTE\" as nome1, "

			. "6969 AS voto2, 1 as scop2, 1 as bac2, " 
			. "g1.m_nvoto as voto1,g1.m_bscoperebbe"
			. " as scop1,g1.m_bbacerebbe as bac1"
			. ",g1.idutentevotante,g1.idutentevotato "
			. " from loginz l,giococoppie g1 WHERE l.id_login=g1.idutentevotato "
			. "AND g1.idutentevotato=$SUOID AND g1.idutentevotante=$MYID"; 
		 $sqlButtaViaTutto =  "select l2.m_snome as nome2,l1.m_snome as nome1,"
		. "g1.m_nvoto as voto1,g2.m_nvoto as voto2,g1.m_bscoperebbe"
		. " as scop1,g1.m_bbacerebbe as bac1"
		. ",g2.m_bscoperebbe as scop2,g2.m_bbacerebbe as bac2,g1.idutentevotante,g1.idutentevotato "
		. " FROM giococoppie g1,giococoppie g2,loginz l1, loginz l2 where l1.id_login=g1.idutentevo"
		. "tante AND l2.id_login=g1.idutentevotato AND "
		. "  l2.id_login=".$MYID." AND "
		. " g1.idutentevotante=g2.idutentevotato AND g1.idutentevotato=g2.idutentevotante "
		. " AND (g1.idutentevotante=".$MYID." )";

	echo "gia votato/a!!!";
	if ($seGiaVotatoScriviCoppia)
		scrivicouplez($sql,$MAXCOPPIEVISUALIZZATE);
	}

	$fotosua=(getFotoUtenteDimensionata($rs["m_sNome"],100));

	if (!isset($fotosua))
		{$lasciaPerdere=TRUE;
		 scrivi("WARNING!!! <b>".$rs["m_sNome"]."</B> non � foto-dotat$desinenza! Non te l$desinenza faccio votare. "
			."TI PREGO, QUESTO � un GROSSO ERRORE, manda una mail al Webmaster (<a href='mailto:$WEBMASTERMAIL'>cli"
			."cca qui</a>) che picchier� chi si � permesso di rendere utente questo foto-non-dotato. Grazie.");
		}
	}

	if ($lasciaPerdere) 
		return;

	 ?>
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#e69cbe"><tr><td>
	  <table width="100%" border="0" cellspacing="1" cellpadding="8" bgcolor="#ffffff"><tr><td>
	 <?php 

	if (!$lasciaPerdere)
	{
		//scriviTabellaInscatolataBellaBeginVariante("Vota "+(($sex=="M") ?"una gnocca":"un manzo"),"formgiococoppie");
		//scrivi("<center>");

	scrivi("<h3><center>Vota ".(($sex=="M") ?"una gnocca":"un manzo") ."</h3>");
	scrivi("<table width='$CONSTLARGEZZA600' valign=top>");
	scrivi("<tr valign=top align=center><td>");
	scrivi("<center><i>Che ne pensi di <b>".$rs["m_sNome"]."</b>?!?</i><br><br>");
	scrivi($fotosua);
	scrivi("</td><td>");
	tabled();
	trtd();
	 formBegin("giocodellecoppie.php");
	 formhidden("idUtenteVotante",SESSION("SESS_id_utente"));
	 formhidden("idUtenteVotato",$rs["ID_LOGIN"]);
	 formhidden("sexVotante",SESSION("SEX"));
	 formhidden("hiddenOPERAZIONE","inserisci");
	 $pagIndria = $AUTOPAGINA;
	 if (querystring("nomeutente") != "") 
		$pagIndria .= "?nomeutente=".querystring("nomeutente");
	 formhidden("hidden_tornaindietroapagina",$pagIndria);
	 formhidden("dataVoto",dammiDatamysql());
	 scrivi("Ci andresti a letto?!?");
	tdtd();
	formScelta2("m_bscoperebbe",TRUE,FALSE,"s�","no",1);
	tttt();
	scrivi("Ci pomiceresti?!?");
	tdtd();
	formScelta2("m_bbacerebbe",TRUE,FALSE,"s�","no",1);
	tttt();
	scrivi("Vuoi che il voto rimanga privato?");

	tdtd();
	formScelta2("m_bprivato",TRUE,FALSE,"s�","no",2);
	tttt();
	scrivi("Voto generale");

	tdtd();
	popolaComboNumerilliDecuplicatiCon69("m_nvoto",2,10,69,0.5);

	tttt();
	formtext("commento","");

	tdtd();

	formbottoneinvia("invia");
	trtdEnd();
	formEnd();
	tableEnd();
	trtdEnd();
	tableEnd();
	}
	else if ($ISPAL) {scrivi("ho lasciato perdere ;)");}

				// la tabellina rosa...
			trtdEnd(); 

			tableEnd();
			trtdEnd();
			tableEnd();
	#echo rosso("giococoppieEnd");
	invio();
}

function popolaComboNumerilliDecuplicatiCon69($ID,$low,$hi,$dflt,$step) {
	$dfltVal=intval($dflt);
	if (empty($step))
		$step=1;
	$step *= 10;
	$low *= 10;
	$hi *= 10;
	scrivi("\n<select name='$ID'>\n");
	if ($hi<$low)
		{scrivi(rossone("estremi errati scemo!"));
		 bona();
		}
	for ($i=$low;$i<=$hi;$i+=$step)
	{if ($i==70)
		{$i=69;	// aggiungo il 69...
		scrivi("  <option ");
		if ($i==$dfltVal)
			scrivi("selected");
		scrivi(" value='$i'>".($i/10)."</option>\n");
		$i=70;

	}
	scrivi("  <option ");
	if ($i==$dfltVal)

		scrivi("selected");

	scrivi(" value=$i>".($i/10)."</option>\n");
	}
	echo "\n</select>\n";
}










function corsivoBluHtml($msg)
{
	return "<font color=\"blue\"><i>".$msg."</i></font>";
}


function scriviRsIntestazione($res,$conAncheTR)
{
$encoded = array();
$nfieldz=mysql_num_fields($res);
	// TABLE scrivi("<table border=1 cellspacing=3 cellpadding=3 rules=box>");
if ($conAncheTR)
	scrivi("<tr class='tabhomeintestazione'>");
for ($i=0;$i<$nfieldz;$i++)
    	{$nome=mysql_field_name($res,$i);
	 if (contiene($nome,"encoded"))
		{$nome .= corsivoBluHtml(" (decodificato)");


		 $encoded[$i]=TRUE;
		}
	 else
		 $encoded[$i]=FALSE;
	 scrivi("<td><b>$nome</b></td>");
	}
if ($conAncheTR)

	scrivi("</tr>");
}



function tentaquery($sql,$errMsg="")
{
global $ISPAL;
$erore=FALSE;
mysql_query($sql) 
 or $erore=TRUE;

if ($erore)
	{if ($ISPAL)
		die("errore a esguire l'sql (<b>$sql</b>) [$errmsg].<br>".mysql_error());
	 else
		die("errore a esguire una query di udate/canc/insert: amen ($errMsg).");
	}
return TRUE;
}





function htmlMessaggione($msg)
{
	return "<p><big><font color=\"red\"><b>".$msg."</b></font></big></p>";

}

function rossone($msg) { return "<font class='errorone'><p>".$msg."</p></font>"; }

function hline($percent="")
{
scrivi("<hr width='".$percent."%' size='2' align='center'/>");

}



function deprecata($nome="?!?!?",$motivo)
{
return obsoleta($nome," [ma guarda che pur sta funzione (deprecata(,)) � deprecata!{$motivo}]");

}
function obsoleta($nome="?!?!?",$motivo="")
{
if (isdevelop())
{
	scrivi(rosso("La funzione <b>$nome</b> � obsoleta, non usarla pi�"));
if (! empty($motivo))
	echo rosso(" <i>($motivo)</i>.<br>");
scrivib("x favore segnalalo al webmaster anche solo con un GMS. muciasgrasias<br/>");
}
}

function query($q) {obsoleta("query","chiedilo a sua mamma il xch�"); return getrecordsetbyquery($q);}


function getrecordsetbyquery($sql) {
	obsoleta("getrecordsetbyquery","usa 'query1' x query a riga singola (resituisce gi� la riga) o 'mysql_query' per pi� righe");
	if (contiene($sql,"\["))
		scrivi(rosso(h1("ATTENZIONE, la query '$sql' � asp-old-fashioned! (s)correggila!")));
	if ($sql == -1)
		{echo "<h1>La query che mi hai dato � '$sql': scommetto che nasce da somma di stringhe alla ASP (+ anzich� .). Guardaci, Ric</h1>"; }
	$result = mysql_query($sql)
		or scrivi("Errore mysql_error: <i>".mysql_error()."</i> nella query '$sql'. Ricorda, ho ucciso (<b>die()</b>) x molto meno.<br/>");
	if (! $result)	
		 {echo "mysql query error sulla query <i>'$sql'</i>, so ben me";}
	//echo "<br/>Queri: <i>$sql</i><br>Errno: <i>".mysql_errno($connessione)."</i>";
	//echo "<br/>righe affette: <i>".mysql_affected_rows($connessione)."</i><br>";
	return $result ;
}



function getIdLogin()
{
$nick=Session("SESS_id_utente");
if ($nick=="undefined" || $nick=="")
	return -1;
else
	return intval($nick); // falla ottimizzare a venerdi'




}



function parseInt($x)
{return intval($x);}
#{return 2+$x-2;}





function aggiornaIndirizzi()
{
echo "non li aggiorno gli indirizzi x ora, venerdi'. non offenderti. ciao";
}









function formEnd() { ?></form><?php   }

function getFoto($paz,$alt,$h=80)
{

 if (Session("antiprof"))
	return "[antiprof]"; 

 $temp = "<img src='".$paz."' alt='".$alt."' border='0' align='Center' ";
 if ($h>0)



	$temp.= "height=$h";



return $temp.">";
}



function getImg($foto,$altezza=0)
{
global $IMMAGINI;

$paz_foto = "$IMMAGINI/";
return getFoto($paz_foto.$foto,$foto,$altezza);
}

function img($foto,$altezza="")
{

scrivi(getImg($foto,$altezza));

}





function tableEnd(){

	scrivi("</table>\n");
}	



// la stringa � un array del tipo: 
// palladius@1073678420@M@1
// ophelia@1073654917@F@1

function stampaUtentiFancy($utenti)
{
 global $TIME;
	// Stampo la tabella degli utenti connessi
while (list($i,$utente) = each($utenti))
	{trtd();
	 $dati=explode("@",$utente);
	 $nome=$dati[0];
	 $data=(time()-intval($dati[1]));
	 $minutifa=intval($data/60);

	 $isuser=$dati[3];
	 $colore = ($dati[2]=="M")
			? "#5555FF"  // azzurrino
			: "#FF5555"; // rosino
	 echo"<tr><td class='bkg_tabellina_chat' align='right'>";
	 if ($isuser) echo "<b class='utente'> ";
	  echo "<font color='$colore'> $nome</font>";
	 if ($isuser) echo "</b>";
	 echo "  <i>($minutifa' fa)"; 
	 trtdEnd();
	}

return;

for ($i=0;$i<sizeof($stringa_utente);$i++)
  if ($stringa_utente[$i]!="") {
	$nome = ciocheprecede($stringa_utente[$i],"@");
	$data = time()-intval(ciochepostcede($stringa_utente[$i],"@"));
	scrivi("<tr><td class='bkg_tabellina_chat' align='right'><b class='utente'> ");
	scrivi($nome."</b> <i>(".intval($data/60)."' fa)"); // un bold maiuscolo e un bold semplice.. ;)
	scrivi("</i></td></tr>"); 
  	}
}



function scriviUtentiAttivi()

{
$online = getApplication("online");
 //echo(("debug: online vale '$online'"));

	//sarebbe: ma dopo combaciava con le hline, incredibile... scrivi("<table border='2' width='70' align='right'>")


$stringa_utente = explode("\$",$online);

echo("Ultimi utenti in chat:");

tabled();

stampaUtentiFancy($stringa_utente);

/*
	// Stampo la tabella degli utenti connessi
for ($i=0;$i<sizeof($stringa_utente);$i++)
  if ($stringa_utente[$i]!="") 
	{
	$nome = ciocheprecede($stringa_utente[$i],"@");
	$data = time()-intval(ciochepostcede($stringa_utente[$i],"@"));
	scrivi("<tr><td class='bkg_tabellina_chat' align='right'><b class=utente>");
	scrivi($nome."</b> <i>(".intval($data/60)."' fa)"); // un bold maiuscolo e un bold semplice.. ;)
	scrivi("</i></td></tr>");
  	}
*/
//if ($erore) 	scrivi(rosso("\n<table><tr><td><center><small>Non c'� nessuno in chat al momento (ma guardaci: non mi fido di me stesso in PHP). Ma puoi sempre entrare e fare un ditone...</Small></td></tr></table>"))
tableEnd();
}

function formtexttdtd($label,$valore_iniziale) {
	if ($valore_iniziale=="null")
		$valore_iniziale="";
	scrivi($label.": \n</td>\n<td>\n <input type='text' name='".$label."'  value='".$valore_iniziale."'>\n");
}


function tttt()


	{scrivi("</td></tr><tr><td valign=top>");}


function big($str)
{return "<big>".$str."</big>";}



function mandaMail($to,$from,$subject,$body) {
	global $ISPAL,$MAILFOOTER,$DEBUG,$WEBMASTERMAIL,$MAILNONVA,$AUTOPAGINA,
	$SITENAME,$GETUTENTE,$DFLTSKIN,$DOVESONO, $QGFDP;
	if ($MAILNONVA) {
		if (contiene($AUTOPAGINA,"nuovo_utente")) {
			echo h2(
			 "attenzione, devo mandarti una mail all'indirizzo $to ma il server non pu� mandare mail"
			." quindi facciamo una bella cosa: mandami una mail a <a href='mailto:"
			."$WEBMASTERMAIL'>$WEBMASTERMAIL</a> e informami"
			." di esserti iscrito. di solito rispondo in fretta (a volte pi� delle mail automatiche, giuro!). Cos� ti mando "
			." la tua password 'a mano'. mi raccomando mandami una mail con MITTENTE UGUALE ALLA MAIL DATA NELLA FORM!!! "
			." Io mander� solo a quella mail la pwd x ovvi motivi di sicurezza. Mi dovrai dire che ti sei iscritto/a come"
			." XXX e che vorresti la password, ok? CIao e scusa il disagio."
			);
			die("muoio!");
		} else
			 die(rosso(h2("Attenzione la mail non va (o almeno cos� dice la variabile impostata!), quindi non posso spedire mail "
				."a '$to'. Mi scuso x l'inconveniente, ma ci stiamo lavorando."
				." Per favore, se hai proprio bisogno manda una <a href='mailto:$WEBMASTERMAIL'>mail a"
				."l webmaster</a>, ma <u>solo</u> se � importante."
			)));
	}

	$MAILHEADER="<link href='http://www.palladius.it/goliardia/pagine/skin/$DFLTSKIN/style/style.css'"
			." rel='stylesheet' type='text/css'>"
			."<table border='0'><tr><td bgcolor='#FFFFCC'><i>(Mail inviata automaticamente dal sito $SITENAME, "
			."dall'utente <b>$GETUTENTE</b> per l'utente <b>$to</b></i>)</td></tr><tr><td bgcolor='#FFFFAA''>"
			."";
	$MAILFOOTER = "</td></tr><tr><td bgcolor='#DDFFFF'>\n"
	#		."<br><br><br><br><hr width='80%' size='2' align='center'/><br>"
			."<table><tr><td> "
			#."<img src='http://www.goliardia.it/immagini/persone/palladius2.jpg' height='120'>"
			."</td><td valign='top'>Questa mail � inviata automaticamente dal sito www.goliardia.it<br>Se non la volevi "
			."ricevere, vuol dire che qualcuno si � iscritto dando la <i>TUA</i> mail anzich� la propria."
			." Non dovrebbe comunque capitare pi�, NON � spam. Grazie. Se puoi per� scrivimi ($WEBMASTERMAIL)"
			." per avvertirmi. Questo a me fa molto comodo. Grazie<br><i> $QGFDP</i>"
			."(da $DOVESONO)"
			."</td></tr></table>"
			."</td></tr></table>";
	$MAILHEADER='';	#"(Questa email e' inviata automaticamente dal sito $SITENAME)\n\n";
	$MAILFOOTER = "\n\n  ---\nQuesta mail � inviata automaticamente dal sito www.goliardia.it\nSe non la volevi "
                  ."ricevere, vuol dire che qualcuno si � iscritto dando la <i>TUA</i> mail anzich� la propria."
                  ." Non dovrebbe comunque capitare pi�, NON � spam, fidati di uno che di spam se ne intende. Grazie. Se puoi per� scrivimi a: $WEBMASTERMAIL"
                  ." per avvertirmi. Questo a me fa molto comodo.\n\nGrazie,\n<br><i>    $QGFDP</i>";

	$corpo = strip_tags($MAILHEADER.$body.$MAILFOOTER) ;

	$ret = mail($to, $subject, $corpo, "From: $from\nReply-To: $from\nBcc: palladiusbonton+goliardiabcc@gmail.com\nTo: $to");

	if ($DEBUG || $ISPAL) 	{
		opentable();
		scrivi("<br><big>Mail a <b>$to</b> mandata correttamente caro Pally...</big><br>Body: <i>($body)</i><br>");
		closetable();
	}
	log2("[notice] mandaMail(to:$to,from:$from,subject:'$subject'): Return=$ret");

	return TRUE;
}

function scriviHeader($arr,$viola,$nero,$bianco)
{
global $CONSTLARGEZZA600;
?>
<table cellspacing="0" cellpadding="0" width="<?php  echo $CONSTLARGEZZA600?>" height="20" border="0" class="menuMultiIcona">
<tbody>
<!---
 <tr>
  <td colspan="3" class=bgviola"><imG src="immagini/pixel.gif" height="1" width="<?php  echo $CONSTLARGEZZA600?>" border="0"><br clear="all">
  </td>
 </tr>
--->
 <tr>
<!---
  <td width="1" class=bgviola">
	<Img src="immagini/pixel.gif" height="20" width="1" border="0"><br clear="all">
  </td>
--->
  <td width="<?php  echo $CONSTLARGEZZA600-2?>" class=bgviola">
<?php 
	scrivi("<table width=\"$CONSTLARGEZZA600\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" height=\"20\">");
	scrivi("<tbody><tr>"); 
	for ($i=0;isset($arr[$i]);$i++) {
		echo $arr[$i]."\n";	
	} 
?>
</tr></tbody></table>
  <!---
  <td width="1" class=bgviola>
	<IMg src="immagini/pixel.gif" height="20" width="1" border="0"><br clear="all">
  </td>
  --->
  </tr>
 <tr>
  <!---
  <td colspan="3" class=bgviola><iMG src="immagini/pixel.gif" height="1" width="<?php  echo $CONSTLARGEZZA600?>" border="0"><br clear="all">
  </td>
  --->
 </tr>
 </tbody>
</table>

<?php 
}




function visualizzaReport_PollTitolo($idpoll,$veloce)
{
$res1=mysql_query("select * from polls_titoli t, polls_domande d,loginz l where t.id_poll="
				.$idpoll." AND l.id_login=id_utente_creatore");

$rs1=mysql_fetch_array($res1);

if ($veloce)
	scrivi("<i>".stripslashes($rs1["Descrizione"])."</i>");
else
	{
	 scriviTabellaInscatolataBellaBeginVariante($rs1["Titolo"],"sondaggi");
	 scrivib(stripslashes($rs1["Descrizione"])."</td></tr>");
	 scrivi("<tr><td><i>Creato da <b class=inizialemaiuscola>".$rs1["m_sNome"].
	 		"</b> il ".toHumanDate(time($rs1["dataCreazione"])).
		 	"; scade il ".toHumanDate(time($rs1["dataFine"]))."</i></td></tr>"
		);
	}
}



function popolaComboBySqlDoppia_Key_Valore($LABEL,$sql3,$DFLT_SELECTED)

{
 global $ISPAL;

// if ($ISPAL) ; //



 $res = mysql_query($sql3)

	or die("query non riuscita!");

 $i=0;

 
// scrivirecordsetcontimeout($res);

// return;


 scrivi("\n<select name='".$LABEL."'>\n");
 $numcampi = mysql_num_fields($res);

 while ($recSet3=mysql_fetch_row($res))
	{
	echo(" <option ");
	if   (
		strval($DFLT_SELECTED)==strval($recSet3[0])		// ID DFLT SELEZIONATO
	    		|| 

		strtolower($DFLT_SELECTED)==strtolower($recSet3[1])  // NOME DFLT SELEZIONATO
		) 
	    echo("selected");

	scrivi(" value=\"$recSet3[0]\">".$recSet3[1]);

	if ($numcampi==3) //=!isset($recset[2]))// se va, bene, se no amen! il III arg � fuckoltativo
		scrivi(" ($recSet3[2])");

	echo("</option>\n");
	}
echo("</select>\n");
}


function tornaindietro($frase,$pagina="") {
global $AUTOPAGINA;
if ($pagina=="")
	$pagina=$AUTOPAGINA;
opentable2();
  echo"<a href='$pagina'>";
  img("indietro.gif",30);

  echo"</a>";
  tdtd();
  scrivib(big($frase));
  invio();
  $troncapag = preg_replace("/(\w*)\.(.*)/","\$1",$pagina);
  scrivib("torna indietro a <a href='$pagina'><b>".$troncapag."</b></a>, mona!"); 
closetable2();
}



function popolaComboCitta($ID,$dflt="Bologna")
{
 $sql= "select `nomecitta`,`nomecitta` from regioni ORDER BY `nomecitta`";
 popolaComboBySqlDoppia_Key_Valore($ID,$sql,$dflt);
}


function getAutoDataByForm($label)
{

obsoleta("la funzione <i>getAutoDataByForm</i> � deprecata. Usa una x il php che ho chiamato strafurbescamente  'getautodatabyformmysql'..");
bona();

$gg=String(Form($label."_GG"));
if (empty($gg))
	return "?!?datainesistente'";
$mm=String(Form($label."_MM"));
$aaaa=String(Form($label."_AA"));
return "$gg-$mm-$aaaa";
}

function getautodatabyformmysql($label)

{
//scrivi(rossone("la funzione � deprecata. Usa una x il php che ho chiamato strafurbescamente  'getautodatabyformmysql'.."));

$gg=String(Form($label."_GG")); 	// 7 - - > 07

if (empty($gg))

	return "?!?datainesistente'";
if (strlen($gg)==1)
 	$gg = '0'.$gg;

$mm=String(Form($label."_MM"));
if (strlen($mm)==1) 	$mm = '0'.$mm;
$aaaa=String(Form($label."_AA"));


return "$aaaa-$mm-$gg 00:00:00";
}




function autoAggiornaTabella($NOMETABELLA,$NOME_ID_da_modificare,$pag_in_cui_andare="") {
 global $ISPAL,$DEBUG;

	$i="";
	$sqlForm="";
	$sqlForm = "uPdAtE $NOMETABELLA ";
	$separatore="BOH";
	$cont=0;

	if ($DEBUG) tabled();	

	while(list($chiave,$valore)=each($_POST))
	{	if ($DEBUG) trtd();
	 if ($cont==0) 
		$separatore = "SET ";
	   else 
		$separatore = ", ";
		if ($DEBUG)  scrivi("$chiave</td><td>".Form($chiave)."</td><td>");

	$TIPO=getTipo($chiave);
		if ($DEBUG) echo "$TIPO</td><td>";
	if ($TIPO==$NOME_ID_da_modificare)
		$TIPO .= " (key)";
		if ($DEBUG) tdtd();
	$valore=getNuovoValoreByTipo($valore,$TIPO);
		if ($DEBUG) echo "(new:) $valore</td><td>";
	if ($TIPO != "nascosto")	
		 {$sqlForm .= $separatore . "`$chiave`=$valore "; // ci van le quadre x parole doppie...
		  $cont++;
		 }
		if ($DEBUG) trtdEnd(); 
	}
		if ($DEBUG) tableEnd();	



	$myhiddenid=getHiddenId();

	if ($myhiddenid=="" || $myhiddenid=="''")
		if (isdevelop() or isAdminVip())
			echo rosso("attento ric, hai dimenticato nella form che spara all'autoaggiornamento l'id "
				."my_hidden_id, del tipo formtext('my_hidden_id',42); che io lo matcho. in futuro se v"
				."uoi checka se esiste form(myhiddenid)e basta. sti automatismi non mi convincono a "
				."quest'oira di sera (son quasi le 21!!!)");

	if (substr(strtolower($NOME_ID_da_modificare),0,2) != "id")
		$myhiddenid = "'$myhiddenid'";
	$sqlForm .= " WHERE `$NOME_ID_da_modificare`=$myhiddenid" ;
	if ($ISPAL) echo rosso($sqlForm);
	/////////////// adesso ho la query sql giusta!!!
	$erore=FALSE;

	 mysql_query($sqlForm)
		or $erore=TRUE;
		//die("non riesco a fare la update!");
		
	 if ($erore)
			{if ($ISPAL)
				scrivi(rossone("PAL1: errore a mandare la queri1 (<b>$sqlForm</b>):<br>".mysql_error()));
			 else
				scrivi(rossone("errore a mandare una queri1<br>"));
			}


	if (! $erore)
		{messaggioOkSql("autoaggiornamento","nihil dictu");
		log2("[BOH] autoaggiornatabella (tabella: '$NOMETABELLA', '$NOME_ID_da_modificare'='$myhiddenid')","queryz.log.php");


		 if ($DEBUG)
			{ scrivi("<br>PS IN MODALIt� debug NON ti ridirigo automaticamente, fallo a mano! QUERYSTRING VECCHIA che serve x la redirezione");
			  scrivi(": <br>".Form("hidden_mia_query_string"));

			}
  	        else {
			  if (! empty($pag_in_cui_andare))

				{scrivib("<a href='$pag_in_cui_andare'>");
				 scrivib(rosso("<br><big>torna a $pag_in_cui_andare.</big></a>")) ;
				}

			}
		}
	else
		 bona();
scrivii(rosso("righe affettate dalla queryy: ".mysql_affected_rows().".<br/>"));
}




function visualizzaReport_PollCorpo($idpoll,$veloce)
{
global $IMMAGINI;

echo("<tr><td>");



	// calcola di questo sondaggio i voti x ogni domanda...
$sql= "SELECT d.id_domanda,d.TestoDomanda, count(*) as quanti"

 ." FROM polls_domande AS d, polls_voti AS v"
 . " WHERE d.id_poll=".$idpoll." AND v.id_domanda=d.id_domanda "

 . " GROUP BY d.id_domanda,d.TestoDomanda";

$eofres1 = FALSE;
$resNumerilli=mysql_query($sql);
$res1=mysql_query("select * from polls_domande where id_poll=".$idpoll)
	or $eofres1 = TRUE;


#scrivirecordsetcontimeout($resNumerilli);
#scrivirecordsetcontimeout($res1);
#trtdend();
#return;


$tot=0;


		//if (! EOF($res1))
while ($rsNumerilli=mysql_fetch_array($resNumerilli))
{

//echo rosso("Setto numeriarr[".$rsNumerilli["id_domanda"]." := ".$rsNumerilli["quanti"]);
$numeriArr[$rsNumerilli["id_domanda"]]=intval($rsNumerilli["quanti"]);

	//associa un numero a ogni domanda, ma se � zero il valore non c'�!!!! il join � vuoto...
	//scrivid("assegno a numeriarr di ".rsNumerilli("id_domanda")." il valore ". rsNumerilli("quanti") ." e quindi vien fuori un valore: ".numeriArr[rsNumerilli("id_domanda")]."<br>");
$tot += intval($rsNumerilli["quanti"]);

}


if (!$eofres1)
{
formBegin("votazioni.php");
formhidden("hidden_operazione","voto");
formhidden("id_utente",getIdLogin());


$inizio= TRUE;
$n1="GHJ";
echo("<center><table valign=center>");

while ($rs1 = mysql_fetch_array($res1))
{
 scrivi("<tr valign=center><td valign=center>");
 $inizio=FALSE;

 		//echo rosso("(n1,rs1(domanda)): ($n1,(".$rs1["id_domanda"].")) - ");

 echo("\n  <input type='radio' ");
	// non funziona qua,. devi ammettere che l'array non vada
 	//$n1=$numeriArr[$rs1["id_domanda"]];

	// nuova versione php!

  if (isset($numeriArr[$rs1["id_domanda"]]))
	 $n1=$numeriArr[$rs1["id_domanda"]];

	else 
	 $n1=0;


// questa era la versione ASP
// if (! $n1>0) 	$n1=0;


 echo " name='id_domanda' value='"
		.$rs1["id_domanda"]
		."'>";


		// echo rosso("(n1 DOPO (arr[...]):($n1)<br/>");

 if (! $veloce)
		scrivi("</td><td>");
 $immag= getImg	(
			 $rs1["tipoFoto"]."/".$rs1["Foto"],
			 ($veloce ? 30 : 40)
			);
 if ((($rs1["tipoFoto"])!="niente")) // in tal caso non c'� alcuna foto...
	if (! $veloce)

		 scrivi(

			"<a href='$IMMAGINI/"
			.$rs1["tipoFoto"]
			."/"
			.$rs1["Foto"]
			."'>$immag</a></td><td>"
			);


 if ($veloce)
	 scrivi(" <small>".$rs1["TestoDomanda"]."</small>\n");

   else
	 scrivi(" ".$rs1["TestoDomanda"]." ($n1/$tot)\n"); // il name dev'essere uguale x tutti!!!
  scrivi("</td></tr>\n");
}

scrivi("</tr></table></center>");

invio();











scrivi("<center>");
if (isGuest())
	; //scrivi("NON PUOI VOTARE; sei ospite...");
else
	formbottoneinvia($veloce ? "invia" : "invia voto.");

scrivi("</center>");
formEnd();
scrivi("</td></tr>");
}

else scrivi("vuoto :(");



}



function query1($sql)
{
global $ISPAL;
$ok=TRUE;
$res=mysql_query($sql)
	or $ok=FALSE; //scrivi("ci son problemi nella query: " . ($ISPAL ? $sql : "sql"));

if (! $ok) 
	{if ($ISPAL)
		echo "Errore in QUERY1: <i>".mysql_error()."</i>, sulla query <b>$sql</b>!!!<br>";
	 return FALSE;
	 }
$row=mysql_fetch_array($res);
return $row;
}



function scriviContenutoPalnews($titolo,$contenuto)
{
 global $paz_foto_persone;
	scriviTabellaInscatolataBellaBeginVariante("<b>$titolo</b> (by <i><b>zio Pal newz</b></i>)","messaggi miei vari..");
	scrivi("<table border=0  bgcolor='#FFFFEE'><tr><td>");
  	scrivi("<a href='utente.php?nomeutente='palladius'><img src='".$paz_foto_persone."palladius.jpg' alt='palladius' align='right' border=0 height=60>\n</a>");
	//$contenuto = ereg_replace("\n","<br>",$contenuto);
	$contenuto=nl2br(stripslashes($contenuto));
	scrivi($contenuto);
	tableEnd();
	scriviTabellaInscatolataBellaEnd();
}



function scriviReportGoliardaDefault($nomeutente,$MYLOGIN)
{
global $AUTOPAGINA;
scrivi("<center>");

scrivi("<h1>Il goliarda associato a $nomeutente �...</h1>");

scrivid("<i>(sembra banale, ma non lo �: $nomeutente puoi avere in gestione uno o pi� goliardi, ma con molta probabilit� TU utente cossirpondi a UNO dei goliardi da te registrati. Io ho bisogno di sapere chi � di questi...)</i>");

$rs=query1("select * from loginz where m_snome='$nomeutente'");

if (!$rs) //bona();
	{scrivi("nessun utente di nome '$nomeutente'... returno."); return;}


$SUOIDUTENTE=$rs["ID_LOGIN"];


$id_gol_dflt=intval($rs["id_goliarda_default"]);




if (empty($id_gol_dflt))


	{scrivi("nessun gol dflt... :(");

	 // NON E' STATO DEFINITO UN GOLIARDA DI DEFAULT...

 $sql    = "select count(*) as QUANTI from goliardi g,loginz l"
	  . " WHERE l.m_sNome = '$nomeutente' "
	  . " AND l.id_login=g.id_login ";



 $rs =query1($sql);
 $n=intval($rs[0]);
 if ($n==0)
	{scrivib("<p class='rosso'>Attenzione! Non so associarti come utente a un goliarda... e perdipi� non hai goliardi tuoi... Se non ti � chiara la differenza tra utenti e goliardi (ti posso capire! lo diceva il mio prof di DB di non fare mai tabelle in corrispondenza 1:1! Ma io gliel'ho motivato e mi ha dato ragione (oltre che 30L). Anni dopo gli do ragione io! Se sei sicuro che un goliarda rappresentativo di te non esista gia', crealo (vai sotto gestioni e clicchi su AGGIUNGI)!!!! COsi' facendo, potrai far sapere al mondo in che ordine sei nato, di che colore hai la feluca eccetera</p>");
	}
else
{ $my_id_login = $MYLOGIN;

	scrivib("Ullall� (x citare Manolus)! Non so associare te come utente a un goliarda... i casi sono (n>0) 3:<br>");
	scrivib("<div align='left'><br>1) ");
	 scrivi("La tua persona � tra i goliardi da te gestiti; te ne accorgi perch� a fianco al bottone <b><i>SONO IO CASO 1</B></I> nel menu a tendina ci sei tu...");
	formBegin("modifica_utente.php");


 		scrivi("<center>caso 1: ");
		popolaComboBySqlDoppia_Key_Valore("id_goliarda_default","select ID_GOL,nomegoliardico from goliardi g,loginz l WHERE l.m_sNome = '$nomeutente' AND l.id_login=g.id_login ",$nomeutente);
		formhidden("my_hidden_id",$my_id_login);
		formbottoneinvia("SONO IO (caso 1)");
	formEnd();
	hline(30);
	scrivib("</center>2) ");



	 scrivi("La tua persona NON � tra i goliardi da te gestiti, ma � tra quelli gestiti da altri; te ne accorgi perch� a fianco al bottone <b><i>SONO IO CASO 2</B></I> nel menu a tendina ci sei tu...");
	formBegin("modifica_utente.php");
 	scrivi("<center>caso 2: ");
		popolaComboGoliardi("id_goliarda_default");
		formhidden("my_hidden_id",$my_id_login);
		formbottoneinvia("SONO IO (caso 2)");
		formEnd();

	hline(30);

	scrivib("<div align='left'>3) ");
	 scrivi("La tua persona NON � in nessuno dei due gruppi; in tal caso, se tu <i>sei</i> effettivamente un goliarda, devi prima aggiungere un nuovo goliarda (trovi l'opzione sotto '<b>goliardi tuoi</b>'), che ovviamente sei tu; fatto ci�, la prox volta che caricherai questa pagina, nel menu a tendina ci sarai tu...");
	scrivib("<br>PS. ");
	 scrivi("Attento che se sei nel caso uno, sei x forza anche nel caso due... ma in tal caso usa il bottone uno, ok? Grazie.");
	}
	}
else
{
 $sql    = "select * from goliardi g, ordini o "
	  . " where g.ID_GOL=".$id_gol_dflt
	  . " AND o.id_ord=g.id_ordine ";

 $recSet=query1($sql);
 if (! $recSet) {
	scrivib("NESSUN GOLIARDA: eof..."); #return; 
	}
 openTable2();


  scrivi("<table>");
   scriviReport_GoliardOrdine($recSet,1);

  tableEnd();

 if (isAdmin())
	scrivi("(admin only:) <a href='$AUTOPAGINA?deassocia_id=$SUOIDUTENTE'>DEASSOCIA DA QUESTO GOLIARDA</a>");
 closeTable2();
}
}





function getOrdineConFotoStringByNameThumbConNome($rsCitta,$h="puoessereindefinita")
{


	 $nome  = $rsCitta["nome_veloce"];
	 $thumb = $rsCitta["m_fileImmagineTn"];
	
	 $tmp ="   <a href=\"modifica_ordine.php?idord=".$rsCitta["id_ord"]."\">";
if ($h == "puoessereindefinita")
	$tmp .= getTagFotoOrdineTnGestisceNull($thumb);
else
	$tmp .= getTagFotoOrdineTnGestisceNull($thumb,$h); // palleggio l'indeterminazione, � la mia prima volta, buffo!

	 if ($rsCitta["sovrano"]=="TRUE")
		$tmp .=  bigg($nome);
		else $tmp .= $nome;
	 $tmp .= "</a>\n"; // e nome
return $tmp;
}


function sqlCercaIdByLoginName($name)
{
 obsoleta("sqlCercaIdByLoginName...");
	return "select id_login  from loginz where m_snome='$name'";
}




function getTagFotoPersonaGestisceNullFast($foto,$n)
{global $paz_foto_persone,$FOTO_NONDISPONIBILE;


// scrivi(rosso("questa funzione � deprecata x la lentezza. ditelo al webmaster"));

 
 	 if (empty($foto))
		$foto=$FOTO_NONDISPONIBILE;

	$foto=$paz_foto_persone.$foto;

$temp= getFotoNoBorder($foto,$foto,$n);
return $temp;
}

// in futuro tolgo anche l'ext... a/b/c.d ---> "c"
function toglidireext($paz)
{return basename($paz)." !?!";}



function rs_goliardi_getFotoPersona($rs)

{
 global $FOTO_NONDISPONIBILE;
	 $foto=($rs["foto"]);
	 if (empty($foto))
		{$foto=$FOTO_NONDISPONIBILE;}
return $foto;
}


function snulla($str){
if ($str=="null" )
	return "";


return $str;
}

function rs_goliardi_getNomeGoliardicoCompleto($rs)
	{return snulla($rs["titolo"])." ".($rs["Nomegoliardico"])." ".snulla($rs["Nomenobiliare"]);}
	#{return ($rs["Nomegoliardico"])." ".snulla($rs["Nomenobiliare"]);}
//	{return ("[".$rs["Nomegoliardico"])." ".($rs["Nomenobiliare"])."]";}


// n � l'altezza della foto (0 vuol dire lascia l'originale)
function getTagFotoPersonaGestisceNull($foto,$n)
{global $paz_foto_persone,$FOTO_NONDISPONIBILE,$paz_foto_persone_bis;
 obsoleta(("questa funzione (getTagFotoPersonaGestisceNull) � deprecata x la lentezza. usa getTagFotoPersonaGestisceNullFast instead"));
 $thumb=$foto;
 	 if (empty($thumb))
		$thumb=$FOTO_NONDISPONIBILE;
 $esiste=file_exists($paz_foto_persone.$thumb);
$foto="";

if ($esiste)
	$foto=$paz_foto_persone.$thumb;
else
{// seconda possiblilit�
$esiste=file_exists($paz_foto_persone_bis.$thumb);

if ($esiste)
	$foto=$paz_foto_persone_bis.$thumb;
else
	$foto=$paz_foto_persone.$FOTO_NONDISPONIBILE;
}
$temp= getFotoNoBorder($foto,$foto,$n);
return $temp;
}

function sqlCercaOrdineById($id)

{

 obsoleta ("funz idiota: sqlCercaOrdineById ('select * from ordini where id_ord='.$id;)");

	return "select * from ordini where id_ord=".$id;
}

function sqlCercaFacoltaById($id)
{ obsoleta ("funz idiota: sqlCercaFacolt�ById (esegue: 'select id_facolta,facolta from facolta where id_facolta='.$id) ");
return "select id_facolta,facolta from facolta where id_facolta=".$id;
}




function scriviReport_Goliarda($rs)
{
 global $ISANONIMO,$ISPAL;
 $RSRVD=rosso("<i>riservato</i>");

// echo "la fo domani che ho + tempo, va...<br/>";


	scrivi("<table ><center>\n<tr><td>");

	$nomenonnnullo=$rs["Nomegoliardico"];
	if ($rs["Nomenobiliare"] != "null")
		$nomenonnnullo .= " ".$rs["Nomenobiliare"];
	scrivi(getCoppiaTabella("Nome:",$rs["titolo"]." <b class='goliarda'>$nomenonnnullo</b>"));
	if (! $ISANONIMO)
		scrivi(getCoppiaTabella("Al secolo:",$rs["Nome"]." ".$rs["Cognome"]));
	scrivi(getCoppiaTabella("Data processo:",$rs["DataProcesso"]));
	scrivi(getCoppiaTabella("Ultimo aggiornamento:",$rs["Dataiscrizione"]));

	if (! $ISANONIMO)
	{ 
		scrivi(getCoppiaTabella("email:",($rs["privacy_mail"]) 
				? $RSRVD
				: "<a href=mailto:".$rs["email"].">".$rs["email"]."</a>"
		));
		scrivi(getCoppiaTabella("Numero di Cellulare:",
			($rs["privacy_cell"])
				? $RSRVD 
				: $rs["numcellulare"]));
		scrivi(getCoppiaTabella("Indirizzo:",
				($rs["privacy_address"])
				? $RSRVD 
				: $rs["Indirizzo"]));
	}
	// ordine NUM->NOME
	$sqlOrdine="select * from ordini where id_ord=".($rs["ID_Ordine"]);
	$resOrd=mysql_query($sqlOrdine)
		or sqlerror($sqlOrdine);
	$rsOrd=mysql_fetch_array($resOrd);
	scrivi(getCoppiaTabella("Ordine di nascita:",
		"<b><a href='modifica_ordine.php?idord=".$rs["ID_Ordine"]."'>".$rsOrd[1]."</b>"));
			// login NUM->NOME
	$sql="SELECT m_snome FROM loginz WHERE ID_LOGIN=".($rs["id_login"]);
	$resOrd=mysql_query($sql)
	  or sqlerror($sql);
	$rsOrd=mysql_fetch_array($resOrd);
	scrivi(getCoppiaTabella("Utente che l'ha registrato:",
			"<a href='utente.php?nomeutente=".$rsOrd[0]."' ><b class='utente'> ".$rsOrd[0]."</b></a>"));
	$sql="select id_facolta,facolta from facolta where id_facolta=".($rs["ID_FACOLTA"]);
	$resOrd=mysql_query($sql)
	  or sqlerror($sql);
	$rsOrd=mysql_fetch_array($resOrd);
	$fac=getColoreFeluca($rsOrd[1],"bologna");

	scrivi(getCoppiaTabella("Nome foto",$rs["foto"]));
	$tabella="</td><td border=0 bgcolor='$fac' width=50 height=19>".getImg("feluca100.gif",30);
	scrivi(getCoppiaTabella("Facolt�:",$rsOrd[1]." ".$tabella));
   scrivi("</tr></center></table>");

}





function getColoreFeluca($fac,$cit)
{
global $ISPAL;

$colori = array (
        'blu' => "#08155C" , // 0, blu scuro
	  'nero' => "#111111" , // 1, nero
        'grigio' => "#AAAAAA" , // 2, grigio
	  'rosso' => "#BD2A08" , // 3, rosso
        'giallo' => "#EEEE00" , // 4, giallo
	  'verde' => "#0F4E2F" , // 5, verde
	  'rosino' => "#FFAAAA" , // 6, dflt: rosino
	  'bianco' => "#EEEEEE" , // 7, bianco
	  'bluel' => "#0000CC",   // 8, blu elettrico 
        'arancione' => "#FF6600", // 9, arancione   
        'rossogra' => "#CC0000", // 10, rosso granata 
        'rossoscu' => "#990000", // 11, rosso scuro
        'viola' => "#CC66CC", // 12, viola
        'azzurro' => "#00C8C8", // 13, azzurro
        'vinaccia' => "#C60D65", // 14, vinaccia 
        'celeste' => "#66FFFF", // 15, celeste
        'rossobordeaux' => "##C60D65", // 16, rosso bordeaux
        'amaranto' => "#CC325F", // 17, amaranto 
        'arancione' => "#FF6600", // 17, arancione
        'dfltinutile' => "#FFAAAA" // 17, dflt, inutile
	  );

	 $f= strtolower($fac);
	
       switch ($f) 
		{
         case 'giurisprudenza':
            $out=$colori['bluel'];
            break;

         case 'scemenze politiche':
            $out=$colori['viola'];
            if ($cit=='bologna') $out=$colori['blu'];
            if ($cit=='macerata') $out=$colori['azzurro'];
            break;
         case 'ingegneria':
            $out=$colori['nero'];
            break;
         case 'chimica industriale':
            $out=$colori['nero'];
            break;
         case 'medicina':
            $out=$colori['rosso'];
            break;
         case 'veterinaria':
            $out=$colori['rossoscu'];

            if ($cit=='bologna') $out=$colori['rosso'];
            break;
         case 'economia':
            $out=$colori['giallo'];
            if ($cit=='torino') $out=$colori['grigio'];
            if ($cit=='genova') $out=$colori['grigio'];
            if ($cit=='milano') $out=$colori['rosino'];
            break;
         case 'fisica':
         case 'matematica':
         case 'informatica':
         case 'chimica':
         case 'biologia':
         case 'astronomia':
         case 'agraria':
         case 'geologia':
         case 'enologia':
         case 'biotecnologie':
	    case 'scienze ambientali':


		case 'scienze e tecnologie alimentari':
		case 'scienze naturali':
            $out=$colori['verde'];
            break;
         case 'scienze statistiche':
            $out=$colori['bluel'];
            if ($cit=='bologna') $out=$colori['giallo'];
            if ($cit=='roma') $out=$colori['giallo'];
            break;
         case 'psicologia':
            $out=$colori['grigio'];
            if ($cit=='bologna') $out=$colori['bianco'];
            if ($cit=='padova') $out=$colori['rosino'];
            break;
         case 'pedagogia':
            $out=$colori['grigio'];
            if ($cit=='bologna') $out=$colori['bianco'];
            if ($cit=='padova') $out=$colori['rosino'];
         case 'storia':
         case 'filosofia':
         case 'archeologia':
         case 'cons. beni culturali':
         case 'lettere':
            $out=$colori['bianco'];

            break;
         case 'scienze della comunicazione':
            $out=$colori['bianco'];
            if ($cit=='macerata') $out=$colori['vinaccia'];
            break;
         case 'scienze bancarie':
            $out=$colori['azzurro'];
            break;
         case 'magistero':
            $out=$colori['bianco'];
            if ($cit=='bologna') $out=$colori['rosso'];
            break;
         case 'architettura':
            $out=$colori['nero'];
            if ($cit=='genova') $out=$colori['arancione'];
            break;
	    case 'ctf':	// provata da ric: non sono infallibile
         case 'farmacia':
            $out=$colori['rossogra'];
            if ($cit=='bologna') $out=$colori['verde'];
            break;
         case 'belle arti':
            $out=$colori['celeste'];
            if ($cit=='bologna') $out=$colori['azzurro'];
            break;
         case 'lingue':
         case 'interprete e traduttore':
            $out=$colori['rossobordeaux'];
            if ($cit=='bologna') $out=$colori['amaranto'];
            if ($cit=='macerata') $out=$colori['bianco'];
            break;
         case 'sociologia':
            $out=$colori['arancione'];
            break;
         default:
            $out=$colori['dfltinutile'];
     } 
	return $out;
}





function blu($msg)
{
	return "<font color=\"blue\">".$msg."</font>";
}


function utenteHaDirittoScritturaSuGoliardaById($idgol)
{global $ANONIMO,$GETUTENTE,$ISPAL;
 if ($ISPAL) echo "guardo diritti per il goliarda numero $idgol...";
 $tmp=FALSE;
 if (isAdmin()) return TRUE;
 $ut=$GETUTENTE ;
 if ($ut==$ANONIMO)
	{scrivib("anonimo, no");
	 return FALSE;
	}

 $resu=mq("select id_login  from loginz where m_snome='$ut'");
 $rsu=mysql_fetch_array($resu);
 $id_loginZ = $rsu["id_login"];
 $sql1="SELECT id_login FROM goliardi WHERE id_gol=".$idgol;
 $resu=mq($sql1);
 if (mysql_num_rows($resu)==0)

	{scrivi(rossone("l'idgol $idgol evidentemente non esiste... scemo!"));
	 bona();

	}
 $rsu=mysql_fetch_array($resu);
 if ($rsu["id_login"]==$id_loginZ)
	{scrivid("TU hai creato questo goliarda, maestro... SI<br>");
	 return TRUE;
	}


 $sqlZ = "SELECT count(*) FROM ulteriori_gestioni_goliardiche WHERE id_login=$id_loginZ AND id_gol=".$idgol;

 $resu=mysql_query($sqlZ);
 $rsu=mysql_fetch_row($resu);
 $n=intval($rsu[0]);

 if ($n==1)
	{scrivid("tu non l'hai creato questo goliarda, ma sei in <i>ulteriore gestione</i>... SI");
	 return TRUE;
	}
 if ($n>1)
	{bug(("BRUTTO SCEMO CI SONO DOPPIONI!!! hai questo goliarda in pi� di una gestione!!!"));
	 return TRUE;
	}
 scrivid("neanche qui ce l'hai in gestione, brutto impostore... NO");

 return FALSE;
}






function utenteHaDirittoScritturaSuOrdineById($idord) {
global $GETUTENTE;
#if (isAdminVip()) return TRUE;
if (isAdmin()) return TRUE; # cambiato per succubus il 14 maggio 06.
$tmp=FALSE;
$ut=$GETUTENTE;
// scrivid(rosso("Accerto che tu abbia potere di scrittura per questo Ordine..."));

 if (anonimo())
	{return FALSE;	}
 $res = mysql_query("select id_login  from loginz where m_snome='$ut'");
 $rs = mysql_fetch_array($res);
$id_login = $rs["id_login"];

 $res = mysql_query("SELECT count(*) FROM gestione_ordini WHERE id_ordine=$idord AND id_login=$id_login");
 $rs  = mysql_fetch_array($res);

 if (($rs[0])>0)
	{//scrivid("cell'hai in gestione ordini singoli... SI")
	 //rs.close();
	 return TRUE;
	}

 $res = mysql_query("SELECT count(*) FROM gestione_citta g,ordini o WHERE o.id_ord="
		.$idord." AND g.citt�=o.citt� AND g.id_login=".$id_login);

 $n=$rs[0];

 if ($n==1)
	{//scrivid("non direttamente, ma dato che hai la sua citt� puoi! <i>ule</i>... SI")
	 //rs.close();
	 return TRUE;
	}
 if ($n>1)
	{scrivi(rossone("BRUTTO SCEMO CI SONO DOPPIONI!!! AVVISA UN AMMINISTRATORE SU STO FATTO GRAZIE"));
	 return TRUE;
	}
// scrivid(rosso("NO (n=0 direi)<br>"))


 return FALSE;

}







function scriviReportModificaDirittiUtentiSulGoliarda($idgol,$idlogin="piipo!")
{
global $GETUTENTE,$AUTOPAGINA,$NOMONE;

scrivi("<h1><a name='diritti'>Diritti sul goliarda</a></h1><br>");

#echo rosso("id faciendum terzium non hodie sed proximodie... (idlogin buffamente vale $idlogin)");
#return;


openTable();
scrivi("<center>");

	// devo decidere x poter regalare se � mio....
$resMio=mq("select l.m_snome from goliardi g,loginz l where g.id_gol=$idgol AND g.id_login=l.id_login"); // unico
$rsMio=mysql_fetch_array($resMio);
$emmio= ($rsMio["m_snome"]==$GETUTENTE  || isAdminVip());

if ($emmio)
	{
	if (isAdminVip())
		{scrivi("Anche se non � tuo, � come se lo fosse, caro Admin Vip...");}

	tabled();
	scrivi("<tr><td>");
	scrivi("<h2>Regala <u>$NOMONE</u> a :</h2>");
	scrivi("</td></tr>");
	scrivi("<tr><td>");

	formBegin();
	 formhidden("hidden_operazione","regala utente");
	 popolaComboUtentiRegistrati("id_login");
	 formhidden("id_gol",$idgol);
	 formbottoneinvia("REGALAGLIELO");
	formEnd();
	scrivi("</td></tr>");

	tableEnd();
}
else

	scrivi(rosso("non � mica mio... nihil factu"));
hline(80);

tabled();
scrivi("<tr><td>");
scrivi("<h2>D� in ulteriore concessione <u>$NOMONE</u> a :</h2>");
scrivi("</td></tr>");
scrivi("<tr><td><center>");
 formBegin();
 formhidden("hidden_operazione","condividi utente");
 formhidden("id_gol",$idgol);
 formhidden("hidden_tornaindietroapagina",$AUTOPAGINA."?idgol=".$idgol);
 formtext("note","perch� bisogna condividere la propria felicit� con altri ogni tanto");
 popolaComboUtentiRegistrati("id_login");
 formbottoneinvia("CONDIVIDILO!");
formEnd();
scrivi("</td></tr>");
scrivi("<tr><td>");
scrivi("<h2>Togli una ulteriore concessione gi� esistente di <u>$NOMONE</u> a :</h2>");
scrivi("</td></tr>");
scrivi("<tr><td><center>");
formBegin();
 formhidden("hidden_tornaindietroapagina",$AUTOPAGINA."?idgol=".$idgol);
 formhidden("hidden_operazione","togli concessione");
 popolaComboBySqlDoppia_Key_Valore("my_hidden_id","select u.id,l.m_snome,u.note from logi"
	."nz l,ulteriori_gestioni_goliardiche u where l.id_login=u.id_login AND u.id_gol="
	.$idgol." order by l.m_snome",1);
formbottoneinvia("togliglielo");
scrivi("</td></tr>");
formEnd();
tableEnd();
scrivi("</td></tr>");
closeTable();
}


function scriviReportCursusHonorumById($idgol,$diritti) {
global $ISSERIO; # dice se l'utente e' serio
//                      0       1               2               3                       4
$sql="SELECT o.m_fileImmagineTn as _fotoordine,o.nome_veloce,nomecarica, data_nomina,n.note ,id_ordine as _linkOrd,hc,id_nomina as _linkNomina FROM nomine n, cariche c, ordini o WHERE o.ID_ORD=c.iD_Ordine  $SERIOSTRING AND n.ID_goliarda=".$idgol." ".($ISSERIO ? "AND o.m_bserio=1 " : "")." AND n.id_carica=c.id_carica ORDER BY data_nomina, id_ordine";

$result42=mysql_query($sql)
        or sqlerror($sql);

scriviRecordSetConTimeout($result42,80,"Nomine del goliarda numero $idgol (tabella Ciapas�-compliant)");

echo "<div class=debug>";
scriviReportCursusHonorumByIdOld($idgol,$diritti);
echo "</div >";
}



function scriviReportCursusHonorumByIdOld($idgol,$diritti) {
global $ISANONIMO,$ISPAL,$SERIOSTRING;


//			0	1		2		3			4			
$sql="SELECT dignit�,nomecarica, data_nomina,data_fine_nomina,id_goliarda_nominante,"
//		5	6		7	8	9		10
	."n.note ,id_ordine ,attiva ,hc,id_nomina,eventuale_numero_progressivo FROM nom"
	."ine n, cariche c, ordini o WHERE o.ID_ORD=c.iD_Ordine  $SERIOSTRING AND n.ID_goliarda=".$idgol." AND n.id_carica=c.id_carica ORDER BY id_ordine, data_nomina";

$vecchioid=-5;

$result42=mysql_query($sql)
	or sqlerror($sql);

$result=mysql_query("select id_ordine from goliardi where ID_GOL=".$idgol)
		or sqlerror("select id_ordine from goliardi where ID_GOL=".$idgol);

if ($row = mysql_fetch_row($result)) {	
		if ($ISPAL) erore( "errore: ciclo su una cosa x me fissa: ".$row[0]."<br/>");
		$rs_idord=$row[0];
	}

	$idord_dflt=$rs_idord;

  	scrivi("<h2><a name=\"cursushonorum\"><u>Cursus honorum:</u></a></h2>\n");

	$vuoto= (mysql_num_rows($result42) == 0);
	if ($ISPAL) echo rosso("PAL: boh, non capisco una fava... vuoto vale '$vuoto'.<br>");
	if (! $vuoto) // non vuoto
		scrivi("<table border='0' cellpadding=2><tr><td><ul>\n");
	else 	{tabled();
		 scrivi("<tr><td>".bigg(("<center>Non disponibile.<br>\n")));
		 scrivib("attenzione, per�, tu <i>puoi</i> aggiungere NOMINE al cursus honorum... "
			."<br>ammesso che il Palladio ti abbia dato i diritti sull'ordine da cui vuo"
			."i aggiungere unqa nomina...<br>basta cliccare qua in basso... potrai dotar"
			."e questo goliarda di un dettagliato Cursus Honorum!!!!<br>Prova!!!!</td></tr>");


		 tableEnd();
		}
	scrivi("<ul >");
	$hoDirittiSullOrdineImo=FALSE;

while ($row42 = mysql_fetch_assoc($result42)) {
	$idord=$row42["id_ordine"];
	#if ($row42[" m_bSerio"]) scrivi(rosso("Attenzione, segue un ordine FASULLO"));
	if ($idord != $vecchioid) {
		if ($hoDirittiSullOrdineImo) { // nasco FALSE quindi se QUI vale TRUE, vuol dire che ho appena terminato una tabella con tasto cancella...
		 	scrivid("]]]");
			tableEnd();
		} 
		if ($vecchioid != -5) // tranne la prima volta 
				{   hline(80);  
		} 
		if ($idord>0) {	
			$hoDirittiSullOrdineImo=utenteHaDirittoScritturaSuOrdineById($idord); 		
		}
	scrivi("</ul>");
		 $vecchioid=$idord;


		$sql1="select nome_veloce, m_fileImmagineTn from ordini WHERE ID_ORD=".$idord;

		$result = mysql_query($sql1)
			or sqlerror($sql1);
		$row = mysql_fetch_row($result);
		 scrivi("<li><big><big> ");
		scrivi("   <a href=\"modifica_ordine.php?idord=".$idord."\">");


		  scrivi($row[0]);
		scrivi("</a>\n"); // e nome
		$thumb = $row[1];
		scrivi ("    ".getTagFotoOrdineTnGestisceNull($thumb)." </big></big></li>");
		scrivi("<ul>");
		if ($hoDirittiSullOrdineImo)
			{scrivid("[[[");
		 	tabled();

			}
		}
		// gestisco la fine della nomina...

	$fine=$row42["data_fine_nomina"];
	$fineStr="";
	if (empty($fine))
		{}
	else $fineStr=" --> ".(datasbura($fine));

	$NUM=$row42["eventuale_numero_progressivo"];

	$NUMSTR= $NUM==0 
			? "" 
			: getRomano($NUM);

	$noteeventuali = snulla($row42["note"]);
	if (!empty($noteeventuali))
		$noteeventuali = " (<i>$noteeventuali</i>)";

	if ($hoDirittiSullOrdineImo) {//table()
		  scrivi("<tr><td valign='top'>");
		  formBegin("nomina_canc.php");
		  formhidden("hidden_operazione","cancella_una_nomina42");
		  formhidden("hidden_idgol",$idgol);
		  formhidden("hidden_idord",$idord);
		  formhidden("my_hidden_id",$row42["id_nomina"]);
		  formbottoneinvia("toglila");
		  formEnd();
		  scrivi("</td><td valign='top'>"); 
		  scrivi((datasbura($row42["data_nomina"])).$fineStr.": <b>".$NUMSTR." ".$row42["nomecarica"]."</b>$noteeventuali\n");
		  scrivi("</td></tr>");
	} else {// caso normale
	  scrivi("<li>");
 	  scrivi((datasbura($row42["data_nomina"])).$fineStr.": <b>".$NUMSTR." ".$row42["nomecarica"]."</b>$noteeventuali\n");
	  scrivi("</li>\n");
	}
	}
	if (!$vuoto)
		scrivi("</ul></td></table>");
	if ($hoDirittiSullOrdineImo) { // ultimo caso, se l'ultimo � TRUE devo chiuderlo QUI
		  scrivid("]]]"); 
		  tableEnd();
	}
	if (!$ISANONIMO) {
		 formBegin("nuova_nomina.php");
		 if (isdevelop()) 
			echo rosso("ric, cambia sta combo nei SOLI ordini che il tipo gestisce, admin compresi! cos� scremi.");
		 scrivi("<table border='0'><tr><td><center><b>".blu("Aggiungi una nomina nell'Ordine:")."</b><br>");
		 formhidden("idgol",$idgol);
		 popolaComboOrdini("idord",$idord_dflt); 
		 formbottoneinvia("aggiungi");
		 scrivi("</tr></td></table></form>\n");
		}
}



function popolaComboNumerilliConAlias($ID,$low,$hi,$dflt,$oldVal,$newVal) {
	$dfltVal=intval($dflt); // lo numerizzo
	scrivi("\n<select name='$ID'>\n");
	if ($hi<$low) {
		scrivi(rossone("estremi errati scemo!"));
		bona();
	}
	for ($i=$low;$i<=$hi;$i++) {
		scrivi("  <option ");
		if ($i==$dfltVal)
			scrivi("selected");
		scrivi(" value='$i'>");
		if ($i==$oldVal)
			scrivi($newVal);
		 else
			scrivi($i);
		scrivi("</option>\n");
	}
scrivi("\n</select>\n");
}

function popolaComboConEccezionePrescelta($LABEL,$sql3,$DFLT_SELECTED,$key0,$val0) {
# scrivi("SQL: $sql3<br>");
 scrivi(" <select name=\"$LABEL\">");
 scrivi("<option selected value=\"$key0\">$val0</option>\n");
 $resrecSet3 = mq($sql3);
 $i=0;

 while ($recSet3=mysql_fetch_array($resrecSet3))
	{
	scrivi("<option ");
	if (	$DFLT_SELECTED == $recSet3[0]
	    				|| 
		$DFLT_SELECTED == $recSet3[1]
		) // se � il mio ordine lo seleziono nella combobox con la parola SELECTED!
		scrivi("selected");


	scrivi(" value=\"".$recSet3[0]."\">".$recSet3[1]);

//	if (isdevelop()) echo rosso("qui non ci gggiurerei: dacci un occhio");
	if (mysql_num_fields($resrecSet3) > 2)
		scrivi(" (".$recSet3[2].")"); // se esiste, bene, se no amen!		
	scrivi("</option>\n");
	}
scrivi("\n</select>\n");
}



/* trasforma 11 in XI */

function getRomano($n)
{
if ($n>300) return "ARGH! $n!!!";
if ($n>=100)

	return "C".getRomano($n-100);
if ($n >= 90) return "XC".getRomano($n-90);
if ($n>=50) return "L".getRomano($n-50);
if ($n >= 40) return "XL".getRomano($n-40);

if ($n<=9)
	{
	 switch ($n)
		{case 1: return "I";
		 case 2: return "II";
		 case 3: return "III";
		 case 4: return "IV";
		 case 5: return "V";
		 case 6: return "VI";
		 case 7: return "VII";
		 case 8: return "VIII";
		 case 9: return "IX";
		 default: return "";
		}
	}
return "X".getRomano($n-10);
}



function table(){
obsoleta("la funz table() border3 � inutile x me");
	scrivi("<table border=3>\n");

}	
	

function scriviReport_GoliardOrdine($recSet) //($recSet,$n)
{
 global $ISPAL;
// vengono usati dati (in RS) su goliardi e ordini...
 $foto="";
 $strFoto="";
 $NomeGolDoppio="";
	{
	if ($ISPAL)
		{
		 scrivi("<td>");
		 formquery("canc gol","delete  from goliardi where ID_GOL=".$recSet["ID_GOL"]);
		 scrivi("</td>");
		}
	 $NomeGolDoppio=$recSet["titolo"]." ".($recSet["Nomegoliardico"])." ".($recSet["Nomenobiliare"]);
	 scrivi("  <td><b class='goliarda'>".$NomeGolDoppio."</b><br>\n");

	 scrivi("(".($recSet["Nome"])." ".($recSet["Cognome"]).")</td>\n  <td>");
	///////////////////////////
	// FOTO personale
	 $foto=($recSet["foto"]);
	 scrivi("<a href=\"pag_goliarda.php?idgol=".$recSet["ID_GOL"]."\">");
	 scrivi("<center>" . getTagFotoPersonaGestisceNullFast($foto,50)."</td>\n  </center>");
	 scrivi("</a>\n  <td>");
	///////////////////////////
	// FOTO dell'ordine
	 $thumb = $recSet["m_fileImmagineTn"];
		scrivi("<a href=\"modifica_ordine.php?idord=".$recSet["ID_ORD"]."\">");
	scrivi(getTagFotoOrdineTnGestisceNull($thumb));


		scrivi("</a>");
	///////////////////////////

	// FOTO dell'utente possessore dell'ordine
	tdtd();

$result=mysql_query("select m_sNome  from loginz where id_login=".$recSet["id_login"]);
#print "DEBUG: $result";
if ($result) {
while ($rsu = mysql_fetch_row($result)) {
	 $nomeutentepossessore = $rsu[0];
	 scrivi("  <center>\n" . 
		getTagFotoPersonaGestisceNullFast($nomeutentepossessore.".jpg",45)
		."\n<br>(". $nomeutentepossessore .")  </center>"); 
	}
	scrivi("</td>\n</tr>\n"); 
} #else { scrivi(rosso("Nessun utente disponibile")) ; 

	}
}








//function visualizzaReport_PollCorpo($idpoll,$veloce)
//	{ scrivib("visualizzaReport_PollCorpo($idpoll,$veloce): se l'hai gi� fatto TU (venerdi') bene, se no lo faccio io domani 5-1. ciao!"); }




function flashTesto($titolo,$w,$h)
{
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0" width="<?php  echo $w?>" height="<?php  echo $h?>">

      <param name=movie value="<?php  echo $titolo?>.swf">


      <param name=quality value=high>
      <param name="BASE" value=".">

      <param name="BGCOLOR" value="">
      <param name="SCALE" value="exactfit">
      <embed src="<?php  echo $titolo?>.swf" base="."  quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" scale="exactfit" width="<?php  echo $w?>" height="<?php  echo $h?>" bgcolor="">
      </embed>
    </object>
<?php 

}



function scriviTabellaInscatolataBellaBeginVariante($titolo="undefined",$variante="undefined") { 
global $SKIN,$NOMESKIN; 
openTable();
?>
	<b><?php  echo $titolo?></b><br>
<?php 
}



function getUtente()
{
$nick=Session("nickname");
 if ($nick=="undefined" || $nick=="")

	return "anonimo";

else
	return $nick;
}


function getUtentiRecenti()
{
global $GETUTENTE;
$online=getApplication("UTENTI_ORA");
if ($online=="")
	return "0";

	// se str vale "nome1$nome2$nome3" : persone = quantidollari+1

$quantidollari =  substr_count('$',$online);
return $quantidollari+1;
}


function scriviLogUtentiConOra()

{
global $GETUTENTE,$ISPAL;
$timeout = 3600; // mexx'ora, in secondi


$nickname=$GETUTENTE;
$d = date("H:i");
$t = time();

$online=getApplication("UTENTI_ORA");
//			if ($ISPAL)		echo rosso("online valeva $online... (t=$t)<br/>");
$stringa_utente = explode("\$",$online);
// inverto il vettore:
$stringa_utente = array_reverse($stringa_utente);
$cisono = FALSE;
//visualizzaarray($stringa_utente);
for ($i=0;$i<sizeof($stringa_utente);$i++) 
{
  $aux = explode("@",$stringa_utente[$i]);
  //visualizzaarray($aux);
  if ($aux[0]==$nickname) 
     	$cisono = TRUE;
  // else  // � goiustpo che visualizzi pure me!!!
  if (isset($aux[1]))
	{		// aggiorno data
//	echo rosso("trovato me stesso, aggiorno data che vale ".$aux[1]."...<br>");
    	$delta = $t - intval($aux[1]);
	img("user.jpg");
    	scrivi("<b>".ucwords($aux[0])."</b>, da ".intval($delta/60)."'<br>\n");
    	if ($delta>$timeout) 
		$stringa_utente[$i] = ""; // aumentato delta t da 60 a 600' (un minuto a 10 minuti...)
  	}
}
if (! $cisono)

	{//echo rosso("non ci sei");
	}//  stringa_utente[stringa_utente.length] = nickname . "@" . t;
$online = "";
for ($i=0;$i<sizeof($stringa_utente);$i++)
  if ($stringa_utente[$i] != "") 
	{
    	if ($online != "") 	$online .= "$";    //appende un dollaro dopo ogni riga ma non alla prima...

	$online .= $stringa_utente[$i];  
	}
//echo rosso("online vale ora $online...<br/>");

setApplication("UTENTI_ORA",$online);
}






//function scriviLogUtentiConOra()

//	{ echo "utenti con ora: TBDS venerdi'<br/>"; }

function tabled()
{

	global $DEBUG;
	scrivi("<table border=".($DEBUG ? 3 : 0).">\n");
}	




function getFotoUtenteDimensionata($utente,$dim)


{
	global $paz_foto,$paz_foto_persone;

	$foto="$utente.jpg";

//echo "getFoto2($paz_foto_persone+$foto,$foto,$dim,$paz_foto-serie/tiposerio.jpg-,$dim).";




	return "\n".

		"<a href='utente.php?nomeutente=$utente'>".
		getFoto2($paz_foto_persone.$foto,$foto,$dim,$paz_foto."serie/tiposerio.jpg",$dim).


		"</a>\n";



}


function freccizzaFrase($frase)

{
	 tabled();
	 scrivi("<tr><td>");
	 img("next.gif");
	 scrivi("</td><td>");
	 scrivi($frase);

	 scrivi("</td></tr>");
	 tableEnd();
}



function getHHMM()
	{return date("H:i");}

/*
	dice dimensione 'friendly' di un file, arriva ai petabyte!!!!

*/

function fsize($size) {

       $a = array("B", "KB", "MB", "GB", "TB", "PB");


       $pos = 0;
       while ($size >= 1024) {
             $size /= 1024;
               $pos++;
       }
     return round($size,2)." ".$a[$pos];
}






/*
ISTRUTTIVO:
foreach (g l o b("*.txt") as $filename) {
   echo "$filename size " . filesize($filename) . "\n";

*/

function globbb($x)
{
echo "[sto globbando $x...]";
return glob($x);
}



function popolaComboFilePattern($ID,$paz,$filepattern,$DFLT_SELECTED="pippo")
{
scrivi("\n<select name='$ID'>\n");
$arrPaz=getArrayDiFileFromDir($paz);
/*
$dir = dir($paz);
while ($file = $dir->read()) 
   if (globbb($paz.$filepattern))	// match di tipo file (*.*, ...)
	if ($file!= "." && $file!= "..")
	{
	 scrivi("  <option ");
	 if ($file == $DFLT_SELECTED) scrivi("selected");
	 scrivi(" value='$file'>$file</option>\n");
	}
*/
for ($i=0;$i<sizeof($arrPaz);$i++)
	{$file=$arrPaz[$i];
	 echo("  <option ");
	 if ($file == $DFLT_SELECTED) 
			echo("selected");
	 echo(" value='$file'>$file</option>\n");
	}
scrivi("\n</select>\n");
}


function popolaComboFilePatternUsaGlob($ID,$paz,$filepattern,$DFLT_SELECTED="pippo")

{
scrivi("\n<select name='$ID'>\n");
		//if ($i==95) 	scrivi("selected");

$dir = dir($paz);
while ($file = $dir->read()) 
   if (globbb($paz.$filepattern))	// match di tipo file (*.*, ...)
	if ($file!= "." && $file!= "..")
	{
	 scrivi("  <option ");

	 if ($file == $DFLT_SELECTED) scrivi("selected");
	 scrivi(" value='$file'>$file</option>\n");

	}
scrivi("\n</select>\n");
}







function popolaComboNumerilliPercentuale($ID)


{

scrivi("\n<select name='$ID'>\n");


for ($i=0;$i<=100;$i+=5)
{
scrivi("  <option ");
if ($i==95)

	scrivi("selected");
scrivi(" value='$i'>$i%</option>\n");
if ($i==65)
	scrivi("<option value='69'>69%</option>\n");
}
scrivi("\n</select>\n");
}





function popolaComboGoliardi($ID,$stringaOpzioni="",$iddflt="")
{
 global $GETUTENTE;

 $sql = "select g.id_gol,g.Nomegoliardico,o.nome_veloce from goliardi g,ordini o WHERE o.id_ord=g.id_ordine ";
 $sql.= " ORDER BY g.Nomegoliardico";

$idGolDflt= ($iddflt=="" ? 0 : $iddflt );


//	if ($recSet3[0] == $idGolDflt )
//		echo " SELECTED ";


if ($stringaOpzioni != "gestiscenull") // no opzioni
	popolaComboBySqlDoppia_Key_Valore($ID,$sql,$idGolDflt);
else
{	// copio il codice di popolacombokeydoppia e lo adatto al goliarda NESSUNO.
 $LABEL = $ID;

 $sql3=$sql;
 $DFLT_SELECTED = 0;
 scrivi("\n<select name='".$LABEL."'>\n");
 echo	"<option value=\"0\">GNISUNI</option>";
$result=mysql_query($sql3);
while ($recSet3 = mysql_fetch_row($result))
	{
	scrivi(" <option ");
	if ($recSet3[0] == $idGolDflt )
		echo " SELECTED ";
	scrivi(" value=\"".$recSet3[0]."\">".$recSet3[1]);
	scrivi("</option>\n");
	}
scrivi("</select>\n");
}
}



function getCoppiaTabella($sx,$dx)

{return ("<tr valign=\"top\">\n  <td><i>".$sx."</i></td>\n  <td>".$dx."</td>\n</tr>");
}





//function Application($arg) { echo "<small>App[$arg]</small>"; }


function rosso($msg)
{
	return "<font class='rosso'>$msg</font>";
}

function scriviSmall($s)
{scrivi("<small>".$s."</small>");

}
function whois($persona)

{
global $IMMAGINI;

return "<a href='utente.php?nomeutente=".$persona."' border='0'><img src='$IMMAGINI/whois.gif' height='12' align='Center'  border=\"0\"></a>";
}


function popolaComboGGMMYY($label)
{
popolaComboNumerilli($label."_GG",1,31,7,1);
popolaComboNumerilli($label."_MM",1,12,2,1);
popolaComboNumerilli($label."_AA",1902,1999,1962,1); // � a 4 cifre per�...
}


function phpdata($s)
	{//echo "pd[$s]";
	 if (empty($s)) 
		return strtotime("1970-01-01 12:34:56"); //strval($s)=="NULL
	return strtotime($s);
	}


function popolaComboNumerilli($ID,$low,$hi,$dflt,$step=1)
{
$dfltVal=intval($dflt);
echo("\n<select name='$ID'>\n");
if ($hi<$low)
	{scrivi(rossone("estremi errati scemo di un Ric!"));
	 bona();
	}
for($i=$low;$i<=$hi;$i+=$step)
{
scrivi("  <option ");

if (strval($i) == strval($dfltVal))

	echo(" selected ");
echo(" value=$i>$i</option>\n");
}

scrivi("\n</select>\n");
}


/**
nick.indexOf("@") != -1 ||
	nick.indexOf("$") != -1 ||
	nick.indexOf("'") != -1 ||
	nick[0] == " " || 			// se inizia o finisce x spazio l'errore non lo becchi manco morto
	nick.indexOf("&") != -1 ||
	nick.indexOf("\"") != -1 ||
	nick.indexOf("�") != -1 ||
	nick.indexOf("�") != -1 ||
	nick.indexOf("�") != -1 ||
	nick.indexOf("�") != -1 ||
	nick.indexOf("_") != -1 ||
	nick.indexOf("'") != -1 ||
	nick.indexOf("-") != -1 ||
	nick.indexOf(",") != -1 ||

	nick.indexOf("<") != -1 ||
	nick.indexOf(">") != -1 ||
deve contenere a-zA-Z0-9 e spazi e non iniziare x numeri/spazi o finire con spazi

*/




/*

	FUNZIONA PERFETTAMENTE MA VOGLIO IMPORRE CTRL SUI TIPI!!! quindi niente arg vuoto!

function toHumanDate($d="")
	{//echo rosso("mi hai dato la data [$d] e viene fuori ".date("Y-m-d",strtotime($d)));
	 //echo "mysql suggerisce(".date('r', $d).")";

	 
	 if ($d=="")


		$t=time();
	   else 
		$t = strtotime($d);

	// echo rosso("tipo di $d/$t=(".gettype($d).";".gettype($t).")");
	// $t = strtotime($d);

	 if ($t == -1) // errore
		return "?!?!-??-!?";
	 return date("d-m-Y",$t); 
	}
*/




function toHumanDate($d)
{
//echo rosso("l'arg di humandate � ($d), di tipo(".gettype($d).").");
if (gettype($d) != "integer") return rosso("[tohumandate: non mi hai dato un TIMESTAMP]");
return date("d-m-Y",$d); 
}


function toHumanDateGGMM($d)
{//echo rosso("$d darebbe come strtotime risultato [".strtotime($d)."]..");

//	 return date("d-m",strtotime($d)); 
if (gettype($d) != "integer") return rosso("[tohumandateGGMM: non mi hai dato un TIMESTAMP]");
 return date("d-m",($d)); 
}



function toHumanDateConMinuti($d)
	{return date("Y-m-d H:i",$d); }


function isValidNick($s)
{
#$match=ereg( "^[a-zA-Z.][ 0-9a-zA-Z.]*[0-9a-zA-Z.]$" , $s);
$match=ereg( "^[0-9a-zA-Z.][ 0-9a-zA-Z.]*[0-9a-zA-Z.]$" , $s);
if ($match)		 // rimane se finisce x spazio
	{// devo vedere non finisce x spazio!!!

	 //echo "fin qui ok ($match)...";
	// if (ereg(".* $",$s))
	//	 {echo "finisce x spazio..."; return FALSE;}

	return TRUE;


	}
echo "non compliant ($match)..";

	return FALSE;

}






function isValidMail($s)
{
if (! ereg(
	"^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$"		// copiata da libro, e ragionevole
	,$s))
	return FALSE;
return TRUE;
}

function rand1()



	{//$rnd=random(10000);
	 //srand(time());
	 //$fl=rand(1,10000000000);
	 //echo "rnd,fl: $rnd:$fl";
	 //return $fl;
	 return rand(1,10000000000);
//	 floor(random(1000000)); 
	}


function dammiData()
{


obsoleta(("Attento, la funzione dammiData() � obsoleta e sconsigliata: dillo al webmaster!!! Dovresti usare altro, tipo dammidatamysql()"));
return date("d/m/Y h.i.s",time()); // cos� piace a mysql
}



function formhiddenApici($label,$val="") {
	echo("\n<input type=hidden name=\"$label\" value=\"$val\">\n"); 
}



function dammidatamysql()
{
return date("Y-m-d H:i:s",time()); // cos� piace a mysql

}


function creaPassword()
{
$makepass="";
$syllables = ("braghe,sbaciucchi,fetente,matricola,fagiolo,boia,faus,bacco,vino,condom,hatu,gnocca,pene,xxx,palladio,goliardi"
	.",golia,cazzo,sigar,lord,sbatti,fitton,cornut,cena,merda,sfiga,figo,surge,oca,chicazzo,checazzo,quanta,mona,culo"
	.",tette,capezzoli,puppe,minchia,parma,bologna,genova,torino,turbo,padova,albar,barolo,cagnina,durex,carnoso,pippo,"
	."troia,magna,limone,kulo,fattincula,incula,chiava,fotte,budello,puzza,schifo,minus,scopa,tromba,rutto,stra,ultra,"
	."mega,minusquam,san,zio,catarro,pompino");
$syllable_array=explode(",",$syllables);

$quanti=sizeof($syllable_array);
for ($count=1; $count<=3; $count++)
	$makepass .= $syllable_array[rand1() % $quanti];
return $makepass;
}





function formScelta2($label,$chiave1,$chiave2,$scritta1,$scritta2,$n_selez_iniziale)
{
// compatibilit� all'indietro: se dai TRUE/true la trasformo in 1 e cos� via, x i boolean in mysql...
 if (strtolower($chiave1)=="true")
	{obsoleta("erore di otimmizazzione nella funzione formScelta2: chiave1 vale TRUE!"); $chiave1=1;}
 if (strtolower($chiave1)=="false")
	{echo "ERRORE NEL DB DI OTTIMIZZAZIONE, SEGNALALO A PAL!"; $chiave1=0;}

 if (strtolower($chiave2)=="true")
	{echo "ERRORE NEL DB DI OTTIMIZZAZIONE, SEGNALALO A PAL!"; $chiave2=1;}
 if (strtolower($chiave2)=="false")
	{echo "ERRORE NEL DB DI OTTIMIZZAZIONE, SEGNALALO A PAL!"; $chiave2=0;}
 
 scrivi("\n  <input type='radio' ");
 	if ($n_selez_iniziale==1)
		scrivi("checked"); // checka la checkbox

 scrivi(" name=\"".$label."\" value='".$chiave1."'>".$scritta1."\n");
 scrivi("\n  <input type='radio' ");

 	if ($n_selez_iniziale==2)

		scrivi("checked"); // checka la checkbox

 scrivi(" name=\"".$label."\" value='".$chiave2."'>".$scritta2."\n");
}

function getFoto2($paz,$alt,$h,$paz2,$h2)
{
if (Session("antiprof"))
	{$temp = "<img src='$paz2' alt='EQUAZ.$alt' align='Center' border='0' ";
	 if ($h2>0)


		$temp .= "height=$h2";
	 return $temp.">";
	}


 $temp = "<img src='$paz' alt='$alt' align='Center' border='0' ";
 if ($h>0)




	$temp.="height=$h";
return $temp.">";
}

function getOrdineGraficoById($id,$h) {
global $ISPAL;
//echo "getOrdineGraficoById($id,$h)";
$sql= "SELECT * FROM ordini WHERE id_ord=$id";
$res=mysql_query($sql);
$rs = mysql_fetch_array($res);
$seriuz = $rs["m_bSerio"];
if (! isset ($seriuz)) return "seriuz-not-set (sql vale $sql)";
$tmp = getOrdineConFotoStringByNameThumb($rs,$h);
if (! $seriuz)
	$tmp = " <i><b>:)</b></i>".$tmp;
if ($ISPAL) 
	$tmp = rosso($tmp);
return $tmp;
}



function getTagFotoOrdineTnGestisceNull($foto,$h=50)
{
global $FOTO_NONDISPONIBILE,$paz_foto_ordini_tn;

	$thumb=strval($foto);

	 if ($thumb=="null")






		$thumb=$FOTO_NONDISPONIBILE;




	 return getFotoNoBorder($paz_foto_ordini_tn.$thumb,($foto=="notfound.gif" ? "?!?" : $foto),$h);




}

function getFotoNoBorder($paz,$alt,$h)
{ if (Session("antiprof"))
	return "PUF";

$alt = "Alt: " . basename($alt);

$temp ="<img src='$paz' alt='$alt' align='Center'  border=\"0\" ";
if ($h>0)
	$temp .= "height=".$h;
return $temp.">";


}



function getOrdineConFotoStringByNameThumb($rsCitta,$h)
{
 if (! isset($rsCitta["Nome_veloce"])) return "getOrdineConFotoStringByNameThumb SCHIF";

	$nome  = $rsCitta["Nome_veloce"];
	$thumb = $rsCitta["m_fileImmagineTn"];

	 $tmp = "   <a href=\"modifica_ordine.php?idord=".$rsCitta["ID_ORD"]."\">";
	 $tmp .= getTagFotoOrdineTnGestisceNull($thumb,$h);
	 $tmp .= "</a>\n"; // e nome

return $tmp;
}




function getMessaggioPrecedente()
{
//	return stripslashes($_POST["QWERTY_MSG_PRECEDENTE"]);
 if (empty($_POST["QWERTY_MSG_PRECEDENTE"]))
	return "";


 else
	return strval($_POST["QWERTY_MSG_PRECEDENTE"]);
//	return ($QWERTY_MSG_PRECEDENTE);

}

function autoInserisci($tabella,$msg,$pagina) //"Messaggio buttato su con successo!","pag_messaggi.php")
{$ok=autoInserisciTabella($tabella);
if (! $ok)
	{scrivi(rossone("problemi durante l'inserimento. L'um spies di mondi :-("));
	 bona();
	}

}



function autoInserisciTabella($NOMETABELLA,$AUTOMSG="",$pag_in_cui_andare="")
{
	global $ISPAL,$DEBUG;

	$sqlForm="";
	$sqlForm = "INSERT INTO $NOMETABELLA ";
	$separatore="BOH";
	$cont=0;

	$CAMPI="";
	$VALORI="";
	$skippa=FALSE;
	scrivid("<table border=3>\n");

 	while(list($chiave,$valore)=each($_POST))

		{
		scrivid("<tr>");
		if ($cont==0)
				$separatore = "( ";
		 	else 
				$separatore = ", ";
		scrivid("<td>$chiave</td><td>$valore</td><td>");
		$TIPO=getTipo($chiave);
		scrivid($TIPO."</td><td>");
			// tipi veri e propri
		if ($TIPO=="data")

		 	if ($valore == "") //QWERTY se la data � nulla inserisci un valore nullo secondo me...
				{
		 		 scrivid("[NON MOVONEXT n� brekko!!!]</td></tr>");
				 $skippa=TRUE;
				}
		if (! $skippa)
			{
			 $valore=getNuovoValoreByTipo($valore,$TIPO);
	 		 if ($TIPO != "nascosto")
				 {//sqlForm += separatore + "[".$chiave."]=".$valore." " 
				  // ATTEBNZIONE ci van le quadre x parole doppie in asp, in php invece le backquotez...
   				  $CAMPI  .= $separatore . "`$chiave`";
				  $VALORI .= $separatore . $valore;
				  $cont++;
				 }
			}
		$skippa=FALSE;
		scrivid("</td></tr>");
		}


	$sqlForm .= $CAMPI . ") values $VALORI)";
	if ($ISPAL) echo("<br><br>La form SQL �: $sqlForm.<br/>");

		/////////////// adesso ho la query sql giusta!!!
	$erore=FALSE;
	mysql_query($sqlForm)
		or $erore=TRUE;
	
	if ($erore)
			{$e=mysql_error();
			if ($ISPAL)
				scrivi(rossone("PAL ONLY) errore a mandare la queri3 ($sqlForm): '$e'."));
			 else
				scrivi(rossone("errore DBstico: $e."));
			 $erore=TRUE;
			}

	if (! $erore)
		{if ($AUTOMSG=="")
			messaggioOkSql("autoinserimento","nihil dictu");
		  else
			scrivib(rosso("msg automatico: [$AUTOMSG]"));
		 scrivid("<br>PS IN MODALIt� debug NON ti ridirigo automaticamente, fallo a mano! ");
		 scrivid("QUERYSTRING VECCHIA che serve x la redirezione: <br> ".Form("hidden_mia_query_string"));
		}
	else
	 	{tornaindietro("errore query di inserimento. <br/>Riprova, sarai + fortunato (si dice co"
			."s�, ma io dubito). Prova senza apostrofi ;)"); 
		 bona();
		}
scrivii(rosso("righe affettate dalla queryy: ".mysql_affected_rows().".<br/>"));
return (! $erore);

}

function getTipo($key)
{
$s=strtolower($key);
$tmp="testo";

if (iniziaPer($s,"data") || iniziaPer($s,"m_data"))
	$tmp="data";


if (iniziaPer($s,"id")  || contiene($s,"_id") || contiene($s,"cardinalit") || iniziaPer($s,"m_n"))
	$tmp="numero";

if (iniziaPer($s,"privacy") || iniziaPer($s,"sovrano") || $s=="pubblico" || $s=="attiva"|| $s=="hc" || iniziaPer($s,"m_b"))
	$tmp="bool";


if ($s=="messaggio")
	$tmp="memo";

if (ereg("hidden",$s))
	$tmp="nascosto";

return $tmp;
}









function bigg($str)
{return "<big><big>$str</big></big>";}



function ridirigiBack()
{
if ((Form("hidden_tornaindietroapagina")) != "")
	ridirigi(Form("hidden_tornaindietroapagina"));
  else 
    if ((Form("hidden_tornaindietroAUTOMATICOFORM")) != "")
	ridirigi(Form("hidden_tornaindietroAUTOMATICOFORM"));
  else 
    scrivib("<br>errore in RIDIRIGIBACK: non so come farti tornare indietro... � un problema conc"
		."ettuale?<br>Se si', scrivimi dove ti compare sto problema... che cerco di correggerlo.<br>");
}

function messaggioOkSql($tipo,$msg)
{

global $GODNAME;



tabled(); trtd();
scrivi(getFotoUtenteDimensionata($GODNAME,100));

tdtd(); //?!?!?
scrivi(bigg("Ciuccio benei (come diceva Madonna),<br> la query di <i>$tipo</i> � andata a buon fine!!!"));

if ($msg != "nihil dictu")
	scrivi(big("<br/>Ti volevo dire: <i>$msg</i>"));



if ((Form("hidden_tornaindietroapagina")) != "")
	scrivi(bigg("<br><a href='".Form("hidden_tornaindietroapagina")."'>Torna mo' indietro</a> (manuale via hidden, soccia che figo che sono!)"));
else if ((Form("hidden_tornaindietroAUTOMATICOFORM")) != "")
	scrivi(bigg("<br><a href='".Form("hidden_tornaindietroAUTOMATICOFORM")."'>Torna mo' indietro</a>"));

else scrivib("<br>PS. non so come farti tornare indietro... � un problema concettuale?<br>Se si', scrivimi dove ti compare sto problema... che cerco di correggerlo.<br>");
trtdEnd();
tableEnd();
}

function iniziaPer($str,$iniz)
{
$pos= strstr($str,$iniz);
//echo "Mi chiedo se $str inizi per <b>$iniz</b>, il responso � <b>".$pos."=?=0</b>.. ".($pos == $str)."<br/>";
//if (($pos == $str)) 	echo "SI<br>";
return ($pos == $str);
}


function getNuovoValoreByTipo($valore,$TIPO)
{
	if ($TIPO=="data")


		{				 //scrivid(rosso("<br>valore: ".$valore));
						 //scrivid(rosso("<br>new Date(v): ".$new Date(valore)));
						 //scrivid(rosso("<br>new Date(str(v)): ".$new Date(String(valore))));
						 //valore=dammiDataByJavaDate(new Date(valore))

						 //scrivid(rosso("<br>DAmmiDataByJava: ".$valore));

			// Se la trasformo ho casini, allora non la trasformo!!! Una data del tipo
		 if ($valore=="")
			$valore="1-1-70";
		}

	if ($TIPO=="testo" || $TIPO=="memo")
		{if ($valore=="")
			$valore="null"; // venerdi' in pohp questa la toglierei, che dici? 
		 else
			$valore=encodeApostrofi($valore);
		} 			// trafsormo apostrofi semplici in doppi

	if ($TIPO=="numero" && $valore=="")
		$valore=-1;

	if ($TIPO=="bool" && $valore=="") // novit� del PHP: se dai TRUE via POST � 1, se dai 0 il POST � vuoto e testa false!!!
		$valore="0";

	if ($TIPO=="testo"  || $TIPO=="memo" || $TIPO=="numero")
		$valore = "'$valore'";


	if ($TIPO=="data" )



		{// se il valore � del tipo

		 scrivid(rosso("DATA VALEVA: ".$valore));


		 if (contiene($valore,"UTC"))

			{scrivi(rossone("errore poich� la data � incompatibile. questo NON dovrebbe succedere. quindi di' a Riccardo"


				." magari via mail che � successo. Grazie."));
			}
		 else{
			 //valore=scambiaGiornoMese(valore); NON VOGLIO USARLO!
			 //$valore = "#$valore#"; IN ASP ERA COSI!!!

			 $valore = "'$valore'";
			}
		 scrivid(rosso("E ORA DATA VALE: $valore<br>"));
		}

return $valore;

}




function tdtdtop()
{ echo "</td><td valign='top'>";}



function encodeApostrofi($testo)



{ 
// global $ISPAL; // venerdi' aiuto! xch� cazzo i magic quotes fa i capricci?!?!? dacci un'occhiata!


//if (isdevelop()) 	scrivi(rosso("ma non lo fa il php di raddoppiare gli apostrofi, tu lascia perdere grazie! TOLTO ENCODE!"));
return $testo;
// return  ereg_replace("'","''",$testo);
}


function errore2002($msg)
{

?>

<table><tr>
<td bgcolor=white>RIC DICE:</td>
<td><font class='erore' size=2><?php  echo $msg?></font></td>
</tr></table>
<?php 

}

function erore($msg) { echo getErrorMsg($msg); }
function getErrorMsg($msg) {
	return "<div class='erore'>$msg</div>";
}



function scrivid($s)
{global $DEBUG,$POST_DEBUG;
 if ($DEBUG) 
	$POST_DEBUG .= $s;
}

function formtextConCheckbox($Tlabel,$Tvalore_iniziale,$Clabel,$Cvalore_iniziale,$msg="BUG, segnala a Pal pliz dove mi hai trovato!!!")
{scrivi("<tr><td><div align='Right'>");
 formtext($Tlabel,$Tvalore_iniziale);
 scrivi("</div></td><td><center> ".$msg.": ");
 scrivi("\n<input type=\"radio\" ");
 if (strtoupper($Cvalore_iniziale)=="TRUE" || ($Cvalore_iniziale)==1)
	scrivi("checked"); // checka la checkbox
 scrivi(" name=\"".$Clabel."\" value='1'>ohi");
 scrivi("\n<input type='radio' ");
 if (strtoupper($Cvalore_iniziale)=="FALSE" || ($Cvalore_iniziale)==0)
	scrivi("checked"); // checka la checkbox
 scrivi(" name=\"".$Clabel."\" value=\"0\">nisba</center></td></tr>");
}



function formtextarea($label,$valore_iniziale="",$rig=5,$col=30) {
	if ($valore_iniziale=="null") 
		$valore_iniziale="";
	$valore_iniziale= trim($valore_iniziale);
	scrivi("\n".$label."<br>\n");
	scrivi("\n<textarea name='".$label."' rows=".$rig." cols=".$col." >" . $valore_iniziale . "</textarea>\n\n");
}




function formtext($label,$valore_iniziale=TRUE)
{

//inutile if ($valore_iniziale=="null") $valore_iniziale="";

scrivi($label.": \n<input type='text' name='".$label."'  value=\"".$valore_iniziale."\">\n");


}






function anonimo()
	{global $GETUTENTE,$ANONIMO;
// 	echo "anonimit�: ut-$GETUTENTE =?= an-$ANONIMO"; 


	return ($GETUTENTE == $ANONIMO);
	}

function htmlSinistra($s)
{return "<div align='Left'>$s</div>\n ";}

function isGuest($who="") {
if ($who != "") // uno in particolare, non uso le sessioni ma l'sql

	{$sql="select m_bGuest from loginz where m_sNome='$who'";
	 //echo "sql vale: '$sql'";
  	 $res=mysql_query($sql);

	 $row=mysql_fetch_row($res)
		or die("utente $who non trovato nel db!");
	 return $row[0];

	}

if (Session("livello") == "ospite")
	return 1;
return 0;
}



function isMsgPubblico($rs) { return $rs["pubblico"] ||  (! isGuest()); }

function linkautente($nome,$frase) { return "<a href=\"utente.php?nomeutente=".$nome."\">".$frase."</a>\n"; }

function formquery($titolo,$query) {
scrivi("<form method='post' valign='top' action='powerquerysql.php'>\n"); 
scrivi("<input type=hidden name='querysql' value=\"$query\">");
scrivi("<input type=hidden name='hidden_1' value='42'>\n");
scrivi("<input type='submit' value='$titolo'>\n</form>\n");
}



function tri($n) {
 if ($n<=2 || $n>=0)  // tabella a 2 colori
{
?>
 <tr class="tabhome<?php  echo $n?>" width="900">
<?php 
}
		else
{
?>
 <tr class="tabellacoloribluErore" width="900">
<?php 
}

}

function decodifica($str) { return unescape($str); }
function codifica($str) { return escape($str); }






function scrivii($x) {echo "<i>$x</i>";}



function formbottoneinvia($label,$dasolo=FALSE)
{
 global $ISPAL;
 echo("<input type='submit' value=\"".$label."\">\n");
 //if (!$dasolo && $ISPAL) echo("<input type='reset' value=\"reset\">\n");
}


function popolaComboGoliardiConUtente($ID)
{
$sql=	  "SELECT g.id_gol,g.nomegoliardico,l.m_snome from goliardi g,ordini o,loginz l "

	. " WHERE o.id_ord=g.id_ordine AND l.id_login=g.id_login"
	. " ORDER BY g.nomegoliardico";

popolaComboBySqlDoppia_Key_Valore($ID,$sql,1);
}




function autoCancellaTabella($NOMETABELLA,$NOME_ID_da_modificare,$pag_in_cui_andare="") {
  global $ISPAL,$DEBUG;

  $sql="DELETE FROM $NOMETABELLA WHERE `$NOME_ID_da_modificare`=".getHiddenId();


	// devo correggere la possibilit� che sia: DELETE ... FROM ... WHERE [45]=IDSTICAZZI... checko la numericit�...




  $ttemp = strval($NOME_ID_da_modificare);
  $iniz= $ttemp[0];
  if ($iniz >= '0' && $iniz <= '9') 
	{
	if ($ISPAL) echo rosso("nome id sbagliato: inverto automaticamente la bazza ;)");
//	$sql="DELETE FROM $NOMETABELLA WHERE `".getHiddenId()."`=".$NOME_ID_da_modificare;

	if (isdevelop()) 
		echo rosso("22.50 09/01/2004: ho messo gli apostrofi intorno all'id;: mysql dsembra gradire di pi�...");
	$sql="DELETE FROM $NOMETABELLA WHERE `".getHiddenId()."`='$NOME_ID_da_modificare'";
	}
 else 
	if ($ISPAL) 
		echo rosso("nome id corretto: '".$NOME_ID_da_modificare."' inizia per il non-numerico '".$iniz."'<br/>");


 

if ($ISPAL ) {
	scrivi(rosso("NOME_ID_da_modificare: <b>".$NOME_ID_da_modificare."</b>."));
	invio();

	scrivi(rosso("getHiddenId: <b>".getHiddenId()."</b>."));
	invio();

	scrivi(rosso("pagina in cui andare: <b>".$pag_in_cui_andare."</b>."));
	invio();
	scrivi(rosso("query DELETE : <b>".$sql."</b><br/>"));
	}



log2("CANCTABELLA: ".$sql);

$erore=FALSE;
$res=mysql_query($sql);

	if (! $erore)
		{messaggioOkSql("autoDELETE","nihil dictu");
		 log2("[BOH] autocancellatabella (tabella: '$NOMETABELLA', '$NOME_ID_da_modificare'='".getHiddenId()."')","queryz.log.php");
		 if ($DEBUG)
			{ scrivi("<br>PS IN MODALIt� debug NON ti ridirigo automaticamente, fallo a mano! QUERYSTRING VECCHIA che serve x la redirezione");
			  scrivi(": <br>".Form("hidden_mia_query_string"));
			}
  	        else {

			  if (! empty($pag_in_cui_andare))
				scrivib("<a href='$pag_in_cui_andare'>".rosso("<br><big>torna a $pag_in_cui_andare</big></a><br>"));
				
			 }


		}
	else
		 bona();

}

function getHiddenId()
{
$myhiddenid=Form("my_hidden_id");

if (empty($myhiddenid)) //=="undefined" || myhiddenid=="null")
		$myhiddenid="'".Form("my_hidden_id_testuale")."'"; 	
				// valuto se � testuale o numeri co l'id... a seconda
return $myhiddenid;	
									// della stringa che mi hai dato in form..
}



function formhidden($label,$val)
{
global $valore_iniziale;
if ($valore_iniziale=="null")

	$valore_iniziale="";
scrivi("\n<input type=hidden name='".$label."' value='".$val."'>\n");
}



function tdtd() {echo "</td><td valign='top'>";}


function trtd() {echo "<tr><td valign='top'>";}
function trtdEnd() {echo("</td></tr>");}




function getRecordSetConVirgoleParentesi($res)
{
$str="";
$i=0;
while ($rs=mysql_fetch_row($res))
	{$str .= $rs[0]." <i>(".$rs[1].")</i>, ";
	 $i++;
	}
if ($i==0) return "votooo aoh!";
//str=str.substring(0,str.length-2); // soazio e virgola tolte...


return substr($str,0,strlen($str)-2);
}

#function spaziaParoleLunghe($s) { return $s; }

function getPreamboloMsg($str="ERRORE: MANCA LA STRINGA!!!",$id=99999) {
	$PREAMBLENGTH=100;
	#$ret= substr(strip_tags($str),0,$PREAMBLENGTH)." <i>(<a href='pag_messaggi.php?ID_MSG=$id'>leggi tutto</a>)</i>";
	# baco corretto
	$ret= substr(strip_tags($str),0,$PREAMBLENGTH);
	$ret= wordwrap($ret,32," \n",1);
	$ret .= " <i>(<a href='pag_messaggi.php?ID_MSG=$id'>leggi tutto</a>)</i>" ;
	return $ret;
}



/**
	ancheBody: dice se c'� anche il corpo del messaggio o solo il titolo. Se solo titolo, metto anche i primi N caratteri per incuriosire il lettore...

*/

function pulsanteXmsg($rs) {
	formBegin("pag_messaggi.php"); formhidden("my_hidden_id",$rs["id_msg"]);
         formhidden("ID_MSG",$rs["id_msg"]); formhidden("OPERAZIONE","CANCELLA"); 
	 formbottoneinvia("DEL"); 
	formEnd(); 
	tdtd();
}


	// � solo un TR
function scriviReport_MessaggioConBody($rs,$ii=0) {
	global $ISSERIO,$DEBUG;
	$ut=$rs["m_sNome"];
	$puoCancellare=isAdminVip();
	$strData= strval($rs["data_creazione"]);
        if ($strData=="" || $strData=="null" ) 
		$strData="???";
		// TR 
 	echo "\n  <tr class='iniziothread'>\n"; 
			// FOTO A SX
	echo "   <td valign=top class='iniziothread1'>\n";
		// TD1 (table con 3 tr: titolo, dati e corpo)
	  scrivi("\n   <table class='titoloecorpo' border=0 width='100%'><tr><td class=titolo height='100%'>\n"); // era qui la link foto utente vecchia
			// TITOLO IN ALTO
	    scrivi("     <a href='pag_messaggi.php?ID_MSG=".$rs["id_msg"]."'><b>".$rs["titolo"]."</b>\n");
            if ($rs["id_figliodi_msg"] != 0) echo ("</a> <a href='pag_messaggi.php?ID_MSG=".$rs["id_figliodi_msg"]."' alt=\"Leggi intero thread\"> <font size=xx-small><i>(tutto il thread)</i></font></a>\n");
	  tttt();
		# riga 2: autore e data
	    if (isset($rs["quantifigli"]))
                if (strval($rs["quantifigli"]) !="0") $strData .= "; <b>".$rs["quantifigli"]."</b> reply";
	    echo "<div align='right' width='100%'>(<a href='utente.php?nomeutente=$ut' class='utente'> ".$rs["m_sNome"]."</a>, $strData)</div>";
	  tttt();
		# riga 3: messaggio
	  echo "<div class='fullmsg_body'>";
            scriviSmall(ripulisciMessaggio($rs["messaggio"],TRUE));
	  echo "</div>";
	echo "</td></tr>\n   </table>\n";
	echo "   </td>\n";
	echo "\n   <td width='80' valign='top'>\n";
		#	TD2 (foto)
	echo "    <img src='immagini/persone/$ut.jpg' height='80' align=left />";
	   if ($puoCancellare) { pulsanteXmsg($rs); }
	scrivi("  </td>\n </tr>\n"); 
}


function scriviReport_MessaggioSenzaBody($rs,$linkami,$ii=0) {

}

function scriviReport_Messaggio($rs,$linkami,$ancheBody,$ii=0) {
 if ($ancheBody) 
	return scriviReport_MessaggioConBody($rs);

 global $ISSERIO,$DEBUG; 
 $linkami = isMsgPubblico($rs); // lo cambio automaticamente...  
 $puoCancellare=isAdminVip(); //(ISPAL); 
	scrivi("<table width='100%'>");
	if (! $ancheBody)
		tri($ii); 
	else 
		scrivi("<tr>");
	scrivi("<td>"); 
#if ($puoCancellare) {
if (0) {
	formBegin("pag_messaggi.php"); 
	formhidden("my_hidden_id",$rs["id_msg"]);
	formhidden("ID_MSG",$rs["id_msg"]);
	formhidden("OPERAZIONE","CANCELLA");
	formbottoneinvia("XX");
	formEnd();
	tdtd(); 
} 
	if ($ancheBody) { 
		scrivi("<table class='reportmessaggio'><tr><td valign=top>"); // era qui la link foto utente vecchia
  		scrivi("</td><td><table border=0><tr><td>");
	} 
	if ($linkami)
		scrivi("<a href='pag_messaggi.php?ID_MSG=".$rs["id_msg"]."'>");
	if ($ancheBody) {	
		scrivi("<b>".$rs["titolo"]."</b>"); 
		if (! $linkami) scrivi(" <i>(privato)</i>"); 
		if ($linkami && $rs["id_figliodi_msg"] != 0)
			scrivi("</a> <a href='pag_messaggi.php?ID_MSG=".  $rs["id_figliodi_msg"]
				.  "' alt=\"Leggi Messaggio Padre, ovvero colui che ha originato il Thread (utile "
				. "quando becchi un msg isolato, x es col motore di ricerca)\">" 
				. getImg("up.gif")); 
	} 
	else scrivi(htmlSinistra($rs["titolo"]));
  	if ($linkami) scrivi("</a>"); 
  	if ($ancheBody) { scrivi("</td><td>");} 
	$strData= strval($rs["data_creazione"]);
	if ($strData=="" || $strData=="null" ) $strData="???";
		// N FIGLI
		if (! $ancheBody) // se no non serve  
			if (isset($rs["quantifigli"]))
				if (strval($rs["quantifigli"]) !="0") 
					$strData .= "; <b>".$rs["quantifigli"]."</b> reply"; // se son 0, non metto nulla
	if ($ancheBody) // quindi + grande
		 	scrivi(htmlDestra("(<i class='utente'>  ".$rs["m_sNome"]." </i>, $strData)"));
		 else
			scriviSmall(htmlDestra("(<i class='utente'> ".$rs["m_sNome"]."</i>, $strData)")); 
	if ($ancheBody) {  
		scrivi("</td></tr></table>"); 
 	  	scrivi("<center><table ><tr><td width='800'>"); 
	   	 if (! $ISSERIO) scrivi(getFotoUtenteDimensionataRight($rs["m_sNome"],60)); 
	  	if ($linkami) {
			echo "<div class='reportmsg_body'>";
			scriviSmall(ripulisciMessaggio($rs["messaggio"],TRUE));
			echo "</div>";
		}
	  	else
			scriviSmall(rosso("<i>mi spiace, non sei abilitato a vedere questo messaggio</i>")); 
	  	scrivi("</td></tr></table></center>"); 
	  	scrivi("</td></tr></table>");
	} else {
		echo "<div class='reportmsg_body'>";
		scrivi(getPreamboloMsg($rs["messaggio"],$rs["id_msg"]));
		echo "</div>";
	}
	scrivi("</td></tr></table>"); 
}

function getVotiTotaliFromSondaggio($id)
{
 $res=mq("select count(*) from polls_voti pv, polls_domande pd where pv.id_doman"
		."da=pd.id_domanda and id_poll=$id");
 $rs=mysql_fetch_row($res);
 return $rs[0];
}

function getVotiTotaliFromDomanda($id)
{
 $res=mq("select count(*) from polls_voti pv where id_domanda=$id");
 $rs=mysql_fetch_row($res);
 return $rs[0];
}

function getDomandeTotaliFromSondaggio($id)
{
 $res=mq("select count(*) from polls_domande  where id_poll=$id");
 $rs=mysql_fetch_row($res);
 return $rs[0];
}


#$TOGLIFASTIDIOSIAPOSTROFIDOPPI=1;

function ripulisciMessaggio($msggio,$trasformaInvio=TRUE,$mantieniiSeguentiTag="") {
	global $IMMAGINI,$TOGLIFASTIDIOSIAPOSTROFIDOPPI;
	$mantieniiSeguentiTag="$mantieniiSeguentiTag<PRE><i><u><b><br>";
	$tmp=strval($msggio);
	#if ($TOGLIFASTIDIOSIAPOSTROFIDOPPI)  $tmp=stripslashes($tmp); 
	if ($mantieniiSeguentiTag != "")
		$tmp=strip_tags($tmp,$mantieniiSeguentiTag);
	else {	// "" ha semantica diversa: � il dflt e intende trasforma i '<','>' in tag html equivalenti...
				// e sticazzi no? Ric del passato, che cazzo volev dire? Ho capito solo semantica.
	 	$tmp= replace($tmp,"<","&lt;");
	 	$tmp= replace($tmp,">","&gt;");
	}
		#	tolto il 28 11 05
if ($trasformaInvio)
	$tmp= replace($tmp,"\n","<br/>");
#$tmp= replace($tmp,"cazzo","<b>astrokazzo di Gundam</b>");
$tmp= replace($tmp,"\(K\)","<img src='immagini/bacio.gif' height='20' />");
#$tmp= replace($tmp,"\<3","<img src='immagini/cuore.gif' height='20' />");
$tmp= replace($tmp,"zzZZzz","<img src='immagini/icone/sonno.gif' height='20' />");
$tmp= replace($tmp,"_mipiace_","<img src='immagini/icone/mipiace.png' height='20' />");
$tmp= replace($tmp,"_ditone_","<img src='immagini/icone/ditone.png' height='50' />");
$tmp= replace($tmp,"_sticazzi_","<img src='immagini/icone/sticazzi.jpg' height='20' />");
$tmp= replace($tmp,"cuore","<i>Cuore</i>");
#$tmp= preg_replace('{{(\w+);(\w+)}}','<b>$1: <a href="utente.php?nomeutente=$2">$2</a></b>',$tmp);
$tmp= preg_replace('{{user;(\w+)}}','<b><a href="utente.php?nomeutente=$1">$1</a></b>',$tmp);
$tmp= preg_replace('{{goliarda;(\w+)}}','<b><a href="utente.php?nomeutente=$1">$1</a></b>',$tmp);
$tmp= preg_replace('{{faq;(\w+)}}','<b><a href="faq.php?id=$1" >FAQ-$1</a></b>',$tmp);
$tmp= preg_replace('{{ordine;(\w+)}}','<b><a href="modifica_ordine.php?idord=$1">Ordine-$1</a></b>',$tmp);
$tmp= preg_replace('{{url;(http[^\}]+)}}','<a href="$1" target="_new"><img src="immagini/url.jpg" align="bottom" ></a>',$tmp);
$tmp= replace($tmp,":\)","<img src='$IMMAGINI/1.gif'>");
$tmp= replace($tmp,":\(","<img src='$IMMAGINI/2.gif'>");
$tmp= replace($tmp,";\)","<img src='$IMMAGINI/3.gif'>");

return $tmp;
}




function htmlDestra($s)
{return "<div align=\"Right\">$s</div>\n ";}

/*
function provajava()
{
$system = new Java('java.lang.System');

  // demonstrate property access
  echo 'Java version=' . $system->getProperty('java.version') . '<br />';
  echo 'Java vendor=' . $system->getProperty('java.vendor') . '<br />';
  echo 'OS=' . $system->getProperty('os.name') . ' ' .
             $system->getProperty('os.version') . ' on ' .
             $system->getProperty('os.arch') . ' <br />';

  // java.util.Date example

  $formatter = new Java('java.text.SimpleDateFormat',
                       "EEEE, MMMM dd, yyyy 'at' h:mm:ss a zzzz");
  echo $formatter->format(new Java('java.util.Date'));
}
*/





function mostraHintz()
{
fopen("");
}


							// FOTO, FUNZIONI SULE FOTO SMANGIUCCHIATE AI VARI PAGINOZZI SUOI


	// dice quante foto ci stanno in una directory e se � fotosa o meno
function quantefoto($dir,$NONFOTO=FALSE)
{ $num=0;
  if (! is_dir($dir))
	{
	 echo "EROORE (non va bene <b>".$dir."</b>)";
	 return -1 ;	
	}

  while($f1 = readdir($dir))
//	if($file != '..' && $file !='.' && $file !='') 
	if($file !='.' && $file !='') 
	    {	$ext=strtoupper($file.substr($file.lastIndexOf(".")+1,3));
	      $isfoto=(isFotoExt($ext));
		if ($isfoto && ! $NONFOTO)
			$num++;	
		if (!$isfoto && $NONFOTO)
			$num++;	
	    }
return $num;
}


function esisteSuoThumbnail($percorso, $nome)
	{ return is_file($percorso."/tn_".$nome);	}



function mettiAltroTnSeTroppoGrande($percorso,$nome,$dimmax,$directoryiniziale)
{
global $THUMB_NONDISPONIBILE;

if (isdevelop()) 
	echo rosso ("in futuro metti a posto: mettiAltroTnSeTroppoGrande()");
//return;

// cerco il file TN_XXX
$f = is_file($percorso."/tn_".$nome);
if (!$f)
	{// se non lo trovo cerco il file xxx....
	 $f = is_file($percorso."/".$nome);

	 if (!$f)
		{if (isdevelop())
			echo (rosso("_erore x (".$percorso."/".$nome."): ".$e.description));
		 return;
		}
	}

if (filesize($f) > $dimmax)
	{ // dovrei ctrlare se esiste il tn
	return $paz_foto.$THUMB_NONDISPONIBILE;
	}

$pos=$percorso.indexOf("avvenimenti")+11;		
	// attenbzione, funziona solo se la directory da visualizzare contiene upload...
	// mi ritgali banalmente il sottoalbero che segue!!!!

return $directoryiniziale.substring($percorso,$pos)."/".$nome;
}

# 2006 lavoro su css...

function  linkaViola($lnk,$frase)
{
global $ISSERIO,$AUTOPAGINA;

$altezza = 30; // altezza in pixel
$tagFoto= "";
$lnk=strtolower($lnk);
if (! $ISSERIO)
        $tagFoto= getImg("icone/$frase.gif",$altezza)."<br>";

if (eregi("$lnk","$AUTOPAGINA"))
        return "<td align=\"center\" class=\"BGbianco\">$tagFoto<a href='$lnk'><font face=\"verdana,arial,ge
neva".
                        ",sans-serif\" size=\"1\" class=\"FGviola\"><b>$frase</b></font></a></td>";
else {return "<td align=\"center\" class=\"BGviola\">$tagFoto<a href='$lnk'><font face=\"verdana,arial,genev
a,".
                       "sans-serif\" size=\"1\" class=\"FGbianco\">$frase</font></a></td>";
        }
}
function getMenuTopColumnBegin($tit,$lnk="NISBA",$img="") { 
	if ($img == "") { $img=$tit.".gif"; }
	return "<td>"
		."\n\t<li>"
		."<strong>"  .(($lnk == "NISBA") ? $tit : "<a href='$lnk'>$tit</a>") ."</strong>\n\t<UL>\n"; 
}
function getMenuTopColumnEnd() { return "\t</UL>\n\t</li>\n"."</td>\n"; }
function getMenuTopItem($tit,$lnk,$img="",$target="") { 
	if ($img == "") { $img=$tit.".gif"; }
	return "\t\t<li><table width='100%'><tr><td class=sx><img src='immagini/icone/$img' height='20' width='20'></td><td class=dx><a href='$lnk' target='$target'>$tit</a></td></tr></table></li>\n"; 
}

function getMenuTopColumnBeginSpartano($tit,$lnk="NISBA",$img="") { 
	if ($img == "") { $img=$tit.".gif"; }
	$l= (($lnk == "NISBA") ? $tit : "<a href='$lnk'>$tit</a>") ;
	return "<td valign=top><table border=1><tr><td><strong>$l</strong></td></tr>"; 
}
function getMenuTopColumnEndSpartano() { return "</table></td>"; }
function getMenuTopItemSpartano($tit,$lnk,$img="",$target="") {
	if ($img == "") { $img=$tit.".gif"; } 
	#return "<tr><td>$tit - $lnk</td></tr>\n";
	return "<tr><td>"
		."<table width='100%'><tr><td class=sx><img src='immagini/icone/$img' height='20' width='20'></td><td class=dx><a href='$lnk' target='$target'>$tit</a></td></tr></table>"
		."</td></tr>\n";

}
function getMenuTopItem2($tit,$lnk,$img="",$target="") {
	global $globMenuItemz;
	if ($img == "") { $img=$tit.".gif"; }
	$globMenuItemz .= "<td><a href='$lnk' target='$target'>$tit</a></td>";
	return getMenuTopItem($tit,$lnk,$img,$target);
}
		

function getMenuVecchiaManiera() {
	global $globMenuItemz;
	$ret="";
	echo "<table border=1><tr>$globMenuItemz</tr></table>";

}


function getMenuTop($classe="") { 
    $ret="";
    $DEV=isdevelop();

    if ($classe == "") { $classe="titoloaltostretto"; }
    global $ISPAL;
	# INIZIO:
	$ret .= '<table class="'.$classe.'" ><tr><td><ul id="nav">';
		$ret.="<table class='mrwolf'><tr>";
	# menu1: GOLIARDIA
	$ret .= getMenuTopColumnBegin("home","index.php");	
	$ret .= getMenuTopColumnEnd("");	
	$ret .= getMenuTopColumnBegin("goliardia");	
	  $ret .= getMenuTopItem("agenda goliardi"	,"agendamail.php" , "agenda.gif");
	  $DEV && $ret .= getMenuTopItem("almanacco"		,"almanacco.php");
	  $ret .= getMenuTopItem2("canti"		,"canzoni.php");
	  $ret .= getMenuTopItem2("citta"		,"citta.php");
	  $ret .= getMenuTopItem2("contenuti"		,"contenuti.php");
	  $ret .= getMenuTopItem2("eventi"		,"calendario.php");
	  $ret .= getMenuTopItem2("gestioni"		,"pag_utente.php");
	  #$ret .= getMenuTopItem("altri siti goliardici"	,"linkz.php?tipo=ordini", "link.gif");
	  $ret .= getMenuTopItem2("ordini"		,"ordini.php");
	$ret .= getMenuTopColumnEnd();
	$ret .= getMenuTopColumnBegin("altro");
	  $ret .= getMenuTopItem2("anti prof"	,"antiprof.php");
	  $ret .= getMenuTopItem2("mandaFoto"	,"mandafoto.php");
	  $ret .= getMenuTopItem2("tuoi dati"	,"utente.php", "utente.gif");
	$ret .= getMenuTopColumnEnd();
	$ret .= getMenuTopColumnBegin("community");
	  $ret .= getMenuTopItem("agenda utenti"	,"agendamail.php" , "agenda.gif");
	  $ret .= getMenuTopItem("cerca"		,"cerca.php" );
	  $ret .= getMenuTopItem2("chat"			,"chat2.php" , "","_new");
	  $ret .= getMenuTopItem2("contenuti"		,"contenuti.php" );
	  $ret .= getMenuTopItem("download"		,"download.php" );
	  $ret .= getMenuTopItem2("FAQ"		 	,"faq.php" );
	  $ret .= getMenuTopItem2("Forum"		,"pag_tutti_messaggi.php", "messaggi.gif");
	  #$ret .= getMenuTopItem("forum: Scrivi"	,"pag_messaggi.php", "messaggi.gif");
	  $ret .= getMenuTopItem2("gioco delle coppie"	,"giocodellecoppie.php", "coppie.gif");
	  $ret .= getMenuTopItem2("gms"			,"gms.php", "GMS.gif");
	  $ret .= getMenuTopItem2("Links"		,"linkz.php?tipo=ordini&opz=selezioneinversa", "Linkz.gif");
	  #$ret .= getMenuTopItem("links vari"		,"linkz.php?tipo=ordini&opz=selezioneinversa", "Linkz.gif");
	  $ret .= getMenuTopItem2("sondaggi"		,"votazioni.php");
	  $ret .= getMenuTopItem2("statistiche"		,"statistiche.php", "stats.gif");
	$ret .= getMenuTopColumnEnd();
	$ret .= getMenuTopColumnBegin("aiuto");
	  $ret .= getMenuTopItem2("AIUTO",	"help.php", "help.gif");
	  $ret .= getMenuTopItem("bugz"		,"bugz.php", "develop.gif");
	  $ret .= getMenuTopItem("supporto",		"support.php", "support.gif");
	$ret .= getMenuTopColumnEnd();
	if (isAdmin()) {
	  $ret .= getMenuTopColumnBegin("Amministrazione", "", "admin.gif");
	    $ret .= getMenuTopItem2("pannello"		,"pannello.php");
	    if ($ISPAL) 
		$ret .= getMenuTopItem2("SQL"		,"powerquerysql.php", "sql.gif");
	  $ret .= getMenuTopColumnEnd();
	} // pannello amministrazione
	# FINE: 
		$ret.="</tr></table>\n";
	$ret .= '</ul></td></tr></table>';
    $ret .= getMenuVecchiaManiera();
return $ret;
}

function openTable()   { echo "<table class='tabella1ext'><tr><td><table class='tabella1int'><tr><td>"; }
function openTable2Futura()  { echo "<table class='tabella2ext'><tr><td><table class='tabella2int'><tr><td>"; }
function closeTableFutura()  { echo "</td></tr></table></td></tr></table>"; }
function closeTable2Futura() { echo "</td></tr></table></td></tr></table>"; }

	// quelli del nuke template...
$bgcolor1 = "#ffffff";	# bianco
$bgcolor2 = "#9cbee6";  # azzurrino
$bgcolor3 = "#d3e2ea";  # grigino
$bgcolor4 = "#0E3259";  # nerone
$textcolor1 = "#000000";
$textcolor2 = "#000000";
function openTableVecchia() { global $bgcolor1, $bgcolor2; 
    echo ("<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\"><tr><td>\n");
    echo ("<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n"); 
} 
function closeTable() { echo ("</td></tr></table></td></tr></table>\n"); } 
function openTable2() { global $bgcolor1, $bgcolor2; 
    echo ("<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\" align=\"center\"><tr><td>\n");
    echo ("<table border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n"); 
} 
function closeTable2() { echo ("</td></tr></table></td></tr></table>\n"); }


function pubblicaBanner() {
   if (! Session("antiprof")) {
         #if ($ISSERIO)
                        #img("logoFooterIside.jpg",100);
                        img("logoiside06-mini.jpg",120);
         #       else
         #               flashTesto("$IMMAGINI/anibelli9_ver5",366,100);
        }
   else
        scrivi("<img src='".$paz_foto."serie/worldscientific.jpg' alt='eq. sbura' align='Center' >");
}

function production() {
		global $ENVIRONMENT ;
	$ENVIRONMENT == "production" ;
}

function development() {
		global $ENVIRONMENT ;
	$ENVIRONMENT == "development" ;
}

function db_importantlog_slow($appname, $log_string) {
	// vogloi mettere nero su bianco che questa operazione e LENTA e costosa quindi non 
	// voglio farne troppe. :)
	// 1. Login con IP per cattive azioni e timestamp cross-correlation.
	// 2. AdminVip operazioni di cambio DB cosi so chi fa cosa quando.. 
	$who = $_SESSION["_SESS_nickname"];
	$where = 'todo where';
	error_log("db_importantlog_slow $who@$where [$appname] \033[1;33m $log_string \033[0m (TODO(ricc): upload su DB da bon"); 

}

//function get_session_var_or_null();  TODO hai gia capito come fare DRY :P
function current_user() {
	if(isset($_SESSION['_SESS_nickname'])) {
		return $_SESSION['_SESS_nickname'];
	} else {
		return NULL;
	}
}
function current_user_id() {
	if(isset($_SESSION['_SESS_id_login'])) {
		return $_SESSION['_SESS_id_login'];
	} else {
		return NULL;
	}
}

// DRY siccome non spanna su sottomoduli :/
function get_paz_upload() {
	$PAZ_UPLOAD="uploads"; // va post slashato, sussunto in classes/manda_foto	$PAZ_UPLOAD
	return $PAZ_UPLOAD;
}

function flash_notice($action, $msg) {
	// https://stackoverflow.com/questions/31854717/rails-bootstrap-flash-notice-success-is-now-red-and-not-green
	?>
	<div class="alert alert-<?= $action ?> alert-dismissible" role="alert">
    	[<?= $action ?>] <?= $msg ?>
    </div>
	<?
	
}

function flash_notice_success($green_msg) {
	// https://stackoverflow.com/questions/31854717/rails-bootstrap-flash-notice-success-is-now-red-and-not-green
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
    	[flash_notice_success deprecated use flash_notice(:success, ..) instead] <?= $green_msg ?>
    </div>
	<?
	
}

?>
